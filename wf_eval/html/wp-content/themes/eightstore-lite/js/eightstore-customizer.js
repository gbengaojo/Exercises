/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	//header-callto text
	wp.customize( 'callto_text', function( value ) {
		value.bind( function( to ) {
			$( '.header-callto' ).html( to );
		} );
	} );

	//footer copyright text
	wp.customize( 'footer_copyright_text', function( value ) {
		value.bind( function( to ) {
			$( '.footer-copyrt .site-info' ).html( to );
		} );
	} );

	//header text fonts
    wp.customize( 'heading_typography', function( value ) {
		value.bind( function( to ) {
			$( 'h1, h2 , h3 , h4 , h5 , h6' ).css( 'font-family' , to );
		} );
	} );
    
    wp.customize( 'typography_format_h1', function( value ) {
		value.bind( function( to ) {
			$( 'h1' ).css( 'font-size' , to+'px' );
		} );
	} );
    
    wp.customize( 'typography_format_h2', function( value ) {
		value.bind( function( to ) {
			$( 'h2' ).css( 'font-size' , to+'px' );
		} );
	} );
    
    wp.customize( 'typography_format_h3', function( value ) {
		value.bind( function( to ) {
			$( 'h3' ).css( 'font-size' , to+'px' );
		} );
	} );
    
    wp.customize( 'typography_format_h4', function( value ) {
		value.bind( function( to ) {
			$( 'h4' ).css( 'font-size' , to+'px' );
		} );
	} );
    
    wp.customize( 'typography_format_h5', function( value ) {
		value.bind( function( to ) {
			$( 'h5' ).css( 'font-size' , to+'px' );
		} );
	} );
    
    wp.customize( 'typography_format_h6', function( value ) {
		value.bind( function( to ) {
			$( 'h6' ).css( 'font-size' , to+'px' );
		} );
	} );
    
    //color settings
    wp.customize( 'typography_color_h1', function( value ) {
		value.bind( function( to ) {
			$( 'h1' ).css( 'color' , to );
		} );
	} );
    
    wp.customize( 'typography_color_h2', function( value ) {
		value.bind( function( to ) {
			$( 'h2' ).css( 'color' , to );
		} );
	} );
    
    wp.customize( 'typography_color_h3', function( value ) {
		value.bind( function( to ) {
			$( 'h3' ).css( 'color' , to );
		} );
	} );
    
    wp.customize( 'typography_color_h4', function( value ) {
		value.bind( function( to ) {
			$( 'h4' ).css( 'color' , to );
		} );
	} );
    
    wp.customize( 'typography_color_h5', function( value ) {
		value.bind( function( to ) {
			$( 'h5' ).css( 'color' , to );
		} );
	} );
    
    wp.customize( 'typography_color_h6', function( value ) {
		value.bind( function( to ) {
			$( 'h6' ).css( 'color' , to );
		} );
	} );
    
    //body text fonts
    wp.customize( 'body_typography', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).css( 'font-family' , to+'px' );
		} );
	} );
    
    wp.customize( 'typography_size_body', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).css( 'font-size' , to+'px' );
		} );
	} );
    
    wp.customize( 'typography_color_body', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).css( 'color' , to );
		} );
	} );
} )( jQuery );