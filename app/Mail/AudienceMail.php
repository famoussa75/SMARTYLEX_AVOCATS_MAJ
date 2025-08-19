<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AudienceMail extends Mailable
{
    use Queueable, SerializesModels;


    public $audiences;
    public $typeListe;

    public function __construct($audiences, $typeListe = 'a_venir') // valeur par défaut si besoin
    {
        $this->audiences = $audiences;
        $this->typeListe = $typeListe;
    }


    public function build()
    {
        return $this->subject('Alerte : Audiences prévues demain')
                    ->view('audiences.allAudiences');
    }


    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
