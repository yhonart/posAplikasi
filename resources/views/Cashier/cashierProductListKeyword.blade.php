
<table id="myTable" class="table table-hover">
    <tbody>
        @foreach($productList as $pL)
        <tr>
            <td colspan="2" class="p-0">
                <button class="btn btn-default btn-block rounded-0 border-0 onClick-produk elevation-0 btn-sm text-primary font-weight-bold text-left" data-id="{{$pL->idinv_stock}}">{{$pL->product_name}}</button>
            </td>
            <td class="p-0"></td class="p-0">
            <td class="p-0">
                {{$pL->product_satuan}}
            </td class="p-0">
            <td class="text-right p-0">
                @foreach($getPrice as $gp)
                    @if($gp->core_product_price == $pL->idm_data_product AND $gp->size_product == $pL->product_size)
                        {{number_format($gp->price_sell,'0',',','.')}}
                    @endif
                @endforeach
            </td>
            <td class="p-0"></td>
            <td class="p-0"></td>
            <td class="p-0 text-right">{{$pL->stock}}</td>
            <td class="p-0"></td>
        </tr>
        @endforeach
    </tbody>
</table>
<script>
    $(document).ready(function() {
        const table = document.getElementById('myTable');
        const rows = table.getElementsByTagName('tr');
        let selectedRowIndex = -1;
        function highlightRow(index) {
            // Hapus sorotan dari baris sebelumnya
            if (selectedRowIndex >= 0 && rows[selectedRowIndex]) {
                rows[selectedRowIndex].classList.remove('highlight');
            }    
            // Tambahkan sorotan ke baris yang dipilih
            if (index >= 0 && index < rows.length) {
                rows[index].classList.add('highlight');
                selectedRowIndex = index;
            } else {
                selectedRowIndex = -1; // Reset jika indeks tidak valid
            }
        }
        // Event listener untuk tombol panah atas dan bawah
        document.addEventListener('keydown', function(event) {
            if (event.key === 'ArrowDown') {
                event.preventDefault(); // Mencegah scroll halaman
                let newIndex = selectedRowIndex + 1;
                if (newIndex >= rows.length) {
                    newIndex = 1; // Kembali ke baris pertama (setelah header)
                }
                // alert (newIndex);
                highlightRow(newIndex);
            } else if (event.key === 'ArrowUp') {
                event.preventDefault(); // Mencegah scroll halaman
                let newIndex = selectedRowIndex - 1;
                if (newIndex < 0) {
                    newIndex = rows.length - 1; // Ke baris terakhir
                }
                // alert (newIndex);
                highlightRow(newIndex);
            }
        });
        // Sorot baris pertama (setelah header) saat halaman dimuat
        highlightRow(0);
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.onClick-produk').on('click', function (e) {
            e.preventDefault();
            let dataID = $(this).attr('data-id'),
                billNumber = "{{$billNumber}}",
                cusGroup = "{{$cosGroup}}";
            let routeIndex = "{{route('Cashier')}}",
                urlProductList = "productList",
                panelProductList = $("#mainListProduct");
            $.ajax({
                type : 'get',
                url : "{{route('Cashier')}}/inputItem/"+dataID+"/"+billNumber+"/"+cusGroup,
                success : function(response){                
                    reloadTableItem(billNumber);
                    sumTotalBelanja(billNumber);
                    $("#fieldProduk").val('');
                    $("#tableSelectProduk").fadeOut("slow");
                    $("#fieldProduk").val(null).focus();
                    // cashier_style.load_productList(routeIndex,urlProductList,panelProductList);
                }
            });
        });

        function reloadTableItem(billNumber){
            $.ajax({
                type : 'get',
                url : "{{route('Cashier')}}/productList/listTableTransaksi/"+billNumber,
                success : function(response){                
                    $("#trLoadProduct").html(response);
                }
            });
        }
            
        function sumTotalBelanja(billNumber){
            $.ajax({
                type : 'get',
                url : "{{route('Cashier')}}/buttonAction/updateTotalBeanja/"+billNumber,
                success : function(response){
                    $('#totalBelanja').html(response);
                }
            });
        }
    });
</script>