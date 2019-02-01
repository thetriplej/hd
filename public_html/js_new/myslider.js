$(window).ready(function(){

	/* fadinout action*/


	var count = 0;
	var imgnum = 2;
	var imgnumb = 2;
	var imgnumc = 2;

setInterval(imgslide, 6000); // 매 1초마다 함수 실행			
setInterval(imgslideb, 3000); 
setInterval(imgslidec, 5000); 


	function imgslide(k){
		if(k != null){imgnum = k;}
		if(imgnum == 1){
			//$('#slider_review').fadeOut(500);
			//천번째 이미지 위치
			$('.slider_img01').fadeIn();
			$('.slider_img02').fadeOut();
			$('.slider_img03').fadeOut();
			$('#bt_point01').css({"background-position":"0px -13px"});
			$('#bt_point02').css({"background-position":"0px 0px"});
			$('#bt_point03').css({"background-position":"0px 0px"});
		}
		else if(imgnum == 2){
			//두번째 이미지 위치
			$('.slider_img01').fadeOut();
			$('.slider_img02').fadeIn();
			$('.slider_img03').fadeOut();
			$('#bt_point01').css({"background-position":"0px 0px"});
			$('#bt_point02').css({"background-position":"0px -13px"});
			$('#bt_point03').css({"background-position":"0px 0px"});
		}
		else if(imgnum == 3){
			//세번째 이미지 위치
			$('.slider_img01').fadeOut();
			$('.slider_img02').fadeOut();
			$('.slider_img03').fadeIn();
			$('#bt_point01').css({"background-position":"0px 0px"});
			$('#bt_point02').css({"background-position":"0px 0px"});
			$('#bt_point03').css({"background-position":"0px -13px"});
			imgnum = 0;
		}
		imgnum = imgnum + 1;
	}

	$("#bt_point01").click(function(){
        //$("#bt_point01").addClass("bgupdown");
		imgslide(1);
    });
	$("#bt_point02").click(function(){
        //$("#bt_point02").addClass("bgupdown");
		imgslide(2);
    });
	$("#bt_point03").click(function(){
        //$("#bt_point03").addClass("bgupdown");
		imgslide(3);
    });




// news sliding *************************//
	function imgslideb(k){
		if(k != null){imgnumb = k;}
		if(imgnumb == 1){
			//$('#slider_review').fadeOut(500);
			//천번째 이미지 위치
			$('.sliderb_img01').fadeIn();
			$('.sliderb_img02').fadeOut();
			//$('.sliderb_img03').fadeOut();
			$('#bt_pointb01').css({"background-position":"0px -13px"});
			$('#bt_pointb02').css({"background-position":"0px 0px"});
			//$('#bt_pointb03').css({"background-position":"0px 0px"});
		}
		else if(imgnumb == 2){
			//두번째 이미지 위치
			$('.sliderb_img01').fadeOut();
			$('.sliderb_img02').fadeIn();
			//$('.sliderb_img03').fadeOut();
			$('#bt_pointb01').css({"background-position":"0px 0px"});
			$('#bt_pointb02').css({"background-position":"0px -13px"});
			//$('#bt_pointb03').css({"background-position":"0px 0px"});
			imgnumb = 0;
		}
		/*else if(imgnumb == 3){
			//세번째 이미지 위치
			$('.sliderb_img01').fadeOut();
			$('.sliderb_img02').fadeOut();
			$('.sliderb_img03').fadeIn();
			$('#bt_pointb01').css({"background-position":"0px 0px"});
			$('#bt_pointb02').css({"background-position":"0px 0px"});
			$('#bt_pointb03').css({"background-position":"0px -13px"});
			imgnumb = 0;
		}*/
		imgnumb = imgnumb + 1;
	}

	$("#bt_pointb01").click(function(){
        //$("#bt_point01").addClass("bgupdown");
		imgslideb(1);
    });
	$("#bt_pointb02").click(function(){
        //$("#bt_point02").addClass("bgupdown");
		imgslideb(2);
    });
	/*$("#bt_pointb03").click(function(){
        //$("#bt_point02").addClass("bgupdown");
		imgslideb(3);
    });*/



// review sliding *************************//
function imgslidec(k){
		if(k != null){imgnumc = k;}
		if(imgnumc == 1){
			//$('#slider_review').fadeOut(500);
			//천번째 이미지 위치
			$('#slideA').animate({left: '0px' }, 1000);
			$('#slideB').animate({left: '710px' }, 1000);
			$('#bt_pointc02').css({"background-position":"0px 0px"});
			$('#bt_pointc01').css({"background-position":"0px -13px"});
		}
		else if(imgnumc == 2){
			//두번째 이미지 위치
			$('#slideA').animate({left: '-710px' }, 1000);
			$('#slideB').animate({left: '0px' }, 1000);
			$('#bt_pointc02').css({"background-position":"0px -13px"});
			$('#bt_pointc01').css({"background-position":"0px 0px"});
			imgnumc = 0;
		}
		imgnumc = imgnumc + 1;
	}

	$("#bt_pointc01").click(function(){
        //$("#bt_point01").addClass("bgupdown");
		imgslidec(1);
    });
	$("#bt_pointc02").click(function(){
        //$("#bt_point02").addClass("bgupdown");
		imgslidec(2);
    });

 }); 

 /*  //////////// 가로 슬라이드 20170222
function imgslide(k){
	if(k != null){imgnum = k;}
	if(imgnum == 1){
		//$('#slider_review').fadeOut(500);
		//천번째 이미지 위치
		$('.slider_img01').animate({left: '0px' }, 1000);
		$('.slider_img02').animate({left: '0px' }, 1000);
		$('.slider_img03').animate({left: '0px' }, 1000);
		$('#bt_point01').css({"background-position":"0px -13px"});
		$('#bt_point02').css({"background-position":"0px 0px"});
		$('#bt_point03').css({"background-position":"0px 0px"});
	}
	else if(imgnum == 2){
		//두번째 이미지 위치
		$('.slider_img01').animate({left: '-1080px'}, 1000 );
		$('.slider_img02').animate({left: '-1080px'}, 1000 );
		$('.slider_img03').animate({left: '-1080px'}, 1000 );
		$('#bt_point01').css({"background-position":"0px 0px"});
		$('#bt_point02').css({"background-position":"0px -13px"});
		$('#bt_point03').css({"background-position":"0px 0px"});
	}
	else if(imgnum == 3){
		//세번째 이미지 위치
		$('.slider_img01').animate({left: '-2160px'}, 1000 );
		$('.slider_img02').animate({left: '-2160px'}, 1000 );
		$('.slider_img03').animate({left: '-2160px'}, 1000 );
		$('#bt_point01').css({"background-position":"0px 0px"});
		$('#bt_point02').css({"background-position":"0px 0px"});
		$('#bt_point03').css({"background-position":"0px -13px"});
	}
	else if(imgnum == 4){
		//리셑
		$('.slider_img01').animate({left: '1080px'}, 1 );
		$('.slider_img01').animate({left: '0px'}, 1000 );
		$('.slider_img03').animate({left: '-3240px' }, 1000);
		$('.slider_img02').animate({left: '0px'}, 1 );
		$('.slider_img03').animate({left: '0px'}, 1);
		$('#bt_point01').css({"background-position":"0px -13px"});
		$('#bt_point02').css({"background-position":"0px 0px"});
		$('#bt_point03').css({"background-position":"0px 0px"});
		imgnum = 1;
	}
	imgnum = imgnum + 1;
}

	$("#bt_point01").click(function(){
        //$("#bt_point01").addClass("bgupdown");
		imgslide(1);
    });
	$("#bt_point02").click(function(){
        //$("#bt_point02").addClass("bgupdown");
		imgslide(2);
    });
	$("#bt_point03").click(function(){
        //$("#bt_point03").addClass("bgupdown");
		imgslide(3);
    });
 }); 
*/
