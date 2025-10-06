<div class="form-group row">
    {!! Form::label('pemeriksa_id', 'Dokter / Petugas Pemeriksa', ['class' => 'col-sm-2 col-form-label']) !!}
    <div class="col-sm-10">
        {!! Form::select('pemeriksa_id', $listPemeriksa, $var['pemeriksaId'], ['class'=>'form-control select2', 'placeholder'=>'Pilih Dokter / Petugas Pemeriksa', 'style'=>'width: 100%;', 'onchange'=>'dataKecamatanTujuan()']) !!}
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
