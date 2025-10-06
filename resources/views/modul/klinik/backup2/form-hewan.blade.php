<div class="form-group row">
    {!! Form::label('hewan', 'Nama Hewan', ['class' => 'col-sm-2 col-form-label']) !!}
    <div class="col-sm-10">
        {!! Form::select('hewan',$listHewan,null, ['class'=>'form-control select2', 'placeholder'=>'Pilih Nama Hewan', 'style'=>'width: 100%;','onchange' => 'dataHewan()']) !!}
    </div>
</div>
