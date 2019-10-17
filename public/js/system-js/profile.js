 
$(document).ready(function() {

 $(document).on('click', '.nav-tabs li', function(event){
        var action =  $(this).find("a").html()
         $('#action').val(action);
  });

 $('#BtnSaveProfile').click(function(event){

        var user_id = $('#user_id').val();
        var type = "post";
        var my_url = pathArray;

        var action = $('#action').val();
        console.log(action);

      

            var formData = {
            'action' : action,
            'id' : user_id,
            'first_name' : $('#first_name').val(),
            'last_name' : $('#last_name').val(),
            'display_name' : $('#display_name').val(),
            'mobile_no' : $('#mobile_no').val(),
            'media_id' : $('#media_id').val(),
            
            '_token' : $('input[name=_token]').val(),
            '_method': 'put',
            }

        console.log(my_url);
        console.log(formData);


        $.ajax({
            type: type,
            url: my_url + "/" + user_id,
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


 $('#BtnSavePassword').click(function(event){

        var user_id = $('#user_id').val();
        var type = "post";
        var my_url = pathArray;

        var action = $('#action').val();
        console.log(action);

            var formData = {
            'action' : action,
            'id' : user_id,
            'password' : $('#password').val(),
            'password_confirmation' : $('#password-confirm').val(),
            '_token' : $('input[name=_token]').val(),
            '_method': 'put',
            }


        console.log(my_url);
        console.log(formData);


        $.ajax({
            type: type,
            url: my_url + "/" + user_id,
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