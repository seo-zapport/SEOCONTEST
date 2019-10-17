 $(document).ready(function() {


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

         var img = new Image();
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

      $('#sfi').click(function () { 
        $("#InsertPhoto").hide('400');
          $("#selectbannerimg").show('400');
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

            console.log(action);
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

      $("#InsertPhoto").click(function () {
        $("#Media").modal("hide"); // Close the modal
        $image_id = $('#edit_id').val();
        /* If variable value is not empty we pass it to tinymce function and it inserts the image to post */
        if ($image_id != "") { 
            tinymce.activeEditor.execCommand('mceInsertContent', false, '<img  class="img-responsive" style="max-width:100%; height:auto; display:block;" src="' + $('#attach_url_'+$image_id).val() + '">'); 
        }
     });

     /**
      * TinyMCE Text Editor
      */
     tinymce.init({
         selector: 'textarea[name=page_content]',
         entity_encoding: 'raw',
         max_height: 500,
         min_height: 500,
         menubar: false,
         branding: false,
         resize: false,
         plugins: [
             'advlist autolink lists link charmap print preview anchor',
             'searchreplace visualblocks code fullscreen',
             'insertdatetime table contextmenu paste code',
             'link image'
         ],
         setup: function (editor) {
         editor.addButton('newmedia', {
          text: 'Add media',
          title: 'Add image to article',
          icon: 'image',
          onclick: function() {
          $("#Media").modal("show");
          $("#InsertPhoto").show('400');
          $("#selectbannerimg").hide('400');

          } });
          },
         toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | code | newmedia'

         //content_css: ‘https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css’,

     });


       $(".titlecomp").prettyTextDiff({
          originalContent: $('#titleorg').text(),
          changedContent: $('#titlerct').text(),
          diffContainer: ".diffresulttitle",
          wrap              : false

       });    

       $(".contentcomp").prettyTextDiff({
          originalContent: $('#contorg').text(),
          changedContent: $('#contrct').text(),
        //   originalContent: $('#org-cont').val(),
        //   changedContent: $('#rct-cont').val(),
          diffContainer: ".diffresult",
          wrap              : false

       });
 
     $(".alert-success").fadeOut(5000);


     $(document).on('click', '.modalDelete', function(event){
        var passid = $(this).find('#Delid').val();
        $('.modal-title').html('<i class="fa fa-trash"></i> Delete Status');
        $('.for-edit').hide('400');
        $('.saveCatChanges').hide('400');
        $('.for-delete').show('400');
        $('.deletePages').show('400');
        $('.for-restore').hide('400');
        $('.restorePages').hide('400');
        $('.for-movetrash').hide('400');
        $('.trashPages').hide('400');
        $('#page_id').val(passid);
        });
   
    $(document).on('click', '.modalRestore', function(event){
        var passid = $(this).find('#Restoreid').val();
        $('.modal-title').html('<i class="fa fa-refresh"></i> Restore Status');
        $('.for-edit').hide('400');
        $('.saveCatChanges').hide('400');
        $('.for-delete').hide('400');
        $('.deletePages').hide('400');
        $('.for-restore').show('400');
        $('.restorePages').show('400');
        $('.for-movetrash').hide('400');
        $('.trashPages').hide('400');
        $('#page_id').val(passid);
    });

    $(document).on('click', '.modalTrash', function(event){
        var passid = $(this).find('#Trashid').val();
        $('.modal-title').html('<i class="fa fa-trash"></i> Move to Trash');
        $('.for-edit').hide('400');
        $('.saveCatChanges').hide('400');
        $('.for-delete').hide('400');
        $('.deletePages').hide('400');
        $('.for-restore').hide('400');
        $('.restorePages').hide('400');
        $('.for-movetrash').show('400');
        $('.trashPages').show('400');
        $('#page_id').val(passid);
        });


   //CRUD  
 	$('#Saves').click(function(event){

 		$.ajaxSetup({
 		    headers: {
 		        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
 		    }
 		})

        var pageid = $('#pageid').val();

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


        if(pageid == ""){
            var my_url = pathArray.replace("/create", '');
            var type = "POST";
        }else{
            var my_url = pathArray.replace("/edit", '');
            var type = "PUT";
        }

 		var formData = {
        'temp_id' : document.getElementById('title_name').getAttribute('data-id'),
        'cseo_media_id' : $('#media_id').val(),
        'page_title' : $('#title_name').val(),
        'page_name' : $('#title_name').val(),
        'page_content' : tinymce.get('page_content').getContent(),
        'tempo_id' : $('#pages_t_id').val(),
        'meta_title' : $('#meta_title').val(),
        'meta_description' : $('#meta_desc').val(),
        'merchant' : merchant,
        'lang_id' : lang_id,
        'action' : 'normal', 
         '_token' : $('input[name=_token]').val(),
        }

    		$.ajax({
                type: type,
                url: my_url,
                data: formData,
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    if(data.status=="success"){
                        window.location= '/system/pages/'+data.last_id+'/edit';  
                    }
                },
                error: function (data) {
                    console.log('Error:', data);
                    location.reload();
                }
            });
 	});

     var minlength = 5;
        
           $('input[name=title_name]').change(function () {
               
               var title_name = $(this).val();      
               var id = $(this).attr("data-id");

               if(id == ""){
                   var my_url = "/system/pages";                
                   var type = "POST";
               }else{
                    var my_url = "/system/pages/"+id;                 
                    var type = "PUT";
               }

                var formData = {
                'id' :  id,
                'cseo_media_id' : $('#media_id').val(),
                'page_title' : $('#title_name').val(),
                'page_name' : $('#title_name').val(),
                'page_content' :  tinymce.get('page_content').getContent(),
                'tempo_id' : $('#pages_t_id').val(),
                'meta_title' : $('#meta_title').val(),
                'meta_description' : $('#meta_desc').val(),
                'merchant' : window.location.origin,
                '_token' : $('input[name=_token]').val(),
                'lang_id': 1,
                'action' : 'draft',
                }
           
                if (title_name.length >= minlength ) {

                     $.ajax({
                        type: type,
                        url: my_url,
                        data: formData,
                        dataType: 'json',
                        success: function(data) {
                            document.getElementById('title_name').setAttribute('data-id',  data.last_id);
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                }
           }); 

   $('.deletePages').click(function(event){

        //var pageid = $('#page_id').val();
        var pageid = $(this).data('id');
        var type = "post"
        var my_url = pathArray

       var formData = {

        'id' :pageid,
        '_token' : $('input[name=_token]').val(),
        '_method': 'delete',
        }    

        $.ajax({

            type: type,
            url: my_url + '/' + pageid,
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

   $('.btn-delPages').click(function(event){

        //var pageid = $('#page_id').val();
        var pageid = $('#pageid').val();
        var type = "post"
        var my_url = pathArray.replace('/edit','');

       var formData = {

        'id' :pageid,
        '_token' : $('input[name=_token]').val(),
        '_method': 'delete',
        }    

        $.ajax({
            type: type,
            url: my_url,
            data: formData,
            dataType: 'json',
            success: function (data) {
               //location.reload();
               window.location = "/system/pages";  
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
 
   $(document).on('click', '#editstatus', function(event){   
           $('.updated_status').removeClass('sr-only');
           $('#editstatus').addClass('sr-only');
       
   });
   
   $(document).on('click', '#canceleditstat', function(event){   
           $('#editstatus').removeClass('sr-only');
           $('.updated_status').addClass('sr-only');
   });


    //Ajax move action

    $('.btn-movetrashpages').click(function(event){
    
           var val = [];
           var id = pathArray.replace('/edit', '');

            val.push(id.replace('system/pages/',''));

            var action = 9;
            var type = "post";
            var my_url = pathArray.replace('/edit', ''); 

            var formData = {
            'action' : action,
            '_token' : $('input[name=_token]').val(),
            '_method': 'put',
            }

            $.ajax({
                type: type,
                url: my_url,
                data: formData,
                dataType: 'json',
                success: function(data) {
                 window.location = "/system/pages";  
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
    });


    $('.btn-moveActionPages').click(function(event){
           var val = [];
    
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
            var moveprocess = "moveSingle"; 

             var formData = {
             'id' :val,
             'curr_status' : curr_status,
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
                 location.reload();  
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
    });

    $('#btn-bulkActionPages').click(function(){
    
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

    $('.btn-bulkActionstat').click(function(event){
            
            var val = [];
            var action = $('#bulkActionStatus option:selected').attr('value');
    
            var type = "post";
            var my_url = pathArray.replace('/edit', '');
            var moveprocess = "moveSingle"; 
            val.push(my_url.replace('/system/pages/',''));
            
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
        var pageid = $('#pageid').val();

        if($('#merchantname option:selected').attr('value') == ""){
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
            'page_title' : $('#title_name').val(),
            'page_name' : $('#title_name').val(),
            'page_content' : "",
            'meta_title' : $('#meta_title').val(),
            'meta_description' : $('#meta_desc').val(),
            'action' : 'normal', 
            'pageid' : parent_id,
            'merchant': merchant,
            'lang_id' : langid,
            'token' :  token,
        }
        
        $.ajax({
            type: type,
            url: my_url,
            data: formData,
            dataType: 'json',
            success: function(data) {
               console.log(data);
                if(data.status == "success"){
                    window.location= '/system/pages/'+data.last_id+'/edit';  
                }else{
                    console.log(data);
                }
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    }