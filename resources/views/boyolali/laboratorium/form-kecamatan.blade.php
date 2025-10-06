<div class="form-group row">
    {!! Form::label('kecamatan_id', 'Kecamatan', ['class' => 'col-sm-2 col-form-label']) !!}
        <div class="col-sm-10">
            {!! Form::select('kecamatan_id',$var['kecamatan'], null, ['class'=>'form-control', 'placeholder'=>'Pilih Kecamatan']) !!}
        </div>
</div>