function goto(url, option) {
	if(url) {
		if (option == "blank") {
			window.open("about:blank").location.href = url;
		} else {
			document.location.href = url;
		}
	}
}

//Element 추가
function ElementAdd(Target, Position, Content, Url, Params, Method){ //Target - 대상, Position - 위치 (beforeBegin, afterBegin, beforeEnd, afterEnd), Url - 경로, Params - 파라미터, Method - GET/POST
	Obj = document.getElementById(Target);

	if(!Url){ //URL이 없을 경우 그 페이지에서 바로 실행
		Obj.insertAdjacentHTML(Position, Content);
	}else{
		Data = sendRequest(Url, Params, Method);

		Content = "<div style='width:600px'>"+Content+"<img src='/Images/ico_del.gif' class='imghand' onclick=\"ElementDel(this, 'Proc_Application.asp','"+ Data +"','POST')\"></div>";
		Obj.insertAdjacentHTML(Position, Content);
	}
}

//Element 삭제
function ElementDel(Target, Url, Params, Method){ //Target - 대상, Url - 경로, Params - 파라미터, Method - GET/POST
	Obj = Target.parentElement; //부모엘레먼트

	if(!Url){ //URL이 없을 경우 그 페이지에서 바로 실행
		Obj.removeNode(Obj);
	}else{
		Data = sendRequest(Url, Params, Method);
		if(Data == "OK"){
			Obj.removeNode(Obj);
		}else{
			alert('삭제가 실패하였습니다.\n다시한번 시도해 주시기 바랍니다.');
		}
	}
}


function frmDel(){
	if (confirm("정말삭제하시겠습니까?")) {
		$.ajax({
			type: "POST",
			url: "/ajax/board/set_del",
			dataType: 'json',
			data: {
				csrf_token: $('input[name=csrf_token]').val(),
				b_index: $('#b_index').val(),
				mode: 'admin'
			},
			success: function (result) {
				if (result == "fail") {
					alert('관리자에게 문의해주세요.(삭제불가)');
					return;
				} else if (result == "success") {
					alert('삭제되었습니다.');
					location.href = $("#pass_uri").val();
				}

			}
		});
	}
}

function checking_file(){
	if($('#Files').val() !=""){
		var file = $('#Files').val();
		var fileExt = file.substring(file.lastIndexOf(".") +1);
		var reg = /gif|jpg|jpeg|png|bmp|psd|tif|tga|pcx|pcd/i;
		var reg2 = /pdf|mp4|hwp|txt|pptx|xlsx|xlsm|xlsb|xltx|xltxm|xls|xlt|ppt|doc|docx/i;
		if(reg.test(fileExt) == true){
			alert("사진파일은 에디터에서  업로드 가능합니다.");
			$('#Files').val('');
			return;
		}
		if(reg2.test(fileExt) == false){
			alert("업로드가 불가능한 파일입니다.");
			$('#Files').val('');
			return;
		}
	}
}

function page_view(id){
	location.href = '/admin/bbs_view?b_index='+id+'&b_code='+$("#b_code").val()+'&page='+$("#page").val()+'&search_type='+$("#search_type option:selected").val()+'&search_value='+$("#search_value").val();
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

	html += (prev_page > 0) ? '<img src="/public_html/images/btn_prev.jpg" class="imghand" onclick="get_list('+prev_block_page+');" name="prev" style="vertical-align: middle">' : '<img src="/public_html/images/btn_prev.jpg" class="img" alt="이전 페이지 블럭">';

	for (var i = first_page; i <= last_page; i++) {
		html += (i != current_page) ? '[<span><a href="javascript:get_list('+ i + ');">'+i+'</a></span>]' : '[<span><a class="on" style="color:red;" href="javascript:void();">'+i+'</a></span>]';

	}

	html += (next_block <= total_block) ? '<img src="/public_html/images/btn_next.jpg" class="imghand" onclick="get_list('+next_block_page+');" alt="다음 페이지 블럭" style="vertical-align: middle">' : '<img src="/public_html/images/btn_next.jpg" class="img" alt="다음 페이지 블럭">';
	//html += (next_block <= total_block) ? "<a href='javascript:getPage("+next_block_page+");' class='next'></a>" : "";
	//html += (next_page <= total_page) ? '<input type="button" class="btn_next" name="next" onclick="get_list("+total_last_page+");" alt="다음 페이지 블럭">' : '';

	window.sessionStorage.setItem('list_paginates', current_page);

	$(".paging").empty();
	$(".paging").append(html);


}