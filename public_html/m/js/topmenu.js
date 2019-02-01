$(document).ready(function () {


	// 전체메뉴
	$("#bt_menu").click(function () {
		$("#main_gnb").animate({left:'0px'},400);
		$("#back_toggle").toggle();
		//$("#main_gnb").toggle();
		//$(".mobile_menu").css({"background-position":"0 -120px"});


		var txt = $(document).height();
		$("#back_toggle").css({"height": txt });
	});

	$("#back_toggle").click(function () {
			$("#main_gnb").animate({left:'-710px'},400);
			$(this).toggle();
			//$("#main_gnb").toggle();
			//$(".mobile_menu").css({"background-position":"0 -120px"});
		}

	);

	$(".main_news").click(function () {
			//$(".menu_toggle").animate({top:'23px'}, 1000);
		}

	);

	var onoff01 = -1;
	var onoff02 = -1;
	var onoff03 = -1;
	var onoff04 = -1;
	var onoff05 = -1;

	// 회사메뉴
	$("#gnb01").click(function(){
		//$("#sub_gnb01").toggle();
		if(onoff01 < 0){
			$("#sub_gnb01").css({"display":"block"});
			$("#sub_gnb02").css({"display":"none"});
			$("#sub_gnb03").css({"display":"none"});
			$("#sub_gnb04").css({"display":"none"});
			$("#sub_gnb05").css({"display":"none"});

			$("#pl01").css({"display":"none"});
			$("#pl02").css({"display":"block"});
			$("#pl03").css({"display":"block"});
			$("#pl04").css({"display":"block"});
			$("#pl05").css({"display":"block"});

			$("#mi01").css({"display":"block"});
			$("#mi02").css({"display":"none"});
			$("#mi03").css({"display":"none"});
			$("#mi04").css({"display":"none"});
			$("#mi05").css({"display":"none"});

			onoff01 = 1;
			onoff02 = -1;
			onoff03 = -1;
			onoff04 = -1;
			onoff05 = -1;
		}

		else{
			$("#sub_gnb01").css({"display":"none"});
			$("#pl01").css({"display":"block"});
			$("#mi01").css({"display":"none"});
			onoff01 = -1;
		}
	});


	// 소재메뉴
	$("#gnb02").click(function () {

		if(onoff02 < 0){
			$("#sub_gnb02").css({"display":"block"});
			$("#sub_gnb01").css({"display":"none"});
			$("#sub_gnb03").css({"display":"none"});
			$("#sub_gnb04").css({"display":"none"});
			$("#sub_gnb05").css({"display":"none"});
			$("#pl01").css({"display":"block"});
			$("#pl02").css({"display":"none"});
			$("#pl03").css({"display":"block"});
			$("#pl04").css({"display":"block"});
			$("#pl05").css({"display":"block"});
			$("#mi01").css({"display":"none"});
			$("#mi02").css({"display":"block"});
			$("#mi03").css({"display":"none"});
			$("#mi04").css({"display":"none"});
			$("#mi05").css({"display":"none"});
			onoff01 = -1;
			onoff02 = 1;
			onoff03 = -1;
			onoff04 = -1;
			onoff05 = -1;
		}

		else{
			$("#sub_gnb02").css({"display":"none"});
			$("#pl02").css({"display":"block"});
			$("#mi02").css({"display":"none"});
			onoff02 = -1;
		}
	});

	// 제품메뉴
	$("#gnb03").click(function () {

		if(onoff03 < 0){
			$("#sub_gnb03").css({"display":"block"});
			$("#sub_gnb02").css({"display":"none"});
			$("#sub_gnb01").css({"display":"none"});
			$("#sub_gnb04").css({"display":"none"});
			$("#sub_gnb05").css({"display":"none"});
			$("#pl01").css({"display":"block"});
			$("#pl02").css({"display":"block"});
			$("#pl03").css({"display":"none"});
			$("#pl04").css({"display":"block"});
			$("#pl05").css({"display":"block"});
			$("#mi01").css({"display":"none"});
			$("#mi02").css({"display":"none"});
			$("#mi03").css({"display":"block"});
			$("#mi04").css({"display":"none"});
			$("#mi05").css({"display":"none"});
			onoff01 = -1;
			onoff02 = -1;
			onoff03 = 1;
			onoff04 = -1;
			onoff05 = -1;
		}

		else{
			$("#sub_gnb03").css({"display":"none"});
			$("#pl03").css({"display":"block"});
			$("#mi03").css({"display":"none"});
			onoff03 = -1;
		}
	});


	// 갤러리메뉴
	$("#gnb04").click(function () {

		if(onoff04 < 0){
			$("#sub_gnb04").css({"display":"block"});
			$("#sub_gnb02").css({"display":"none"});
			$("#sub_gnb03").css({"display":"none"});
			$("#sub_gnb01").css({"display":"none"});
			$("#sub_gnb05").css({"display":"none"});
			$("#pl01").css({"display":"block"});
			$("#pl02").css({"display":"block"});
			$("#pl03").css({"display":"block"});
			$("#pl04").css({"display":"none"});
			$("#pl05").css({"display":"block"});
			$("#mi01").css({"display":"none"});
			$("#mi02").css({"display":"none"});
			$("#mi03").css({"display":"none"});
			$("#mi04").css({"display":"block"});
			$("#mi05").css({"display":"none"});
			onoff01 = -1;
			onoff02 = -1;
			onoff03 = -1;
			onoff04 = 1;
			onoff05 = -1;
		}

		else{
			$("#sub_gnb04").css({"display":"none"});
			$("#pl04").css({"display":"block"});
			$("#mi04").css({"display":"none"});
			onoff04 = -1;
		}
	});

	// 노티스메뉴
	$("#gnb05").click(function () {

		if(onoff05 < 0){
			$("#sub_gnb05").css({"display":"block"});
			$("#sub_gnb02").css({"display":"none"});
			$("#sub_gnb03").css({"display":"none"});
			$("#sub_gnb04").css({"display":"none"});
			$("#sub_gnb01").css({"display":"none"});
			$("#pl01").css({"display":"block"});
			$("#pl02").css({"display":"block"});
			$("#pl03").css({"display":"block"});
			$("#pl04").css({"display":"block"});
			$("#pl05").css({"display":"none"});
			$("#mi01").css({"display":"none"});
			$("#mi02").css({"display":"none"});
			$("#mi03").css({"display":"none"});
			$("#mi04").css({"display":"none"});
			$("#mi05").css({"display":"block"});
			onoff01 = -1;
			onoff02 = -1;
			onoff03 = -1;
			onoff04 = -1;
			onoff05 = 1;
		}

		else{
			$("#sub_gnb05").css({"display":"none"});
			$("#pl05").css({"display":"block"});
			$("#mi05").css({"display":"none"});
			onoff05 = -1;
		}
	});


	//////////////////////////////// 팝업 사라지기 ////////

		//   $('#hclose').click(function(){
		//	   $('#hpopup').hide(100);
		//   });


});




