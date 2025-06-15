<?php

namespace App\Services;

use App\Models\Jamu;
use Carbon\Carbon;

class SmartAlgorithmService
{
    /**
     * Calculate SMART algorithm for jamu recommendation
     */
    public function calculateSmart($jamus, $weights, $filters = [])
    {
        $results = [];

        foreach ($jamus as $jamu) {
            $score = $this->calculateJamuScore($jamu, $weights);
            $results[] = [
                'jamu' => $jamu,
                'score' => $score,
                'normalized_scores' => $this->getNormalizedScores($jamu, $weights)
            ];
        }

        // Sort by score descending
        usort($results, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        return $results;
    }
    /**
     * Calculate individual jamu score
     */
    public function calculateJamuScore($jamu, $weights)
    {
        $kandunganScore = $this->normalizeKandungan($jamu->nilai_kandungan);
        $khasiatScore = $this->normalizeKhasiat($jamu->nilai_khasiat);
        $hargaScore = $this->normalizeHarga($jamu->harga);
        $expiredScore = $this->normalizeExpired($jamu->expired_date);

        $totalScore = (
            ($kandunganScore * $weights['kandungan']) +
            ($khasiatScore * $weights['khasiat']) +
            ($hargaScore * $weights['harga']) +
            ($expiredScore * $weights['expired'])
        );

        return round($totalScore, 4);
    }
    /**
     * Get normalized scores for each criteria
     */
    public function getNormalizedScores($jamu, $weights)
    {
        return [
            'kandungan' => $this->normalizeKandungan($jamu->nilai_kandungan),
            'khasiat' => $this->normalizeKhasiat($jamu->nilai_khasiat),
            'harga' => $this->normalizeHarga($jamu->harga),
            'expired' => $this->normalizeExpired($jamu->expired_date)
        ];
    }

    /**
     * Normalize kandungan value (1-5 scale)
     */
    private function normalizeKandungan($value)
    {
        // Higher kandungan value is better
        return $value / 100;
    }

    /**
     * Normalize khasiat value (1-5 scale)
     */
    private function normalizeKhasiat($value)
    {
        // Higher khasiat value is better
        return $value / 100;
    }

    /**
     * Normalize harga value (lower is better)
     */
    private function normalizeHarga($price)
    {
        $minPrice = 10000; // Minimum expected price
        $maxPrice = 100000; // Maximum expected price

        // Invert the scale (lower price = higher score)
        $normalized = ($maxPrice - $price) / ($maxPrice - $minPrice);

        return max(0, min(1, $normalized));
    }

    /**
     * Normalize expired date (further expiry is better)
     */
    private function normalizeExpired($expiredDate)
    {
        $now = Carbon::now();
        $expiry = Carbon::parse($expiredDate);

        if ($expiry->isPast()) {
            return 0; // Expired products get 0 score
        }

        $daysToExpiry = $now->diffInDays($expiry);
        $maxDays = 365 * 2; // 2 years maximum

        return min(1, $daysToExpiry / $maxDays);
    }

    /**
     * Apply filters to jamu collection
     */
    public function applyFilters($query, $filters)
    {
        if (!empty($filters['category'])) {
            $query->where('kategori', $filters['category']);
        }

        if (!empty($filters['min_price'])) {
            $query->where('harga', '>=', $filters['min_price']);
        }

        if (!empty($filters['max_price'])) {
            $query->where('harga', '<=', $filters['max_price']);
        }

        if (!empty($filters['kandungan'])) {
            foreach ($filters['kandungan'] as $ingredient) {
                $query->where('kandungan', 'like', "%{$ingredient}%");
            }
        }

        if (!empty($filters['exclude_ingredients'])) {
            foreach ($filters['exclude_ingredients'] as $ingredient) {
                $query->where('kandungan', 'not like', "%{$ingredient}%");
            }
        }

        if (!empty($filters['khasiat'])) {
            $query->where('khasiat', 'like', "%{$filters['khasiat']}%");
        }

        // Exclude expired products by default
        if (!isset($filters['include_expired']) || !$filters['include_expired']) {
            $query->where('expired_date', '>', now());
        }

        return $query->active();
    }

    /**
     * Get default weights for criteria
     */
    public function getDefaultWeights()
    {
        return [
            'kandungan' => 0.25,
            'khasiat' => 0.30,
            'harga' => 0.20,
            'expired' => 0.25
        ];
    }
    /**
     * Validate weights (must sum to 1.0)
     */
    public function validateWeights($weights)
    {
        $sum = array_sum($weights);
        return abs($sum - 1.0) < 0.01; // Allow small floating point differences
    }

    /**
     * Normalize weights to sum to 1.0
     */
    public function normalizeWeights($weights)
    {
        // Convert percentage values (0-100) to decimal (0-1)
        $weights = array_map(function ($weight) {
            return $weight / 100;
        }, $weights);

        $sum = array_sum($weights);

        if ($sum == 0) {
            return $this->getDefaultWeights();
        }

        return array_map(function ($weight) use ($sum) {
            return $weight / $sum;
        }, $weights);
    }
}
