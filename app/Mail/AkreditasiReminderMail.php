<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AkreditasiReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $akreditasi;

    /**
     * Create a new message instance.
     *
     * @param $akreditasi
     * @return void
     */
    public function __construct($akreditasi)
    {
        $this->akreditasi = $akreditasi;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.akreditasi_reminder')
                    ->subject('Pengingat Akreditasi untuk ' . $this->akreditasi->prodi)
                    ->with(['akreditasi' => $this->akreditasi]);
    }
}
