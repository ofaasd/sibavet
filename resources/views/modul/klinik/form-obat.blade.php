<div class="form-group row">
        {!! Form::label('terapi_id', 'Terapi / Tindakan', ['class' => 'col-sm-2 col-form-label']) !!}
    <div class="col-sm-10">
        {!! Form::select('terapi_id', $var['obat'], null, ['class'=>'form-control select2', 'placeholder'=>'Pilih Terapi / Tindakan', 'style'=>'width: 100%;']) !!}
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
