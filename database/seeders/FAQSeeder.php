<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FAQ;

class FAQSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faqs = [
            [
                'question' => 'How much is your rate?',
                'answer' => 'The determination of the rate is contingent upon specific shipment details, including but not limited to the number of items, sizes, and contents. Such rate is typically discussed and agreed upon in a meeting involving MFA and the consignee.',
            ], [
                'question' => 'What are some of the fees that will be shouldered by the client?',
                'answer' => 'Import duties, excise tax, administrative costs for documentary custom stamps, fines and penalties, permit fees, registration fees, clearance fees, inspection fees, and processing expenses were typically handled by an importer in BOC. Additionally, there are fees for shipping lines, trucks, and brokers.',
            ], [
                'question' => 'Do you also handle bulk cargoes?',
                'answer' => 'Yes, MFA Customs Brokerage handles bulk cargoes.',
            ], [
                'question' => 'What are the necessary documents for importation?',
                'answer' => 'The following documents were required for importation: a BL (Bill of Lading), an invoice, a packing list, payment documentation, AFTA, and marine insurance.',
            ], [
                'question' => 'How can I contact MFA personnel?',
                'answer' => 'You may reach MFA Customs Brokerage at (82887706) or (9177033799).',
            ], [
                'question' => 'What do I need to become a client of MFA?',
                'answer' => 'To become a client of MFA, you need to submit the necessary paperwork to complete your registration as an importer with BOC. You also need to have a meeting with the MFA manager to discuss all the details of becoming a customer. You can contact MFA through various channels, including sending an email to mfabrokerage@gmail.com, calling (82887706) or (9177033799), or submitting a form through the Contact Us page on this website. (Please insert the actual link of the website Contact Us page).',
            ], [
                'question' => 'What are the limitations in sending or delivering packages?',
                'answer' => 'There are several limitations in sending or delivering packages, such as delays caused by the customer\'s delay in paying the BOC fees required for the release of the shipment, incomplete or missing documents from the clients, and slow processing of delivery orders by shipping companies. These are just some examples of the reasons that can cause delays or limitations in the shipping and delivery of packages.',
            ], [
                'question' => 'Does MFA handle loose cargo (LCL)?',
                'answer' => 'Yes, MFA Customs Brokerage handles LCL.
                LCL (Less-than-Container Load) refers to shipping cargo that doesn\'t fill an entire shipping container, so it is typically combined with other cargo to fill the container.',
            ], [
                'question' => 'Can you tell me the length of the contract between MFA and its clients?',
                'answer' => 'The term typically ends when the importer\'s contract in BOC end, the client needs to comply with all required documents to renew their importation.',
            ], [
                'question' => 'What is the range of MFA\'s trucking fees?',
                'answer' => 'The range of the trucking fees depends on the shipment details, such as the weight, size, content, and distance. ',
            ], [
                'question' => 'How does MFA ensure the safety and security of the cargo during transportation?',
                'answer' => 'MFA Customs Brokerage is affiliated with Sonya Trucking Services as a business partner, where the delivery trucking service is irrevocable, and the aforementioned partner is bound by a contractual obligation with MFA to guarantee the safety and security of the client\'s cargo during transportation.',
            ], [
                'question' => 'How does MFA handle shipment delays or damages?',
                'answer' => 'MFA responds to these situations by first determining why the shipment is being delayed or, in some cases, damaged. Once MFA has determined the cause, MFA will determine who is responsible for those situations.',
            ], [
                'question' => 'Can MFA provide storage and warehousing services?',
                'answer' => 'No, unfortunately only client can provide their own storage and warehousing for their shipment.',
            ], [
                'question' => 'What are the options for tracking the status of a shipment with MFA?',
                'answer' => 'MFA Customs Brokerage offers a website where customers can log in and track their shipments. The tracking of shipments is limited to updates on the BOC processing status and the predicted delivery date.',
            ], [
                'question' => 'Does MFA offer any discounts or promotions for long-term clients or high-volume shipments?',
                'answer' => 'Yes, MFA Customs Brokerage offers discounts and promotions depending on the shipment. ',
            ], [
                'question' => 'What are the weight and size limitations for cargo handled by MFA?',
                'answer' => 'The sizes are bulk, LCL, 1x20, and 1x40. The weight required is any weight.',
            ],
        ];

        foreach ($faqs as $faq) {
            FAQ::create($faq);
        }
    }
}
