<div class="form-group row">
    {!! Form::label('kabupaten_tujuan_id', 'Kota / Kabupaten', ['class' => 'col-sm-2 col-form-label']) !!}
    <div class="col-sm-10">
        {!! Form::select('kabupaten_tujuan_id', $listKota, $var['kotaId'], ['class'=>'form-control select2', 'placeholder'=>'Pilih Kota / Kabupaten', 'style'=>'width: 100%;', 'onchange'=>'dataKecamatanTujuan()']) !!}
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
