function respon() {	
	var hfoot = $('.footer-container').outerHeight(),
		hhead = $('.header-container').outerHeight(),
		hscreen = $(window).outerHeight(),
		wcontainer = $('.footer-container .container').outerWidth(),
		wscreen = $(window).outerWidth();
	
	$('.mm-page').css({marginBottom:-hfoot});
	$('.main-wrap').css({paddingBottom:hfoot});
	$('.spleft').css({paddingLeft:(wscreen-wcontainer)/2+15});	
	$('.spright').css({paddingRight:(wscreen-wcontainer)/2+15});	
	$('.banner .item').css({height:hscreen, paddingTop:hhead});
	$('.bn-inner .caption').css({paddingTop:hhead});
	$('.thanks-wrap .bcol').css({height:hscreen, paddingTop:hhead+30});
	$('.login-wrap .tb-col > .bcol').css({height:hscreen, paddingTop:hhead+30});
	$('.tempt-1 .main-wrap').css({paddingTop:hhead});	
	$('.no-bn').css({paddingTop:hhead});	
	
} 

function myScroll(e) {
	var topScroll = $(window).scrollTop();
	var totalScroll = topScroll + $(window).height();
	var offsetTop = $(e).offset().top;
	return totalScroll >= (offsetTop )
}
$(document).ready(function(){
	$(".object").each(function() {
		myScroll(this) === !0 && $(this).find('.animated').addClass("go")
	});
});

$(window).scroll(function(){
	$(".object").each(function() {
		myScroll(this) === !0 && $(this).find('.animated').addClass("go")
	});
  if ($(window).scrollTop() > 0) {
    $('.gotop').css({opacity:1});
   }
   else {
    $('.gotop').css({opacity:0});
   }
});



var jump=function(e){
	if (e){
	   e.preventDefault();
	   var target = $(this).attr("href");
	}else{
	   var target = location.hash;
	}
	
	$('html,body').animate(
	{
	   scrollTop: $(target).offset().top
	},1000,function()
	{
	   location.hash = target;
	});
	
	var tabcurrent = '#' + $(target).val();
	$('.nav-tabs-wrap input').attr('checked',false);
	$(target).attr('checked',true);
	$('.tabcontent').removeClass('active');
	$(tabcurrent).addClass('active');
}


