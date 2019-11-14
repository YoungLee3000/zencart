//Scroll to top Script
"use strict";	
var jq=jQuery.noConflict();jq(function(){jq.fn.scrollToTop=function(){jq(this).hide().removeAttr("href");if(jq(window).scrollTop()!="0"){jq(this).fadeIn("slow")}var a=jq(this);jq(window).scroll(function(){if(jq(window).scrollTop()>"350"){jq(a).fadeIn("slow")}else{jq(a).fadeOut("slow")}});jq(this).click(function(){jq("html, body").animate({scrollTop:0},"slow")})}});jq(function(){jq("#w2b-StoTop").scrollToTop()});	
var $j = jQuery.noConflict();
function debouncer(func, timeout) {
	var timeoutID, timeout = timeout || 500;
	return function() {
		var scope = this,
			args = arguments;
		clearTimeout(timeoutID);
		timeoutID = setTimeout(function() {
			func.apply(scope, Array.prototype.slice.call(args));
		}, timeout);
	}
}

var jq=jQuery.noConflict();jq(function(){jq.fn.scrollToTop=function(){jq(this).hide().removeAttr("href");if(jq(window).scrollTop()!="0"){jq(this).fadeIn("slow")}var a=jq(this);jq(window).scroll(function(){if(jq(window).scrollTop()>"350"){jq(a).fadeIn("slow")}else{jq(a).fadeOut("slow")}});jq(this).click(function(){jq("html, body").animate({scrollTop:0},"slow")})}});jq(function(){jq("#scrollUp").scrollToTop()});var acc=jQuery.noConflict();acc(document).ready(function(){acc(".accordian-content").hide();acc(".accordian-header:first").addClass("active").next().show();acc(".accordian-header").click(function(){if(acc(this).next().is(":hidden")){acc(".accordian-header").removeClass("active").next().slideUp();acc(this).toggleClass("active").next().slideDown()}return false})});

/*Image Hover*/
var $ = jQuery.noConflict();
/*Tooltip*/
$(document).ready(function(){
    $(".product_image a, .custom-block .overlay > a").tooltip({
        placement : 'top'
    });
	$(".wish_link_product_info, .compare_link_product_info, #productPrevNext a").tooltip({
        placement : 'top'
    });
	$(".arrow-down a").tooltip({
        placement : 'left'
    });
	$("header h4 .navNextPrevList a").tooltip({
        placement : 'top'
    });
	$(".product-details-review .smallProductImage a, .attribImg a").tooltip({
        placement : 'top'
    });
	$(".product-details-review .product-review-default h4 a").tooltip({
        placement : 'top'
    });
	$("a.compare_remove, #wishlist .extendedDelete a, .product-details-review .product-review-default p a").tooltip({
        placement : 'top'
    });
	$(".social_bookmarks li, .dFilterClear a, a.clear_all_filters").tooltip({
        placement : 'top'
    });
});

$('.breadcrumb li:first').addClass('home-link');
$('.breadcrumb li:first a').addClass('icon icon-home');
$('.breadcrumb li:last').addClass('active');
$('input[type="text"], input[type="password"], input[type="email"], input[type="tel"], textarea, input#state').not('.subscribe-box input[type="email"]').addClass('form-control');
$('select').addClass('select--ys form-control');
$('#bestsellers').addClass('coll-products-js');
$('.leftBoxContainer > .sideBoxContent').addClass('collapse-block__content').removeClass('centeredContent');
$('.rightBoxContainer > .sideBoxContent').addClass('collapse-block__content').removeClass('centeredContent');
$('.sideBoxContent ul').not('#categoriescss .sideBoxInnerContent ul').addClass('simple-list');
$('#wishlist .buttons > a, .product-info .cartAdd > a, .product__inside__info__btns > a').addClass('btn btn--ys');
$('#off-canvas-menu .expander-list li ul').addClass('multicolumn-level');
/* mailchip change structure */
if($('#mc_embed_signup').length>0){
var mc_embed_input=$('#mc_embed_signup input#mc-embedded-subscribe');
mc_embed_input.parents("div.clear").hide();
$('#mc_embed_signup').find("form").addClass("form-inline text-left");
$('#mc_embed_signup div.clear').before('<button type="submit" name="'+mc_embed_input.attr("name")+'" id="'+mc_embed_input.attr("id")+'" class="btn btn--ys btn--xl">'+mc_embed_input.attr("value")+'</button>');
}
/*EOF mailchip change structure */
//$('#off-canvas-menu .expander-list li.level*').addClass('dropdown-menu megamenu image-links-layout');
/*Menu JS*/
$(document).ready(function() {
    $('a.moduleBox').click(function() { // show selected module(s)
    // variables
      var popID = $(this).attr('rel');
      var popNAV = $(this).attr('class');
    // clear out menu styles and apply active
      $('a.moduleBox').css('background', '');
      $(this).css('background', '');
    // hide all wrappers and display the one selected
      $('.centerBoxWrapper').hide();
      // check if all or single selection
      if (popID != 'viewAll') {
        $('#' + popID).show();
      } else {
       $('.centerBoxWrapper').show();
      }
    });
	$('a.navOne').click(function() {
		$('a.navOne').addClass('active');
		$('a.navTwo').removeClass('active');
		$('a.navThree').removeClass('active');
	});
	$('a.navTwo').click(function() {
		$('a.navOne').removeClass('active');
		$('a.navTwo').addClass('active');
		$('a.navThree').removeClass('active');
	});
	$('a.navThree').click(function() {
		$('a.navOne').removeClass('active');
		$('a.navTwo').removeClass('active');
		$('a.navThree').addClass('active');
	});
	
});
  
