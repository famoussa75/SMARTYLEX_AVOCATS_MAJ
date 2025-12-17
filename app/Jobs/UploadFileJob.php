<?php

namespace App\Jobs;

use App\Models\Fichiers;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UploadFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tempPath;
    public $affaireSlug;
    public $originalName;
    public $token;
    public $targetPath;
    public $filenamePrefix;

    public function __construct($tempPath, $affaireSlug, $originalName, $token, $targetPath, $filenamePrefix)
    {
        $this->tempPath     = $tempPath;
        $this->affaireSlug  = $affaireSlug;
        $this->originalName = $originalName;
        $this->token        = $token;
        $this->targetPath   = rtrim($targetPath, '/') . '/'; // sécurisation
        $this->filenamePrefix = $filenamePrefix;
    }

    public function handle()
    {
        Log::info('🚀 UploadFileJob START', ['temp' => $this->tempPath]);

        // 1️⃣ Vérifier le fichier temp
        if (!Storage::disk('local')->exists($this->tempPath)) {
            throw new \Exception('TEMP FILE NOT FOUND: ' . $this->tempPath);
        }

        // 2️⃣ Nom final
        $extension = pathinfo($this->originalName, PATHINFO_EXTENSION);
        $filename = $this->filenamePrefix . uniqid('', true) . '.' . $extension;

        // 3️⃣ Chemin FINAL (RELATIF AU DISK)
        $finalPath = $this->targetPath . $filename;

        // 4️⃣ Laravel crée le dossier automatiquement
        Storage::disk('public')->put(
            $finalPath,
            Storage::disk('local')->get($this->tempPath)
        );

        // 5️⃣ Supprimer le temp
        Storage::disk('local')->delete($this->tempPath);

        // 6️⃣ Sauvegarde BDD
        Fichiers::create([
            'nomOriginal' => $this->originalName,
            'slugSource'  => $this->affaireSlug,
            'filename'    => $filename,
            'slug'        => uniqid(),
            'path'        => 'storage/' . $finalPath,
        ]);

        Log::info('✅ UploadFileJob SUCCESS', ['file' => $filename]);
    }
}