$(document).ready(function(){
	respon();
	
	stickyHeader();
	$('[data-toggle="tooltip"]').tooltip();
	
	if (location.hash){
		setTimeout(function(){
			$('html, body').scrollTop(0).css({opacity:1});
			jump()
		}, 300);				
			
	}else{
	  $('html, body').css({opacity:1});
		
	}
	$(".menu ul a").on("click", function(){
		var xhref = $(this).attr("href"); 
		var arrHref = xhref.split("#");
		if(arrHref.length > 1){
			//alert(arrHref[1]);
			$("#" +arrHref[1]).trigger("click");
		}
	})   

	$(".toggle-password").click(function() {
	  $(this).toggleClass("fa-eye fa-eye-slash");
	  var input = $($(this).attr("toggle"));
	  if (input.attr("type") == "password") {
		input.attr("type", "text");
	  } else {
		input.attr("type", "password");
	  }
	});
	var md = new MobileDetect(window.navigator.userAgent);
        if(md.mobile() == "iPad"){
          $("body").addClass("touch");
        }else if(md.mobile() == "" || md.mobile() == null){
			
          $("body").addClass("notouch");
        }else{

          $("body").addClass("touch");
        }
	
	$(".menu li").find("ul").prev().addClass("hasSub").append("<span class='subarrow'></span>");
		
	$('.menu li').each(function(){
		$(this).hover(
		  function() {
			$(this).find('.hover').addClass('hovered');
		  }, function() {
			$(this).find('.hover').removeClass('hovered');
			$(this).find('.hover').addClass('leave').delay(100,function () { 
				$(this).find('.hover').removeClass('leave'); 
			});
		  }
		);
	});	
	/*var setHover;
	$('.menu ul > li > a').hover(function(){
		$(this).find('> .hover').addClass('hovered');
	}, function(){
		var sefl = $(this);
		sefl.find('> .hover').addClass('leave');
		clearTimeout(setHover);
		setHover = setTimeout(function(){
			sefl.find('> .hover').removeClass('hovered leave'); 
		}, 200);
	});*/
	
	
	$('.menu .subarrow').each(function(){
		var currentid = $(this).attr('href');
		$(this).click(function(e){
	        e.preventDefault();
			 $(this).parent().next().toggleClass('open');
			 $(this).parent().toggleClass('open');
		});	
	});	
		
	$('.control-page').each(function(){
		var currentid = $(this).attr('href');
		$(this).click(function(e){
	        e.preventDefault();
			 $(this).toggleClass('active-burger');
			 $(currentid).toggleClass('open-sub');
			 $('body').toggleClass('open-page');
		});	
	});	
		
		
	$('.btn-control').each(function(){
		var currentid = $(this).attr('href'),
			lnk = $(currentid).find('a'),
			str = $(this).next().find('.active').text();
		if (str!="") {
		 $(this).html(str); }		
		$(lnk).each(function(){	       
			$(this).click(function(e){
				e.preventDefault();
				 var str2 = $(this).text();
				$(this).parent().parent().prev().html(str2);	
			});				
		});	
		$(this).click(function(e){
	        e.preventDefault();
			 $(this).toggleClass('open');
			 $(currentid).toggle().toggleClass('opensub');	
		});	
		$('body').on('click',function(event){
		   if(!$(event.target).is('.btn-control')){
			 $(this).removeClass('open');
			 $(currentid).hide().removeClass("opensub");
		   }
		});
	});	
	
	$('.touch .btn-show-wrap').each(function(){
		$(this).click(function(){
			if ($(this).hasClass()){
			 $(this).removeClass('open');				
			}else{
			 $('.touch .btn-show-wrap').removeClass('open');
			 $(this).addClass('open');				
			}
		});	
		
		$(document).on("click", ".touch .btn-show-wrap, .touch .btn-show-wrap .descript", function(e){
			e.stopPropagation();
		});
		
		$(document).click(function(){
			$('.touch .btn-show-wrap').removeClass('open');
		});
	});	
	$('.notouch .btn-show-wrap').each(function(){
		$(this).hover(function(){
			 $(this).toggleClass('open');
		});	
	});	
	
	$('.btn-drop').each(function(){
		var currentid = $(this).attr('href'),
			str = $(this).next().find('.active').text();
		$(this).html(str);
		$(this).click(function(e){
	        e.preventDefault();
			e.stopPropagation();
			if ($(this).hasClass('open')) {				
				 $(this).removeClass('open');
				 $(currentid).removeClass('opensub');
			}else{			
				$(".drop-wrap .drop-content").removeClass('opensub');
				$('.btn-drop').removeClass('open');	
				 $(this).addClass('open');
				 $(currentid).addClass('opensub');
			}
		});	
		/*$(currentid).click(function(e){
			e.stopPropagation();
		});*/
		
		$(document).click(function(){
			$(".drop-wrap .drop-content").removeClass('opensub');
			$('.btn-drop').removeClass('open');
		});
	});	
	
	
	/* bg appointment */
	$('.bg').each(function() {
		var imgUrl1 = $(this).find('.bgimg').attr('src');
		$(this).fixbg({ srcimg : imgUrl1});           
    });
	
	$('.fancybox').fancybox({
		padding: 0,
		helpers: {
			title : {
				type : 'over'
			},
			overlay : {
				locked: false
			}
		}
	});
	
	$('.fancybox-media').fancybox({
		padding: 0,
		maxWidth	: 800,
		maxHeight	: 600,
		fitToView	: false,
		autoSize	: false,
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none',
		helpers : {
			overlay : {
				locked: false
			}
		}
	});
	
	/* btn scroll to element */
	$('.smoothscroll').bind('click',function (e) {
        e.preventDefault();
        var target = this.hash,
        $target = $(target);
        $('html, body').stop().animate( {
            'scrollTop': $target.offset().top
        }, 1000, 'swing', function () {
            window.location.hash = target;
        } );
    } );
	
	$('.choose-wrap').each(function() {
		var itemradio = $(this).find(".tabcontent");
		$(this).find('.radio-control').click(function() {
			var test = $(this).val(),
				current = "#" + test;
			$(itemradio).removeClass("active");
			$(current).addClass("active");
		});        
    });
	
	$('.show-full').each(function(){
		$(this).click(function(e){
	        e.preventDefault();
			$(this).parent().prev().removeClass('short');
			$(this).addClass('hidebtn');
			$(this).next().removeClass('hidebtn');
		});			
	});	
	$('.show-short').each(function(){
		$(this).click(function(e){
	        e.preventDefault();
			$(this).parent().prev().addClass('short');
			$(this).addClass('hidebtn');
			$(this).prev().removeClass('hidebtn');
		});			
	});	
	
	$('.inputfile').on("change", function() {
		let filenames = [];
		let files = document.getElementById("customFile").files;
		if (files.length > 1) {
		  filenames.push("Total Files (" + files.length + ")");
		} else {
		  for (let i in files) {
			if (files.hasOwnProperty(i)) {
			  filenames.push(files[i].name);
			}
		  }
		}
		$(this)
		  .next(".custom-file-label")
		  .html(filenames.join(","));
	  });
	
	$("#uploadphoto").on('change',function(){
        var input = $(this)[0];
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#preview').attr('src', e.target.result).fadeIn('slow');
            }
            reader.readAsDataURL(input.files[0]);
        }
    });
	
	$('.shownote').focus(function(){
	   $('.notebox').fadeIn();
	}).focusout(function(){
	   $('.notebox').fadeOut();
	});
	
	
	$('.btn-modal').each(function(){
		$(this).click(function(){
			var idclose = $(this).attr('data-close'),
				idopen = $(this).attr('href');
			$(idclose).modal('hide');
			setTimeout(function() {
				   $(idopen).modal({
					   backdrop: 'static'
			   })
			}, 400);
		});	
	});	
	
	
	$(".select-wrap select").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");
            if(optionValue){
                $(".select-content").hide();
                $("#" + optionValue).show();
            } else{
                $(".select-content").hide();
            }
        });
    }).change();
	
	$('.ig-1 input').each(function(){
		$(this).on('focus blur', function(){
			 $(this).parent().toggleClass('focused');
		})
	});	
	$('.form-control-2 input').each(function(){
		$(this).on('focus blur', function(){
			 $(this).parent().toggleClass('focused');
		})
	});	
		
});


