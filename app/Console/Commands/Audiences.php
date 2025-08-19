<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\AudienceMail;





class Audiences extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:audiences';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Traite les audiences du lendemain et envoie un mail de rappel.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $demain = Carbon::tomorrow()->format('Y-m-d');
        // Récupération des audiences avec une audience prévue demain
        $audiences = DB::table('audiences')
            ->whereDate('prochaineAudience', '=', $demain)
            ->get();

        if ($audiences->isEmpty()) {
            $this->info("Aucune audience prévue demain.");
            return;
        }

        // Envoi par mail
        Mail::to("houmadifahad100@email.com")->send(new AudienceMail($audiences, 'a_venir'));


        $this->info("Alerte audience envoyée !");
    }
}
