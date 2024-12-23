<select class="form-control form-control-sm select-2" name="methodPayment" id="methodPayment">
    @if($mSupplier->payment_type == "Tunai")
    <option value="1">Tunai</option>
    <option value="2">Transfer</option>
    @elseif($mSupplier->payment_type == "Tempo")
    <option value="3">Tempo [Custome]</option>
    <option value="30">Net 30</option>
    <option value="15">Net 15</option>
    <option value="60">Net 60</option>
    @else
    <option value="1">Tunai</option>
    <option value="2">Transfer</option>
    <option value="3">Tempo [Custome]</option>
    <option value="30">Net 30</option>
    <option value="15">Net 15</option>
    <option value="60">Net 60</option>
    @endif
</select>