window.onload = new function () {
	
	respon();
	
	setTimeout(function(){
		$('body').addClass('loaded');
	}, 500);
	
	
	$('#slider').slick({
		//arrows: false,
		autoplay: true,
		autoplaySpeed: 5000,
		dots: true,
		fade: true,
		pauseOnHover: false,
		slidesToShow: 1,
		slidesToScroll: 1,
		speed: 500
	});	

	$('.slick-1').slick({
		//autoplay: true,
		slidesToShow:3,
		slidesToScroll: 3,
		speed: 1000,
		responsive: [
		{
		  breakpoint: 1025,
		  settings: {
			slidesToShow: 2,
			slidesToScroll: 2
		  }
		},
		{
		  breakpoint: 767,
		  settings: {
			slidesToShow: 1,
			slidesToScroll: 1
		  }
		},
	  ]
	});		

		
	$('.eheight').each(function() {
		$(this).find('.ecol').matchHeight();
	});
	$('.grid-4').each(function() {
		$(this).find('figure').matchHeight();
	});
	$('.grid-1').each(function() {
		$(this).find('figure').matchHeight();
		$(this).find('h3').matchHeight();
		$(this).find('.content').matchHeight();
	});
	$('.grid-2').each(function() {
		$(this).find('.imgwrap').matchHeight();
		$(this).find('.content').matchHeight();
		$(this).find('.item').addClass('animated');
	});
	
	/*setTimeout(function(){
		var $container = $('.masony').isotope({
			itemSelector: '.item',
		  });
	}, 1000);	*/	
	
	/*var $container = $('.masony').isotope({
		itemSelector: '.item',
	  });
		$container.imagesLoaded().progress( function() {
		  $container.isotope('layout');
		});*/
	
	
};

$(window).resize(function() {
	respon();
});