<script src="{{ asset('fabadmin/assets/vendor_components/jquery/dist/jquery.min.js') }}"></script>
<!-- <script src="{{ asset('fabadmin/assets/vendor_components/popper/dist/popper.min.js') }}"></script> -->
<script src="{{ asset('fabadmin/assets/vendor_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('fabadmin/assets/vendor_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('fabadmin/assets/vendor_components/fastclick/lib/fastclick.js') }}"></script>
<script src="{{ asset('fabadmin/assets/vendor_components') }}/tiny-editable/mindmup-editabletable.js"></script>
<script src="{{ asset('fabadmin/assets/vendor_components') }}/tiny-editable/numeric-input-example.js"></script>
<script src="{{ asset('fabadmin/main/js/template.js') }}"></script>
<script src="{{ asset('fabadmin/main/js/demo.js') }}"></script>
<script src="{{ asset('fabadmin/assets/vendor_components/jquery-steps-master/build/jquery.steps.js') }}"></script>
<script src="{{ asset('fabadmin/assets/vendor_components/select2/dist/js/select2.full.js') }}"></script>
<script src="{{ asset('fabadmin/assets/vendor_components/jquery-validation-1.17.0/dist/jquery.validate.min.js') }}"></script>
<script src="{{ asset('fabadmin/assets/vendor_components/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('fabadmin/assets/vendor_components/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('fabadmin/assets/vendor_components/jquery-toast-plugin-master/src/jquery.toast.js') }}"></script>
<script src="{{ asset('fabadmin/assets/vendor_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('fabadmin/assets/vendor_plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>

<script>
    $(document).ready(function() {
        //Confirm Message
	    $('table button.btn-danger').on('click', function(e){
	        e.preventDefault();
            var $self = $(this);
            swal({
                title: "Data yakin dihapus ?",
                text: "Mohon diteliti sebelum menghapus data",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Hapus",
                cancelButtonText: "Batal",
                closeOnConfirm: false
            }, function(isConfirm){
                if (isConfirm) {
			        $self.parents(".delete_form").submit();
			    }
            });
        });

        $('.tanggalku').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy',
            orientation: "bottom"
        });
    });

    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });

    function state(url) {
        stateurl = "{!! URL::to('/') !!}"+url;
        history.replaceState(null, "url", stateurl);
    }

    function gotoUrl(url, redirected = 0,data='') {
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: 'get',
            data: ''+data,
            url : (redirected==0?"{!! URL::to('/') !!}":"")+url,
            beforeSend: function(){
                $preloader.fadeIn();
                $(".sidebar-menu li").removeClass("active");
            },
            success: function(data) {
                $('#konten_utama').html(data);
                if(redirected==0)state(url);
                $('.preloader').fadeOut();
                return 1;
            },
            error: function (xhr, status, error) {
                $('.preloader').fadeOut();
                var errorMessage = xhr.status + ': ' + xhr.statusText
                notif('Error!',errorMessage,'error');
                return 0;
            }
        });
        return 0;
    }

    function notif(judul, pesan='',tipe = 'info') {
        $.toast({
            heading: judul,
            text: pesan,
            position: 'top-right',
            loaderBg: '#ff6849',
            icon: tipe,
            hideAfter: 3000,
            stack: 6
        });

    }

    function sumClass(nama_class,callback) {
        var sum = 0;
        var tem = 1;
        $("."+nama_class).each(function(){
            if($(this).val() == "" || isNaN($(this).val())){
                tem = 0;
                $(this).val(0);
            }else{
               tem = $(this).val();
               tem = parseInt(tem);
               $(this).val(tem);
            }
            sum = sum+tem;
        });
        callback(sum);
    }

    function printDiv(id) { 
        var divContents = $("#"+id).html(); 
        var a = window.open('', '', 'height=500, width=500'); 
        a.document.write('<html>'); 
        a.document.write('<body > <h1>Div contents are <br>'); 
        a.document.write(divContents); 
        a.document.write('</body></html>'); 
        a.document.close(); 
        a.print(); 
    } 
</script>
