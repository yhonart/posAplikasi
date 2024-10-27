<?php
    $no = '1';
    $arayStatus = array(
        0=>"Trs. Batal",
        1=>"Dlm. Proses",
        2=>"Hold",
        3=>"Kredit",
        4=>"Trs. Sukses",
    );
    $arayColor = array(
        0=>"bg-danger",
        1=>"bg-info",
        2=>"bg-warning",
        3=>"bg-success",
        4=>"bg-success",
    );
?>
<div class="card">
    <div class="card-body table-responsive" style="height:500px;">
        <table class="table table-bordered table-sm table-hover">
            <thead class="bg-gray font-weight-bold text-center">
                <tr>
                    <td>No.</td>
                    <td>Kode Transaksi</td>
                    <td>Tanggal</td>
                    <td>Kasir</td>
                    <td>Pelanggan</td>
                    <td>Jenis Pembayaran</td>
                    <td>Total Belanja</td>
                    <td>Total Pembayaran</td>
                    <td>Bank Transfer</td>
                    <td>Status</td>
                </tr>
            </thead>
            <tbody>
                @if($condition == "alltrx")
                    @foreach($allCondition as $aC)
                        <tr>
                            <td>{{$no++}}</td>
                            <td>
                                {{$aC->core_id_trx}}
                            </td>
                            <td>{{$aC->date_trx}}</td>
                            <td>{{$aC->created_by}}</td>
                            <td>{{$aC->customer_store}}</td>
                            <td>{{$aC->bankTransfer}}</td>
                            <td>{{number_format($aC->total_struk,'0',',','.')}}</td>
                            <td>{{number_format($aC->total_payment,'0',',','.')}}</td>
                            <td>{{$aC->bank_name}}</td>
                            <td></td>
                        </tr>
                    @endforeach
                @elseif($condition == "onprocess")
                    @foreach($allCondition as $aC)
                        <tr>
                            <td>{{$no++}}</td>
                            <td>{{$aC->billing_number}}</td>
                            <td>{{$aC->tr_date}}</td>
                            <td>{{$aC->created_by}}</td>
                            <td>{{$aC->customer_name}}</td>
                            <td>-</td>
                            <td>{{number_format($aC->t_bill,'0',',','.')}}</td>
                            <td>{{number_format($aC->t_pay,'0',',','.')}}</td>
                            <td>-</td>
                            <td class="text-right {{$arayColor[$aC->status]}}">
                                    {{$arayStatus[$aC->status]}}
                            </td>
                        </tr>
                    @endforeach
                @elseif($condition == "kredit")
                    @foreach($allCondition as $aC)
                        <tr>
                            <td>{{$no++}}</td>
                            <td>{{$aC->from_payment_code}}</td>
                            <td>{{$aC->created_at}}</td>
                            <td>{{$aC->created_by}}</td>
                            <td>{{$aC->customer_store}}</td>
                            <td>-</td>
                            <td>{{number_format($aC->nominal,'0',',','.')}}</td>
                            <td>{{number_format($aC->nom_payed,'0',',','.')}}</td>
                            <td>-</td>
                            <td></td>
                        </tr>
                    @endforeach
                @elseif($condition == "allSummery")
                    @foreach($allCondition as $aC)
                        <tr>
                            <td>{{$no++}}</td>
                            <td>
                                <a href="{{route('Dashboard')}}/modalLogTrx/{{$aC->billing_number}}" class="text-info font-weight-bold BTN-OPEN-MODAL-GLOBAL-LG">
                                    {{$aC->billing_number}}                                
                                </a>
                            </td>
                            <td>{{$aC->tr_date}}</td>
                            <td>{{$aC->created_by}}</td>
                            <td>{{$aC->customer_name}}</td>
                            <td>-</td>
                            <td>{{number_format($aC->t_bill,'0',',','.')}}</td>
                            <td>
                                <?php
                                    if($aC->t_pay >= $aC->t_bill){
                                        $selisih = $aC->t_bill;
                                    }
                                    elseif($aC->t_pay < $aC->t_bill){
                                        $selisih = $aC->t_bill - $aC->t_pay - $aC->t_bill;
                                    }
                                    else{
                                        $selisih = '0';
                                    }
                                ?>
                                {{number_format($selisih,'0',',','.')}}
                            </td>
                            <td>-</td>
                            <td class="text-right {{$arayColor[$aC->status]}}">
                                    {{$arayStatus[$aC->status]}}
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>