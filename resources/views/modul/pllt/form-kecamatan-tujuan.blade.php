<div class="form-group row">
    <label for="kecamatan_tujuan_id" class="col-sm-2 col-form-label">Kecamatan</label>
    <div class="col-sm-10">
        <select name="kecamatan_tujuan_id" id="kecamatan_tujuan_id" class="form-control select2" style="width: 100%;">
            <option value="">Pilih Kecamatan</option>
            @foreach($listKecamatan as $key => $value)
                <option value="{{ $key }}" {{ $var['kecamatanId'] == $key ? 'selected' : '' }}>{{ $value }}</option>
            @endforeach
        </select>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
