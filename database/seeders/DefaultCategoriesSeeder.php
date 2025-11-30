<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class DefaultCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $defaultCategories = [
            // Income Categories
            [
                'name' => 'Salary',
                'type' => 'income',
                'icon' => '💰',
                'color' => '#10b981',
                'is_default' => true,
                'user_id' => null,
            ],
            [
                'name' => 'Freelance',
                'type' => 'income',
                'icon' => '💻',
                'color' => '#3b82f6',
                'is_default' => true,
                'user_id' => null,
            ],
            [
                'name' => 'Investment',
                'type' => 'income',
                'icon' => '📈',
                'color' => '#8b5cf6',
                'is_default' => true,
                'user_id' => null,
            ],
            [
                'name' => 'Gift',
                'type' => 'income',
                'icon' => '🎁',
                'color' => '#ec4899',
                'is_default' => true,
                'user_id' => null,
            ],
            
            // Expense Categories
            [
                'name' => 'Food & Dining',
                'type' => 'expense',
                'icon' => '🍔',
                'color' => '#ef4444',
                'is_default' => true,
                'user_id' => null,
            ],
            [
                'name' => 'Transport',
                'type' => 'expense',
                'icon' => '🚗',
                'color' => '#f59e0b',
                'is_default' => true,
                'user_id' => null,
            ],
            [
                'name' => 'Shopping',
                'type' => 'expense',
                'icon' => '🛍️',
                'color' => '#ec4899',
                'is_default' => true,
                'user_id' => null,
            ],
            [
                'name' => 'Entertainment',
                'type' => 'expense',
                'icon' => '🎮',
                'color' => '#8b5cf6',
                'is_default' => true,
                'user_id' => null,
            ],
            [
                'name' => 'Bills & Utilities',
                'type' => 'expense',
                'icon' => '💡',
                'color' => '#eab308',
                'is_default' => true,
                'user_id' => null,
            ],
            [
                'name' => 'Healthcare',
                'type' => 'expense',
                'icon' => '🏥',
                'color' => '#06b6d4',
                'is_default' => true,
                'user_id' => null,
            ],
            [
                'name' => 'Education',
                'type' => 'expense',
                'icon' => '📚',
                'color' => '#3b82f6',
                'is_default' => true,
                'user_id' => null,
            ],
            [
                'name' => 'Subscription',
                'type' => 'expense',
                'icon' => '📱',
                'color' => '#6366f1',
                'is_default' => true,
                'user_id' => null,
            ],
            [
                'name' => 'Cafe & Coffee',
                'type' => 'expense',
                'icon' => '☕',
                'color' => '#78716c',
                'is_default' => true,
                'user_id' => null,
            ],
            [
                'name' => 'Other',
                'type' => 'expense',
                'icon' => '📝',
                'color' => '#64748b',
                'is_default' => true,
                'user_id' => null,
            ],
        ];

        foreach ($defaultCategories as $category) {
            Category::updateOrCreate(
                [
                    'name' => $category['name'],
                    'type' => $category['type'],
                    'is_default' => true,
                ],
                $category
            );
        }
    }
}