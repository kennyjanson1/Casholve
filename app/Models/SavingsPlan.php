<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SavingsPlan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'target_amount',
        'current_amount',
        'deadline',
        'status',
    ];

    protected $casts = [
        'target_amount' => 'decimal:2',
        'current_amount' => 'decimal:2',
        'deadline' => 'date',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function savingsTransactions()
    {
        return $this->hasMany(SavingsTransaction::class);
    }

    // Accessors
    public function getProgressPercentageAttribute()
    {
        if ($this->target_amount == 0) return 0;
        return min(($this->current_amount / $this->target_amount) * 100, 100);
    }

    public function getRemainingAmountAttribute()
    {
        return max($this->target_amount - $this->current_amount, 0);
    }

    public function getIsCompletedAttribute()
    {
        return $this->current_amount >= $this->target_amount;
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', 'active')
                     ->where('deadline', '<', now())
                     ->where('current_amount', '<', 'target_amount');
    }
}