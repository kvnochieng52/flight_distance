<?php

namespace Database\Seeders;

use App\Models\Terms;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TermsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Terms::create([
            'title' => 'Terms and Conditions',
            'content' => '
                <h1>Terms and Conditions for 24 Hour Flight Distance</h1>

                <h2>1. Acceptance of Terms</h2>
                <p>By downloading, installing, or using the 24 Hour Flight Distance application, you agree to be bound by these Terms and Conditions.</p>

                <h2>2. Description of Service</h2>
                <p>24 Hour Flight Distance is a mobile application that provides flight distance calculations and related aviation information services.</p>

                <h2>3. User Registration</h2>
                <p>To access certain features of the app, you must register for an account. You agree to:</p>
                <ul>
                    <li>Provide accurate and complete information</li>
                    <li>Keep your account information updated</li>
                    <li>Maintain the security of your account</li>
                    <li>Accept responsibility for all activities under your account</li>
                </ul>

                <h2>4. Account Approval</h2>
                <p>New user registrations require administrator approval before access is granted. We reserve the right to approve or deny any registration at our discretion.</p>

                <h2>5. Acceptable Use</h2>
                <p>You agree not to use the service for any unlawful purpose or in any way that could damage the service or interfere with other users.</p>

                <h2>6. Privacy</h2>
                <p>Your privacy is important to us. Please review our Privacy Policy to understand how we collect and use your information.</p>

                <h2>7. Disclaimer</h2>
                <p>The information provided by this application is for general informational purposes only. We make no warranties about the accuracy or completeness of the information.</p>

                <h2>8. Changes to Terms</h2>
                <p>We reserve the right to modify these terms at any time. Changes will be effective immediately upon posting within the application.</p>

                <h2>9. Contact Information</h2>
                <p>If you have any questions about these Terms and Conditions, please contact us through the application support channels.</p>

                <p><strong>Last Updated:</strong> ' . now()->format('F j, Y') . '</p>
            ',
            'version' => '1.0',
            'is_active' => true
        ]);
    }
}
