<?php

namespace App\Http\Controllers;

use App\User;
use App\time_management;
use Datatables;

use Illuminate\Http\Request;

class dataTableApiController extends Controller
{
    public function userTable(){

        $query = User::select('id','first_name', 'middle_name', 'last_name','contact_no');

        return datatables($query)->make(true);

    }
}
