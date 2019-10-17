jQuery(document).ready(function($) {
	
	$(document).bind("contextmenu", function(e){
		return false;
	});

    //Disable cut copy paste
    $('body').bind('cut copy paste', function (e) {
        e.preventDefault();
    });
   
    //Disable mouse right click
    $("body").on("contextmenu",function(e){
        return false;
    });

	$("img, a").mousedown(function(e){
	     e.preventDefault()
	});

	$(document).keydown(function (event) {
	    if (event.keyCode == 123) { // Prevent F12
	        return false;
	    } else if (event.ctrlKey && event.shiftKey && event.keyCode == 73 || 
	    	(event.ctrlKey && event.shiftKey && event.keyCode == 74) || 
	    	(event.ctrlKey && event.shiftKey && event.keyCode == 67) || 
	    	(event.ctrlKey && event.keyCode == 85) || 
	    	(event.ctrlKey && event.keyCode == 83) ||
	    	(event.ctrlKey && event.keyCode == 80) ||
	    	(event.ctrlKey && event.keyCode == 65)) { // Prevent Ctrl+Shift+I        
	        return false;
	    }
	});
	
});