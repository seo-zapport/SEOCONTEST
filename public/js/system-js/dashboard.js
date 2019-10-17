/*global $, jQuery, alert*/
/*jslint white: true, browser: true*/

$(document).ready( function () {

	$(document).on('click', '#btn-rr', function(event){
	    var passid = $(this).data('id');
    	var type = "GET";
    	var token = $("input[name='_token']").val();
    	var gresult = passid;
    	var my_url =  window.location.pathname+"/curlresultAjax";

    	var formData = {
    		'gresult': gresult,
    		'token' :  token,
    	}
    	$(".google_result").empty();
    	$(".sk-spinner").show();
	    	$.ajax({
	    	    type: type,
	    	    url: my_url,
	    	    data: formData,
	    	    dataType: 'json',
	    	    success: function(data) {
	    	    if(data.success == true)
	   			{
	   				console.log(data.resulta);
	   			}
	                 $(".google_result").html(data.resulta);
    				 $(".sk-spinner").hide();       	   
	    	    },
	    	    error: function (xhr,textStatus,thrownError,data) {
	    	        console.log(xhr + "\n" + textStatus + "\n" + thrownError);
	                $(".google_result").html('<h3 class="gnotice text-center text-danger" style="margin-top: 15%;"><i class="fa fa-warning"></i>Connection Timeout</h3>');
    				$(".sk-spinner").hide();       	
	    	    	
	    	    }
	    	});


	});
});
                                            

function filterResult(domain){

	var type = "GET";
	var token = $("input[name='_token']").val();
	var domain_id = domain.value;
	var my_url =  window.location.pathname+"/firstGlance";

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
	        $(".first-glance").html('');
            $(".first-glance").html(data.report);

	        $(".rark-report").html('');
            $(".rark-report").html(data.report_google);
	    },
	    error: function (data) {
	        console.log('Error:', data);
	    }
	});
}