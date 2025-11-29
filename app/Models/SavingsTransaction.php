<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SavingsTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'savings_plan_id',
        'user_id',
        'amount',
        'type',
        'date',
        'note',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'date' => 'date',
    ];

    // Relationships
    public function savingsPlan()
    {
        return $this->belongsTo(SavingsPlan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeDeposit($query)
    {
        return $query->where('type', 'deposit');
    }

    public function scopeWithdraw($query)
    {
        return $query->where('type', 'withdraw');
    }

    public function scopeRecent($query, $limit = 10)
    {
        return $query->orderBy('date', 'desc')
                     ->orderBy('created_at', 'desc')
                     ->limit($limit);
    }
}