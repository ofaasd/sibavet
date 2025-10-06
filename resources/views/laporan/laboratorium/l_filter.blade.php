<section>
    @if(Auth::user()->view_data > 2)
        <input type="hidden" name="sub_satuan_kerja_id" id="sub_satuan_kerja_id" value="{!! Auth::user()->sub_satuan_kerja_id !!}">
    @else
    <div class="form-group row">
        {!! Form::label('sub_satuan_kerja_id', 'Nama Laboratorium :', ['class' => 'col-sm-2 col-form-label']) !!}
        <div class="col-sm-9">
            {!! viewSelectLab($lab,'sub_satuan_kerja_id',@$keswan->sub_satuan_kerja_id) !!}
        </div>
    </div>
    @endif
    <div class="form-group row">
        {!! Form::label('', 'Tanggal :', ['class' => 'col-sm-2 col-form-label']) !!}
        <div class="col-sm-4">
            {!! viewSelectTanggal('tanggal_awal', date('1-m-Y'), ' tanggal')  !!}
        </div>
        <div class="col-sm-1" style="text-align: center;">
            s/d
        </div>
        <div class="col-sm-4">
            {!! viewSelectTanggal('tanggal_akhir', date('d-m-Y'), ' tanggal')  !!}
        </div>
    </div>
    <div class="form-group row">
        {!! Form::label('permintaan_uji', 'Jenis Pengujian :', ['class' => 'col-sm-2 col-form-label']) !!}
        <div class="col-sm-9">
             {!! viewSelectPermintaanUji($lab,'permintaan_uji[]') !!}
         </div>
    </div>
    <div class="form-group row">
        {!! Form::label('asal_contoh_id', 'Asal Contoh', ['class' => 'col-sm-2 col-form-label']) !!}
        <div class="col-sm-7">
            {!! viewSelectKota('asal_contoh_id') !!}
        </div>
    </div>

    <input type="hidden" name="tipe" id="tipe" value="PDF">
</section>       
<style>
    .tanggal{
        text-align: center;
    }
</style>
<!-- /.content -->
<script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2();
        $('.tanggal').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy'
        });

        $("#form-cetak-pengujian").validate({
            rules: {
                bulan: "required",
                tahun: "required",
                sub_satuan_kerja_id: "required",
            },
            messages: {
                bulan: "Kolom bulan harus diisi",
                tahun: "Kolom tahun harus diisi",
                sub_satuan_kerja_id: "Kolom laboratorium harus diisi",
            }
        });
    });
</script>