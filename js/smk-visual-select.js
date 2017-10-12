/**
 * SMK Visual Select jQuery Plugin v1.0
 * ----------------------------------------------------
 * Author: Smartik
 * Author URL: http://smartik.ws/
 * License: MIT
 */
;(function ( $ ) {

	"use strict";

	$.fn.smk_VisualSelect = function( options ) {
		
		if (this.length > 1){
			this.each(function() { 
				$(this).smk_VisualSelect(options);
			});
			return this;
		}
		
		// Defaults
		var settings = $.extend({}, options );
		var plugin   = this;

		this.isset = function( str ){
			return typeof str != 'undefined' ? true : false;
		}

		//"Constructor"
		var init = function() {
			plugin.prepareHtml();
			plugin.createStructure();
			plugin.proceedOnClick();
		}

		// Prepare HTML
		this.prepareHtml = function() {
			plugin.addClass('visual-select');
			plugin.html( '<div class="native">' + plugin.getTheHtml() + '</div>' );
			plugin.append('<div class="choice"></div>');
			plugin.find('.native').hide();
		}

		//Make the structure
		this.createStructure = function() {
			plugin.getInputs().each( function(){
				var it     = $(this),
				    val    = it.attr('value'),
				    label  = it.data('label'),
				    active = it.is(':checked') ? ' active' : '';

				plugin.find('.choice').append( '<span class="handle'+ active +'" data-value="'+ val +'">'+ label +'</span>' );
			});
		}

		// Get the inner HTML
		this.getTheHtml = function() {
			if( plugin.children('.native').length < 1 ){
				return plugin.html();
			}
		}

		// Get the inputs
		this.getInputs = function() {
			return plugin.find('input');
		}

		// Check it
		this.checkIt = function( value ) {
			var block = plugin.find('.native');
			block.find('input').removeAttr('checked');
			block.find('input[value="'+ value +'"]').attr('checked', 'checked').change();
		}

		// Make active
		this.makeActive = function( current ) {
			plugin.find('.choice .handle').removeClass('active');
			$( current ).addClass('active');
		}

		// Proceed on click
		this.proceedOnClick = function(){
			plugin.on('click', '.handle', function(){
				plugin.checkIt( $(this).data('value') );
				plugin.makeActive( this );
			})
		}

		//"Constructor" init
		init();
		return this;

	};


}( jQuery ));