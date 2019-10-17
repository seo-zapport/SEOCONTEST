/*global $, jQuery, alert*/
/*jslint white: true, browser: true*/

//first input code in registration v 0.0.0.01

var Pending = '6';
var Approved = '7';
var Disqualified = '8';
var Trash ='11';


if(Trash == $.urlParam('status_id')){

    $("#bulkActionParticipant").append('<option value=9>Restore</option>');
    $("#bulkActionParticipant").append('<option value=16>Delete Permanently</option>');
    
}else if(Pending == $.urlParam('status_id')){
    
    $("#bulkActionParticipant").append('<option value=7>Approved</option>');
    $("#bulkActionParticipant").append('<option value=8>Disqualified</option>');
    $("#bulkActionParticipant").append('<option value=11>Move to Trash</option>');
    
}else if(Disqualified == $.urlParam('status_id')){

    $("#bulkActionParticipant").append('<option value=6>Pending</option>');
    $("#bulkActionParticipant").append('<option value=7>Approved</option>');
    $("#bulkActionParticipant").append('<option value=11>Move to Trash</option>');
    
}else{

    $("#bulkActionParticipant").append('<option value=6>Pending</option>');
    $("#bulkActionParticipant").append('<option value=7>Approved</option>');
    $("#bulkActionParticipant").append('<option value=8>Disqualified</option>');
    $("#bulkActionParticipant").append('<option value=11>Move to Trash</option>');

}

$(document).on('click', '.modalDelete', function(event){
  var passid = $(this).find('#Delid').val();
  $('.modal-header').addClass('bg-danger');
  $('.modal-header').removeClass('bg-primary');
  $('.modal-header').removeClass('bg-success');
  $('.modal-header').removeClass('bg-warning');
  $('.modal-title').html('<i class="fa fa-trash"></i> Delete Status');
  $('.for-delete').show('400');
  $('.deleteConstest').show('400');
  $('.for-restore').hide('400');
  $('.restoreBanner').hide('400');
  $('.for-movetrash').hide('400');
  $('.trashBanner').hide('400');
  $('.for-view').hide('400');
  $('.updateBanner').hide('400');
  $('.for-moveApproved').hide('400');
  $('.approvedBanner').hide('400');
  $('.pendingBanner').hide('400');
  $('.for-movePending').hide('400');
  $('.for-moveDisqualified').hide('400');
  $('.disqualifiedBanner').hide('400');
  $("input[name=reg_id]").val(passid);
});

$(document).on('click', '.modalRestore', function(event){
  var passid = $(this).find('#Restoreid').val();
  $('.modal-header').removeClass('bg-danger');
  $('.modal-header').addClass('bg-primary');
  $('.modal-header').removeClass('bg-success');
  $('.modal-header').removeClass('bg-warning');
  $('.modal-title').html('<i class="fa fa-refresh"></i> Restore Status');
  $('.for-delete').hide('400');
  $('.deleteConstest').hide('400');
  $('.for-restore').show('400');
  $('.restoreBanner').show('400');
  $('.for-movetrash').hide('400');
  $('.trashBanner').hide('400');
  $('.for-view').hide('400');
  $('.updateBanner').hide('400');
  $('.for-moveApproved').hide('400');
  $('.approvedBanner').hide('400');
  $('.pendingBanner').hide('400');
  $('.for-movePending').hide('400');
  $('.for-moveDisqualified').hide('400');
  $('.disqualifiedBanner').hide('400');
  $("input[name=reg_id]").val(passid);
});

$(document).on('click', '.modalTrash', function(event){
  var passid = $(this).find('#Trashid').val();
  $('.modal-header').addClass('bg-danger');
  $('.modal-header').removeClass('bg-primary');
  $('.modal-header').removeClass('bg-success');
  $('.modal-header').removeClass('bg-warning');
  $('.modal-title').html('<i class="fa fa-trash"></i> Move to Trash');
  $('.for-delete').hide('400');
  $('.deleteConstest').hide('400');
  $('.for-restore').hide('400');
  $('.restoreBanner').hide('400');
  $('.for-movetrash').show('400');
  $('.trashBanner').show('400');
  $('.for-view').hide('400');
  $('.updateBanner').hide('400');
  $('.for-moveApproved').hide('400');
  $('.approvedBanner').hide('400');
  $('.pendingBanner').hide('400');
  $('.for-movePending').hide('400');
  $('.for-moveDisqualified').hide('400');
  $('.disqualifiedBanner').hide('400');
  $("input[name=reg_id]").val(passid);
});

