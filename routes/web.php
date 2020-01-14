<?php

date_default_timezone_set('Asia/Manila');

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

//Login
Route::get('/login', 'PagesController@login')->name('login');
Route::get('/', 'PagesController@login')->name('login');


//Dashboard
Route::get('/dashboard', 'PagesController@dashboard')->name('dashboard');
Route::get('/pieGraph', 'PagesController@pieGraph')->name('pieGraph');

//Role Get
Route::get('/roleManage', 'PagesController@roleManage')->name('roleManage');
Route::get('/roleManage/getRoleList', 'PagesController@getRoleList')->name('roleManage.getRoleList');	
Route::get('/roleManage/{id}', 'PagesController@showRoleInfo')->name('roleManage.showRoleInfo');

//User Get
Route::get('/userManage', 'PagesController@userManage')->name('userManage');
Route::get('/userManage/getUserList', 'PagesController@getUserList')->name('userManage.getUserList');
Route::get('/userManage/{id}', 'PagesController@showUserInfo')->name('userManage.showUserInfo');

//Expense Category Get
Route::get('/expenseCategories', 'PagesController@expenseCategories')->name('expenseCategories');
Route::get('/expenseCategories/getCategoryList', 'PagesController@getCategoryList')->name('expenseCategories.getCategoryList');
Route::get('/expenseCategories/{id}', 'PagesController@showCategInfo')->name('expenseCategories.showCategInfo');

//Expenses Get
Route::get('/expenses', 'PagesController@expenses')->name('expenses');
Route::get('/expenses/getExpensesList', 'PagesController@getExpensesList')->name('expenses.getExpensesList');
Route::get('/expenses/{id}', 'PagesController@showExpensesInfo')->name('expenses.showExpensesInfo');

// SUBMIT POST

Route::post('/loginProcess', 'PagesController@loginProcess')->name('loginProcess');

//Role Post
Route::post('/addRoleProcess', 'PagesController@addRoleProcess')->name('addRoleProcess');
Route::post('/updateRoleProcess', 'PagesController@updateRoleProcess')->name('updateRoleProcess');
Route::post('/deleteRole', 'PagesController@deleteRole')->name('deleteRole');

//User Post

Route::post('/addNewUser', 'PagesController@addNewUser')->name('addNewUser');
Route::post('/updateUserProcess', 'PagesController@updateUser')->name('updateUser');
Route::post('/deleteUser', 'PagesController@deleteUser')->name('deleteUser');


//Expense Category Post

Route::post('/addNewCategory', 'PagesController@addNewCategory')->name('addNewCategory');
Route::post('/updateCategProcess', 'PagesController@updateCategory')->name('updateCategory');
Route::post('/deleteCategory', 'PagesController@deleteCategory')->name('deleteCategory');


//Expenses Post
Route::post('/addNewExpenses', 'PagesController@addNewExpenses')->name('addNewExpenses');
Route::post('/updateExpenses', 'PagesController@updateExpenses')->name('updateExpenses');
Route::post('/deleteExpenses', 'PagesController@deleteExpenses')->name('deleteExpenses');

//logout

Route::post('/logout', 'PagesController@logout')->name('logout');
