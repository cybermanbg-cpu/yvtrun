<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Volunteer extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'role',
        'phone',
        'time_slot',
        'checkpoint_location',
        'confirmed'
    ];
    
    protected $casts = [
        'confirmed' => 'boolean'
    ];
    
    // Възможни роли
    public static function getRoles()
    {
        return [
            'food_water' => '🍎 Храна и вода',
            'driver' => '🚐 Шофьор/Мобилен щаб',
            'live_operator' => '📸 Лайв оператор',
            'escort' => '🚴‍♂️ Ескорт с велосипед',
            'medical' => '🩺 Медицинско лице',
            'photographer' => '📷 Фотограф'
        ];
    }
    
    // Връща човешкия прочит на ролята
    public function getRoleNameAttribute()
    {
        return self::getRoles()[$this->role] ?? $this->role;
    }
    
    // Само потвърдените доброволци
    public function scopeConfirmed($query)
    {
        return $query->where('confirmed', true);
    }
    
    // Групиране по роли
    public static function getGroupedByRole()
    {
        return self::confirmed()->get()->groupBy('role');
    }
}