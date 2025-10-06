<div class="form-group row">
    {!! Form::label('kota', 'Kota / Kabupaten', ['class' => 'col-sm-2 col-form-label']) !!}
        <div class="col-sm-10">
            {!! Form::select('kota',$var['kota'], null, ['class'=>'form-control', 'placeholder'=>'Pilih Kota / Kabupaten']) !!}
        </div>
</div>