/*
	jQuery Plus One plugin v1.0
	Creates and animate a counter that will go up 1 unit on a given event.
	Default event is click over an element with the class .jcpo-plusone, can be
	changed to anything that triggers the function $.counter.plusOne which is
	public.
	Copyright 2013 José Gleiser
	Released under MIT License.
*/
(function($) {

	$.fn.counter = function( options ) {

		var settings = $.extend( {}, $.fn.counter.defaults, options );

		return this.each(function() {
			var $counter = $(this);
			if (0 === $counter.text().replace(/\D/g,"").length) {
				$counter.html('<p>' + settings.val + '</p>');
			}
			settings.countTrigger($counter);
		});

	};

	$.counter = {
		plusOne : function ($counter) {
			var
				n_counter = $counter.text().replace(/\D/g,""),
				num_digits = n_counter.length,
				element = '<p>',
				digits = n_counter.split('');

			for (var i = 0; i < num_digits; i++) {
				element += '<span class="contador-dig-' + i + '">' + digits[i] + '</span>';
			}
			$counter.html(element + '</p>');

			for (var i = num_digits; i >= 1; i--) {
				var
					$digit = $counter.find('.contador-dig-'+(i-1)),
					digit = parseInt($digit.text(),10);
				if (9 === digit) {
					$digit.animate({
						bottom: '-40px',
						}, 200, function(){
							$(this).text('0');
							$(this).animate({
								bottom: '40px',
								},0,function(){
									$(this).animate({
										bottom: '0px',
									}, 200);
							});
					});
				} else {
					$digit.animate({
						bottom: '-40px',
						}, 200, function(){
							var d = parseInt($(this).text(),10);
							$(this).text(++d);
							$(this).animate({
								bottom: '40px',
								},0,function(){
									$(this).animate({
										bottom: '0px',
									}, 200);
							});
					});
					break;
				}
			}
		}
	};

	$.fn.counter.defaults = {
		val: '00000',
		triggerEvent: 'click',
		triggerElement: '.jcpo-plusone',
		countTrigger: function ($counter) {
			$(this.triggerElement).on(this.triggerEvent, function() {
				$.counter.plusOne($counter);
			});
		}
	};

}(jQuery));
