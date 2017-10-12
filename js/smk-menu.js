/**
 * SMK Menu jQuery Plugin v1.0
 * 
 * -------------------------------------------------------------------------------------
 * Author: Smartik
 * Author URI: http://smartik.ws/
 * Copyright: (c) 2014 Smartik. All rights reserved
 * -------------------------------------------------------------------------------------
 *
 */
;(function( $ ) {

	"use strict";

	$.fn.smk_Menu = function( options ) {
		
		/* Bind each element
		------------------------------------------------*/
		if (this.length > 1){
			this.each(function() { 
				$(this).smk_Menu( options );
			});
			return this;
		}
		
		/* Defaults
		------------------------------------------------*/
		var opt = $.extend({
			breakpoint:  768,
			breakpointText: '<i class="the-breakpoint-handle-icon fa fa-navicon"></i>',
			subMenuPointerForwardText: '<i class="the-sub-menu-pointer-icon fa fa-chevron-right"></i>',
			subMenuPointerBackText: '<i class="the-sub-menu-pointer-icon fa fa-chevron-left"></i>',
			subMenuMarkText: '+',
			hoverIntentSpeed: 500,
			responsive: true
		}, options );

		/* This object
		------------------------------------------------*/
		var obj = this;

		/* Variables
		------------------------------------------------*/
		var isResponsive = false,
		    hoverIntentTimer;

		/* Utilities
		------------------------------------------------*/
		var util = {

			// Check if the value is set
			isset: function( str ){
				return typeof str != 'undefined' ? true : false;
			},

			// If is set use data, else set it
			setData: function( option, data_attr ){
				return util.isset( obj.data(data_attr) ) ? obj.data(data_attr) : option;
			},

		};

		/* Search for data-* attr and replace defaults if exists
		------------------------------------------------*/
		opt.breakpoint = util.setData( opt.breakpoint, 'breakpoint');
	
		/* "Constructor"
		------------------------------------------------*/
		var init = function() {
			obj.makeItResponsive();
			obj.onWindowResize();
			obj.activateMenuOnClick();
			obj.subMenuPointer();
			obj.menuHoverIntent();
			obj.markSubMenus();
		};

		/* Mark all list items that has a submenu
		------------------------------------------------*/
		this.markSubMenus = function(){
			if( opt.subMenuMarkText ){
				obj.find('.sub-menu').parent().children('a').append( ' <span class="sub-menu-mark">'+  opt.subMenuMarkText +'</span>' );
			}
		};

		/* When user hover the menu item
		------------------------------------------------*/
		this.menuHoverIntent = function(){
			if( ! isResponsive ){
				$( obj.find('li') ).on({
					'mouseenter': function () {
						clearTimeout(hoverIntentTimer);
						$(this).find('.sub-menu').removeClass('hovv');
					},
					'mouseover': function () {
						clearTimeout(hoverIntentTimer);
						$( $(this).parents('ul').children('li') ).children('.sub-menu').removeClass('hovv');
						$(this).children('.sub-menu').addClass('hovv');
					},
					'mouseout' : function () {
						clearTimeout(hoverIntentTimer);
						var the_submenu = $(this).find('.sub-menu');
						hoverIntentTimer = setTimeout(function () {
							the_submenu.removeClass('hovv');
						}, opt.hoverIntentSpeed );
					}
				});
			}
			else{
			}
		};

		/* Do Breakpoint
		------------------------------------------------*/
		this.doBreakpoint = function(){
			obj.addClass('breakpoint');
		};

		/* Remove Breakpoint
		------------------------------------------------*/
		this.removeBreakpoint = function(){
			obj.removeClass('breakpoint');
		};

		/* Add breakpoint handle
		------------------------------------------------*/
		this.addBreakpointHandle = function(){
			if( obj.hasClass('breakpoint') ){
				if( obj.find('.breakpoint-handle').length < 1 ){
					obj.prepend('<span class="breakpoint-handle">'+ opt.breakpointText +'</span>');
				}
			}
		};

		/* Remove breakpoint handle
		------------------------------------------------*/
		this.removeBreakpointHandle = function(){
			obj.find('.breakpoint-handle').remove();
		};

		/* Show the responsive menu on click. Activate.
		------------------------------------------------*/
		this.activateMenuOnClick = function(){
			obj.on('click', '.breakpoint-handle', function(event){
		  		event.preventDefault();
				event.stopPropagation();
				if( obj.hasClass('active-menu') ){
					obj.removeClass('active-menu');
					obj.resetAllSubMenuPointers();
				}
				else{
					obj.addClass('active-menu');
				}
				event.stopImmediatePropagation();
			});
		};

		/* Deactivate menu.
		------------------------------------------------*/
		this.deactivateMenu = function(){
			obj.removeClass('active-menu');
			obj.resetAllSubMenuPointers();
		};

		/* Add sub menu pointer
		------------------------------------------------*/
		this.addSubmenuPointer = function(elem){
			var current_li = $(elem);
			if ( current_li.children('.sub-menu').length > 0 ){
				if ( current_li.children('.sub-menu-pointer').length < 1 ){
					current_li.append('<span class="sub-menu-pointer">'+ opt.subMenuPointerForwardText +'</span>');
				}
			}
		};

		/* Remove sub menu pointer
		------------------------------------------------*/
		this.removeSubmenuPointer = function(){
			obj.find('.sub-menu-pointer').remove();
		};

		/* Create sub menu pointer
		------------------------------------------------*/
		this.createSubMenuPointer = function(){
			$( $(this).find('.menu > li') ).each(function(){
				obj.addSubmenuPointer(this);
			});
			$( $(this).find('.menu .sub-menu > li') ).each(function(){
				obj.addSubmenuPointer(this);
			});
		};

		/* Reset this sub menu pointer
		------------------------------------------------*/
		this.resetSubMenuPointer = function(elem){

			var handle  = $(elem);
			var this_li = handle.parent('li');

			// Show all list items, and not this as well
			this_li.parent('ul').find('li').removeClass('inactive-li active-li');

			// Remove all active handles
			this_li.parent('ul').find('.sub-menu-pointer').removeClass('active');
			this_li.parent('ul').find('.sub-menu-pointer').html( opt.subMenuPointerForwardText );
		};

		/* Activate this sub menu pointer
		------------------------------------------------*/
		this.activateSubMenuPointer = function(elem){

			var handle  = $(elem);
			var this_li = handle.parent('li');

			handle.html( opt.subMenuPointerBackText );

			// Hide list items
			this_li.parent('ul').children('li').addClass('inactive-li');

			// Show only this item
			this_li.removeClass('inactive-li').addClass('active-li');

			// Make handle active
			handle.addClass('active');
		};

		/* Reset all sub menu pointers
		------------------------------------------------*/
		this.resetAllSubMenuPointers = function(){
			obj.find('.sub-menu-pointer').removeClass('active').html( opt.subMenuPointerForwardText );
			obj.find('li').removeClass('inactive-li active-li');
		};


		/* Sub menu pointer
		------------------------------------------------*/
		this.subMenuPointer = function(){
			obj.on('click', '.sub-menu-pointer', function(){
		  		event.preventDefault();
				$(this).hasClass('active') ? obj.resetSubMenuPointer( this ) : obj.activateSubMenuPointer( this );
				event.stopImmediatePropagation();
			});
		};

		/* Build responsive elements
		------------------------------------------------*/
		this.buildResponsive = function(){
			obj.doBreakpoint();
			obj.addBreakpointHandle();
			obj.createSubMenuPointer();
		};

		/* Destroy responsive elements
		------------------------------------------------*/
		this.destroyResponsive = function(){
			obj.removeBreakpoint();
			obj.removeBreakpointHandle();
			obj.removeSubmenuPointer();
			obj.deactivateMenu();
		};

		/* Make it responsive
		------------------------------------------------*/
		this.makeItResponsive = function(){
			if( $(window).outerWidth() < opt.breakpoint ){
				if( opt.responsive ){
					if( ! isResponsive ){
						obj.buildResponsive();
					}
					isResponsive = true;
				}
			}
			else{
				obj.destroyResponsive();
				isResponsive = false;
			}
		};

		/* On Window Resize
		------------------------------------------------*/
		this.onWindowResize = function(){
			$(window).resize(function(){
				obj.makeItResponsive();
				$( obj.find('.menu > li') ).unbind('mouseover').unbind('mouseout');
				obj.menuHoverIntent();
			});
		};

		/* "Constructor" init
		------------------------------------------------*/
		init();
		return this;

	};

}( jQuery ));