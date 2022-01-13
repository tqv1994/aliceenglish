jQuery(document).ready(function($) {
    xsdp.init();
});
var xsdpconfig = {
    rootPath: tryDirAssets+'/',
}
var isrunning = false;
var arrHead = new Array('', '', '', '', '', '', '', '', '', '');
var arrTail = new Array('', '', '', '', '', '', '', '', '', '');
var xsdp = {
    variables: {
        lotMsgListMN: 0,
        lotMsgListMT: 0,
        currentPage: 1
    },
    init: function () {
        jQuery("input[name='select-option']").attr("disabled", true);
        this.events();
    },
    events: function () {
        jQuery('input[type="radio"][name="optionsTK"]').on('change', function () {
            window.location.href = jQuery(this).val();
        });
        jQuery("#hover-number td").mouseout(function () {
            var id = jQuery(this).parent().attr("data");
            jQuery('#table-' + id + ' tbody tr td span').each(function (index, element) {
                var txt = jQuery(element).html();
                var res = txt.split('<mark>');
                jQuery(element).html(res);
            });
        });
        jQuery("#hover-number td").mouseover(function () {
            var value = jQuery(this).text();
            console.log('a: ' + value);
            var id = jQuery(this).parent().attr("data");
            jQuery('#table-' + id + ' tbody tr td span').each(function (index, element) {
                var txt = jQuery(element).html();
                if (txt[txt.length - 1] == value || txt[txt.length - 2] == value)
                    jQuery(element).html(txt.slice(0, txt.length - 2) + '<mark>' + txt.slice(txt.length - 2, txt.length) + '</mark>');
            });
        });
    },
    getRandomString: function (len) {
        var number = '';
        for (var i = 0; i < len; i++) {
            number += Math.floor(Math.random() * (9 - 0 + 1) + 0);
        }
        return number;
    },
    getHtmlForMBBeginRun: function () {
        var count = 0;
        var retVal = '<table class="table table-striped table-xsmb" id="turn-xsmb">' +
            '<tbody>' +
            '<tr>' +
            '<td>G.ĐB</td>' +
            ' <td class="text-center" id="mb_prizeDB">' +
            ' <span class="special-prize-lg no-bor">' +
            '<img src="/assets/images/load.gif" class="img-loading hide-img" alt=""/>' +
            ' </span>' +
            '</td>' +
            '</tr>' +
            '<tr>' +
            '<td>G.1</td>' +
            '<td class="text-center" id="mb_prize1">' +
            '<span class="number-black-bold-mb no-bor">' +
            '<img src="/assets/images/load.gif" class="img-loading hide-img" alt=""/>' +
            '</span>' +
            ' </td>' +
            ' </tr>' +
            '  <tr>' +
            ' <td>G.2</td>' +
            ' <td class="text-center" id="mb_prize2">';
        for (var index = 0; index < 2; index++) {
            retVal += ' <span class="col-xs-6 number-black-bold-mb no-bor-b">' +
                '  <img src="/assets/images/load.gif" class="img-loading hide-img" alt=""/>' +
                '</span>';
        }
        retVal += ' </td>' +
            '</tr>' +
            '<tr>' +
            '<td>G.3</td>' +
            '<td class="text-center" id="mb_prize3">';
        for (var index = 0; index < 6; index++) {
            retVal += ' <span class="col-xs-4 number-black-bold-mb no-bor div-horizontal">' +
                '  <img src="/assets/images/load.gif" class="img-loading hide-img" alt=""/>' +
                '</span>';
        }
        retVal += '</td>' +
            '</tr>' +
            '<tr>' +
            '<td>G.4</td>' +
            '<td class="text-center" id="mb_prize4">';
        for (var index = 0; index < 4; index++) {
            retVal += ' <span class="col-xs-3 number-black-bold-mb no-bor-b div-horizontal">' +
                '  <img src="/assets/images/load.gif" class="img-loading hide-img" alt=""/>' +
                '</span>';
        }
        retVal += '</td>' +
            '</tr>' +
            '<tr>' +
            '<td>G.5</td>' +
            '<td class="text-center" id="mb_prize5">';
        for (var index = 0; index < 6; index++) {
            retVal += ' <span class="col-xs-4 number-black-bold-mb no-bor div-horizontal">' +
                '<img src="/assets/images/load.gif" class="img-loading hide-img" alt=""/>' +
                '</span>';
        }
        retVal += '</td>' +
            '</tr>' +
            ' <tr>' +
            '<td>G.6</td>' +
            '<td class="text-center" id="mb_prize6">';
        for (var index = 0; index < 3; index++) {
            retVal += ' <span class="col-xs-4 number-black-bold-mb no-bor-b div-horizontal">' +
                '  <img src="/assets/images/load.gif" class="img-loading hide-img" alt=""/>' +
                '</span>';
        }
        retVal += '</td>' +
            '</tr>' +
            '<tr>' +
            '<td>G.7</td>' +
            '<td class="text-center" id="mb_prize7">';
        for (var index = 0; index < 4; index++) {
            retVal += ' <span class="col-xs-3 number-black-bold-mb no-bor-b div-horizontal">' +
                '  <img src="/assets/images/load.gif" class="img-loading hide-img" alt=""/>' +
                '</span>';
        }
        retVal += '</td>' +
            '</tr>' +
            '</tbody>' +
            '</table>';
        jQuery('#table-xsmb').html(retVal);
    },
    getHtmlForMB: function () {
        var count = 0;
        var countLot = 2;
        var retVal = '<table class="table table-striped table-xsmb" id="turn-xsmb">' +
            '<tbody>' +
            '<tr>' +
            '<td>ÄB</td>' +
            ' <td class="text-center">' +
            ' <span class="special-prize-lg no-bor div-horizontal" id="mb_prize_0">';
        for (var i = 0; i < 5; i++) {
            count++;
            retVal += '<div class="output" id="output' + count + '"></div>';
        }
        retVal += ' </span>' +
            '</td>' +
            '</tr>' +
            '<tr>' +
            '<td>G.1</td>' +
            '<td class="text-center">' +
            '<span class="number-black-bold-mb no-bor div-horizontal" id="mb_prize_1">';
        for (var i = 0; i < 5; i++) {
            count++;
            retVal += '<div class="output" id="output' + count + '"></div>';
        }
        retVal += ' </span>' +
            ' </td>' +
            ' </tr>' +
            '  <tr>' +
            ' <td>G.2</td>' +
            ' <td class="text-center">';
        for (var index = 0; index < 2; index++) {
            retVal += ' <span class="col-xs-6 number-black-bold-mb no-bor-b div-horizontal" id="mb_prize_' + countLot + '">';
            for (var i = 0; i < 5; i++) {
                count++;
                retVal += '<div class="output" id="output' + count + '"></div>';
            }
            retVal += '</span>';
            countLot++;
        }
        retVal += ' </td>' +
            '</tr>' +
            '<tr>' +
            '<td>G.3</td>' +
            '<td class="text-center">';
        for (var index = 0; index < 6; index++) {
            retVal += ' <span class="col-xs-4 number-black-bold-mb no-bor div-horizontal"  id="mb_prize_' + countLot + '">';
            for (var i = 0; i < 5; i++) {
                count++;
                retVal += '<div class="output" id="output' + count + '"></div>';
            }
            retVal += '</span>';
            countLot++
        }
        retVal += '</td>' +
            '</tr>' +
            '<tr>' +
            '<td>G.4</td>' +
            '<td class="text-center">';
        for (var index = 0; index < 4; index++) {
            retVal += ' <span class="col-xs-3 number-black-bold-mb no-bor-b div-horizontal"  id="mb_prize_' + countLot + '">';
            for (var i = 0; i < 4; i++) {
                count++;
                retVal += '<div class="output" id="output' + count + '"></div>';
            }
            retVal += '</span>';
            countLot++;
        }
        retVal += '</td>' +
            '</tr>' +
            '<tr>' +
            '<td>G.5</td>' +
            '<td class="text-center">';
        for (var index = 0; index < 6; index++) {
            retVal += ' <span class="col-xs-4 number-black-bold-mb no-bor div-horizontal"  id="mb_prize_' + countLot + '">';
            for (var i = 0; i < 4; i++) {
                count++;
                retVal += '<div class="output" id="output' + count + '"></div>';
            }
            retVal += '</span>';
            countLot++;
        }
        retVal += '</td>' +
            '</tr>' +
            ' <tr>' +
            '<td>G.6</td>' +
            '<td class="text-center">';
        for (var index = 0; index < 3; index++) {
            retVal += ' <span class="col-xs-4 number-black-bold-mb no-bor-b div-horizontal"  id="mb_prize_' + countLot + '">';
            for (var i = 0; i < 3; i++) {
                count++;
                retVal += '<div class="output" id="output' + count + '"></div>';
            }
            retVal += '</span>';
            countLot++;
        }
        retVal += '</td>' +
            '</tr>' +
            '<tr>' +
            '<td>G.7</td>' +
            '<td class="text-center">';
        for (var index = 0; index < 4; index++) {
            retVal += ' <span class="col-xs-3 number-black-bold-mb no-bor-b div-horizontal"  id="mb_prize_' + countLot + '">';
            for (var i = 0; i < 4; i++) {
                count++;
                retVal += '<div class="output" id="output' + count + '"></div>';
            }
            retVal += '</span>';
            countLot++;
        }
        retVal += '</td>' +
            '</tr>' +
            '</tbody>' +
            '</table>';
        jQuery('#table-xsmb').html(retVal);
    },
    getRandomTextMB: function (num, numOfWord, lenOfWord) {
        var retVal = '';
        var myclass = '';
        var number = '';
        switch (num) {
            case 0: myclass = 'special-prize-lg no-bor'; break;
            case 1: myclass = 'number-black-bold-mb no-bor'; break;
            case 2: myclass = 'col-xs-6 number-black-bold-mb no-bor-b'; break;
            case 3: myclass = 'col-xs-4 number-black-bold-mb'; break;
            case 4: myclass = 'col-xs-3 number-black-bold-mb no-bor-b'; break;
            case 5: myclass = 'col-xs-4 number-black-bold-mb'; break;
            case 6: myclass = 'col-xs-4 number-black-bold-mb no-bor-b'; break;
            case 7: myclass = 'col-xs-3 number-black-bold-mb no-bor-b'; break;
        }
        for (var i = 0; i < numOfWord; i++) {
            number = xsdp.getRandomString(lenOfWord);
            retVal += '<span class="' + myclass + '" data="' + number + '">' + number + '</span>';
        }
        return retVal;
    },
    getHtmlMBToday: function (str) {
        var url = xsdpconfig.rootPath + 'XSDPAjax/GetHtmlMBToday';
        var dataGetter = {};
        jQuery.xsdpAjax(url, 'Get', dataGetter, function (resp) {
            jQuery("#bangkq_xsmb").html(resp);
            xsdp.RunRandomXSMB();
        });
    },
    getHtmlMNToday: function (str) {
        var url = xsdpconfig.rootPath + 'XSDPAjax/GetHtmlMNToday';
        var dataGetter = {};
        jQuery.xsdpAjax(url, 'Get', dataGetter, function (resp) {
            jQuery("#bangkq_xsmn").html(resp);
            xsdp.RunRandomXSMN();
        });
    },
    getHtmlMTToday: function (str) {
        var url = xsdpconfig.rootPath + 'XSDPAjax/GetHtmlMTToday';
        var dataGetter = {};
        jQuery.xsdpAjax(url, 'Get', dataGetter, function (resp) {
            jQuery("#bangkq_xsmt").html(resp);
            xsdp.RunRandomXSMT();
        });
    },
    RunRandomComplete: function (str) {
        console.log('complete');
        isrunning = false;
        jQuery("input[name='select-option']").removeAttr("disabled");
        jQuery('#turn').html('<span class="change-color">NHẬP QUAY THỬ LẠI</span>');
    },
    choice: function (id, num) {
        mn_mt = "table-xsmb";
        if (id == 1)
            mn_mt = "table-xsmn";
        if (id == 2)
            mn_mt = "table-xsmt";
        if (id == 3)
            mn_mt = "table-tinh";
        jQuery('#' + mn_mt + ' tbody tr td span').each(function (index, element) {
            var txt = jQuery(element).attr("data");
            if (num == 2 || num == 3) {
                if (txt.length > num)
                    txt = txt.substr(txt.length - num);
            }
            jQuery(element).text(txt);
        });
    },
    RunRandomXSMB: function () {
        jQuery("input[name='select-option']").attr("disabled", true);
        isrunning = true;
        xsdp.goToByScroll('bangkq_xsmb');
        jQuery('#turn').html('NHẤP QUAY THỬ XSMB');
        var animationTimer = null;
        var started = new Date().getTime();
        var duration = 2000;
        var arrRange = new Array();
        //add ket qua
        arrRange.push(xsdp.getRandomString(5));
        arrRange.push(xsdp.getRandomString(5));
        arrRange.push(xsdp.getRandomString(5));
        for (var i = 0; i < 6; i++) {
            arrRange.push(xsdp.getRandomString(5));
        }
        for (var i = 0; i < 4; i++) {
            arrRange.push(xsdp.getRandomString(4));
        }
        for (var i = 0; i < 6; i++) {
            arrRange.push(xsdp.getRandomString(4));
        }
        for (var i = 0; i < 3; i++) {
            arrRange.push(xsdp.getRandomString(3));
        }
        for (var i = 0; i < 4; i++) {
            arrRange.push(xsdp.getRandomString(2));
        }
        //add ket qua giai dac biet
        arrRange.push(xsdp.getRandomString(5));
        //chuyen tat ca ket qua ve anh gif
        for (var i = 0; i < arrRange.length; i++) {
            jQuery('#mb_prize_' + i).html('<img src="' + xsdpconfig.rootPath + 'images/load.gif" class="img-loading hide-img" alt=""/>');
        }
        //gan du lieu cho tung ket qua, moi ket qua cach nhau 3000
        for (var i = 0; i < arrRange.length; i++) {
            xsdp.sethtml('mb_prize_' + i, arrRange[i], 3000 * i);
        }
    },
    sethtml: function (id, value, time) {
        setTimeout(function () { xsdp.sethtmlRuning(id, value); }, time);
    },
    sethtmlRuning: function (id, value) {
        var animationTimer = null;
        var started = new Date().getTime();
        var duration = 3000;
        var minNumber = 0; // le minimum
        var maxNumber = 9; // le maximum
        jQuery('#' + id).html('<div class="output" id="output0"></div>' +
            '<div class="output" id="output1"></div>' +
            '<div class="output" id="output2"></div>' +
            '<div class="output" id="output3"></div>' +
            '<div class="output" id="output4"></div>');
        animationTimer = setInterval(function () {
            if (new Date().getTime() - started < duration) {
                //so chay random truoc khi show ket qua
                for (var i = 0; i <= 4; i++) {
                    jQuery('#output' + i).text('' + Math.floor(Math.random() * (maxNumber - minNumber + 1) + minNumber));
                }
            }
            else {
                clearInterval(animationTimer); // Stop the loop
                //show ket qua
                jQuery('#' + id).html(value); jQuery('#' + id).attr("data", value);
                var trIndex = jQuery('#' + id).parent().parent().index();
                if(jQuery('.firstlast.fl').length > 0){
                    var firstLast = value.slice(-2);
                    var first = firstLast[0];
                    var last = firstLast[1];
                    console.log(first,last);
                    if(jQuery('.firstlast.fl .v-loto-dau-'+first).length > 0){
                        var text = jQuery('.firstlast.fl .v-loto-dau-'+first).text();
                        if(trIndex != 0) {
                            jQuery('.firstlast.fl .v-loto-dau-'+first).text(text ? last+","+text : last);
                        }else{
                            jQuery('.firstlast.fl .v-loto-dau-'+first).html(text ? `<span class="clnote">${last}</span>` + "," + text : `<span class="clnote">${last}</span>`);
                        }
                    }
                }
                if(jQuery('.firstlast.fr').length > 0){
                    var firstLast = value.slice(-2);
                    var first = firstLast[0];
                    var last = firstLast[1];
                    if(jQuery('.firstlast.fr .v-loto-duoi-'+first).length > 0){
                        var text = jQuery('.firstlast.fl .v-loto-duoi-'+last).text();
                        if(trIndex != 0) {
                            jQuery('.firstlast.fr .v-loto-duoi-'+last).text(text ? first+","+text : first);
                        }else{
                            jQuery('.firstlast.fr .v-loto-duoi-'+last).html(text ? `<span class="clnote">${first}</span>` + "," + text : `<span class="clnote">${first}</span>`);
                        }

                    }
                }
            }
        }, 100);
    },
    RunRandomXSMN: function () {
        jQuery("input[name='select-option']").attr("disabled", true);
        isrunning = true;
        xsdp.goToByScroll('bangkq_xsmn');
        jQuery('#turn').html('NHẤP QUAY THỬ XSMN');
        var conveniancecount = jQuery("span[id*='mn_prize_']").length;
        console.log(conveniancecount);
        var numberprovince = conveniancecount / 18;
        var animationTimer = null;
        var started = new Date().getTime();
        var duration = 6000;
        var arrRange = new Array();
        //add ket qua
        for (var index = 0; index < numberprovince; index++) {
            arrRange.push(xsdp.getRandomString(2));
        }
        for (var index = 0; index < numberprovince; index++) {
            arrRange.push(xsdp.getRandomString(3));
        }
        for (var index = 0; index < numberprovince; index++) {
            for (var i = 0; i < 3; i++) {
                arrRange.push(xsdp.getRandomString(4));
            }
        }
        for (var index = 0; index < numberprovince; index++) {
            arrRange.push(xsdp.getRandomString(4));
        }
        for (var index = 0; index < numberprovince; index++) {
            for (var i = 0; i < 7; i++) {
                arrRange.push(xsdp.getRandomString(5));
            }
        }
        for (var index = 0; index < numberprovince; index++) {
            for (var i = 0; i < 2; i++) {
                arrRange.push(xsdp.getRandomString(5));
            }
        }
        for (var index = 0; index < numberprovince; index++) {
            arrRange.push(xsdp.getRandomString(5));
        }
        for (var index = 0; index < numberprovince; index++) {
            arrRange.push(xsdp.getRandomString(5));
        }
        for (var index = 0; index < numberprovince; index++) {
            arrRange.push(xsdp.getRandomString(6));
        }
        //chuyen tat ca ket qua ve anh gif
        for (var i = 0; i < arrRange.length; i++) {
            jQuery('#mn_prize_' + i).html('<img src="' + xsdpconfig.rootPath + 'images/load.gif" class="img-loading hide-img" alt=""/>');
        }
        //gan du lieu cho tung ket qua, moi ket qua cach nhau 3000
        for (var i = 0; i < arrRange.length; i++) {
            xsdp.sethtmlMN('mn_prize_' + i, arrRange[i], 3000 * i);
        }
    },
    sethtmlMN: function (id, value, time) {
        setTimeout(function () { xsdp.sethtmlMNRuning(id, value); }, time);
    },
    sethtmlMNRuning: function (id, value) {
        var animationTimer = null;
        var started = new Date().getTime();
        var duration = 3000;
        var minNumber = 0; // le minimum
        var maxNumber = 9; // le maximum
        jQuery('#' + id).html('<div class="output" id="outputMN0"></div>' +
            '<div class="output" id="outputMN1"></div>' +
            '<div class="output" id="outputMN2"></div>' +
            '<div class="output" id="outputMN3"></div>' +
            '<div class="output" id="outputMN4"></div>');
        animationTimer = setInterval(function () {
            if (new Date().getTime() - started < duration) {
                //so chay random truoc khi show ket qua
                for (var i = 0; i <= 4; i++) {
                    jQuery('#outputMN' + i).text('' + Math.floor(Math.random() * (maxNumber - minNumber + 1) + minNumber));
                }
            }
            else {
                clearInterval(animationTimer); // Stop the loop
                //show ket qua
                jQuery('#' + id).html(value); jQuery('#' + id).attr("data", value);
                var tdIndex = jQuery('#' + id).parent().index();
                var trIndex = jQuery('#' + id).parent().parent().index();
                if(jQuery('.firstlast.fl').length > 0){
                    var firstLast = value.slice(-2);
                    var first = firstLast[0];
                    var last = firstLast[1];
                    jQuery(`.firstlast.fl tr`).each(function(){
                        if(jQuery(this).find(`td:eq(${tdIndex}).v-loto-dau-`+first).length > 0){
                            var text = jQuery(this).find(`td:eq(${tdIndex}).v-loto-dau-`+first).text();
                            if(trIndex < 8) {
                                jQuery(this).find(`td:eq(${tdIndex}).v-loto-dau-` + first).text(text ? last + "," + text : last);
                            }else{
                                jQuery(this).find(`td:eq(${tdIndex}).v-loto-dau-` + first).html(text ? `<span class="clnote">${last}</span>` + "," + text : `<span class="clnote">${last}</span>`);
                            }
                        }
                    });
                }
            }
        }, 100);
    },
    RunRandomXSMT: function () {
        jQuery("input[name='select-option']").attr("disabled", true);
        isrunning = true;
        xsdp.goToByScroll('bangkq_xsmt');
        jQuery('#turn').html('NHẤP QUAY THỬ XSMT');
        var conveniancecount = jQuery("span[id*='mt_prize_']").length;
        var numberprovince = conveniancecount / 18;
        var animationTimer = null;
        var started = new Date().getTime();
        var duration = 6000;
        var arrRange = new Array();
        //add ket qua
        for (var index = 0; index < numberprovince; index++) {
            arrRange.push(xsdp.getRandomString(2));
        }
        for (var index = 0; index < numberprovince; index++) {
            arrRange.push(xsdp.getRandomString(3));
        }
        for (var index = 0; index < numberprovince; index++) {
            for (var i = 0; i < 3; i++) {
                arrRange.push(xsdp.getRandomString(4));
            }
        }
        for (var index = 0; index < numberprovince; index++) {
            arrRange.push(xsdp.getRandomString(4));
        }
        for (var index = 0; index < numberprovince; index++) {
            for (var i = 0; i < 7; i++) {
                arrRange.push(xsdp.getRandomString(5));
            }
        }
        for (var index = 0; index < numberprovince; index++) {
            for (var i = 0; i < 2; i++) {
                arrRange.push(xsdp.getRandomString(5));
            }
        }
        for (var index = 0; index < numberprovince; index++) {
            arrRange.push(xsdp.getRandomString(5));
        }
        for (var index = 0; index < numberprovince; index++) {
            arrRange.push(xsdp.getRandomString(5));
        }
        for (var index = 0; index < numberprovince; index++) {
            arrRange.push(xsdp.getRandomString(6));
        }
        //chuyen tat ca ket qua ve anh gif
        for (var i = 0; i < arrRange.length; i++) {
            jQuery('#mt_prize_' + i).html('<img src="' + xsdpconfig.rootPath + 'images/load.gif" class="img-loading hide-img" alt=""/>');
        }
        //gan du lieu cho tung ket qua, moi ket qua cach nhau 1000
        for (var i = 0; i < arrRange.length; i++) {
            xsdp.sethtmlMT('mt_prize_' + i, arrRange[i], 3000 * i);
        }
    },
    sethtmlMT: function (id, value, time) {
        setTimeout(function () { xsdp.sethtmlMTRuning(id, value); }, time);
    },
    sethtmlMTRuning: function (id, value) {
        var animationTimer = null;
        var started = new Date().getTime();
        var duration = 3000;
        var minNumber = 0; // le minimum
        var maxNumber = 9; // le maximum
        jQuery('#' + id).html('<div class="output" id="outputMT0"></div>' +
            '<div class="output" id="outputMT1"></div>' +
            '<div class="output" id="outputMT2"></div>' +
            '<div class="output" id="outputMT3"></div>' +
            '<div class="output" id="outputMT4"></div>');
        animationTimer = setInterval(function () {
            if (new Date().getTime() - started < duration) {
                //so chay random truoc khi show ket qua
                for (var i = 0; i <= 4; i++) {
                    jQuery('#outputMT' + i).text('' + Math.floor(Math.random() * (maxNumber - minNumber + 1) + minNumber));
                }
            }
            else {
                clearInterval(animationTimer); // Stop the loop
                //show ket qua
                jQuery('#' + id).html(value); jQuery('#' + id).attr("data", value);
                var tdIndex = jQuery('#' + id).parent().index();
                var trIndex = jQuery('#' + id).parent().parent().index();
                if(jQuery('.firstlast.fl').length > 0){
                    var firstLast = value.slice(-2);
                    var first = firstLast[0];
                    var last = firstLast[1];
                    jQuery(`.firstlast.fl tr`).each(function(index){
                        if(jQuery(this).find(`td:eq(${tdIndex}).v-loto-dau-`+first).length > 0){
                            var text = jQuery(this).find(`td:eq(${tdIndex}).v-loto-dau-`+first).text();
                            if(trIndex < 8) {
                                jQuery(this).find(`td:eq(${tdIndex}).v-loto-dau-` + first).text(text ? last + "," + text : last);
                            }else{
                                jQuery(this).find(`td:eq(${tdIndex}).v-loto-dau-` + first).html(text ? `<span class="clnote">${last}</span>` + "," + text : `<span class="clnote">${last}</span>`);
                            }
                        }
                    });
                }

            }
        }, 100);
    },
    RunRandomXSTheoDai: function (lotteryCode) {
        isrunning = true;
        xsdp.goToByScroll('bangkq_xstheodai');
        var d = new Date();
        var month = d.getMonth() + 1;
        var day = d.getDate();
        var datetimenow = (day < 10 ? '0' : '') + day + '/' + (month < 10 ? '0' : '') + month + '/' + d.getFullYear();
        jQuery('#dateqttd').html(' ngĂ y ' + datetimenow);
        jQuery('#turn').html('NHẤP QUAY THỬ XS' + lotteryCode + ' <img class="btn-loading" src="' + xsdpconfig.rootPath + 'images/loading.gif"/>');
        var animationTimer = null;
        var started = new Date().getTime();
        var duration = 2000;
        var arrRange = new Array();
        //add ket qua
        arrRange.push(xsdp.getRandomString(2));
        arrRange.push(xsdp.getRandomString(3));
        for (var i = 0; i < 3; i++) {
            arrRange.push(xsdp.getRandomString(4));
        }
        arrRange.push(xsdp.getRandomString(4));
        for (var i = 0; i < 7; i++) {
            arrRange.push(xsdp.getRandomString(5));
        }
        for (var i = 0; i < 2; i++) {
            arrRange.push(xsdp.getRandomString(5));
        }
        arrRange.push(xsdp.getRandomString(5));
        arrRange.push(xsdp.getRandomString(5));
        //add ket qua giai dac biet
        arrRange.push(xsdp.getRandomString(6));
        //chuyen tat ca ket qua ve anh gif
        for (var i = 0; i < arrRange.length; i++) {
            jQuery('#qttd_prize_' + i).html('<img src="' + xsdpconfig.rootPath + 'images/load.gif" class="img-loading hide-img" alt=""/>');
        }
        //gan du lieu cho tung ket qua, moi ket qua cach nhau 1000
        for (var i = 0; i < arrRange.length; i++) {
            xsdp.sethtml('qttd_prize_' + i, arrRange[i], 1000 * i);
        }
    },
    goToByScroll: function (id) {
        // Remove "link" from the ID
        id = id.replace("link", "");
        // Scroll
        jQuery('html,body').animate({ scrollTop: jQuery("#" + id).offset().top }, 2000);
    }
}
jQuery.extend({
    xsdpAjax: function (url, type, dataGetter, onsuccess) {
        var execOnSuccess = jQuery.isFunction(onsuccess) ? onsuccess : jQuery.noop;
        var getData = jQuery.isFunction(dataGetter) ? dataGetter : function () {
            return dataGetter;
        };
        jQuery.ajax({
            url: url,
            type: type,
            data: getData(),
            traditional: true,
            beforeSend: function () {
                jQuery('.btn-viewmore').hide();
                jQuery('.loadmoreimg').show();
                jQuery('button.btn-red').prop('disabled', true).css('cursor', 'wait');
            },
            error: function (xhr, status, error) {
                if (xhr.status == 400) {
                    alert(xhr.responseText);
                } else {
                    alert('KhĂ´ng thá»ƒ káº¿t ná»‘i Ä‘áº¿n mĂ¡y chá»§.');
                }
                jQuery('.btn-viewmore').show();
                jQuery('.loadmoreimg').hide();
                jQuery('button.btn-red').prop('disabled', false).css('cursor', 'default');
            },
            success: function (data, status, xhr) {
                window.setTimeout(function () {
                    execOnSuccess(data);
                }, 10);
                jQuery('.btn-viewmore').show();
                jQuery('.loadmoreimg').hide();
                jQuery('button.btn-red').prop('disabled', false).css('cursor', 'default');
            }
        });
    }
});
jQuery.fn.preloader = function (options) {
    var defaults = {
        delay: 50,
        preload_parent: "a",
        check_timer: 300,
        ondone: function () { },
        oneachload: function (image) { },
        fadein: 300
    };
    var options = jQuery.extend(defaults, options),
        root = jQuery(this),
        images = root.find("img").css({
            "visibility": "hidden",
            opacity: 0
        }),
        timer, counter = 0,
        i = 0,
        checkFlag = [],
        delaySum = options.delay,
        init = function () {
            timer = setInterval(function () {
                if (counter >= checkFlag.length) {
                    clearInterval(timer);
                    options.ondone();
                    return;
                }
                for (i = 0; i < images.length; i++) {
                    if (images[i].complete == true) {
                        if (checkFlag[i] == false) {
                            checkFlag[i] = true;
                            options.oneachload(images[i]);
                            counter++;
                            delaySum = delaySum + options.delay;
                        }
                        jQuery(images[i]).css("visibility", "visible").delay(delaySum).animate({
                            opacity: 1
                        }, options.fadein, function () {
                            jQuery(this).parent().removeClass("preloader");
                        });
                    }
                }
            }, options.check_timer);
        };
    images.each(function () {
        if (jQuery(this).parent(options.preload_parent).length == 0) jQuery(this).wrap("<a class='preloader' />");
        else
            jQuery(this).parent().addClass("preloader");
        checkFlag[i++] = false;
    });
    images = jQuery.makeArray(images);
    var icon = jQuery("<img />", {
        id: 'loadingicon',
        src: '/assets/images/Loading_icon.gif'
    }).hide().appendTo("body");
    timer = setInterval(function () {
        if (icon[0].complete == true) {
            clearInterval(timer);
            init();
            icon.remove();
            return;
        }
    }, 100);
}