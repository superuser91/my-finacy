<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Expense;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        if (!$request['limit']) {
            $request['limit'] = 10;
        }
        $datas = Expense::where('user_id', (Auth::user()->id))->paginate($request['limit']);
        $success['data'] = $datas;
        return response()->json(['success' => $success]);
    }
    public function detail($id)
    {
        $datas = Expense::find($id);
        $success['data'] = $datas;
        return response()->json(['success' => $success]);
    }
    public function store(Request $request)
    {
        $validator = \Validator::make((array) $request->all(), [
            'category_id' => 'required',
            'amount' => 'required',
            'date' => 'required',
            'note' => 'string|max:120'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $date = Carbon::createFromFormat('d/m/Y', $request->input('date'))->toDateString();
        $expense = new Expense();
        $expense->user_id = Auth::user()->id;
        $expense->category_id = $request->input('category_id');
        $expense->amount = $request->input('amount');
        $expense->date = $date;
        $expense->note = $request->input('note');
        $expense->save();
        $success['data'] = $expense;
        return response()->json(['success' => $success]);
    }
    public function edit(Request $request, $id)
    {
        try {
            $validator = \Validator::make((array) $request->all(), [
                'categoryId' => 'required',
                'date' => 'required',
                'note' => 'string|max:45',
                'amount' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 401);
            }
            $date = Carbon::createFromFormat('d/m/Y', $request->input('date'))->toDateString();
            $expense =  Expense::find($id);
            $expense->category_id = $request->input('categoryId');
            $expense->amount = $request->input('amount');
            $expense->note = $request->input('note');
            $expense->date =  $date;
            $expense->save();
            $success['data'] = Expense::find($id);
            return response()->json(['success' => $success]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage()
            ]);
        }
    }
    public function destroy($id)
    {
        try {
            Expense::find($id)->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
