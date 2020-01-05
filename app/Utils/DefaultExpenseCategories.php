<?php

namespace App\Utils;

class DefaultExpenseCategories
{
    private $expenses = [
        ['name' => 'Ăn uống', 'color' => '#6633FF'],
        ['name' => 'Mỹ phẩm', 'color' => '#FF0000'],
    ];
    public function __invoke($user_id)
    {
        foreach ($this->expenses as $index => $expense) {
            $this->expenses[$index]['user_id'] = $user_id;
        }
        return $this->expenses;
    }
}
