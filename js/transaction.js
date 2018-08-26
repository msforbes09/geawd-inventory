$(function(){
  $(document).on('click','.itemList',function(){//select item
    indexRow3($(this).attr('id'));
  })
  $(document).on('keypress','#text_itemQuantity',function(){//disable character input
    return isNumber(event);
  })
  $(document).on('keyup','#text_itemSearch',function(){//search item
    var keyWord = $(this).val();

    $.ajax({
      type: 'post',
      url: 'server/index_masterList.php',
      data: {
        keyWord: keyWord
      }
    }).done(function(data){
      if(data){
        var itemIndex = 'item_' + data;
        indexRow3(itemIndex);
        $('.container_itemList').animate({scrollTop:$('.selected3').offset().top - $('.itemList').offset().top},250);
      } else {
        showHelper('No Matched Found!','#ffd700');
      }
    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })
  $(document).on('keyup','#text_itemReturnSearch',function(){//search item
    var keyWord = $(this).val();
    var rnId = $('.selected').attr('id').split('_')[1];

    $.ajax({
      type: 'post',
      url: 'server/indexReturn_masterList.php',
      data: {
        rnId: rnId,
        keyWord: keyWord
      }
    }).done(function(data){
      if(data){
        var itemIndex = 'item_' + data;
        indexRow3(itemIndex);
        $('.container_itemList').animate({scrollTop:$('.selected3').offset().top - $('.itemList').offset().top},250);
      } else {
        showHelper('No Matched Found!','#ffd700');
      }
    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })

})