$(window).bind("load", function () {
	$('#status').fadeOut(); // will first fade out the loading animation
	$('#preloader').delay(1000).fadeOut('slow'); // will fade out the white DIV that covers the website.
	//$('body').delay(1000).css({'overflow-x': 'hidden'}).css({'overflow-y': 'auto'});
	//checkContactForm();
});
  
// Cart	
function cartSlideIni(){
	if ($j("header .cart").length > 0) {
		$j('body').on('click','header .cart .dropdown-toggle', function(e){
			$j("header .cart .dropdown").toggleClass('open');
			headerCartSize();
			e.preventDefault();
		});
		 $j('body').on('click','header .cart .cart__close', function(e){
			$j("header .cart .dropdown").toggleClass('open');
			e.preventDefault();
		});						
	}
}
	
var $cart = $j(".cart");
$j(window).resize(headerCartSize);
function headerCartSize() {
  if ($cart.length) {
	$cart.find(".dropdown-menu").scrollTop(0)
	cartHeight();
  }
}

function cartHeight(){
	var $obj = $cart.find(".dropdown-menu");
	var w_height = window.innerHeight;
	var o_height = $obj.outerHeight();
	var delta = parseInt(w_height - o_height);
	if(delta < 0) {
		$obj.css({"max-height": o_height + delta, "overflow": "auto", "overflow-x": "hidden" });
	}
}

function changeInputNameCartPage() {
  var name= "updates[]";
  if ($j(window).width() > 767) {
	$j(".input-mobile").attr("name", "");
	$j(".input-desktop").attr("name", name);
  }
  else {
	$j(".input-mobile").attr("name", name);
	$j(".input-desktop").attr("name", "");
  }
}

if ($j(".input-mobile").length && $j(".input-desktop").length ) {
  changeInputNameCartPage();
  $j(window).resize(changeInputNameCartPage);
}	
	
/*Toggle Search*/
if($('.search-button').length>0){
	$('.search-button').click(function (e) {
	  e.preventDefault();
	  var fld = $(this).find('+ .field');
	  fld.addClass('open');
	});

	$('html').click(function () {
	  $('.search-holder .field').removeClass('open');
	});
	
	$('.search-holder').click(function (event) {
	  event.stopPropagation();
	});
}
		
$('[data-placeholder]').focus(function () {
  var input = $(this);
  if (input.val() == input.attr('data-placeholder')) {
	input.val('');
  }
}).blur(function () {
  var input = $(this);
  if (input.val() == '' || input.val() == input.attr('data-placeholder')) {
	input.addClass('placeholder');
	input.val(input.attr('data-placeholder'));
  }
}).blur();
	
$('[data-placeholder]').parents('form').submit(function () {
  $(this).find('[data-placeholder]').each(function () {
	var input = $(this);
	if (input.val() == input.attr('data-placeholder')) {
	  input.val('');
	}
  });
});
var accordian1=$('#accordion-1').not(".two-columns-home #accordion-1");
if(accordian1.length > 0){
	accordian1.dcAccordion({
		eventType: 'click',
		autoClose: true,
		saveState: true,
		disableLink: true,
		speed: 'slow',
		showCount: false,
		autoExpand: true,
		//cookie	: 'dcjq-accordion-1',
		classExpand	 : 'dcjq-current-parent'
	});
}
jQuery(function($) {
	if ($j("#off-canvas-menu").length > 0) {
		"use strict";
		$j(document).bind('cbox_open', function() {
			$j('html').css({
				overflow: 'hidden'
			});
		}).bind('cbox_closed', function() {
			$j('html').css({
				overflow: ''
			});
		});

		// check if RTL mode
		var colorBoxMenuPosL = ($j("body").hasClass('rtl')) ? 'none' : '0';
		var colorBoxMenuPosR = ($j("body").hasClass('rtl')) ? '0' : 'none';

		$j("#off-canvas-menu-toggle").colorbox({
			inline: true,
			opacity: 0.55,
			transition: "none",
			arrowKey: false,
			width: "300",
			height: "100%",
			fixed: true,
			className: 'canvas-menu',
			top: 0,
			right: colorBoxMenuPosR,
			left: colorBoxMenuPosL,
			colorBoxCartPos: 0
		})
	}

});

$j(window).resize(function(){
	var $cboxClose = $j("#cboxClose");
	if($cboxClose.length && window.innerWidth > 1024 ) {
		$j("#cboxClose").trigger("click");
	}
})

jQuery(function($j) {
	"use strict";
	$j("#off-canvas-menu .expander-list").find("ul").hide().end().find(" .expander").text("+").end().find(".active").each(function() {
		$j(this).parents("li ").each(function() {
			var $jthis = $j(this),
				$jul = $jthis.find("> ul"),

				$jexpander = $jthis.find("> .name .expander");
			$jul.show();

			$jexpander.html("&minus;")
		})
	}).end().find(" .expander").each(function() {
		var $jthis = $j(this),
			hide = $jthis.text() === "+",
			$jul = $jthis.parent(".name").next("ul"),
			$jname = $jthis.next("a");
		$jthis.click(function() {
			if ($jul.css("display") ==
				"block") $jul.slideUp("slow");
			else $jul.slideDown("slow");
			$j(this).html(hide ? "&minus;" : "+");
			hide = !hide
		})
	})
});

