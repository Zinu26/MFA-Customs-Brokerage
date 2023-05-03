<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Shipment;

class ChatBotController extends Controller
{
    // public function handleRequest(Request $request, Client $gpt3)
    // {
    //     $message = $request->input('message');
    //     $response = $gpt3->post('https://api.openai.com/v1/engines/davinci-codex/completions', [
    //         'headers' => [
    //             'Content-Type' => 'application/json',
    //             'Authorization' => 'Bearer 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',
    //         ],
    //         'json' => [
    //             'prompt' => $message,
    //             'max_tokens' => 50,
    //             'temperature' => 0.7,
    //         ],
    //     ]);

    //     $chatbotResponse = $response->getBody();
    //     return response()->json(['response' => $chatbotResponse]);
    // }

    public function sendChat(Request $request) {
        $input = $request->input;
        if (strpos(strtolower($input), 'users') !== false) {
            $users = User::all();
            $userList = '';
            foreach ($users as $user) {
                $userList .= $user->name . ', ';
            }
            $response = 'Here is the list of registered users: ' . $userList;
        }if (strpos(strtolower($input), 'shipments') !== false) {
            $shipments = Shipment::all();
            $shipmentList = '';
            foreach ($shipments as $shipment) {
                $shipmentList .= $shipment->bl_number . ', ';
            }
            $response = 'Here is the list of shipments: ' . $shipmentList;
        } else {
            // Send the user's input to OpenAI for processing
            $result = OpenAI::completions()->create([
                'max_tokens' => 100,
                'model' => 'text-davinci-003',
                'prompt' => $input
            ]);

            $response = array_reduce(
                $result->toArray()['choices'],
                fn(string $result, array $choice) => $result . $choice['text'], ""
            );
        }
        return $response;
    }



}
