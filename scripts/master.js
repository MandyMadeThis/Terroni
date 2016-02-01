(function($) {
   // jQuery Code here.
	
	/* Global Javascript
	===========================================================================*/
	var windowWidth = $(window).width();
	var windowHeight = $(window).height();
	
	// carousel values
	tlwp.carousel = {};
	tlwp.carousel.ratioCarouselWidth = 2.547;
	tlwp.carousel.ratioCarousel = 1.488;
	tlwp.carousel.ratioMargin = 0.024;
	tlwp.carousel.ratioArrow = 22.75;
	tlwp.carousel.ratioArrowMargin = 5.55;
	tlwp.carousel.perItem = 2;
	
   $('.btn-back-to-top, .navbar-brand').smoothScroll({offset:-100});
	
   $(window).load(function(){
		// fix the init-loader
		$('#init-loader, #init-loader .vertical').width(windowWidth).height(windowHeight);
		$('#init-loader').css('opacity', 1);
		
		fixFontSize();
		
		/* Dropdown Sub-Headers
		================================ */
		var shopHeader = $('.dropdown-shop .dropdown-menu li a');

		if(shopHeader.length > 0) // need to fix
		{
			shopHeader.each(function(){
				// check which menu we are using
				var parent = $(this).closest('ul.nav-header');
				if(parent.attr('id') == 'menu-header-menu') // desktop
				{
					var arr = $(this).find('span.menu-underline').html().split('|');
					var html = (arr.length >=0) ? '<span class="text-top">'+arr[0]+'</span>' : '';
					html += (arr.length >=1) ? '<div class="clearfix"></div><span class="text-bottom">'+arr[1]+'</span>' : '';
					
					$(this).html(html).addClass('two-lines');
				}
				else // mobile
				{
					// we need to break the two lines
					$(this).html($(this).find('span.menu-underline').html().replace('|', ' '));
				} // if
			});
		} // if
		
		/* Location Menu
		================================ */
		var menuContainer = $('.menu-container');
		
		if(menuContainer.length > 0) // add functionality to the menu
		{
			var menuTabs = menuContainer.find('.menu-tabs-container');
			var menuTables = menuContainer.find('.menu-table-container');
			
			menuTabs.find('a').click(function(){
				var self = $(this);
				
				if(!self.hasClass('disabled'))
				{
					menuTabs.find('a').addClass('disabled');
					
					if(!self.hasClass('active')) // new menu
					{
						var tableId = self.data('table-id');
						var curTable = menuTables.find('table.active');
						
						curTable.fadeOut('slow', function(){
							curTable.removeClass('active');
							var newTable = menuTables.find('table#'+tableId);
							
							menuTabs.find('a.active').removeClass('active');
							newTable.addClass('active');
							
							newTable.fadeIn('slow', function(){
								self.addClass('active');
								
								menuTabs.find('a').removeClass('disabled');
							});
						});
					} // if
				} // if
			});
			
			$(document).on('change', '#menu-tab-mobile', function(){
				var tableId = $(this).val();
				
				var curTable = menuTables.find('table.active');
						
				curTable.fadeOut('slow', function(){
					curTable.removeClass('active');
					var newTable = menuTables.find('table#'+tableId);
					newTable.addClass('active');
					
					newTable.fadeIn('slow', function(){
					});
				});
			});
		} // if
		
		/* Section - Location Single
		======================================== */
		var locationSingle = $('div[data-section="location-single"]');
		
		if(locationSingle.length > 0) // need to set the dropdown for terroni
		{
			$(document).on('click', '.dropdown-toggle', function(e){
				e.stopPropagation();
				
				if($(this).attr('href') != '#')
					window.location.href = $(this).attr('href');
			});
			
			// fix the fonts for desktop
			$('header .main-nav-item-location').each(function(){
				
				// set a url for the top nav
				var dropdownToggle = $(this).find('.dropdown-toggle');
				
				if(dropdownToggle.length > 0) // create the link
				{
					//var title = dropdownToggle.attr('title').toLowerCase().replace('|','-');
					dropdownToggle.attr('href', tlwp.url + '/');
				} // if
				
				$(this).find('a').each(function(){
					// check to see if there is a span
					var obj = $(this).clone();
					var cssName = '';
					var caret = (obj.find('span.caret').length > 0);
					
					var arrText = obj.find('span.menu-underline').html().split('|');
					var text = '';
					
					if(arrText.length >= 1) // add text-top
					{
						text += '<span class="text-top">'+arrText[0]+'</span><div class="clearfix"></div>';
						cssName = 'one-line';
					} // if
					
					if(arrText.length == 2) // add text-bottom
					{
						text += '<span class="text-bottom">'+arrText[1]+'</span>';
						cssName = 'two-lines'
					} // if
					
					if(caret)
						text += '<span class="caret"></span>'
						
					$(this).html(text).addClass(cssName);
					
				});
			});
			
			// TODO: Make this into a non-dropdown menu
			// fix the fonts for mobile
			$('ul#menu-primary-mobile .main-nav-item-location').each(function(){
				if($(this).css('display') == 'block')
				{
					var obj = $(this).find('ul.dropdown-menu').clone();
				
					obj.find('li').each(function(){
						var obj = $(this).clone();
						var cssName = '';
						
						obj.find('span.caret').remove();
						obj.find('span.menu-underline').html(obj.find('span.menu-underline').html().replace('|', ' '));
						
						$(this).html(obj.html()).addClass('main-nav-item-sub');
					});
	
					$(this).find('ul.dropdown-menu').remove();
					$(this).after(obj.html());
					$(this).find('.caret').remove();
					$(this).find('a').attr('href', tlwp.url);
				} // if	
			});
		} // if
		
		/* Form - Book An Event
		======================================== */
		var formBook = $('#frmBookAnEvent');
		
		if(formBook.length > 0) // form logic
		{
			formBook.find('#phone').mask("(999) 999-9999? x9999");
			formBook.find('#eventDate').datepicker({ dateFormat : 'yy-mm-dd' });
			
			var errBook = formBook.find('#error-book-an-event');
			var errBookMsg = errBook.find('strong');
			
			// validation code
			formBook.validate({
				onkeyup: false,
				onfocusout: false,
				rules: {
					fullName:
					{
						required: true,
						maxlength: 100
					},
					email:
					{
						required: true,
						email: true,
						maxlength: 200
					},
					phone:
					{
						required: true
					},
					contactTime:
					{
						required: true	
					},
					eventDate:
					{
						required: true
					},
					venue:
					{
						required: true
					},
					guests:
					{
						required: true,
						number: true
					},
					serviceType:
					{
						required: true
					}
				},
				errorLabelContainer: errBookMsg,
				messages:
				{
					fullName:
					{
						required: 'Full Name is required'
					},
					email:
					{
						required: "Email is required",
						email: "Invalid Email. ie: abc@def.com"
					},
					phone:
					{
						required: "Phone is required"
					},
					contactTime:
					{
						required: "Event Time is required"
					},
					eventDate:
					{
						required: "Event Date is required"
					},
					venue:
					{
						required: "Venue is required"
					},
					guests:
					{
						required: "Number of Guests is required"
					},
					serviceType:
					{
						required: "Type of Service is required"
					}
				}
			});
			
			var btnBookSubmit = formBook.find('#btn-book-an-event-submit');
			
			btnBookSubmit.click(function(){
				var self = $(this);
				
				if(!self.hasClass('disabled'))
				{
					self.addClass('disabled');
					var loader = formBook.find('.loader');
					loader.show();
					
					if(formBook.valid()) // submit the form
					{
						errBook.addClass('hideObj');
						formBook.submit(); // check db stuff on post instead
					}
					else // invalid, show the error container
					{
						addFormError(formBook);
						
						errBook.removeClass('hideObj');
						loader.hide();
						self.removeClass('disabled');
					} // if
				} // if
				
				return;
			});
			
		} // if
   });
	
	$(window).resize(function(){
		fixFontSize();
	});
	
	/* Open Table
	==================================== */
	$(window).load(function(){
		var openTableOverlay = $('.reservations');
		
		if(openTableOverlay.length > 0)
		{
			$('#datepicker').datepicker({
				dateFormat : 'dd/mm/yy',
				minDate: 0
			});
			
			$(document).on('click', '.overlay.reservations .close-container a', function(){
				// hide the overlay
				openTableOverlay.animate({'opacity' : 0}, 1000, function(){
					openTableOverlay.hide();
					openTableOverlay.find('.overlayContainer').css('opacity', 0);
				});
			});
			
			$(document).on('click', '.btn-reservations', function(){
				// show the overlay
				openTableOverlay.show().animate({'opacity' : 1}, 500, function(){
					openTableOverlay.find('.overlayContainer').animate({'opacity' : 1}, 500, function(){});
				});
			});
			
			$(document).on('click', '.overlay .field.calendar', function(){
				$('#datepicker').datepicker('show');
			});
			
			$(document).on('click', '#submitOpenTableForm', function(){
				var self = $(this);
				
				if(!self.hasClass('disabled'))
				{
					self.addClass('disabled');
					
					var reservationObj = $('.reservations-stand-alone');
					
					if(reservationObj.length > 0) // set the location value
					{
						var location = $('#Location');
						
						$('#RestaurantID, #rid, #RestaurantReferralID').val(location.val());
					} // if
					
					$('#openTableForm').submit();
				} // if
				
				return;
			});
		} // if
	});
	
	/* Fix Image in Content
	==================================== */
	$('#full-width-content img').each(function(){
		$(this).removeClass().addClass('img-responsive').removeAttr('width').removeAttr('height');
	});
	
	/* Carousel
	==================================== */
	$(document).on('click', '.btn-carousel-arrow', function(){
		var self = $(this);
		
		if(!self.hasClass('disabled'))
		{
			var carouselArrow = $('.btn-carousel-arrow');
			carouselArrow.addClass('disabled');
			var movement = self.data('arrow');
			var carouselInner = self.parent().find('.carousel-inner');
			var newPos = carouselInner.css('left').replace('px', '');

			if(movement == 'left') // prev
				newPos = parseInt(newPos) + parseInt(tlwp.carousel.movement);
			else // next
				newPos = parseInt(newPos) - parseInt(tlwp.carousel.movement);
			
			var active = carouselInner.find('.carousel-item.active');
			var activeIndex = active.index();
			var newIndex = (movement == 'left') ? activeIndex - 1 : activeIndex + 1;
			var newActive = carouselInner.find('.carousel-item').eq(newIndex)
			
			active.removeClass('active');
			newActive.addClass('active');

			// animate
			carouselInner.animate({ 'left' : newPos+'px'}, { duration: 500, queue: false }, function(){});
				
			$('div[data-section="carousel-description"] .inline-block').fadeOut(500, function(){
				$(this).html(newActive.find('.description').html());
				$(this).fadeIn(500, function(){
					// finally, check if there is a go-to so we can set the new index
					var goTo = newActive.data('goto');
					
					if(goTo !== undefined) // set the new active
					{
						newActive.removeClass('active')
						newIndex = parseInt(goTo);
						newActive = carouselInner.find('.carousel-item').eq(newIndex).addClass('active');
						
						// set the new left;
						
						var adjustPos = ((((tlwp.carousel.finalWidth + (tlwp.carousel.finalMargin * tlwp.carousel.perItem)) * newIndex))+tlwp.carousel.finalMargin)-(($(window).width()-tlwp.carousel.finalWidth)/2);
						
						carouselInner.css('left', (0-adjustPos)+'px');
					};
					
					carouselArrow.removeClass('disabled');
				})
			});
		} // if
		
		return;
	});
	
	// change city
	$(document).on('click', '.btn-location-main', function(){
		var self = $(this);
		
		if(!self.hasClass('disabled'))
		{
			var btnLocationMain = $('.btn-location-main');
			btnLocationMain.addClass('disabled');
			
			var curActive = $('.btn-location-main.active');
			var dataKey = $(this).data('key');
			
			var curCarousel = $('.all-carousel-container .carousel-container.active');
			curCarousel.fadeOut({duration:500, queue:false});
			$('.location-links.active').fadeOut({duration:500, queue:false});
			
			setTimeout(function(){
				$('.location-links.active').removeClass('active');
				$('.location-links[data-location="'+dataKey+'"]').addClass('active').find('.btn-location').eq(0).click();
				
				$('.location-links.active').fadeIn({duration:500, queue:false});
				curActive.removeClass('active');
				self.addClass('active');

				btnLocationMain.removeClass('disabled');
			}, 600);
			
			
		} // if
		
		return;
	});
	
	// change carousels within the same location (city)
	$(document).on('click', '.location-links .btn-location', function(){
		var self = $(this);
		
		if(!self.hasClass('disabled'))
		{
			var btnLocation = $('.location-links .btn-location');
			btnLocation.addClass('disabled');
			
			var id = self.data('id');
			
			var allContainer = $('.all-carousel-container');
			var curCarousel = allContainer.find('.carousel-container.active');
			var newCarousel = allContainer.find('.carousel-container[data-post-id="'+id+'"]');
			var newDesc = newCarousel.find('.carousel-item.active').find('.description');
			
			curCarousel.fadeOut(500, function(){
				newCarousel.fadeIn(500, function(){
					
					curCarousel.removeClass('active');
					$(this).addClass('active');
					
					$('.location-links .btn-location.active').removeClass('active');
					self.addClass('active');
					
					btnLocation.removeClass('disabled');
				});
			});
			
			var carouselDesc = $('div[data-section="carousel-description"]');
			
			carouselDesc.fadeOut(500, function(){
				$(this).find('.inline-block').html(newDesc.html());
				$(this).fadeIn(500);
			});
		} // if
		
		return;
	});
	
	// location change on mobile
	$(document).on('change', '.location-main-container select', function(){
		var value = $(this).val();
		
		// change location single dropdown
		var locationSub = $('.location-sub-container');
		var newLocationSub = locationSub.find('select[data-location="'+value+'"]');
		locationSub.find('select.active').removeClass('active');
		newLocationSub.addClass('active');
		
		// change carousel
		var curLocationSingle = newLocationSub.find('option').eq(0);
		$('.all-carousel-container').find('.carousel.slide.active').fadeOut(500, function(){
			$(this).removeClass('active');
			$('#carousel-container-mobile-'+curLocationSingle.val()).fadeIn(500, function(){
				$(this).addClass('active');
				$('div[data-section="carousel-description"] .inline-block').html($(this).find('.item.active .description').html());
			});
		});
	});
	
	// location single change on mobile
	// SORRY FOR THE NON-DRY
	$(document).on('change', '.location-sub-container select', function(){
		var value = $(this).val();
		
		$('.all-carousel-container').find('.carousel.slide.active').fadeOut(500, function(){
			$(this).removeClass('active');
			$('#carousel-container-mobile-'+value).fadeIn(500, function(){
				$(this).addClass('active');
				$('div[data-section="carousel-description"] .inline-block').html($(this).find('.item.active .description').html());
			});
		});
	});
	
	$('.carousel.slide').on('slide.bs.carousel', function (event) {
		var activeItem = $(event.relatedTarget);
		
		var carouselDesc = $('div[data-section="carousel-description"]');
		carouselDesc.fadeOut(500, function(){
			carouselDesc.find('.inline-block').html(activeItem.find('.description').html());
			carouselDesc.fadeIn(500);
		});
	});
	
	/* Blog Landing
	==================================== */
	var blogLanding = $('#blog-landing-container');
	
	if(blogLanding.length > 0) // populate the first article
	{
		blogLanding.find('#blog-landing-header').html(tlwp.blogLanding[0]['header']);
		blogLanding.find('#blog-landing-content').html(tlwp.blogLanding[0]['body']);
		
		$(document).on('click', '#blog-landing-header a', function(){
			$(this).hide();
			$(this).parent().find('.embed-responsive').removeClass('hideObj');
		});
		
		$(document).on('click', '.btn-blog', function(){
			var self = $(this);
			
			if(!(self.hasClass('disabled') || self.hasClass('deactivated')))
			{
				var allBtn = blogLanding.find('.btn-blog');
				
				allBtn.addClass('disabled');
				
				var pos = parseInt(blogLanding.data('pos'));
				var newPos = 0;
				var header = blogLanding.find('#blog-landing-header');
				var content = blogLanding.find('#blog-landing-content');
				var btnPrev = blogLanding.find('.btn-blog.btn-blog-previous');
				var btnNext = blogLanding.find('.btn-blog.btn-blog-next');
				
				// check movement
				newPos =	(self.hasClass('btn-blog-previous'))
							? pos - 1 // prev
							: pos + 1; // next
					
				if(pos < 0) // problems
					newPos = 0;
					
				if(pos > (tlwp.blogLanding.length-1)) // problem
					newPos = (tlwp.blogLanding.length-1);
					
				if(pos != newPos) // let's switch the view
				{
					blogLanding.data('pos', newPos).attr('data-pos', newPos);
					
					header.animate({opacity: 0}, {queue: false, duration: 500});
					content.animate({opacity: 0}, {queue: false, duration: 500});
					
					setTimeout(function(){
						header.html(tlwp.blogLanding[newPos]['header']);
						content.html(tlwp.blogLanding[newPos]['body']);
						
						header.animate({opacity: 1}, {queue: false, duration: 500});
						content.animate({opacity: 1}, {queue: false, duration: 500});
						
						fixStackableSizes();
						
						if(newPos == 0) // hide Prev
						{
							btnPrev.addClass('deactivated');
							btnNext.removeClass('deactivated');
						}
						else if(newPos == (tlwp.blogLanding.length -1)) // hide Next
						{
							btnPrev.removeClass('deactivated');
							btnNext.addClass('deactivated');
						}
						else // hide none
						{
							btnPrev.removeClass('deactivated');
							btnNext.removeClass('deactivated');
						} // if
						
						allBtn.removeClass('disabled');
 					}, 600);
				} // if
			} // if
			
			return;
		});
	} // if
	
	// fixes the stackable sizes
	function fixStackableSizes()
	{
		var ratio = [];
		ratio.two_col = { 'regular' : 1.024, 'thin' : 2.56};
		ratio.one_col = { 'regular' : 5.12 };
		ratio.footer_banner = 5.12;
		ratio.location_header = 2.56;
		
		var blogLanding = $('#blog-landing-container');
		
		if(blogLanding.length > 0)
		{
			// fix the ratio
			var blogHeader = blogLanding.find('#blog-landing-header');
			var blogHeight = ( blogHeader.width() / ratio.location_header );
			blogHeader.height(blogHeight);
			blogHeader.find('a').width(blogHeader.width()).height(blogHeight);
			blogHeader.find('.embed-responsive').width(blogHeader.width()).height(blogHeight);
			
			// vertically fix the arrows
			var blogContent = blogLanding.find('#blog-landing-content');
			blogLanding.find('a.btn-blog').css('marginTop', (blogContent.height()/2)+'px');
		} // if
		
		var footerBanner = $('.footer-banner');
		
		if(footerBanner.length > 0) // need to fix the ratio here
		{
			footerBanner.each(function(){
				var width = $(this).width();
				var height = (width / ratio.footer_banner);
				$(this).find('a').width(width).height(height);
			});
		} // if
		
		var locationHeader = $('.location-header');
		
		if(locationHeader.length > 0) // need to fix the ratio here
		{
			var width = locationHeader.width();
			var height = (width / ratio.location_header);
			locationHeader.height(height);
			
			// next we need to fix the vertical-alignment of the .location-header-content-container
			var locHeaderCont = locationHeader.find('.location-header-content-container');
			var padding = (height - locHeaderCont.height()) / 2;
			locHeaderCont.css('paddingTop', padding+'px');
		} // if
		
		var stackable = $('.container-fluid[data-type="stackable"]');
		
		if(stackable.length > 0) // need to fix widths and heights
		{
			stackable.each(function(){
				$(this).find('.row').each(function(){
					var dataCol = $(this).data('col');

					$(this).find('.stackable-column').each(function(){
						var link = $(this).find('a.stackable');
						var type = link.data('type');
						
						var width = $(this).width();
						var height = (width / ratio[dataCol][type]);
						
						//$(this).width(width).height(height);
						link.width(width).height(height);
					});
				});
			});
		} // if

		var carouselContainer = $('.carousel-container');
		
		if(carouselContainer.length > 0) // carousel logic
		{
			// fix carousel sizes			
			carouselContainer.each(function(){
				var windowWidth = $(window).width();
				tlwp.carousel.finalWidth = windowWidth / tlwp.carousel.ratioCarouselWidth;
				tlwp.carousel.finalHeight = tlwp.carousel.finalWidth / tlwp.carousel.ratioCarousel;
				tlwp.carousel.finalMargin = tlwp.carousel.ratioMargin * windowWidth;
				
				tlwp.carousel.finalArrow = windowWidth / tlwp.carousel.ratioArrow;
				tlwp.carousel.finalArrowMargin = windowWidth / tlwp.carousel.ratioArrowMargin;
				tlwp.carousel.movement = tlwp.carousel.finalWidth+(tlwp.carousel.finalMargin*tlwp.carousel.perItem);
				
				$(this).height(tlwp.carousel.finalHeight);
				
				$(this).find('.carousel-item').width(tlwp.carousel.finalWidth).height(tlwp.carousel.finalHeight);
				$(this).find('img').width(tlwp.carousel.finalWidth).height(tlwp.carousel.finalHeight);
				$(this).find('.carousel-item').css('marginLeft', tlwp.carousel.finalMargin+'px').css('marginRight', tlwp.carousel.finalMargin+'px');
				
				$(this).find('.btn-carousel-arrow').width(tlwp.carousel.finalArrow).height(tlwp.carousel.finalArrow).css('top', ((tlwp.carousel.finalHeight-tlwp.carousel.finalArrow)/2)+'px');
				$(this).find('.btn-carousel-arrow img').width(tlwp.carousel.finalArrow).height(tlwp.carousel.finalArrow);
				$(this).find('.btn-carousel-arrow[data-arrow="left"]').css('left', (tlwp.carousel.finalArrowMargin)+'px');
				$(this).find('.btn-carousel-arrow[data-arrow="right"]').css('right', (tlwp.carousel.finalArrowMargin)+'px');
				
				var adjustPos = ((((tlwp.carousel.finalWidth + (tlwp.carousel.finalMargin * tlwp.carousel.perItem)) * 2))+tlwp.carousel.finalMargin)-((windowWidth-tlwp.carousel.finalWidth)/2);
				$(this).find('.carousel-inner').css('left', (0-adjustPos)+'px');
				
				if($(this).find('.carousel-item.active').length == 0)
					$(this).find('.carousel-item').eq(tlwp.carousel.perItem).addClass('active');
			});
		} // if
		
		// get the active carousel
		var activeCarousel = $('.carousel-container.active');
		if(activeCarousel.find('.carousel-item.active').length > 0)
		{
			var desc = activeCarousel.find('.carousel-item').eq(tlwp.carousel.perItem).find('.description');
			$('div[data-section="carousel-description"]').find('.inline-block').html(desc.html());
		} // if
		
		setTimeout(function(){
			$('#wrapper, footer').animate({ opacity: 1 }, 500, function(){});
		}, 100);
	} // fixStackableSizes
	
	// fix the font size
	function fixFontSize()
	{
		tlwp.fontSize.curWidth = $(window).width();
		
		//if(tlwp.fontSize.curWidth >= tlwp.fontSize.maxWidth) // max out here
		//	tlwp.fontSize.curWidth = tlwp.fontSize.maxWidth;
		
		tlwp.fontSize.curFontSize = Math.floor(tlwp.fontSize.originalFontSize / tlwp.fontSize.originalWidth * tlwp.fontSize.curWidth * 10)/10;
		
		//constrain to min font size of 9px;
		if(tlwp.fontSize.curFontSize < tlwp.fontSize.minFontSize)
			tlwp.fontSize.curFontSize = tlwp.fontSize.minFontSize;
		
		$(document.body).css('fontSize', tlwp.fontSize.curFontSize + 'px');
	} // fixFontSize
	
	// adds error class to control-group for jquery validate usage
	// @param		_form				form to traverse
	function addFormError(_form)
	{
		$(_form).find('input,select').each(function(index){
			if($(this).hasClass('error')) // error
			{
				$(this).closest('.form-group').addClass('error');
				$(this).removeClass('error');
			}
			else // remove the error
			{
				$(this).closest('.form-group').removeClass('error');
			} // if
		});
	} // addFormError
	
	$(window).load(function(){
		fixStackableSizes();
	});
	
	$(window).resize(function(){
		fixStackableSizes();
	});

	/* Desktop Javascript
	===========================================================================*/
	if(windowWidth > 768)
	{
	} // if

	/* Mobile Javascript
	===========================================================================*/
	if(windowWidth <= 768) // mobile view
	{
	} // if	
	
	// close navbar on outside click
	$(document).ready(function () {
		 $(document).click(function (event) {
			  var clickover = $(event.target);
			  var _opened = $(".navbar-collapse").hasClass("in");
			  if (_opened === true && !clickover.hasClass("navbar-toggle")) {
					$("button.navbar-toggle").click();
			  }
		 });
	});
	
	
	/* Twitter-Bootstrap jQuery
	===========================================================================*/
	// create optgroup
	
	$('.btn-modal-close').click(function(){
		$('.modal-wpcf7').modal('hide');
	});
	
	var wp7form = $(document).find('.wpcf7-form');
	//wp7form.addClass('form-horizontal');
	
	if(wp7form.length > 0) // form logic
	{		
		$(window).load(function(){
			// initialize these
			wp7form.find('#phone').mask("(999) 999-9999? x9999");
			wp7form.find('#event-date').datepicker({ dateFormat : 'yy-mm-dd' });
			
			// fix ajax loader
			var loader = wp7form.find('.ajax-loader');
			loader.attr('src', tlwp.uri + '/images/ajax-loader-init.gif');
			
			wp7form.find('select').each(function(){
				var option = $(this).find('option');
				
				if(option.length > 0 && option.eq(0).val().length == 0)
					option.eq(0).html('Select');
			});
			
			// search for parent_ items
			var foundin = $('option:contains("parent_")');
			$.each(foundin, function(value) {
				 var updated = $(this).val().replace("parent_","");
				// find all following elements until endparent
				$(this).nextUntil('option:contains("endparent")')
				.wrapAll('<optgroup label="'+ updated +'"></optgroup');
			});
			// remove placeholder options
			$('option:contains("parent_")').remove();
			$('option:contains("endparent")').remove();

		});
	} // if
})(jQuery);

function bookAnEventThanks()
{
	document.getElementsByClassName('wpcf7-form')[0].style.display = 'none';
	document.getElementById('book-an-event-thanks-container').style.display = 'block';
	location.href='#book-an-event-thanks-container';
}