//end mobile
// Product Carousel
function productCarousel(carousel,numberXl,numberLg,numberMd,numberSm,numberXs,numberXxs) {
	var windowW = window.innerWidth || $j(window).width();
	var slidesToShowXl = (numberXl > 0) ? numberXl : 6;
	var slidesToShowLg = (numberLg > 0) ? numberLg : 4;
	var slidesToShowMd = (numberMd > 0) ? numberMd : numberLg;
	var slidesToShowSm = (numberSm > 0) ? numberSm : numberMd;
	var slidesToShowXs = (numberXs > 0) ? numberXs : 2;
	var slidesToShowXxs = (numberXxs > 0) ? numberXxs : 1;
	var carousel = carousel;
	var speed = 500;
	if (carousel.parent().find('.carousel-products__button').length > 0) {

			carousel.slick({
					prevArrow: carousel.parent().find('.carousel-products__button .btn-prev'),
					nextArrow: carousel.parent().find('.carousel-products__button .btn-next'),
					dots: true,
					slidesToShow: slidesToShowXl,
					slidesToScroll: slidesToShowXl,
					responsive: [{
						breakpoint: 1770,
						settings: {
							slidesToShow: slidesToShowLg,
							slidesToScroll: slidesToShowLg
						}
					},{
						breakpoint: 1200,
						settings: {
							slidesToShow: slidesToShowMd,
							slidesToScroll: slidesToShowMd
						}
					}, {
						breakpoint: 992,
						settings: {
							slidesToShow: slidesToShowSm,
							slidesToScroll: slidesToShowSm
						}
					}, {
						breakpoint: 768,
						settings: {
							slidesToShow: slidesToShowXs,
							slidesToScroll: slidesToShowXs
						}
					}, {
						breakpoint: 480,
						settings: {
							slidesToShow: slidesToShowXxs,
							slidesToScroll: slidesToShowXxs
						}
					}]
				});
		}
		else {
			carousel.slick({
				slidesToShow: slidesToShowXl,
				slidesToScroll: 1,
				speed: speed,
					responsive: [{
						breakpoint: 1770,
						settings: {
							slidesToShow: slidesToShowLg,
							slidesToScroll: slidesToShowLg
						}
					},{
						breakpoint: 1200,
						settings: {
							slidesToShow: slidesToShowMd,
							slidesToScroll: slidesToShowMd
						}
					}, {
						breakpoint: 992,
						settings: {
							slidesToShow: slidesToShowSm,
							slidesToScroll: slidesToShowSm
						}
					}, {
						breakpoint: 768,
						settings: {
							slidesToShow: slidesToShowXs,
							slidesToScroll: slidesToShowXs
						}
					}, {
						breakpoint: 480,
						settings: {
							slidesToShow: slidesToShowXxs,
							slidesToScroll: slidesToShowXxs
						}
					}]
			});
		}
	

	fixCarouselHover(carousel);
};

// Blog carousel		
function blogCarousel(carousel,numberXl,numberLg,numberMd,numberSm,numberXs) {

	var windowW = window.innerWidth || $j(window).width();

	var slidesToShowXl = (numberXl > 0) ? numberXl : 6;
	var slidesToShowLg = (numberLg > 0) ? numberLg : 4;
	var slidesToShowMd = (numberMd > 0) ? numberMd : numberLg;
	var slidesToShowSm = (numberSm > 0) ? numberSm : numberMd;
	var slidesToShowXs = (numberXs > 0) ? numberXs : 1;
	var carousel = carousel;
	var speed = 500;
	if (carousel.parent().find('.carousel-products__button').length > 0) {
		carousel.slick({
				prevArrow: carousel.parent().find('.carousel-products__button .btn-prev'),
				nextArrow: carousel.parent().find('.carousel-products__button .btn-next'),
				dots: false,
				infinite: true,
				slidesToShow: slidesToShowXl,
				slidesToScroll: slidesToShowXl,
				responsive: [{
					breakpoint: 1770,
					settings: {
						slidesToShow: slidesToShowLg,
						slidesToScroll: slidesToShowLg
					}
				},{
					breakpoint: 992,
					settings: {
						slidesToShow: slidesToShowMd,
						slidesToScroll: slidesToShowMd
					}
				}, {
					breakpoint: 768,
					settings: {
						slidesToShow: slidesToShowSm,
						slidesToScroll: slidesToShowSm
					}
				}, {
					breakpoint: 480,
					settings: {
						slidesToShow: slidesToShowXs,
						slidesToScroll: slidesToShowXs
					}
				}]
			});
	}
	else {
		carousel.slick({
			slidesToShow: slidesToShowXl,
			slidesToScroll: 1,
			speed: speed,
				responsive: [{
					breakpoint: 1770,
					settings: {
						slidesToShow: slidesToShowLg,
						slidesToScroll: slidesToShowLg
					}
				},{
					breakpoint: 992,
					settings: {
						slidesToShow: slidesToShowMd,
						slidesToScroll: slidesToShowMd
					}
				}, {
					breakpoint: 768,
					settings: {
						slidesToShow: slidesToShowSm,
						slidesToScroll: slidesToShowSm
					}
				}, {
					breakpoint: 480,
					settings: {
						slidesToShow: slidesToShowXs,
						slidesToScroll: slidesToShowXs
					}
				}]
		});
	}
};
	
// Category carousel	
function bannerCarousel(carousel) {
	carousel.slick({
		infinite: true,
		dots: false,
		slidesToShow: 3,
		slidesToScroll: 3,
		responsive: [{
			breakpoint: 768,
			settings: {
				slidesToShow: 2,
				slidesToScroll: 2
				}
			}, 
			{
			breakpoint: 480,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1
			}
		}]
	});
}
function bannerCarouselBottom(carousel,numberXl,numberLg,numberMd,numberSm,numberXs) {
	var windowW = window.innerWidth || $j(window).width();

	var slidesToShowXl = (numberXl > 0) ? numberXl : 6;
	var slidesToShowLg = (numberLg > 0) ? numberLg : 4;
	var slidesToShowMd = (numberMd > 0) ? numberMd : numberLg;
	var slidesToShowSm = (numberSm > 0) ? numberSm : numberMd;
	var slidesToShowXs = (numberXs > 0) ? numberXs : 1;
	var carousel = carousel;
	
	carousel.slick({
		infinite: true,
		dots: false,
		slidesToShow: slidesToShowXl,
				slidesToScroll: slidesToShowXl,
				responsive: [{
					breakpoint: 1770,
					settings: {
						slidesToShow: slidesToShowLg,
						slidesToScroll: slidesToShowLg
					}
				},{
					breakpoint: 992,
					settings: {
						slidesToShow: slidesToShowMd,
						slidesToScroll: slidesToShowMd
					}
				}, {
					breakpoint: 768,
					settings: {
						slidesToShow: slidesToShowSm,
						slidesToScroll: slidesToShowSm
					}
				}, {
					breakpoint: 480,
					settings: {
						slidesToShow: slidesToShowXs,
						slidesToScroll: slidesToShowXs
					}
				}]
	});
}

