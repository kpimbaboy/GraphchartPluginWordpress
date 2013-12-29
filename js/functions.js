
jQuery(document).ready(function($) {
	// Autoresize
 !function(a,b){var c=function(a,b,c){var d;return function(){function g(){c||a.apply(e,f),d=null}var e=this,f=arguments;d?clearTimeout(d):c&&a.apply(e,f),d=setTimeout(g,b||100)}};jQuery.fn[b]=function(a){return a?this.bind("resize",c(a)):this.trigger(b)}}(jQuery,"smartresize");

	// definir height et width.
	function squareIt(selector) {
		$(selector).each(function() {
			var current = $(this);
			var thisWidth = current.outerWidth();
			current.css( 'height', thisWidth );
			current.parent().css( 'height', thisWidth );
		});
	}
	// chargement de la classe correspondante
	squareIt('.icps_charts_canvas');

	// application de l'autoresize
	$(window).smartresize(function() {
		squareIt('.icps_charts_canvas');
	});

});