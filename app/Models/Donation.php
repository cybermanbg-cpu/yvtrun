<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Donation extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'donor_name',
        'email',
        'address',
        'amount',
        'message',
        'is_anonymous',
        'status'
    ];
    
    protected $casts = [
        'amount' => 'decimal:2',
        'is_anonymous' => 'boolean'
    ];
    
    // Само завършените дарения
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
    
    // Обща събрана сума
    public static function getTotalRaised()
    {
        return self::completed()->sum('amount');
    }
    
    // Брой дарители
    public static function getDonorsCount()
    {
        return self::completed()->count();
    }
    
    // Топ дарители
    public static function getTopDonors($limit = 5)
    {
        return self::completed()
            ->orderBy('amount', 'desc')
            ->limit($limit)
            ->get();
    }
    
    // Маркиране като завършено
    public function markAsCompleted()
    {
        $this->update(['status' => 'completed']);
    }
}