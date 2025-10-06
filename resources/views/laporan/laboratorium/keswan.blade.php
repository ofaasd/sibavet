@php
    $lab = 1;
@endphp
<section class="content-header">
    <h1>
        Laporan Keswan
    </h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
        <li class="breadcrumb-item"><a href="#">Laporan</a></li>
        <li class="breadcrumb-item active">Laporan Keswan</li>
    </ol>
</section>
<section class="content">
{!! Form::open(['id'=>'form-laporan-keswan', 'method'=>'POST', 'url'=>URL::to('/laporan/lab-keswan'), 'target'=>'_blank']) !!}
    <div class="row">
        <div class="col-12 col-lg-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h4 class="box-title">Laporan - Lab. Keswan</h4>
                    <ul class="box-controls pull-right">
                      <li><a class="box-btn-fullscreen" href="#"></a></li>
                      <li><a class="box-btn-slide" href="#"></a></li>   
                    </ul>
                </div>
                <div class="box-body">
                    @include('laporan.laboratorium.l_filter')
                </div>
                <div class="box-footer flexbox">                     
                    <div class="text-right flex-grow">
                        <input type="submit" class="btn btn-primary" value="tampil">
                    </div>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div id="konten_laporan">
                
            </div>
        </div>
    </div>
{!! Form::close() !!}

</section>
<script type="text/javascript">
    

    function store(callback) {
        var formData = new FormData($('#form-laporan-keswan')[0]);
        if($('#form-laporan-keswan').valid()){
        event.preventDefault();
            $.ajax({
                url : "{{ url('laporan/lab-keswan') }}",
                type : 'POST',
                data : formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function(){
                },
                success:function(data){
                    $('#konten_laporan').html(data);
                    $preloader.fadeOut();
                    notif("Suksess!", data.pesan,'success');
                    callback(data.kode);
                }
            });
        }else{
            callback(0);
        }
    }
</script>