/////////////팝업창 열기 /////
function windOPE()
{
	noticeWindow  =  window.open("mystery.html","신비의물성",'left=200, top=40, width=360, height=720, resizable=no, scrollbars=no, status=no location=no ');
}

function windOPE2()
{
	noticeWindow2  =  window.open("certificate.html","certificate",'left=200, top=40, width=580, height=760, resizable=no, scrollbars=no, status=no location=no ');
}

function windOPE2eng()
{
	noticeWindow2eng  =  window.open("ecertificate.html","certificate",'left=200, top=40, width=580, height=760, resizable=no, scrollbars=no, status=no location=no ');
}

function windOPE3()
{
	noticeWindow3  =  window.open("http://www.toray.com/technology/toray/history/index.html","",'scrollbars=yes, left=200, top=40');
}


///////////// 게시판 iframe 높이값 조종 ///////////////////////////


function changeHeight(obj) {
	if(obj.contentDocument){
		obj.height = obj.contentDocument.body.offsetHeight ;
	} else {
		obj.height = obj.contentWindow.document.body.scrollHeight;
	}
}

/*
 var currentPosition = 0;
 $(window).scroll(function()
 {
 currentPosition = $(window).scrollTop();
 if(currentPosition < 550){
 $('#wrap_cont_left').animate({top:0+"px" });
 }
 else if(currentPosition >= 550){
 $('#wrap_cont_left').animate({top:$(window).scrollTop()-500+"px" });   }
 });  */

//when the close button at right corner of the message box is clicked
//$('#scroll').click(function()
//{
//the messagebox gets scrool down with top property and gets hidden with zero opacity
// $('#scroll').animate({ top:"+=15px",opacity:0 }, "slow");
// });
