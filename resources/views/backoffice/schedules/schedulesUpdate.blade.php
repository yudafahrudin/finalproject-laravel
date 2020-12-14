@extends('backoffice_layouts.index') @section('content')
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">UPDDATE JADWAL PELAJARAN</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="javascript:void(0)">Home</a>
            </li>
            <li class="breadcrumb-item active">Jadwal Pelajaran</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                @if ($error_message)
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>{{$error_message}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                @endif
                <form method="POST" action="{{ Route('schedule.update', $schedule->id) }}">
                    @csrf
                    {{ method_field('PUT') }}
                    <div class="form-body">
                        <h3 class="card-title" style="font-weight: bold">Info</h3>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Mata Pelajaran</label>
                                    <select class="form-control" name="subject_id" custom-select">
                                        @foreach ($subjects as $subject)
                                        <option value="{{$subject->id}}"
                                            {{$schedule->subject_id == $subject->id ? 'selected': ''}}
                                            >{{$subject->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Kelas</label>
                                    <select class="form-control" name="kelas_id" custom-select">
                                        @foreach ($kelas as $class)
                                        <option value="{{$class->id}}"
                                            {{$schedule->kelas_id == $class->id ? 'selected': ''}}
                                            >{{$class->grade}} - {{$class->majors}} {{$class->number}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Guru Pengajar</label>
                                    <select class="form-control" name="user_id" custom-select">
                                        @foreach ($teachers as $teacher)
                                        <option value="{{$teacher->id}}"
                                            {{$schedule->user_id == $teacher->id ? 'selected': ''}}
                                            >{{$teacher->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <h3 class="card-title" style="font-weight: bold">Info Jam dan Tahun</h3>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Jam Mulai</label>
                                    <input type="text" class="form-control" name="start_at"
                                id="timePicker1" value="{{$schedule->start_at}}"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Jam Selesai</label>
                                    <input type="text" class="form-control" name="end_at"
                                id="timePicker2" value="{{$schedule->end_at}}" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Hari</label>
                                    <select class="form-control" name="day" custom-select">
                                        <option value="senin"  {{ $schedule->day == 'senin' ? 'selected':'' }}>Senin</option>
                                        <option value="selasa" {{ $schedule->day == 'selasa' ? 'selected':'' }}>Selasa</option>
                                        <option value="rabu" {{ $schedule->day == 'rabu' ? 'selected':'' }}>Rabu</option>
                                        <option value="kamis" {{ $schedule->day == 'kamis' ? 'selected':'' }}>Kamis</option>
                                        <option value="jumat" {{ $schedule->day == 'jumat' ? 'selected':'' }}>Jumat</option>
                                        <option value="sabtu" {{ $schedule->day == 'sabtu' ? 'selected':'' }}>Sabtu</option>
                                        <option value="minggu" {{ $schedule->day == 'minggu' ? 'selected':'' }}>Minggu</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Semester</label>
                                    <select class="form-control" name="semester" custom-select">
                                        <option value="ganjil">ganjil</option>
                                        <option value="genap">genap</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Tahun</label>
                                    <select class="form-control" name="year" custom-select">
                                        <option value="{{date('Y')}}">{{date('Y')}}</option>
                                        <option value="{{date('Y', strtotime('+1 year'))}}">{{date('Y', strtotime('+1 year'))}}</option>
                                    </select>
                                </div>
                            </div>
                        
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Simpan</button>
                            <a href="{{url('/schedule')}}" class="btn btn-inverse">Cancel</a>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