function testimonialsAsid(carousel) {
	    carousel.slick({
	        infinite: true,
	        dots: true,
	        arrows: false,
	        slidesToShow: 1,
	        slidesToScroll: 1
	    });
	}
	
// Brands carousel	
function brandsCarousel(carousel) {
	carousel.slick({
		infinite: true,
		dots: false,
		slidesToShow: 10,
		slidesToScroll: 10,
		responsive: [{
			breakpoint: 1770,
			settings: {
				slidesToShow: 6,
				slidesToScroll: 6
				}
			},{
			breakpoint: 1199,
			settings: {
				slidesToShow: 3,
				slidesToScroll: 3
				}
			},{
			breakpoint: 768,
			settings: {
				slidesToShow: 3,
				slidesToScroll: 3
				}
			}, 
			{
			breakpoint: 480,
			settings: {
				slidesToShow: 2,
				slidesToScroll: 2
			}
		}]
	});
}
	
// Product thumbnails carousel
function thumbnailsCarousel(carousel) {
	carousel.slick({
		infinite: false,
		dots: false,
		slidesToShow: 4,
		slidesToScroll: 1,
		responsive: [{
			breakpoint: 1200,
			settings: {
				slidesToShow: 3,
				slidesToScroll: 1
			}
		},{
			breakpoint: 992,
			settings: {
				slidesToShow: 2,
				slidesToScroll: 1
			}
		}]
	});
}
	
// Vertical carousel	
function verticalCarousel(carousel, slidesToShow) {
	var slidesToShow = (slidesToShow > 0) ? slidesToShow : 2;
	carousel.slick({
		infinite: false,
		dots: false,
		slidesToShow: slidesToShow,
		slidesToScroll: slidesToShow,
		vertical: true
	});
}

// Fix z-index problem on carousel hover
function fixCarouselHover(carousel) {
	carousel.find('.slick-slide').bind( "mouseenter mouseleave",
			function( event ){
				$j(this).closest('.slick-slider').toggleClass('hover');
			}
	);			
};

// Elevate Zoom
function elevateZoom() {
		var windowW = window.innerWidth || document.documentElement.clientWidth;
		$j('.product-zoom').imagesLoaded(function() {
		if ($j('.product-zoom').length) {
			   var zoomPosition
				if ( $j('html').css('direction').toLowerCase() == 'rtl' ) {
					zoomPosition = 11;					
				}
				else {
					zoomPosition = 1
				}

			if (windowW > 767) {
				$j('.product-zoom').elevateZoom({
					//zoomWindowHeight: $j('.product-zoom').height(), // if zoom container must be as image height
					zoomWindowWidth: $j('.product-zoom').width()- 60,
					zoomWindowHeight: $j('.product-zoom').width() - 60,
					gallery: "smallGallery",
					galleryActiveClass: 'active',
					zoomWindowPosition	: zoomPosition
				})

			} else {
				$j(".product-zoom").elevateZoom({
					gallery: "smallGallery",
					zoomType: "inner",
					galleryActiveClass: 'active',
					zoomWindowPosition	: zoomPosition
				});
			}
		}
	})
		
	$j('.product-main-image > .product-main-image__zoom ').bind('click', function(){
			galleryObj = [];
			current = 0;
			itemN = 0;
			
		if ($j('#smallGallery').length){
			console.log('1');
			$j('#smallGallery li a').not('.video-link').each(function() {
				if ($j(this).hasClass('active')) {
					current = itemN;
				}
				itemN++;
				var src = $j(this).data('zoom-image'),
					type = 'image';
					image = {};
					image ["src"] = src;
					image ["type"] = type;

				galleryObj.push(image);
			});
		}else {
			console.log('2');
				itemN++;
				var src = $j(this).parent().find('.product-zoom').data('zoom-image'),
					type = 'image';
					image = {};
					image ["src"] = src;
					image ["type"] = type;

				galleryObj.push(image);
		}
		$j.magnificPopup.open({
			items: galleryObj,
			gallery: {
				enabled: true,
			}
		}, current);
	});
	var  prevW = windowW;
	$j(window).resize(debouncer(function(e) {
		var currentW = window.innerWidth || $j(window).width();
		if (currentW != prevW) {
			// start resize events
			$j('.zoomContainer').remove();
			$j('.elevatezoom').removeData('elevateZoom');
			if ($j('.product-zoom').length) {
				if (currentW > 767) {
					$j('.product-zoom').elevateZoom({
						zoomWindowHeight: $j('.product-zoom').height(),
						gallery: "smallGallery"
					})
				} else {
					$j(".product-zoom").elevateZoom({
						gallery: "smallGallery",
						zoomType: "inner"
					});
				}
			}		
			// end resize events		
		}
		prevW = window.innerWidth || $j(window).width();
	}));
}

// menu click go URL
function navbarClick() {
	var windowW = window.innerWidth || $j(window).width();
	// mobile menu off width
	if (windowW > 1025) {
		$j('.navbar .dropdown > a').on('click', function(){
			location.href = this.href;
			return false
		});
	}

};

