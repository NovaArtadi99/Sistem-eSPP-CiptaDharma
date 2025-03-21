<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\User;

class TelegramController extends Controller
{
    public function updateChatId(Request $request)
    {
        $botToken = env('TELEGRAM_BOT_TOKEN');
        $url = "https://api.telegram.org/bot{$botToken}/getUpdates";

        $client = new Client();
        $response = $client->get($url);
        $updates = json_decode($response->getBody(), true);

        if ($updates['ok']) {
            foreach ($updates['result'] as $update) {
                if (isset($update['message']['chat']['id']) && isset($update['message']['text'])) {
                    $chatId = $update['message']['chat']['id'];
                    $text = $update['message']['text'];


                    if (isset($update['message']['entities'])) {
                        foreach ($update['message']['entities'] as $entity) {
                            if ($entity['type'] === 'phone_number') {
                                $phoneNumber = $text;

                                $user = User::where('no_telp', $phoneNumber)->first();

                                if ($user) {
                                    $user->update(['chat_id' => $chatId]);
                                }

                                break;
                            }
                        }
                    }
                }
            }
            return redirect()->back()->with('success', 'Data berhasil diperbarui!');
        }
        return response()->json(['message' => 'Gagal mengambil data'], 500);
    }

    // public function send_tagihan()
    // {
    //     $botToken = env('TELEGRAM_BOT_TOKEN');
    //     $chatId = 700414598;
    //     $client = new \GuzzleHttp\Client();
    //     $response = $client->post("https://api.telegram.org/bot{$botToken}/sendMessage", [
    //         'form_params' => [
    //             'chat_id' => $chatId,
    //             'text' => 'Hello from Laravel!',
    //         ],
    //     ]);
    // }
}
