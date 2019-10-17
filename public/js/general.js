/*global $, jQuery, alert*/
/*jslint white: true, browser: true*/

var base_url = window.location.origin;
var host = window.location.host;
var pathArray = window.location.pathname;



/*Bry Add Function*/

//functions for resiting the value of form
function resetForm($form) {
    $form.find('input:text, input:password, input:file, select, textarea').val('');
    $form.find('input:radio, input:checkbox')
         .removeAttr('checked').removeAttr('selected');
}


$.urlParam = function(name){
    var results = new RegExp('[\?&]' + name + '=([^]*)').exec(window.location.href);
    if (results==null){
       return null;
    }
    else{
       return results[1] || 0;
    }
}

var Trash = '11';
var Published = '9';


if(Trash == $.urlParam('status_id')){

    $("#bulkAction").append('<option value=9>Restore</option>');
    $("#bulkAction").append('<option value=16>Delete Permanently</option>');
    var actionmove = '9';

}else if(Published == $.urlParam('status_id')){
    //$("#bulkAction").append('<option value=6>Edit</option>');
    $("#bulkAction").append('<option value=11>Move to Trash</option>');
    var actionmove = '11';

}else{

    //$("#bulkAction").append('<option value=6>Edit</option>');
    $("#bulkAction").append('<option value=11>Move to Trash</option>');
    var actionmove = '11';
}

$(document).ready(function(){
		/*Javascript for Scroll Content*/
        $('.scroll_content').slimscroll({
                    height: '350px'
         });
         $('.scroll_content_grank').slimscroll({
                    height: '350px'
         });
});


/* new updated */

$('#selectAll').change(function(e) {
  if (e.currentTarget.checked) {
  $('.rows').find('input[type="checkbox"]').prop('checked', true);
} else {
    $('.rows').find('input[type="checkbox"]').prop('checked', false);
  }
});

