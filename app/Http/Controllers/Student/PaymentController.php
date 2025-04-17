<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::whereHas('invoice', function ($query) {
            $query->where('student_id', auth()->user()->student->id);
        })->with(['invoice'])->latest()->get();

        return view('student.payments.index', compact('payments'));
    }
}