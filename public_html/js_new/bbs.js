// function searchList(){
//
// 	location.href="./List.asp?B_Code="+$("#B_Code").val()+"&searchValue="+$("#searchValue").val()+"&searchType="+$("#searchType").val();
// }

function goto(url, option) {
	if(url) {
		if (option == "blank") {
			window.open("about:blank").location.href = url;
		} else {
			document.location.href = url;
		}
	}
}
var checkURL;
var agt = navigator.userAgent.toLowerCase();

function Send(sendURL, e, Locked){
	//화면의 높이와 너비를 구한다.
	var maskHeight = $(document).height();  
	var maskWidth = $(window).width();
	
	//마스크의 높이와 너비를 화면 것으로 만들어 전체 화면을 채운다.
	$('#blind').css({'width':maskWidth,'height':maskHeight});  
	//마스크의 투명도 처리
	$('#blind').fadeTo("slow",0.8);  
	 
	if (Locked == "Y"){
		//window.status = "X=" + window.event.x + " Y=" +window.event.y;
		if (agt.indexOf("firefox") != -1){			
			var x = e.offsetX;
			var y = e.offsetY;
		}else{
			var y = window.event.y;
			var x = window.event.x;
		}
		

		$("#blind").fadeIn('fast');
		$("#in_pass").css({
			top: ($("#tj_content").height() -300),
			left: (maskWidth*0.4),
			margin: 0
		}).fadeIn();
		//$(window).scrollTop($(document).height() - $(window).height())
		 


		checkURL = sendURL;
		
		$("#ck_lock").val(Locked);
		$("#passwd").attr('action',checkURL);
		
		
	}else{
		location.href=sendURL;
	}
}

function cancel(){
	$("#blind").fadeOut('fast');
	$("#in_pass").fadeOut();
}

function CheckPW(){
	if(!$("#pw").val()){
		alert("비밀번호를 입력해주세요.");
		$("#pw").focus();
		return false;
	}
	document.passwd.submit();

}

// function frmSend(IDX, URL){
// 	with(document.frm01){
// 		B_IDX.value = IDX;
// 		action = URL;
// 		submit();
// 	}
// }
//
// function frmDel(){
// 	with(document.frm01){
// 		method = 'post';
// 		ProcType.value = "D";
// 		action = "Proc.asp";
// 		submit();
// 	}
// }