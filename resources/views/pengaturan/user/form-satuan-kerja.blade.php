<div class="form-group row">
    <label for="sub_satuan_kerja_id" class="col-sm-2 col-form-label">Sub Satuan Kerja</label>
    <div class="col-sm-10">
        <select name="sub_satuan_kerja_id" id="sub_satuan_kerja_id" class="form-control">
            <option value="">Pilih Sub Satuan Kerja</option>
            @foreach($listSubSatuanKerja as $key => $value)
                <option value="{{ $key }}" {{ $var['subSatuanKerjaId'] == $key ? 'selected' : '' }}>{{ $value }}</option>
            @endforeach
    </div>
</div>
