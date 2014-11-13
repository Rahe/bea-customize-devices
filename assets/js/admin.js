(function(){
	'use strict';
	var bea;
	if( !bea ) {
		bea = {};
	} else {
		if( typeof bea !== "object" ) {
			throw new Error( 'bea already exists and not an object' );
		}
	}

	if( !bea.customize ) {
		bea.customize = {};
	} else {
		if( typeof bea.customize !== "object" ) {
			throw new Error( 'fr.customize already exists and not an object' );
		}
	}

	if(_.isEmpty( bea_customize_devices ) || _.isUndefined( bea_customize_devices.sizes ) ) {
		return false;
	}

	bea.customize.template = _.memoize( function ( id ) {
		var compiled,
			options = {
				evaluate:    /<#([\s\S]+?)#>/g,
				interpolate: /\{\{\{([\s\S]+?)\}\}\}/g,
				escape:      /\{\{([^\}]+?)\}\}(?!\})/g,
				variable:    'data'
			};

		return function ( data ) {
			compiled = compiled || _.template( jQuery( '#tmpl-' + id ).html(), null, options );
			return compiled( data );
		};
	});

	bea.customize.Sizes = Backbone.View.extend( {
		sizes :  bea_customize_devices.sizes,
		className : 'bea-customize-devices-sizes',
		tagName : 'ul',
		initialize : function( ) {"use strict";
			this.render();
		},
		render : function( ) {"use strict";
			var self = this;
			_.each( this.sizes, function( size, i ) {
				var model = new bea.customize.SizeModel( size),
				size = new bea.customize.Size( { model : model } );

				self.$el.append( size.render().$el );
			} );

			jQuery('.wp-full-overlay-sidebar-content.accordion-container').prepend( this.$el );
		}
	} );

	bea.customize.Size = Backbone.View.extend( {
		tagName : 'li',
		template : bea.customize.template( 'bea-customize-size' ),
		events : {
			'click a' : 'change_size'
		},
		initialize : function( ) {"use strict";},
		render : function( ) {"use strict";
			this.$el.html( this.template( this.model.toJSON() ) );

			return this;
		},
		change_size : function ( e ) {
			e.preventDefault();
			bea.customize.sizesview.$el.find( 'a' ).removeClass( 'active' );
			this.$el.find( 'a' ).addClass( 'active' );
			jQuery('#customize-preview iframe').width( this.model.get( 'size' ) );
		}
	} );

	bea.customize.SizeModel = Backbone.Model.extend( {
		defaults : {
			title 	: 'Desktop',
			icon 	: 'dashicons-desktop',
			class 	: 'default',
			size 	: '100%'
		}
	} );

	// New view
	bea.customize.sizesview = new bea.customize.Sizes();
})();