<?php

namespace App\Mail;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContratLocation extends Mailable
{
    use Queueable, SerializesModels;

    public $detailsContrat;

    public function __construct($detailsContrat)
    {
        $this->detailsContrat = $detailsContrat;
    }

    public function build()
    {
         // Générer le PDF
         $pdf = Pdf::loadView('Contrat.contrat', ['detailsContrat' => $this->detailsContrat]);
         return $this->subject('Demande validée et Contrat envoyé')
             ->view('emails.contrat_valide', ['detailsContrat' => $this->detailsContrat])
             ->attachData($pdf->output(), 'contrat_de_location_dsimmo.pdf', [
                 'mime' => 'application/pdf',
             ]);
    }

}
