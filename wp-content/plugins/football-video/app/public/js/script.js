/*JS FOR SCROLLING THE ROW OF THUMBNAILS*/
jQuery(document).ready(function ($) {
    $('.vid-item').each(function(index){
        $(this).on('click', function(){
            var current_index = index+1;
            $('.vid-item .thumb').removeClass('active');
            $('.vid-item:nth-child('+current_index+') .thumb').addClass('active');
        });
    });
        $(".vid-list-container .vid-list").niceScroll({
            cursorcolor: '#777',
            background: '#CCC',
            cursorwidth: '10px',
            cursorborder: '0',
            cursorborderradius: '1px',
            autohidemode: true,
            railalign: 'left'
        });
});