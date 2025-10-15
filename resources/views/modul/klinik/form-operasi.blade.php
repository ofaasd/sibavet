<div class="form-group row">
    <label for="terapi_id" class="col-sm-2 col-form-label">Terapi / Tindakan</label>
    <div class="col-sm-10">
        <select name="terapi_id" id="terapi_id" class="form-control select2" placeholder="Pilih Terapi / Tindakan" style="width: 100%;">
            @foreach($var['operasi'] as $id => $name)
                <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </select>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
