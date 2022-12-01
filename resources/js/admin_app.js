
require('./bootstrap');
window.Vue = require('vue').default;

Vue.config.devtools = true;
Vue.config.performance = true;


import UploadFileComponent from "./components/admin/UploadFileComponent.vue";
Vue.component("upload-file-component", UploadFileComponent);

new Vue({
    el: "#app",
});
const $ = window.$;

const _token = $('meta[name="csrf-token"]').attr('content');


if($('#editor_content').length){
    CKEDITOR.replace('editor_content',{
        height: "500px",
        filebrowserUploadUrl: "/admin/ckeditor/image_upload?_token=" + _token,
        filebrowserUploadMethod: 'form'
    });
}
if($('.editor_small_content').length){
    $('.editor_small_content').each(function(){
        let id = $(this).attr("id");
        CKEDITOR.replace(id,{
            height: "300px",
            filebrowserUploadUrl: "/admin/ckeditor/image_upload?_token=" + _token,
            filebrowserUploadMethod: 'form'
        });
    });
}

window.upload_max_chunk_size = 200000;

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': _token
    }
});

window.selectCity = (city, district_input, district) => {
    $.ajax({
        url: window.get_districts_url,
        type: "GET",
        data: {
            city
        },
        timeout: 10000,
        beforeSend: function() {
        },
        success: function(response) {
            if(response.districts !== undefined && response.districts.length > 0){
                let _options = '<option value="" selected>Chọn quận, huyện</option>';
                response.districts.forEach(item => {
                    let _selected = '';
                    if(district == item.id){
                        _selected = 'selected';
                    }
                    _options += '<option value="'+item.id+'" '+_selected+'>'+item.name+'</option>';
                });
                $(district_input).html(_options);
            }
        },
        error: function(t) {
        }
    });
}

window.selectDistrict = (district, ward_input, ward) => {
    $.ajax({
        url: window.get_wards_url,
        type: "GET",
        data: {
            district
        },
        timeout: 10000,
        beforeSend: function() {
        },
        success: function(response) {
            if(response.wards !== undefined && response.wards.length > 0){
                let _options = '<option value="" selected>Chọn phường, xã</option>';
                response.wards.forEach(item => {
                    let _selected = '';
                    if(ward == item.id){
                        _selected = 'selected';
                    }
                    _options += '<option value="'+item.id+'" '+_selected+'>'+item.name+'</option>';
                });
                $(ward_input).html(_options);
            }
        },
        error: function(t) {
        }
    });
}

window.addCommas = (nStr) => {
    var nDec = "";
    if (nStr.indexOf(".") > -1){
        var aDec = nStr.split(".");
        nDec = "." + aDec[1];
        nStr = aDec[0];
    }
    nStr = window.removeCommas(nStr);
    nStr += '';
    let x = nStr.split(',');
    let x1 = x[0];
    let x2 = x.length > 1 ? ',' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1))
    {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    var sReturn = x1 + x2;
    sReturn = sReturn + nDec;
    return sReturn;
}
window.removeCommas = (theString) => {
    var rgx = /(\,)/g;
    return theString.replace(rgx, "");
}
window.parseMoney = (oObj,oFunction) => {
    var sValue = window.addCommas(oObj.value.toString());
    oObj.value = sValue;
    if (typeof(oFunction) != "undefined"){
        oFunction.call(oObj);
    }
}