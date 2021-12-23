jQuery(document).ready(function($){
    if($('#bangkq_xsmb').length > 0){
        $('#bangkq_xsmb').on('click','#turn',function(){
           xsdp.RunRandomXSMB();
        });
    }
    if($('#bangkq_xsmn').length > 0){
        $('#bangkq_xsmn').on('click','#turn',function(){
            xsdp.RunRandomXSMN();
        });
    }
    if($('#bangkq_xsmt').length > 0){
        $('#bangkq_xsmt').on('click','#turn',function(){
            xsdp.RunRandomXSMT();
        });
    }
    $("body").find(" #hover-number td").mouseout(function () {
        var id = $(this).parent().attr("data");
        $('#table-' + id + ' tbody tr td span').each(function (index, element) {
            var txt = $(element).html();
            var res = txt.split('<mark>');
            $(element).html(res);
        });
    });
    $("body").find("#hover-number td").mouseover(function () {
        var value = $(this).text();
        console.log('a: ' + value);
        var id = $(this).parent().attr("data");
        $('#table-' + id + ' tbody tr td span').each(function (index, element) {
            var txt = $(element).html();
            if (txt[txt.length - 1] == value || txt[txt.length - 2] == value)
                $(element).html(txt.slice(0, txt.length - 2) + '<mark>' + txt.slice(txt.length - 2, txt.length) + '</mark>');
        });
    });
});