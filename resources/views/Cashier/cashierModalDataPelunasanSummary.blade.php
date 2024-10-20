@php
    $grandTotalKredit = '0';
    $grandTotalBayar = '0';
@endphp
<div class="card card-body table-responsive p-0" style="height:400px;">
    <table class="table table-valign-middle table-hover">
        <thead class="bg-gradient-purple">
            <tr>
                <th></th>
                <th>Nama Pelanggan</th>
                <th>Nomor Faktur</th>
                <th>Tgl. Faktur</th>
                <th>Kredit</th>
                <th>Dibayar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($datPinjaman as $dpn)
                <tr>
                    <td></td>
                    <td>{{$dpn->customer_store}}</td>
                    <td>{{$dpn->from_payment_code}}</td>
                    <td>{{date('d-M-Y', strtotime($dpn->created_at))}}</td>
                    <td><i class="fa-solid fa-rupiah-sign float-left"></i> <span class="float-right">{{number_format($dpn->nom_kredit,'0',',','.')}}</span></td>
                    <td><i class="fa-solid fa-rupiah-sign float-left"></i> <span class="float-right">{{number_format($dpn->nom_payed,'0',',','.')}}</span></td>
                </tr>
                @php
                    $grandTotalKredit += $dpn->nom_kredit; 
                    $grandTotalBayar += $dpn->nom_payed; 
                @endphp
            @endforeach
        </tbody>
        <tbody class="bg-light">
            <tr>
                <td class="font-weight-bold">Grand Total</td>
                <td></td>
                <td></td>
                <td></td>
                <td class="font-weight-bold"><i class="fa-solid fa-rupiah-sign float-left"></i> <span class="float-right">{{number_format($grandTotalKredit,'0',',','.')}}</span></td>
                <td class="font-weight-bold"><i class="fa-solid fa-rupiah-sign float-left"></i> <span class="float-right">{{number_format($grandTotalBayar,'0',',','.')}}</span></td>
            </tr>
        </tbody>
    </table>
</div>