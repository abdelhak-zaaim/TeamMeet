<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class DefaultFaqsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'How does the free trial work?',
                'answer' => 'It\'s free to use for your first five ticket sales. Once your sixth ticket purchase comes through we will start charging the standard PAY rate. If you would like to move to Pre pay then head to "Billing" and "Buy ticket credits".',
                'is_default' => true,
            ],
            [
                'question' => 'How do you weigh different criteria in your process?',
                'answer' => 'That\'s right. We want to make Ticket Tailor as affordable as possible for event organisers of all sizes. You also have the option to pass on any ticketing costs to your customers through a booking fee. We always aim to be the best value on the market so please let us know if you think you can find a similar product for a lower price.',
                'is_default' => true,
            ],
            [
                'question' => 'What does First Round look for in an idea?',
                'answer' => 'Yes, you can add any booking fee you like to the ticket price, which means all your fees are covered and you get to keep the entire face value of the ticket price. You\'re in total control.',
                'is_default' => true,
            ],
            [
                'question' => 'What do you look for in a founding team?',
                'answer' => 'All the subscriptions of that plan will retain to stay unless we explicitly move them to any other plan. The deletion is best a "soft" delete that stops the plan from permitting new subscriptions.',
                'is_default' => true,
            ],
            [
                'question' => 'Do you recommend Pay as you go or Pre pay?',
                'answer' => 'If your event has free tickets then there is no charge to use the platform. If your event has paid for tickets then you can get your customer to absorb the fees via the booking fee - in this instance you will receive the face value of the ticket. Please note that all tickets (free and paid) sold using seating charts will incur a fee.',
                'is_default' => true,
            ],
            [
                'question' => 'Can I pass the fees on to my customers?',
                'answer' => 'We endeavor towards zero downtime, including deployments over weekends. Our development team has broad experience taking care of server versatility and you can lay guaranteed on our capacity to give a very accessible and exceedingly versatile administration. You can check the uptime status of ChargeMonk here.',
                'is_default' => true,
            ],
            [
                'question' => 'How do I get paid for the tickets sold?',
                'answer' => 'As a dealer, you are as yet in charge of chargebacks as the vendor account is possessed by you. ChargeMonk causes you with the correct apparatuses to convey regularly & impart unambiguously to keep away from chargebacks from your customers. Here are some extra resources on how to avoid chargebacks.',
                'is_default' => true,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}
