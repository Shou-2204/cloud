<?php

namespace App\Jobs;

use App\Models\Team;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\LabelAlignment;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class GenerateTeamQrCode implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Team $team)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (empty($this->team->short_url)) {
            return;
        }

        $builder = new Builder(
            writer: new PngWriter(),
            writerOptions: [],
            validateResult: false,
            data: $this->team->short_url,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            size: 300,
            margin: 10,
            roundBlockSizeMode: RoundBlockSizeMode::Margin
        );

        $result = $builder->build();

        // Delete old QR code if it exists
        if ($this->team->qr_code_path && Storage::disk(Team::QR_CODE_DISK)->exists($this->team->qr_code_path)) {
            Storage::disk(Team::QR_CODE_DISK)->delete($this->team->qr_code_path);
        }

        // Generate a random filename to avoid predictability
        $fileName = 'qrcodes/' . \Illuminate\Support\Str::uuid() . '.png';
        
        // Store in the cloud public disk so it's accessible via S3
        Storage::disk(Team::QR_CODE_DISK)->put($fileName, $result->getString());

        $this->team->forceFill(['qr_code_path' => $fileName])->saveQuietly();
    }
}
