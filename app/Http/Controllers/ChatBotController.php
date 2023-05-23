<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shipment;

class ChatBotController extends Controller
{
    public function home()
    {
        return view('landing');
    }

    // Basic words
    // public function sendChat(Request $request)
    // {
    //     $user = Auth::user();
    //     $input = strtolower(trim($request->input));

    //     $conversation = session('conversation', []);
    //     $last_message = end($conversation);

    //     // Start a new conversation if this is the first message or the previous message was a "stop" command
    //     if (empty($conversation) || $last_message === 'stop') {
    //         $conversation = [];
    //         $response = 'Hi, ' . $user->name . '! What BL number are you inquiring about?';
    //     } else {
    //         // Find BL Numbers in the database
    //         if (preg_match('/^\d+$/', $input, $matches)) {
    //             $bl_number = $matches[0];
    //             $shipment = Shipment::where('bl_number', $bl_number)->where('consignee_name', $user->name)->first();
    //             if ($shipment) {
    //                 // If the user is asking about a shipment, prompt for details
    //                 $conversation[] = $input;
    //                 session(['shipment' => $shipment]);
    //                 $response = 'What details do you want to know about the shipment? You can ask about its shipment status, DO status, Billing status, arrival date, delivery date, entry number, shipping line or item description.';
    //             } else {
    //                 // The BL number was not found in the database
    //                 $response = 'Sorry, I couldn\'t find any shipments with BL number ' . $bl_number . ' under ' . $user->name . '. Please try again.';
    //             }
    //         } elseif ($last_message && $last_message !== 'stop') {
    //             // If the user is inquiring about shipment details, provide a response based on their input
    //             $shipment = session('shipment');
    //             if ($shipment) {
    //                 $conversation[] = $input;
    //                 switch ($input) {
    //                     case 'reset':
    //                         $conversation = [];
    //                         $response = 'Okay, let\'s start over. What BL number are you inquiring about?';
    //                         break;
    //                     case 'stop':
    //                         $response = 'Okay, have a great day!';
    //                         break;
    //                     case 'shipment status':
    //                         $response = 'The current status of this shipment is ' . $shipment->shipment_status . '.';
    //                         $response .= ' Would you like to know more about this shipment? You can also say "reset" or provide another "bl number" to start over or "stop" to end this conversation.';
    //                         break;
    //                     case 'shipment':
    //                         $response = 'The current status of this shipment is ' . $shipment->shipment_status . '.';
    //                         $response .= ' Would you like to know more about this shipment? You can also say "reset" to start over or "stop" to end this conversation.';
    //                         break;
    //                     case 'do status':
    //                         $response = 'The DO status of this shipment is ' . $shipment->do_status . '.';
    //                         $response .= ' Would you like to know more about this shipment? You can also say "reset" or provide another "bl number" to start over or "stop" to end this conversation.';
    //                         break;
    //                     case 'do':
    //                         $response = 'The DO status of this shipment is ' . $shipment->do_status . '.';
    //                         $response .= ' Would you like to know more about this shipment? You can also say "reset" or provide another "bl number" to start over or "stop" to end this conversation.';
    //                         break;
    //                     case 'billing':
    //                         $response = 'The Billing status of this shipment is ' . $shipment->billing_status . '.';
    //                         $response .= ' Would you like to know more about this shipment? You can also say "reset" or provide another "bl number" to start over or "stop" to end this conversation.';
    //                         break;
    //                     case 'billing status':
    //                         $response = 'The Billing status of this shipment is ' . $shipment->billing_status . '.';
    //                         $response .= ' Would you like to know more about this shipment? You can also say "reset" or provide another "bl number" to start over or "stop" to end this conversation.';
    //                         break;
    //                     case 'arrival date':
    //                         $response = 'The Arrival date of this shipment is ' . $shipment->arrival . '.';
    //                         $response .= ' Would you like to know more about this shipment? You can also say "reset" or provide another "bl number" to start over or "stop" to end this conversation.';
    //                         break;
    //                     case 'arrival':
    //                         $response = 'The Arrival date of this shipment is ' . $shipment->arrival . '.';
    //                         $response .= ' Would you like to know more about this shipment? You can also say "reset" or provide another "bl number" to start over or "stop" to end this conversation.';
    //                         break;
    //                     case 'delivery date':
    //                         if ($shipment->predicted_delivery_date !== null) {
    //                             $response = 'The Delivery date of this shipment is ' . $shipment->predicted_delivery_date . '.';
    //                             $response .= ' Would you like to know more about this shipment? You can also say "reset" or provide another "bl number" to start over or "stop" to end this conversation.';
    //                         } else {
    //                             $response = 'The shipment is currently being processed. We will let you know when it will be delivered.';
    //                             $response .= ' Would you like to know more about this shipment? You can also say "reset" or provide another "bl number" to start over or "stop" to end this conversation.';
    //                         }
    //                         break;
    //                     case 'delivery':
    //                         if ($shipment->predicted_delivery_date !== null) {
    //                             $response = 'The Delivery date of this shipment is ' . $shipment->predicted_delivery_date . '.';
    //                             $response .= ' Would you like to know more about this shipment? You can also say "reset" or provide another "bl number" to start over or "stop" to end this conversation.';
    //                         } else {
    //                             $response = 'The shipment is currently being processed. We will let you know when it will be delivered.';
    //                             $response .= ' Would you like to know more about this shipment? You can also say "reset" or provide another "bl number" to start over or "stop" to end this conversation.';
    //                         }
    //                         break;
    //                     case 'entry number':
    //                         $response = 'The Entry number of this shipment is ' . $shipment->entry_number . '.';
    //                         $response .= ' Would you like to know more about this shipment? You can also say "reset" or provide another "bl number" to start over or "stop" to end this conversation.';
    //                         break;
    //                     case 'entry':
    //                         $response = 'The Entry number of this shipment is ' . $shipment->entry_number . '.';
    //                         $response .= ' Would you like to know more about this shipment? You can also say "reset" or provide another "bl number" to start over or "stop" to end this conversation.';
    //                         break;
    //                     case 'shipping line':
    //                         $response = 'This shipment is under ' . $shipment->shipping_line . '.';
    //                         $response .= ' Would you like to know more about this shipment? You can also say "reset" or provide another "bl number" to start over or "stop" to end this conversation.';
    //                         break;
    //                     case 'shipping':
    //                         $response = 'This shipment is under ' . $shipment->shipping_line . '.';
    //                         $response .= ' Would you like to know more about this shipment? You can also say "reset" or provide another "bl number" to start over or "stop" to end this conversation.';
    //                         break;
    //                     case 'description':
    //                         $response =  'Size: ' . $shipment->size . 'Item: ' . $shipment->item_description . ' Weight: ' . $shipment->weight . '.';
    //                         $response .= ' Would you like to know more about this shipment? You can also say "reset" or provide another "bl number" to start over or "stop" to end this conversation.';
    //                         break;
    //                     case 'details':
    //                         $response =  'Size: ' . $shipment->size . 'Item: ' . $shipment->item_description . ' Weight: ' . $shipment->weight . '.';
    //                         $response .= ' Would you like to know more about this shipment? You can also say "reset" or provide another "bl number" to start over or "stop" to end this conversation.';
    //                         break;
    //                     case 'item':
    //                         $response =  'Size: ' . $shipment->size . 'Item: ' . $shipment->item_description . ' Weight: ' . $shipment->weight . '.';
    //                         $response .= ' Would you like to know more about this shipment? You can also say "reset" or provide another "bl number" to start over or "stop" to end this conversation.';
    //                         break;
    //                     default:
    //                         $response = 'Sorry, I didn\'t understand that. You can ask about the shipment\'s status or DO status.';
    //                         break;
    //                 }
    //             } else {
    //                 // The user needs to provide a valid BL number before requesting shipment details
    //                 $response = 'Sorry, I don\'t have any shipments to provide details about. Please provide a BL number.';
    //             }
    //         } else {
    //             // If the user has not provided a valid input, ask them to try again
    //             $response = 'Sorry, I didn\'t understand that. What BL number are you inquiring about?';
    //         }
    //     }
    //     $conversation[] = $input;
    //     session(['conversation' => $conversation]);
    //     return $response;
    // }

