<?php

namespace App\Utils;

class DefaultIncomeCategories
{
    private $incomes = [
        ['name' => 'Tiền Lương', 'color' => '#66FFFF'],
        ['name' => 'Tiền Thưởng', 'color' => '#FF3333'],
        ['name' => 'Trợ Cấp', 'color' => '#330066'],
    ];
    public function __invoke($user_id)
    {
        foreach ($this->incomes as $index => $income) {
            $this->incomes[$index]['user_id'] = $user_id;
        }
        return $this->incomes;
    }
}
