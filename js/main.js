jQuery(function($) {'use strict';

	// Navigation Scroll
	$(window).scroll(function(event) {
		Scroll();
	});

	$('a').on('click', function() {  
		$('html, body').animate({scrollTop: $(this.hash).offset().top - 5}, 1000);
		return false;
	});

	// User define function
	function Scroll() {
		var contentTop      =   [];
		var contentBottom   =   [];
		var winTop      =   $(window).scrollTop();
		var rangeTop    =   200;
		var rangeBottom =   500;
		$.each( contentTop, function(i){
			if ( winTop > contentTop[i] - rangeTop ){
				$('.navbar-collapse li.scroll')
				.removeClass('active')
				.eq(i).addClass('active');			
			}
		})
	};

	$('#tohash').on('click', function(){
		$('html, body').animate({scrollTop: $(this.hash).offset().top - 5}, 1000);
		return false;
	});

	// accordian
	$('.accordion-toggle').on('click', function(){
		$(this).closest('.panel-group').children().each(function(){
		$(this).find('>.panel-heading').removeClass('active');
		 });

	 	$(this).closest('.panel-heading').toggleClass('active');
	});

	//Slider
	$(document).ready(function() {
		var time = 7; // time in seconds

	 	var $progressBar,
	      $bar, 
	      $elem, 
	      isPause, 
	      tick,
	      percentTime;

	 
	    //Init progressBar where elem is $("#owl-demo")
	    function progressBar(elem){
	      $elem = elem;
	      //build progress bar elements
	      buildProgressBar();
	      //start counting
	      start();
	    }
	 
	    //create div#progressBar and div#bar then append to $(".owl-carousel")
	    function buildProgressBar(){
	      $progressBar = $("<div>",{
	        id:"progressBar"
	      });
	      $bar = $("<div>",{
	        id:"bar"
	      });
	      $progressBar.append($bar).appendTo($elem);
	    }
	 
	    function start() {
	      //reset timer
	      percentTime = 0;
	      isPause = false;
	      //run interval every 0.01 second
	      tick = setInterval(interval, 10);
	    };
	 
	    function interval() {
	      if(isPause === false){
	        percentTime += 1 / time;
	        $bar.css({
	           width: percentTime+"%"
	         });
	        //if percentTime is equal or greater than 100
	        if(percentTime >= 100){
	          //slide to next item 
	          $elem.trigger('owl.next')
	        }
	      }
	    }
	 
	    //pause while dragging 
	    function pauseOnDragging(){
	      isPause = true;
	    }
	 
	    //moved callback
	    function moved(){
	      //clear interval
	      clearTimeout(tick);
	      //start again
	      start();
	    }
	});

	//Initiat WOW JS
	new WOW().init();

	$(document).ready(function() {
		//Animated Progress
		$('.progress-bar').bind('inview', function(event, visible, visiblePartX, visiblePartY) {
			if (visible) {
				$(this).css('width', $(this).data('width') + '%');
				$(this).unbind('inview');
			}
		});

		//Animated Number
		$.fn.animateNumbers = function(stop, commas, duration, ease) {
			return this.each(function() {
				var $this = $(this);
				var start = parseInt($this.text().replace(/,/g, ""));
				commas = (commas === undefined) ? true : commas;
				$({value: start}).animate({value: stop}, {
					duration: duration == undefined ? 1000 : duration,
					easing: ease == undefined ? "swing" : ease,
					step: function() {
						$this.text(Math.floor(this.value));
						if (commas) { $this.text($this.text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")); }
					},
					complete: function() {
						if (parseInt($this.text()) !== stop) {
							$this.text(stop);
							if (commas) { $this.text($this.text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")); }
						}
					}
				});
			});
		};

		$('.animated-number').bind('inview', function(event, visible, visiblePartX, visiblePartY) {
			var $this = $(this);
			if (visible) {
				$this.animateNumbers($this.data('digit'), false, $this.data('duration')); 
				$this.unbind('inview');
			}
		});
	});

	// Question parents form
	var form = $('#question-parents-contact-form');
	form.submit(function(event){
		event.preventDefault();
		var form_status = $('<div class="form_status"></div>');
		$.ajax({
			url: $(this).attr('action'),
			type: "POST",
			data: {
				name: $('input[name="name"]').val(),
				email: $('input[name="email"]').val(),
				subject: $('input[name="subject"]').val(),
				message: $('textarea[name="message"]').val()
			},
			beforeSend: function(){
				$('input[type="text"]').val("");
				$('input[type="email"]').val("");
				$('textarea').val("");
				form.prepend( form_status.html('<p><i class="fa fa-spinner fa-spin"></i> Email is sending...</p>').fadeIn() );
			}
		}).done(function(data){
			form_status.html('<p class="text-success">Thank you for contact us. As early as possible we will contact you</p>').delay(3000).fadeOut();
		});
	});

	// Q&A form
	var form2 = $('#question-contact-form');
	form2.submit(function(event){
		event.preventDefault();
		var form_status = $('<div class="form_status"></div>');
		$.ajax({
			url: $(this).attr('action'),
			type: "POST",
			data: {
				name: $('input[name="name"]').val(),
				email: $('input[name="email"]').val(),
				subject: $('input[name="subject"]').val(),
				message: $('textarea[name="message"]').val()
			},
			beforeSend: function(){
				$('input[type="text"]').val("");
				$('input[type="email"]').val("");
				$('textarea').val("");
				form2.prepend( form_status.html('<p><i class="fa fa-spinner fa-spin"></i> Email is sending...</p>').fadeIn() );
			}
		}).done(function(data){
			form_status.html('<p class="text-success">Thank you for contact us. As early as possible we will contact you</p>').delay(3000).fadeOut();
		});
	});

	// partner form
	var form3 = $('#partner-contact-form');
	form3.submit(function(event){
		event.preventDefault();
		var form_status = $('<div class="form_status"></div>');
		$.ajax({
			url: $(this).attr('action'),
			type: "POST",
			data: {
				name: $('input[name="name"]').val(),
				email: $('input[name="email"]').val(),
				phone: $('input[name="phone"]').val(),
				id: $('input[name="id"]').val(),
				city: $('input[name="city"]').val(),
				state: $('input[name="state"]').val(),
				zip: $('input[name="zip"]').val(),
				company: $('input[name="company"]').val(),
				which: $('textarea[name="which"]').val(),
				description: $('textarea[name="description"]').val(),
				giro: $('input[name="giro"]:checked', '#partner-contact-form').val(),
				comments: $('textarea[name="comments"]').val()
			},
			beforeSend: function(){
				$('input[type="text"]').val("");
				$('input[type="email"]').val("");
				$('input[type="tel"]').val("");
				$('textarea').val("");
				form3.prepend( form_status.html('<p><i class="fa fa-spinner fa-spin"></i> Email is sending...</p>').fadeIn() );
			}
		}).done(function(data){
			form_status.html('<p class="text-success">Thank you for contact us. As early as possible we will contact you</p>').delay(3000).fadeOut();
		});
	});

	$('#subscribe-form').on('submit', function(event) {
		event.preventDefault();
		var form_status = $('<div class="form_status"></div>');
		console.log("Data send: " + $('#subscribe-form input[name="email"]').val());
		$.ajax({
			url: $(this).attr('action'),
			type: 'POST',
			data: {
				email: $('#subscribe-form input[name="email"]').val()
			},
			beforeSend: function(){
				$('#subscribe-form')
					.parents()
					.eq(1)
					.prepend(form_status
					.html('<div class="col-xs-12 col-sm-7 col-sm-offset-5"><p class="text-right text-schooltek">Email is sending...</p></div>')
					.fadeIn() );
			}
		})
		.done(function(data) {
			$('#subscribe-form input[name="email"]').val("");
			console.log("success: " + data);
			form_status
				.html('<div class="col-xs-12 col-sm-7 col-sm-offset-5"><p class="text-right text-schooltek">Thank you for subscribing. You will receive our notifications in your email</p></div>')
				.delay(4000).fadeOut();
		})
		.fail(function() {
			console.log("error");
			form_status.hide();
		})
		.always(function() {
			console.log("complete");
		});
	});


	$('#regulation').on('shown.bs.modal', function () {
	  $('#myInput').focus()
	})

});