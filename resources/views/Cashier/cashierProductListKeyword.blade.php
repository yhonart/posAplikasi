<table id="myTable" class="table table-sm table-bordered">    
    <tbody>
        @foreach($productList as $pL)
        <tr data-id="{{$pL->idinv_stock}}">
            <td class="p-0" colspan="3" width="37%">
                {{$pL->product_name}}
            </td>
            <td class="p-0" width="12%">
                {{$pL->product_satuan}}
            </td>
            <td class="text-right p-0" width="12%">
                {{number_format($pL->price_sell,'0',',','.')}}
            </td>            
            <td class="p-0 text-right" colspan="2">{{$pL->stock}}</td>            
        </tr>
        @endforeach
    </tbody>
</table>
<script>
    $(document).ready(function() {
        const table = document.getElementById('myTable');
        const rows = table.getElementsByTagName('tr');
        let selectedRow = -1;
        let hargaSatuan = document.getElementById("formHargaSatuan"),
            hargaBeli = document.getElementById("hargaBeli"),
            formQty = document.getElementById("formQty"),
            formSatuan = document.getElementById("formSatuan"),
            formDisc = document.getElementById("formDisc"),
            formJumlah = document.getElementById("formJumlah"),
            formStock = document.getElementById("formStock"),
            disStockAwal = document.getElementById("formStockAwal"),
            disProduk = document.getElementById("disProduk");

        function highlightRow(index) {
            if (selectedRow >= 0) {
                rows[selectedRow].classList.remove('highlight');
            }
            if (index >= 0 && index < rows.length) {
                rows[index].classList.add('highlight');
                selectedRow = index;
            }
        }
        // Event listener untuk tombol panah atas dan bawah
        document.addEventListener('keydown', function(event) {
            if (event.key === 'ArrowDown') {
                event.preventDefault(); // Mencegah scroll halaman
                if (selectedRow < rows.length - 1) {
                    highlightRow(selectedRow + 1);
                }
            } else if (event.key === 'ArrowUp') {
                event.preventDefault(); // Mencegah scroll halaman
                if (selectedRow > 0) {
                    highlightRow(selectedRow - 1);
                }
            } else if (event.key === 'Enter' && selectedRow >= 0) {
                // Kirim data baris yang dipilih
                let selectedId = rows[selectedRow].getAttribute('data-id');
                let billNumber = "{{$billNumber}}",
                    cusGroup = "{{$cosGroup}}",
                    memberID = "{{$memberID}}";

                let routeIndex = "{{route('Cashier')}}",
                    urlProductList = "productList",
                    panelProductList = $("#mainListProduct");
                $("#tableSelectProduk").fadeOut("slow");
                $("#disProduk").fadeIn("slow");
                $("#fieldProduk").fadeOut("slow");
                // $("#trInputProdut").fadeOut("slow");
                if (selectedId) {
                    fetch("{{route('Cashier')}}/selectResponse/" + selectedId + "/" + memberID)
                    .then(response => response.json())
                    .then(data => {
                        if ((data.price) || (data.satuan) || (data.jumlah) || (data.prdStock) || (data.prodName) || (data.discount) || (data.hrgModal)) {
                            hargaSatuan.value = accounting.formatMoney(data.price,{
                                symbol: "",
                                precision: 0,
                                thousand: ".",
                            });
                            disProduk.value = data.prodName;
                            formSatuan.value = data.satuan;
                            formDisc.value = data.discount;
                            formJumlah.value = accounting.formatMoney(data.price,{
                                symbol: "",
                                precision: 0,
                                thousand: ".",
                            });
                            formStock.value = data.prdStock;
                            hargaBeli.value = data.hrgModal;                            
                            disStockAwal.value = data.prdStock;                            
                        }
                    }); 
                    $("#formQty").val("1").focus().select();                   
                    $("#fieldProduk").val(null);
                    $("#stockID").val(selectedId);
                    $("#cusGroup").val(cusGroup);
                }
            }
        });
        // CSS untuk menandai baris yang dipilih
        const style = document.createElement('style');
        style.innerHTML = `
            .highlight {
                background-color: #211C84;
                color: #F6F0F0;
            }
        `;
        document.head.appendChild(style);

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