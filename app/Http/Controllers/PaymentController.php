<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Student;
use App\Models\Enrollment;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function create()
    {
        $students = Student::all();
        return view('payments.create', compact('students'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|numeric',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string',
            'period' => 'required|numeric|min:1|max:12',
            'enrollment_id' => 'nullable|numeric'
        ]);
        
        $data = $request->only(['student_id', 'enrollment_id', 'amount', 'description', 'period']);
        $data['payment_date'] = Carbon::now();
        $payment = Payment::create($data);
        
        $datePart = Carbon::now()->format('Ymd');
        $payment->receipt_number = $datePart . '-' . str_pad($payment->id, 4, '0', STR_PAD_LEFT);
        $payment->save();
        
        return redirect()->route('payments.history', $data['student_id'])->with('success', 'Pago registrado exitosamente.');
    }
    
    public function history($student_id)
    {
        $payments = Payment::where('student_id', $student_id)->orderBy('payment_date', 'desc')->get();
        return view('payments.history', compact('payments', 'student_id'));
    }
}