$(document).on('click', '.modalApproved', function(event){
  var passid = $(this).find('#Approvedid').val();
  $('.modal-header').removeClass('bg-danger');
  $('.modal-header').removeClass('bg-primary');
  $('.modal-header').addClass('bg-success');
  $('.modal-header').removeClass('bg-warning');
  $('.modal-title').html('<i class="fa fa-check"></i> Register Approved');
  $('.for-delete').hide('400');
  $('.deleteConstest').hide('400');
  $('.for-restore').hide('400');
  $('.restoreBanner').hide('400');
  $('.for-movetrash').hide('400');
  $('.trashBanner').hide('400');
  $('.for-view').hide('400');
  $('.updateBanner').hide('400');
  $('.for-moveApproved').show('400');
  $('.approvedBanner').show('400');
  $('.pendingBanner').hide('400');
  $('.for-movePending').hide('400');
  $('.for-moveDisqualified').hide('400');
  $('.disqualifiedBanner').hide('400');
  $("input[name=reg_id]").val(passid);
});

$(document).on('click', '.modalPending', function(event){
  var passid = $(this).find('#Pendingid').val();
  $('.modal-header').removeClass('bg-danger');
  $('.modal-header').removeClass('bg-primary');
  $('.modal-header').removeClass('bg-success');
  $('.modal-header').addClass('bg-warning');
  $('.modal-title').html('<i class="fa fa-files-o"></i> Register Pending');
  $('.for-delete').hide('400');
  $('.deleteConstest').hide('400');
  $('.for-restore').hide('400');
  $('.restoreBanner').hide('400');
  $('.for-movetrash').hide('400');
  $('.trashBanner').hide('400');
  $('.for-view').hide('400');
  $('.updateBanner').hide('400');
  $('.for-moveApproved').hide('400');
  $('.approvedBanner').hide('400');
  $('.pendingBanner').show('400');
  $('.for-movePending').show('400');
  $('.for-moveDisqualified').hide('400');
  $('.disqualifiedBanner').hide('400');
  $("input[name=reg_id]").val(passid);
});

$(document).on('click', '.modalDisqualified', function(event){
  var passid = $(this).find('#Disqualifiedid').val();
  $('.modal-header').addClass('bg-danger');
  $('.modal-header').removeClass('bg-primary');
  $('.modal-header').removeClass('bg-success');
  $('.modal-header').removeClass('bg-warning');
  $('.modal-title').html('<i class="fa fa-remove"></i> Disqualified Pending');
  $('.for-delete').hide('400');
  $('.deleteConstest').hide('400');
  $('.for-restore').hide('400');
  $('.restoreBanner').hide('400');
  $('.for-movetrash').hide('400');
  $('.trashBanner').hide('400');
  $('.for-view').hide('400');
  $('.updateBanner').hide('400');
  $('.for-moveApproved').hide('400');
  $('.approvedBanner').hide('400');
  $('.pendingBanner').hide('400');
  $('.for-movePending').hide('400');
  $('.for-moveDisqualified').show('400');
  $('.disqualifiedBanner').show('400');
  $("input[name=reg_id]").val(passid);
});

$(document).on('click', '.modalView', function(event){
  var passid = $(this).find('#Viewid').val();
  $('.modal-header').removeClass('bg-danger');
  $('.modal-header').addClass('bg-primary');
  $('.modal-header').removeClass('bg-success');
  $('.modal-header').removeClass('bg-warning');
  $('.modal-title').html('<i class="fa fa-user"></i> Contestant Info');
  $('.for-delete').hide('400');
  $('.deleteConstest').hide('400');
  $('.for-restore').hide('400');
  $('.restoreBanner').hide('400');
  $('.for-movetrash').hide('400');
  $('.trashBanner').hide('400');
  $('.for-view').show('400');
  $('.updateBanner').show('400');
  $('.for-moveApproved').hide('400');
  $('.approvedBanner').hide('400');
  $('.pendingBanner').hide('400');
  $('.for-movePending').hide('400');
  $('.for-moveDisqualified').hide('400');
  $('.disqualifiedBanner').hide('400');
  $("input[name=reg_id]").val(passid);
});

