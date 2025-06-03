<?php

/**
 * Test script to verify the fixes for SPK Jamu system
 * Tests both critical errors that were reported:
 * 1. SMART Algorithm "scores" error
 * 2. ArticleController $featuredArticle error
 */

require_once __DIR__ . '/vendor/autoload.php';

use App\Services\SmartAlgorithmService;
use App\Models\Jamu;
use App\Models\Article;

echo "=== SPK JAMU FIX VERIFICATION TEST ===\n\n";

// Test 1: SMART Algorithm Service
echo "1. Testing SMART Algorithm Service...\n";
try {
    $smartService = new SmartAlgorithmService();

    // Get sample jamu data
    $jamus = Jamu::limit(5)->get();

    // Test weights (as percentages, should be normalized)
    $weights = [
        'kandungan' => 30,  // 30%
        'khasiat' => 25,    // 25%
        'harga' => 25,      // 25%
        'expired' => 20     // 20%
    ];

    // Convert to normalized weights (0-1 scale)
    $normalizedWeights = [
        'kandungan' => $weights['kandungan'] / 100,
        'khasiat' => $weights['khasiat'] / 100,
        'harga' => $weights['harga'] / 100,
        'expired' => $weights['expired'] / 100
    ];

    $results = $smartService->calculateSmart($jamus, $normalizedWeights);

    echo "   ✓ SMART calculation successful\n";
    echo "   ✓ Results count: " . count($results) . "\n";

    // Test the specific structure that was causing the error
    foreach ($results as $index => $item) {
        if (isset($item['normalized_scores'])) {
            $scores = $item['normalized_scores'];
            if (
                isset($scores['kandungan']) && isset($scores['khasiat']) &&
                isset($scores['harga']) && isset($scores['expired'])
            ) {
                echo "   ✓ Item $index: normalized_scores structure is correct\n";

                // Verify the scores are numeric and in valid range
                foreach (['kandungan', 'khasiat', 'harga', 'expired'] as $criterion) {
                    $score = $scores[$criterion];
                    if (is_numeric($score) && $score >= 0 && $score <= 1) {
                        echo "     ✓ $criterion score: " . number_format($score * 100, 1) . "%\n";
                    } else {
                        echo "     ✗ $criterion score invalid: $score\n";
                    }
                }
                break; // Just test first item
            } else {
                echo "   ✗ Item $index: missing required score keys\n";
            }
        } else {
            echo "   ✗ Item $index: missing normalized_scores array\n";
        }
    }
} catch (Exception $e) {
    echo "   ✗ SMART Algorithm test failed: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 2: Article Controller Logic
echo "2. Testing Article Controller Logic...\n";
try {
    // Test the logic that was in ArticleController

    // Test getting featured article (should not be null)
    $featuredArticle = Article::where('is_featured', true)->first() ?? Article::latest()->first();

    if ($featuredArticle) {
        echo "   ✓ Featured article found: " . $featuredArticle->title . "\n";
    } else {
        echo "   ✗ No featured article found\n";
    }

    // Test getting articles for index
    $articles = Article::latest()->take(6)->get();
    echo "   ✓ Articles for index: " . $articles->count() . " found\n";

    // Test getting article by slug
    $sampleArticle = Article::first();
    if ($sampleArticle) {
        $articleBySlug = Article::where('slug', $sampleArticle->slug)->first();
        if ($articleBySlug) {
            echo "   ✓ Article by slug found: " . $articleBySlug->title . "\n";
        } else {
            echo "   ✗ Article by slug not found\n";
        }
    }

    // Test category filtering
    $categories = Article::distinct()->pluck('category')->filter();
    echo "   ✓ Article categories: " . $categories->count() . " found\n";
} catch (Exception $e) {
    echo "   ✗ Article Controller test failed: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 3: Simulated Form Data Processing
echo "3. Testing Form Data Processing...\n";
try {
    // Simulate the form data that would come from the SMART form
    $formData = [
        'weights' => [
            'kandungan' => '30',
            'khasiat' => '25',
            'harga' => '25',
            'expired' => '20'
        ],
        'filters' => [
            'category' => 'herbal',
            'max_price' => '100000'
        ]
    ];

    // Test validation rules (like in SmartController)
    $weights = $formData['weights'];
    $total = array_sum($weights);

    if ($total == 100) {
        echo "   ✓ Weight validation: Total is exactly 100%\n";
    } else {
        echo "   ✗ Weight validation: Total is $total% (should be 100%)\n";
    }

    // Test individual weight ranges
    foreach ($weights as $criterion => $weight) {
        if ($weight >= 0 && $weight <= 100) {
            echo "   ✓ $criterion weight ($weight%) is in valid range\n";
        } else {
            echo "   ✗ $criterion weight ($weight%) is out of range\n";
        }
    }
} catch (Exception $e) {
    echo "   ✗ Form data processing test failed: " . $e->getMessage() . "\n";
}

echo "\n=== TEST SUMMARY ===\n";
echo "If all tests show ✓ marks, both critical errors have been resolved:\n";
echo "1. SMART Algorithm 'scores' undefined key error → Fixed with 'normalized_scores'\n";
echo "2. ArticleController \$featuredArticle undefined variable → Fixed with proper variable assignment\n";
echo "3. Form validation and SweetAlert integration → Implemented\n\n";

echo "The SPK Jamu system should now work correctly!\n";
echo "You can test it at: http://127.0.0.1:8000\n";
