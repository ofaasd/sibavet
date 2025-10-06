<div class="form-group row">
    {!! Form::label('kota_id', 'Kota / Kabupaten', ['class' => 'col-sm-2 col-form-label']) !!}
    <div class="col-sm-10">
        {!! Form::select('kota_id', $listKota, $var['kotaId'], ['class'=>'form-control select2', 'placeholder'=>'Pilih Kota / Kabupaten', 'style'=>'width: 100%;', 'onchange'=>'dataKecamatan()']) !!}
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
