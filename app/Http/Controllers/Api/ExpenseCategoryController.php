<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\IncomeCategory;
use App\ExpenseCategory;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ExpenseCategoryController extends Controller
{
    public function index()
    {
        $categories = ExpenseCategory::where('user_id', Auth::user()->id)
            ->get();
        return response()->json([
            'categories' => $categories
        ]);
    }

    public function create(Request $request)
    {
        try {
            $validator = \Validator::make($request->all(), [
                'name' => 'required|string|max:256',
                'description' => 'string|max:256',
                'color' => 'string|max:45',
                'icon' => 'string|max:45'
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 401);
            }
            $category = new ExpenseCategory;
            $category->name = $request->input('name');
            $category->color = $request->input('color');
            $category->user_id = Auth::user()->id;
            $category->save();
            return response()->json([
                'success' => true,
                'category' => $category
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => $e->getMessage()
            ]);
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            $validator = \Validator::make($request->all(), [
                'name' => 'required|string|max:256',
                'color' => 'required|string|max:45',
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 401);
            }
            $category = ExpenseCategory::find($id);
            $category->name = $request->input('name');
            $category->color = $request->input('color');
            $category->save();
            return response()->json([
                'success' => true,
                'category' => $category
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }
    public function destroy($id)
    {
        try {
            ExpenseCategory::find($id)->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }
}
