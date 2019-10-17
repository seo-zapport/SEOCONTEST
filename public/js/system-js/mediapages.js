
    Dropzone.options.dropzoneFormCreate = {
         paramName: "file", // The name that will be used to transfer the file
         maxFilesize: 2, // MB
         acceptedFiles: 'image/*', //Only Images Accept
         dictDefaultMessage: "<strong>Drag and drop images here or click to upload. </strong></br> (Maximum Filesize is 2mb)",

    };

    Dropzone.options.dropzoneProfile = {
         paramName: "file", // The name that will be used to transfer the file
         maxFilesize: 2, // MB
         acceptedFiles: 'image/*', //Only Images Accept
         dictDefaultMessage: "<strong>Drag and drop images here or click to upload. </strong></br> (Maximum Filesize is 2mb)",

         success: function(file, response) {
                $('#media_library').load(location.href + ' #media_library');
                //dropzoneForm.removeFile(file); 
                if(pathArray == pathArray ){  
                   $('.nav-tabs a[href="#media_library"]').tab('show');
                   //$('.details').load(location.href + ' .details'); 
                   //location.reload(); 
                   $('.col-md-2').removeClass('sr-only');
                }
       },
       error: function (file, response) {
           console.log('Error:', data);
       },
        init: function(){
              var th = this;
              this.on('queuecomplete', function(){
                 /* ImageUpload.loadImage();  // CALL IMAGE LOADING HERE*/
                  setTimeout(function(){
                    th.removeAllFiles();  
                  },1000);
              })
          },

    };

    Dropzone.options.dropzoneForm = {
         paramName: "file", // The name that will be used to transfer the file
         maxFilesize: 2, // MB
         acceptedFiles: 'image/*', //Only Images Accept
         dictDefaultMessage: "<strong>Images files here or click to upload. </strong></br> (Maximum Filesize is 2mb)",

         success: function(file, response) {
                $('#media_library').load(location.href + ' #media_library');
                //dropzoneForm.removeFile(file); 
                if(pathArray == pathArray ){  
                   $('.nav-tabs a[href="#media_library"]').tab('show');
                   $('.details').load(location.href + ' .details'); 
                   location.reload(); 
                   $('.col-md-2').removeClass('sr-only');
                }
       },
       error: function (file, response) {
           console.log('Error:', data);
       },
        init: function(){
              var th = this;
              this.on('queuecomplete', function(){
                 /* ImageUpload.loadImage();  // CALL IMAGE LOADING HERE*/
                  setTimeout(function(){
                    th.removeAllFiles();  
                  },1000);
              })
          },

    };

 $(document).ready(function() {

        $(document).on('click', '#addnew', function(event){
           $('.dropimg').show('400');
        });    

        $(document).on('click', '#dropclose', function(event){
           $('.dropimg').hide('400');
        });    

        $(document).on('click', '.show_details', function(event){
        
        $id = $(this).data('id');

        $('.selected').removeClass('select');
        $('.check-select-'+$id).addClass('select');  
       
        $('.thumbnails.lightBoxGallery').removeClass('img_lib');
        $('.thumbnails.lightBoxGallery.selected-'+$id).addClass('img_lib');


        });


        $(document).on('click', '#delete_img', function(event){
           
                var type = "post";
                var my_url = '/system/media/'+$(this).data('id'); 
                var formData = {
                '_token' : $('input[name=_token]').val(),
                '_method': 'DELETE',
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


        var minlength = 3;
        
             $(document).on('click', '#modal-edit', function(event){
                 var passid = $(this).data('id');    
                $('#edit_id').val(passid);   
            });


           $('input[name=attach_title]').keyup(function () {
               
               var title_name = $(this).val();
               var id = $('#edit_id').val();
               console.log(title_name);

               var type = "POST";
               var my_url = "/system/media/"+id; 

                var formData = {
                'id' :id,
                'title_name' : $('#attach_title_'+id).val(),
                'caption_name' : $('#attach_caption_'+id).val(),
                 'alt_text' : $('#attach_alt_text_'+id).val(),
                 'description' : $('#attach_desc_'+id).val(),
                '_token' : $('input[name=_token]').val(),
                '_method': 'put',
                }
           
                if (title_name.length >= minlength ) {

                     $.ajax({
                        type: type,
                        url: my_url,
                        data: formData,
                        dataType: 'json',
                        success: function(data) {  
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                }
           });


           $('textarea[name=attach_caption]').keyup(function () {
               
               var attach_caption = $(this).val();
               var id = $('#edit_id').val();
               var type = "POST";
               var my_url = "/system/media/"+id; 

                var formData = {
                'id' :id,
                'title_name' : $('#attach_title_'+id).val(),
                'caption_name' : $('#attach_caption_'+id).val(),
                 'alt_text' : $('#attach_alt_text_'+id).val(),
                 'description' : $('#attach_desc_'+id).val(),
                '_token' : $('input[name=_token]').val(),
                '_method': 'put',
                }
           
           
                if (attach_caption.length >= minlength ) {

                     $.ajax({
                        type: type,
                        url: my_url,
                        data: formData,
                        dataType: 'json',
                        success: function(data) {
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                }
           });

           $('input[name=attach_alt_text]').keyup(function () {
               
               var attach_alt_text = $(this).val();
               var id = $('#edit_id').val();
               var type = "POST";
               var my_url = "/system/media/"+id; 

                var formData = {
                'id' :id,
                'title_name' : $('#attach_title_'+id).val(),
                'caption_name' : $('#attach_caption_'+id).val(),
                 'alt_text' : $('#attach_alt_text_'+id).val(),
                 'description' : $('#attach_desc_'+id).val(),
                '_token' : $('input[name=_token]').val(),
                '_method': 'put',
                }
           
                if (attach_alt_text.length >= minlength ) {

                     $.ajax({
                        type: type,
                        url: my_url,
                        data: formData,
                        dataType: 'json',
                        success: function(data) {
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                }
           });

           $('textarea[name=attach_desc]').keyup(function () {
               
               var attach_desc = $(this).val();
               var id = $('#edit_id').val();
               var type = "POST";
               var my_url = "/system/media/"+id; 

                var formData = {
                'id' :id,
                'title_name' : $('#attach_title_'+id).val(),
                'caption_name' : $('#attach_caption_'+id).val(),
                 'alt_text' : $('#attach_alt_text_'+id).val(),
                 'description' : $('#attach_desc_'+id).val(),
                '_token' : $('input[name=_token]').val(),
                '_method': 'put',
                }
           
                if (attach_desc.length >= minlength ) {

                     $.ajax({
                        type: type,
                        url: my_url,
                        data: formData,
                        dataType: 'json',
                        success: function(data) {
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                }
           });


 });

