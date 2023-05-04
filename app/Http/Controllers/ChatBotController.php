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
    // public function sendChat(Request $request){
    //     $result = OpenAI::completions()->create([
    //         'max_tokens' => 100,
    //         'model' => 'text-davinci-003',
    //         'prompt' => $request->input
    //     ]);

    //     $response = array_reduce(
    //         $result->toArray()['choices'],
    //         fn(string $result, array $choice) => $result . $choice['text'], ""
    //     );

    //     return $response;
    // }

    public function sendChat(Request $request)
    {
        $input = $request->input;
        if (strpos(strtolower($input), 'shipments') !== false) {
            if (strpos(strtolower($input), 'details') !== false) {
                $response = 'What details do you need to know about the shipment? Please provide the BL number.';
                return $response;
            }
        }

        // If the input contains the BL number, look it up in the database
        if (preg_match('/^\d+$/', $input, $matches)) {
            $bl_number = $matches[0];
            $shipment = Shipment::where('bl_number', $bl_number)->first();
            if ($shipment) {
                if (strpos(strtolower($input), 'delivery status') !== false) {
                    $response = "The delivery status for BL number $bl_number is " . $shipment->delivery_status . '.';
                    return $response;
                } else {
                    // Prompt the user for what they want to know about the shipment
                    $response = 'What details do you need to know about the shipment?';
                    return $response;
                }
            } else {
                // The BL number was not found in the database
                $response = "Sorry, I couldn't find any shipments with BL number $bl_number. Please try again.";
                return $response;
            }
        }

        // If the input is not related to shipments or company details, prompt a randomly-selected generic response
        $responses = [
            'I apologize, but I can only answer questions related to MFA company and shipments details. Please try asking a different question.',
            'I am not sure I understand your question. Could you please rephrase it in terms of MFA company and shipments details?',
            'Unfortunately, I cannot assist you with that. Please ask me a question related to MFA company and shipments details.',
            'I am sorry, but I am only able to answer questions related to MFA company and shipments details. Can I help you with anything else?',
            'I am designed to answer questions related to MFA shipments and company details. Please try asking me about those topics.',
            'That does not seem to be related to MFA company and shipments details. Do you have a question on those topics?'
        ];
        $response = $responses[array_rand($responses)];
        return $response;

        // // Send the user's input to OpenAI for processing
        // $result = OpenAI::completions()->create([
        //     'max_tokens' => 100,
        //     'model' => 'text-davinci-003',
        //     'prompt' => $input
        // ]);

        // $response = array_reduce(
        //     $result->toArray()['choices'],
        //     fn(string $result, array $choice) => $result . $choice['text'], ""
        // );

        // return $response;
    }


    // public function sendChat(Request $request)
    // {
    //     $input = $request->input;
    //     $response = '';

    //     // Use OpenAI's GPT-3 to understand the user's intent and extract relevant information
    //     $result = OpenAI::davinci()->search($input, ['shipments', 'delivery status']);
    //     $intent = $result->getIntent();
    //     $entities = $result->getEntities();

    //     // Handle user queries based on the extracted intent and entities
    //     if ($intent == 'shipments') {
    //         if (empty($entities)) {
    //             // User wants to see a list of shipments
    //             $shipments = Shipment::all();
    //             $shipmentList = '';
    //             foreach ($shipments as $shipment) {
    //                 $shipmentList .= $shipment->bl_number . ', ';
    //             }
    //             $response = 'Here is the list of shipments: ' . $shipmentList;
    //         } else {
    //             // User wants to know about a specific shipment
    //             $blNumber = $entities['bl_number'][0];
    //             $shipment = Shipment::where('bl_number', $blNumber)->first();
    //             if ($shipment) {
    //                 if (isset($entities['delivery_status'])) {
    //                     // User wants to know the delivery status of the shipment
    //                     $response = "The delivery status of shipment $blNumber is " . $shipment->delivery_status;
    //                 } else {
    //                     // User wants to know other details about the shipment
    //                     $response = "Here are the details of shipment $blNumber: " . $shipment->details;
    //                 }
    //             } else {
    //                 // BL number not found
    //                 $response = "Sorry, I couldn't find any shipments with BL number $blNumber. Please try again.";
    //             }
    //         }
    //     } else {
    //         // Default response if the user's intent cannot be determined
    //         $response = "I'm sorry, I'm not sure what you're asking. Can you please be more specific?";
    //     }

    //     return $response;
    // }
}
