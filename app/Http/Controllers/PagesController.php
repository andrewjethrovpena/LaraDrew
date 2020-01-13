<?php

namespace App\Http\Controllers;

use DB;
use Excel;
use App\Quotation;
use Hash;
use Redirect;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\expenses;
use App\expense_categories;
use Datatables;
use Session;

use App\Exports\timeExport;
// use Maatwebsite\Excel\Facades\Excel;


class PagesController extends Controller
{
   

	public function login(){
		return view('pages.login');
	}

	public function roleManage(){
		return view('pages.roleManagement');
	}	

	public function userManage(){

		$roleList = Role::where("role_id", "!=", "0")->orderBy('role_name', 'ASC')->get();

		return view('pages.userManagement', compact('roleList'));
	}

	public function expenseCategories(){
		return view('pages.expenseCategory');
	}

	public function expenses(){

		$categoryList = expense_categories::where("category_id", "!=", "0")->orderBy('expense_name', 'ASC')->get();

		return view('pages.expenses', compact('categoryList'));
	}

	public function dashboard(){
		return view('pages.dashboard');
	}

	public function loginProcess(Request $request){

		$username = $request->username;
		$password = $request->password;

		$existUser = User::where('username',$username)->count();

		if ($existUser == 1) {
			$userID = User::where('username',$username)->pluck('user_id')[0];

			$userInfo = User::where('user_id',$userID)->get();
			foreach ($userInfo as $key => $getInfo) {
				# code...
			}

			if(Hash::check($password, $getInfo->password)) {

				Session::put('username', $getInfo->username);
				Session::put('roleID', $getInfo->role_id);
				Session::put('userID', $getInfo->user_id);

				// Session::get('userID')

				return "1";
		        
		    } else {
		    	
		    	return "0";
		    }

		}else{
			return "0";
		}

	}

	public function logout(){
		Session::flush();
		return view('pages.login');
	}

	public function addRoleProcess(Request $request){

		$roleName = $request->roleName;
		$roleDesc = $request->roleDesc;


		$insertRole = new Role;

		$insertRole->role_name = $roleName;
		$insertRole->role_description = $roleDesc;

		$insertRole->save();

		return 1;
	}

	public function showRoleInfo($id){

		$getRole = Role::where('role_id', $id)->get();
		foreach ($getRole as $key => $roleValue) {
			# code...
		}

		return ["roleName" => $roleValue->role_name, "roleDesp" => $roleValue->role_description];

	}

	public function updateRoleProcess(Request $request){

		$roleNameInfo = $request->roleNameInfo;
		$roleDescInfo = $request->roleDescInfo;
		$updateRoleID = $request->updateRoleID;	

		Role::where('role_id',$updateRoleID)->update(array("role_name" => $roleNameInfo, "role_description" => $roleDescInfo));

		return 1;

	}

	public function deleteRole(Request $request){

		$res=Role::where('role_id',$request->roleId)->delete();

		return 1;
	}

	public function getRoleList(){

		$results = Role::orderBy("role_id", "ASC")->get();

		return Datatables($results)
			   	->editColumn('roleName', function ($info) { 
		   			return $info->role_name; 
				})
				->editColumn('roleDescp', function ($info) { 
			   		return $info->role_description; 
				})
				->editColumn('dateCreated', function ($info) { 
			   		return date('Y-m-d', strtotime($info->created_at)); 
				})
				->editColumn('action', function ($info) { 
			   		return "<button class='btn btn-primary' style='background-color:#27ae60; border:#27ae60;' onclick=viewRole(\"".$info->role_id."\");>Update</button>&nbsp;<button class='btn btn-primary' style='background-color:#e74c3c; border:#e74c3c; ' onclick=deleteRole(\"".$info->role_id."\");>Delete</button>"; 
				})
			   	->escapeColumns(null)
				->make(true);
	}

