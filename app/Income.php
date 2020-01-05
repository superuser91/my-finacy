<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $table = 'incomes';
    protected $fillable = [
        'user_id',
        'category_id',
        'amount',
        'note'
    ];
    protected $with = [
        'category'
    ];

    public function category()
    {
        return $this->belongsTo('App\IncomeCategory', 'category_id', 'id')->withTrashed();;
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
