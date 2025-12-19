<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\UploadPending;
use App\Jobs\ProcessUploadJob;



class ProcessUploadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $filePath;
    public $slug;

    public function __construct($filePath, $slug)
    {
        $this->filePath = $filePath;
        $this->slug = $slug;
    }

    public function handle()
    {
        $fileName = basename($this->filePath);

        UploadPending::create([
            'temp_path'     => $this->filePath,
            'original_name' => $fileName,
            'final_path'    => 'assets/upload/fichiers/affaires/',
            'affaire_slug'  => $this->slug,
        ]);
    }
}


