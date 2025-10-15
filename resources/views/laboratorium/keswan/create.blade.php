<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <a href="{!! URL::to('/lab/keswan') !!}"><i class="fa fa-angle-left" style="font-size: 20pt"></i>&nbsp;Lab-Keswan<a><small> FORM 01 - Penerimaan Contoh</small>
    </h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{!! URL::to('/lab/keswan') !!}"><i class="fa fa-hospital-o"/>Lab-Keswan</a></li>
        <li class="breadcrumb-item active">FORM 01</li>
    </ol>
</section>
<form id="form-keswan" method="POST" action="/lab/keswan/create" class="validation-wizard wizard-circle" enctype="multipart/form-data">
@csrf
<section class="content">
    <div class="row">
        <div class="col-12 col-lg-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h4 class="box-title">FORM 01 - Penerimaan Contoh</h4>
                    <ul class="box-controls pull-right">
                      <li><a class="box-btn-fullscreen" href="#"></a></li>
                      <li><a class="box-btn-slide" href="#"></a></li>   
                    </ul>
                </div>
                <div class="box-body wizard-content">
                    <section>
                        <div class="form-group row">
                            <label for="no_epid" class="col-sm-2 col-form-label" style="font-weight:bold;text-align:right;">No. EPID :</label>
                            <div class="col-sm-2">                                
                                <select name="status_epid" id="status_epid" class="form-control" placeholder="- Status EPID -">
                                    <option value="">- Status EPID -</option>
                                    <option value="ES">ES (Pasif)</option>
                                    <option value="ED">ED (Aktif)</option>
                                </select>
                            </div>
                            <div class="col-sm-5">
                                <input type="text" name="no_epid" id="no_epid" class="form-control" placeholder="Inputkan Nomor EPID" style="font-weight:bold;">
                            </div>
                        </div>
                        @if(Auth::user()->role == 'Administrator')
                        <div class="form-group row">
                            <label for="sub_satuan_kerja_id" class="col-sm-2 col-form-label">Nama Laboratorium :</label>
                            <div class="col-sm-10">
                                {{-- {!! viewSelectLab(1,'sub_satuan_kerja_id','','col-sm-5') !!} --}}
                                <select name="sub_satuan_kerja_id" id="sub_satuan_kerja_id" class="form-control col-sm-5">
                                    @foreach($subSatuanKerja as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endif
                        <div class="form-group row">                            
                            <label for="nama_pengirim_id" class="col-sm-2 col-form-label">Nama Pengirim :</label>
                            <div class="col-sm-10">
                                {{-- {!! viewSelectCustomer('nama_pengirim_id','','col-sm-5') !!} --}}
                                <select name="nama_pengirim_id" id="nama_pengirim_id" class="form-control col-sm-5">
                                    @foreach($customers as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">                            
                            <label for="alamat_pengirim" class="col-sm-2 col-form-label">Alamat Pengirim :</label>
                            <div class="col-sm-10">
                                <input type="text" name="alamat_pengirim" id="alamat_pengirim" class="form-control" placeholder="Alamat Pengirim" readonly value="{{ ($var['method']=='edit' || $var['method']=='show') ? (@$listLaboratorium->customer->alamat) : '' }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="jenis_hewan_id" class="col-sm-2 col-form-label">Jenis Hewan :</label>
                            <div class="col-sm-10">
                                {{-- {!! viewSelectSpesies(1,'jenis_hewan_id','','col-sm-4') !!} --}}
                                <select name="jenis_hewan_id" id="jenis_hewan_id" class="form-control col-sm-4">
                                    @foreach($spesies as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">                            
                            <label for="" class="col-sm-2 col-form-label">Contoh :</label>
                            <div class="col-sm-10">
                                <table class="table table-bordered mb-0" id='tabel_contoh'>
                                    <thead>
                                        <tr>
                                        <th style="width: 100pt;">Jumlah</th>
                                        <th>Jenis Contoh</th>
                                        <th style="width: 20pt;">#</th>
                                    </tr>
                                </table>
                                <br>
                                <a href="#" class="btn btn-rounded btn-sm btn-info" id="tambah_contoh">Tambah Contoh</a>
                            </div>
                        </div>
                        <div id="areaJenisPengujian">
                            <div class="form-group row">
                                <label for="permintaan_uji_id[]" class="col-sm-2 col-form-label">Permintaan Uji :</label>
                                <div class="col-sm-10">
                                    {{-- {!! viewSelectPermintaanUji('1','permintaan_uji[]')!!} --}}
                                    <select name="permintaan_uji[]" id="permintaan_uji[]" class="form-control select2" multiple="multiple" data-placeholder="Pilih Permintaan Uji">
                                        @foreach($permintaanUji as $id => $name)
                                            <option value="{{ $id }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">                            
                            <label for="kriteria_contoh" class="col-sm-2 col-form-label">Kriteria Contoh :</label>
                            <div class="col-sm-10"
>                               <input name="kriteria_contoh" class="with-gap radio-col-blue form-control" type="radio" id="memenuhi" value="MS" checked="">
                                <label for="memenuhi">Memenuhi Syarat</label>&nbsp;&nbsp;&nbsp;
                                <input name="kriteria_contoh" class="with-gap radio-col-red form-control" type="radio" id="tidak_memenuhi" value="TMS">
                                <label for="tidak_memenuhi">Tidak Memenuhi Syarat</label>
                            </div>
                        </div>                        
                        <div class="form-group row">                            
                            <label for="peralatan" class="col-sm-2 col-form-label">Peralatan :</label>
                            <div class="col-sm-10"
>                               <input name="peralatan" class="with-gap radio-col-blue form-control" type="radio" id="peralatan_mampu" value="Mampu" checked="">
                                <label for="peralatan_mampu">Mampu</label>&nbsp;&nbsp;&nbsp;
                                <input name="peralatan" class="with-gap radio-col-red form-control" type="radio" id="peralatan_tidak_mampu" value="Tidak Mampu">
                                <label for="peralatan_tidak_mampu">Tidak Mampu</label>
                            </div>
                        </div>                        
                        <div class="form-group row">                            
                            <label for="bahan" class="col-sm-2 col-form-label">Bahan :</label>
                            <div class="col-sm-10"
>                               <input name="bahan" class="with-gap radio-col-blue form-control" type="radio" id="bahan_mampu" value="Mampu" checked="">
                                <label for="bahan_mampu">Mampu</label>&nbsp;&nbsp;&nbsp;
                                <input name="bahan" class="with-gap radio-col-red form-control" type="radio" id="bahan_tidak_mampu" value="Tidak Mampu">
                                <label for="bahan_tidak_mampu">Tidak Mampu</label>
                            </div>
                        </div>                        
                        <div class="form-group row">                            
                            <label for="personil" class="col-sm-2 col-form-label">Personil :</label>
                            <div class="col-sm-10"
>                               <input name="personil" class="with-gap radio-col-blue form-control" type="radio" id="personil_mampu" value="Mampu" checked="">
                                <label for="personil_mampu">Mampu</label>&nbsp;&nbsp;&nbsp;
                                <input name="personil" class="with-gap radio-col-red form-control" type="radio" id="personil_tidak_mampu" value="Tidak Mampu">
                                <label for="personil_tidak_mampu">Tidak Mampu</label>
                            </div>
                        </div>                        
                        <div class="form-group row">                            
                            <label for="catatan" class="col-sm-2 col-form-label">Catatan/Saran :</label>
                            <div class="col-sm-10">
                                <textarea name="catatan" id="catatan" class="form-control" rows="2" placeholder="Catatan/Saran"></textarea>
                            </div>
                        </div>                        
                        <div class="form-group row">                            
                            <label for="pengirim" class="col-sm-2 col-form-label">Pengirim :</label>
                            <div class="col-sm-10">
                                <input type="text" name="pengirim" id="pengirim" class="form-control col-sm-4" placeholder="Nama Pengirim">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="penerima" class="col-sm-2 col-form-label">Penerima :</label>
                            <div class="col-sm-10">
                                <input type="text" name="penerima" id="penerima" class="form-control col-sm-4" placeholder="Nama Penerima">
                            </div>
                        </div>
                    </section>
                </div>
                <div class="box-footer flexbox">                     
                    <div class="text-right flex-grow">
                        <a id="tombol-kembali" href="#" class="btn btn-secondary">Kembali</a>
                        <a id="tombol-form02" href="#" class="btn btn-info">FORM 02</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</form>
<script>
    $(document).ready(function() {
        $('.select2').select2();
        $('#tanggal_penerimaan').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy'
        });
        $('#tambah_contoh').click();

        $('#form-keswan').validate({
            rules: {
                status_epid: "required",
                no_epid: {
                    required: true,
                    remote: {
                        url: "{{ url('lab/keswan/checknoepid') }}",
                        type: "post",
                        data: {
                            "kolom" : "no_epid",
                            "aksi" : "{{ $var['method'] }}",
                        }
                    }
                },
            },
            messages: {
                status_epid: "Kolom status epid harus diisi",
                no_epid: {
                    required: "Kolom nomor epid harus diisi",
                    remote: "Nomor epid sudah digunakan"
                },
            },
            focusInvalid: false,
            invalidHandler: function(form, validator) {
                // if (!validator.numberOfInvalids())
                //     return;
                $('html, body').animate({
                    scrollTop: $(validator.errorList[0].element).offset().top-100
                }, 1000);
            }
        });
    });

    $('#nama_pengirim_id').on('change',function(){
        var  customerId = $(this).val();
        $.ajax({
            method : 'get',
            url : "{{ url('/lab/customer') }}",
            data : 'customerId='+customerId,
        }).done(function (data) {
            $("#alamat_pengirim").val(data.alamat);
        });
    });

    $('#tambah_contoh').on('click', function(){
        $('#tabel_contoh tbody').append(
            '<tr>'
                +'<td class="center"><input class="form-control" value="1" name="jumlah_contoh[]" type="number" style="text-align: center;"/></td>'
                +'<td>'
                    +'<select name="jenis_contoh[]" class="form-control select2">'
                        +'@foreach($jenisContoh as $id => $name)'
                            +'<option value="{{ $id }}">{{ $name }}</option>'
                        +'@endforeach'
                    +'</select></td>'
                +'<td class="center delete_contoh"><a class="text-danger" style="cursor:pointer"><i class="fa fa-times-circle"></i></a></td>'
            +'</tr>'
        );
        // $('#tabel_contoh').editableTableWidget().numericInputExample();
    });

    $('#tabel_contoh').on('click','.delete_contoh', function(){
        $(this).parent().remove();
    });

    $("#status_epid").change(function(){
        var status = $(this).val()!=""?$(this).val()+'.':null;
        $("#no_epid").val(status);
    });


    // $('#tombol-simpan').click(function(e){
    //     $simpan = store();
    // });

    $('#tombol-kembali').click(function(e){
        $preloader.fadeIn();
        gotoUrl('/lab/keswan');
    });

    $('#tombol-form02').click(function(e){
        if(store() ==  1){
            gotoUrl('/lab/keswan');
        }
    });

    function store() {
        var formData = new FormData($('#form-keswan')[0]);

        if($('#form-keswan').valid()){
            $.ajax({
                url : "{{ url('lab/keswan/form01') }}",
                type : 'POST',
                data : formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function(){
                },
                success:function(data){
                    pesan(data.kode, data.pesan);
                    return data.kode;
                }
            });
        }else{
            return 0;
        }
    }

</script>