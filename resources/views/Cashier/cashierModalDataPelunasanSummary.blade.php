@php
    $grandTotalKredit = '0';
    $grandTotalBayar = '0';
    $grandSaldoKredit = '0';
@endphp
<div class="card card-purple" >  
    <div class="card-header">
        <h3 class="card-title">Summary Hutang Pelanggan</h3>
    </div>  
    <div class="card-bidy text-xs table-responsive" style="height:500px;">
        <table class="table table-valign-middle table-hover table-sm">
            <thead>
                <tr>
                    <th>Nama Pelanggan</th>
                    <th>Nomor Faktur</th>
                    <th>Tgl. Faktur</th>
                    <th><i class="fa-solid fa-rupiah-sign float-left"></i> <span class="float-right">Kredit</span></th>
                    <th><i class="fa-solid fa-rupiah-sign float-left"></i> <span class="float-right">Dibayar</span></th>
                    <th><i class="fa-solid fa-rupiah-sign float-left"></i> <span class="float-right">Sisa Kredit</span></th>
                </tr>
            </thead>
            <tbody>
                @foreach($datPinjaman as $dpn)
                    <tr>
                        <td>{{$dpn->customer_store}}</td>
                        <td>{{$dpn->from_payment_code}}</td>
                        <td>{{date('d-M-Y', strtotime($dpn->created_at))}}</td>
                        <td class="text-right">{{number_format($dpn->nominal,'0',',','.')}}</td>
                        <td class="text-right">{{number_format($dpn->nom_payed,'0',',','.')}}</td>
                        <td class="text-right">{{number_format($dpn->nom_kredit,'0',',','.')}}</td>
                    </tr>
                    @php
                        $grandTotalKredit += $dpn->nominal; 
                        $grandTotalBayar += $dpn->nom_payed; 
                        $grandSaldoKredit += $dpn->nom_kredit; 
                    @endphp
                @endforeach
            </tbody>
            <tbody class="bg-light">
                <tr>
                    <td class="font-weight-bold" colspan="3">Grand Total</td>
                    <td class="font-weight-bold"><i class="fa-solid fa-rupiah-sign float-left"></i> <span class="float-right">{{number_format($grandTotalKredit,'0',',','.')}}</span></td>
                    <td class="font-weight-bold"><i class="fa-solid fa-rupiah-sign float-left"></i> <span class="float-right">{{number_format($grandTotalBayar,'0',',','.')}}</span></td>
                    <td class="font-weight-bold"><i class="fa-solid fa-rupiah-sign float-left"></i> <span class="float-right">{{number_format($grandSaldoKredit,'0',',','.')}}</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>