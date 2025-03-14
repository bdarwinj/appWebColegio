<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Student;
use App\Models\Enrollment;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
    public function create()
    {
        // Obtener la lista de estudiantes para el select
        $students = Student::all();
        return view('payments.create', compact('students'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'student_id'   => 'required|numeric',
            'amount'       => 'required|numeric|min:0.01',
            'description'  => 'required|string',
            'period'       => 'required|numeric|min:1|max:12',
            'enrollment_id'=> 'nullable|numeric'
        ]);
        
        $data = $request->only(['student_id', 'enrollment_id', 'amount', 'description', 'period']);
        $data['payment_date'] = Carbon::now();
        $payment = Payment::create($data);
        
        // Generar número de recibo similar a la versión Python: YYYYMMDD-000X
        $datePart = Carbon::now()->format('Ymd');
        $receiptNumber = $datePart . '-' . str_pad($payment->id, 4, '0', STR_PAD_LEFT);
        $payment->receipt_number = $receiptNumber;
        $payment->save();
        
        // Almacenar en sesión los datos del recibo para mostrar el modal
        session()->flash('receipt', [
            'id'             => $payment->id,
            'receipt_number' => $receiptNumber,
            'amount'         => $payment->amount,
            'payment_date'   => $payment->payment_date,
            'description'    => $payment->description,
            'period'         => $payment->period,
        ]);
        
        return redirect()->route('payments.create')->with('success', 'Pago registrado exitosamente.');
    }
    
    public function receipt($id)
    {
        $payment = Payment::findOrFail($id);
        $student = $payment->student;
        $data = [
            'payment' => $payment,
            'student' => $student,
            // Opcional: también se puede pasar $schoolName y $logoPath desde la configuración
            'schoolName' => session('schoolName', 'Colegio Ejemplo'),
            'logoPath' => session('logoPath', 'assets/logo.png'),
        ];
        $pdf = Pdf::loadView('payments.receipt', $data);
        return $pdf->download('recibo_' . $payment->receipt_number . '.pdf');
    }
    
    public function history($student_id)
    {
        $payments = Payment::where('student_id', $student_id)->orderBy('payment_date', 'desc')->get();
        return view('payments.history', compact('payments', 'student_id'));
    }
}
