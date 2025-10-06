<div class="form-group row">
    {!! Form::label('kelurahan_id', 'Kelurahan', ['class' => 'col-sm-2 col-form-label']) !!}
    <div class="col-sm-10">
        {!! Form::select('kelurahan_id', $listKelurahan, $var['kelurahanId'], ['class'=>'form-control select2', 'placeholder'=>'Pilih Kelurahan', 'style'=>'width: 100%;']) !!}
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
