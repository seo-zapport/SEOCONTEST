$(document).ready(function() {

    //auto fill 
    var config = {
        '#searchlistname .chosen-select'           : {},
        '#searchlistname .chosen-select-deselect'  : {allow_single_deselect:true},
        '#searchlistname .chosen-select-no-single' : {disable_search_threshold:10},
        '#searchlistname .chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
        '#searchlistname .chosen-select-width'     : {width:"350px"}
        }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }

    $("#formbanner").validate({
         rules: {
            name: {
                 required: true,
                 minlength: 6
             },
             url_win: {
                  required: true,
                  minlength: 6,
                  url: true
              },
              place: {
                   required: true,
                   minlength: 1,
                   maxlength: 2,
                   number: true
               },     
            }
     });   

     $(".alert-success").fadeOut(5000);

    $(document).on('click', '.modalDelete', function(event){
        var passid = $(this).find('#Delid').val();
        $('.modal-title').html('<i class="fa fa-trash"></i> Delete Status');
        $('.for-edit').hide('400');
        $('.for-delete').show('400');
        $('.deleteWin').show('400');
        $('.for-restore').hide('400');
        $('.restoreWin').hide('400');
        $('.for-movetrash').hide('400');
        $('.trashWin').hide('400');
        $('#wins_id').val(passid);
    });
   
    $(document).on('click', '.modalRestore', function(event){
        var passid = $(this).find('#Restoreid').val();
        $('.modal-title').html('<i class="fa fa-refresh"></i> Restore Status');
        $('.for-edit').hide('400');
        $('.for-delete').hide('400');
        $('.deleteWin').hide('400');
        $('.for-restore').show('400');
        $('.restoreWin').show('400');
        $('.for-movetrash').hide('400');
        $('.trashWin').hide('400');
        $('#wins_id').val(passid);
    });

    $(document).on('click', '.modalTrash', function(event){
        var passid = $(this).find('#Trashid').val();
        $('.modal-title').html('<i class="fa fa-trash"></i> Move to Trash');
        $('.for-edit').hide('400');
        $('.for-delete').hide('400');
        $('.deleteWin').hide('400');
        $('.for-restore').hide('400');
        $('.restoreWin').hide('400');
        $('.for-movetrash').show('400');
        $('.trashWin').show('400');
        $('#wins_id').val(passid);
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

     var winnerid = $('#winnerid').val();
        
        if(winnerid == ""){
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
         var lang_id = '2';
     }else{
         var lang_id = $('#langname option:selected').attr('value');
     }

        var formData = {
        
        'name' : $('#name').val(),
        'url_win' : $('#url_win').val(),
        'pop' : $('#pop').val(),
        'place' : $('#place').val(),
        'merchant_id' : merchant,
        'lang_id' : lang_id,
        'status_id' : stat,
        '_token' : $('input[name=_token]').val(),

        }

        console.log(formData);
        console.log(my_url);
        console.log(type);
        console.log(stat);

      $.ajax({
                type: type,
                url: my_url,
                data: formData,
                dataType: 'json',
                success: function(data) {
                    console.log(data);

                    if(data.status=="success"){
                        console.log(data);
                        window.location= '/system/winner/'+data.id+'/edit';  
                    
                    }else if(data.status=="fail"){
                        location.reload();
                    }


                },
                error: function (data) {
                    console.log('Error:', data);
                    location.reload();
                }
            });
    });

   $('.deleteWin').click(function(event){

        var winid = $('#wins_id').val();
        var type = "post"
        var my_url = pathArray

       var formData = {
        'id' :$('#wins_id').val(),
        '_token' : $('input[name=_token]').val(),
        '_method': 'delete',
        }    

        $.ajax({

            type: type,
            url: my_url + '/' + winid,
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
            val.push(my_url.replace('/system/winner/',''));
            
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
    
     $('.btn-movetrashwin').click(function(event){

           var val = [];

           val.push($('#winnerid').val());

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
                 window.location = "/system/winner";  
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
    });

    $('.btn-moveActionWin').click(function(event){

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

    $('#btn-bulkActionWin').click(function(){
    
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

    $('#constest-tab').on('click', '#selectcontestant', function(event){
        //var selectid = $(this).attr("data-id");
        var currentRow=$(this).closest("tr"); 
         $("#name").val( currentRow.find("td:eq(1)").html() );       
         $("#url_win").val( currentRow.find("td:eq(2)").html() );       
         $('#merchantname option[value="http://' + currentRow.find("td:eq(0)").html() +'"]').prop("selected", true);   
         $('#langname option[value="' + currentRow.find("td:eq(3)").data('lagid') +'"]').prop("selected", true);   

         $('#merchantnamefilter option[value=""]').prop("selected", true);   
         $('#searchname option[value=""]').prop("selected", true);   

    });

    $('.contest-list').on('click', '#constest-tab #selectcontestant', function(event){
        //var selectid = $(this).attr("data-id");
        var currentRow=$(this).closest("tr"); 
         $("#name").val( currentRow.find("td:eq(1)").html() );       
         $("#url_win").val( currentRow.find("td:eq(2)").html() );       
         $('#merchantname option[value="http://' + currentRow.find("td:eq(0)").html() +'"]').prop("selected", true);   
         $('#langname option[value="' + currentRow.find("td:eq(3)").data('lagid') +'"]').prop("selected", true);   

         $('#merchantnamefilter option[value=""]').prop("selected", true);   
         $('#searchname option[value=""]').prop("selected", true);   

    });

 });



 function countrylang(lang){

     var type = "GET";
     var token = $("input[name='_token']").val();
     var langid = lang.value;
     var pageid = $('#winnerid').val();

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
        'name' : $('#title_name').val(),
        'url_win' : $('#target_url').val(),
        'pop' : $('#pop').val(),
        'merchant_id' : merchant,
        'lang_id' : langid,
        'status_id' : '9',
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
                 window.location= '/system/winner/'+data.id+'/edit';  
             }else{
                 console.log(data);
             }
         },
         error: function (data) {
             console.log('Error:', data);
         }
     });
 }

 function merchantfilter(merchant) {
    
    var winnerid = $('#winnerid').val();
    var type = "GET";
    var token = $("input[name='_token']").val();
    var domain_id = merchant.value;
    var my_url;

       if(winnerid == ""){
            my_url =  window.location.pathname.replace('/create', '')+"/merchantfilter";
       }else{
            my_url =  window.location.pathname.replace('/'+winnerid+'/edit', '')+"/merchantfilter";    
       }

    var formData = {
        'domain_id': domain_id,
        'token' :  token,
    }

    $.ajax({
        type: type,
        url: my_url,
        data: formData,
        dataType: 'json',
        success: function(data) {
            $(".contest-list").html('');
            $(".contest-list").html(data.contest_list);
            $("#searchlistname").html('');
            $("#searchlistname").html(data.contest_listname);
        
            var config = {
                '#searchlistname .chosen-select'           : {},
                '#searchlistname .chosen-select-deselect'  : {allow_single_deselect:true},
                '#searchlistname .chosen-select-no-single' : {disable_search_threshold:10},
                '#searchlistname .chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                '#searchlistname .chosen-select-width'     : {width:"350px"}
                }
            for (var selector in config) {
                $(selector).chosen(config[selector]);
            }

        },
        error: function (data) {
            console.log('Error:', data.contest_list);
        }
    });

 }


 function searchfilter(search)  {
    
    var winnerid = $('#winnerid').val();
    var type = "GET";
    var token = $("input[name='_token']").val();
    var selectedValue = search.value;
    var merchant = $('#merchantnamefilter option:selected').attr('value');
    var my_url;

    if(winnerid == ""){
         my_url =  window.location.pathname.replace('/create', '')+"/searchname";
    }else{
         my_url =  window.location.pathname.replace('/'+winnerid+'/edit', '')+"/searchname";    
    }


    var formData = {
        'merchant': merchant,
        'search' : selectedValue,
        'token' :  token,
    }

    $.ajax({
        type: type,
        url: my_url,
        data: formData,
        dataType: 'json',
        success: function(data) {
           
            $(".contest-list").html('');
            $(".contest-list").html(data.contest_list);
         
            var config = {
                '#searchlistname .chosen-select'           : {},
                '#searchlistname .chosen-select-deselect'  : {allow_single_deselect:true},
                '#searchlistname .chosen-select-no-single' : {disable_search_threshold:10},
                '#searchlistname .chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                '#searchlistname .chosen-select-width'     : {width:"350px"}
                }
            for (var selector in config) {
                $(selector).chosen(config[selector]);
            }
        },
        error: function (data) {
            console.log('Error:', data.contest_list);
        }
    });
 } 


