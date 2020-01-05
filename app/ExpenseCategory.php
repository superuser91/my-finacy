<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpenseCategory extends Model
{
    use SoftDeletes;
    //
    protected $table = 'expense_categories';
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
