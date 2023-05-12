<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Shipment;
use App\Models\FAQ;
use Spatie\Tags\Tag;

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

    public function home()
    {
        $faqs = Faq::all();

        return view('landing', compact('faqs'));
    }

    public function sendChat(Request $request)
    {

        // $selectedFaq = $request->input('input');
        // $faq = FAQ::where('question', $selectedFaq)->first();
        // $answer = $faq ? $faq->answer : "Sorry, the answer is not available.";
        // return response()->json(['answer' => $answer]);

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


        $selectedFaq = $request->input('faq');
        $faq = FAQ::where('question', $selectedFaq)->first();
        $answer = '';
        if ($faq) {
            if ($faq->question == 'How much is your rate?') {
                // choose one of the answers for this question randomly or based on some criteria
                $answers = [
                    'The determination of the rate is contingent upon specific shipment details, including but not limited to the number of items, sizes, and contents. Such rate is typically discussed and agreed upon in a meeting involving MFA and the consignee.',
                    'Rate determination is subject to various shipment specifics such as contents, number, and size. A meeting with the consignee and MFA typically settles the rate.',
                    'The rate is determined based on shipment details such as contents, number, and size. MFA and the consignee usually meet to discuss and agree on the rate.',
                    'To determine the rate, shipment specifics such as number, size, and contents are considered. MFA and the consignee generally meet to decide on the rate.',
                    'A meeting between MFA and the consignee usually determines the rate based on shipment details like contents, number, and size.'
                ];
                $answer = $answers[array_rand($answers)];
            } else {
                $answer = $faq->answer;
            }
        } else {
            $answer = "Sorry, the answer is not available.";
        }
        return response()->json(['answer' => $answer]);

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

    public function guest_send(Request $request)
    {
        // Remove any non-alphanumeric characters from the input
        $input = preg_replace('/[^a-zA-Z0-9\s]/', '', strtolower($request->input));


        // List of words and their synonyms to detect in the input
        $words  = [
            'MFA' => ['mfa', 'customs brokerage', 'brokerage'],
            'rate' => ['rate', 'pricing', 'cost'],
            'fees' => ['fees', 'charges', 'costs'],
            'bulk' => ['bulk', 'large quantity', 'massive'],
            'documents' => ['documents', 'papers', 'forms'],
            'contact' => ['contact', 'reach', 'call'],
            'client' => ['client', 'customer', 'importer'],
            'limitations' => ['limitations', 'restrictions', 'issues'],
            'lcl' => ['lcl', 'less-than-container-load', 'loose cargo'],
            'contract' => ['contract', 'agreement', 'term'],
            'trucking' => ['trucking', 'shipping', 'delivery'],
            'safety' => ['safety', 'security', 'protection'],
            'delay' => ['delay', 'late', 'postpone'],
            'shipment' => ['shipment', 'delivery', 'cargo'],
            'damage' => ['damage', 'broken', 'harm'],
            'storage' => ['storage', 'warehousing', 'inventory'],
            'tracking' => ['tracking', 'status', 'location'],
            'discounts' => ['discounts', 'promotions', 'offers'],
            'weight' => ['weight', 'mass', 'load'],
            'sizes' => ['sizes', 'dimensions', 'measurements'],
            'limitations' => ['limitations', 'restrictions', 'boundaries'],
        ];

        // Check the input sentence or trim the sentence word by word
        $words_in_input = preg_split('/\s+/', $input);

        // Check if any of the words or synonyms are present in the input
        foreach ($words as $word => $synonyms) {
            if (in_array($word, $words_in_input) || array_intersect($synonyms, $words_in_input)) {
                // Generate a random response based on the detected word
                switch ($word) {
                    case 'MFA':
                        $responses = [
                            'MFA Customs Brokerage is a business partner of Sonya Trucking Services.',
                            'MFA Customs Brokerage guarantees the safety and security of the client\'s cargo during transportation.',
                            'MFA Customs Brokerage works with clients to ensure smooth and efficient customs clearance.',
                            'MFA Customs Brokerage provides personalized and reliable logistics solutions for clients.'
                        ];
                    case 'rate':
                        $responses = [
                            'The rate depends on shipment details such as items, sizes, and contents.',
                            'The rate is decided in a meeting with MFA and the consignee.',
                            'The rate is determined based on shipment specifics.',
                            'Shipment details impact the rate, including item count, sizes, and contents.',
                            'MFA and consignee meet to agree on the rate, which is influenced by shipment details.'
                        ];
                        break;
                    case 'fees':
                        $responses = [
                            'Import duties, excise tax, and other administrative costs are typically handled by the importer.',
                            'There are fees for shipping lines, trucks, and brokers that may be shouldered by the client.',
                            'The client may also be responsible for fines and penalties, permit fees, registration fees, clearance fees, inspection fees, and processing expenses.',
                            'All fees and charges are discussed and agreed upon before the shipment is processed.',
                            'The exact fees and charges will depend on the specifics of the shipment.'
                        ];
                        break;
                    case 'bulk':
                        $responses = [
                            'Yes, MFA Customs Brokerage handles bulk cargoes.',
                            'We have experience in handling large-scale shipments.',
                            'Bulk cargoes require special handling and logistics, which we can provide.',
                            'We can assist you in finding the best shipping solutions for your bulk cargo.',
                            'Our team has the expertise and equipment necessary to handle massive shipments.'
                        ];
                        break;
                    case 'documents':
                        $responses = [
                            'The following documents are typically required for importation: BL (Bill of Lading), invoice, packing list, payment documentation, AFTA, and marine insurance.',
                            'We can provide assistance in preparing and processing all necessary importation documents.',
                            'The exact documents required will depend on the specifics of the shipment and the country of origin.',
                            'Our team can help you navigate the complex documentation requirements of international trade.',
                            'We have experience in handling all types of importation documents, from customs clearance forms to export permits.'
                        ];
                        break;
                    case 'contact':
                        $responses = [
                            'You may reach MFA Customs Brokerage at (82887706) or (9177033799).',
                            'Our team is available 24/7 to assist you with your shipment needs.',
                            'If you have any questions or concerns, please do not hesitate to contact us.',
                            'We pride ourselves on providing excellent customer service, and we are always here to help.',
                        ];
                        break;
                    case 'client':
                        $responses = [
                            'To become a client, you need to submit the necessary paperwork and meet with our manager.',
                            'You can contact us through various channels to become a customer.',
                            'Becoming a client requires completing your registration as an importer with BOC.',
                            'We look forward to discussing all the details of becoming a customer with you.',
                            'To get started as a client, send us an email or call us today.'
                        ];
                        break;
                    case 'limitations':
                        $responses = [
                            'Delays caused by BOC fees, missing documents, or slow processing can limit shipments.',
                            'We work hard to minimize delays, but some issues can arise during shipping and delivery.',
                            'Several factors can cause limitations, such as incomplete or missing documents or processing delays.',
                            'While we strive for efficient and speedy service, some limitations may occur due to external factors.',
                            'We work closely with our clients to address any issues or limitations that may arise.'
                        ];
                        break;
                    case 'lcl':
                        $responses = [
                            'Yes, we handle LCL shipments for our clients.',
                            'LCL refers to shipping cargo that doesn\'t fill a container, and we can help with this.',
                            'We combine LCL shipments with others to fill the container, making shipping more efficient.',
                            'Handling LCL shipments requires expertise and special handling, which we can provide.',
                            'Our team is experienced in managing LCL shipments, from start to finish.'
                        ];
                        break;
                    case 'contract':
                        $responses = [
                            'The term of the contract typically ends when the importer\'s contract with BOC ends.',
                            'To renew your importation, you need to comply with all the required documents.',
                            'The contract length will depend on the importer\'s contract with BOC.',
                            'The length of the contract will vary depending on the importer\'s specific needs and requirements.',
                            'We are happy to work with our clients to determine the best contract length for their needs.'
                        ];
                        break;
                    case 'trucking':
                        $responses = [
                            'The range of trucking fees depends on the shipment details, such as weight, size, and content.',
                            'The exact fees will depend on the specifics of the shipment, such as distance and destination.',
                            'We work hard to keep our trucking fees competitive and affordable for our clients.',
                            'We are happy to provide you with a quote for our trucking services based on your specific shipment details.',
                            'Our team is committed to providing efficient and reliable trucking services for our clients.'
                        ];
                        break;
                    case 'safety':
                    $responses = [
                        'MFA Customs Brokerage ensures the safety and security of cargo during transportation through our contractual obligation with our business partner, Sonya Trucking Services.',
                        'We take safety seriously and work to minimize the risk of damage or loss of cargo.',
                        'Our team follows strict safety protocols to ensure the safety and security of your cargo.',
                        'We have a team of experts that specialize in cargo security and safety.',
                        'We have invested in advanced technology and equipment to ensure the safety and security of your cargo.'
                    ];
                    break;
                case 'shipment':
                    $responses = [
                        'MFA Customs Brokerage provides delivery and trucking services for your shipment needs.',
                        'Our team handles cargo of all types and sizes, from small packages to large-scale shipments.',
                        'We work with our clients to ensure smooth and efficient customs clearance.',
                        'We offer a wide range of logistics solutions to meet your shipment needs.',
                        'Our team provides personalized and reliable service to ensure your shipment arrives on time and in good condition.'
                    ];
                    break;
                case 'delay':
                    $responses = [
                        'MFA Customs Brokerage responds to shipment delays by first determining the cause of the delay.',
                        'We work with our clients to find solutions to minimize the impact of delays on their business.',
                        'We have a team of experts that specialize in managing shipment delays.',
                        'We provide regular updates to our clients on the status of their delayed shipments.',
                        'Our team works around the clock to ensure your shipment arrives as quickly as possible.'
                    ];
                    break;
                }
                $response = $responses[array_rand($responses)];
                return $response;
            }
        }

        // If the input is not related to shipments or company details, prompt a randomly-selected generic response
        $responses = [
            'I\'m sorry, I didn\'t quite understand. Could you please rephrase your question?',
            'I\'m not sure I understand what you\'re asking. Can you provide more context?',
            'I\'m afraid I can\'t answer that. Is there something else I can help you with?',
            'I\'m not programmed to answer that question. Is there something else you would like to know?',
            'I\'m sorry, I didn\'t catch that. Could you please repeat your question?',
        ];
        $response = $responses[array_rand($responses)];
        return $response;
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
