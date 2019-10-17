

$(document).ready(function(){


$("#useraccount").validate({
         rules: {
            first_name: {
                 required: true
             },
            last_name: {
                 required: true
             },
            account_type: {
                 required: true
             },
             country: {
                 required: true
             },
             password: {
                 required: true,
                 minlength: 6
             },
             email: {
                 required: true,
                 email: true,
             },
            
         }
     });


    var SuperAdmin ='1';
    var Admin = '2';
    var Developer = '3';
    var Support = '4';


    console.log($.urlParam('account_type'));

    if(Support == $.urlParam('account_type')){

        $("#RoleAction").append('<option value=1>Administrator</option>');
        $("#RoleAction").append('<option value=3>Developer</option>');

    }else if(Developer == $.urlParam('account_type')){

        $("#RoleAction").append('<option value=1>Administrator</option>');
        $("#RoleAction").append('<option value=4>Support</option>');


    }else if(Admin == $.urlParam('account_type')){

        $("#RoleAction").append('<option value=3>Developer</option>');
        $("#RoleAction").append('<option value=4>Support</option>');
        
    }else{

        $("#RoleAction").append('<option value=2>Administrator</option>');
        $("#RoleAction").append('<option value=3>Developer</option>');
        $("#RoleAction").append('<option value=4>Support</option>');
        
        
    }

    $(document).on('click', '.newpass', function(event){

        $('#Editpassword').show('400');
        $('.newpass').hide('400');
       
    });


    $('#btn-RoleAction').click(function(){

            var val = [];
            $('.check:checked').each(function(i){
                 val[i] = $(this).val();
               });

            var action = $('#RoleAction option:selected').attr('value');
            var type = "POST";
            var my_url = pathArray +"/"+ val;
            var moveprocess = "moveMulti";

            var formData = {
            'id' :val,
            'action' : action,
            'moveprocess': moveprocess,
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

    $('#btn-bulkActionUser').click(function(){

            var val = [];
            $('.check:checked').each(function(i){
                 val[i] = $(this).val();
               });

            var action = $('#bulkActionAccount option:selected').attr('value');
            var type = "POST";
            var my_url = pathArray +"/"+ val;
            var moveprocess = "moveMulti";

            var formData = {
            'id' :val,
            'action' : action,
            'moveprocess': moveprocess,
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

});





function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}