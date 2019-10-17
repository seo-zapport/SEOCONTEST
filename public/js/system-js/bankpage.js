$(document).ready(function() {
     $("#formBank").validate({
       rules: {
           bname: {
               required: true
           }
       }
    });

    $(document).on('click', '.modalEdit', function(event){
        var passid = $(this).find('#Editid').val();
        $('.modal-title').text('Edit Status');
        $('.for-edit').show('400');
        $('.saveBankChanges').show('400');
        $('.for-delete').hide('400');
        $('.deleteBank').hide('400');
        $('.for-restore').hide('400');
        $('.restoreBank').hide('400');
        $('.for-movetrash').hide('400');
        $('.trashBank').hide('400');
        $('#bankid').val(passid);
    });

     $(document).on('click', '.modalDelete', function(event){
        var passid = $(this).find('#Delid').val();
        $('.modal-title').html('<i class="fa fa-trash"></i> Delete Status');
        $('.for-edit').hide('400');
        $('.saveBankChanges').hide('400');
        $('.for-delete').show('400');
        $('.deleteBank').show('400');
        $('.for-restore').hide('400');
        $('.restoreBank').hide('400');
        $('.for-movetrash').hide('400');
        $('.trashBank').hide('400');
        $('#bankid').val(passid);
        });
    
    $(document).on('click', '.modalRestore', function(event){
        var passid = $(this).find('#Restoreid').val();
        $('.modal-title').html('<i class="fa fa-refresh"></i> Restore Status');
        $('.for-edit').hide('400');
        $('.saveBankChanges').hide('400');
        $('.for-delete').hide('400');
        $('.deleteBank').hide('400');
        $('.for-restore').show('400');
        $('.restoreBank').show('400');
        $('.for-movetrash').hide('400');
        $('.trashBank').hide('400');
        $('#bankid').val(passid);
    });

    $(document).on('click', '.modalTrash', function(event){
        var passid = $(this).find('#Trashid').val();
        $('.modal-title').html('<i class="fa fa-trash"></i> Move to Trash');
        $('.for-edit').hide('400');
        $('.saveBankChanges').hide('400');
        $('.for-delete').hide('400');
        $('.deleteBank').hide('400');
        $('.for-restore').hide('400');
        $('.restoreBank').hide('400');
        $('.for-movetrash').show('400');
        $('.trashBank').show('400');
        $('#bankid').val(passid);
        });

   //  
 	$('#AddnewBank').click(function(event){

 		$.ajaxSetup({
 		    headers: {
 		        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
 		    }
 		})

        var type = "POST";
        var my_url = pathArray;
        
 		var formData = {
    	
        'bname' : $('#bname').val(),
        'langid' : $('#lang option:selected').attr('value'),
        'bacronym' : $('#bacronym').val(),
        '_token' : $('input[name=_token]').val(),
        }

 		$.ajax({
            type: type,
            url: my_url,
            data: formData,
            dataType: 'json',
            success: function(data) {

                 $('#Status-Items').load(location.href + ' #Status-Items');
                 $('.alert alert-success').load(location.href + ' .alert alert-success');
                 location.reload(); 
            },
            error: function (data) {
                console.log('Error:', data);
                location.reload();
            }
        });
 	
 	});

    $('.saveBankChanges').click(function(event){

        var bank_id = $('#bankid').val();
        var type = "post";
        var my_url = pathArray

        var formData = {
        'id' : $('#bankid').val(),
        'bname' : $('#edb_name_'+bank_id).val(),
        'langid' : $('#team_'+bank_id+' option:selected').attr('value'),
        'bacronym' : $('#edbank_acronym_'+bank_id).val(),
        '_token' : $('input[name=_token]').val(),
        '_method': 'put',
        }

        $.ajax({
            type: type,
            url: my_url + "/" + bank_id,
            data: formData,
            dataType: 'json',
            success: function(data) {
                console.log(data);
       
                 $('#Status-Items').load(location.href + ' #Status-Items');
                 $('.alert alert-success').load(location.href + ' .alert alert-success');
                 location.reload(); 
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    
    });

   $('.deleteBank').click(function(event){

        var bank_id = $('#bankid').val();
        var type = "post"
        var my_url = pathArray

        console.log(bank_id);

       var formData = {

        'id' :$('#bankid').val(),
        '_token' : $('input[name=_token]').val(),
        '_method': 'delete',
        }    

        $.ajax({

            type: type,
            url: my_url + '/' + bank_id,
            data: formData,
            dataType: 'json',
            success: function (data) {
                 location.reload(); 
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });




 
 });

