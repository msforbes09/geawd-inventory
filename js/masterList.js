$(function(){
  $(document).on('click','.materialList',function(){//select item
    indexRow($(this).attr('id'));
  })
  $(document).on('keyup','#searchText',function(){//search item
    var keyWord = $(this).val();

    $.ajax({
      type: 'post',
      url: 'server/index_masterList.php',
      data: {
        keyWord: keyWord
      }
    }).done(function(data){
      if(data){
        var itemIndex = 'list_' + data;
        indexRow(itemIndex);
        $('.container_masterList').animate({scrollTop:$('.selected').offset().top - $('.materialList').offset().top},500);
      } else {
        showHelper('No Matched Found!','#ffd700');
      }
    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })
  $(document).on('click','#print_masterList',function(){//print materlist
    $.ajax({
      type: 'post',
      url: 'report/masterList.php'
    }).done(function(data){
      $('.face').hide(0);
      $('.printArea').html(data);
      window.print();
      $('.face').show(0);
      $('.printArea').html('');
    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })
  $(document).on('click','.close_windowMaterial',function(){//close window
    close_windowMaterial();
  })
  $(document).on('click','#newMaterial',function(){//show add form
    $.ajax({
      type: 'post',
      url: 'window/newMaterial.php'
    }).done(function(data){
      setWindowBack('#masterListWindow',0);
      $('#windowMaterial').remove();
      $('.windowArea').append(data);
      setDragggable('#windowMaterial');
      $('#textStock').select();
    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })
  $(document).on('keypress','#textBalance, #textReorder',function(){//disable character input
    return isNumber(event);
  })
  $(document).on('click','#addMaterial',function(){//save material
    $('#textStock').select();
    var stockNo = $('#textStock').val().trim();
    var unit = $('#selectUnit').val();
    var itemDesc = $('#text_itemDesc').val().trim();
    var balance = parseInt($('#textBalance').val());
    var reorder = parseInt($('#textReorder').val());

    if(stockNo.length == 0 || unit == 0 || itemDesc.length == 0 || isNaN(balance) || balance <= 0 || isNaN(reorder) || reorder <= 0){
      showHelper('Incomplete/Invalid Input!','#ffd700');
      return false;
    }

    $.ajax({
      type: 'post',
      url: 'server/save_materialList.php',
      data:{
        stockNo: stockNo,
        unit: unit,
        itemDesc: itemDesc,
        balance: balance,
        reorder: reorder
      }
    }).done(function(data){
      if(data.length > 10){
        showHelper(data,'#ffd700');
        return false;
      }
      showHelper('Saved Successfully!','#00ffff');
      read_masterList('list_' + data);
      $('#textStock, #text_itemDesc').val('');
      $('#selectUnit, #textBalance, #textReorder').val(0);
    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })
  $(document).on('click','#removeMaterial',function(){//confirm delete
    var itemId = $('.selected').attr('id');
    if(!itemId){
      showHelper('No Selected Item!','#ffd700');
      return false;
    }

    $.ajax({
      type: 'post',
      url: 'window/removeMaterial.php'
    }).done(function(data){
      $('#' + itemId).addClass('selectedDelete');
      $('.container_masterList').animate({scrollTop:$('.selected').offset().top - $('.materialList').offset().top},250);
      setWindowBack('#masterListWindow',0);
      $('#windowMaterial').remove();
      $('.windowArea').append(data);
      setDragggable('#windowMaterial');
    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })
  $(document).on('click','#cancel_removeMaterial',function(){//hide confirmation
    close_windowMaterial();
  })
  $(document).on('click','#confirm_removeMaterial',function(){//remove item from the list
    var itemId = $('.selected').attr('id');

    $.ajax({
      type: 'post',
      url: 'server/remove_materialList.php',
      data:{
        itemIndex: itemId.split('_')[1]
      }
    }).done(function(data){
      if(data){
        showHelper(data,'#ffd700');
        return false;
      }
      showHelper('Removed Successfully!','#00ffff');
      close_windowMaterial();
      if($('.selected').next().attr('id')){
        itemId = $('.selected').next().attr('id');
      } else if($('.selected').prev().attr('id')) {
        itemId = $('.selected').prev().attr('id');
      }
      read_masterList(itemId);
    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })
  $(document).on('click','#updateMaterial',function(){//show update form
    var itemId = $('.selected').attr('id');
    if(!itemId){
      showHelper('No Selected Item!','#ffd700');
      return false;
    }

    $.ajax({
      type: 'post',
      url: 'window/updateMaterial.php',
      data: {
        itemIndex: itemId.split('_')[1]
      }
    }).done(function(data){
      $('.container_masterList').animate({scrollTop:$('.selected').offset().top - $('.materialList').offset().top},250);
      setWindowBack('#masterListWindow',0);
      $('#windowMaterial').remove();
      $('.windowArea').append(data);
      setDragggable('#windowMaterial');
      $('#textStock').select();
    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })
  $(document).on('click','#editMaterial',function(){//edit material
    var itemId = $('.selected').attr('id');
    var stockNo = $('#textStock').val().trim();
    var unit = $('#selectUnit').val();
    var itemDesc = $('#text_itemDesc').val().trim();
    var balance = parseInt($('#textBalance').val());
    var reorder = parseInt($('#textReorder').val());

    if(stockNo.length == 0 || itemDesc.length == 0 || isNaN(balance) || balance <= 0 || isNaN(reorder) || reorder <= 0){
      showHelper('Incomplete/Invalid Input!','#ffd700');
      $('#textStock').select();
      return false;
    }

    $.ajax({
      type: 'post',
      url: 'server/update_materialList.php',
      data:{
        stockNo: stockNo,
        unit: unit,
        itemDesc: itemDesc,
        balance: balance,
        reorder: reorder,
        itemIndex: itemId.split('_')[1]
      }
    }).done(function(data){
      if(data){
        showHelper(data,'#ffd700');
        $('#textStock').select();
        return false;
      }
      showHelper('Updated Successfully!','#00ffff');
      close_windowMaterial();
      read_masterList(itemId);
    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })
})
function close_windowMaterial(){
  $('#windowMaterial').remove();
  setWindowFront('#masterListWindow');
  if($('.selected').attr('id')){
    var itemId = $('.selected').attr('id');
    $('#' + itemId).removeClass('selectedDelete');
  }
}
function read_masterList(row){
  $.ajax({
    type: 'post',
    url: 'server/read_masterList.php'
  }).done(function(data){
    $('#body_masterList').html(data);
    indexRow(row);
    $('.container_masterList').animate({scrollTop:$('.selected').offset().top - $('.materialList').offset().top},250);
  }).fail(function(data){
    alert('Something went wrong!!!');
  })
  $.ajax({
    type: 'post',
    url: 'server/read_materialTotal.php'
  }).done(function(data){
    $('.displayGroup').html(data);
  }).fail(function(data){
    alert('Something went wrong!!!');
  })
}
