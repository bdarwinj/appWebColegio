<?php

if (!function_exists('calculate_student_balance')) {
    /**
     * Calcula el estado de cuenta de mensualidades para un estudiante en un año académico dado.
     * Se asume 12 mensualidades.
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
        $expectedTotal = $fee * 12;
        
        // Sumar los pagos realizados en ese año para el estudiante
        $totalPaid = \App\Models\Payment::where('student_id', $studentId)
            ->whereYear('payment_date', $academicYear)
            ->sum('amount');
        
        $balance = $expectedTotal - $totalPaid;
        $pendingMonths = ($fee > 0 && $balance > 0) ? ceil($balance / $fee) : 0;
        
        return [
            'monthly_fee'   => $fee,
            'expected_total'=> $expectedTotal,
            'total_paid'    => $totalPaid,
            'balance'       => $balance,
            'pending_months'=> $pendingMonths
        ];
    }
}
