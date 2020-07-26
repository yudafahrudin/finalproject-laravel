<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Product;
use App\Transaction;
use App\UserPurchaseMap;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MidtransTransactionController extends Controller
{
    public function upgradeAccount(Request $request)
    {
        if (!$request->product_id) {
            $request->session()->flash('alert', 'Mohon pilih salah satu ya kak :)');
            return redirect()->route('account.upgrade');
        }

        try {
            \Midtrans\Config::$serverKey = config('services.midtrans.serverKey');
            \Midtrans\Config::$isProduction = config('services.midtrans.isProduction');
            \Midtrans\Config::$isSanitized = config('services.midtrans.isSanitized');
            \Midtrans\Config::$is3ds = config('services.midtrans.is3ds');

            $user = auth()->user();
            $product = Product::findOrFail($request->product_id);
            $carbon = new Carbon();
            $date_now = $carbon->format('Y-m-d H:i') . " +0700";
            $snapToken = null;
            $transaction_id = null;
            $order_id = null;
            $status = 'pending';
            $purchase_price = $product->price;
            $currentTransaction = Transaction::where('product_id', $product->id)
                ->where('user_id', $user->id)
                ->where('status', 'pending')
                ->get()
                ->first();
            if ($currentTransaction) {
                $order_id = $currentTransaction->order_id;
                $purchase_price = $currentTransaction->purchase_price;
                $status = $currentTransaction->status;

                $transaction_details = array(
                    'order_id' => $order_id,
                    'gross_amount' => $purchase_price,
                );

                $customer_details = array(
                    'first_name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone_number ? $user->phone_number : "081357778874",
                );

                $expiry = array(
                    "unit" => "hours",
                    "duration" => 1,
                );

                $item_details = array(
                    'id' => $product->SKU,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => 1,
                );

                $item_details = array($item_details);

                // Fill transaction details
                $transaction = array(
                    'transaction_details' => $transaction_details,
                    'customer_details' => $customer_details,
                    'item_details' => $item_details,
                    'expiry' => $expiry,
                );
                $snapToken = \Midtrans\Snap::getSnapToken($transaction);

            } else {
                $order_id = strtoupper($product->code . '-' . Str::random(5) . rand(0, date('mm')));
                $transaction_details = array(
                    'order_id' => $order_id,
                    'gross_amount' => $purchase_price,
                );

                $customer_details = array(
                    'first_name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone_number ? $user->phone_number : "081357778874",
                );

                $expiry = array(
                    "unit" => "hours",
                    "duration" => 1,
                );

                $item_details = array(
                    'id' => $product->SKU,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => 1,
                );

                $item_details = array($item_details);

                // Fill transaction details
                $transaction = array(
                    'transaction_details' => $transaction_details,
                    'customer_details' => $customer_details,
                    'item_details' => $item_details,
                    'expiry' => $expiry,
                );

                $snapToken = \Midtrans\Snap::getSnapToken($transaction);

                // Begin transaction
                DB::beginTransaction();

                //Create transaction
                $transaction = Transaction::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'purchase_price' => $product->price,
                    'purchase_subscription_period_number' => $product->subscription_period_number,
                    'purchase_subscription_period_date' => $product->subscription_period_date,
                    'order_id' => $order_id,
                    'snap_token' => $snapToken,
                    'status' => $status,
                ]);

                UserPurchaseMap::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'transaction_id' => $transaction->id,
                ]);

                //Commit if all is already setup
                DB::commit();
            }
        } catch (\Exception $e) {
            DB::rollBack();
            $request->session()->flash('alert', $e->getMessage());
        }

        $message = $request->session()->get('alert');
        return redirect()->route('account.upgrade');
    }

    public function upgradeAccountViews(Request $request)
    {

        $user = auth()->user();
        $snapToken = null;
        $products = Product::all();
        $userMapTransaction = UserPurchaseMap::whereUser_id($user->id)->get();
        $hasSuscribeTransaction = $user->userPurchaseMapNotExpired()->first();
        $currentTransaction = null;
        foreach ($userMapTransaction as $key => $item) {
            if ($item->transaction->status == 'pending' && $item->product->type == 'subscription') {
                $currentTransaction = $item;
            }
        }

        if ($currentTransaction) {
            $snapToken = $currentTransaction->transaction->snap_token;
        }

        $message = $request->session()->get('alert');
        return view('general.upgradeAccount', compact('user', 'message', 'products', 'snapToken', 'currentTransaction', 'hasSuscribeTransaction'));
    }
}