// Set Product Page Prev-Next Arrows Position at center of the product image 
function setProductArrows() {
	var windowW = window.innerWidth || $j(window).width();
	var setArrowPos = function(windowW) {
		if (windowW > 1199) {
			var imgH = $j('.product-main-image img').height();
			$j('#productPrevNext > a').css({'top': imgH/2 + 'px'});
		}
	}
	setArrowPos(windowW);
	$j(window).resize(debouncer(function(e) {
		var currentW = window.innerWidth || $j(window).width();
		setArrowPos(currentW);
	}))
};

// Set mobile dropdowns width
function setMobileDrop() {
	var windowW = $j('body').innerWidth();
	var setDropsW;
	setDropsW = function(windowW) {
		// mobile menu off width
		if (windowW < 1025) {
			$j('.dropdown-menu--xs-full').each(function() {
				$j(this).css({'width': windowW + 'px'});
			})
		}
		else {
			$j('.dropdown-menu--xs-full').each(function() {
				$j(this).css({'width': ''});
			})
		}
	}
	setDropsW(windowW);
	$j(window).resize(debouncer(function(e) {
		var currentW = $j('body').innerWidth();
		setDropsW(currentW);
	}));
};

// Collapse Block (left column in listing)
function collapseBlock() {
	$j('.collapse-block__content').each(function() {
		if ($j(this).parent('.collapse-block').hasClass('open')){
			$j(this).slideDown(0);
		}
	})
	$j('.collapse-block__title').on('click', function(e) {
		e.preventDefault;
		var speed = 300;
		var thisItem = $j(this).parent(),
			nextLevel = $j(this).next('.collapse-block__content');
		if (thisItem.hasClass('open')){
			thisItem.removeClass('open');
			nextLevel.slideUp(speed);
		}
		else {
			thisItem.addClass('open');
			nextLevel.slideDown(speed);
		}
	})
};

// Set Mobile Carousel Arrows Position at center of the product image 
function setCarouselArrows() {
	var windowW = window.innerWidth || $j(window).width();
	var setArrowPos = function(windowW) {
		if (windowW < 480) {
			if ($j('.carousel-products-mobile.slick-initialized').length || $j('.carousel-products.slick-initialized').length){
				$j('.carousel-products-mobile').each(function() {
					var imgH = $j(this).find('.slick-list .slick-track .slick-slide:first-child img').height();
					$j(this).find('.slick-arrow').css({'top': imgH/2 + 'px'});
				})					
				$j('.carousel-products').each(function() {
					if ($j(this).parent().parent().find('.carousel-products__button').length > 0) {
						var imgH = $j(this).find('.slick-list .slick-track .slick-slide:first-child img').height();
						var titleH = $j(this).parent().parent().find('.title-with-button').height();
						$j(this).parent().parent().find('.carousel-products__button').css({'top': imgH/2 + titleH + 'px'});
					}
				})
			}
		} else {
			$j('.carousel-products').each(function() {
				if ($j(this).parent().parent().find('.carousel-products__button').length > 0) {
					$j(this).parent().parent().find('.carousel-products__button').css({'top': ''});
				}
				else {
					var imgH = $j(this).find('.slick-list .slick-track .slick-slide:first-child img').height();
					$j(this).find('.slick-arrow').css({'top': imgH/2 + 'px'});
				}
			})
		}		
	}
	setArrowPos(windowW);
	$j(window).resize(debouncer(function(e) {
		var currentW = window.innerWidth || $j(window).width();
		setArrowPos(currentW);
	}))
};

// Set mobile dropdowns width

function setMobileDrop() {
	var windowW = $j('body').innerWidth();
	var setDropsW;
	setDropsW = function(windowW) {
	// mobile menu off width
		if (windowW < 1025) {
			$j('.dropdown-menu--xs-full').each(function() {
				$j(this).css({'width': windowW + 'px'});
			})			
		}
		else {
			$j('.dropdown-menu--xs-full').each(function() {
				$j(this).css({'width': ''});
			})	
		}
	}	
	setDropsW(windowW);
	$j(window).resize(debouncer(function(e) {
		var currentW = $j('body').innerWidth();
		setDropsW(currentW);
	}))
};

// DropDown Close
function handlerDropDownClose() {
	$j('.dropdown-menu__close').on('click', function(e) {
		e.preventDefault();
		$j(this).closest('.dropdown.open .dropdown-toggle').dropdown('toggle');
	});	
};
// Product inside carousel
if($j(".nav-tabs > li").length>0){
	$j(".nav-tabs > li").click(function(){
		productInsideCarousel();
	});
}
 function productInsideCarousel() {
  $j(".product__inside__carousel").each(function () {
	var $this = $j(this);
	$this.carousel({
		interval: false
	});
	$this.find('.carousel-control.next').on('click', function() {
		$this.carousel('next');
	});
   $this.find('.carousel-control.prev').on('click', function() {
	$this.carousel('prev');
   });
  });
 };

// Category list collapse
function expanderList() {
	$j('.expander-list .expander').each(function() {
		if ($j(this).parent('li').hasClass('active')){
			$j(this).next('ul').slideDown(0);
			$j(this).parent().addClass('open');
		}
	})
	$j(".expander-list .expander").on('click', function(e) {
		e.preventDefault;
		var speed = 300;
		var thisItem = $j(this).parent(),
			nextLevel = $j(this).next('ul');
		if (thisItem.hasClass('open')){
			thisItem.removeClass('open');
			nextLevel.slideUp(speed);
		}
		else {
			thisItem.addClass('open');
			nextLevel.slideDown(speed);
		}
	})
};

