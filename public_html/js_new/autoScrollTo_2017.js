
// 2016 hassed left menu slider

window.onscroll = function() {myFunction()};

function myFunction() {
    if (document.body.scrollTop > 570 || document.documentElement.scrollTop > 570) {
        document.getElementById("smenu_left").className = "leftmenufixed";
    } else {
        document.getElementById("smenu_left").className = "leftmenu_reset";
    }
}


// 2016 hassed left menu slider end












var winW = $(window).width();
//슬라이더를 움직여주는 함수


/* subslider action*/

			  $(function() {

				$( "#btnext" ).click(function() {
				    var willMoveleft = -(1920);
					$('.slider_pannel').animate({left: willMoveleft }, 'slow');
					$('.slider_text_pannel').animate({left: willMoveleft }, 1200);
					$('.control_button').fadeOut(1000);
					$('.control_pannel2').fadeIn(1000);

				});

			  });
/* subslider action*/

/* subslider action*/

			  $(function() {

				$( "#btprev" ).click(function() {
				    var willMoveleft = (0);
					$('.slider_pannel').animate({left: willMoveleft }, 'slow');
					$('.slider_text_pannel').animate({left: willMoveleft }, 1200);
					$('.control_button').fadeIn(1000);
					$('.control_pannel2').fadeOut(1000);

				});

			  });
/* subslider action*/


/* sub02 slider action*/

			  $(function() {

				$( "#bt_item_7" ).click(function() {
				    var Moveleft = (0);
					var imgMove = (0);
					$('.triangle3').animate({left: Moveleft }, 500);
					$('.item_7>img').addClass('menu_act_color');
					$('.item_8>img').removeClass('menu_act_color');
					$('.item_9>img').removeClass('menu_act_color');
					$('.item_10>img').removeClass('menu_act_color');
					$('.sub02_img').animate({left: imgMove }, 500);
					$('#course_a').fadeIn(1000);
					$('#course_b').fadeOut(1000);
					$('#course_c').fadeOut(1000);
					$('#course_d').fadeOut(1000);
				});

				$( "#bt_item_8" ).click(function() {
				    var Moveleft = (240);
					var imgMove = (-960);
					$('.triangle3').animate({left: Moveleft }, 500);
					$('.item_7>img').removeClass('menu_act_color');
					$('.item_8>img').addClass('menu_act_color');
					$('.item_9>img').removeClass('menu_act_color');
					$('.item_10>img').removeClass('menu_act_color');
					$('.sub02_img').animate({left: imgMove }, 500);
					$('#course_a').fadeOut(1000);
					$('#course_b').fadeIn(1000);
					$('#course_c').fadeOut(1000);
					$('#course_d').fadeOut(1000);
				});

				$( "#bt_item_9" ).click(function() {
				    var Moveleft = (480);
					var imgMove = (-1920);
					$('.triangle3').animate({left: Moveleft }, 500);
					$('.item_7>img').removeClass('menu_act_color');
					$('.item_8>img').removeClass('menu_act_color');
					$('.item_9>img').addClass('menu_act_color');
					$('.item_10>img').removeClass('menu_act_color');
					$('.sub02_img').animate({left: imgMove }, 500);
					$('#course_a').fadeOut(1000);
					$('#course_b').fadeOut(1000);
					$('#course_c').fadeIn(1000);
					$('#course_d').fadeOut(1000);
				});

				$( "#bt_item_10" ).click(function() {
				    var Moveleft = (720);
					var imgMove = (-2880);
					$('.triangle3').animate({left: Moveleft }, 500);
					$('.item_7>img').removeClass('menu_act_color');
					$('.item_8>img').removeClass('menu_act_color');
					$('.item_9>img').removeClass('menu_act_color');
					$('.item_10>img').addClass('menu_act_color');
					$('.sub02_img').animate({left: imgMove }, 500);
					$('#course_a').fadeOut(1000);
					$('#course_b').fadeOut(1000);
					$('#course_c').fadeOut(1000);
					$('#course_d').fadeIn(1000);
				});


			  });
/* sub02 slider action*/


