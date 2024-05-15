<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssManagedController extends Controller
{
    public function main (){
        return view ('AssetManagement/main');
    }

    // MASTER DATA    
    public function mCategory(){
        return view ('AssetManagement/MasterData/CategoryIndex');
    }

    public function FormAddCategory(){
        return view ('AssetManagement/MasterData/CategoryModalFormAdd');
    }

    public function PostNewCategory(Request $reqNewCat){
        $dataCatCode = strtoupper($reqNewCat->categoryCode);
        $dataCatName = strtoupper($reqNewCat->categoryName);

        $dataMC = DB::table('m_asset_category')
            ->where([
                'category_code'=>$dataCatCode,
                ])
            ->orWhere([
                'category_name'=>$dataCatName,
            ])
            ->count();
        if ($dataCatCode=="" OR $dataCatCode==" " OR $dataCatName=="" OR $dataCatName==" ") {
            $msg = array('warning' => '! Nama dan kode kategori harus di isi.');
        }
        elseif ($dataMC>=1) {
            $msg = array('warning' => '! Nama atau kode kategori sudah ada.');
        }
        else{
            DB::table('m_asset_category')
                ->insert([
                    'category_code'=>$dataCatCode,
                    'category_name'=>$dataCatName,
                    'create_date'=>now(),                    
                ]);
            $msg = array('success' => '✔ Data berhasil dimasukkan.');
        }
        return response()->json($msg);
    }

    public function arrayCategory(){
        $tableCategory = DB::table('m_asset_category')            
            ->get();
        return view('AssetManagement/MasterData/CategoryTableData', compact('tableCategory'));
    }

    public function editMenuCategory($id){
        $CategoryEdit = DB::table('m_asset_category')
            ->where('idm_asset_category',$id)
            ->first();

        return view ('AssetManagement/MasterData/CategoryModalFormEdit', compact('id','CategoryEdit'));
    }

    public function PostEditCategory(Request $reqEditCat){
        $id = $reqEditCat->categoryId;
        $categoryCode = $reqEditCat->categoryCode;
        $categoryName = $reqEditCat->categoryName;

        $countData = DB::table('m_asset_category')
            ->where([
                'category_code'=>$categoryCode,
                ])
            ->count();

        if ($categoryCode=="" OR $categoryCode==" " OR $categoryName=="" OR $categoryName==" ") {
            $msg = array('warning' => '! Nama dan kode kategori harus di isi.');
        }
        elseif ($countData>=1) {
            $msg = array('warning' => '! Nama atau kode kategori sudah ada.');
        }
        else {
            DB::table('m_asset_category')
            ->where('idm_asset_category',$id)
            ->update([
                'category_code'=>$categoryCode,
                'category_name'=>$categoryName,
            ]);            
            $msg = array('success' => '✔ Data berhasil diupdate.');
        }
        return response()->json($msg);
    }

    public function PostDelPermanent($id){
        DB::table('m_asset_category')
            ->where('idm_asset_category',$id)
            ->delete();
    }

    // MANUFACTURE 
    public function mManufacture(){
        return view('AssetManagement/MasterData/ManufactureIndex');
    }

    public function FormAddManufacture(){
        $category = DB::table('m_asset_category')
            ->where('category_status','1')
            ->get();

        return view('AssetManagement/MasterData/ManufactureModalFormAdd',compact('category'));
    }

    public function PostNewManufacture(Request $reqNewMft){
        $manufactureCode = strtoupper($reqNewMft->manufactureCode);
        $manufactureName = strtoupper($reqNewMft->manufactureName);
        $catId = $reqNewMft->catID;

        $counDataM = DB::table('m_asset_manufacture')
            ->where('manufacture_code',$manufactureCode)
            ->count();

        if ($manufactureCode=="" OR $manufactureCode==" " OR $manufactureName=="" OR $manufactureName==" ") {
            $msg = array('warning' => '! Nama dan kode manufacture harus di isi');
        }
        elseif ($counDataM>1) {
            $msg = array('warning' => '! Kode manufacture sudah ada.');
        }
        elseif ($catId=='0') {
            $msg = array('warning' => '! Brand kategori harus di isi.');
        }
        else {
            DB::table('m_asset_manufacture')
                ->insert([
                    'manufacture_code'=>$manufactureCode,
                    'manufacture_name'=>$manufactureName,
                    'asset_cat_id'=>$catId,
                ]);
            $msg = array('success' => '✔ Data berhasil dimasukkan');            
        }
        return response()->json($msg);
    }

    public function arrayManufacture(){
        $tableManufacture = DB::table('m_asset_manufacture')
            ->get();

        return view('AssetManagement/MasterData/ManufactureTableData', compact('tableManufacture'));
    }

    public function editManufacture($id){
        $manufactureEdit = DB::table('m_asset_manufacture')
            ->where('idm_asset_manufacture',$id)
            ->first();
            
        $categoryedit = DB::table('manufacture_view')
            ->where('idm_asset_manufacture',$id)
            ->first();

        $categoryList = DB::table('m_asset_category')
            ->select('idm_asset_category','category_name')
            ->get();

        return view('AssetManagement/MasterData/ManufactureModalFormEdit',compact('manufactureEdit','id','categoryedit','categoryList'));
    }

    public function PostEditManufacture(Request $reqposteditMF){
        $manufactureCode = strtoupper($reqposteditMF->manufactureCode);
        $manufactureName = $reqposteditMF->manufactureName;
        $manufactureId = $reqposteditMF->manufactureId;
        $categoryId = $reqposteditMF->CatBrand;

        $counDataM = DB::table('m_asset_manufacture')
            ->where('manufacture_code',$manufactureCode)
            ->count();

        if ($manufactureCode=="" OR $manufactureCode==" " OR $manufactureName=="" OR $manufactureName==" ") {
            $msg = array('warning' => '! Nama dan kode manufacture harus di isi');
        }
        elseif ($counDataM>1) {
            $msg = array('warning' => '! Kode manufacture sudah ada.');
        }
        else {
            DB::table('m_asset_manufacture')
                ->where('idm_asset_manufacture',$manufactureId)
                ->update([
                    'manufacture_code'=>$manufactureCode,
                    'manufacture_name'=>$manufactureName,
                    'asset_cat_id'=>$categoryId,
                ]);
            $msg = array('success' => '✔ Data berhasil terupdate');            
        }
        return response()->json($msg);
    }

    public function PostDelPermanentMF($id){
        DB::table('m_asset_manufacture')
            ->where('idm_asset_manufacture',$id)
            ->delete();
    }

    //MODEL
    public function mModel(){
        return view('AssetManagement/MasterData/ModelIndex');
    }

    public function FormAddModel(){
        $mCategory = DB::table('m_asset_category')
            ->get();
        $mManufacture = DB::table('m_asset_manufacture')
            ->get();

        return view('AssetManagement/MasterData/ModelModalFormAdd',compact('mCategory','mManufacture'));
    }

    public function PostNewModel(Request $reqPostModel){
        $mCode = $reqPostModel->modelCode;
        $mName = $reqPostModel->modelName;
        $mCategory = $reqPostModel->modelCategory;
        $mManufacture = $reqPostModel->modelManufacture;
        $mNote = $reqPostModel->modelNote;
        $mFile = str_replace(" ","",$reqPostModel->modelFile);

        if ($mFile<>"") {
            $TypeDoc = $mFile->getClientOriginalExtension();
            $NameDoc = $mFile->getClientOriginalName();
            $DirPublic = public_path()."/images/Upload/Model/";            
            $mFile->move($DirPublic, $NameDoc);
        }
        else{
            $TypeDoc = "";
            $NameDoc = "";
            $DirPublic = "";
        }
        
        DB::table('m_asset_model')
            ->insert([
                'model_code'=>$mCode,
                'model_name'=>$mName,
                'category_note'=>$mCategory,
                'manufacture_note'=>$mManufacture,
                'model_note'=>$mNote,
                'model_file_type'=>$TypeDoc,
                'model_file_dir'=>$DirPublic,
                'model_file_name'=>$NameDoc,
                'model_status'=>'Ready',
            ]);
        $msg = array('success' => '✔ Data berhasil dimasukkan');        
        return response()->json($msg);
    }

    public function arrayModel(){
        $tableModel = DB::table('m_asset_model')
            ->get();

        return view ('AssetManagement/MasterData/ModelTableData', compact('tableModel'));
    }

    public function editMenuModel($id){
        $ModelEdit = DB::table('m_asset_model')
            ->where('idm_asset_model',$id)
            ->first();
        
        $mCategory = DB::table('m_asset_category')
            ->get();

        $mManufacture = DB::table('m_asset_manufacture')
            ->get();

        return view ('AssetManagement/MasterData/ModelModalFormEdit', compact('ModelEdit','mCategory','mManufacture'));
    }

    public function PostEditModel (Request $reqPostEditModel){
        $idModel = $reqPostEditModel->idModelEdit;
        $editModelCode = $reqPostEditModel->modelCode;
        $editModelName = $reqPostEditModel->modelName;
        $editModelCategory = $reqPostEditModel->modelCategory;
        $editModelManufacture = $reqPostEditModel->modelManufacture;
        $editModelNote = $reqPostEditModel->modelNote;
        $editModelStatus = $reqPostEditModel->modelStatus;
        $editModelFile = $reqPostEditModel->modelFile;

        if ($editModelFile<>"") {
            $TypeDoc = $editModelFile->getClientOriginalExtension();
            $NameDoc = $editModelFile->getClientOriginalName();
            $DirPublic = public_path()."/images/Upload/Model/";            
            $editModelFile->move($DirPublic, $NameDoc);
        }
        else{
            $TypeDoc = "";
            $NameDoc = "";
            $DirPublic = "";
        }

        DB::table('m_asset_model')
            ->where('idm_asset_model',$idModel)
            ->update([
                'model_code'=>$editModelCode,
                'model_name'=>$editModelName,
                'category_note'=>$editModelCategory,
                'manufacture_note'=>$editModelManufacture,
                'model_note'=>$editModelNote,
                'model_file_type'=>$TypeDoc,
                'model_file_dir'=>$DirPublic,
                'model_file_name'=>$NameDoc,
                'model_status'=>$editModelStatus,
            ]);
        $msg = array('success' => '✔ Data berhasil terupdate');        
        return response()->json($msg);
    }
}
