$(function(){
  $(document).on('click','.globalClose',function(){
    $(this).parent().parent().parent().remove();
  })
  $(document).on('click','#quit',function(){
    $.ajax({
      type: 'post',
      url: '../sign_in/server/log_out.php'
    }).done(function(data){
      location.reload(true);
    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })
  $(document).on('click','.helper',function(){
    $(this).stop();
    $(this).hide();
  })
  $(document).on('click','.emptyCode',function(){
    showHelper('No Function Yet!','#ffd700');
  })
  $(document).on('click','#masterList',function(){
    $.ajax({
      type: 'post',
      url: 'window/masterList.php'
    }).done(function(data){
      $('.windowDialog').remove();
      $('.windowArea').append(data);
      setDragggable('#masterListWindow');
      indexRow($('.materialList').eq(0).attr('id'));
    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })
  $(document).on('click','#materialReceived',function(){
    $.ajax({
      type: 'post',
      url: 'window/materialReceived.php'
    }).done(function(data){
      var receivedIndex = 0;
      $('.windowDialog').remove();
      $('.windowArea').append(data);
      setDragggable('#materialReceivedWindow');
      indexRow($('.receivedList').eq(0).attr('id'));
      if($('.selected').eq(0).attr('id')){
        receivedIndex = $('.selected').attr('id').split('_')[1];
      }
      receivedContent(receivedIndex);
    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })
  $(document).on('click','#materialReleased',function(){
    $.ajax({
      type: 'post',
      url: 'window/materialReleased.php'
    }).done(function(data){
      var risId = 0;
      $('.windowDialog').remove();
      $('.windowArea').append(data);
      setDragggable('#materialReleasedWindow');
      indexRow($('.releasedList').eq(0).attr('id'));
      if($('.selected').eq(0).attr('id')){
        risId = $('.selected').attr('id').split('_')[1];
      }
      releasedContent(risId);
    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })
  $(document).on('click','#materialReturned',function(){
    $.ajax({
      type: 'post',
      url: 'window/materialReturned.php'
    }).done(function(data){
      var rnId = 0;
      $('.windowDialog').remove();
      $('.windowArea').append(data);
      setDragggable('#materialReturnedWindow');
      indexRow($('.returnedList').eq(0).attr('id'));
      if($('.selected').eq(0).attr('id')){
        rnId = $('.selected').attr('id').split('_')[1];
      }
      returnedContent(rnId);
    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })
  $(document).on('mouseover','.windowArea, .menuItem',function(){
    $('.menuItem').removeClass('menuActive');
    $('.menuContent').hide();
  })
  $(document).on('mouseover','#report',function(){
    $('.menuContent').load('server/menuReport.php');
    $(this).addClass('menuActive');
    $('.menuContent').css({
      top: $('.menu').innerHeight() + 2,
      minWidth: $(this).innerWidth(),
      left: $(this).offset().left + 1
    });
    $('.menuContent').show();
  })
  $(document).on('mouseover','#others',function(){
    $('.menuContent').load('server/menuOthers.php');
    $(this).addClass('menuActive');
    $('.menuContent').css({
      top: $('.menu').innerHeight() + 2,
      minWidth: $(this).innerWidth(),
      left: $(this).offset().left + 1
    });
    $('.menuContent').show();
  })


  setWindowArea();
})

$('.helper').hide();
$('.menuContent').hide();
window.setInterval( function() {
    $.ajax({
        cache: false,
        type: "GET",
        url: "../sign_in/server/refresh_session.php",
        success: function(data) {
        }
    });
}, 60000 );
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode = 47 && (charCode < 46 || charCode > 57)) {
        return false;
    }
    return true;
}
function setWindowArea(){
  $('.windowArea').height($('.windowArea').offset().top - ($('.menu').innerHeight() + 2));
  $('.windowArea').css({'position':'relative', 'top':$('.menu').innerHeight() + 2});
}
function showHelper(msg,color){
  $('.helper').stop();
  $('.helper').html(msg);
  $('.helper').css({'color':color});
  $('.helper').show(0);
  $('.helper').hide("fade", 10000);
}
function setDragggable(window){
  $(window).draggable({
    cancel: ".windowClose",
    cursor: "move",
    handle: ".windowHead",
    containment: "parent",
  });
  var top = ($('.windowArea').height() - $(window).height()) / 2;
  var left = ($('.windowArea').width() - $(window).width()) / 2;
  $(window).css({
    top: top,
    left: left
  })
}
function setWindowBack(window, offset){
  $(window).css({ zIndex: '-1' });
  $(window).animate({ top: $('.menu').innerHeight() + 2 + offset },100);
  $(window).animate({ left: offset },100)
}
function setWindowFront(window){
  var top = ($('.windowArea').height() - $(window).height()) / 2;
  var left = ($('.windowArea').width() - $(window).width()) / 2;
  $(window).css({ zIndex: '0' });
  $(window).animate({ left: left },100);
  $(window).animate({ top: top },100);
}
function indexRow(row){
  $('.selected').children().eq(0).html('');
  $('.selected').removeClass('selected');
  $('#' + row).children().eq(0).html('<span class="glyphicon glyphicon-chevron-right index"></span>');
  $('#' + row).addClass('selected');
}
function indexRow2(row){
  $('.selected2').children().eq(0).html('');
  $('.selected2').removeClass('selected2');
  $('#' + row).children().eq(0).html('<span class="glyphicon glyphicon-chevron-right index"></span>');
  $('#' + row).addClass('selected2');
}
function indexRow3(row){
  $('.selected3').children().eq(0).html('');
  $('.selected3').removeClass('selected3');
  $('#' + row).children().eq(0).html('<span class="glyphicon glyphicon-chevron-right index"></span>');
  $('#' + row).addClass('selected3');
}
