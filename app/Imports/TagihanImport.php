<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Biaya;
use App\Models\Siswa;
use App\Models\Tagihan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use GuzzleHttp\Client;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class TagihanImport implements ToModel, WithStartRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

     public function startRow(): int
     {
         return 2;
     }
    public function model(array $row)
    {
        $tagihan = new Tagihan([
            'keterangan' => $row[1] ?? '',
            'tanggal_terbit'     => $row[2] ?? '',
            'tanggal_lunas'      => $row[3] ?? Carbon::now()->format('Y-m-d'),
            'status'     => $row[4] ?? '',
            'user_penerbit_id'    => User::where('nama',$row[5])->first()->id,
            'user_melunasi_id' => User::where('nama',$row[6])->first()->id ?? null,
            'biaya_id' => Biaya::where('nama_biaya',$row[7])->first()->id ?? '',
            'user_id'   => User::where('nama',$row[8])->first()->id,
            'bulan'  => $row[9] ?? '',
            'tahun'  => $row[10] ?? '',

        ]);

        $tagihan->save();
        $this->sendTelegramNotification($tagihan);

        return $tagihan;
    }

    private function sendTelegramNotification(Tagihan $tagihan)
    {
        $user = User::find($tagihan->user_id);
        $biaya = Biaya::find($tagihan->biaya_id);

        if (!$user || !$biaya) {
            return;
        }

        $chatId = $user->chat_id ?? env('TELEGRAM_CHAT_ID');
        $botToken = env('TELEGRAM_BOT_TOKEN');

        // Generate invoice PDF
        $imageData = base64_encode(file_get_contents(public_path('logo_sekolah.png')));
        $imageSrc = 'data:image/png;base64,' . $imageData;

        $html = View::make('invoice_template', [
            'user' => $user,
            'biaya' => $biaya,
            'data_tagihan' => $tagihan,
            'imageSrc' => $imageSrc
        ])->render();

        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($options);
        $dompdf->set_option('isHtml5ParserEnabled', true);
        $dompdf->set_option('isPhpEnabled', true);
        $dompdf->loadHtml($html);
        $dompdf->setPaper([0, 0, 800, 600], 'portrait');
        $dompdf->render();

        $pdfPath = storage_path('app/public/invoice_' . $tagihan->id . '.pdf');
        file_put_contents($pdfPath, $dompdf->output());

        // Kirim pesan Telegram
        $client = new Client();
        $client->post("https://api.telegram.org/bot{$botToken}/sendMessage", [
            'form_params' => [
                'chat_id' => $chatId,
                'text' => "Halo {$user->nama}, berikut adalah invoice tagihan Anda: {$biaya->nama_biaya}.",
            ],
        ]);

        // Kirim PDF
        $client->post("https://api.telegram.org/bot{$botToken}/sendDocument", [
            'multipart' => [
                [
                    'name' => 'chat_id',
                    'contents' => $chatId,
                ],
                [
                    'name' => 'document',
                    'contents' => fopen($pdfPath, 'r'),
                    'filename' => 'invoice.pdf',
                ],
            ],
        ]);

        // Hapus file setelah dikirim
        unlink($pdfPath);
    }
}
