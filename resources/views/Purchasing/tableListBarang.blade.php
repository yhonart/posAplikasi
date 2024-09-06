<?php
    $no = '1';
    $sumTot = '0';
    
?>
@foreach($listDataBarang as $ldb)
    
    <tr>
        <td class="p-0 text-center">{{$no++}}</td>
        <td class="p-0">
            {{$ldb->product_name}}
        </td>
        <td>
            @if($ldb->status == '3')
                {{$ldb->satuan}}
            @else
            <select class="form-control form-control-sm rounded-0" name="editSatuan" id="editSatuan" onchange="saveToDatabase(this,'purchase_list_order','size','{{$ldb->id_lo}}','id_lo')">
                <option value="{{$ldb->size}}" readonly>{{$ldb->satuan}}</option>
                @foreach($satuanBarang as $sb)
                    @if($ldb->product_id == $sb->core_id_product AND $ldb->size <> $sb->product_size)
                        <option value="{{$sb->product_size}}">{{$sb->product_satuan}}</option>
                    @endif
                @endforeach
            </select>
            @endif
        </td>
        <td class="p-0">
            @if($ldb->status == '3')
                {{$ldb->qty}}
            @else
            <input type="number" name="editQty" id="editQty" class="form-control form-control-sm rounded-0" value="{{$ldb->qty}}" onchange="saveToDatabase(this,'purchase_list_order','qty','{{$ldb->id_lo}}','id_lo')">
            @endif
        </td>
        <td class="text-right">{{number_format($ldb->unit_price,'0',',','.')}}</td>
        <td class="p-0">
            @if($ldb->status == '3')
                {{$ldb->discount}}
            @else
                <input type="number" name="editDis" id="editDis" class="form-control form-control-sm rounded-0" value="{{$ldb->discount}}" onchange="saveToDatabase(this,'purchase_list_order','discount','{{$ldb->id_lo}}','id_lo')">
            @endif
        </td>
        <td class="text-right">{{number_format($ldb->total_price,'0',',','.')}}</td>
        <td class="p-0">
            @if($ldb->status == '3')
            {{$ldb->site_name}}
            @else
            <select class="form-control form-control-sm rounded-0" name="editWarehouse" id="editWarehouse" onchange="saveToDatabase(this,'purchase_list_order','warehouse','{{$ldb->id_lo}}','id_lo')">
                <option value="{{$ldb->warehouse}}" readonly>{{$ldb->site_name}}</option>
                @foreach($warehouse as $w)
                    @if($w->idm_site <> $ldb->warehouse)
                        <option value="{{$w->idm_site}}">{{$w->site_name}}</option>
                    @endif
                @endforeach
            </select>
            @endif
        </td>
        <td class="p-0 text-center">
            {{$ldb->stock_awal}}
        </td>
        <td class="p-0 text-center">
            {{$ldb->stock_akhir}}
        </td>
        <td class="p-0">
            @if($ldb->status <> '3')
            <button class="btn border-0 elevation-0 btn-danger btn-flat deleteItem" data-id="{{$ldb->id_lo}}"><i class="fa-solid fa-xmark"></i></button>
            @endif
        </td>
        $sumTot += $ldb->total_price;
    </tr>
@endforeach
<script>
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $('.deleteItem').on('click', function (e) {
        e.preventDefault();
        let dataEdit = $(this).attr('data-id');
        $("#notifLoading").fadeIn("slow");
        $.ajax({
            type : 'get',
            url : "{{route('Purchasing')}}/tablePenerimaan/deleteItem/"+dataEdit,
            success : function(response){
                $("#notifLoading").fadeOut("slow");
                loadTableData();
            loadSumData();
            }
        });
    });
});
function saveToDatabase(editableObj,tablename,column,id,idChange) {
    $("#notifLoading").fadeIn("slow");
    $.ajax({
        url: "{{route('Purchasing')}}/tablePenerimaan/updateOnChange",
        type: "POST",
        data:'tablename='+tablename+'&column='+column+'&editval='+editableObj.value+'&id='+id+'&idChange='+idChange,            
        success: function(data){
            alertify.success('Data Berhasil Terupdate');
            $("#notifLoading").fadeOut("slow");
            loadTableData();
            loadSumData();
        }
    });
}
function loadTableData(){
    let numberPO = "{{$numberPO}}";
    $.ajax({
        type : 'get',
        url : "{{route('Purchasing')}}/tableInputBarang/loadBarang/"+numberPO,
        success : function(response){                
            $("#tableListBarang").html(response);
        }
    });
}
function loadSumData(){
    let numberPO = "{{$numberPO}}";
    $.ajax({
        type : 'get',
        url : "{{route('Purchasing')}}/tableInputBarang/tableSum/"+numberPO,
        success : function(response){                
            $("#tableSum").html(response);
        }
    });
}
</script>