<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MoUController extends Controller
{
    public function mainIndex(){
        return view ('AssetManagement/MasterData/MoUMaintenance');
    }

    public function tableMoU(){
        $mouData = DB::table('m_unit')
            ->get();

        return view ('AssetManagement/MasterData/MoUTableData', compact('mouData'));
    }

    public function AddMoU (){
        return view ('AssetManagement/MasterData/MoUModalFormAdd');
    }

    public function PostAddMoU(Request $reqPostMoU){
        $initial = $reqPostMoU->initialUnit;
        $nameUnit = strtoupper($reqPostMoU->UnitName);

        if ($initial=='0' OR $nameUnit=="" OR $nameUnit==" ") {
            $msg = array('warning' => '! Unit inisial dan nama harus di isi.');
        }
        else{
            DB::table('m_unit')
                ->insert([
                    'unit_initial'=>$initial,
                    'unit_note'=>$nameUnit,
                ]);
            $msg = array('success' => '✔ Success, data berhasil di masukkan.');
        }
        return response()->json($msg);
    }
}