    // Sentence


    public function sendChat(Request $request)
    {
        $user = Auth::user();
        $input = preg_replace('/[^a-zA-Z0-9\s]/', '', strtolower($request->input));

        $conversation = session('conversation', []);
        $last_message = end($conversation);

        $keywords = ['reset', 'stop', 'shipment', 'do', 'billing', 'arrival', 'delivery', 'entry', 'shipping', 'details', 'shipment status', 'do status', 'billing status', 'arrival date', 'delivery date', 'entry number', 'shipping line', 'item description'];

        // Start a new conversation if this is the first message or the previous message was a "stop" command
        if (empty($conversation) || $last_message === 'stop') {
            $conversation = [];
            $response = 'Hi, ' . $user->name . '! What BL number are you inquiring about?';
        } else {
            // Check if input matches BL number
            $words = preg_split('/\s+/', $input);
            $bl_number = null;
            foreach ($words as $word) {
                if (preg_match('/(\d+)/', $word)) {
                    $bl_number = $word;
                    break;
                }
            }

            if ($bl_number) {
                $shipment = Shipment::where('bl_number', $bl_number)->where('consignee_name', $user->name)->first();
                if ($shipment) {
                    // If the user is asking about a shipment, prompt for details
                    $conversation[] = $input;
                    session(['shipment' => $shipment]);
                    $response = 'What details do you want to know about the shipment? You can ask about its shipment status, DO status, Billing status, arrival date, delivery date, entry number, shipping line or item description.';
                } else {
                    // The BL number was not found in the database
                    $response = 'Sorry, I couldn\'t find any shipments with BL number ' . $bl_number . ' under ' . $user->name . '. Please try again.';
                }
            } elseif ($last_message && $last_message !== 'stop') {
                // If the user is inquiring about shipment details, provide a response based on their input
                $shipment = session('shipment');
                if ($shipment) {
                    $conversation[] = $input;

                    foreach ($keywords as $keyword) {
                        if (strpos($input, $keyword) !== false) {
                            switch ($keyword) {
                                case 'reset':
                                    $conversation = [];
                                    $response = 'Okay, let\'s start over. What BL number are you inquiring about?';
                                    break;
                                case 'stop':
                                    $response = 'Okay, have a great day!';
                                    break;
                                case 'shipment status':
                                    $response = 'The current status of this shipment is ' . $shipment->shipment_status . '.';
                                    $response .= ' Would you like to know more about this shipment? You can also say "reset" or provide another "bl number" to start over or "stop" to end this conversation.';
                                    break;
                                case 'shipment':
                                    $response = 'The current status of this shipment is ' . $shipment->shipment_status . '.';
                                    $response .= ' Would you like to know more about this shipment? You can also say "reset" to start over or "stop" to end this conversation.';
                                    break;
                                case 'do status':
                                    $response = 'The DO status of this shipment is ' . $shipment->do_status . '.';
                                    $response .= ' Would you like to know more about this shipment? You can also say "reset" or provide another "bl number" to start over or "stop" to end this conversation.';
                                    break;
                                case 'do':
                                    $response = 'The DO status of this shipment is ' . $shipment->do_status . '.';
                                    $response .= ' Would you like to know more about this shipment? You can also say "reset" or provide another "bl number" to start over or "stop" to end this conversation.';
                                    break;
                                case 'billing':
                                    $response = 'The Billing status of this shipment is ' . $shipment->billing_status . '.';
                                    $response .= ' Would you like to know more about this shipment? You can also say "reset" or provide another "bl number" to start over or "stop" to end this conversation.';
                                    break;
                                case 'billing status':
                                    $response = 'The Billing status of this shipment is ' . $shipment->billing_status . '.';
                                    $response .= ' Would you like to know more about this shipment? You can also say "reset" or provide another "bl number" to start over or "stop" to end this conversation.';
                                    break;
                                case 'arrival date':
                                    $response = 'The Arrival date of this shipment is ' . $shipment->arrival . '.';
                                    $response .= ' Would you like to know more about this shipment? You can also say "reset" or provide another "bl number" to start over or "stop" to end this conversation.';
                                    break;
                                case 'arrival':
                                    $response = 'The Arrival date of this shipment is ' . $shipment->arrival . '.';
                                    $response .= ' Would you like to know more about this shipment? You can also say "reset" or provide another "bl number" to start over or "stop" to end this conversation.';
                                    break;
                                case 'delivery date':
                                    if ($shipment->predicted_delivery_date !== null) {
                                        $response = 'The Delivery date of this shipment is ' . $shipment->predicted_delivery_date . '.';
                                        $response .= ' Would you like to know more about this shipment? You can also say "reset" or provide another "bl number" to start over or "stop" to end this conversation.';
                                    } else {
                                        $response = 'The shipment is currently being processed. We will let you know when it will be delivered.';
                                        $response .= ' Would you like to know more about this shipment? You can also say "reset" or provide another "bl number" to start over or "stop" to end this conversation.';
                                    }
                                    break;
                                case 'delivery':
                                    if ($shipment->predicted_delivery_date !== null) {
                                        $response = 'The Delivery date of this shipment is ' . $shipment->predicted_delivery_date . '.';
                                        $response .= ' Would you like to know more about this shipment? You can also say "reset" or provide another "bl number" to start over or "stop" to end this conversation.';
                                    } else {
                                        $response = 'The shipment is currently being processed. We will let you know when it will be delivered.';
                                        $response .= ' Would you like to know more about this shipment? You can also say "reset" or provide another "bl number" to start over or "stop" to end this conversation.';
                                    }
                                    break;
                                case 'entry number':
                                    $response = 'The Entry number of this shipment is ' . $shipment->entry_number . '.';
                                    $response .= ' Would you like to know more about this shipment? You can also say "reset" or provide another "bl number" to start over or "stop" to end this conversation.';
                                    break;
                                case 'entry':
                                    $response = 'The Entry number of this shipment is ' . $shipment->entry_number . '.';
                                    $response .= ' Would you like to know more about this shipment? You can also say "reset" or provide another "bl number" to start over or "stop" to end this conversation.';
                                    break;
                                case 'shipping line':
                                    $response = 'This shipment is under ' . $shipment->shipping_line . '.';
                                    $response .= ' Would you like to know more about this shipment? You can also say "reset" or provide another "bl number" to start over or "stop" to end this conversation.';
                                    break;
                                case 'shipping':
                                    $response = 'This shipment is under ' . $shipment->shipping_line . '.';
                                    $response .= ' Would you like to know more about this shipment? You can also say "reset" or provide another "bl number" to start over or "stop" to end this conversation.';
                                    break;
                                case 'description':
                                    $response =  'Size: ' . $shipment->size . 'Item: ' . $shipment->item_description . ' Weight: ' . $shipment->weight . '.';
                                    $response .= ' Would you like to know more about this shipment? You can also say "reset" or provide another "bl number" to start over or "stop" to end this conversation.';
                                    break;
                                case 'details':
                                    $response =  'Size: ' . $shipment->size . 'Item: ' . $shipment->item_description . ' Weight: ' . $shipment->weight . '.';
                                    $response .= ' Would you like to know more about this shipment? You can also say "reset" or provide another "bl number" to start over or "stop" to end this conversation.';
                                    break;
                                case 'item':
                                    $response =  'Size: ' . $shipment->size . 'Item: ' . $shipment->item_description . ' Weight: ' . $shipment->weight . '.';
                                    $response .= ' Would you like to know more about this shipment? You can also say "reset" or provide another "bl number" to start over or "stop" to end this conversation.';
                                    break;
                                default:
                                    $response = 'Sorry, I didn\'t understand that. You can ask about the shipment\'s status or DO status.';
                                    break;
                            }
                        }
                    }
                } else {
                    // The user needs to provide a valid BL number before requesting shipment details
                    $response = 'Sorry, I don\'t have any shipments to provide details about. Please provide a BL number.';
                }
            } else {
                // If the user has not provided a valid input, ask them to try again
                $response = 'Sorry, I didn\'t understand that. What BL number are you inquiring about?';
            }
        }
        $conversation[] = $input;
        session(['conversation' => $conversation]);
        return $response;
    }

