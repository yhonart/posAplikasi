<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Hash;


class RemainingController extends Controller
{    
    // CEK INFORMASI USER TERKAIT AREA KERJA YANG TERDAFTAR PADA SISTEM
    public function checkuserInfo (){
        $userID = Auth::user()->id;
        $cekUserArea = DB::table('users_area AS a')
            ->select('a.area_id','b.site_code','b.site_name')
            ->leftJoin('m_site AS b','a.area_id','=','b.idm_site')
            ->where('a.user_id',$userID)
            ->first();
        if (!empty($cekUserArea)) {
            # code...
            $userAreaID = $cekUserArea->area_id;            
        }
        else {
            $userAreaID = 0;
        }
        return $userAreaID;
    }

    public function remainingStock(){
        $listofSite = DB::table('m_site')
            ->get();
        
        $category = DB::table('m_asset_category')
            ->orderBy('category_name','ASC')
            ->get();
            
        $dbInv = DB::table('inv_stock')
            ->select(DB::raw('SUM(stock_unit) as stock'),'product_id')
            ->groupBy('product_id')
            ->get();
            
        foreach($dbInv as $inv){
            DB::table('m_product_unit')
                ->where('idm_product_satuan',$inv->product_id)
                ->update([
                    'stock'=>$inv->stock
                ]);
        }
        
        return view('RemainingStock/main',compact('listofSite','category'));
    }
    
    public function filNamaBarang($fromBarang, $endBarang){
        $filterBarang = DB::table('m_product')
            ->whereBetween('product_category',[$fromBarang,$endBarang])
            ->orderBy('product_name','asc')
            ->get();
        return view('RemainingStock/displayFilterNamaBarang',compact('filterBarang'));
    }
    public function filteringData(Request $reqFilData){
        $filterTanggal = $reqFilData->filterTanggal;
        $pilihLokasi = $reqFilData->pilihLokasi;
        $fromPilihBarang = $reqFilData->fromPilihBarang;
        $endPilihBarang = $reqFilData->endPilihBarang;
        $fromNamaBarang = $reqFilData->fromNamaBarang;
        $endNamaBarang = $reqFilData->endNamaBarang;
        // echo $fromNamaBarang."-".$endNamaBarang;
        $todayDate = date('Y-m-d');
            
        $mProduct = DB::table('view_product_stock');
        if($pilihLokasi <> '0'){
            $mProduct = $mProduct->where('location_id',$pilihLokasi);
        }
        if($fromPilihBarang <> '0' AND $endPilihBarang <> '0'){
            $mProduct = $mProduct->whereBetween('product_category',[$fromPilihBarang,$endPilihBarang]);
        }
        if($fromNamaBarang<>'0' AND $endNamaBarang<>'0'){
            $mProduct = $mProduct->whereBetween('product_name',[$fromNamaBarang,$endNamaBarang]);
        }
        
        $mProduct = $mProduct->groupBy('product_name');
        $mProduct = $mProduct->orderBy('product_name','asc');
        $mProduct = $mProduct->orderBy('site_name','asc');
        $mProduct = $mProduct->paginate(20);
        
        $valBesar = DB::table('m_product_unit')
            ->select('core_id_product','size_code','product_volume')
            ->where('size_code','1')
            ->get();
            
        $valKecil = DB::table('m_product_unit')
            ->select('core_id_product','size_code','product_volume')
            ->where('size_code','2')
            ->get();
            
        $tbCekStockBarang = DB::table('view_product_stock')
            ->where('location_id',$pilihLokasi)
            ->get();
            
        $mUnit = DB::table('m_product_unit')
            ->get();
            
        $totalStock = DB::table('view_product_stock as b');
            $totalStock = $totalStock->select(DB::raw('SUM(b.stock) as sumstock'),'b.stock', 'b.idm_data_product', 'b.product_name', 'b.product_price_order','b.stock_unit','b.product_volume','b.size_code',DB::raw('COUNT(size_code) as countsize'));
            if($pilihLokasi <> '0'){
                $totalStock = $totalStock->where('b.location_id',$pilihLokasi);
            }
            $totalStock = $totalStock->join(
                DB::raw('(SELECT product_name, MAX(size_code) AS max_code, stock_unit, idm_data_product FROM view_product_stock GROUP BY idm_data_product) as subquery') ,
                function($join){
                    $join->on('b.idm_data_product', '=', 'subquery.idm_data_product');
                    $join->on('b.size_code','=','subquery.max_code');
                }
            );
            $totalStock=$totalStock->groupBy('b.idm_data_product');
            $totalStock=$totalStock->get();
            
        $saldoStock = DB::table('view_product_stock as b');
            $saldoStock=$saldoStock->select(DB::raw('SUM(b.stock) as sumstock'),'b.stock', 'b.idm_data_product', 'b.product_name', 'b.product_price_order','b.stock_unit');
            if($pilihLokasi <> '0'){
                $saldoStock = $saldoStock->where('b.location_id',$pilihLokasi);
            }
            $saldoStock=$saldoStock->join(
                DB::raw('(SELECT product_name, MIN(size_code) AS min_stock, idm_data_product FROM view_product_stock GROUP BY idm_data_product)subquery') ,
                function($join){
                    $join->on('b.idm_data_product', '=', 'subquery.idm_data_product');
                    $join->on('b.size_code','=','subquery.min_stock');
                }
            );
            $saldoStock=$saldoStock->groupBy('b.idm_data_product');
            $saldoStock=$saldoStock->get();
        
        return view('RemainingStock/displayFilteringProduct', compact('tbCekStockBarang','mProduct','totalStock','saldoStock','valKecil','mUnit','valBesar'));
    }
    
