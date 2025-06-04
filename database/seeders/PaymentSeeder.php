<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $payments = [
            [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'description' => 'Monthly subscription payment for premium service',
                'amount' => 99.99,
                'currency' => 'USD',
                'is_paid' => true,
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'description' => 'One-time purchase for digital product',
                'amount' => 49.99,
                'currency' => 'USD',
                'is_paid' => false,
            ],
            [
                'name' => 'Bob Johnson',
                'email' => 'bob.johnson@example.com',
                'description' => 'Annual membership fee',
                'amount' => 299.99,
                'currency' => 'USD',
                'is_paid' => true,
            ],
            [
                'name' => 'Alice Brown',
                'email' => 'alice.brown@example.com',
                'description' => 'Consultation service payment',
                'amount' => 150.00,
                'currency' => 'EUR',
                'is_paid' => false,
            ],
            [
                'name' => 'Charlie Wilson',
                'email' => 'charlie.wilson@example.com',
                'description' => 'Software license renewal',
                'amount' => 199.99,
                'currency' => 'GBP',
                'is_paid' => true,
            ],
        ];

        foreach ($payments as $payment) {
            Payment::create($payment);
        }
    }
}