$(window).ready(function(){

	/* fadinout action*/


	var count = 0;
	var imgnum = 2;

//setInterval(brandslide, 6000); // �� 1�ʸ��� �Լ� ����			


//////////// ���� �����̵� 20170222
function brandslide(k){
	if(k != null){
		landr = k;
		if(landr == 1){
			imgnum = imgnum - 1;
			if(imgnum <= 1){
				imgnum = 1;
			}
		}
		else if(landr == 2){
			imgnum = imgnum + 1;
			if(imgnum >= 5){
				imgnum = 5;
			}
		}
	}

	if(imgnum == 1){
		//õ��° �̹��� ��ġ
		$('.brand_slide').animate({left: '190px' }, 500);
		$('.brand_slide_bt_left').css({"background-position":"0px 0px"});
		$('.brand_slide_bt_right').css({"background-position":"0px 0px"});
	}
	else if(imgnum == 2){
		//�ι�° �̹��� ��ġ
		$('.brand_slide').animate({left: '-510px'}, 500 );
		$('.brand_slide_bt_left').css({"background-position":"0px -100px"});
		$('.brand_slide_bt_right').css({"background-position":"0px -100px"});
	}
	else if(imgnum == 3){
		//����° �̹��� ��ġ
		$('.brand_slide').animate({left: '-1210px'}, 500 );
		$('brand_slide_bt_left').css({"background-position":"0px -200px"});
		$('.brand_slide_bt_right').css({"background-position":"0px -200px"});
	}
	else if(imgnum == 4){
		//�׹�° �̹��� ��ġ
		$('.brand_slide').animate({left: '-1910px'}, 500 );
		$('.brand_slide_bt_left').css({"background-position":"0px -300px"});
		$('.brand_slide_bt_right').css({"background-position":"0px -300px"});
	}
	else if(imgnum == 5){
		//���V
		$('.brand_slide').animate({left: '-2610px'}, 500 );
		$('.brand_slide_bt_left').css({"background-position":"0px -400px"});
		$('.brand_slide_bt_right').css({"background-position":"0px -400px"});
		//imgnum = 1;
	}
	else if(imgnum == 6){
		//���V
		$('.brand_slide').animate({left: '-3310px'}, 500 );
		$('.brand_slide_bt_left').css({"background-position":"0px -500px"});
		$('.brand_slide_bt_right').css({"background-position":"0px -500px"});
		//imgnum = 1;
	}
}
	//imgnum = imgnum + 1;

	$("#bt_br_left").click(function(){
		brandslide(1);
    });
	$("#bt_br_right").click(function(){
		brandslide(2);
    });

});