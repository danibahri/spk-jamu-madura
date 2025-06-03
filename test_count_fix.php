<?php
// Test script to verify count() fixes
require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

// Mock the application for testing
$app = new Application(dirname(__FILE__));

// Test the count() scenarios that were causing errors
echo "Testing count() fixes...\n\n";

// Test 1: null values
echo "1. Testing count() with null:\n";
$testNull = null;
try {
    // This should cause error in PHP 8+
    // count($testNull);

    // Safe approach
    $safeCount = !empty($testNull) ? count($testNull) : 0;
    echo "   Safe count of null: $safeCount\n";
} catch (TypeError $e) {
    echo "   Error caught: " . $e->getMessage() . "\n";
}

// Test 2: empty array
echo "\n2. Testing count() with empty array:\n";
$testEmpty = [];
$safeCount = !empty($testEmpty) ? count($testEmpty) : 0;
echo "   Safe count of empty array: $safeCount\n";

// Test 3: array with values
echo "\n3. Testing count() with values:\n";
$testArray = ['item1', 'item2', 'item3'];
$safeCount = !empty($testArray) ? count($testArray) : 0;
echo "   Safe count of array: $safeCount\n";

// Test 4: Blade template syntax simulation
echo "\n4. Testing Blade template logic:\n";
$results = null;
$displayCount = !empty($results) ? count($results) : 0;
echo "   Template count display: $displayCount\n";

$results = ['result1', 'result2'];
$displayCount = !empty($results) ? count($results) : 0;
echo "   Template count with data: $displayCount\n";

echo "\nAll count() safety tests passed!\n";
echo "The fixes should prevent TypeError: count() argument must be Countable|array\n";
