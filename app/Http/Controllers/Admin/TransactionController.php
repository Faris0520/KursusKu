<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $transactions = Transaction::with(['user', 'course'])
            ->when($request->search, function ($q, $search) {
                $q->whereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%"))
                  ->orWhereHas('course', fn($c) => $c->where('title', 'like', "%{$search}%"));
            })
            ->when($request->status, fn($q, $status) => $q->where('status', $status))
            ->latest()
            ->paginate(20);

        $stats = [
            'total'   => Transaction::count(),
            'paid'    => Transaction::where('status', 'paid')->count(),
            'pending' => Transaction::where('status', 'pending')->count(),
            'failed'  => Transaction::whereIn('status', ['failed', 'expired'])->count(),
            'revenue' => Transaction::where('status', 'paid')->sum('amount'),
        ];

        return view('admin.transactions.index', compact('transactions', 'stats'));
    }
}
