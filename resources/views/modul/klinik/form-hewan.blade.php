<div class="form-group row">
    <label for="hewan" class="col-sm-2 col-form-label">Nama Hewan</label>
    <div class="col-sm-10">
        @php 
				var_dump($listHewan)
			@endphp
		<select name="pemilik_id" id="pemilik_id" class="form-control select2" style="width:100%" onchange="dataHewan()">
			<option value="0">Pilih Hewan</option>
			@foreach($listHewan as $row)
				<option value="{{$row->id}}">{{$row->nama_hewan}}</option>
			@endforeach
			<option value="999999999999">Lainnya</option>
		</select>
    </div>
</div>
