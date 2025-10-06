<div class="form-group row">
    {!! Form::label('ras_id', 'Ras', ['class' => 'col-sm-2 col-form-label']) !!}
    <div class="col-sm-10">
        {!! Form::select('ras_id', $listRas, $var['rasId'], ['class'=>'form-control select2', 'placeholder'=>'Pilih Ras', 'style'=>'width: 100%;']) !!}
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