//Accept or Reject   
$(document).on('click', '#upateConstest', function(event){
  var id = $(this).data('id');
  var type = "PUT";
  var my_url = pathArray+"/"+$('#reg_id_'+id).val(); 

  var formData = {
    'action' : $('#stat option:selected').attr('value'),
    'name' : $('#full_name').val(),
    'email' : $('#email').val(),
    'mob_no' : $('#mob_no').val(),
    'bbm_pin' : $('#bbm_pin').val(),
    'url_permalink' : $('#url_permalink').val(),
    'bank_name' : $('#bank_name option:selected').attr('value'),
    'acct_no' : $('#acct_no').val(),
    'be_acct' : $('#be_acct').val(),  
    '_token' : $('input[name=_token]').val(),
  };

  $.ajax({
    type: type,
    url: my_url,
    data: formData,
    dataType: 'json',
    success: function(data) {
          location.reload();                     
    },
    error: function (data) {
        console.log('Error:', data);
         location.reload();  
    }
  });
});

//Single MoveAction 
$('.deleteConstest').click(function(event){
  var constestid = $(this).data('id');
  var type = "post";
  var my_url = pathArray;

  var formData = {
    'id' :constestid,
    '_token' : $('input[name=_token]').val(),
    '_method': 'delete',
  };  

  $.ajax({
    type: type,
    url: my_url + '/' + constestid,
    data: formData,
    dataType: 'json',
    success: function (data) {
      console.log(data);
      location.reload(); 
    },
      error: function (data) {
      console.log('Error:', data);
    }
  });
});     

$('.btn-moveActionConstest').click(function(event){
  var val = [];
  val.push($(this).data('id'));

  var moveactionprocess = $(this).data('action');
  var now_status =  $('#status_now_'+$(this).data('id')).val();

  if($('#status_now_'+$(this).data('id')).val() == "11"){
    var action = $('#curr_status_'+$(this).data('id')).val();
    var curr_status = now_status;
  }else{
    var action = moveactionprocess;
    var curr_status = now_status;
  }

  var type = "post";
  var my_url = pathArray +"/"+ val; 
  var moveprocess = "moveSingle"; 

  var formData = {
    'id' :val,
    'curr_status' : curr_status,
    'action' : action,
    'moveprocess':moveprocess,
    '_token' : $('input[name=_token]').val(),
    '_method': 'put',
  };
  
  console.log(moveactionprocess);
  console.log(formData);

  $.ajax({
     type: type,
     url: my_url,
     data: formData,
     dataType: 'json',
     success: function(data) {
      console.log(data);
      location.reload();  
     },
     error: function (data) {
        console.log('Error:', data);
     }
  });
});

    $('#btn-bulkActionConstest').click(function(){
    
            var val = [];
            $('.check:checked').each(function(i){
                 val[i] = $(this).val();
               });
    
            var action = $('#bulkActionParticipant option:selected').attr('value');
            var type = "post";
            var my_url = pathArray +"/"+ val; 
            var moveprocess = "moveMulti"; 

            var formData = {
            'id' :val,
            'action' : action,
            'moveprocess':moveprocess,
            '_token' : $('input[name=_token]').val(),
            '_method': 'put',
            }

            console.log(action);
            console.log(my_url);
            console.log(formData);

            $.ajax({
                type: type,
                url: my_url,
                data: formData,
                dataType: 'json',
                success: function(data) {
                 location.reload();  
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });

    });
    
    


//     $('#btn-bulkActionExportExcel').click(function(){
// 	    var passid = $(this).data('id');
//     	var type = "GET";
//     	var token = $("input[name='_token']").val();
//     	var status_id = passid;
//     	var my_url =  window.location.pathname+"/getExportExcel";

//     	var formData = {
//     		'status_id': status_id,
//     		'token' :  token,
//     	}
    
// 	    	$.ajax({
// 	    	    type: type,
// 	    	    url: my_url,
// 	    	    data: formData,
// 	    	    dataType: 'json',
// 	    	    success: function(data) {
	    	    	   
// 	    	    },
// 	    	    error: function (xhr,textStatus,thrownError,data) {
// 	    	        console.log(xhr + "\n" + textStatus + "\n" + thrownError);
// 	    	    }
// 	    	});
// });