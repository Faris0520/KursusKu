<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class TransactionController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function create(Course $course)
    {
        $user = auth()->user();

        if ($user->isEnrolled($course)) {
            return back()->with('error', 'Kamu sudah terdaftar di kursus ini.');
        }

        if ($course->isFree()) {
            return back()->with('error', 'Kursus ini gratis, tidak perlu pembayaran.');
        }

        $orderId = 'KSK-' . $course->id . '-' . $user->id . '-' . time();

        $transaction = Transaction::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'amount' => $course->price,
            'midtrans_order_id' => $orderId,
            'status' => 'pending',
        ]);

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $course->price,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
            'item_details' => [
                [
                    'id' => $course->id,
                    'price' => (int) $course->price,
                    'quantity' => 1,
                    'name' => substr($course->title, 0, 50),
                ],
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        return view('transactions.pay', compact('snapToken', 'course', 'transaction'));
    }

    public function callback(Request $request)
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');

        $notification = new Notification();

        $orderId = $notification->order_id;
        $transactionStatus = $notification->transaction_status;
        $fraudStatus = $notification->fraud_status;

        $transaction = Transaction::where('midtrans_order_id', $orderId)->first();

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            if ($fraudStatus == 'accept' || $transactionStatus == 'settlement') {
                $transaction->update([
                    'status' => 'paid',
                    'midtrans_transaction_id' => $notification->transaction_id,
                    'paid_at' => now(),
                ]);

                Enrollment::firstOrCreate([
                    'user_id' => $transaction->user_id,
                    'course_id' => $transaction->course_id,
                ], [
                    'enrolled_at' => now(),
                ]);
            }
        } elseif ($transactionStatus == 'cancel' || $transactionStatus == 'deny') {
            $transaction->update(['status' => 'failed']);
        } elseif ($transactionStatus == 'expire') {
            $transaction->update(['status' => 'expired']);
        }

        return response()->json(['message' => 'OK']);
    }

    public function history()
    {
        $transactions = auth()->user()->transactions()
            ->with('course')
            ->latest()
            ->paginate(15);

        return view('transactions.history', compact('transactions'));
    }
}