    public function searchByKeyword($keyword, $filOption, $lokasi){
        
        $mProduct = DB::table('view_product_stock');
            $mProduct = $mProduct->select(DB::raw('DISTINCT(product_name) as product_name'), 'idm_data_product');
            if($keyword <> '0' AND $lokasi <> '0'){
                $mProduct = $mProduct->where([
                    ['product_name', 'like', '%' . $keyword .'%'],
                    ['location_id',$lokasi]
                    ]);
            }
            elseif($keyword <> '0' AND $lokasi == '0'){
                $mProduct = $mProduct->where([
                    ['product_name', 'like', '%' . $keyword .'%']
                    ]);
            }
            
            if($filOption == '0'){
                $mProduct = $mProduct->where([
                    ['stock','=','0'],
                    ['size_code','3']
                    ]);
            }
            elseif($filOption == '2'){
                $mProduct = $mProduct->where([
                    ['stock','>','0'],
                    ['stock','<','100'],
                    ['size_code','3']
                    ]);
            }
            elseif($filOption == '3'){
                $mProduct = $mProduct->where([
                    ['stock','>','0'],
                    ['size_code','3']
                    ]);
            }
            $mProduct = $mProduct->orderBy('product_name','asc');
            $mProduct = $mProduct->paginate(20);
        
        $tbCekStockBarang = DB::table('view_product_stock')
            ->get();
            
        $mUnit = DB::table('m_product_unit')
            ->get();
            
        $valBesar = DB::table('m_product_unit')
            ->select('core_id_product','size_code','product_volume')
            ->where('size_code','1')
            ->get();
        
        $valKecil = DB::table('m_product_unit')
            ->select('core_id_product','size_code','product_volume')
            ->where('size_code','2')
            ->get();
            
        $totalStock = DB::table('view_product_stock as b');
        $totalStock = $totalStock->select(DB::raw('SUM(b.stock) as sumstock'),'b.stock', 'b.idm_data_product', 'b.product_name', 'b.product_price_order','b.stock_unit','b.product_volume','b.size_code',DB::raw('COUNT(size_code) as countsize'));
        $totalStock = $totalStock->join(
                DB::raw('(SELECT product_name, MAX(size_code) AS max_code, stock_unit, idm_data_product FROM view_product_stock GROUP BY idm_data_product) as subquery') ,
                function($join){
                    $join->on('b.idm_data_product', '=', 'subquery.idm_data_product');
                    $join->on('b.size_code','=','subquery.max_code');
                }
            );
        if($keyword <> '0' AND $lokasi <> '0'){
            $totalStock = $totalStock->where([
                ['b.product_name', 'like', '%' . $keyword .'%'],
                ['b.location_id',$lokasi]
                ]);
        }
        elseif($keyword <> '0' AND $lokasi == '0'){
            $totalStock = $totalStock->where([
                ['b.product_name', 'like', '%' . $keyword .'%']
                ]);
        }
        $totalStock = $totalStock->groupBy('b.idm_data_product');
        $totalStock = $totalStock->get();
            
        $saldoStock = DB::table('view_product_stock as b')
            ->select(DB::raw('SUM(b.stock) as sumstock'),'b.stock', 'b.idm_data_product', 'b.product_name', 'b.product_price_order','b.stock_unit','b.product_volume','b.size_code')
            ->join(
                DB::raw('(SELECT product_name, MAX(size_code) AS max_code, stock_unit, idm_data_product FROM view_product_stock WHERE size_code = 1 GROUP BY idm_data_product) as subquery') ,
                function($join){
                    $join->on('b.idm_data_product', '=', 'subquery.idm_data_product');
                    $join->on('b.size_code','=','subquery.max_code');
                }
            )
            ->groupBy('b.idm_data_product')
            ->get();
        
        return view('RemainingStock/displayFilteringProduct', compact('tbCekStockBarang','mProduct','totalStock','saldoStock','valKecil','mUnit','valBesar'));
    }
    public function downloadData($keyword, $filOption, $lokasi){
            
        $mProduct = DB::table('view_product_stock as a');
            $mProduct = $mProduct->select('a.size_code', 'a.idm_data_product','a.product_code','a.product_name','a.product_satuan');
            $mProduct = $mProduct->join(
                DB::raw('(SELECT MAX(size_code) AS max_code, stock_unit, idm_data_product FROM view_product_stock GROUP BY idm_data_product) as subquery') ,
                function($join){
                    $join->on('a.idm_data_product', '=', 'subquery.idm_data_product');
                    $join->on('a.size_code','=','subquery.max_code');
                }
            );            
            if($keyword <> '0' AND $lokasi <> '0'){
                $mProduct = $mProduct->where([
                    ['a.product_name', 'like', '%' . $keyword .'%'],
                    ['a.location_id',$lokasi]
                    ]);
            }
            elseif($keyword <> '0' AND $lokasi == '0'){
                $mProduct = $mProduct->where([
                    ['a.product_name', 'like', '%' . $keyword .'%']
                    ]);
            }
            
            if($filOption == '0'){
                $mProduct = $mProduct->where([
                    ['a.stock','=','0'],
                    ['a.size_code','3']
                    ]);
            }
            elseif($filOption == '2'){
                $mProduct = $mProduct->where([
                    ['a.stock','>','0'],
                    ['a.stock','<','100'],
                    ['a.size_code','3']
                    ]);
            }
            elseif($filOption == '3'){
                $mProduct = $mProduct->where([
                    ['a.stock','>','0'],
                    ['a.size_code','3']
                    ]);
            }
            $mProduct = $mProduct->groupBy('a.idm_data_product');
            $mProduct = $mProduct->orderBy('a.product_name','asc');
            $mProduct = $mProduct->get();
        
        $tbCekStockBarang = DB::table('view_product_stock')
            ->get();
            
        $mUnit = DB::table('m_product_unit')
            ->get();
            
        $valBesar = DB::table('m_product_unit')
            ->select('core_id_product','size_code','product_volume')
            ->where('size_code','1')
            ->get();
        
        $valKecil = DB::table('m_product_unit')
            ->select('core_id_product','size_code','product_volume')
            ->where('size_code','2')
            ->get();
            
        $totalStock = DB::table('view_product_stock as b');
        $totalStock = $totalStock->select(DB::raw('SUM(b.stock) as sumstock'),'b.stock', 'b.idm_data_product', 'b.product_name', 'b.product_price_order','b.stock_unit','b.product_volume','b.size_code',DB::raw('COUNT(size_code) as countsize'));
        $totalStock = $totalStock->join(
                DB::raw('(SELECT product_name, MAX(size_code) AS max_code, stock_unit, idm_data_product FROM view_product_stock GROUP BY idm_data_product) as subquery') ,
                function($join){
                    $join->on('b.idm_data_product', '=', 'subquery.idm_data_product');
                    $join->on('b.size_code','=','subquery.max_code');
                }
            );
        if($keyword <> '0' AND $lokasi <> '0'){
            $totalStock = $totalStock->where([
                ['b.product_name', 'like', '%' . $keyword .'%'],
                ['b.location_id',$lokasi]
                ]);
        }
        elseif($keyword <> '0' AND $lokasi == '0'){
            $totalStock = $totalStock->where([
                ['b.product_name', 'like', '%' . $keyword .'%']
                ]);
        }
        $totalStock = $totalStock->groupBy('b.idm_data_product');
        $totalStock = $totalStock->get();
            
        $saldoStock = DB::table('view_product_stock as b')
            ->select(DB::raw('SUM(b.stock) as sumstock'),'b.stock', 'b.idm_data_product', 'b.product_name', 'b.product_price_order','b.stock_unit','b.product_volume','b.size_code')
            ->join(
                DB::raw('(SELECT product_name, MAX(size_code) AS max_code, stock_unit, idm_data_product FROM view_product_stock WHERE size_code = 1 GROUP BY idm_data_product) as subquery') ,
                function($join){
                    $join->on('b.idm_data_product', '=', 'subquery.idm_data_product');
                    $join->on('b.size_code','=','subquery.max_code');
                }
            )
            ->groupBy('b.idm_data_product')
            ->get();
        
        return view('RemainingStock/downloadExcel', compact('tbCekStockBarang','mProduct','totalStock','saldoStock','valKecil','mUnit','valBesar'));
    }
    
