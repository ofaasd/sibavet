<div class="form-group row">
    {!! Form::label('bentuk_contoh_id', 'Bentuk Contoh', ['class' => 'col-sm-2 col-form-label']) !!}
    <div class="col-sm-10">
        {!! Form::select('bentuk_contoh_id', $listBentukContoh, $var['bentukContohId'], ['class'=>'form-control select2', 'placeholder'=>'Pilih Bentuk Contoh', 'style'=>'width: 100%;']) !!}
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
