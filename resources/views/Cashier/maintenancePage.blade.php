@extends('layouts.frontpage')
@section('content')
<script src="{{asset('public/js/cashierButton.js')}}"></script>
<div class="content mt-0">
    <div class="container-fluid">
        @if($checkArea <> 0)    
        <div class="row">
            <div class="col-md-12">
            <table id="myTable" border="1">
                <thead>
                    <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <tr data-id="1" data-nama="John Doe" data-email="john@example.com">
                    <td>1</td>
                    <td>John Doe</td>
                    <td>john@example.com</td>
                    </tr>
                    <tr data-id="2" data-nama="Jane Smith" data-email="jane@example.com">
                    <td>2</td>
                    <td>Jane Smith</td>
                    <td>jane@example.com</td>
                    </tr>
                    <tr data-id="3" data-nama="Peter Jones" data-email="peter@example.com">
                    <td>3</td>
                    <td>Peter Jones</td>
                    <td>peter@example.com</td>
                    </tr>
                </tbody>
                </table>
            </div>
        </div>        
        <div class="row">
            <div class="col-12 col-lg-8 pr-0">
                @include('Global.global_spinner')
                <div class="card">
                    <div class="card-body p-0 table-responsive" style="height:700px;">                        
                        <div id="mainListProduct"></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div id="mainButton"></div>
            </div>
        </div>
        @else
            <div class="row d-flex justify-content-center">
                <div class="col-8">
                    <div class="alert alert-warning alert-dismissible text-center">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                        <span class="font-weight-bold">
                            User anda belum memiliki hak akses dikarenakan belum di setup area kerjanya, silahkan hubungi administrator untuk lebih lanjutnya!
                        </span>
                    </div>                        
                </div>
            </div>
        @endif
    </div>
</div>
<script>
    $(document).ready(function(){
        let routeIndex = "{{route('Cashier')}}",
            urlProductList = "productList",
            panelProductList = $("#mainListProduct"),
            urlButtonForm = "buttonAction",
            panelButtonForm = $("#mainButton");

        cashier_style.load_productList(routeIndex,urlProductList,panelProductList);
        cashier_style.load_buttonForm(routeIndex,urlButtonForm,panelButtonForm);

        document.addEventListener('DOMContentLoaded', function() {
        const table = document.getElementById('myTable');
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
        if (event.key === 'ArrowDown' || event.key === 40) {
            event.preventDefault(); // Mencegah scroll halaman
            if (selectedRowIndex < rows.length - 1) {
                selectRow(selectedRowIndex + 1);
            }
            alert("Tombol Turun");
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

@endsection