	public function getUserList(){
		
		$results = User::orderBy("name", "ASC")->get();

		return Datatables($results)
		   	->editColumn('name', function ($info) { 
	   			return $info->name; 
			})
			->editColumn('email', function ($info) { 
	   			return $info->email; 
			})
			->editColumn('role', function ($info) { 

				$countRole = Role::where('role_id', $info->role_id)->count();

				if ($countRole != 0) {
					$getRole = Role::where('role_id', $info->role_id)->pluck('role_name')[0];
					return $getRole; 

				}else{
					return "N/A";
				}
		   		
			})
			->editColumn('dateCreated', function ($info) { 
		   		return date('Y-m-d', strtotime($info->created_at)); 
			})
			->editColumn('action', function ($info) { 
		   		return "<button class='btn btn-primary' style='background-color:#27ae60; border:#27ae60;' onclick=viewUser(\"".$info->user_id."\");>Update</button>&nbsp;<button class='btn btn-primary' style='background-color:#e74c3c; border:#e74c3c; ' onclick=deleteUser(\"".$info->user_id."\");>Delete</button>"; 
			})
		   	->escapeColumns(null)
			->make(true);	

	}

	public function addNewUser(Request $request){


		$roleSelect = $request->roleSelect;
		$name = $request->name;
		$username = $request->username;
		$email = $request->email;
		$userDesc = $request->userDesc;
		$password = $request->password;
		$csrfAdd = $request->csrfAdd;

		$createUser = new User;

		$createUser->role_id = $roleSelect;
		$createUser->name = $name;
		$createUser->username = $username;
		$createUser->email = $email;
		$createUser->email_verified_at = NOW();
		$createUser->description = $userDesc;
		$createUser->password = \Hash::make($password);
		$createUser->remember_token = $csrfAdd;

		$createUser->save();

		return 1;

	}

	public function showUserInfo($id){


		$getUserInfo = User::where('user_id', $id)->get();
		foreach ($getUserInfo as $key => $getInfo) {
			# code...
		}

		return ["name" => $getInfo->name, "username" => $getInfo->username, "description" => $getInfo->description, "email" => $getInfo->email];

	}

	public function updateUser(Request $request){


		$updateName = $request->updateName;
		$updateUsername = $request->updateUsername;
		$updateEmail = $request->updateEmail;
		$updateDesc = $request->updateDesc;
		$updatePassword = $request->updatePassword;
		$updateUserID = $request->updateUserID;
		$roleSelectUpdate = $request->roleSelectUpdate;

		if ($updatePassword != "") {
			$updatePassword =  \Hash::make($updatePassword);
		}else{
			$updatePassword = User::where('user_id', $updateUserID)->pluck('password')[0];
		}

		if ($roleSelectUpdate == "") {
			$roleSelectUpdate = User::where('user_id', $updateUserID)->pluck('role_id')[0];
		}

		User::where('user_id', $updateUserID)->update(array("name" => $updateName, "username" => $updateUsername, "email" => $updateEmail, "description" => $updateDesc, "password" => $updatePassword, "role_id" => $roleSelectUpdate));

		return 1;

	}

	public function deleteUser(Request $request){

		$res=User::where('user_id',$request->userId)->delete();

		return 1;

	}

	public function getCategoryList(){

		$results = expense_categories::orderBy("expense_name", "ASC")->get();

		return Datatables($results)
		   	->editColumn('name', function ($info) { 
	   			return $info->expense_name; 
			})
			->editColumn('category', function ($info) { 
	   			return $info->expense_category; 
			})
			->editColumn('dateCreated', function ($info) { 
		   		return date('Y-m-d', strtotime($info->created_at)); 
			})
			->editColumn('action', function ($info) { 
		   		return "<button class='btn btn-primary' style='background-color:#27ae60; border:#27ae60;' onclick=viewCategory(\"".$info->category_id."\");>Update</button>&nbsp;<button class='btn btn-primary' style='background-color:#e74c3c; border:#e74c3c; ' onclick=deleteCategory(\"".$info->category_id."\");>Delete</button>"; 
			})
		   	->escapeColumns(null)
			->make(true);	

	}

