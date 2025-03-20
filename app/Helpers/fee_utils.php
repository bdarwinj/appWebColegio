<?php

if (!function_exists('calculate_student_balance')) {
    /**
     * Calcula el estado de cuenta de mensualidades para un estudiante en un año académico dado.
     * Se determina el número de meses transcurridos en el año (asumiendo inicio en enero).
     *
     * @param int $studentId
     * @param int $academicYear
     * @return array|null
     */
    function calculate_student_balance($studentId, $academicYear)
    {
        // Obtener el estudiante (se asume que el modelo Student existe)
        $student = \App\Models\Student::find($studentId);
        if (!$student) {
            return null;
        }
        
        // Obtener el valor de la mensualidad para el curso del estudiante en el año especificado
        $courseFee = \App\Models\CourseFee::where('course_id', $student->course_id)
            ->where('academic_year', $academicYear)
            ->first();
        $fee = $courseFee ? $courseFee->fee : 0;
        
        // Determinar el número de meses transcurridos en el año
        $currentYear = date('Y');
        if ($academicYear == $currentYear) {
            $elapsedMonths = (int) date('n'); // Mes actual
        } elseif ($academicYear < $currentYear) {
            $elapsedMonths = 12;
        } else {
            $elapsedMonths = 0;
        }
        
        $expectedTotal = $fee * $elapsedMonths;
        $totalPaid = \App\Models\Payment::where('student_id', $studentId)
            ->whereYear('payment_date', $academicYear)
            ->sum('amount');
        
        $balance = $expectedTotal - $totalPaid;
        $pendingMonths = ($fee > 0 && $balance > 0) ? ceil($balance / $fee) : 0;
        
        return [
            'monthly_fee'    => $fee,
            'elapsed_months' => $elapsedMonths,
            'expected_total' => $expectedTotal,
            'total_paid'     => $totalPaid,
            'balance'        => $balance,
            'pending_months' => $pendingMonths
        ];
    }
}
