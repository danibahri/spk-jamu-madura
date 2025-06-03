<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;

class Jamu extends Model
{
    protected $fillable = [
        'nama_jamu',
        'kategori',
        'kandungan',
        'harga',
        'khasiat',
        'efek_samping',
        'expired_date',
        'nilai_kandungan',
        'nilai_khasiat',
        'deskripsi',
        'cara_penggunaan',
        'image',
        'is_active'
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'expired_date' => 'date',
        'nilai_kandungan' => 'integer',
        'nilai_khasiat' => 'integer',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    // Accessors
    protected function kandunganArray(): Attribute
    {
        return Attribute::make(
            get: fn() => explode(', ', $this->kandungan)
        );
    }

    protected function isExpired(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->expired_date->isPast()
        );
    }

    protected function expiredStatus(): Attribute
    {
        return Attribute::make(
            get: function () {
                $now = Carbon::now();
                $expiredDate = $this->expired_date;

                if ($expiredDate->isPast()) {
                    return 'expired';
                } elseif ($expiredDate->diffInDays($now) <= 90) {
                    return 'near_expired';
                } else {
                    return 'fresh';
                }
            }
        );
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('kategori', $category);
    }

    public function scopeByPriceRange($query, $minPrice, $maxPrice)
    {
        return $query->whereBetween('harga', [$minPrice, $maxPrice]);
    }

    public function scopeNotExpired($query)
    {
        return $query->where('expired_date', '>', now());
    }

    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('nama_jamu', 'like', "%{$term}%")
                ->orWhere('khasiat', 'like', "%{$term}%")
                ->orWhere('kandungan', 'like', "%{$term}%");
        });
    }

    // Static methods
    public static function getCategories()
    {
        return self::distinct('kategori')->pluck('kategori')->toArray();
    }

    public static function getKandunganList()
    {
        $allKandungan = self::pluck('kandungan')->toArray();
        $kandunganArray = [];

        foreach ($allKandungan as $kandungan) {
            $items = explode(', ', $kandungan);
            $kandunganArray = array_merge($kandunganArray, $items);
        }

        return array_unique($kandunganArray);
    }
}
