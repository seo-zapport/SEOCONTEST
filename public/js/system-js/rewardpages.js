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
        $('.saveRewardChanges').show('400');
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
        $('.saveRewardChanges').hide('400');
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
        $('.saveRewardChanges').hide('400');
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
        $('.saveRewardChanges').hide('400');
        $('.for-delete').hide('400');
        $('.deleteBrand').hide('400');
        $('.for-restore').hide('400');
        $('.restoreBrand').hide('400');
        $('.for-movetrash').show('400');
        $('.trashBrand').show('400');
        $('#brandid').val(passid);
        });

   //  
 	$('#AddnewReward').click(function(event){

 		$.ajaxSetup({
 		    headers: {
 		        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
 		    }
 		})

        var type = "POST";
        var merchant = pathArray.replace('/edit','');
        var merchants_id = merchant.replace('/system/reward/','');
        var my_url = merchant.replace('/'+merchants_id, '');

        if($('#langname option:selected').attr('value')== ""){
            var lang_id = '1';
        }else{
            var lang_id = $('#langname option:selected').attr('value');
        }



 		var formData = {
    	'placereward' : $('#place_reward').val(),
        'amount' : $('#amount').val(),
        'merchant' : merchants_id,
        'lang_id' : lang_id,
 		'_token' : $('input[name=_token]').val(),
        }

        console.log(merchant);
        console.log(merchants_id);
        console.log(my_url);
        console.log(formData);

 		$.ajax({
            type: type,
            url: my_url,
            data: formData,
            dataType: 'json',
            success: function(data) {
                 //location.reload(); 

                 $(".table-responsive").html('');
                 $(".table-responsive").html(data.rewardtable);

                 $(".popedit").html('');
                 $(".popedit").html(data.popedit); 
                
                document.getElementById("place_reward").value = "";
                document.getElementById("amount").value = "";

            },
            error: function (data) {
                console.log('Error:', data);
                //location.reload();
            
            }
        });
 	
 	});

    $('.saveRewardChanges').click(function(event){


        var rew_id = $(this).data('id');
        var type = "post";
        var merchant = pathArray.replace('/edit','');
        var merchants_id = merchant.replace('/system/reward/','');
        var my_url = merchant.replace(merchants_id, '')+rew_id;

        if($('#langname option:selected').attr('value')== ""){
            var lang_id = '1';
        }else{
            var lang_id = $('#langname option:selected').attr('value');
        }


        var formData = {

        'placereward' : $('#edplace_reward_'+rew_id).val(),
        'amount' : $('#edamount_'+rew_id).val(),
        '_token' : $('input[name=_token]').val(),
        'lang_id' : lang_id,
         'merchant' : merchants_id,
        '_method': 'put',
        }

        console.log(my_url);
        console.log(formData);

        $.ajax({
            type: type,
            url: my_url,
            data: formData,
            dataType: 'json',
            success: function(data) {
               // console.log(data);

                $(".table-responsive").html('');
                $(".table-responsive").html(data.rewardtable);

                $(".popedit").html('');
                $(".popedit").html(data.popedit);
                //location.reload(); 
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    
    });

    $('.popedit').on('click', '.saveRewardChanges', function(event) {
        event.preventDefault();

        var rew_id = $(this).data('id');
        var type = "post";
        var merchant = pathArray.replace('/edit','');
        var merchants_id = merchant.replace('/system/reward/','');
        var my_url = merchant.replace(merchants_id, '')+rew_id;


        if($('#langname option:selected').attr('value')== ""){
            var lang_id = '1';
        }else{
            var lang_id = $('#langname option:selected').attr('value');
        }

        var formData = {

        'placereward' : $('#edplace_reward_'+rew_id).val(),
        'amount' : $('#edamount_'+rew_id).val(),
        '_token' : $('input[name=_token]').val(),
        'merchant' : merchants_id,
        'lang_id' : lang_id,
        '_method': 'put',
        }

        console.log(my_url);
        console.log(formData);

        $.ajax({
            type: type,
            url: my_url,
            data: formData,
            dataType: 'json',
            success: function(data) {
                //console.log(data);
                //location.reload(); 
                $(".table-responsive").html('');
                $(".table-responsive").html(data.rewardtable);

                $(".popedit").html('');
                $(".popedit").html(data.popedit);
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

  function countrylang(lang){

        var type = "GET";
        var token = $("input[name='_token']").val();
        var langid = lang.value;
       // var pageid = $('#pageid').val();
        var merchant = $("#merchants_id").val();

        //if(pageid != ""){
            var my_url = "/system/reward/pageslang";   
       // }

        var formData = {
            //'pageid' : pageid,
            'merchant': merchant,
            'lang_id' : langid,
            'token' :  token,
        }
        
        console.log(my_url);
        console.log(formData);
    
        $.ajax({
            type: type,
            url: my_url,
            data: formData,
            dataType: 'json',
            success: function(data) {
               console.log(data);
                
                $(".table-responsive").html('');
                $(".table-responsive").html(data.rewardtable);

                $(".popedit").html('');
                $(".popedit").html(data.popedit); 
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    }