	public function addNewCategory(Request $request){

		$createCategory = new expense_categories;

		$createCategory->expense_name = $request->name;
		$createCategory->expense_category =  $request->category;

		$createCategory->save();

		return 1;
	}

	public function showCategInfo($id){

		$categoryList = expense_categories::where('category_id', $id)->get();
		foreach ($categoryList as $key => $expenseInfo) {
			
		}

		return ['name' => $expenseInfo->expense_name, 'category' => $expenseInfo->expense_category];

	}

	public function updateCategory(Request $request){

		$updateCategoryID = $request->updateCategoryID;
		$updateName = $request->updateName;
		$updateCategname = $request->updateCategname;

		expense_categories::where('category_id', $updateCategoryID)->update(array("expense_name" => $updateName, "expense_category" => $updateCategname));

		return 1;


	}

	public function deleteCategory(Request $request){

		$res=expense_categories::where('category_id',$request->categId)->delete();

		return 1;


	}

	public function getExpensesList(){

		$results = expenses::orderBy("transaction_id", "ASC")->get();

		return Datatables($results)
			   	->editColumn('category', function ($info) { 

			   		$countCateg = expense_categories::where('category_id', $info->category_id)->count();

			   		if ($countCateg != 0) {
			   			
			   			return expense_categories::where('category_id', $info->category_id)->pluck('expense_name')[0];

			   		}else{
			   			return "N/a"; 
			   		}

				})
				->editColumn('amount', function ($info) { 
			   		return $info->amount; 
				})
				->editColumn('transDate', function ($info) { 
			   		return date('Y-m-d', strtotime($info->transaction_date)); 
				})
				->editColumn('action', function ($info) { 
			   		return "<button class='btn btn-primary' style='background-color:#27ae60; border:#27ae60;' onclick=viewExpenses(\"".$info->transaction_id."\");>Update</button>&nbsp;<button class='btn btn-primary' style='background-color:#e74c3c; border:#e74c3c; ' onclick=deleteExpenses(\"".$info->transaction_id."\");>Delete</button>"; 
				})
			   	->escapeColumns(null)
				->make(true);

	}

	public function addNewExpenses(Request $request){

		$createExpenses = new expenses;

		$createExpenses->category_id = $request->category;
		$createExpenses->amount = $request->amount;
		$createExpenses->transaction_date = date('Y-m-d', strtotime($request->entryDate));

		$createExpenses->save();

		return 1;
	}

	public function showExpensesInfo($id){

		return expenses::where('transaction_id', $id)->pluck('amount')[0];

	}

	public function updateExpenses(Request $request){

		$updateCategory = $request->updateCategory;
		$updateAmount = $request->updateAmount;
		$updateTransDate = $request->updateTransDate;
		$updateExpenseId = $request->updateExpenseId;

		if ($updateTransDate == "") {
			$updateTransDate = expenses::where('transaction_id', $updateExpenseId)->pluck('transaction_date')[0];
		}else{
			$updateTransDate = date('Y-m-d', strtotime($updateTransDate));
		}

		if ($updateCategory == "") {
			$updateCategory = expenses::where('transaction_id', $updateExpenseId)->pluck('category_id')[0];
		}

		expenses::where('transaction_id', $updateExpenseId)->update(array('amount' => $updateAmount, 'category_id' => $updateCategory, 'transaction_date' => $updateTransDate));

		return 1;

	}

	public function deleteExpenses(Request $request){

		$res=expenses::where('transaction_id',$request->transId)->delete();

		return 1;
	}

	public function pieGraph(){

		$labels = [];
		$points = [];
		$passLabel = [];
		$passAmount = [];

		$countExpenseList = expenses::count();

		$expsensList = expenses::get();
		$count = 0;
		foreach ($expsensList as $key => $info) {
			$passAmount[] = $info->amount;
			$categoryName = expense_categories::where('category_id', $info->category_id)->get();
			foreach ($categoryName as $key => $value) {
				$passLabel[] = $value->expense_name;

			}

			$labels[] = $passLabel[$count];
			$count++;
		}

		return ['labels' => $labels, 'points' => $passAmount];

	}


}