// Search DropDown
function searchDropDown() {
	$j('.search__open').on('click', function(e) {
		e.preventDefault();
		$j(this).parent('.search').addClass('open');
		$j(this).next('#search-dropdown').addClass('open');
		$j('header .badge').addClass('badge--hidden');
	});		
	$j('.search__close').on('click', function(e) {
		e.preventDefault();
		$j(this).closest('.search').removeClass('open');
		$j(this).closest('#search-dropdown').removeClass('open');
		$j('header .badge').removeClass('badge--hidden');
	});	
};

//=========== back-to-top
function backToTop(){
	if($j(".back-to-top").length > 0) {
		$j('.back-to-top').click(function() {
			$j('html, body').animate({scrollTop: 0},500);
			return false;
		  }) 
		$j(window).scroll(function () {
			if ( $j(window).scrollTop() > 500) {$j(".back-to-top").stop(true.false).fadeIn(110)}
			else {$j(".back-to-top").stop(true.false).fadeOut(110)}
		})
	}	
}

//=========== stuck-nav
var HeaderTop = '';
function stuckNav(){
	if ($j(".stuck-nav").length > 0) {
		HeaderTop = $j('.header-layout-02.homepage').length && window.innerWidth > 1024 ? $j('#pageContent').offset().top : $j('.stuck-nav').offset().top;
		$j(window).scroll(function(){
			checkStickyPosition();
			$j('.header-layout-02.homepage').length ? stickNav() : false;
		});
		$j(window).resize(function(){
			HeaderTop = $j('#pageContent').offset().top;
			checkStickyPosition();
			$j('.header-layout-02.homepage').length ? $j( '.stuck-nav' ).length && window.innerWidth <= 1024 ? $j( '.stuck-nav' ).show() : stickNav() : false;
		});
		checkStickyPosition();
	}
}

function checkStickyPosition(){
	$j(window).scrollTop() > HeaderTop ? $j('.stuck-nav').addClass('fixedbar') : $j('.stuck-nav').removeClass('fixedbar');
}

function stickNav() {
	if($j( '.stuck-nav' ).length && window.innerWidth > 1024) {
		$j( window ).scrollTop() > ($j('#header').innerHeight()+$j(".stuck-nav").innerHeight()) ? $j( '.stuck-nav' ).show() : $j( '.stuck-nav' ).hide();
	}
}

//=========== click on cart(header-layout-06)
jQuery(function($j) {
    "use strict";
     if ($j(".header-layout-06 ").length > 0) {
     	 $j(".header-layout-06 .icon-search").click(function() {
	        $j(".header-layout-06 .alignment-extra").toggleClass('width-extra');
	    });
	     $j(".header-layout-06 .icon-close").click(function() {
	        $j(".header-layout-06 .alignment-extra").toggleClass('width-extra');
	    });
     }

});

//=========== click on cart
jQuery(function($j) {
    "use strict";
    $j("header .cart").click(function() {
        $j("#slider").toggleClass('slider-button');
    });
	/*
	if ($j("html.touch").length > 0) {
		 $j(".product .product__inside__image .carousel-inner a").click(function(event) {	       
	        event.preventDefault();
	    });	
	}*/
});

// Image background
jQuery(function($j) {
    "use strict";
	if ($j('.image-bg').length) {
		$j('.image-bg').each(function() {
			var attr = $j(this).attr('data-image');		
			$j(this).css({'background-image': 'url('+attr+')'});
		})
	}
});
	
// Parallax
jQuery(function($j) {
    "use strict";
    if ($j('.content--parallax, .carusel--parallax').length) {
		$j('.content--parallax, .carusel--parallax').each(function() {
			var attr = $j(this).attr('data-image');		
			$j(this).css({'background-image': 'url('+attr+')'}).parallax("50%", 0.01);
		})
	}
});
// bannerAsid carousel	
	
function bannerAsid(carousel) {
	carousel.slick({
		infinite: true,
		dots: true,
		arrows: false,
		slidesToShow: 1,
		slidesToScroll: 1
	});
}

// Mobile footer collapse
function footerCollapse() {
	$j('.mobile-collapse__title').on('click', function(e) {
		e.preventDefault;
		$j(this).parent('.mobile-collapse').toggleClass('open');
	})
};

//=========== click on toggle-menu(icon toggle menu)
jQuery(function($j) {
	"use strict";
	if ($j('.toggle-menu').length) {
		$j(".toggle-menu .icon, .toggle-menu .close").click(function() {
			$j(".toggle-menu .dropdown-menu").fadeToggle(20);
		});
	}
});

// desctop menu(popup)
$j("nav").each(function(){
	if(!$j( this ).hasClass("navbar-vertical")) {
		$j( this ).find(".dropdown").each(function(){
			$j( this ).hover(
				function() {
					var $this = $j( this );
					var $obj = $this.find(".dropdown-menu");
					submenuXposition($obj);
					submenuYposition($obj);
					$j( window ).bind( "scroll", { obj: $obj }, menuScroll);

				}, function() {
					var $this = $j( this );
					$this.find(".dropdown-menu").removeAttr("style");
					$j( window ).unbind( "scroll", menuScroll);
				}
			);
		});
	}
});

function submenuXposition($obj){
	var w_width = window.innerWidth;
	if(typeof $obj.offset() !== 'undefined'){
		var o_position = $obj.offset().left;
		var o_width = $obj.outerWidth();
		var delta = parseInt(w_width - o_position - o_width - 25);

		if(delta < 0) {
			$obj.css("left", delta);
		}
	}
}

function submenuYposition($obj){
	var w_height = window.innerHeight;
	if(typeof $obj.offset() !== 'undefined'){
		var o_position = $j(".stuck-nav").hasClass("fixedbar") ? $obj.position().top : $obj.offset().top;
		var o_height = $obj.outerHeight();
		var delta = parseInt(w_height - o_position - o_height);
		if(delta < 0) {
			$obj.css({"max-height": o_height + delta - 25, "overflow": "auto"});
		}
	}
}

