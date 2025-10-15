function gotoPage(url) {
	$.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
        type: 'get',
        url : url,
        beforeSend: function(){
            // remove class active di semua <li>
            $(".sidebar-menu li").removeClass("active");
        },
        success: function(data) {
            $('#konten_utama').html(data);
            $('.preloader').fadeOut();
            return 1;
        }
    });
    return 0;
}