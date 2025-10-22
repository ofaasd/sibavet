<div class="form-group row">
    <div class="col-sm-10">
		<select name="hewan" id="hewan" class="form-control select2" style="width:100%" onchange="dataHewan()">
			<option value="0">Pilih Hewan</option>
			@foreach($listHewan as $row)
				<option value="{{$row->id}}">{{$row->nama_hewan}}</option>
			@endforeach
			<option value="999999999999">Lainnya</option>
		</select>
		<div id="new_hewan">
															
		</div>	
    </div>
</div>
<script>
	$(document).ready(function(){
		$('.select2').select2();
	});
</script>