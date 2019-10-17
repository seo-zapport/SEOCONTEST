$(document).ready(function() {
     $("#formcategory").validate({
       rules: {
           category_name: {
               required: true
           }
       }
    });

    $(document).on('click', '.modalEdit', function(event){
        var passid = $(this).find('#Editid').val();
        $('.modal-title').text('Edit Status');
        $('.for-edit').show('400');
        $('.saveCatChanges').show('400');
        $('.for-delete').hide('400');
        $('.deleteCat').hide('400');
        $('.for-restore').hide('400');
        $('.restoreCountry').hide('400');
        $('.for-movetrash').hide('400');
        $('.trashCountry').hide('400');
        $('#catid').val(passid);
    });

     $(document).on('click', '.modalDelete', function(event){
        var passid = $(this).find('#Delid').val();
        $('.modal-title').html('<i class="fa fa-trash"></i> Delete Status');
        $('.for-edit').hide('400');
        $('.saveCatChanges').hide('400');
        $('.for-delete').show('400');
        $('.deleteCat').show('400');
        $('.for-restore').hide('400');
        $('.restoreCountry').hide('400');
        $('.for-movetrash').hide('400');
        $('.trashCountry').hide('400');
        $('#catid').val(passid);
        });
    
    $(document).on('click', '.modalRestore', function(event){
        var passid = $(this).find('#Restoreid').val();
        $('.modal-title').html('<i class="fa fa-refresh"></i> Restore Status');
        $('.for-edit').hide('400');
        $('.saveCatChanges').hide('400');
        $('.for-delete').hide('400');
        $('.deleteCat').hide('400');
        $('.for-restore').show('400');
        $('.restoreCountry').show('400');
        $('.for-movetrash').hide('400');
        $('.trashCountry').hide('400');
        $('#catid').val(passid);
    });

    $(document).on('click', '.modalTrash', function(event){
        var passid = $(this).find('#Trashid').val();
        $('.modal-title').html('<i class="fa fa-trash"></i> Move to Trash');
        $('.for-edit').hide('400');
        $('.saveCatChanges').hide('400');
        $('.for-delete').hide('400');
        $('.deleteCat').hide('400');
        $('.for-restore').hide('400');
        $('.restoreCountry').hide('400');
        $('.for-movetrash').show('400');
        $('.trashCountry').show('400');
        $('#catid').val(passid);
        });

   //  
 	$('#AddnewCat').click(function(event){

 		$.ajaxSetup({
 		    headers: {
 		        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
 		    }
 		})

        var type = "POST";
        var my_url = pathArray;
        

 		var formData = {
    	'category_name' : $('#category_name').val(),
        'description' : $('#description').val(),
        'taxo_id' : $('#taxo_id').val(),
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

    $('.saveCatChanges').click(function(event){

        var cat_id = $('#catid').val();
        var type = "post";
        var my_url = pathArray

        var formData = {
        'id' : $('#catid').val(),
        'category_name' : $('#edcategory_name_'+cat_id).val(),
        'description' : $('#eddescription_'+cat_id).val(),
        '_token' : $('input[name=_token]').val(),
        '_method': 'put',
        }

        $.ajax({
            type: type,
            url: my_url + "/" + cat_id,
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

   $('.deleteCat').click(function(event){

        var cat_id = $('#catid').val();
        var type = "post"
        var my_url = pathArray

        console.log(cat_id);

       var formData = {

        'id' :$('#catid').val(),
        '_token' : $('input[name=_token]').val(),
        '_method': 'delete',
        }    

        $.ajax({

            type: type,
            url: my_url + '/' + cat_id,
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
    $('.btn-moveActioncat').click(function(event){

    
           var val = [];
           $("input:hidden.catid").each(function() {
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

    $('#btn-bulkActioncat').click(function(){
    
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

