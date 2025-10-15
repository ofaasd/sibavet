<div class="form-group row">
    <label for="permintaan_uji_id" class="col-sm-2 col-form-label">Jenis Pengujian</label>
    <div class="col-sm-10">
        <select name="permintaan_uji_id" id="permintaan_uji_id" class="form-control select2" placeholder="Pilih Jenis Pengujian" style="width: 100%;">
            @foreach($listJenisPengujian as $id => $name)
                <option value="{{ $id }}" {{ ($var['jenisPengujianId'] == $id) ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
        </select>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
