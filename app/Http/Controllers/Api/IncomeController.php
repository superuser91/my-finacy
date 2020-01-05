<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Income;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class IncomeController extends Controller
{
    public function index(Request $request)
    {
        if (!$request['limit']) {
            $request['limit'] = 10;
        }
        $datas = Income::where('user_id', (Auth::user()->id))->paginate($request['limit']);
        $success['data'] = $datas;
        return response()->json(['success' => $success]);
    }
    public function detail($id)
    {
        $datas = Income::find($id);
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
        $income = new Income();
        $income->user_id = Auth::user()->id;
        $income->category_id = $request->input('category_id');
        $income->amount = $request->input('amount');
        $income->date = $date;
        $income->note = $request->input('note');
        $income->save();
        $success['data'] = $income;
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
            $income =  Income::find($id);
            $income->category_id = $request->input('categoryId');
            $income->amount = $request->input('amount');
            $income->note = $request->input('note');
            $income->date =  $date;
            $income->save();
            $success['data'] = Income::find($id);
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
            Income::find($id)->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
