<div class="form-group row">
    {!! Form::label('jenis_hewan_id', 'Ras', ['class' => 'col-sm-2 col-form-label']) !!}
    <div class="col-sm-10">
        {!! Form::select('jenis_hewan_id', $listJenisHewan, $var['jenisHewanId'], ['class'=>'form-control select2', 'placeholder'=>'Pilih Ras', 'style'=>'width: 100%;']) !!}
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
