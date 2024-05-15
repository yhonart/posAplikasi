<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersonaliaController extends Controller
{
    public function mainIndex (){
        return view ('hris/masterData/mainIndex');
    }

    public function dataTablePersonalia (){
        $personalia = DB::table('m_employee')
            ->paginate(10);

        return view ('hris/masterData/personaliaMaintenance');
    }

    public function searchData ($keyword){
        $personalia = DB::table('m_employee');
            if ($keyword <> 0) {
                $personalia = $personalia->where('employee_name','LIKE','%'.$keyword.'%');
            }
            $personalia = $personalia->paginate(10);

        return view ('hris/masterData/personaliaList', compact('personalia'));
    }
}
