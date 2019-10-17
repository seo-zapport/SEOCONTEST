/*global $, jQuery, alert*/
/*jslint white: true, browser: true*/

//first input code in registration v 0.0.0.01

$(function(){
    "use strict";
    $('#registrationForm').change(function (e) {
      var verified = grecaptcha.getResponse();
      if (verified.length === 0) {
        e.preventDefault();
      }
    });
    $.validator.methods.email = function( value, element ) {
      return this.optional( element ) || /[a-z]+@[a-z]+\.[a-z]+/.test( value );
    }
    $("#registrationForm").validate({
       rules: {
           full_name: {  required: true }, 
           url_permalink: { required: true, url: true },
           mob_no: { required: true, number: true, maxlength: 15  },
           bbm_pin: { required: true, maxlength: 8 },
           acct_no: { required: true, number: true },
           email: { required: true, email:true},
           bank_name: { required: true },
           be_acct: { required: true }
       },
       messages: {
        email: {
          email: 'The Email you entered is not valid'
        },
       },
       wrapper: 'span',
       errorClass: 'text-danger',
       errorElement: 'strong',
    });

    $('input[name=email]').on('change',function(){
      $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        type: 'POST',
        url: "/checkEmail",
        data: { 'email' : $('#email').val(), '_token' : $('input[name=_token]').val() },
        success: function(data) {
          if (data.status.lenght > 0) {
            $('#sample').append('test');
          }
          console.log(data);
        },
        error: function (data) {
          console.log('Error:', data);
          //location.reload();  
        }
      });
    });

    $('#btnRegister').on('click', function(){

      var type = "POST";
      var my_url = "/"; 
     
      // var full_name = $('#full_name').val(),
      // email = $('#email').val(),
      // mob_no = $('#mob_no').val(),
      // bbm_pin = $('#bbm_pin').val(),
      // url_permalink = $('#url_permalink').val(),
      // bank_name = $('#bank_name option:selected').attr('value'),
      // acct_no = $('#acct_no').val(),
      // be_acct = $('#be_acct').val(),  
      // _token = $('input[name=_token]').val();

      // var formData = '';
      // formData = "_token=" + _token;
      // formData += "&full_name=" + full_name;
      // formData += "&email=" + email;
      // formData += "&mob_no=" + mob_no;
      // formData += "&bbm_pin=" + bbm_pin;
      // formData += "&url_permalink=" + url_permalink;
      // formData += "&bank_name=" + bank_name;
      // formData += "&acct_no=" + acct_no;
      // formData += "&be_acct=" + be_acct;
      // formData += "&g_token=" + g_token;

      var g_token = $('textarea[name=g-recaptcha-response]').val();

      var formData = {
      'full_name' : $('#full_name').val(),
      'email' : $('#email').val(),
      'mob_no' : $('#mob_no').val(),
      'bbm_pin' : $('#bbm_pin').val(),
      'url_permalink' : $('#url_permalink').val(),
      'bank_name' : $('#bank_name option:selected').attr('value'),
      'acct_no' : $('#acct_no').val(),
      'be_acct' : $('#be_acct').val(),  
      'merchant' : window.location.origin,
      'g_token' : g_token,
       '_token' : $('input[name=_token]').val(),
      };
     
      console.log(my_url);
      console.log(formData);

       $.ajax({
          //headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          type: 'POST',
          url: my_url,
          data: formData,
          dataType: 'json',
          cache: false,
          success: function(data) {
            console.log(data);
            location.reload();
          },
          error: function (data) {
            console.log('Error:', data);
            location.reload();  
          }
        });

    });
 });

function onloadCallback() {
  $('#btnRegister').show();
  var timesRun = 0;
  var interval = setInterval(function(){
    timesRun += 1;
    if (timesRun === 1 ) {
       $('#btnWrap').html('');
       $('#btnRegister').hide();
      grecaptcha.reset();
      clearInterval(interval);
    }
  }, 60000);
};

