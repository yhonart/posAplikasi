<link rel="stylesheet" href="{{asset('public/dazbuild/dist/css/adminlte.min.css')}}">
<script src="{{asset('public/dazbuild/dist/js/adminlte.min.js')}}"></script>
<style>
    .styled-table {
        border-collapse: collapse;
        margin: 25px 0;
        font-size: 6;
        font-family: sans-serif;
        min-width: 400px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
        border: 1px solid #dee2e6;
    }.styled-table-2 tbody tr th,
    .styled-table thead tr {
        background-color: #17a2b8;
        color: #ffffff;
        text-align: left;
    }
    .styled-table th,
    .styled-table td {
        padding: 6px 7px;
        border: 1px solid #dee2e6;
    }
    .styled-table tbody tr.active-row {
        font-weight: bold;
        color: #009879;
    }
    .styled-table tbody{
        vertical-align: top;
        border: 1px solid #dee2e6;
    }
    .styled-table .date_check{
        width: 100%;
    }
    .judul{
        text-align: left;
        font-size: 1em;
        font-family: sans-serif;
    }
    .judul p{
        margin: 0.1em;
    }
    .span {
        font-size :8;
    }
    .total {
        font-size : 7;
    }
    .grand-total {
        font-size : 7;
    }
</style>
<?php
    $no = '1';
    $sumTunai = '0';
    $sumTransfer = '0';
    $sumTempo1 = '0';
    $sumTempo2 = '0';
    $sumPoint = '0';
    $sumBelanja = '0';
    $kurangBayar = '0';
    $bon = '0';
    $return = '0';
    $kreditRecord = '0';
    $sumKreditTf = '0';
    $grndTotalKredit = '0';
    $totalPenerimaan = '0';
    $totalBelanjaTunai = '0';
    $totalBelanjaTransfer = '0';
    $grndTotalBelanja = '0';

    function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = penyebut($nilai - 10). " Belas";
		} else if ($nilai < 100) {
			$temp = penyebut($nilai/10)." Puluh". penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = penyebut($nilai/100) . " Ratus" . penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = penyebut($nilai/1000) . " Ribu" . penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = penyebut($nilai/1000000) . " Juta" . penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = penyebut($nilai/1000000000) . " Milyar" . penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = penyebut($nilai/1000000000000) . " Trilyun" . penyebut(fmod($nilai,1000000000000));
		}     
		return $temp;
	}

    function terbilang($nilai) {
        if($nilai<0) {
            $hasil = "minus ". trim(penyebut($nilai));
        } else {
            $hasil = trim(penyebut($nilai));
        }     		
        return $hasil;
    }
?>
<table cellpadding="0" cellspacing="0" style="width:100%">
    <tbody>
        <tr>
            <td>No. Transaksi</td>
            <td>{{$purchaseOrder->purchase_number}}</td>
            <td>Metode Pembayaran</td>
            <td>
                @if($purchaseOrder->payment_methode == '1' OR $purchaseOrder->payment_methode == '2')
                    {{$purchaseOrder->tempo}} : 
                    @if($purchaseOrder->bank_account <> '0')
                    {{$purchaseOrder->bank_code}}-{{substr($purchaseOrder->account_number,'4')}}
                    @endif
                @else
                    Tempo : {{$purchaseOrder->tempo}}
                @endif
            </td>
        </tr>
        <tr>
            <td>Supplier</td>
            <td>
                {{$purchaseOrder->store_name}}
                <br>
                <small>{{$purchaseOrder->address}}, {{$purchaseOrder->city}}</small>
            </td>
        </tr>
    </tbody>
</table>
<div class="row">
    <div class="col-md-4">
        <dl class="row">
            <dt class="col-md-4">Nomor Transaksi</dt>
            <dd class="col-md-8">{{$purchaseOrder->purchase_number}}</dd>
        </dl>
    </div>
</div>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>NO. PERKIRAAN</th>
            <th>KETERANGAN</th>
            <th>DEBIT</th>
            <th>KREDIT</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            
        </tr>
    </tbody>
</table>


