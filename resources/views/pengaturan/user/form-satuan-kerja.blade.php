<div class="form-group row">
    {!! Form::label('sub_satuan_kerja_id', 'Sub Satuan Kerja', ['class' => 'col-sm-2 col-form-label']) !!}
    <div class="col-sm-10">
        {!! Form::select('sub_satuan_kerja_id', $listSubSatuanKerja, $var['subSatuanKerjaId'], ['class'=>'form-control', 'placeholder'=>'Pilih Sub Satuan Kerja']) !!}
    </div>
</div>
