function goto(url, option) {
	if(url) {
		if (option == "blank") {
			window.open("about:blank").location.href = url;
		} else {
			document.location.href = url;
		}
	}
}

function pwView(Obj){
	var TT = Obj.innerText;
	if(TT == "[확인]"){
		Obj.innerHTML = "[숨기기]";
		document.getElementById("pwView").style.display = "";
	}
	if(TT == "[숨기기]"){
		Obj.innerHTML = "[확인]";
		document.getElementById("pwView").style.display = "none";
	}
}

function frmList(rqURL){
	var frm=eval("document."+'frm01');
	if (confirm('리스트로 가시겠습니까?')){
		frm.action= rqURL+'?b_code='+$("#b_code").val()+'&page='+$("#page").val()+'&search_type='+$("#search_type").val()+'&search_value='+$("#search_value").val();
		frm.submit();
	}

}

function frmModi(idx , edit_uri){
	var frm=eval("document."+'frm01');
	if (confirm('수정하시겠습니까?')){
		frm.action= edit_uri+'?b_index='+idx+'&b_code='+$("#b_code").val()+'&page='+$("#page").val()+'&search_type='+$("#search_type").val()+'&search_value='+$("#search_value").val();
		frm.submit();
	}

}


function frmReply(idx){
	var frm=eval("document."+'frm01');
	if (!confirm('답변을 등록 하시겠습니까?')){
		return;
	}
	frm.action= '/admin/bbs_reply?b_index='+idx+'&b_code='+$("#b_code").val()+'&page='+$("#page").val()+'&search_type='+$("#search_type").val()+'&search_value='+$("#search_value").val();;
	frm.proc_type.value = "RW";
	frm.submit();
}

function log_out(){

		$.ajax({
			type: "POST",
			url: "/ajax/admin/log_out",
			dataType: 'json',
			data: {
				csrf_token: $('input[name=csrf_token]').val(),
				mode: 'admin'
			},
			success: function (result) {
				if (result == "fail") {
					alert('관리자에게 문의해주세요.(삭제불가)');
					return;
				} else if (result == "success") {
					alert('로그아웃되었습니다..');
					location.href = '/admin/';
				}

			}
		});

}
function frmDel(idx,uri){
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
					location.href = uri+'?b_code='+$("#b_code").val()+'&page='+$("#page").val()+'&search_type='+$("#search_type").val()+'&search_value='+$("#search_value").val();
				}

			}
		});
	}
}

function checking_file(){
	if($('input[name=files]').val() !=""){
		var file = $('#files').val();
		var fileExt = file.substring(file.lastIndexOf(".") +1);
		var reg = /gif|jpg|jpeg|png|bmp|psd|tif|tga|pcx|pcd/i;
		var reg2 = /pdf|mp4|hwp|txt|pptx|xlsx|xlsm|xlsb|xltx|xltxm|xls|xlt|ppt|doc|docx/i;
		if(reg.test(fileExt) == true){
			alert("사진파일은 에디터에서  업로드 가능합니다.");
			$('#files').val('');
			return;
		}
		if(reg2.test(fileExt) == false){
			alert("업로드가 불가능한 파일입니다.");
			$('#files').val('');
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
function file_down(path){
    location.href = "/other/file_down?path=" + path;
}

function imgView(Obj,dir,Width){
    Width = (Width == "780") ? " width='780' " : "";
    document.getElementById("imgView").innerHTML = "<img src= /public_html"+dir+" "+Width+"><br /><span class=\"hand\" onClick=\"imgClose(this);\">[닫기]</span>";
}

function imgClose(Obj){
    document.getElementById("imgView").innerHTML = "";
}

function Popular(idx){
    $.ajax({
        type:"POST",
        url:"/ajax/admin/popular_set",
		dataType: 'json',
        data: {
            csrf_token: $('input[name=csrf_token]').val(),
            idx: $('#b_index').val(),
            mode : 'admin'
        },
        success:function(result){
            if(result == "success"){
                alert("등록되었습니다.");
            }else if(result == "already"){
                alert("이미 등록이 되어있습니다.");
            }else if(result == "update"){
                alert("등록되었습니다.");
            }else if(result =="over"){
                alert("등록갯수를 초과하였습니다.");
            }else{
                alert("관리자에게 문의해주세요.")
            }

        }
    });

}

function delFile(idx) {

    $.ajax({
        type: "POST",
        url: "/ajax/admin/file_delete",
		dataType: 'json',
        data: {
            csrf_token: $('input[name=csrf_token]').val(),
            idx: idx,
            mode : 'admin'
        },
        success : function(result) {
            if(result == "success") {
                alert("파일이 삭제되었습니다.");
				$('.'+idx+'').empty();
            }else{
                alert("관리자에게 문의해주세요.");
            }

        }
    });
}

function admin_mode(mode){

	$.ajax({
		type: "POST",
		url: "/ajax/admin/admin_mode",
		dataType: 'json',
		data: {
			csrf_token: $('input[name=csrf_token]').val(),
			mode : mode
		},
		success : function(result) {
			if(result == "success") {
				if(mode=="admin"){
					location.href = '/admin/notice_list';
				}else{
					location.href = '/admin/visit_list';
				}
			}else{
				alert("관리자에게 문의해주세요.");
			}

		}
	});
}