/* sub03 slider action*/

			  $(function() {

				$( "#bt_item_1" ).click(function() {
				    var Moveleft = (0);
					var imgMove = (0);
					//$('.img_item_1').animate({left: willMoveleft }, 'slow');
					$('.triangle').animate({left: Moveleft }, 500);
					$('.item_1>img').addClass('menu_act_color');
					$('.item_2>img').removeClass('menu_act_color');
					$('.item_3>img').removeClass('menu_act_color');
					$('.item_4>img').removeClass('menu_act_color');
					$('.sub03_img').animate({left: imgMove }, 500);
				});

				$( "#bt_item_2" ).click(function() {
				    var Moveleft = (240);
					var imgMove = (-960);
					//$('.img_item_1').animate({left: willMoveleft }, 'slow');
					$('.triangle').animate({left: Moveleft }, 500);
					$('.item_1>img').removeClass('menu_act_color');
					$('.item_2>img').addClass('menu_act_color');
					$('.item_3>img').removeClass('menu_act_color');
					$('.item_4>img').removeClass('menu_act_color');
					$('.sub03_img').animate({left: imgMove }, 500);
				});

				$( "#bt_item_3" ).click(function() {
				    var Moveleft = (480);
					var imgMove = (-1920);
					//$('.img_item_1').animate({left: willMoveleft }, 'slow');
					$('.triangle').animate({left: Moveleft }, 500);
					$('.item_1>img').removeClass('menu_act_color');
					$('.item_2>img').removeClass('menu_act_color');
					$('.item_3>img').addClass('menu_act_color');
					$('.item_4>img').removeClass('menu_act_color');
					$('.sub03_img').animate({left: imgMove }, 500);
				});

				$( "#bt_item_4" ).click(function() {
				    var Moveleft = (720);
					var imgMove = (-2880);
					//$('.img_item_1').animate({left: willMoveleft }, 'slow');
					$('.triangle').animate({left: Moveleft }, 500);
					$('.item_1>img').removeClass('menu_act_color');
					$('.item_2>img').removeClass('menu_act_color');
					$('.item_3>img').removeClass('menu_act_color');
					$('.item_4>img').addClass('menu_act_color');
					$('.sub03_img').animate({left: imgMove }, 500);
				});


			  });
/* sub03 slider action*/


/* sub04 slider action*/

			  $(function() {

				$( "#bt_item_5" ).click(function() {
				    var Moveleft = (0);
					var imgMove = (0);
					//$('.img_item_1').animate({left: willMoveleft }, 'slow');
					$('.triangle2').animate({left: Moveleft }, 500);
					$('.sub04_img').animate({left: imgMove }, 500);
					$('.item_5>span').addClass('font_blue');
					$('.item_6>span').removeClass('font_blue');

				});

				$( "#bt_item_6" ).click(function() {
				    var Moveleft = (474);
					var imgMove = (-960);
					//$('.img_item_1').animate({left: willMoveleft }, 'slow');
					$('.triangle2').animate({left: Moveleft }, 500);
					$('.item_6>span').addClass('font_blue');
					$('.item_5>span').removeClass('font_blue');
					$('.sub04_img').animate({left: imgMove }, 500);
				});

			  });
/* sub04 slider action*/



/* sub05 slider action*/

			  $(function() {

				$( "#bt_item_11" ).click(function() {
				    var Moveleft = (0);
					var imgMove = (0);
					$('.triangle4').animate({left: Moveleft }, 500);
					$('.sub05_img').animate({left: imgMove }, 500);
					$('.item_11>span').addClass('font_blue');
					$('.item_12>span').removeClass('font_blue');
					$('.item_13>span').removeClass('font_blue');

				});

				$( "#bt_item_12" ).click(function() {
				    var Moveleft = (312);
					var imgMove = (-960);
					$('.triangle4').animate({left: Moveleft }, 500);
					$('.item_11>span').removeClass('font_blue');
					$('.item_12>span').addClass('font_blue');
					$('.item_13>span').removeClass('font_blue');
					$('.sub05_img').animate({left: imgMove }, 500);
				});

				$( "#bt_item_13" ).click(function() {
				    var Moveleft = (624);
					var imgMove = (-1920);
					$('.triangle4').animate({left: Moveleft }, 500);
					$('.item_11>span').removeClass('font_blue');
					$('.item_12>span').removeClass('font_blue');
					$('.item_13>span').addClass('font_blue');
					$('.sub05_img').animate({left: imgMove }, 500);
				});

			  });
/* sub05 slider action*/



