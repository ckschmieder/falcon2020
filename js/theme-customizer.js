(function( $ ) {
	"use strict";

	// Homepage Hero Section Background Image - Image Control
	wp.customize( 'sk_homepage_settings_background_image', function( value ) {
		value.bind( function( to ) {
			$( '.hero.sec' ).css( 'background-image', 'url( ' + to + ')' );
		} );
	});

	// Homepage Featured Menu Item #1 Background Image - Image Control
	wp.customize( 'j_homepage_featured1_background_image', function( value ) {
		value.bind( function( to ) {
			$( '#menu-homepage li:first-child' ).css( 'background-image', 'url( ' + to + ')' );
		} );
	});
	// Homepage Featured Menu Item #2 Background Image - Image Control
	wp.customize( 'j_homepage_featured2_background_image', function( value ) {
		value.bind( function( to ) {
			$( '#menu-homepage li:nth-child(2)' ).css( 'background-image', 'url( ' + to + ')' );
		} );
	});
	// Homepage Featured Menu Item #3 Background Image - Image Control
	wp.customize( 'j_homepage_featured3_background_image', function( value ) {
		value.bind( function( to ) {
			$( '#menu-homepage li:nth-child(3)' ).css( 'background-image', 'url( ' + to + ')' );
		} );
	});


})( jQuery );