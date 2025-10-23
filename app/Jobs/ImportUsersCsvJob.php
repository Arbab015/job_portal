<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ImportUsersCsvJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $path;

    /**
     * Create a new job instance.
     */
    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
             Log::info("Import started: {$this->path}");

        if (!file_exists($this->path)) {
            Log::warning("CSV import failed: file not found at {$this->path}");
            return;
        }
        if (($handle = fopen($this->path, 'r')) === false) {
            Log::warning("CSV import failed: cannot open file at {$this->path}");
            return;
        }

               Log::info("Reading file...");
               
        fgetcsv($handle);

        while (($row = fgetcsv($handle, 1000, ',')) !== false) {
            [$name, $email, $password] = $row;

            if (!User::where('email', $email)->exists()) {
                User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => $password,
                ]);
            }
        }

        fclose($handle);
    }
}
