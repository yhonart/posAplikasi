<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Hash;

class TrxKasUmumController extends Controller
{
    public function mainTrx(){
        return view('TrxKasUmum/main');
    }

    public function tambahBiaya()
    {
        $kasKategori = DB::table('m_category_kas')
            ->where('status','1')
            ->orderBy('cat_name','asc')
            ->get();

        $mStaff = DB::table('m_sales')
            ->where('sales_status','1')
            ->get();
        
        $mAdmin = DB::table('users')
            ->get();

        return view('TrxKasUmum/modalTambahBiaya', compact('kasKategori','mAdmin','mStaff'));
    }

    public function selectKategori($kategori)
    {
        $selectOption = DB::table('m_subcategory_kas')
            ->where('from_cat_id',$kategori)
            ->orderBy('subcat_name','asc')
            ->get();

        return view('TrxKasUmum/selectOptionSubKategori', compact('selectOption'));
    }

    public function postTrxPembiayaan(Request $reqAddPembiayaan)
    {
        
        $kasDate = $reqAddPembiayaan->tanggal;
        $kasCatid = $reqAddPembiayaan->selKategori;
        $kasSubCatid = $reqAddPembiayaan->subKategori;
        $description = $reqAddPembiayaan->keterangan;
        $kasPersonal = $reqAddPembiayaan->personal;
        $kasNominal = $reqAddPembiayaan->nominal;
        $mFile = $reqAddPembiayaan->docLampiran;

        $splitPers = explode("|",$kasPersonal);
        $persCode = $splitPers[0];
        $persName = $splitPers[1];

        $creatorName = Auth::user()->name;

        if ($mFile <> "") {
            $TypeDoc = $mFile->getClientOriginalExtension();
            $NameDoc = $mFile->getClientOriginalName();
            $DirPublic = public_path()."/images/Upload/TrxKas/";
            $mFile->move($DirPublic, $NameDoc);
        }
        else {
            $TypeDoc = "";
            $NameDoc = "";
            $DirPublic = "";
        }

        DB::table('tr_kas')
            ->insert([
                'kas_catId'=>$kasCatid,
                'kas_subCatId'=>$kasSubCatid,
                'kas_persCode'=>$persCode,
                'kas_persName'=>$persName,
                'description'=>$description,
                'kas_date'=>$kasDate,
                'created_date'=>now(),
                'status'=>'1',
                'created_by'=>$creatorName,
                'nominal'=>$kasNominal,
                'file_name'=>$NameDoc,
                'file_type'=>$TypeDoc
            ]);
        
    }

    public function filterByDate($fromDate, $endDate)
    {
        $displayByDate = DB::table('tr_kas as a');
            $displayByDate = $displayByDate->select('a.*','b.cat_name','c.subcat_name');
            $displayByDate = $displayByDate->leftJoin('m_category_kas as b','b.idm_cat_kas','=','a.kas_catId');
            $displayByDate = $displayByDate->leftJoin('m_subcategory_kas as c','c.idm_sub','=','a.kas_subCatId');
            $displayByDate = $displayByDate->where([
                ['a.status','1']
            ]);
            if ($fromDate <> '0' OR $endDate <> '0') {
                $displayByDate = $displayByDate->whereBetween("a.kas_date", [$fromDate, $endDate]);
            }
            $displayByDate = $displayByDate->get();

        return view('TrxKasUmum/listTransactionKas', compact('displayByDate'));
    }
}
