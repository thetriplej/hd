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

function send(sendURL, e, Locked){
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

function frmSend(IDX, URL){
	with(document.frm01){
		B_IDX.value = IDX;
		action = URL;
		submit();
	}
}

function frmDel(){
	with(document.frm01){
		method = 'post';
		ProcType.value = "D";
		action = "Proc.asp";
		submit();
	}
}

/* 비동기식 페이징 추가. */
/* 현재 페이지, 마지막 페이지, 보여주는 데이터 수, 전체 데이터 수, 한 페이지에 보여주는 페이징 수 */
function pagination(current_page, total_last_page, per_page, total, page_num){
	//console.log(current_page +" / "+ last_page +" / "+ per_page +" / "+ total);
	var page_set = per_page; //한 페이지에 보여줄 데이터 수
	var block_set = page_num; //한 페이지에 보여줄 블럭 수
	var total_page = Math.ceil(total / page_set); //전체 페이징 수
	var total_block = Math.ceil(total_page / block_set); // 전체 블럭 수

	var block = Math.ceil(current_page / block_set); //현재 페이징

	// 페이지번호 & 블럭 설정
	var first_page = ((block - 1) * block_set) + 1; // 첫번째 페이지번호
	var last_page = Math.min(total_page, block * block_set); // 마지막 페이지번호

	var prev_page = current_page - 1; // 이전페이지
	var next_page = current_page + 1; // 다음페이지

	var prev_block = block - 1; // 이전블럭
	var next_block = block + 1; // 다음블럭

	var prev_block_page = prev_block * block_set; //다음 블럭 마지막 페이지
	var next_block_page = next_block * block_set - (block_set - 1); //다음 블럭 첫 페이지


	// 페이징 화면
	var html = "";

	//html += (prev_page > 0) ? '<input type="button" class="btn_prev" onclick="get_list(1);" name="prev">' : '';

	html += (prev_page > 0) ? '<input type="button" class="btn_prev" onclick="get_list('+prev_block_page+');" name="prev" style="vertical-align: middle">' : '<input type="button" class="btn_prev" onclick="get_list(1);" name="prev" style="vertical-align: middle">';

	for (var i = first_page; i <= last_page; i++) {
		html += (i != current_page) ? '<span>[<a href="javascript:get_list('+ i + ');">'+i+'</a>]</span>' : '<span>[<a class="on" style="color:red;" href="javascript:void();">'+i+'</a>]</span>';

	}

	html += (next_block <= total_page) ? '<input type="button" class="btn_next" name="next" onclick="get_list('+next_block_page+');" alt="다음 페이지 블럭" style="vertical-align: middle">' : '';
	//html += (next_block <= total_block) ? "<a href='javascript:getPage("+next_block_page+");' class='next'></a>" : "";
	//html += (next_page <= total_page) ? '<input type="button" class="btn_next" name="next" onclick="get_list("+total_last_page+");" alt="다음 페이지 블럭">' : '';

	window.sessionStorage.setItem('list_paginates', current_page);

	$(".paging").empty();
	$(".paging").append(html);


}