    public function generateStock(Request $reqGenerate){
        
        // $dbInv = DB::table('inv_stock')
        //     ->select(DB::raw('SUM(stock_unit) as stock'),'product_id')
        //     ->groupBy('product_id')
        //     ->get();
            
        // foreach($dbInv as $inv){
        //     // echo $inv->product_id."==".$inv->stock."<br>";
        //     DB::table('m_product_unit')
        //         ->where('idm_product_satuan',$inv->product_id)
        //         ->update([
        //             'stock'=>$inv->stock
        //         ]);
        // }
        
        //UPDATE STOCK BARANG
        $dbunit = DB::table('view_product_stock')
            ->where([
                ['core_id_product','!=','0'],
                ['size_code','1']
                ])
            ->get();
            
        $a = "0";
        foreach($dbunit as $du){
            $a = $du->product_volume * $du->stock;
            // $firstUnit = DB::table('m_product_unit')
            //     ->where([
            //         ['size_code','1'],
            //         ['core_id_product',$du->idm_data_product]
            //         ])
            //     ->first();
                
            $secoundUnit = DB::table('view_product_stock')
                ->where([
                    ['size_code','2'],
                    ['core_id_product',$du->idm_data_product]
                    ])
                ->get();
            
            foreach($secoundUnit as $su){
                $ab = $a + $su->stock_unit;
                echo $du->site_name."/".$du->product_name."=".$ab."<br>";
                    // DB::table('inv_stock')
                    //     ->where([
                    //         ['product_id',$su->idm_product_satuan],
                    //         ])
                    //     ->update([
                    //         'stock'=>$ab   
                    //     ]);
            }
            // echo $du->product_id."/".$firstUnit->idm_product_satuan."<br>";
            // if($du->size_code == '1'){
            //     $a = $firstUnit->stock;
            // }
            // elseif($du->size_code == '2'){
            //     $a = $firstUnit->product_volume * $firstUnit->stock + $secoundUnit->stock;
            //     // $a = (int)$a1;
            // }
            
            // if($du->size_code <> '3'){
            //     echo $du->size_code."==".$du->product_name."=".$a."/".$firstUnit->product_volume."<br>";
            //     DB::table('inv_stock')
            //         ->where('product_id',$du->idm_product_satuan)
            //         ->update([
            //             'stock'=>$a    
            //         ]);
            // }
        }
    }
    
    public function detailInfoStock ($idmproduct){
        $viewStock = DB::table('view_product_stock')
            ->where([
                ['idm_data_product',$idmproduct],
                ['product_volume','!=','0']
                ])
            ->orderBy('site_name','asc')
            ->get();
            
        return view('RemainingStock/modalDataProduct', compact('idmproduct','viewStock'));
    }
    
    public function postModalUpdateStock(Request $postUpdate){
        $table = $postUpdate->tableName;
        $coloumn = $postUpdate->column;
        $editVal = $postUpdate->editVal;
        $colId = $postUpdate->tableID;
        $id = $postUpdate->id;
        
        DB::table($table)
            ->where($colId,$id)
            ->update([
                $coloumn=>$editVal,
                ]);
    }
   
}
