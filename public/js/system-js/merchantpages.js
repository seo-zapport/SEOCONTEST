$(document).ready(function() {
     $("#formMerchant").validate({
       rules: {
           merchant_name: {
               required: true
           }
       }
    });

    $(document).on('click', '.modalEdit', function(event){
        var passid = $(this).find('#Editid').val();
        $('.modal-title').text('Edit Status');
        $('.for-edit').show('400');
        $('.saveBrandChanges').show('400');
        $('.for-delete').hide('400');
        $('.deleteBrand').hide('400');
        $('.for-restore').hide('400');
        $('.restoreBrand').hide('400');
        $('.for-movetrash').hide('400');
        $('.trashBrand').hide('400');
        $('#brandid').val(passid);
    });

     $(document).on('click', '.modalDelete', function(event){
        var passid = $(this).find('#Delid').val();
        $('.modal-title').html('<i class="fa fa-trash"></i> Delete Status');
        $('.for-edit').hide('400');
        $('.saveBrandChanges').hide('400');
        $('.for-delete').show('400');
        $('.deleteBrand').show('400');
        $('.for-restore').hide('400');
        $('.restoreBrand').hide('400');
        $('.for-movetrash').hide('400');
        $('.trashBrand').hide('400');
        $('#brandid').val(passid);
        });
    
    $(document).on('click', '.modalRestore', function(event){
        var passid = $(this).find('#Restoreid').val();
        $('.modal-title').html('<i class="fa fa-refresh"></i> Restore Status');
        $('.for-edit').hide('400');
        $('.saveBrandChanges').hide('400');
        $('.for-delete').hide('400');
        $('.deleteBrand').hide('400');
        $('.for-restore').show('400');
        $('.restoreBrand').show('400');
        $('.for-movetrash').hide('400');
        $('.trashBrand').hide('400');
        $('#brandid').val(passid);
    });

    $(document).on('click', '.modalTrash', function(event){
        var passid = $(this).find('#Trashid').val();
        $('.modal-title').html('<i class="fa fa-trash"></i> Move to Trash');
        $('.for-edit').hide('400');
        $('.saveBrandChanges').hide('400');
        $('.for-delete').hide('400');
        $('.deleteBrand').hide('400');
        $('.for-restore').hide('400');
        $('.restoreBrand').hide('400');
        $('.for-movetrash').show('400');
        $('.trashBrand').show('400');
        $('#brandid').val(passid);
        });

   //  
 	$('#AddnewBrand').click(function(event){

 		$.ajaxSetup({
 		    headers: {
 		        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
 		    }
 		})

        var type = "POST";
        var my_url = pathArray;
        
 		var formData = {
    	'merchant_name' : $('#merchant_name').val(),
        'team_id' : $('#team option:selected').attr('value'),
        'merchant_title' : $('#merchant_title').val(),
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

    $('.saveBrandChanges').click(function(event){

        var brand_id = $('#brandid').val();
        var type = "post";
        var my_url = pathArray

        var formData = {
        'id' : $('#brandid').val(),
        'category_name' : $('#edbrand_name'+brand_id).val(),
        'team_id' : $('#team_'+brand_id+' option:selected').attr('value'),
        'description' : $('#eddescription_'+brand_id).val(),
        '_token' : $('input[name=_token]').val(),
        '_method': 'put',
        }

        $.ajax({
            type: type,
            url: my_url + "/" + brand_id,
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

   $('.deleteBrand').click(function(event){

        var brand_id = $('#brandid').val();
        var type = "post"
        var my_url = pathArray

        console.log(brand_id);

       var formData = {

        'id' :$('#brandid').val(),
        '_token' : $('input[name=_token]').val(),
        '_method': 'delete',
        }    

        $.ajax({

            type: type,
            url: my_url + '/' + brand_id,
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

    //Ajax move action
    $('.btn-moveActionBrand').click(function(event){

           var val = [];
           $("input:hidden.brandid").each(function() {
              val.push($(this).val());
           });

            var action = actionmove;
            var type = "post";
            var my_url = pathArray +"/"+ val; 
            var moveprocess = "moveSingle"; 

            var formData = {
            'id' :val,
            'action' : action,
            'moveprocess':moveprocess,
            '_token' : $('input[name=_token]').val(),
            '_method': 'put',
            }

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

    $('#btn-bulkActionBrand').click(function(){
    
            var val = [];
            $('.check:checked').each(function(i){
                 val[i] = $(this).val();
               });
    
            var action = $('#bulkAction option:selected').attr('value');

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
                 console.log(data);
                 location.reload();  
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });

    });
 
 });

