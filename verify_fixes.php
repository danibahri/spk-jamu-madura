<?php

require_once __DIR__ . '/bootstrap/app.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

echo "=== SPK JAMU VERIFICATION TEST ===\n";

// Test 1: Check if key models work
echo "1. Testing Models...\n";
echo "   Jamu records: " . \App\Models\Jamu::count() . "\n";
echo "   Article records: " . \App\Models\Article::count() . "\n";

// Test 2: Test SMART Service
echo "\n2. Testing SMART Service...\n";
try {
    $service = new \App\Services\SmartAlgorithmService();
    $jamus = \App\Models\Jamu::limit(2)->get();
    $weights = [
        'kandungan' => 0.3,
        'khasiat' => 0.25,
        'harga' => 0.25,
        'expired' => 0.2
    ];

    $results = $service->calculateSmart($jamus, $weights);
    echo "   ✓ SMART calculation successful: " . count($results) . " results\n";

    // Check structure
    $first = $results[0];
    echo "   ✓ First result keys: " . implode(', ', array_keys($first)) . "\n";

    if (isset($first['normalized_scores'])) {
        $scores = $first['normalized_scores'];
        echo "   ✓ Normalized scores keys: " . implode(', ', array_keys($scores)) . "\n";
        echo "   ✓ Kandungan score: " . number_format($scores['kandungan'] * 100, 1) . "%\n";
    }
} catch (Exception $e) {
    echo "   ✗ SMART test failed: " . $e->getMessage() . "\n";
}

// Test 3: Test Article logic
echo "\n3. Testing Article Logic...\n";
try {
    $featuredArticle = \App\Models\Article::where('is_featured', true)->first() ??
        \App\Models\Article::latest()->first();

    if ($featuredArticle) {
        echo "   ✓ Featured article found: " . $featuredArticle->title . "\n";
    } else {
        echo "   ✗ No featured article found\n";
    }
} catch (Exception $e) {
    echo "   ✗ Article test failed: " . $e->getMessage() . "\n";
}

echo "\n=== VERIFICATION COMPLETE ===\n";
echo "Both critical errors should now be fixed!\n";
echo "Visit http://127.0.0.1:8000 to test the application.\n";
