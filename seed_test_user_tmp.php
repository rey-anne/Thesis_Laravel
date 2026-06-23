<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$u = App\Models\User::updateOrCreate(
    ['email' => 'qa-superadmin@verifyre.test'],
    [
        'role' => 'superadmin',
        'full_name' => 'QA Tester',
        'contact_number' => '0000000000',
        'password' => Illuminate\Support\Facades\Hash::make('QaPass123!'),
        'account_status' => 'active',
        'date_registered' => now(),
    ]
);

echo "Test user id: {$u->id}\n";
