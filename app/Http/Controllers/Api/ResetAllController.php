<?php

namespace App\Http\Controllers\Api;

use App\IncomeCategory;
use App\ExpenseCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Income;
use App\Expense;
use Illuminate\Support\Facades\Auth;
use App\Utils\DefaultIncomeCategories;
use App\Utils\DefaultExpenseCategories;

class ResetAllController extends Controller
{
    public function __invoke()
    {
        try {
            Expense::where('user_id', Auth::user()->id)->delete();
            Income::where('user_id', Auth::user()->id)->delete();
            IncomeCategory::where('user_id', Auth::user()->id)->forceDelete();
            ExpenseCategory::where('user_id', Auth::user()->id)->forceDelete();
            IncomeCategory::insert((new DefaultIncomeCategories)(Auth::user()->id));
            ExpenseCategory::insert((new DefaultExpenseCategories)(Auth::user()->id));
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
