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
        $todayInfo = date("Y-m-d");

        $kasKategori = DB::table('m_category_kas')
            ->where('status','1')
            ->orderBy('cat_name','asc')
            ->get();

        $mStaff = DB::table('m_sales')
            ->where('sales_status','1')
            ->get();
        
        $mAdmin = DB::table('users')
            ->get();

        $selectOption = DB::table('m_subcategory_kas')
            ->orderBy('subcat_name','asc')
            ->get();

        $kasKasir = DB::table('m_set_kas as a')
            ->select('a.*', 'b.name')
            ->leftJoin('users as b', 'a.personal_id','=','b.id')
            ->get();

        $pendapatanKasir = DB::table('tr_store')
            ->select(DB::raw('SUM(t_pay) as payment'),'created_by')
            ->where('tr_date',$todayInfo)
            ->groupBy('created_by')
            ->get();

        $mBank = DB::table('m_bank')
            ->where('display_status','1')
            ->get();

        $kasPayble = DB::table('tr_kas')
            ->select(DB::raw('SUM(nominal) as nominal'), 'sumber_dana')
            ->where([
                ['kas_date',$todayInfo],
                ['status','1']
                ])
            ->groupBy('sumber_dana')
            ->get();

        return view('TrxKasUmum/modalTambahBiaya', compact('kasKategori','mAdmin','mStaff','selectOption','kasKasir','pendapatanKasir','mBank','kasPayble'));
    }

    public function selectKategori($kategori)
    {
        $countSubcategory = DB::table('m_subcategory_kas')
            ->where('from_cat_id',$kategori)
            ->count();
                   
        $selectKategori = DB::table('m_category_kas')
            ->where('idm_cat_kas',$kategori)
            ->first();

        $selectOption = DB::table('m_subcategory_kas')
            ->where('from_cat_id',$kategori)
            ->orderBy('subcat_name','asc')
            ->get();


        return view('TrxKasUmum/selectOptionSubKategori', compact('selectOption','selectKategori','countSubcategory'));
    }

    public function selectPersonal($persno)
    {
        $explodPersno = explode("|",$persno);
        $persCode = $explodPersno[0];
        $persName = $explodPersno[1];

        $selectNopol = DB::table('users')
            ->select('utility','no_utility')
            ->where('id',$persCode)
            ->first();

        return response()->json([
            'noPol' => $selectNopol->no_utility,
        ]);
        return response()->json(['error' => '0'], 404);        
    }

    public function postTrxPembiayaan(Request $reqAddPembiayaan)
    {
        
        $kasDate = $reqAddPembiayaan->tanggal;
        $kasCatid = $reqAddPembiayaan->selKategori;
        $kasSubCatid = $reqAddPembiayaan->subKategori;
        $description = $reqAddPembiayaan->keterangan;
        $kasPersonal = $reqAddPembiayaan->personal;
        $kasNominal = str_replace(".", "", $reqAddPembiayaan->nominal);
        $mFile = $reqAddPembiayaan->docLampiran;
        $nopol = $reqAddPembiayaan->nopol;

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
                'file_type'=>$TypeDoc,
                'no_polisi'=>$nopol
            ]);
    }

    public function filterByDate($fromDate, $endDate)
    {
        $displayByDate = DB::table('tr_kas as a');
            $displayByDate = $displayByDate->select('a.*','b.cat_name','c.subcat_name');
            $displayByDate = $displayByDate->leftJoin('m_category_kas as b','b.idm_cat_kas','=','a.kas_catId');
            $displayByDate = $displayByDate->leftJoin('m_subcategory_kas as c','c.idm_sub','=','a.kas_subCatId');
            $displayByDate = $displayByDate->where([
                ['a.status','1'],
                ['a.trx_code','2']
            ]);
            if ($fromDate <> '0' OR $endDate <> '0') {
                $displayByDate = $displayByDate->whereBetween("a.kas_date", [$fromDate, $endDate]);
            }
            $displayByDate = $displayByDate->get();

        return view('TrxKasUmum/listTransactionKas', compact('displayByDate'));
    }

    public function exportData($exportType, $fromDate, $endDate)
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

        if ($exportType=="excel") {
            return view('TrxKasUmum/exportReportExcel', compact('displayByDate'));
        }
        else {
            $pdf = PDF::loadview('TrxKasUmum/exportReportPdf', compact('displayByDate'))->setPaper("A4", 'portrait');
            return $pdf->stream();
        }

    }

    public function modalEditKas($id)
    {
        $editData = DB::table('tr_kas as a')
            ->select('a.*','b.cat_name','c.subcat_name')
            ->leftJoin('m_category_kas as b','b.idm_cat_kas','=','a.kas_catId')
            ->leftJoin('m_subcategory_kas as c','c.idm_sub','=','a.kas_subCatId')
            ->where('a.idtr_kas',$id)
            ->first();

        $kasKategori = DB::table('m_category_kas')
            ->where('status','1')
            ->orderBy('cat_name','asc')
            ->get();

        $mStaff = DB::table('m_sales')
            ->where('sales_status','1')
            ->get();
        
        $mAdmin = DB::table('users')
            ->get();

        $selectSubKategori = DB::table('m_subcategory_kas')
            ->orderBy('subcat_name','asc')
            ->get();

        return view('TrxKasUmum/editTransaksiKas', compact('editData','kasKategori','mAdmin','mStaff','selectSubKategori'));
    }

    public function postTrxEditKas(Request $reqPostEdit)
    {
        $id = $reqPostEdit->idHidden;
        $kasDate = $reqPostEdit->tanggal;
        $kasCatid = $reqPostEdit->selEditKategori;
        $kasSubCatid = $reqPostEdit->subEditKategori;
        $description = $reqPostEdit->keterangan;
        $kasPersonal = $reqPostEdit->personal;
        $kasNominal = str_replace(".", "", $reqPostEdit->nominal);
        $mFile = $reqPostEdit->docLampiran;

        $splitPers = explode("|",$kasPersonal);
        $persCode = $splitPers[0];
        $persName = $splitPers[1];

        $TypeDoc = "";
        $NameDoc = "";
        $DirPublic = "";

        $creatorName = Auth::user()->name;
        
        if ($mFile <> "") {
            $TypeDoc = $mFile->getClientOriginalExtension();
            $NameDoc = $mFile->getClientOriginalName();
            $DirPublic = public_path()."/images/Upload/TrxKas/";
            $mFile->move($DirPublic, $NameDoc);
        }

        DB::table('tr_kas')
            ->where('idtr_kas',$id)
            ->update([
                'kas_catId'=>$kasCatid,
                'kas_subCatId'=>$kasSubCatid,
                'kas_persCode'=>$persCode,
                'kas_persName'=>$persName,
                'description'=>$description,
                'kas_date'=>$kasDate,
                'updated_date'=>now(),
                'status'=>'1',
                'created_by'=>$creatorName,
                'nominal'=>$kasNominal,
                'file_name'=>$NameDoc,
                'file_type'=>$TypeDoc
            ]);
    }
}
