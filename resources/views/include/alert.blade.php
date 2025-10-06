@if(Session::has('pesanSukses'))
    <script type="text/javascript">
        function codeAddress() {
            //Success Message
		    swal("Berhasil !", "{{ Session::get('pesanSukses') }}", "success")
        }
        window.onload = codeAddress;
    </script>
@endif

@if(Session::has('pesanError'))
    <script type="text/javascript">
        function codeAddress() {
            //Success Message
		    swal("Gagal !", "{{ Session::get('pesanError') }}", "error")
        }
        window.onload = codeAddress;
    </script>
@endif

<script type="text/javascript">
    function pesan(code=1, pesan = "") {
        //Success Message
        swal(code=="1"?"Berhasil !":"Gagal !", pesan, code=="1"?"success":"error")
    }
</script>