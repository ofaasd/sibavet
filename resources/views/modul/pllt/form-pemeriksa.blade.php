<div class="form-group row">
    <label for="pemeriksa_id" class="col-sm-2 col-form-label">Dokter / Petugas Pemeriksa</label>
    <div class="col-sm-10">
        <select name="pemeriksa_id" id="pemeriksa_id" class="form-control select2" style="width: 100%;" onchange="dataKecamatanTujuan()">
            <option value="">Pilih Dokter / Petugas Pemeriksa</option>
            @foreach($listPemeriksa as $key => $value)
                <option value="{{ $key }}" {{ $var['pemeriksaId'] == $key ? 'selected' : '' }}>{{ $value }}</option>
            @endforeach
        </select>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
