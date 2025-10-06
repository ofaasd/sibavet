<section class="content-header">
    <h1>
        Lab. Keswan
    </h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active"><i class="fa fa-hospital-o"></i> Lab. Keswan</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="box">
                <!-- /.box-header -->
                <div class="box-body">
                    <!-- Tab panes -->
                                <div class="row">
                                    <div class="col-lg-6">
                                            <a href="#" id="tombol-tambah" class="btn btn-primary"><b>Tambah Data</b></a>
                                    </div>
                                    <div class="col-lg-6">
                                        <form method="get" action="">
                                            <div class="input-group">
                                                <input name="cari" type="text" class="form-control" placeholder="Inputkan Pencarian" value="{{ Request::get('cari') }}" />
                                                <div class="input-group-prepend">
                                                    <button type="button" class="btn btn-info">Cari</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <br />
                                <div class="table-responsive">
                                    <table class="table table-hover" id="tabel_keswan">
                                        <thead>
                                            <tr class="bg-dark">
                                                <!-- <th width="130px" style="text-align:center;">Aksi</th> -->
                                                <th style="text-align:center;">No. Epid</th>
                                                <th style="text-align:center;">Laboratorium</th>
                                                <th style="text-align:center;">Nama Pengirim</th>
                                                <th style="text-align:center;">Jenis Hewan</th>
                                                <th style="text-align:center;">Seksi Laboratorium</th>
                                                <th style="text-align:center;">Pengirim</th>
                                                <th style="text-align:center;">FORM</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $no = 0;
                                        @endphp
                                        @foreach($listLaboratorium as $keswan)
                                            @php
                                                $no++;
                                            @endphp
                                            <tr recid="{!! $keswan->id !!}">
                                                <!-- <td style="text-align:center">
                                                    <div class="btn-group">
                                                        {!! Form::open(['method'=>'delete', 'url'=>'/laboratorium/'.$keswan->id.$var['url']['all'], 'class'=> 'delete_form']) !!}
                                                        {!! Form::hidden('nomor', $no, ['class'=>'form-control']) !!}
                                                        <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                            @can('Delete Laboratorium')
                                                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                                            @endcan -->
                                                            <!-- @can('Update Laboratorium')
                                                                <a href="{{ url('/laboratorium/'.$keswan->id.'/edit'.$var['url']['all'])}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                                            @endcan -->
                                                           <!--  <a href="{{ url('/laboratorium/'.$keswan->id.$var['url']['all'])}}" class="btn btn-info btn-sm"><i class="fa fa-search"></i></a>
                                                            <a href="{{ url('/laboratorium/cetak/'.$keswan->id)}}" class="btn btn-success btn-sm" target="_blank"><i class="fa fa-print"></i></a>
                                                        </div>
                                                        {!! Form::close() !!}
                                                    </div>
                                                </td> -->
                                                <td>{{ $keswan->no_epid }}</td>
                                                <td>{{ @$keswan->subSatuanKerja->sub_satuan_kerja }}</td>
                                                <td>{{ @$keswan->customer->nama_pelanggan }}</td>
                                                <td>{{ @$keswan->spesies->nama_spesies }}</td>
                                                <td>{{ @$keswan->seksiLaboratorium->seksi_laboratorium }}</td>
                                                <td>{{ $keswan->pengirim }}</td>
                                                <td style="text-align:center">
                                                    <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                            <a href="#" class="btn btn-success btn-sm tombol-form" recform="form01">01</a>
                                                            <a href="#" class="btn btn-primary btn-sm tombol-form" recform="form02">02</a>
                                                            <a href="#" class="btn btn-default btn-sm tombol-form" recform="form03">03</a>
                                                            <a href="#" class="btn btn-warning btn-sm tombol-form" recform="form04">04</a>
                                                            <a href="#" class="btn btn-info btn-sm tombol-form" recform="formhasil"><i class="fa fa-th-list"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-lg-8 ml-auto">
                                        {{ $listLaboratorium->render() }}
                                </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
    </div>
</section>
<script>
    $(document).ready(function() {
        $preloader.fadeOut();
    });
    
    $('#tombol-tambah').on('click',function(e){
        gotoUrl('/lab/keswan/form01');
    });

    $('#tabel_keswan').on('click','.tombol-form',function(e){
        e.preventDefault();
        gotoUrl('/lab/keswan/'+$(this).closest('tr').attr('recid')+'/'+$(this).attr('recform'));
    });
</script>