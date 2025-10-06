<div class="form-group row">
    {!! Form::label('jenis_contoh_id', 'Jenis Contoh', ['class' => 'col-sm-2 col-form-label']) !!}
    <div class="col-sm-10">
        {!! Form::select('jenis_contoh_id', $listJenisContoh, $var['jenisContohId'], ['class'=>'form-control select2', 'placeholder'=>'Pilih Jenis Contoh', 'style'=>'width: 100%;', 'onchange'=>'bentukContoh()']) !!}
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
