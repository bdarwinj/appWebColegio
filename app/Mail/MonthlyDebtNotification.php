<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MonthlyDebtNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $student;
    public $balanceData;
    public $academicYear;

    /**
     * Crea una nueva instancia del mensaje.
     *
     * @param \App\Models\Student $student
     * @param array $balanceData
     * @param int $academicYear
     */
    public function __construct($student, $balanceData, $academicYear)
    {
        $this->student = $student;
        $this->balanceData = $balanceData;
        $this->academicYear = $academicYear;
    }

    /**
     * Construye el mensaje.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Notificación de Deuda de Mensualidades')
                    ->view('emails.monthly_debt_notification');
    }
}
