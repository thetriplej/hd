(function($){
$(document).ready(function () {

    // 전체메뉴
    $("#bt_menu").click(function () {
            $("#main_gnb").toggle(100);
            $(".menu_toggle").css({"background-position":"0 -23"});
        }

    );

    $(".main_news").click(function () {
            //$(".menu_toggle").animate({top:'23px'}, 1000);
        }

    );

    // 회사메뉴
    $("#gnb01").on({
        mouseenter: function () { $("#sub_gnb01").show(100);
        }
    });

	$("#gnb01").on({
		mouseleave: function () { $("#sub_gnb01").hide(100); }
    });

    // 소재메뉴
    $("#gnb02").on({
        mouseenter: function () {
            $("#sub_gnb02").show(100);
        }
    });
    $("#gnb02").on({
        mouseleave: function () { $("#sub_gnb02").hide(100);}
    });

    // 제품메뉴
    $("#gnb03").on({
        mouseenter: function () {
            $("#sub_gnb03").show(100);
        }
    });
    $("#gnb03").on({
        mouseleave: function () { $("#sub_gnb03").hide(100);
        }
    });

    // 제품메뉴
    $("#gnb04").on({
        mouseenter: function () {
            $("#sub_gnb04").show(400);
        }
    });
    $("#gnb04").on({
        mouseleave: function () { $("#sub_gnb04").hide(100); }
    });

    // 갤러리메뉴
    $("#gnb05").on({
        mouseenter: function () {
            $("#sub_gnb05").show(100);
        }
    });
    $("#gnb05").on({
        mouseleave: function () { $("#sub_gnb05").hide(100); }
    });

	 // 노티스메뉴
    $("#gnb06").on({
        mouseenter: function () {
            $("#sub_gnb06").show(100);
        }
    });
    $("#gnb06").on({
        mouseleave: function () { $("#sub_gnb06").hide(100); }
    });


/////////////마우스가 메뉴바 위로 올라갈때 서브메뉴 사라지기 /////
    $(".top_menubar").on({
        mouseleave: function () {
            //$("#main_gnb").hide(100);
            $("#sub_gnb01").hide(100);
            $("#sub_gnb02").hide(100);
            $("#sub_gnb03").hide(100);
            $("#sub_gnb04").hide(100);
            $("#sub_gnb05").hide(100);
            $("#sub_gnb06").hide(100);
            $("#sub_gnb07").hide(100); }
    });


/////////////마우스가 위로 올라갈때 /////
    $(".top_menubar").on({
        mouseenter: function () {
            $("#top_background").show(100);
			}
    });
	
	$(".top_menubar").on({
        mouseleave: function () {
            $("#top_background").hide(100);
			}
    });


//////////////////////////////// 팝업 사라지기 ////////

		//   $('#hclose').click(function(){
		//	   $('#hpopup').hide(100);

});


})(jQuery);


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
    noticeWindow3  =  window.open("http://www.toray.com/","",'scrollbars=yes, left=200, top=40');
}


///////////// 게시판 iframe 높이값 조종 ///////////////////////////


function changeHeight(obj) {
    if(obj.contentDocument){
        obj.height = obj.contentDocument.body.offsetHeight ;
    } else {
        obj.height = obj.contentWindow.document.body.scrollHeight;
    }
}



// 2022 hassed_menu slider

window.onscroll = function() {menuslide()};

function menuslide() {
    if (document.body.scrollTop > 45 || document.body.scrollTop > 45) {
        document.getElementById("menuslide").className = "top_menubar_hide";
    } else {
        document.getElementById("menuslide").className = "top_menubar";
    }
}



// 2017 hassed top menu slider
/*
window.onscroll = function() {topbar()};

function topbar() {
    if (document.body.scrollTop > 45 || document.documentElement.scrollTop > 45) {
        document.getElementById("sns_frame").className = "bar_hidden";
    } else {
        document.getElementById("sns_frame").className = "bar_visible";
    }
}
*/
// 2017 hassed top menu slider end