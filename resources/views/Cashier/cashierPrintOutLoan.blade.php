@extends('layouts.print')
@section('content')
<div class="row">
    <div class="col-12 text-center">
        <h3 class="font-weight-bold">FAKTUR</h3>
    </div>
</div>
<div class="row">
    <div class="col-8">
        <p>Kepada Yth.</p>
        <address>
            <span class="font-weight-bold">{{$trStore->customer_name}}</span> <br>
            {{$trStore->address}}
        </address>
        <p>Kota : </p>
    </div>
    <div class="col-4">
        <dl class="row mb-0">
            <dt class="col-4">No.</dt>
            <dd class="col-8">{{$trStore->billing_number}}</dd>
        </dl>
        <dl class="row">
            <dt class="col-4">Tanggal</dt>
            <dd class="col-8">{{$trStore->tr_date}}</dd>
        </dl>
    </div>
</div>
<?php
    $no = '1';
?>
<div class="row">
    <div class="col-12">
        <table class="table table-sm table-bordered table-valign-middle">
            <thead class="bg-gray-dark font-weight-bold">
                <tr>
                    <th class="text-center">No.</th>
                    <th class="text-right">Qty</th>
                    <th class="text-left">Satuan</th>
                    <th class="text-center">Nama Barang</th>
                    <th class="text-center">Harga</th>
                    <th class="text-center">Total (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($trStoreList as $list)
                    <tr>
                        <td class="text-center">{{$no++}}</td>
                        <td class="text-right">{{$list->qty}}</td>
                        <td class="text-left">{{$list->unit}}</td>
                        <td>{{$list->product_name}}</td>
                        <td class="text-right">{{number_format($list->m_price,'0',',','.')}}</td>
                        <td class="text-right">{{number_format($list->t_price,'0',',','.')}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <p>Keterangan</p>
    </div>
    <div class="col-6">
        <table class="table table-sm">
            <tbody>
                <tr>
                    <td>Sub. Total</td>
                    <td class="text-right">:</td>
                    <td class="text-right">{{number_format($totalPayment->totalBilling,'0',',','.')}}</td>
                </tr>
                <tr>
                    <td>Discount</td>
                    <td class="text-right">:</td>
                    <td class="text-right">0</td>
                </tr>
                <tr>
                    <td>Bon Lalu</td>
                    <td class="text-right">:</td>
                    <td class="text-right">
                        <?php
                            if($countBilling >= '1'){
                                $lastKredit = $remainKredit->kredit;
                            }
                            else{
                                $lastKredit = '0';
                            }
                        ?>
                        {{number_format($lastKredit,0,',','.')}}
                    </td>
                </tr>
                <tr>
                    <td>PPN</td>
                    <td class="text-right">:</td>
                    <td class="text-right"></td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td class="text-right">:</td>
                    <td class="text-right">
                        <?php
                            if($countBilling >= '1'){
                                $lastKredit = $remainKredit->kredit;
                            }
                            else{
                                $lastKredit = '0';
                            }
                        ?>
                        {{number_format($lastKredit,0,',','.')}}
                    </td>
                </tr>
                
            </tbody>
        </table>
        <table cellpadding="0" cellspacing="0" style="width:100%" class="table">
            <tbody>
                @foreach($paymentRecord as $pr)
                    <tr>
                        <td class="font-weight-bold">Pembayaran</td>
                        <td class="txt-right font-weight-bold" align="right">{{$pr->methodName}}</td>
                        <td class="txt-right font-weight-bold" align="right">{{number_format($sumpaymentRecord->nominal,0,',','.')}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <table class="table table-borderless">
            <thead class="text-center">
                <tr>
                    <td>Hormat Kami</td>
                    <td>Tanda Terima</td>
                </tr>
            </thead>
            <tbody class="text-center font-weight-bold">
                <tr>
                    <td>
                        @if(!empty($companyName))
                        {{$companyName->company_name}}
                        @else
                        <b>------</b>
                        @endif
                    </td>
                    <td>{{$trStore->customer_name}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<script>
    window.addEventListener("load", window.print());
</script>
@endsection