function menuScroll(event) {
	event.data.obj.removeAttr("style");
	submenuXposition(event.data.obj);
	submenuYposition(event.data.obj)
}

if($j(".l9-one-product-js").length) {
	l9rectangle();
	$j(window).resize(l9rectangle);
}

function l9rectangle() {
	var $obj = $j(".l9-one-product-js");
	$obj.find(".row").removeAttr("style");
	setTimeout(function(){
		var w_height = window.innerHeight;
		var y_pos = $obj.offset().top;
		var h_obj = $obj.outerHeight();
		var delta = parseInt(w_height - y_pos - h_obj);
		if(delta > 0) {
			$obj.find(".row").css("padding-bottom", delta);
		}
	}, 100);
}

$j(document).ready(function() {
	"use strict";
	navbarClick();
	setMobileDrop();
	handlerDropDownClose();
	searchDropDown();
	footerCollapse();
	productInsideCarousel();
	expanderList();
	collapseBlock();
	backToTop();
	stuckNav();
	cartSlideIni();
	// Remove Loader
	$j('body').addClass('loaded');
	
	
	var timeout2;
	clearTimeout(timeout2);
	timeout2 = setTimeout(function() {
		// Resize elements	
		setCarouselArrows();
		if ($j('#productPrevNext').length) {
			setProductArrows();	
		}
	}, 2000);
	
	// Listing Gallery
	function initListingGalleryEvent() {
	  $j('.coll-products-js').click(function(){
		$j(this).unbind();
		listingGalleryEventHandler();
	  });
	}
	function listingGalleryEventHandler() {
	  $j('.coll-gallery').empty();
	  $j('.coll-gallery-clone').children().clone().appendTo('.coll-gallery');
	  verticalCarousel($j('.coll-gallery .vertical-carousel-2'),2);
	};
	if($j('.coll-products-js').length) {
	  if($j('.coll-products-js').hasClass('open')) {
		listingGalleryEventHandler();
	  } else {
		initListingGalleryEvent();
	  }
	  $j(window).resize(function(){
		$j('.coll-products-js').unbind();
		initListingGalleryEvent();
		if($j('.coll-products-js').hasClass('open')) {
		  listingGalleryEventHandler();
		}
	  });
	};
})
//tabs content
if($j('.nav-tabs--ys-center').length) {
  initTabsGallery();
  $j('.nav-tabs--ys-center .active a').trigger('click');
  $j(window).resize(function(){
    $j('.nav-tabs--ys-center a').unbind();
    initTabsGallery();
  });

}

 function initTabsGallery(){
    $j('.nav-tabs--ys-center a').each(function(){
      $j(this).click(function(){
        $j(this).unbind();
        var tab = $j(this).attr("href");
        var clone = tab+"-clone";
        $j(tab).empty();
        $j(clone).children().clone().appendTo($j(tab));
        var $obj = $j(tab).find(".carouselTab");
		var tabtwocol=$j("body.two-columns-home");
        $obj.css("visibility", "hidden");
        if($obj.length) {
          setTimeout(function(){
				if(tabtwocol.length>0){
					if($j("body.two-columns-home.fnt-small").length > 0)
						productCarousel($obj,6,4,3,2,1);
					else	
						productCarousel($obj,5,3,3,2,1);
				}else{
					productCarousel($obj,6,4,3,2,1);
				}
            $obj.hide();
            $obj.css("visibility", "visible");
            $obj.fadeIn(500);
          }, 5);
        }
      })
    });
  }

//Eof tabs content

// Subscription popupbox model
function getCookie(c_name) {
    var c_value = document.cookie;
    var c_start = c_value.indexOf(" " + c_name + "=");
    if (c_start == -1) {
        c_start = c_value.indexOf(c_name + "=");
    }
    if (c_start == -1) {
        c_value = null;
    } else {
        c_start = c_value.indexOf("=", c_start) + 1;
        var c_end = c_value.indexOf(";", c_start);
        if (c_end == -1) {
            c_end = c_value.length;
        }
        c_value = unescape(c_value.substring(c_start, c_end));
    }
    return c_value;
}

function setCookie(c_name, value, exdays) {
    var exdate = new Date();
    exdate.setDate(exdate.getDate() + exdays);
    var c_value = escape(value) + ((exdays == null) ? "" : "; expires=" + exdate.toUTCString());
    document.cookie = c_name + "=" + c_value;
}

function close_pop() {
    setCookie('subscribepop', true, 365);
    return false;
}

$(document).ready(function($){
    if (!getCookie('subscribepop')) {
		// show newsletter Modal
		$(function($) {
			"use strict";
			if ($('#newsletterModal').length) {
				var pause = $('#newsletterModal').attr('data-pause');
				setTimeout(function() {
					$('#newsletterModal').modal('show');
				}, pause);
			}
		})
		$('#nomorepopbox').click(function () {
			if($('#nomorepopbox').prop("checked")==true){
				close_pop();
			}
		});
		$('#newsletterModal .close').click(function () {
		   $('#newsletterModal').modal('hide');
		});
    }
});
//EOF Subscription popupbox model

//Set responsive class
$(document).ready(function(){
	var wwidth=$(window).width();
	res_class(wwidth);
});

$(window).resize(function(){
	var wwidth=$(window).width();
	res_class(wwidth);
});

