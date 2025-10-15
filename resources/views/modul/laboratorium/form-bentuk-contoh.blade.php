<div class="form-group row">
    <label for="bentuk_contoh_id" class="col-sm-2 col-form-label">Bentuk Contoh</label>
    <div class="col-sm-10">
        <select name="bentuk_contoh_id" id="bentuk_contoh_id" class="form-control select2" placeholder="Pilih Bentuk Contoh" style="width: 100%;">
            @foreach($listBentukContoh as $id => $name)
                <option value="{{ $id }}" {{ ($var['bentukContohId'] == $id) ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
        </select>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
