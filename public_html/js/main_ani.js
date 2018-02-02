$(window).ready(function(){

	/* fadinout action


		var simg = 1;

			setInterval(function() {
				
				 if(simg == 1){
					$('#slider_b').fadeOut(2000);
				  }
				  else{
					$('#slider_b').fadeIn(2000);
				  }

				  simg *= -1; // 매 5초마다 숫자 -1을 sum 변수에 곱합니다.

			}, 5000); // 5000ms(5초)가 경과하면 이 함수가 실행합니다.

	/* fadinout action*/

	/* fadinout action*/


		var btimg = 1;

			setInterval(function() {
				
				 if(btimg == 1){
					$('#slider_review').fadeOut(500);
				  }
				  else{
					$('#slider_review').fadeIn(500);
				  }

				  btimg *= -1; // 매 5초마다 숫자 -1을 sum 변수에 곱합니다.

			}, 1000); // 5000ms(5초)가 경과하면 이 함수가 실행합니다.

	/* fadinout action*/
 }); 


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

