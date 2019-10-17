/*global $, jQuery, alert*/
/*jslint white: true, browser: true*/

$(document).ready( function () {
	"use strict";
	$('#btn_general_action').on('click', function () {
		var btn_general_action = $(this).val();
		var _token = $('input[name=_token]').val();
		var site_title = $('input[name=site_title]').val();
		var site_tag_line = $('input[name=site_tag_line]').val();
		var site_display_assets = $('input[name=site_display_assets]').is(':checked');
		var site_url = $('input[name=site_url]').val();

		if ( btn_general_action == "Publish" ) {
			var store_url = base_url + '/system/settings-general/store';
		}else{
			var store_url = base_url + '/system/settings-general/update/1';
		}
		


		var dataSend = '_token=' + _token;
		dataSend += '&btn_general_action=' + btn_general_action;
		dataSend += '&site_title=' + site_title;
		dataSend += '&site_tag_line=' + site_tag_line;
		dataSend += '&site_display_assets=' + site_display_assets;
		dataSend += '&site_url=' + site_url;
		$.ajax({
			headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
			type: 'POST',
			url: store_url,
			data: dataSend,
			cache: false,
			success: function ( res ) {
				Pace.restart();
				if ( res.error ) {
					console.log('display errors');
					$('#box-alert').html('<div class="alert alert-danger"><ul></ul></div>');
					$.each(res.error, function (key,value) {
						$('#box-alert').find('div.alert').append(value);
					});
					if (res.error.site_title) {
						$('#site_title_error').html('<strong>' + res.error.site_title + '</strong>');
						$('#errors-title-wrap').addClass('has-error');
					}
					$( "div.alert" ).fadeIn( 300 ).delay( 1500 ).fadeOut( 700 );
				}else{
					if ( res.status.length > 0 ) {
						var btn_name = 'btn_save';
						var btn_value = 'Publish';

						if ( res.type.length > 0 ) {
						var type_text = 'Updated';
							btn_name = 'btn_update';
							btn_value = 'Update';

							if ( res.type === 'publish' ) {
								type_text = 'Added New';
							}
						}

						$('#box-alert').html('<div class="alert alert-success"><span></span>Successfully ' + type_text + ' Record.</div>');
						$( "div.alert" ).fadeIn( 300 ).delay( 1500 ).fadeOut( 400 );
						$('#site_title_error').html('');
						$('#errors-title-wrap').removeClass('has-error');
						$('#btn_general_action').val( btn_value ).attr('name', btn_name);
					}
				}
			}
		});
	});
});