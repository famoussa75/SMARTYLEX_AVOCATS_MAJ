<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UploadPending;
use App\Models\Fichiers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProcessPendingUploads extends Command
{
    protected $signature = 'uploads:process';
    protected $description = 'Process pending file uploads';

    public function handle()
    {
        $uploads = UploadPending::where('status', 'pending')->limit(5)->get();

        foreach ($uploads as $upload) {
            try {
                if (!Storage::disk('local')->exists($upload->temp_path)) {
                    throw new \Exception('Temp file missing');
                }

                $ext = pathinfo($upload->original_name, PATHINFO_EXTENSION);
                $filename = 'AFF_'.uniqid().'.'.$ext;

                Storage::disk('public')->put(
                    $upload->final_path.$filename,
                    Storage::disk('local')->get($upload->temp_path)
                );

                Storage::disk('local')->delete($upload->temp_path);

                Fichiers::create([
                    'nomOriginal' => $upload->original_name,
                    'slugSource'  => $upload->affaire_slug,
                    'filename'    => $filename,
                    'path'        => 'storage/'.$upload->final_path.$filename,
                    'slug'        => uniqid(),
                ]);

                $upload->update(['status' => 'done']);

            } catch (\Throwable $e) {
                $upload->update([
                    'status' => 'error',
                    'error'  => $e->getMessage()
                ]);
            }
        }
    }
}

