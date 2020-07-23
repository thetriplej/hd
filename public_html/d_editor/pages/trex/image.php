<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>이미지 첨부</title>
<script src="../../js/popup.js" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" href="../../css/popup_mobile.css" type="text/css"  charset="utf-8"/>
<script src="/public_html/js/jquery-1.11.1.min.js"></script>
<script src="/public_html/js/jquery/plugins/jquery.form.js"></script>
<script type="text/javascript">
// <![CDATA[


	function initUploader(){
	    var _opener = PopupUtil.getOpener();
	    if (!_opener) {
	        alert('잘못된 경로로 접근하셨습니다.');
	        return;
	    }

	    var _attacher = getAttacher('image', _opener);
	    registerAction(_attacher);
	}
// ]]>

$(document).ready(function() {

	// Setup the ajax indicator
	$('body').append('<div id="ajaxBusy"><p><img src="/public_html/images/giphy.gif"  style="width:140px; height:140px"></p></div>');

	$('#ajaxBusy').css({
		display:"none",
		margin:"0px",
		paddingLeft:"0px",
		paddingRight:"0px",
		paddingTop:"0px",
		paddingBottom:"0px",
		position:"absolute",
		right:"50%",
		top:"50%",
		width:"auto"
	});
});


$(function(){
	$( "#submit" ).bind( "click", function() {
		if($('#attachFile').val() == '' ){
			alert("첨부 파일이 선택되지 않았습니다.\r\n첨부파일을 올려주세요.");
			return false;
		}
		if($('#attachFile').val() !=""){
			var file = $('#attachFile').val();
			var fileExt = file.substring(file.lastIndexOf(".") +1);
			var reg = /gif|jpg|jpeg|png|bmp/i;
			if(reg.test(fileExt) == false){
				alert("사진파일만 업로드 가능합니다.");
				return;
			}
		}

		$('#ajaxBusy').show();
		$('#ajaxform').submit();
	});

	$('#ajaxform').ajaxForm({
		dataType: 'json',
		//보내기전 validation check가 필요할경우
		beforeSubmit: function (data, frm, opt) {

			return true;
		},
		//submit이후의 처리
		success: function(response, status) {
			$('#ajaxBusy').hide();
			if(response.result == 'success') {
                $.each( response._mockdata, function( key, value ) {

                    if (key.image_width > 600) {
                        var rate = (600 / key.image_width);
                        var imgH = value.image_height * rate;
                        var imgW = value.image_width * rate;
                    } else {
                        var imgH = value.image_height;
                        var imgW = value.image_width;
                    }

                    var _mockdata = {
                        'imageurl': value.originalurl,
                        'f_rename': value.f_rename,
                        'filename': value.filename,
                        'filesize': value.filesize,
                        'imagealign': 'C',
                        'originalurl': value.originalurl,
                        'thumburl': value.thumburl,
                        'mimeType': value.mime_type,
                        'imageWidth': value.image_width,
                        'width': parseInt(imgW),
                        'height': parseInt(imgH),

                    };
                    execAttach(_mockdata);
                });
				$("#attachFile").val('');
				$("#msg").html("<font color='red'>사진이 등록되었습니다.</font>");
				closeWindow();


			} else {
				alert(response.msg) ;
				// TODO 실패에 따른 처리
			}
		},
		//ajax error
		error: function(){
			alert("에러발생!!");
		}
	});
	//폼전송
	$("#attachFile").click(function(){
		if($(this).val() == "") $("#msg").text("사진 첨부 확인");
	});
});
</script>
</head>
<body onload="initUploader();">
<div class="wrapper">
	<div class="header">
		<h1>
		<div style="padding: 80px 0 0 0;">사진 첨부</div></h1>
	</div>
	<div class="body">
		<div class="txt-info">
		
		파일선택을 누르시면 <br>사진을 첨부 하실수 있습니다
		</div>
		<Form name="ajaxform" id="ajaxform"  method="post"  action="/ajax/board/gallery_file_upload"  enctype="multipart/form-data">
					<Input Type="file" name="attachFile[]" id="attachFile" size='30' multiple>
					<input type="hidden" id="attachType" name="attachType[]" value="image" />
				</Form>
	</div>
	<div class="footer">
		<!--	<p><a href="#" onclick="closeWindow();" title="닫기" class="close">닫기</a></p> -->
		<ul>
<!--			<li class="submit"><a href="#" onclick="done();" title="등록" class="btnlink">등록</a> </li>-->
			<li class="submit"><a href="#" id="submit" title="등록" class="btnlink">등록</a> </li>
			<li class="cancel"><a href="#" onclick="closeWindow();" title="취소" class="btnlink">취소</a></li>
		</ul>
	</div>
</div>
</body>
</html>