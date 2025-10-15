<div class="form-group row">
    <label for="kabupaten_asal_id" class="col-sm-2 col-form-label">Kota / Kabupaten</label>
    <div class="col-sm-10">
        <select name="kabupaten_asal_id" id="kabupaten_asal_id" class="form-control select2" style="width: 100%;" onchange="dataKecamatanAsal()">
            <option value="">Pilih Kota / Kabupaten</option>
            @foreach($listKota as $key => $value)
                <option value="{{ $key }}" {{ $var['kotaId'] == $key ? 'selected' : '' }}>{{ $value }}</option>
            @endforeach
        </select>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
