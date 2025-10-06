@php
    $lab = 3;
@endphp
<section class="content-header">
    <h1>
        Laporan Kesmavet
    </h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
        <li class="breadcrumb-item"><a href="#">Laporan</a></li>
        <li class="breadcrumb-item active">Laporan Kesmavet</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
{!! Form::open(['id'=>'form-laporan-kesmavet', 'method'=>'POST', 'url'=>URL::to("/laporan/lab-keswan"), 'target'=>'_blank']) !!}
    <div class="row">
        <div class="col-12 col-lg-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h4 class="box-title">Laporan - Lab. Kesmavet</h4>
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
                        <a href="#" id="tombol-tampil" class="btn btn-primary">Tampil</a>
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
    $('#tombol-tampil').on('click', function(){
        $preloader.fadeIn();
        store(function(result) {
            if(result==1){
            }
            $preloader.fadeOut();
        });        
    });

    function store(callback) {
        var formData = new FormData($('#form-laporan-kesmavet')[0]);
        if($('#form-laporan-kesmavet').valid()){
        event.preventDefault();
            $.ajax({
                url : "{{ url('laporan/lab-kesmavet') }}",
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