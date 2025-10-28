<?php

namespace App\Jobs;

use App\Models\User;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ImportUsersCsvJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $path;
    public $user_id;
    public $user_email;

    /**
     * Create a new job instance.
     */
    public function __construct(string $path, int $user_id, array $user_email)
    {
        $this->path = $path;
        $this->user_id = $user_id;
        $this->user_email = $user_email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $user = User::findOrFail($this->user_id);
            Log::info("Import started: {$this->path}");

            if (!file_exists($this->path)) {
                Log::warning("CSV import failed: file not found at {$this->path}");
                return;
            }

            $handle = fopen($this->path, 'r');
            if (!$handle) {
                Log::warning("CSV import failed: cannot open file at {$this->path}");
                return;
            }

            $total_rows = 0;
            while (fgets($handle) !== false) {
                $total_rows++;
            }
            $total_rows--;
            rewind($handle);
            fgetcsv($handle);

            $chunk = [];
            $chunk_size = 20;
            $total_imported = 0;

            while (($row = fgetcsv($handle)) !== false) {
                [$name, $email, $password] = $row;

                if (in_array($email, $this->user_email)) {
                    continue;
                }

                $chunk[] = [
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make($password),
                ];

                if (count($chunk) >= $chunk_size) {
                    User::insert($chunk);
                    $total_imported += count($chunk);
                    $percent = round(($total_imported / $total_rows) * 100, 2);
                    $user->update(['percentage' => $percent]);
                    Log::info("Progress: {$percent}% ({$total_imported}/{$total_rows}) imported");
                    $chunk = [];
                }
            }

            if (!empty($chunk)) {
                Log::info("remaining values");
                User::insert($chunk);
                $total_imported += count($chunk);
                $percent = round(($total_imported / $total_rows) * 100, 2);
                $user->update(['percentage' => $percent]);
                Log::info("Progress: {$percent}% ({$total_imported}/{$total_rows}) imported");
            }
            fclose($handle);
            File::delete($this->path);
            $user->update(['percentage' => 0]);
            Log::info("Import completed. Total users imported: {$total_imported}");
        } catch (Exception $e) {
            $user->update(['percentage' => 0]);
        }
    }

   
}
