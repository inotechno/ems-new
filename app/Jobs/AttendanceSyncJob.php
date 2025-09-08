<?php

namespace App\Jobs;

use App\Models\Attendance;
use App\Models\ConfigAttendance;
use App\Models\Machine;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Rats\Zkteco\Lib\ZKTeco;
use Illuminate\Support\Facades\Mail;

class AttendanceSyncJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = $this->data;

        try {
            foreach ($data as $dt) {
                Attendance::updateOrCreate(
                    ['uid' => $dt['uid']],
                    $dt
                );

                \Log::info(json_encode($dt));

                if ($dt['late']) {
                    $selisihTelat = $dt['diff_late'];
                    $input['description'] = "Halo {$dt['name']},\n\nAbsensi Anda pada " . date('d M Y, H:i', strtotime($dt['timestamp'])) . " telah tercatat. Namun, Anda mengalami keterlambatan selama $selisihTelat.\n\nTetap semangat dan selalu jaga kedisiplinan!\n\nTerima kasih.";
                    $input['subject'] = "Konfirmasi Absensi - Keterlambatan $selisihTelat";

                    $input['email'] = $dt['email'];
                    $input['name'] = $dt['name'];

                    if ($dt['whatsapp_number'] != "") {
                        $this->sendWhatsAppNotification($dt['whatsapp_number'], $input['description']);
                        \Log::info(date('Y-m-d H:i:s') . ' ' . 'Sent Whatsapp ' . $dt['whatsapp_number'] . ' Successfully');
                    }

                    // if ($dt['email'] != "") {
                    //     Mail::send('email.send_announcement', $input, function ($message) use ($input) {
                    //         $message->to($input['email'], $input['name'])->subject($input['subject']);
                    //     });

                    //     \Log::info(date('Y-m-d H:i:s') . ' ' . 'Sent Email ' . $dt['email'] . ' Successfully');
                    // }
                }
            }

            \Log::info(date('Y-m-d H:i:s') . ' ' . 'Attendance Sync Job Completed Successfully');
        } catch (\Throwable $th) {
            \Log::error(date('Y-m-d H:i:s') . ' ' . $th->getMessage());
        }
    }


    /**
     * Mengirim notifikasi WhatsApp
     */
    private function sendWhatsAppNotification($phoneNumber, $message)
    {
        try {
            $no_hp = ltrim($phoneNumber);
            if (str_starts_with($no_hp, '0')) {
                $no_hp = '62' . substr($no_hp, 1);
            }

            $url = "https://waha.tpm-facility.com/api/sendText";
            $data = [
                "session" => "default",
                "chatId" => $no_hp,
                "text" => $message
            ];

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'X-Api-Key: dutaMas26'
            ]);
            $response = curl_exec($ch);
            $error = curl_error($ch);

            curl_close($ch);

            if ($error) {
                \Log::error('WA API Error: ' . $error);
                return false;
            }

            \Log::info('WhatsApp Notification Sent', ['response' => $response]);
            return $response;
        } catch (\Throwable $th) {
            \Log::error('WA Send Error: ' . $th->getMessage());
            return false;
        }
    }

}
