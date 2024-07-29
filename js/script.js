/*jshint jquery:true */

$(document).ready(function($) {
	"use strict";

	/* global google: false */
	/*jshint -W018 */

	/*-------------------------------------------------*/
	/* =  portfolio isotope
	/*-------------------------------------------------*/

	var winDow = $(window);
		// Needed variables
		var $container=$('.iso-call');
		var $filter=$('.filter');

		try{
			$container.imagesLoaded( function(){
				$container.trigger('resize');
				$container.isotope({
					filter:'*',
					layoutMode:'masonry',
					animationOptions:{
						duration:750,
						easing:'linear'
					}
				});

				setTimeout(Resize, 1500);
			});
		} catch(err) {
		}

		winDow.on('resize', function(){
			var selector = $filter.find('a.active').attr('data-filter');

			try {
				$container.isotope({ 
					filter	: selector,
					animationOptions: {
						duration: 750,
						easing	: 'linear',
						queue	: false,
					}
				});
			} catch(err) {
			}
			return false;
		});
		
		// Isotope Filter 
		$filter.find('a').on('click', function(){
			var selector = $(this).attr('data-filter');

			try {
				$container.isotope({ 
					filter	: selector,
					animationOptions: {
						duration: 750,
						easing	: 'linear',
						queue	: false,
					}
				});
			} catch(err) {

			}
			return false;
		});


	var filterItemA	= $('.filter li a');

		filterItemA.on('click', function(){
			var $this = $(this);
			if ( !$this.hasClass('active')) {
				filterItemA.removeClass('active');
				$this.addClass('active');
			}
		});

	/*-------------------------------------------------*/
	/* =  preloader function
	/*-------------------------------------------------*/
	
	$('body').ready(function(){
		var mainDiv = $('#container');
		mainDiv.delay(400).addClass('active');
	});

	/*-------------------------------------------------*/
	/* =  search animate
	/*-------------------------------------------------*/

	var searchButton = $('button.search-icon');

	searchButton.on('click', function(event) {
		event.preventDefault();

		var searchBar = $('.search_bar'),
			$this = $(this);
		if ( !$this.hasClass('opened') ) {
			$this.addClass('opened');
			$this.find('.open-search').fadeOut(0);
			$this.find('.close-search').fadeIn(0);
			searchBar.fadeIn(400);
			searchBar.find("input[type='search']").focus();
		} else {
			$this.removeClass('opened');
			$this.find('.open-search').fadeIn(0);
			$this.find('.close-search').fadeOut(0);
			searchBar.fadeOut(400);
		}
	});

	/*-------------------------------------------------*/
	/* =  nav animate
	/*-------------------------------------------------*/

	var ToogleMenu = $('a.mobile-nav-toggle');

	ToogleMenu.on('click', function(event) {
		event.preventDefault();

		var containerMover = $('#container'),
			mobileMenu = $('.mobile-menu'),
			$this = $(this);
		if ( !$this.hasClass('opened') ) {
			$this.addClass('opened');
			containerMover.addClass('move');
			mobileMenu.addClass('open');
		} else {
			$this.removeClass('opened');
			containerMover.removeClass('move');
			mobileMenu.removeClass('open');
		}
	});

	/*-------------------------------------------------*/
	/* =  toggle course-panel-content
	/*-------------------------------------------------*/

	var panelHeading = $('.course-panel-heading');

	panelHeading.on('click', function() {
		$(this).toggleClass('active');
	});

	/* ---------------------------------------------------------------------- */
	/*	magnific-popup
	/* ---------------------------------------------------------------------- */

	// Example with multiple objects
	function callMagnificpopup() {
		$('.zoom').magnificPopup({
			type: 'image',
			gallery: {
				enabled: true
			}
		});
	}
	
	callMagnificpopup();

	// Example with multiple objects
	$('.preview-button').magnificPopup({
		type: 'iframe'
	});

	/*-------------------------------------------------*/
	/* = skills animate
	/*-------------------------------------------------*/

	var skillBar = $('.skills-box');
	skillBar.appear(function() {

		var animateElement = $(".meter > p");
		animateElement.each(function() {
			$(this)
				.data("origWidth", $(this).width())
				.width(0)
				.animate({
					width: $(this).data("origWidth")
				}, 1200);
		});

	});

	/*-------------------------------------------------*/
	/* =  count increment
	/*-------------------------------------------------*/

	$('.statistic-post').appear(function() {
		$('.timer').countTo({
			speed: 4000,
			refreshInterval: 60,
			formatter: function (value, options) {
				return value.toFixed(options.decimals);
			}
		});
	});

	/*-------------------------------------------------*/
	/* =  comming soon & error height fix
	/*-------------------------------------------------*/

	var dateCount = $('.countdown-item').attr('data-date');

	$('.countdown-item').countdown(dateCount, function(event) {
		var $this = $(this);
		switch(event.type) {
			case "seconds":
			case "minutes":
			case "hours":
			case "days":
			case "daysLeft":
				$this.find('span#'+event.type).html(event.value);
				break;
			case "finished":
				$this.hide();
				break;
		}
	});
	
	/*-------------------------------------------------*/
	/* =  OWL carousell
	/*-------------------------------------------------*/

	var owlWrap = $('.owl-wrapper');

	if (owlWrap.length > 0) {

		if (jQuery().owlCarousel) {
			owlWrap.each(function(){

				var carousel= $(this).find('.owl-carousel'),
					dataNum = $(this).find('.owl-carousel').attr('data-num'),
					dataNum2,
					dataNum3;
				var nav = false;
				if($(this).find('.owl-carousel').attr('data-nav') == 'true'){
					nav = true
				}
				if ( dataNum == 1 ) {
					dataNum2 = 1;
					dataNum3 = 1;
				} else if ( dataNum == 2 ) {
					dataNum2 = 2;
					dataNum3 = dataNum - 1;
				} else {
					dataNum2 = dataNum - 1;
					dataNum3 = dataNum - 2;
				}
				carousel.owlCarousel({
					autoPlay: 5000,
					navigation : nav,
					items : dataNum,
					itemsDesktop : [1199,dataNum2],
					itemsDesktopSmall : [991,dataNum3],
					itemsTablet : [768, dataNum3],
					margin: 10,
					navigationText: ['<i class="fa fa-chevron-left"></i>','<i class="fa fa-chevron-right"></i>'],
				});

			});
		}
	}
	
	/* ---------------------------------------------------------------------- */
	/*	Contact Map
	/* ---------------------------------------------------------------------- */
 	try {
		var fenway = [42.345573,-71.098326]; //Change a map coordinate here!
		var markerPosition = [42.345573,-71.098326]; //Change a map marker here!
		$('#map').gmap3({
				center: fenway,
				zoom: 13,
				scrollwheel: false,
				mapTypeId : google.maps.MapTypeId.ROADMAP
			})
			.marker({
				position: markerPosition,
				icon: 'images/marker.png'
		});
	} catch(error) {

	}

	/* ---------------------------------------------------------------------- */
	/*	Contact Form
	/* ---------------------------------------------------------------------- */


	$('#contact').on('submit',function(e){
		e.preventDefault();
		var message = $('#msg');
		if($(this).hasClass('popup')){
			message = $('#msg2');
		}
		
		if($(this).valid()){
			$.ajax({
				type: "POST",
				url: 'mail/smartprocess.php',
				dataType: 'json',
				cache: false,
				data: $('#contact').serialize(),
				success: function(data) {
	
					if(data.info !== 'error'){
						message.hide().removeClass('alert-success').removeClass('alert-danger').addClass('alert-success').html(data.msg).fadeIn('slow').delay(5000).fadeOut('slow');
						$('#contact').trigger('reset');
					} else {
						message.hide().removeClass('alert-success').removeClass('alert-danger').addClass('alert-danger').html(data.msg).fadeIn('slow').delay(5000).fadeOut('slow');
					}
				}
			});
		}
	})

	$('#contact2').on('submit',function(e){
		e.preventDefault();
		var message = $('#msg2');
		
		
		if($(this).valid()){
			$.ajax({
				type: "POST",
				url: 'mail/smartprocess.php',
				dataType: 'json',
				cache: false,
				data: $('#contact2').serialize(),
				success: function(data) {
	
					if(data.info !== 'error'){
						message.hide().removeClass('alert-success').removeClass('alert-danger').addClass('alert-success').html(data.msg).fadeIn('slow').delay(10000).fadeOut('slow');
						$('#contact2').trigger('reset');
					} else {
						message.hide().removeClass('alert-success').removeClass('alert-danger').addClass('alert-danger').html(data.msg).fadeIn('slow').delay(1000).fadeOut('slow');
					}
				}
			});
		}
	})

	$('.single-course-content .btn').on('click', function(){
		if($(this).hasClass('collapsed')){
			$(this).find('i').first().addClass('fa-minus').removeClass('fa-plus')
		}
		else{
			$(this).find('i').first().addClass('fa-plus').removeClass('fa-minus')
		}
		
		var card = $(this).closest('.card').siblings('.card')
		card.each(function(){
			$(this).find('i').first().addClass('fa-plus').removeClass('fa-minus')
		})
	});

	$('a.facebook').on('click', function (e) {
		e.preventDefault();
		var url = "https://www.facebook.com/sharer/sharer.php?&u="+window.location.href+"&display=popup";
		window.open(url);
	});

	$('a.twitter').on('click', function(e){
		e.preventDefault();
		var url = "https://twitter.com/intent/tweet?&text=Check Out this course by Novatec&url="+window.location.href;
		window.open(url);
	})

	$('a.linkedin').on('click', function(e){
		e.preventDefault();
		var url = "https://www.linkedin.com/sharing/share-offsite/?url="+window.location.href;
		window.open(url);
	})

});

function Resize() {
	$(window).trigger('resize');
}

