<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'avatar',
        'initial_balance',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'initial_balance' => 'decimal:2',
    ];

    // Relationships
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function savingsPlans()
    {
        return $this->hasMany(SavingsPlan::class);
    }

    public function savingsTransactions()
    {
        return $this->hasMany(SavingsTransaction::class);
    }

    // Helper Methods
    public function getTotalIncomeAttribute()
    {
        return $this->transactions()
            ->where('type', 'income')
            ->sum('amount');
    }

    public function getTotalExpenseAttribute()
    {
        return $this->transactions()
            ->where('type', 'expense')
            ->sum('amount');
    }

    public function getCurrentBalanceAttribute()
    {
        return $this->initial_balance + $this->total_income - $this->total_expense;
    }
}