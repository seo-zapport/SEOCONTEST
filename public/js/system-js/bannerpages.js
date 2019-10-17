 $(document).ready(function() {

     $("#formbanner").validate({
         rules: {
            // target_url: {
            //      required: true,
            //      url: true
            // },
            title_name: {
                 required: true,
                 minlength: 6
             },
             title_b_name: {
                  required: true,
                  minlength: 6
              },
              alt_text: {
                   required: true,
                   minlength: 6
               },    
         }
     });   

     $(".alert-success").fadeOut(5000);
    
     $(document).on('click', '.modalDelete', function(event){
        var passid = $(this).find('#Delid').val();
        $('.modal-title').html('<i class="fa fa-trash"></i> Delete Status');
        $('.for-edit').hide('400');
        $('.saveCatChanges').hide('400');
        $('.for-delete').show('400');
        $('.deleteBanner').show('400');
        $('.for-restore').hide('400');
        $('.restoreBanner').hide('400');
        $('.for-movetrash').hide('400');
        $('.trashBanner').hide('400');
        $('#banner_id').val(passid);
        });
   
    $(document).on('click', '.modalRestore', function(event){
        var passid = $(this).find('#Restoreid').val();
        $('.modal-title').html('<i class="fa fa-refresh"></i> Restore Status');
        $('.for-edit').hide('400');
        $('.saveCatChanges').hide('400');
        $('.for-delete').hide('400');
        $('.deleteBanner').hide('400');
        $('.for-restore').show('400');
        $('.restoreBanner').show('400');
        $('.for-movetrash').hide('400');
        $('.trashBanner').hide('400');
        $('#banner_id').val(passid);
    });

    $(document).on('click', '.modalTrash', function(event){
        var passid = $(this).find('#Trashid').val();
        $('.modal-title').html('<i class="fa fa-trash"></i> Move to Trash');
        $('.for-edit').hide('400');
        $('.saveCatChanges').hide('400');
        $('.for-delete').hide('400');
        $('.deleteBanner').hide('400');
        $('.for-restore').hide('400');
        $('.restoreBanner').hide('400');
        $('.for-movetrash').show('400');
        $('.trashBanner').show('400');
        $('#banner_id').val(passid);
        });

    $(document).on('click', '.show_details_image', function(event){
      
      $('.details_attach').hide();
      var showgetid = $(this).data('id');
      $('.details_'+showgetid).show('400');
      $('#edit_id').val(showgetid);

      });
    
  
    $(document).on('click', '#selectbannerimg', function(event){
      
      $image_id = $('#edit_id').val();
      $("#preview_images").attr('src',$('#attach_url_'+$image_id).val());
      $("#media_id").attr('value',$image_id);
      $("#remove_set_img").removeClass('sr-only');
       
       $(".img-select-text").addClass('sr-only'); 

        var img = new Image;
        img.src= $('#attach_url_'+$image_id).val();
        img.onload = function() {
            //alert(img.width+" "+img.height);
           // if(img.width == "2000" && img.height == "490"){
           //      $(".img-error").addClass('sr-only');
           // }else{
           //      $(".img-error").removeClass('sr-only');
           // }
        };

    });

     $('#remove_set_img').click(function () { 
        $("#preview_images").attr('src','');
        $(".img-select-text").removeClass('sr-only'); 
        $("#media_id").attr('value','');
        $("#remove_set_img").addClass('sr-only');
        $(".img-error").addClass('sr-only');
    });


    $(document).on('click', '.nav-tabs li', function(event){
           var action =  $(this).find("a").html()
           
           if(action=="Upload Files"){         
                $('.col-md-2').addClass('sr-only');
                $('.media-attachment').removeClass('col-md-10');
                $('.media-attachment').addClass('col-md-12');

           }else{
                $('.col-md-2').removeClass('sr-only');
                $('.media-attachment').removeClass('col-md-12');
                $('.media-attachment').addClass('col-md-10');
           }

     });

    $(document).on('click', '#editstatus', function(event){   
            $('.updated_status').removeClass('sr-only');
            $('#editstatus').addClass('sr-only');
        
    });
    
    $(document).on('click', '#canceleditstat', function(event){   
            $('#editstatus').removeClass('sr-only');
            $('.updated_status').addClass('sr-only');
    });

   //CRUD  
 	$('#Saves').click(function(event){

     var bannerid = $('#bannerid').val();
        if(bannerid == ""){
            var my_url = pathArray.replace("/create", '');
            var type = "POST";
            var stat = "9";
        }else{
            var my_url = pathArray.replace("/edit", '');
            var type = "PUT";
            var stat = $('#bulkActionStatus option:selected').attr('value');
        }   


     if($('#merchantname option:selected').attr('value')== ""){
         var merchant = window.location.origin;
     }else{
         var merchant = $('#merchantname option:selected').attr('value');
     }   


     if($('#langname option:selected').attr('value')== ""){
         var lang_id = '1';
     }else{
         var lang_id = $('#langname option:selected').attr('value');
     }


 		var formData = {
        'cseo_media_id' : $('#media_id').val(),
        'title_name' : $('#title_name').val(),
        'title_b_name' : $('#title_b_name').val(),
        'target_url' : $('#target_url').val(),
        'alt_text' : $('#alt_text').val(),
        'cagetory' : $('#cagetory option:selected').attr('value'),
        'description' : $('#description').val(),
        'merchant' : merchant,
        'lang_id' : lang_id,
        'status_id' : stat,
 		'_token' : $('input[name=_token]').val(),

        }

        //console.log(formData);
      $.ajax({
                type: type,
                url: my_url,
                data: formData,
                dataType: 'json',
                success: function(data) {
                	console.log(data);

                    if(data.status=="success"){
                        console.log(data);
                        window.location= '/system/banner/'+data.id+'/edit';  
                    }
                },
                error: function (data) {
                    console.log('Error:', data);
                    location.reload();
                }
            });
 	});

   $('.deleteBanner').click(function(event){

        var bannerid = $('#banner_id').val();
        var type = "post"
        var my_url = pathArray

       var formData = {
        'id' :$('#banner_id').val(),
        '_token' : $('input[name=_token]').val(),
        '_method': 'delete',
        }    

        $.ajax({

            type: type,
            url: my_url + '/' + bannerid,
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
 
    $('.btn-bulkActionstat').click(function(event){
            
            var val = [];

            var action = $('#bulkActionStatus option:selected').attr('value');

            var type = "post";
            var my_url = pathArray.replace('/edit', '');
            var moveprocess = "moveSingle"; 
            val.push(my_url.replace('/system/banner/',''));
            
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
    
     $('.btn-movetrashban').click(function(event){

           var val = [];
           //var id = pathArray.replace('/edit', '');
           //val.push(id.replace('system/banner',''));
           val.push($('#bannerid').val());

            var action = '999';
            var type = "post";
            var my_url = pathArray.replace('/edit', ''); 
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
                 window.location = "/system/banner";  
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
    });

    $('.btn-moveActionBanner').click(function(event){

           var val = [];
            // $("input:hidden.banner_id").each(function() {
            //    val.push($(this).val());
            // });

            val.push($(this).data('id'));

            var now_status =  $('#status_now_'+$(this).data('id')).val();
            if($('#status_now_'+$(this).data('id')).val() =="11"){
              var action = $('#curr_status_'+$(this).data('id')).val();
              var curr_status = now_status;
            }else{
              var action = actionmove;
              var curr_status = now_status;
            }

            var type = "post";
            var my_url = pathArray +"/"+ val; 
            var moveprocess = "moveMulti"; 

             var formData = {
             'id' :val,
             'curr_status' : curr_status,
             'action' : action,
             'moveprocess':moveprocess,
             '_token' : $('input[name=_token]').val(),
             '_method': 'put',
             }

            //console.log(val);
            //console.log(action);
            //console.log(my_url);
           // console.log(formData);
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

    $('#btn-bulkActionBanner').click(function(){
    
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

            // console.log(action);
            // console.log(formData);
            // console.log(my_url);

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

 });

 function countrylang(lang){

     var type = "GET";
     var token = $("input[name='_token']").val();
     var langid = lang.value;
     var pageid = $('#bannerid').val();

     if($('#merchantname option:selected').attr('value')== ""){
         var merchant = window.location.origin;
     }else{
         var merchant = $('#merchantname option:selected').attr('value');
     }

     if(pageid != ""){
         var my_url = pathArray.replace("/"+pageid+"/edit", '/pageslang');   
     }


     if($('#pages_parent_id').val() == 0) {
         var parent_id = pageid;    
     }else{
         var parent_id = $('#pages_parent_id').val();    

     }
     var formData = {
        'cseo_media_id' : $('#media_id').val(),
        'title_name' : $('#title_name').val(),
        'title_b_name' : $('#title_b_name').val(),
        'target_url' : $('#target_url').val(),
        'alt_text' : $('#alt_text').val(),
        'cagetory' : $('#cagetory option:selected').attr('value'),
        'description' : $('#description').val(),
        'action' : "normal",
        'pageid' : parent_id,
        'merchant': merchant,
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
                 window.location= '/system/banner/'+data.id+'/edit';  
             }else{
                 console.log(data);
             }
         },
         error: function (data) {
             console.log('Error:', data);
         }
     });
 }