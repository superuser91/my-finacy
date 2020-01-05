<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IncomeCategory extends Model
{
    use SoftDeletes;
    //
    protected $table = 'income_categories';
    protected $fillable = [
        'name',
        'description',
        'color'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'user_id'
    ];
    protected $dates = ['deleted_at'];
}
