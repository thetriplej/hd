   
	   
	   $(document).ready(function () {

		   // ��ü�޴�
           $("#bt_menu").click(function () {
                   $("#main_gnb").toggle(100);
				   $(".menu_toggle").css({"background-position":"0 -23"});
               }
			   
           );

		   $(".main_news").click(function () {
				   //$(".menu_toggle").animate({top:'23px'}, 1000);
               }
			   
           );

           // ȸ��޴�
           $("#gnb01").on({
               mouseenter: function () {
				   $("#sub_gnb02").hide(10);
				   $("#sub_gnb03").hide(10); 
				   $("#sub_gnb04").hide(10); 
				   $("#sub_gnb05").hide(10); 
                   $("#sub_gnb01").show(100);
               }
           });
           $("#sub_gnb01 > ul").on({
               mouseleave: function () { $("#sub_gnb01").hide(100); }
           });

           // ����޴�
           $("#gnb02").on({
               mouseenter: function () {
                   $("#sub_gnb01").hide(10);
                   $("#sub_gnb03").hide(10);
				   $("#sub_gnb04").hide(10); 
				   $("#sub_gnb05").hide(10); 
				   $("#sub_gnb02").show(400);
               }
           });
           $("#sub_gnb02 > ul").on({
               mouseleave: function () { $("#sub_gnb02").hide(100);}
           });

           // ��ǰ�޴�
           $("#gnb03").on({
               mouseenter: function () {
                   $("#sub_gnb02").hide(10);
                   $("#sub_gnb04").hide(10);
				   $("#sub_gnb01").hide(10); 
				   $("#sub_gnb05").hide(10); 
				   $("#sub_gnb03").show(100);
               }
           });
           $("#sub_gnb03 > ul").on({
               mouseleave: function () { $("#sub_gnb03").hide(100); 
			    }
           });

           // �������޴�
           $("#gnb04").on({
               mouseenter: function () {
                   $("#sub_gnb03").hide(10);
                   $("#sub_gnb05").hide(10);
				   $("#sub_gnb01").hide(10); 
				   $("#sub_gnb02").hide(10);  
				   $("#sub_gnb04").show(100);
               }
           });
           $("#sub_gnb04 > ul").on({
               mouseleave: function () { $("#sub_gnb04").hide(100); }
           });

           // ��Ƽ���޴�
           $("#gnb05").on({
               mouseenter: function () {
                   $("#sub_gnb04").hide(10);
				   $("#sub_gnb03").hide(10); 
				   $("#sub_gnb02").hide(10); 
				   $("#sub_gnb01").hide(10); 
                   $("#sub_gnb05").show(100);
               }
           });
           $("#sub_gnb05 > ul").on({
               mouseleave: function () { $("#sub_gnb05").hide(100); }
           });


/////////////���콺�� ���� ������ ����޴� ������� /////
           $("#wrap_top").on({
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



       });



/////////////�˾�â ���� /////
function windOPE()
{
	noticeWindow  =  window.open("mystery.html","�ź��ǹ���",'left=200, top=40, width=360, height=720, resizable=no, scrollbars=no, status=no location=no ');
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


///////////// �Խ��� iframe ���̰� ���� ///////////////////////////


function changeHeight(obj) { 
	 if(obj.contentDocument){
		obj.height = obj.contentDocument.body.offsetHeight ;
	} else {
		obj.height = obj.contentWindow.document.body.scrollHeight;
	}
} 

// 2017 hassed top menu slider

window.onscroll = function() {topbar()};

function topbar() {
	if (document.body.scrollTop > 45 || document.documentElement.scrollTop > 45) {
		document.getElementById("sns_frame").className = "bar_hidden";
	} else {
		document.getElementById("sns_frame").className = "bar_visible";
	}
}

// 2017 hassed top menu slider end