    public function guest_send(Request $request)
    {
        $input = preg_replace('/[^a-zA-Z0-9\s]/', '', strtolower($request->input));

        $response = $this->getResponse($input);

        if (!$response) {
            $response = $this->getGenericResponse();
        }

        return $response;
    }

    private function getResponse($input)
    {
        $words  = [
            'mfa' => ['MFA', 'customs brokerage', 'brokerage'],
            'rate' => ['rate', 'pricing', 'cost'],
            'fees' => ['fees', 'charges', 'costs'],
            'bulk' => ['bulk', 'large quantity', 'massive'],
            'documents' => ['documents', 'papers', 'forms'],
            'contact' => ['contact', 'reach', 'call'],
            'client' => ['client', 'customer', 'importer'],
            'limitations' => ['limitations', 'restrictions', 'issues'],
            'lcl' => ['lcl', 'less-than-container-load', 'loose-cargo'],
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
        ];

        // Check the input sentence or trim the sentence word by word
        $words_in_input = preg_split('/\s+/', $input);

        // Check if any of the words or synonyms are present in the input
        foreach ($words as $word => $synonyms) {
            $rootWord = null;

            // Find the root word that matches the predefined words
            foreach ($words_in_input as $input_word) {
                if (in_array($input_word, $synonyms)) {
                    $rootWord = $word;
                    break;
                }
            }

            if (!is_null($rootWord)) {
                // Generate a random response based on the detected word
                switch ($rootWord) {
                    case 'mfa':
                        $responses = [
                            'MFA Customs Brokerage is a business partner of Sonya Trucking Services.',
                            'MFA Customs Brokerage guarantees the safety and security of the client\'s cargo during transportation.',
                            'MFA Customs Brokerage works with clients to ensure smooth and efficient customs clearance.',
                            'MFA Customs Brokerage provides personalized and reliable logistics solutions for clients.'
                        ];
                        break;
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
                            'Our company, MFA Customs Brokerage, can handle your LCL shipments.',
                            'Need to ship cargo that doesn\'t fill a whole container? MFA Customs Brokerage has got you covered with our LCL services.',
                            'When it comes to LCL shipments, you can trust MFA Customs Brokerage to get the job done right.',
                            'At MFA Customs Brokerage, we specialize in handling LCL shipments for our clients.',
                            'Don\'t let your less-than-container load shipment stress you out. Let MFA Customs Brokerage take care of it for you.',
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
                    case 'damage':
                        $responses = [
                            'After identifying the source of the problem, MFA will assign accountability for any resulting damages.',
                            'MFA will pinpoint the root cause of the issue and then allocate responsibility for any harm caused.',
                            'Determining the origin of the issue is just the first step for MFA; it also assigns liability for any resulting harm.',
                            'Once the cause of the problem has been identified, MFA moves to establish culpability for any damage incurred.',
                            'MFA not only investigates the cause of the issue, but also determines liability for any harm caused as a result.',
                        ];
                        break;
                    case 'storage':
                        $responses = [
                            'We don\'t offer storage or warehousing services for client shipments, it\'s up to the client to arrange for their own.',
                            'Our policy dictates that clients are responsible for their own storage and warehousing needs for their shipments.',
                            'We don\'t have the capability to provide storage or warehousing for client shipments, that falls on the client to organize.',
                            'Our company does not handle storage or warehousing for client shipments, it\'s the client\'s responsibility to arrange for that.',
                            'It\'s the client\'s responsibility to secure their own storage and warehousing for their shipments, we don\'t offer that service.',
                        ];
                        break;
                    case 'tracking':
                        $responses = [
                            'Customers of MFA Customs Brokerage can stay up-to-date with the status of their shipments through the company\'s online platform. The platform provides real-time updates on BOC processing and estimated delivery times.',
                            'With MFA Customs Brokerage\'s website, customers can easily track their shipments and receive updates on their processing status and expected delivery date.',
                            'MFA Customs Brokerage\'s online tracking system allows customers to monitor their shipments in real-time and receive automatic notifications on any changes in the processing or delivery schedule.',
                            'By logging in to MFA Customs Brokerage\'s website, customers gain access to a comprehensive tracking tool that provides detailed information on their shipments\' BOC processing status and delivery date.',
                            'MFA Customs Brokerage\'s website enables customers to keep track of their shipments with ease, providing regular updates on BOC processing and estimated delivery times.',
                        ];
                        break;
                    case 'discounts':
                        $responses = [
                            'MFA Customs Brokerage provides various discounts and promotions based on the shipment type.',
                            'Shipment discounts and promotions are available through MFA Customs Brokerage.',
                            'Depending on your shipment, MFA Customs Brokerage can offer discounts and promotions.',
                            'At MFA Customs Brokerage, promotions and discounts are tailored to your specific shipment.',
                            'Save money on your shipment with MFA Customs Brokerage\'s discounts and promotions.',
                        ];
                        break;
                    case 'weight':
                        $responses = [
                            'Available sizes include bulk, LCL, 1x20, and 1x40, with no weight restrictions.',
                            'Bulk, LCL, 1x20, and 1x40 sizes are available for shipping any weight.',
                            'Whether shipping bulk or just a few items, we\'ve got you covered with LCL, 1x20, and 1x40 options too.',
                            'Shipping any weight is a breeze with bulk, LCL, 1x20, and 1x40 container sizes.',
                            'Get your items where they need to go with bulk, LCL, 1x20, and 1x40 shipping options, no matter the weight.',
                            'Need to ship a heavy load? Our bulk, LCL, 1x20, and 1x40 options can handle any weight.',
                            'From small to large shipments, choose from bulk, LCL, 1x20, and 1x40 container sizes for all weights.',
                        ];
                        break;
                    case 'sizes':
                        $responses = [
                            'For any weight and any size shipment, we offer bulk, LCL, 1x20, and 1x40 shipping options.',
                            'When it comes to shipping, we have the versatility you need with bulk, LCL, 1x20, and 1x40 options for any weight.',
                            'Choose from bulk, LCL, 1x20, and 1x40 container sizes to ship any weight, large or small.',
                            'Our bulk, LCL, 1x20, and 1x40 options make shipping any weight a cinch.',
                            'Whether you need to ship a little or a lot, we have the container sizes you need - bulk, LCL, 1x20, and 1x40 - for any weight.',
                            'Don\'t worry about weight restrictions when you choose our bulk, LCL, 1x20, and 1x40 shipping options.',
                            'Shipping large or small loads is no problem with our bulk, LCL, 1x20, and 1x40 container sizes, accommodating any weight.',
                            'When you need to ship any weight, look no further than our bulk, LCL, 1x20, and 1x40 container options.',
                        ];
                        break;
                }
                $response = $responses[array_rand($responses)];
                return $response;
            }
        }
        return null;
    }

