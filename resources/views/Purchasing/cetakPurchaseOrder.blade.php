<link rel="stylesheet" href="{{asset('public/dazbuild/dist/css/adminlte.min.css')}}">
<script src="{{asset('public/dazbuild/dist/js/adminlte.min.js')}}"></script>
<style>
.table-list {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

.table-list td, .table-list th {
  border: 1px solid #ddd;
  padding: 8px;
}

.table-list th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #04AA6D;
  color: white;
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
<table class="table-list">
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


