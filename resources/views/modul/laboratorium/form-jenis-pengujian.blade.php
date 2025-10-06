<div class="form-group row">
    {!! Form::label('permintaan_uji_id', 'Jenis Pengujian', ['class' => 'col-sm-2 col-form-label']) !!}
    <div class="col-sm-10">
        {!! Form::select('permintaan_uji_id', $listJenisPengujian, $var['jenisPengujianId'], ['class'=>'form-control select2', 'placeholder'=>'Pilih Jenis Pengujian', 'style'=>'width: 100%;']) !!}
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
