<div class="form-group row">
 <label for="jenis_contoh_id" class="col-sm-2 col-form-label">Jenis Contoh</label>
    <div class="col-sm-10">
 <select name="jenis_contoh_id" id="jenis_contoh_id" class="form-control select2" placeholder="Pilih Jenis Contoh" style="width: 100%;" onchange="bentukContoh()">
 @foreach($listJenisContoh as $id => $name)
 <option value="{{ $id }}" {{ ($var['jenisContohId'] == $id) ? 'selected' : '' }}>{{ $name }}</option>
 @endforeach
 </select>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
