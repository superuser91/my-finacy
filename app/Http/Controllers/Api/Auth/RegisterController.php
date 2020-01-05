<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\ExpenseCategory;
use App\IncomeCategory;
use App\Utils\DefaultExpenseCategories;
use App\Utils\DefaultIncomeCategories;
use DB;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|max:32',
            'c_password' => 'required|same:password'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        DB::beginTransaction();
        $user = User::create($input);
        try {
            IncomeCategory::insert((new DefaultIncomeCategories)($user->id));
            ExpenseCategory::insert((new DefaultExpenseCategories)($user->id));
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['infomation'] =  $user;
        DB::commit();
        return response()->json(['success' => $success], 200);
    }
}