function res_class(wd){
	var rclass='';
	if(wd<=1024){
		if(!$("body").hasClass("rsmenu")){$("body").addClass("rsmenu");}
	}else{
		if($("body").hasClass("rsmenu")){$("body").removeClass("rsmenu");}
	}
	
}
//EOF Set responsive class
//zencart 1.5.5 jquery
$(document).ready(function(){
	if($('nav.pagination li.current.active').length>0 && ($('nav.pagination li.current.active span').length==0) ){ var pcon=$('nav.pagination li.current.active').html(); $('nav.pagination li.current.active').html("<span>"+pcon+"</span>"); }
});
//EOF zencart 1.5.5 jquery
$(document).ready(function(){
	pzen_page_load();
});
function pzen_page_load(){
	if($('input[type="submit"].cssButton').length>0){
		$('input[type="submit"].cssButton').attr("data-btn","btn btn--ys");
	}
}
function checkBootstrapMode(){
	if ($(window).width() < 480){ return 'xxs';}
	else if($(window).width() >= 480 && $(window).width() < 768) { return 'xs'; }
	else if($(window).width() >= 768 && $(window).width() < 992) { return 'sm'; }
	else if ($(window).width() >= 992 && $(window).width() < 1200) { return 'md'; }
	else if ($(window).width() >= 1200 && $(window).width() < 1770) { return 'lg'; }
	else { return 'xl'; }
}
function pzen_prod_list(size){
	//pzen products listing management
	var pzen_cols_ar = [];
	if(jQuery(".product-grid.pzen-prod-list").length > 0){
		jQuery(".product-grid.pzen-prod-list").each(function(index) {
			 pzen_cols_ar["pzen_cols_"+index]=0;
		});
	};
	if(jQuery(".product-grid.pzen-prod-list").length > 0){
		jQuery(".product-grid.pzen-prod-list").each(function( index ) {
				var parthis=jQuery(this);
				var parindex=index;
				var jqdxxs= parthis.data("xxs");
				var jqdxs= parthis.data("xs");
				var jqdsm= parthis.data("sm");
				var jqdmd= parthis.data("md");
				var jqdlg= parthis.data("lg");
				var jqdxl= parthis.data("xl");
				var jqdcols=(parthis.data(size));
				var prodContClass='';
				if(typeof jqdxl != 'undefined'){ prodContClass+= ' pzen-xl-'+jqdxl; }
				if(typeof jqdlg != 'undefined'){ prodContClass+= ' pzen-lg-'+jqdlg; }
				if(typeof jqdmd != 'undefined'){ prodContClass+= ' pzen-md-'+jqdmd; }
				if(typeof jqdsm != 'undefined'){ prodContClass+= ' pzen-sm-'+jqdsm; }
				if(typeof jqdxs != 'undefined'){ prodContClass+= ' pzen-xs-'+jqdxs; }
				if(typeof jqdxxs != 'undefined'){ prodContClass+= ' pzen-xxs-'+jqdxxs; }
				if(prodContClass){ parthis.addClass(prodContClass);}
				if(jqdcols!=pzen_cols_ar["pzen_cols_"+index]){
					pzen_cols_ar["pzen_cols_"+index]=jqdcols;
					if(pzen_cols_ar["pzen_cols_"+index]){
						parthis.children('.clearfix').remove();
						var divs=parthis.children("div");
						divs.each(function(index){
							var chithis=jQuery(this);
							if(index%(pzen_cols_ar["pzen_cols_"+parindex])==0 && index!=0 && pzen_cols_ar["pzen_cols_"+parindex]!=1){
								chithis.before("<div class='clearfix'></div>");
							}
							//chithis.addClass("col-xs-"+jqdxs+" col-sm-"+jqdsm+" col-md-"+jqdmd+" col-lg-"+jqdlg+" col-xl-"+jqdxl);
						});
					}
				}
			});
	}
}
jQuery(document).ready(function(){
	 pzen_prod_list(checkBootstrapMode());
});
jQuery(window).resize(function(){
	 pzen_prod_list(checkBootstrapMode());
});
//pzen products listing management

//pzen quickview
$(document).ready(function() {
	// Support for AJAX loaded modal window.
	$('body').on('click', '[data-toggle="modal"].quickview-action', function(e) {
		e.preventDefault();
		if($('#quickViewModal').length > 0 ){
			$('.modal-backdrop').remove();
			$('#quickViewModal').remove();
		}
		var datatarget=$(this).attr("data-target");
		var dataurl=$(this).attr("data-target-href");
		datatarget.replace('#','');
		if($('#quickViewModal').length > 0 ){
			$("#quickViewModal .product-popup-content").html('<div class="popup-loader" style="width:100%;min-height:400px;float:left;text-align:cener;" ><div id="loader-wrapper"><div id="loader"><div class="dot"></div><div class="dot"></div><div class="dot"></div>		<div class="dot"></div><div class="dot"></div><div class="dot"></div><div class="dot"></div><div class="dot"></div></div></div></div>');
		}
		$.get(dataurl, function(data) {
			if($('#quickViewModal').length > 0 ){
				$("#quickViewModal .product-popup-content").html(data);
				$('#quickViewModal').modal('open');
			}else{
				$('<div class="modal  modal--bg fade"  id="quickViewModal"><div class="modal-dialog white-modal"><div class="modal-content container"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="icon icon-clear"></span></button></div><div class="product-popup"><div class="product-popup-content">' + data + '</div></div></div></div></div>').modal();
			}
		}).success();
	});
});
//eof pzen quickview
if($j('.bannerAsid').length>0){
	bannerAsid($j('.bannerAsid'),1,1,1,1,1);
}
if($j('.bannerCarousel').length>0){
	productCarousel($j('.bannerCarousel'),4,3,3,2,1);
}
//Product Compare
function compareNew(obj, action) {
    $('#compareProducts').load('ajax_compare.php', {'compare_id': obj, 'action': action});
}  
function compareNew(obj, action) {
	var jqno=jQuery.noConflict();
	jqno.ajax({	type: "POST", cache: false, data:{'compare_id': obj, 'com_action': action,'msg':'yes'}, url: "pzen_ajax_compare.php", success: function(msg){   alert(msg); }
	});
}