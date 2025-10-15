<div class="form-group row">
    <label for="kelurahan_id" class="col-sm-2 col-form-label">Kelurahan</label>
    <div class="col-sm-10">
        <select name="kelurahan_id" id="kelurahan_id" class="form-control select2" style="width: 100%;">
            <option value="">Pilih Kelurahan</option>
            @foreach($listKelurahan as $key => $value)
                <option value="{{ $key }}" {{ $var['kelurahanId'] == $key ? 'selected' : '' }}>{{ $value }}</option>
            @endforeach
        </select>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
