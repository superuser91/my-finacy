<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\IncomeCategory;
use Illuminate\Support\Facades\Auth;

class IncomeCategoryController extends Controller
{
    public function index()
    {
        $categories = IncomeCategory::where('user_id', Auth::user()->id)
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
            $category = new IncomeCategory;
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
                'color' => 'string|max:45',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 401);
            }
            $category = IncomeCategory::find($id);
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
            IncomeCategory::find($id)->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }
}
