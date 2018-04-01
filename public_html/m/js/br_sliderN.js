$(window).ready(function(){

	/* fadinout action*/

	var imgnum = 2;

	setInterval(brandslideN, 6000); // 매 1초마다 함수 실행


//////////// 가로 슬라이드 20170404
	function brandslideN(k){
		if(k != null){
			landr = k;

			if(landr == 1){
				imgnum = imgnum - 1;
				if(imgnum < 1){
					imgnum = 5;
				}
			}
			else if(landr == 2){
				imgnum = imgnum + 1;
				if(imgnum > 5){
					imgnum = 1;
				}
			}
		}
		else {
			if(imgnum > 1){
				imgnum = imgnum - 1;}
			else if(imgnum < 5){
				imgnum = 5;
			}
		}

		if(imgnum == 1){
			//천번째 이미지 위치
			$('#bs01').animate({left: '0px' }, 0);
			$('#bs02').animate({left: '700px' }, 500);
			$('#bs03').animate({left: '1400px' }, 500);
			$('#bs04').animate({left: '2100px' }, 500);
			$('#bs05').animate({left: '2800px' }, 0);
			$('.brand_slide_bt_leftN').css({"background-position":"0px -200px"});
			$('.brand_slide_bt_rightN').css({"background-position":"0px -200px"});
		}
		else if(imgnum == 2){
			//두번째 이미지 위치
			$('#bs01').animate({left: '700px' }, 500);
			$('#bs02').animate({left: '1400px' }, 500);
			$('#bs03').animate({left: '2100px' }, 500);
			$('#bs04').animate({left: '2800px' }, 0);
			$('#bs05').animate({left: '0px' }, 0);
			$('.brand_slide_bt_leftN').css({"background-position":"0px -100px"});
			$('.brand_slide_bt_rightN').css({"background-position":"0px -100px"});
		}
		else if(imgnum == 3){
			//세번째 이미지 위치
			$('#bs01').animate({left: '1400px' }, 500);
			$('#bs02').animate({left: '2100px' }, 500);
			$('#bs03').animate({left: '2800px' }, 0);
			$('#bs04').animate({left: '0px' }, 0);
			$('#bs05').animate({left: '700px' }, 500);
			$('.brand_slide_bt_leftN').css({"background-position":"0px -500px"});
			$('.brand_slide_bt_rightN').css({"background-position":"0px 0px"});
		}
		else if(imgnum == 4){
			//네번째 이미지 위치
			$('#bs01').animate({left: '2100px' }, 500);
			$('#bs02').animate({left: '2800px' }, 0);
			$('#bs03').animate({left: '0px' }, 0);
			$('#bs04').animate({left: '700px' }, 500);
			$('#bs05').animate({left: '1400px' }, 500);
			$('.brand_slide_bt_leftN').css({"background-position":"0px -400px"});
			$('.brand_slide_bt_rightN').css({"background-position":"0px -400px"});
		}
		else if(imgnum == 5){
			//리셑
			$('#bs01').animate({left: '2800px' }, 0);
			$('#bs02').animate({left: '0px' }, 0);
			$('#bs03').animate({left: '700px' }, 500);
			$('#bs04').animate({left: '1400px' }, 500);
			$('#bs05').animate({left: '2100px' }, 500);
			$('.brand_slide_bt_leftN').css({"background-position":"0px -300px"});
			$('.brand_slide_bt_rightN').css({"background-position":"0px -300px"});
			//imgnum = 1;
		}
	}
	//imgnum = imgnum + 1;

	$("#bt_br_left").click(function(){
		brandslideN(2);
	});
	$("#bt_br_right").click(function(){
		brandslideN(1);
	});


});