    private function getGenericResponse()
    {
        $responses = [
            'I\'m sorry, but I\'m unable to assist with that particular inquiry. If you have any questions related to customs brokerage or shipment import/export, I\'ll be more than happy to help you out.',
            'It seems like your question isn\'t related to customs brokerage or shipment import/export, which is the expertise of MFA Customs Brokerage. If you have any queries or concerns about customs processes or international trade, feel free to ask.',
            'While I understand your query, it appears to be outside the scope of customs brokerage and shipment import/export, which is the focus of MFA Customs Brokerage. If you have any questions regarding customs procedures or international shipping, I\'m here to provide you with accurate information.',
            'Sorry, that\'s not related to our business. Can I help with customs brokerage or shipment import/export?',
            'I appreciate your question, but it doesn\'t align with the core business of MFA Customs Brokerage, which primarily revolves around customs processes and shipment import/export. If you have any inquiries related to these areas, I\'ll be glad to assist you.',
            'It seems like your question falls outside the purview of MFA Customs Brokerage, which specializes in customs brokerage and shipment import/export. If you need guidance or support regarding customs procedures, documentation, or international logistics, I\'m here to lend a hand.',
            'Not our expertise. Have any questions about customs or international trade?',
            'Out of our scope. Need assistance with customs procedures or international shipping?',
            'Doesn\'t align with our business. Any inquiries about customs or import/export?',
            'Not our focus. Need guidance on customs, documentation, or logistics?',
        ];

        return $responses[array_rand($responses)];
    }
}
