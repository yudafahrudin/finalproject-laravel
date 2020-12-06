<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

use App\Absent;
use App\Schedule;

class AbsenteeismParentController extends Controller
{

    private function switchDayName($name)
    {
        switch ($name) {
            case 'Sun':
                return "minggu";
                break;

            case 'Mon':
                return "senin";
                break;

            case 'Tue':
                return "selasa";
                break;

            case 'Wed':
                return "rabu";
                break;

            case 'Thu':
                return "kamis";
                break;

            case 'Fri':
                return "jumat";
                break;

            case 'Sat':
                return "sabtu";
                break;

            default:
                return "Tidak di ketahui";
                break;
        }
    }

    public function submitAbsent(Request $request)
    {
        try {
            date_default_timezone_set('Asia/Jakarta');
            $user = auth()->user();
            $day = $this->switchDayName(date('D', $request->date));
            $date = date('Y-m-d', $request->date);

            $validator = Validator::make(
                $request->all(),
                [
                    'file'  => 'mimes:png,jpg,jpeg|max:2048'
                ]
            );

            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => $validator->errors()]);
            }

            $imagename = null;
            if ($request->file('foto')) {
                // Decode image
                $imagename = date('YmdHis-') . uniqid() . '.jpg';
                $path = '/user/absent/' . auth()->user()->id . '/' . $imagename;
                $imagesBatch = Image::make($request->file('foto'))->encode('jpg');

                // Save proccess
                Storage::disk('public')->put($path, $imagesBatch);
            }

            $userAbsentToday = [];
            $userScheduleToday = [];

            $userAbsentToday = Absent::where('date_absent', $date)
                ->where('user_id', '=', $user->id)
                ->get();

            $userScheduleToday = Schedule::where('day', $day)
                ->where('kelas_id', $user->kelas_id)
                ->get();

            if (count($userAbsentToday)) {
                if ($request->reasons == 'masuk') {
                    foreach ($userAbsentToday as $absent) {
                        $absent->delete();
                    }
                } else {
                    foreach ($userAbsentToday as $absent) {
                        $absent->reason = $request->reasons;
                        if ($request->description) {
                            $absent->description = $request->description;
                        }
                        if ($imagename) {
                            $absent->image = $imagename;
                        }
                        $absent->save();
                    }
                }
            } else {
                if ($request->reasons !== 'masuk') {
                    if (count($userScheduleToday)) {
                        foreach ($userScheduleToday as $schedule) {
                            Absent::create([
                                'schedule_id' => $schedule->id,
                                'user_id' => $user->id,
                                'reason' => $request->reasons,
                                'date_absent' => $date,
                                'image' => $imagename,
                                'description' => $request->description
                            ]);
                        }
                    } else {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Tidak ada jadwal sekolah',
                            'test' => $userAbsentToday,
                            'test2' => $userScheduleToday,
                            'date' => $date,
                            's' =>  $request->date,
                            'sll' =>  $request->all(),
                            'day' => $day,
                        ]);
                    }
                }
            }

            return response([
                'status' => 'success',
                'message' => 'absent berhasil diajukan',
                'test' => $userAbsentToday,
                'test2' => $userScheduleToday,
                'date' => $date,
                'day' => $day
            ]);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}