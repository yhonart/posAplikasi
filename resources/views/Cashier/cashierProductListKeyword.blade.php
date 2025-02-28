@foreach($productList as $pL)
<tr data-id="{{$pL->idinv_stock}}">
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

        document.addEventListener('DOMContentLoaded', function() {
        const table = document.getElementById('listTableItemTrx');
        const rows = table.querySelectorAll('tbody tr');
        let selectedRowIndex = -1;

        // Fungsi untuk menandai baris yang dipilih
        function selectRow(index) {
            if (selectedRowIndex !== -1) {
            rows[selectedRowIndex].classList.remove('selected');
            }
            if (index >= 0 && index < rows.length) {
            rows[index].classList.add('selected');
            selectedRowIndex = index;
            }
        }

        // Event listener untuk tombol panah atas dan bawah
        document.addEventListener('keydown', function(event) {
            if (event.key === 'ArrowDown') {
            event.preventDefault(); // Mencegah scroll halaman
            if (selectedRowIndex < rows.length - 1) {
                selectRow(selectedRowIndex + 1);
            }
            } else if (event.key === 'ArrowUp') {
            event.preventDefault(); // Mencegah scroll halaman
            if (selectedRowIndex > 0) {
                selectRow(selectedRowIndex - 1);
            }
            } else if (event.key === 'Enter' && selectedRowIndex !== -1) {
            // Kirim data menggunakan AJAX
            const selectedRow = rows[selectedRowIndex];
            const id = selectedRow.dataset.id;
            const nama = selectedRow.dataset.nama;
            const email = selectedRow.dataset.email;

            // Contoh penggunaan fetch API
            fetch('/proses_data', { // Ganti dengan URL endpoint Anda
                method: 'POST',
                headers: {
                'Content-Type': 'application/json',
                },
                body: JSON.stringify({ id: id, nama: nama, email: email }),
            })
            .then(response => response.json())
            .then(data => {
                console.log('Sukses:', data);
                // Lakukan sesuatu dengan respons dari server
            })
            .catch((error) => {
                console.error('Error:', error);
            });
            }
        });

        // Styling untuk baris yang dipilih (opsional)
        const style = document.createElement('style');
        style.innerHTML = `
            #myTable tbody tr.selected {
            background-color: #f0f0f0;
            }
        `;
        document.head.appendChild(style);
        });
    });
</script>
@endforeach