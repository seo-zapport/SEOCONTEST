 $(document).ready(function() {
        
        $('.scroll_content').slimscroll({
                    height: '200px'
        })

        var updateOutput = function (e) {
             var list = e.length ? e : $(e.target),output = list.data('output');
             
             var type = "POST";
             var my_url = '/system/menu/Nestable'; 

             var formData = {
             'list' : list.nestable('serialize'),
             '_token' : $('input[name=_token]').val(),
             '_method' : 'POST',
             } 
             
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
         };

         // activate Nestable for list 1
         $('#nestable').nestable({
             group: 1,
       
         }).on('change', updateOutput);

         // output initial serialised data
         //updateOutput($('#nestable').data('output', $('#nestable-output')));
    
         $('.dd a').on('mousedown', function(event) {
             event.preventDefault();
             return false;
         });

        $('.dd form button').on('mousedown', function(event) {
            event.preventDefault();
            return false;
        });

        
         $('.dd').on('mousedown','a',function(event) {
             event.preventDefault();
             return false;
         });

        $('.dd').on('mousedown','form button',function(event) {
            event.preventDefault();
            return false;
        });


        $('.dd').on('mousedown','#EditMenu',function(event) {
            event.preventDefault();
            return false;
        });


        $(document).on('click', '#EditMenu', function(event){
        var passid = $(this).find('#ms_eid').val();
        $('.msid').val(passid);
       
        });



        $('.UpdateMS').click(function(event){

            var menus_id = $('#msid').val();
            var type = "post";
            var my_url = "/system/menu/"+menus_id;
            var tab_stat = 0;

            if($('#tab_status_'+menus_id).is(':checked')) {
                tab_stat = 1 ;
            }else{
                tab_stat = 0 ;                
            }

            if($('#modal_pop_'+menus_id).is(':checked')) {
                pop_mod = 1 ;
            }else{
                pop_mod = 0 ;
            }
            
            var langid =  $('#langname option:selected').attr('value');

            var formData = {
            'id' : $('#msid').val(),
            'action': 'Updatemenu_setup',
            'label' : $('#Label_'+menus_id).val(),
            'link' : $('#Url_'+menus_id).val(),
            'title_attrib' : $('#title_attrib_'+menus_id).val(),
            'tab_status' : tab_stat,
            'pop_mod' : pop_mod,
            'lang_id' : langid,
            'css_class' : $('#css_class_'+menus_id).val(),
            'link_rel' : $('#link_rel_'+menus_id).val(),
            'description' : $('#description_'+menus_id).val(),
            '_token' : $('input[name=_token]').val(),
            '_method': 'put',
            }

            //console.log(my_url);
            //console.log(formData);

            $.ajax({
                type: type,
                url: my_url,
                data: formData,
                dataType: 'json',
                success: function(data) {
                  //console.log(data);
                  //$('#nestable').load(location.href + ' #nestable');
                  $(".dd").html('');
                  $(".dd").html(data.menulist); 

                  $(".msmodal").html('');
                  $(".msmodal").html(data.modal); 
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        
        });


        $('.msmodal').on('click', '.UpdateMS', function(event) {
            event.preventDefault();

            var menus_id = $('#msid').val();
            var type = "post";
            var my_url = "/system/menu/"+menus_id;
            var tab_stat = 0;

            if($('#tab_status_'+menus_id).is(':checked')) {
                tab_stat = 1 ;
            }else{
                tab_stat = 0 ;                
            }

            if($('#modal_pop_'+menus_id).is(':checked')) {
                pop_mod = 1 ;
            }else{
                pop_mod = 0 ;
            }
            
            var langid =  $('#langname option:selected').attr('value');

            var formData = {
            'id' : $('#msid').val(),
            'action': 'Updatemenu_setup',
            'label' : $('#Label_'+menus_id).val(),
            'link' : $('#Url_'+menus_id).val(),
            'title_attrib' : $('#title_attrib_'+menus_id).val(),
            'tab_status' : tab_stat,
            'pop_mod' : pop_mod,
            'css_class' : $('#css_class_'+menus_id).val(),
            'link_rel' : $('#link_rel_'+menus_id).val(),
            'lang_id' : langid,
            'description' : $('#description_'+menus_id).val(),
            '_token' : $('input[name=_token]').val(),
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
                    //$('#nestable').load(location.href + ' #nestable');
                  $(".dd").html('');
                  $(".dd").html(data.menulist); 

                  $(".msmodal").html('');
                  $(".msmodal").html(data.modal); 
                    
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });

        });

        $(document).on('click', '#selectgo', function(event){
            if($('#selmenu option:selected').attr('value') !=""){
                  window.location= '/system/menu/'+$('#selmenu option:selected').attr('value')+'/edit';  
              }else{
                 window.location= '/system/menu';     
              }
        });

        $(document).on('click', '#AddMenus', function(event){

            var adddmunelabel = $(this).data('options');

            var val = [];
            var valid = [];

                $('.check-item:checked').each(function(i){
                     val[i] = $(this).val();
                     valid[i] = $(this).data('id');
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })

            var langid =  $('#langname option:selected').attr('value');

            var type = "POST";
            var my_url = "/system/menu"; 

            var formData = {
            'label' :val,
            'label_id' :valid, 
            'url' : adddmunelabel,
            'action':"AddMenu",
            'lang_id' : langid,
            'menu_id' : $('#menu_ids').val(),
            '_token' : $('input[name=_token]').val(),
            } 

            console.log(formData);

           $.ajax({
                type: type,
                url: my_url,
                data: formData,
                dataType: 'json',
                success: function(data) {

                  //$('.msmodal').empty().load(location.href + ' .msmodal'); 
                  //location.reload();
                  $(".dd").html('');
                  $(".dd").html(data.menulist); 

                  $(".msmodal").html('');
                  $(".msmodal").html(data.modal); 
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });

        });


         $(document).on('click', '#AddCustomMenus', function(event){

           $.ajaxSetup({
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
               }
           })

           var langid =  $('#langname option:selected').attr('value');


           var type = "POST";
           var my_url = "/system/menu"; 
           var formData = {
           'label' :$('#url_title').val(),
           'link' :$('#add_url').val(), 
           'lang_id' : langid,
           'stat' :'2', 
           'action':"AddCustomMenu",
           'menu_id' : $('#menu_ids').val(),
           '_token' : $('input[name=_token]').val(),
           } 

           console.log(formData);

           $.ajax({
               type: type,
               url: my_url,
               data: formData,
               dataType: 'json',
               success: function(data) {
                 //location.reload();  
                    $(".dd").html('');
                    $(".dd").html(data.menulist); 

                    $(".msmodal").html('');
                    $(".msmodal").html(data.modal); 

                    document.getElementById("url_title").value = "";
                    document.getElementById("add_url").value = "";
 
               },
               error: function (data) {
                   console.log('Error:', data);
               }
           });

        });

      $(document).on('click', '#AddNewMenu', function(event){

         $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
             }
         })

         if ($('#selbrand option:selected').attr('value') == ""){
               merchant = window.location.origin;   
         }else{
               merchant = $('#selbrand option:selected').attr('value');
         }

         var type = "post";
         var my_url = '/system/menu'; 
         var formData = {
         'menu_name' :$('#menu_name').val(),
         'action':"Newmenu",
         'merchant' : merchant,
         '_token' : $('input[name=_token]').val(),
         } 

        $.ajax({
             type: type,
             url: my_url,
             data: formData,
             dataType: 'json',
             success: function(data) { 
               window.location= '/system/menu/'+data.id+'/edit';  
             },
             error: function (data) {
                 console.log('Error:', data);
             }
         });


     });

        $(document).on('click', '#CreateMenu', function(event){
           
             var type = "post";
             var my_url = '/system/menu/'+$('#menu_ids').val(); 

            var merchant = "";    
            var primval = "";
            var pri_ft_val = "";
                
             if ($('#selbrand option:selected').attr('value') == ""){
                   merchant = window.location.origin;   
             }else{
                   merchant = $('#selbrand option:selected').attr('value');
             }


             if ($('.check-item-prim').is(':checked')){
                 primval = 1;   
             }else{
                 primval = 0;
             }

             if ($('.check-item-pri-ft').is(':checked')){
                  pri_ft_val = 1;   
             }else{
                  pri_ft_val = 0;
             }  

             var formData = {
             'menu_name' :$('#menu_name').val(),
             'default_id' :primval,
             'footer_d_id' :pri_ft_val,
             'merchant' : merchant,
             'action':"Updatemenu",
             '_token' : $('input[name=_token]').val(),
             '_method': 'PUT',
             } ;
             
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

        $(document).on('click', '#SaveDefaultMenu', function(event){
           
            var type = "post";
            var my_url = '/system/menu/'+$('#menu_ids').val(); 

            var prim_id_menu = $('#primenu option:selected').attr('value');
            var default_f_menu= $('#ftprimenu option:selected').attr('value');
            
            primval = 1;
            pri_ft_val = 1;

             var formData = {
             'default_id' : primval,
             'footer_d_id' :pri_ft_val,
             'primary_menu_id' :prim_id_menu,
             'footer_menu_id' :default_f_menu,
             'action':"updatedefault",
             '_token' : $('input[name=_token]').val(),
             '_method': 'PUT',
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

        $(document).on('click', '#DeleteMenus', function(event){
           
                var type = "post";
                var my_url = '/system/menu/'+$('#menu_ids').val(); 

                var formData = {
                
                'action':"Deletemenu",
                '_token' : $('input[name=_token]').val(),
                '_method': 'DELETE',
                } 

               $.ajax({
                    type: type,
                    url: my_url,
                    data: formData,
                    dataType: 'json',
                    success: function(data) {
                      window.location= '/system/menu';  
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
        
        var page = pathArray.replace("/edit", '');
        var pageid = page.replace('/system/menu/', '')
        //var merchant = $("#merchants_id").val();
        var merchant = "";

        //if(pageid != ""){
            var my_url = "/system/menu/pageslang";   
       // }

       if ($('#selbrand option:selected').attr('value') === ""){
             merchant = window.location.origin;   
       }else{
             merchant = $('#selbrand option:selected').attr('value');
       }


        var formData = {
            'pageid' : pageid,
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
               //console.log(data);
                
                $(".slimScrollDiv").html('');
                $(".slimScrollDiv").html(data.pagelist);

                $(".dd").html('');
                $(".dd").html(data.menulist); 

                $(".msmodal").html('');
                $(".msmodal").html(data.modal); 

            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    }