<?php
// Simple test script to verify registration endpoint

// Include Laravel
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Test 1: Check if User model exists
echo "=== Test 1: User Model ===\n";
try {
    $userModel = new App\Models\User();
    echo "✓ User model loaded\n";
    echo "  Table: " . $userModel->getTable() . "\n";
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}

// Test 2: Check if users table exists and has columns
echo "\n=== Test 2: Database Connection & Users Table ===\n";
try {
    $conn = \Illuminate\Support\Facades\DB::connection();
    echo "✓ Database connected\n";
    
    $columns = \Illuminate\Support\Facades\DB::getSchemaBuilder()->getColumnListing('users');
    echo "✓ Users table exists with columns:\n";
    foreach ($columns as $col) {
        echo "  - $col\n";
    }
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}

// Test 3: Test User creation with hashed password
echo "\n=== Test 3: Test User Creation ===\n";
try {
    $testUser = App\Models\User::create([
        'nama' => 'Test User ' . time(),
        'no_hp' => '0812345' . time() % 10000,  // Unique phone number
        'alamat' => 'Test Address',
        'password' => \Illuminate\Support\Facades\Hash::make('password123'),
        'role' => 'anggota_jamaah',  // Valid enum value
        'face_data' => json_encode([])
    ]);
    echo "✓ Test user created with ID: " . $testUser->id . "\n";
    
    // Delete test user
    $testUser->delete();
    echo "✓ Test user deleted\n";
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}

echo "\n=== All tests completed ===\n";
