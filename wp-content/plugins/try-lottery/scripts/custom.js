jQuery(document).ready(function($){
    if($('#bangkq_xsmb').length > 0){
        $('#bangkq_xsmb').on('click','#turn',function(){
            if(!isrunning){
                xsdp.RunRandomXSMB();
                setTimeout(function () {
                    //RELOAD CÁC KẾT QUẢ
                    xsdp.RunRandomComplete();
                }, 81000);
            }
        });
    }
    if($('#bangkq_xsmn').length > 0){
        $('#bangkq_xsmn').on('click','#turn',function(){
            if(!isrunning) {
                var columnNumber = $('#bangkq_xsmn').find('tr:eq(0) th').length;
                xsdp.RunRandomXSMN();
                setTimeout(function () {
                    //RELOAD CÁC KẾT QUẢ
                    xsdp.RunRandomComplete();
                }, 3000 * 18 * (columnNumber-1));
            }
        });
    }
    if($('#bangkq_xsmt').length > 0){
        $('#bangkq_xsmt').on('click','#turn',function(){
            if(!isrunning) {
                var columnNumber = $('#bangkq_xsmt').find('tr:eq(0) th').length;
                console.log(columnNumber);
                xsdp.RunRandomXSMT();
                setTimeout(function () {
                    //RELOAD CÁC KẾT QUẢ
                    xsdp.RunRandomComplete();
                }, 3000 * 18 * (columnNumber-1));
            }
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