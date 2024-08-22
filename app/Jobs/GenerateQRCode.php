<?php

namespace App\Jobs;

use App\Models\Site;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class GenerateQRCode implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $uid;
    /**
     * Create a new job instance.
     */
    public function __construct($uid)
    {
        $this->uid = $uid;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Generate QR Code
        $qrContent = QrCode::size(1012)
            ->margin(1)
            ->backgroundColor(255, 255, 255)
            ->format('png')
            ->generate($this->uid);

        // Simpan QR Code ke GCS
        $qrcodePath = 'qrcodes/' . $this->uid . '.png';
        Storage::disk('gcs')->put($qrcodePath, $qrContent);

        // Dapatkan URL publik penuh dari file yang diunggah
        $qrcodeUrl = Storage::disk('gcs')->url($qrcodePath);

        // Update site dengan qrcode_path dan qrcode_url
        Site::where('uid', $this->uid)->update([
            'qrcode_path' => $qrcodePath,
            'qrcode_url' => $qrcodeUrl,
        ]);
    }
}
