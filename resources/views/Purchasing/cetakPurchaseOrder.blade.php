<link rel="stylesheet" href="{{asset('public/dazbuild/dist/css/adminlte.min.css')}}">
<script src="{{asset('public/dazbuild/dist/js/adminlte.min.js')}}"></script>
<style>
.table-title {
  font-family: Arial, Helvetica, sans-serif;
  font-size: 12px;
  border-collapse: collapse;
  width: 100%;
}

.table-title td, .table-title th {
    border-bottom: 1px solid #ddd;
    /* padding: 8px; */
}

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
<?php
    $totalHargaSatuan = 0;
    $totalHargaDiscount = 0;
    $totalHargaJumlah = 0;
    $totalPotongan = 0;
    $dodate = 0;
?>
<table class="table-title">
    <tbody>
        <tr>
            <td><b>No. Transaksi</b></td>
            <td>{{$purchaseOrder->purchase_number}}</td>
            <td><b>Metode Pembayaran</b></td>
            <td>
                @if($purchaseOrder->payment_methode == '1' OR $purchaseOrder->payment_methode == '2')
                    {{$purchaseOrder->tempo}} : 
                @if($purchaseOrder->bank_account <> '0')
                    {{$purchaseOrder->bank_code}}-{{substr($purchaseOrder->account_number,'4')}}
                    @endif
                @else
                    <?php
                        $dodate = date("d/M/Y", strtotime("+".$purchaseOrder->tempo."day",strtotime($purchaseOrder->delivery_date)));
                    ?>
                    Tempo : {{$purchaseOrder->tempo}} <br>
                    Tgl. Jatuh Tempo : {{$dodate}};
                @endif
            </td>
            <td><b>Nomor Faktur</b></td>
            <td>{{$purchaseOrder->faktur_number}}</td>
            <td><b>Tgl. Faktur</b></td>
            <td>{{$purchaseOrder->faktur_date}}</td>
        </tr>
        <tr>
            <td><b>Supplier</b></td>
            <td>
                {{$purchaseOrder->store_name}}
                <br>
                <small>{{$purchaseOrder->address}}, {{$purchaseOrder->city}}</small>
            </td>
            <td><b>Nomor SJ</b></td>
            <td>{{$purchaseOrder->do_number}}</td>
            <td><b>Tgl. Pengiriman</b></td>
            <td>{{$purchaseOrder->delivery_date}}</td>
            <td></td>
            <td></td>
        </tr>
    </tbody>
</table>
<?php
    $nomor = 1;
?>
<table class="table-list">
    <thead>
        <tr>
            <th>No.</th>
            <th>Produk</th>
            <th>Satuan</th>
            <th>Qty</th>
            <th>Gudang</th>
            <th>Saldo Awal</th>
            <th>Saldo Akhir</th>
            <th>Harga Satuan</th>
            <th>Disc.</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>
        @foreach($purchaseListOrder as $plo)
        <tr>
            <td>{{$nomor++}}</td>
            <td>{{$plo->product_name}}</td>
            <td>{{$plo->satuan}}</td>
            <td>{{$plo->qty}}</td>
            <td>{{$plo->site_name}}</td>
            <td>{{$plo->stock_awal}}</td>
            <td>{{$plo->stock_akhir}}</td>
            <td class="text-right">{{number_format($plo->unit_price,'0',',','.')}}</td>
            <td class="text-right">{{number_format($plo->discount,'0',',','.')}}</td>
            <td class="text-right">{{number_format($plo->total_price,'0',',','.')}}</td>
        </tr>
        <?php
            $totalHargaSatuan += $plo->unit_price;
            $totalHargaDiscount += $plo->discount;
            $totalHargaJumlah += $plo->total_price;
        ?>
        @endforeach
        <?php
            $potonganVoucher = $purchaseOrder->total_potongan;
            $totalPotongan = $totalHargaJumlah - $potonganVoucher;
        ?>
        <tr>
            <td colspan="9" class="text-right font-weight-bold">Total</td>            
            <td class="text-right font-weight-bold">{{number_format($totalHargaJumlah,'0',',','.')}}</td>
        </tr>
        <tr>
            <td colspan="9" class="text-right font-weight-bold">Voucher -</td>
            <td class="text-right font-weight-bold">{{number_format($potonganVoucher,'0',',','.')}}</td>
        </tr>
        <tr>
            <td colspan="9"></td>
            <td class="text-right font-weight-bold">{{number_format($totalPotongan,'0',',','.')}}</td>            
        </tr>
    </tbody>
</table>


