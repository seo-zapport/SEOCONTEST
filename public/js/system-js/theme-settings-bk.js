/*global $, jQuery, alert*/
/*jslint white: true, browser: true*/

$(function () {
    "use strict";
    tinymce.init({
        selector: 'textarea[name=site_fp_editor]',
        entity_encoding: 'raw',
        max_height: 500,
        min_height: 500,
        menubar: false,
        branding: false,
        resize: false,
        plugins: [
         'advlist autolink lists link charmap print preview anchor',
         'searchreplace visualblocks code fullscreen',
         'insertdatetime table contextmenu paste code'
        ],
        toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | code'
    });

    tinymce.init({
        selector: 'textarea[name=header_misc]',
        entity_encoding: 'raw',
        max_height: 500,
        min_height: 500,
        menubar: false,
        branding: false,
        resize: false,
        toolbar: false,
        plugins: [
         'advlist autolink lists link charmap print preview anchor',
         'searchreplace visualblocks code fullscreen',
         'insertdatetime table contextmenu paste code'
        ]
    });

    tinymce.init({
        selector: 'textarea[name=footer_misc]',
        entity_encoding: 'raw',
        max_height: 500,
        min_height: 500,
        menubar: false,
        branding: false,
        resize: false,
        toolbar: false,
        plugins: [
         'advlist autolink lists link charmap print preview anchor',
         'searchreplace visualblocks code fullscreen',
         'insertdatetime table contextmenu paste code'
        ]
    });

    $('#colorElementHeading').colorpicker();
    $('#colorElementDefaultColor').colorpicker();
    $('#colorElementMenuColorWrap').colorpicker();
    $('#colorElementMenuColorText').colorpicker();
    $('#colorElementMenuColorHover').colorpicker();
    $('#colorElementMenuColorMobileBtn').colorpicker();
    $('#colorElementMenuColorMobileBtnIcon').colorpicker();
    $('#colorElementMenuColorMobileBtnHover').colorpicker();
    $('#colorElementBGColor').colorpicker();
    $('#data_1 .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
    });
    $('.chosen-select').chosen({width: "100%"});

    $('.footable').footable();

    var global_value = "";

    $('a.browsePogi').on('click',function(){
        if ($(this).data('option') === "logo" ) {
            global_value = 'logo';
        }else if($(this).data('option') === "icon"){
            global_value = 'icon';
        }else if($(this).data('option') === "banner"){
            global_value = 'banner';    
        }else{
            global_value = 'bg_image';
        }
    });

    $(document).on('click', '.show_details_image', function(event){
        event.preventDefault();
        $('.details_attach').hide();
        var showgetid = $(this).data('id');
        $('.details_'+showgetid).show('400');
        $('#edit_id').val(showgetid);
    });
    $(document).on('click', '#selectbannerimg', function(event){
        event.preventDefault();
        var image_id = $('#edit_id').val();

        if ( global_value === "logo" ) {
            $("#preview_logo").attr('src',$('#attach_url_' + image_id).val());
            $("#media_logo").attr('value',image_id);
            $('#btnWrapRemove > #sampleBtn').show();
        }else if ( global_value === "icon" ) {
            $("#preview_icon").attr('src',$('#attach_url_'+image_id).val());
            $("#media_icon").attr('value',image_id);
        }else if ( global_value === "banner" ) {
            $("#preview_banner").attr('src',$('#attach_url_'+image_id).val());
            $("#media_banner").attr('value',image_id);
        }else{
            $("#preview_bg_img").attr('src',$('#attach_url_'+image_id).val());
            $("#media_bg_img").attr('value',image_id);
        }        
        $("#remove_set_img").removeClass('sr-only'); 
        $(".img-select-text").addClass('sr-only'); 
    });
    $(document).on('click', '.nav-tabs li', function(event){
        event.preventDefault();
        var action =  $(this).find("a").html();

        if( action === "Upload Files" ){         
            $('.col-md-2').addClass('sr-only');
            $('.media-attachment').removeClass('col-md-10');
            $('.media-attachment').addClass('col-md-12');
        }else{
            $('.col-md-2').removeClass('sr-only');
            $('.media-attachment').removeClass('col-md-12');
            $('.media-attachment').addClass('col-md-10');
        }
    });
    //btnstyle
    $('#sampleBtn').on('click', function(){
        $("#preview_logo").attr('src','http://via.placeholder.com/250x60');
        $("#media_logo").attr('value','0');       
        $(this).hide();
    });
    //a link
    $('.tab-item a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var target = $(e.target).data("bg_attr"); // activated tab
        $('#bgAttrib_opt').val(target); 
    });

    //Getting
    $('select#site_url').bind('change',function(e){
        var id = "select#site_url";
        var $siteMerchant = $(id + ' option:selected').data('merchant');
        e.preventDefault();
        $('input[name=site_merchant_id]').val($siteMerchant);
    }).trigger('change');

    //Check what is the item selected in presets field
    $('select#site_fp_presets').bind('change',function(e){
        e.preventDefault();
        var selecValue = $(this).val();
        if ( selecValue === 'fill-screen' ) {
            $('#site_fp_elem__position').show();
            $('#site_fp_elem__repeat').hide();
            $('#site_fp_elem__scroll').hide();
            $('#site_fp_elem__size').hide();
        }else if( selecValue === 'fit-to-screen' ){
            $('#site_fp_elem__position').show();
            $('#site_fp_elem__repeat').show();
            $('#site_fp_elem__scroll').hide();
            $('#site_fp_elem__size').hide();
        }else if( selecValue === 'repeat' ){
            $('#site_fp_elem__position').show();
            $('#site_fp_elem__repeat').hide();
            $('#site_fp_elem__scroll').show();
            $('#site_fp_elem__size').hide();
        }else if( selecValue === 'custom' ){
            $('#site_fp_elem__position').show();
            $('#site_fp_elem__repeat').show();
            $('#site_fp_elem__scroll').show();
            $('#site_fp_elem__size').show();
        }else{
            $('#site_fp_elem__position').hide();
            $('#site_fp_elem__repeat').hide();
            $('#site_fp_elem__scroll').hide();
            $('#site_fp_elem__size').hide();
        }
    }).trigger('change');

    //Theme Settings Process
    $('#theme_settings_btn_update').bind('click', function(){
        $('#theme_settings_form').each(function(){
            $(this).change();
        });
        
        //Getting all of the value
        var _token = $('input[name=_token]').val(),
        site_id = $(this).data('theme_id'),
        site_url = $('#site_url').val(),
        merchant_id = $('input[name=site_merchant_id]').val(),
        media_logo = $('input[name=media_logo]').val(),
        media_banner = $('input[name=media_banner]').val(),
        site_title = $('input[name=site_title]').val(),
        site_tag_line = $('input[name=site_tag_line]').val(),
        site_display_assets = $('input[name=site_display_assets]').prop('checked'),
        media_icon = $('input[name=media_icon]').val(),
        familyHead_opt = $('#font_family_heading').chosen().val(),
        font_size_heading = $('#font_size_heading').val(),
        font_style_heading = $('select#font_style_heading').val(),
        font_weight_heading = $('select#font_weight_heading').val(),
        familyContent_opt = $('#font_family_content').chosen().val(),
        font_size_content = $('#font_size_content').val(),
        font_style_content = $('#font_style_content').val(),
        font_weight_content = $('#font_weight_content').val(),
        colorElementHeading = $('input[name=colorElementHeading]').val(),
        colorElementMenuColorWrap = $('input[name=colorElementMenuColorWrap]').val(),
        colorElementMenuColorText = $('input[name=colorElementMenuColorText]').val(),
        colorElementMenuColorHover = $('input[name=colorElementMenuColorHover]').val(),
        colorElementMenuColorMobileBtn = $('input[name=colorElementMenuColorMobileBtn]').val(),
        colorElementMenuColorMobileBtnIcon = $('input[name=colorElementMenuColorMobileBtnIcon]').val(),
        colorElementMenuColorMobileBtnHover = $('input[name=colorElementMenuColorMobileBtnHover]').val(),
        colorElementDefaultColor = $('input[name=colorElementDefaultColor]').val(),
        bgAttrib_opt = $('#bgAttrib_opt').val(),
        bgcoloritem_opt = $('input[name=colorElementBGColor]').val(),
        bgimageitem_opt = $('input[name=media_bg_img]').val(),
        site_fp_presets = $('select#site_fp_presets').val(),
        site_fp_position = $('input[name=radioInline]:checked').val(),
        site_fp_repeat = $('input[name=site_fp_repeat]').prop('checked'),
        site_fp_scroll = $('input[name=site_fp_scroll]').prop('checked'),
        site_fp_size = $('select#site_fp_size').val(),

        /*Frontpage*/
        site_fp_title = $('input[name=site_fp_title]').val(),
        site_fp_editor = tinymce.get('site_fp_editor').getContent(),
        google_ranking = $('input[name=site_act_title]').val(),
        google_gvkey = $('input[name=site_gv]').val(),
        google_gakey = $('input[name=site_ga]').val(),
        google_gkey = $('input[name=site_g_key]').val(),
        google_skey = $('input[name=site_s_key]').val(),

        /*Notification*/
        site_notif = $('input[name=site_notif]').val(),
        lor = $('input[name=daterange]').val(),
        wa = $('input[name=daterangeend]').val(),
        
        /* Misc */
        /*head_misc = $('textarea#header_misc').val(),*/
        head_misc = tinymce.get('header_misc').getContent(),
        foot_misc = tinymce.get('footer_misc').getContent(),

        /*Footer*/
        site_fp_ft_copyright = $('#site_fp_ft_copyright').val(),
        site_fp_ft_target = $('select[name=site_fp_ft_target]').val(),
        site_fp_ft_rel = $('select[name=site_fp_ft_rel]').val();


        if (bgAttrib_opt === 'color' || bgimageitem_opt < 2) {
            bgAttrib_opt = '1';
        }else{
            bgAttrib_opt = '2';
        }

        var maintenance_val; 

        if ($('.js-switch').is(':checked')){
             maintenance_val = '1';
        }else{
            maintenance_val = '0';
        }

        var  lang_id;

        if($('#langname option:selected').attr('value') === ""){
             lang_id = window.location.origin;
        }else{
            lang_id = $('#langname option:selected').attr('value');
        }
        

        // var dataSend = '';
        // dataSend += '_token=' + _token;
        // dataSend += '&site_id=' + site_id;
        // dataSend += '&site_url=' + site_url;
        // dataSend += '&merchant_id=' + merchant_id;
        // dataSend += '&media_logo=' + media_logo;
        // dataSend += '&media_banner=' + media_banner;
        // dataSend += '&site_title=' + site_title;
        // dataSend += '&site_tag_line=' + site_tag_line;
        // dataSend += '&site_display_assets=' + site_display_assets;
        // dataSend += '&media_icon=' + media_icon;
        // dataSend += '&familyHead_opt=' + familyHead_opt;
        // dataSend += '&font_size_heading=' + font_size_heading;
        // dataSend += '&font_style_heading=' + font_style_heading;
        // dataSend += '&font_weight_heading=' + font_weight_heading;
        // dataSend += '&familyContent_opt=' + familyContent_opt;
        // dataSend += '&font_size_content=' + font_size_content;
        // dataSend += '&font_style_content=' + font_style_content;
        // dataSend += '&font_weight_content=' + font_weight_content;
        // dataSend += '&colorElementHeading=' + colorElementHeading;
        // dataSend += '&colorElementMenuColorWrap=' + colorElementMenuColorWrap;
        // dataSend += '&colorElementMenuColorText=' + colorElementMenuColorText;
        // dataSend += '&colorElementMenuColorHover=' + colorElementMenuColorHover;
        // dataSend += '&colorElementMenuColorMobileBtn=' + colorElementMenuColorMobileBtn;
        // dataSend += '&colorElementMenuColorMobileBtnIcon=' + colorElementMenuColorMobileBtnIcon;
        // dataSend += '&colorElementMenuColorMobileBtnHover=' + colorElementMenuColorMobileBtnHover;
        // dataSend += '&colorElementDefaultColor=' + colorElementDefaultColor;
        // dataSend += '&bgAttrib_opt=' + bgAttrib_opt;
        // dataSend += '&bgcoloritem_opt=' + bgcoloritem_opt;
        // dataSend += '&bgimageitem_opt=' + bgimageitem_opt;
        // if (bgAttrib_opt === "1") {
        // }else{
        //     dataSend += '&site_fp_presets=' + site_fp_presets;
        //     if ( site_fp_presets === 'fill-screen' ) {
        //         dataSend += '&site_fp_position=' + site_fp_position;
        //     }else if( site_fp_presets === 'fit-to-screen' ){
        //         dataSend += '&site_fp_position=' + site_fp_position;
        //         dataSend += '&site_fp_repeat=' + site_fp_repeat;
        //     }else if( site_fp_presets === 'repeat' ){
        //         dataSend += '&site_fp_position=' + site_fp_position;
        //         dataSend += '&site_fp_scroll=' + site_fp_scroll;
        //     }else if( site_fp_presets === 'custom' ){
        //         dataSend += '&site_fp_position=' + site_fp_position;
        //         dataSend += '&site_fp_repeat=' + site_fp_repeat;
        //         dataSend += '&site_fp_scroll=' + site_fp_scroll;
        //         dataSend += '&site_fp_size=' + site_fp_size;
        //     }
        // }
        // dataSend += '&site_fp_title=' + site_fp_title;
        // dataSend += '&google_ranking=' + google_ranking;
        // dataSend += '&google_gv=' + google_gvkey;
        // dataSend += '&google_ga=' + google_gakey;
        // dataSend += '&google_gkey=' + google_gkey;
        // dataSend += '&google_skey=' + google_skey;
        // dataSend += '&site_notif=' + site_notif;
        // dataSend += '&lor=' + lor;
        // dataSend += '&wa=' + wa;
      
        // dataSend += '&maintenance_mode=' + maintenance_val;
        // dataSend += '&lang_id=' + lang_id;
        // dataSend += '&site_fp_editor=' + site_fp_editor;
        // dataSend += '&site_fp_ft_copyright=' + site_fp_ft_copyright;
        // dataSend += '&site_fp_ft_target=' + site_fp_ft_target;
        // dataSend += '&site_fp_ft_rel=' + site_fp_ft_rel;
        //  dataSend += '&head_misc=' + head_misc;
        // dataSend += '&foot_misc=' + foot_misc;
        
         var dataSend = {
        
        	'_token'	:	_token,
        	'site_id'	: 	site_id,
        	'site_url'	:	site_url,
        	'merchant_id'	:	merchant_id,
        	'media_logo'	: 	media_logo,
        	'media_banner'	:	media_banner,
        	'site_title'	:	site_title,
        	'site_tag_line'	:	site_tag_line,
        	'site_display_assets'	:	site_display_assets,
        	'media_icon'	:	media_icon,
        	'familyHead_opt'	:	familyHead_opt,
        	'font_size_heading'	:	font_size_heading,
        	'font_style_heading'	:	font_style_heading,
        	'font_weight_heading'	:	font_weight_heading,
        	'familyContent_opt'	:	familyContent_opt,
        	'font_size_content'	:	font_size_content,
        	'font_style_content'	:	font_style_content,
        	'font_weight_content'	:	font_weight_content,
        	'colorElementHeading'	:	colorElementHeading,
        	'colorElementMenuColorWrap'	:	colorElementMenuColorWrap,
        	'colorElementMenuColorText'	:	colorElementMenuColorText,
        	'colorElementMenuColorHover'	:	colorElementMenuColorHover,
        	'colorElementMenuColorMobileBtn'	:	colorElementMenuColorMobileBtn,
        	'colorElementMenuColorMobileBtnIcon'	:	colorElementMenuColorMobileBtnIcon,
        	'colorElementMenuColorMobileBtnHover'	:	colorElementMenuColorMobileBtnHover,
        	'colorElementDefaultColor'	:	colorElementDefaultColor,
        	'bgAttrib_opt'	:	bgAttrib_opt,
        	'bgcoloritem_opt'	:	bgcoloritem_opt,
        	'bgimageitem_opt'	:	bgimageitem_opt,
        	'site_fp_presets' : site_fp_presets,
        	'site_fp_position' : site_fp_position,
            'site_fp_repeat=' : site_fp_repeat,
            'site_fp_scroll=' : site_fp_scroll,
            'site_fp_size=' : site_fp_size,
        	'site_fp_title'	: 	site_fp_title,
            'google_ranking'	: 	google_ranking,
            'google_gv'	: 	google_gvkey,
            'google_ga'	: 	google_gakey,
            'google_gkey'	: 	google_gkey,
            'google_skey'	: 	google_skey,
            'site_notif'	: 	site_notif,
            'lor'	: 	lor,
            'wa'	: 	wa,
            'maintenance_mode' : 	maintenance_val,
            'lang_id' : 	lang_id,
            'site_fp_editor' : 	site_fp_editor,
            'site_fp_ft_copyright' : 	site_fp_ft_copyright,
            'site_fp_ft_target' : 	site_fp_ft_target,
            'site_fp_ft_rel' : 	site_fp_ft_rel,
            'head_misc' : 	head_misc,
            'foot_misc' : 	foot_misc,
        	'_method': 'put',
        }

        console.log(dataSend);    
        //console.log(site_id);
        
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            type: 'POST',
            //url: '/system/theme-settings/' + site_id + '/update',
            url: '/system/theme-settings/' + site_id ,
            cache: false,
            data: dataSend,
            dataType: 'json',
            success: function(data){
                var status = data.status,
                message = data.message,
                redirect = data.redirect;
                if ( status === 'success' ) {
                    swal({ 
                        title: status,
                        text: message,
                        type: "success",
                        confirmButtonText: 'Okay',
                    },
                    function (isConfirm){
                        if (isConfirm) {
                            window.location.assign(redirect);
                        }
                    }, 2000);                   
                }else{
                  // swal( status , message, "Warning");
                  swal( status , message, "warning");
                   
                }
            }
        
            // },
            // error: function (data) {
            //         swal('Oops...','Something went wrong!','warning');
            //         console.log('Error:', data);
            //         //location.reload();

            // }
         });
    });
});

  function countrylang(lang){

        var type = "GET";
        var token = $("input[name='_token']").val();
        var langid = lang.value;
        var pageid = $('#pageid').val();
        var merchant = $("#site_merchant_id").val();
        var merchant_title = $("#site_title").val();


        //if(pageid != ""){
            var my_url = "/system/theme-settings/pageslang";   
       // }

        var formData = {

            'pageid' : pageid,
            'merchant': merchant,
            'merchant_title' : merchant_title,
            'lang_id' : langid,
            'token' :  token,
        }
        
        //console.log(my_url);
        //console.log(formData);
    
        $.ajax({
            type: type,
            url: my_url,
            data: formData,
            dataType: 'json',
            success: function(data) {
               console.log(data);
                if(data.status == "success"){
                    window.location= '/system/theme-settings/'+data.last_id+'/edit';  
                }else{
                    console.log(data);
                }
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    }
    
   $(document).ready(function(){

              $('input[name="daterange"]').daterangepicker({
                    timePicker: true,
                    //timePickerIncrement: 30,
                    minDate: '01-01-2018 00:00 AM',
                    maxDate: '12-31-2020 00:00 AM',
                    locale: {
                        format: 'MM/DD/YYYY h:mm A'
                    }
                });

              $('input[name="daterangeend"]').daterangepicker({
                    timePicker: true,
                    //timePickerIncrement: 30,
                    minDate: '01-01-2018 00:00 AM',
                    maxDate: '12-31-2020 00:00 AM',
                    locale: {
                        format: 'MM/DD/YYYY h:mm A'
                    }
                });
            
            
 });
