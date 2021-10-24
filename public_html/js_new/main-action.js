(function($){
$(document).ready(function () {


//////////////////////////////// 팝업 사라지기 ////////

		//   $('#hclose').click(function(){
		//	   $('#hpopup').hide(100);
		//   });






/////////////2초마다 실행되는 함수 /////


setInterval(function() {
 var bodyWidth = 70;
  var bodyHeight = 80;
  var randPosX = Math.floor((Math.random()*bodyWidth));
  var randPosY = Math.floor((Math.random()*bodyHeight));
  //var posLog = document.getElementById('pos_log');
  //var posXY = 'x: ' + randPosX + '<br />' + 'y: ' + randPosY;
  $('#rand_pos').animate({'left':randPosX-70},800).animate({'top':randPosY-80},800);
  }, 1000);
});





$('.rect').on({
 mouseenter: function(){
 var bodyWidth = 70;
  var bodyHeight = 80;
  var randPosX = Math.floor((Math.random()*bodyWidth));
  var randPosY = Math.floor((Math.random()*bodyHeight));
  //var posLog = document.getElementById('pos_log');
  //var posXY = 'x: ' + randPosX + '<br />' + 'y: ' + randPosY;
  $('#rand_pos').animate({'left':randPosX-70},800).animate({'top':randPosY-80},800);
  }
});

$('.rect').on({
 mouseleave: function(){
 var bodyWidth = 70;
  var bodyHeight = 80;
  var randPosX = Math.floor((Math.random()*bodyWidth));
  var randPosY = Math.floor((Math.random()*bodyHeight));
  //var posLog = document.getElementById('pos_log');
  //var posXY = 'x: ' + randPosX + '<br />' + 'y: ' + randPosY;
  $('#rand_pos').animate({'left':randPosX-70},{'top':randPosY-80},800);
  //$('#rand_pos').animate({'top':randPosY-80},800); 
  }
});


 $("#toraybook").on({
 mouseenter: function () {
  var bodyWidth = 70;
  var bodyHeight = 80;
  var randPosX = Math.floor((Math.random()*bodyWidth));
  var randPosY = Math.floor((Math.random()*bodyHeight));
  var posLog = document.getElementById('pos_log');
  var posXY = 'x: ' + randPosX + '<br />' + 'y: ' + randPosY;
  $('#rand_pos').animate({'left':randPosX-70},800);
  $('#rand_pos').animate({'top':randPosY-80},800); 
  posLog.innerHTML = posXY
 }
});



$('.rect').everyTime(2000, function(){
				$(this).animate({'opacity':0},800).animate({'opacity':1},800);
			});


$('.new_pos').click(function() {

  var bodyWidth = document.body.clientWidth;
  var bodyHeight = document.body.clientHeight;
  var randPosX = Math.floor((Math.random()*bodyWidth));
  var randPosY = Math.floor((Math.random()*bodyHeight));
  var posLog = document.getElementById('pos_log');
  var posXY = 'x: ' + randPosX + '<br />' + 'y: ' + randPosY;
  $('#rand_pos').css('left', randPosX);
  $('#rand_pos').css('top', randPosY); 
  posLog.innerHTML = posXY

});




});




})(jQuery);


