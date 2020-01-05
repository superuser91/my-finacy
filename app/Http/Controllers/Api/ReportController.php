<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Income;
use App\Expense;
use App\IncomeCategory;
use App\ExpenseCategory;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function dayDetail(Request $request)
    {
        $date = Carbon::createFromFormat('d/m/Y', $request->date)->toDateString();
        $income = Income::where('date', '=', $date)
            ->where('user_id', '=', Auth::user()->id)
            ->get();
        $expense = Expense::where('date', '=', $date)
            ->where('user_id', '=', Auth::user()->id)
            ->get();
        $datas = [
            'khoanthu' => $income,
            'khoanchi' => $expense
        ];
        return response()->json(['success' => true, 'data' => $datas]);
    }
    public function monthSummary(Request $request)
    {
        $date = Carbon::createFromFormat('d/m/Y', $request->date)->toDateString();
        $startDate = date('Y-m-01', strtotime($date));
        $endDate = date('Y-m-t', strtotime($date));
        $incomes = Income::where('user_id', '=', Auth::user()->id)
            ->where('date', '>=', $startDate)
            ->where('date', '<=', $endDate)
            ->get();
        $expenses = Expense::where('user_id', '=', Auth::user()->id)
            ->where('date', '>=', $startDate)
            ->where('date', '<=', $endDate)
            ->get();
        $datas = [
            'tongthu' => $incomes->sum('amount'),
            'tongchi' => $expenses->sum('amount'),
            'incomes' => $incomes,
            'expenses' => $expenses
        ];
        return response()->json(['success' => true, 'data' => $datas]);
    }
    public function yearIncomeSummary(Request $request, $year)
    {
        $startDate = $year . '-01-01';
        $endDate =  $year . '-12-31';
        $datas = Income::where('user_id', '=', Auth::user()->id)
            ->where('date', '>=', $startDate)
            ->where('date', '<=', $endDate)
            ->select(
                \DB::raw('CAST(sum(amount) as DOUBLE PRECISION) as amount'),
                \DB::raw('EXTRACT(month from date) as month')
            )
            ->groupBy(\DB::raw('EXTRACT(month from date)'))
            ->pluck('amount', 'month');
        for ($i = 0; $i < 12; $i++) {
            $x[$i] =  $datas[$i + 1] ?? 0;
        }
        $data = [
            'labels' => ["T1", "T2", "T3", "T4", "T5", "T6", "T7", "T8", "T9", "T10", "T11", 'T12'],
            'datasets' => [['data' => $x]]
        ];
        return response()->json(['success' => true, 'data' => $data]);
    }
    public function yearExpenseSummary(Request $request)
    {
        $startDate = $request->year . '-01-01';
        $endDate =  $request->year . '-12-31';
        $datas = Expense::where('user_id', '=', Auth::user()->id)
            ->where('date', '>=', $startDate)
            ->where('date', '<=', $endDate)
            ->select(
                \DB::raw('CAST(sum(amount) as DOUBLE PRECISION) as amount'),
                \DB::raw('EXTRACT(month from date) as month')
            )
            ->groupBy(\DB::raw('EXTRACT(month from date)'))
            ->pluck('amount', 'month');
        for ($i = 0; $i < 12; $i++) {
            $x[$i] =  $datas[$i + 1] ?? 0;
        }
        $data = [
            'labels' => ["T1", "T2", "T3", "T4", "T5", "T6", "T7", "T8", "T9", "T10", "T11", 'T12'],
            'datasets' => [['data' => $x]]
        ];
        return response()->json(['success' => true, 'data' => $data]);
    }
    public function incomesReport($year, $month = null)
    {
        if ($month) {
            $startDate = date('Y-m-01', strtotime("{$year}-{$month}-01"));
            $endDate =  date('Y-m-t', strtotime("{$year}-{$month}-01"));
        } else {
            $startDate = "{$year}-01-01";
            $endDate =  "{$year}-12-31";
        }
        $datas = \DB::table('incomes')
            ->join('income_categories', 'income_categories.id', '=', 'incomes.category_id')
            ->where('incomes.user_id', '=', Auth::user()->id)
            ->where('date', '>=', $startDate)
            ->where('date', '<=', $endDate)
            ->select(
                'income_categories.name as name',
                \DB::raw('sum(amount) as population'),
                'income_categories.color'
            )
            ->groupBy(
                'income_categories.color',
                'income_categories.name'
            )
            ->get();
        return response()->json(['success' => true, 'data' => $datas]);
    }
    public function expensesReport($year, $month = null)
    {
        //
        if ($month) {
            $startDate = date('Y-m-01', strtotime("{$year}-{$month}-01"));
            $endDate =  date('Y-m-t', strtotime("{$year}-{$month}-01"));
        } else {
            $startDate = "{$year}-01-01";
            $endDate =  "{$year}-12-31";
        }
        $datas = \DB::table('expenses')
            ->join('expense_categories', 'expense_categories.id', '=', 'expenses.category_id')
            ->where('expenses.user_id', '=', Auth::user()->id)
            ->where('date', '>=', $startDate)
            ->where('date', '<=', $endDate)
            ->select(
                'expense_categories.name as name',
                \DB::raw('sum(amount) as population'),
                'expense_categories.color'
            )
            ->groupBy(
                'expense_categories.color',
                'expense_categories.name'
            )
            ->get();
        return response()->json(['success' => true, 'data' => $datas]);
    }
}
