<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shipment;
use App\Models\FAQ;

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

    // public function sendChat(Request $request)
    // {
    //     $user = Auth::user();
    //     $input = $request->input;

    //     // Find BL Numbers in the database
    //     // Find BL Numbers in the database
    //     if (preg_match('/^\d+$/', $input, $matches)) {
    //         $bl_number = $matches[0];
    //         $shipment = Shipment::where('bl_number', $bl_number)->where('consignee_name', $user->name)->first();
    //         if ($shipment) {
    //             // Prompt the user for more details about the shipment
    //             $response = 'What details would you like to know about shipment ' . $bl_number . '?';
    //             $options = [
    //                 'Shipment Status',
    //                 'DO Status',
    //             ];
    //             $response .= ' [Options: ' . implode(', ', $options) . ']';

    //             // Keep prompting the user for input until they enter "stop" or "reset"
    //             $stop_words = ['stop', 'reset'];
    //             $input = strtolower(trim($input));
    //             while (!in_array($input, $stop_words)) {
    //                 // Generate a response based on the user's input
    //                 switch ($input) {
    //                     case 'shipment status':
    //                         $response = 'The shipment status for shipment ' . $bl_number . ' is ' . $shipment->status;
    //                         break;
    //                     case 'do status':
    //                         $response = 'The DO status for shipment ' . $bl_number . ' is ' . $shipment->do_status;
    //                         break;
    //                     default:
    //                         $response = 'I\'m sorry, I didn\'t understand your input. Please choose one of the available options for shipment ' . $bl_number . '. [Options: ' . implode(', ', $options) . ']';
    //                         break;
    //                 }
    //                 // Prompt the user for more input
    //                 $input = strtolower(trim(fgets(STDIN)));
    //             }
    //             return $response;
    //         } else {
    //             // The BL number was not found in the database
    //             $responses = [
    //                 'Sorry, I couldn\'t find any shipments with BL number ' . $bl_number . ' Under ' . $user->name . ' Shipment list. Please try again.',
    //                 'Unfortunately, there are no shipments matching BL number ' . $bl_number . ' in ' . $user->name . ' Shipment list. Please check your input and try again.',
    //                 'I\'m sorry, I couldn\'t locate any shipments with BL number ' . $bl_number . ' under ' . $user->name . '. Please revise your search and try again.',
    //                 'Regrettably, there are no shipments associated with BL number ' . $bl_number . ' in ' . $user->name . ' Shipment list. Please verify your details and try again.',
    //                 'Apologies, but I couldn\'t find any shipments that match BL number ' . $bl_number . ' for ' . $user->name . '. Please double-check your information and try again.',
    //                 'I regret to inform you that there are no shipments with BL number ' . $bl_number . ' linked to ' . $user->name . ' Shipment list. Please re-enter your query and try again.',
    //             ];
    //             $response = $responses[array_rand($responses)];
    //             return $response;
    //         }
    //     }

    //     // If the input is not related to shipments or company details, prompt a randomly-selected generic response
    //     $responses = [
    //         'I apologize, but I can only answer questions related to MFA company and shipments details. Please try asking a different question.',
    //         'I am not sure I understand your question. Could you please rephrase it in terms of MFA company and shipments details?',
    //         'Unfortunately, I cannot assist you with that. Please ask me a question related to MFA company and shipments details.',
    //         'I am sorry, but I am only able to answer questions related to MFA company and shipments details. Can I help you with anything else?',
    //         'I am designed to answer questions related to MFA shipments and company details. Please try asking me about those topics.',
    //         'That does not seem to be related to MFA company and shipments details. Do you have a question on those topics?'
    //     ];
    //     $response = $responses[array_rand($responses)];
    //     return $response;
    // }

    public function sendChat(Request $request)
    {
        $user = Auth::user();
        $input = strtolower(trim($request->input));

        $conversation = session('conversation', []);
        $last_message = end($conversation);

        // Start a new conversation if this is the first message or the previous message was a "stop" command
        if (empty($conversation) || $last_message === 'stop') {
            $conversation = [];
            $response = 'Hi, ' . $user->name . '! What BL number are you inquiring about?';
        } else {
            // Find BL Numbers in the database
            if (preg_match('/^\d+$/', $input, $matches)) {
                $bl_number = $matches[0];
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
                    switch ($input) {
                        case 'shipment status':
                            $response = 'The current status of this shipment is ' . $shipment->shipment_status . '.';
                            break;
                        case 'shipment':
                            $response = 'The current status of this shipment is ' . $shipment->shipment_status . '.';
                            break;
                        case 'do status':
                            $response = 'The DO status of this shipment is ' . $shipment->do_status . '.';
                            break;
                        case 'do':
                            $response = 'The DO status of this shipment is ' . $shipment->do_status . '.';
                            break;
                        case 'billing':
                            $response = 'The Billing status of this shipment is ' . $shipment->billing_status . '.';
                            break;
                        case 'billing status':
                            $response = 'The Billing status of this shipment is ' . $shipment->billing_status . '.';
                            break;
                        case 'arrival date':
                            $response = 'The Arrival date of this shipment is ' . $shipment->arrival . '.';
                            break;
                        case 'arrival':
                            $response = 'The Arrival date of this shipment is ' . $shipment->arrival . '.';
                            break;
                        case 'delivery date':
                            if ($shipment->predicted_delivery_date !== null) {
                                $response = 'The Delivery date of this shipment is ' . $shipment->predicted_delivery_date . '.';
                            } else {
                                $response = 'The shipment is currently being processed. We will let you know when it will be delivered.';
                            }
                            break;
                        case 'delivery':
                            if ($shipment->predicted_delivery_date !== null) {
                                $response = 'The Delivery date of this shipment is ' . $shipment->predicted_delivery_date . '.';
                            } else {
                                $response = 'The shipment is currently being processed. We will let you know when it will be delivered.';
                            }
                            break;
                        case 'entry number':
                            $response = 'The Entry number of this shipment is ' . $shipment->entry_number . '.';
                            break;
                        case 'entry':
                            $response = 'The Entry numberof this shipment is ' . $shipment->entry_number . '.';
                            break;
                        case 'shipping line':
                            $response = 'This shipment is under ' . $shipment->shipping_line . '.';
                            break;
                        case 'shipping':
                            $response = 'This shipment is under ' . $shipment->shipping_line . '.';
                            break;
                        case 'description':
                            $response =  'Size: ' . $shipment->size . 'Item: ' . $shipment->item_description . ' Weight: ' . $shipment->weight . '.';
                            break;
                        case 'details':
                            $response =  'Size: ' . $shipment->size . 'Item: ' . $shipment->item_description . ' Weight: ' . $shipment->weight . '.';
                            break;
                        case 'item':
                            $response =  'Size: ' . $shipment->size . 'Item: ' . $shipment->item_description . ' Weight: ' . $shipment->weight . '.';
                            break;
                        default:
                            $response = 'Sorry, I didn\'t understand that. You can ask about the shipment\'s status or DO status.';
                            break;
                    }
                    $response .= ' Would you like to know more about this shipment? You can also say "reset" to start over or "stop" to end this conversation.';
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
}
