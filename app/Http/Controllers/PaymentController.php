<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Student;
use App\Models\Enrollment;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

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
            'student_id'   => 'required|numeric',
            'amount'       => 'required|numeric|min:0.01',
            'description'  => 'required|string',
            'period'       => 'nullable|numeric|min:1|max:12', // Ahora es opcional
            'enrollment_id'=> 'nullable|numeric'
        ]);
        
        $data = $request->only(['student_id', 'enrollment_id', 'amount', 'description', 'period']);
        // Si el campo 'period' está vacío, lo almacenamos como null.
        if(empty($data['period'])) {
            $data['period'] = null;
        }
        $data['payment_date'] = Carbon::now();
        $data['user_id'] = auth()->id(); // Guardar el usuario que registra el pago
        $payment = Payment::create($data);
        
        $datePart = Carbon::now()->format('Ymd');
        $receiptNumber = $datePart . '-' . str_pad($payment->id, 4, '0', STR_PAD_LEFT);
        $payment->receipt_number = $receiptNumber;
        $payment->save();
        
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
        $payment = Payment::with('user', 'student')->findOrFail($id);
        $schoolName = DB::table('config')->where('key', 'SCHOOL_NAME')->value('value') ?? 'Colegio Ejemplo';
        $logoPath = DB::table('config')->where('key', 'LOGO_PATH')->value('value') ?? 'assets/logo.png';
        
        $data = [
            'payment'   => $payment,
            'student'   => $payment->student,
            'schoolName'=> $schoolName,
            'logoPath'  => $logoPath,
        ];
        $pdf = PDF::loadView('payments.receipt', $data);
        return $pdf->download('recibo_' . $payment->receipt_number . '.pdf');
    }
    
    // Nuevo método para historial global con búsqueda
    public function historyAll(Request $request)
    {
        $query = Payment::query()->with(['student', 'user']);
        
        if ($request->has('search')) {
            $search = $request->input('search');
            // Filtrar pagos a través de la relación con el estudiante
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('identificacion', 'like', "%$search%")
                  ->orWhere('nombre', 'like', "%$search%")
                  ->orWhere('apellido', 'like', "%$search%");
            });
        }
        
        // Puedes usar paginate() o get() según prefieras
        $payments = $query->orderBy('payment_date', 'desc')->paginate(15);
        
        return view('payments.history_all', compact('payments'));
    }
    
    public function history($student_id)
    {
        $payments = Payment::with('user')->where('student_id', $student_id)->orderBy('payment_date', 'desc')->get();
        return view('payments.history', compact('payments', 'student_id'));
    }
}
