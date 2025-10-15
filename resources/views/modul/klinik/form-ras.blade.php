<div class="form-group row">
    <label for="ras_id" class="col-sm-2 col-form-label">Ras</label>
    <div class="col-sm-10">
        <select name="ras_id" id="ras_id" class="form-control select2" placeholder="Pilih Ras" style="width: 100%;">
            @foreach($listRas as $id => $name)
                <option value="{{ $id }}" {{ ($var['rasId'] == $id) ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
        </select>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
