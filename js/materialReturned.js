$(function(){
  $(document).on('click','.returnedList',function(){//select item
    indexRow($(this).attr('id'));
    var rnId = $(this).attr('id').split('_')[1];
    returnedContent(rnId);
  })
  $(document).on('change','#text_rnDate',function(){//filter list
    index_materialRn('rnDate',$(this).val());
  })
  $(document).on('keyup','#text_rnNo',function(){//filter list
    index_materialRn('rnNo',$(this).val());
  })
  $(document).on('click','#print_materialRn',function(){//print rn
    $.ajax({
      type: 'post',
      url: 'report/materialRn.php'
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
  $(document).on('click','#newRn',function(){//show add rn form
    $.ajax({
      type: 'post',
      url: 'window/newRn.php'
    }).done(function(data){
      setWindowBack('#materialReturnedWindow',0);
      $('#windowReturned').remove();
      $('.windowArea').append(data);
      setDragggable('#windowReturned');
      $('#inputRnNo').select();
    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })
  $(document).on('click','.close_windowReturned',function(){//close window
    close_windowReturned();
  })
  $(document).on('keypress','#inputRnNo',function(){//disable character input
    evt = (event) ? event : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 45 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
  })
  $(document).on('click','#addRn',function(){//save rn
    var rnNo = $('#inputRnNo').val().trim();
    var rnDate = $('#inputRnDate').val();
    var returnedBy = $('#selectReturnedBy').val();
    var receivedBy = $('#selectReceivedBy').val();
    var risId = $('#selectRisNo').val();

    if(rnNo.length < 11 || rnNo.split('-').length != 2 || rnNo.indexOf('-') != 4 || returnedBy == 0 || receivedBy == 0 || risId == 0){
      showHelper('Incomplete/Invalid Input!','#ffd700');
      $('#inputRisNo').select();
      return false;
    }

    $.ajax({
      type: 'post',
      url: 'server/save_materialRn.php',
      data:{
        rnNo: rnNo,
        rnDate: rnDate,
        returnedBy: returnedBy,
        receivedBy: receivedBy,
        risId: risId
      }
    }).done(function(data){
      if(data.length > 10){
        showHelper(data,'#ffd700');
        return false;
      }
      showHelper('Saved Successfully!','#00ffff');
      returnedContent(data);
      read_materialReturned('rn_' + data);
      read_materialRn(data);
    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })
  $(document).on('click','.rnList',function(){//select item
    indexRow2($(this).attr('id'));
  })
  $(document).on('click','#add_returnedItem',function(){//show add item form
    var rnId = $('.selected').attr('id').split('_')[1];

    $.ajax({
      type: 'post',
      url: 'window/newReturnedItem.php',
      data: {
        rnId: rnId
      }
    }).done(function(data){
      setWindowBack('#windowReturned',30);
      $('#windowRn').remove();
      $('.windowArea').append(data);
      setDragggable('#windowRn');
    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })
  $(document).on('click','.close_windowRn',function(){//close window
    close_windowRn();
  })
  $(document).on('click','#viewRn',function(){//show rn window
    var rnId = $('.selected').attr('id');
    if(!rnId){
      showHelper('No Selected Item!','#ffd700');
      return false;
    }
    $('.containerTransaction').animate({scrollTop:$('.selected').offset().top - $('.returnedList').offset().top},250);
    setWindowBack('#materialReturnedWindow',0);
    read_materialRn(rnId.split('_')[1]);
  })
  $(document).on('click','#save_returnedItem',function(){//save returned item
    var rnId = $('.selected').attr('id').split('_')[1];
    var itemId = $('.selected3').attr('id');
    var quantity = parseInt($('#text_itemQuantity').val());

    if(!itemId){
      showHelper('No Selected Item!','#ffd700');
      return false;
    }
    if(isNaN(quantity) || quantity <= 0){
      showHelper('Invalid Quantity!','#ffd700');
      $('#text_itemQuantity').select();
      return false;
    }

    $.ajax({
      type: 'post',
      url: 'server/save_returnedItem.php',
      data:{
        rnId: rnId,
        itemId: itemId.split('_')[1],
        quantity: quantity
      }
    }).done(function(data){
      if(data.length > 10){
        showHelper(data,'#ffd700');
        return false;
      }
      showHelper('Saved Successfully!','#00ffff');
      read_rnContent('returnedContent_' + data);
      $('.selected3').children().eq(0).html('');
      $('.selected3').removeClass('selected3');
      $('#text_itemQuantity').val(0);
      $('#text_itemReturnSearch').val('');
    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })
  $(document).on('click','#print_returnedItem',function(){//print rn
    var rnId = $('.selected').attr('id').split('_')[1];

    $.ajax({
      type: 'post',
      url: 'report/materialReturned.php',
      data: {
        rnId: rnId
      }
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
  $(document).on('click','#remove_returnedItem',function(){//confirm delete
    var itemId = $('.selected2').attr('id');
    if(!itemId){
      showHelper('No Selected Item!','#ffd700');
      return false;
    }

    $.ajax({
      type: 'post',
      url: 'window/removeReturnedItem.php'
    }).done(function(data){
      $('#' + itemId).addClass('selectedDelete');
      $('.containerRnContent').animate({scrollTop:$('.selected2').offset().top - $('.rnList').offset().top},250);
      setWindowBack('#windowReturned',30);
      $('#windowRn').remove();
      $('.windowArea').append(data);
      setDragggable('#windowRn');
    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })
  $(document).on('click','#cancel_removeReturned',function(){//hide confirmation
    close_windowRn();
  })
  $(document).on('click','#confirm_removeReturned',function(){//remove item from the list
    var itemId = $('.selected2').attr('id');

    $.ajax({
      type: 'post',
      url: 'server/remove_returnedItem.php',
      data:{
        itemIndex: itemId.split('_')[1]
      }
    }).done(function(data){
      if(data){
        showHelper(data,'#ffd700');
        return false;
      }
      showHelper('Removed Successfully!','#00ffff');
      close_windowRn();
      if($('.selected2').next().attr('id')){
        itemId = $('.selected2').next().attr('id');
      } else if($('.selected2').prev().attr('id')) {
        itemId = $('.selected2').prev().attr('id');
      }
      read_rnContent(itemId);
    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })
  $(document).on('click','#edit_returnedItem',function(){//show add item form
    var itemId = $('.selected2').attr('id');
    var rnId = $('.selected').attr('id').split('_')[1];

    if(!itemId){
      showHelper('No Selected Item!','#ffd700');
      return false;
    }

    $.ajax({
      type: 'post',
      url: 'window/updateReturnedItem.php',
      data:{
        rnId: rnId,
        returnId : itemId.split('_')[1]
      }
    }).done(function(data){
      $('.containerRnContent').animate({scrollTop:$('.selected2').offset().top - $('.rnList').offset().top},250);
      setWindowBack('#windowReturned',30);
      $('#windowRn').remove();
      $('.windowArea').append(data);
      setDragggable('#windowRn');
      var itemId = $('.selected3').attr('id');
      $('.container_itemList').animate({scrollTop:$('.selected3').offset().top - $('.itemList').offset().top},0);
      indexRow3(itemId);

    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })
  $(document).on('click','#update_returnedItem',function(){//update released item
    var returnId = $('.selected2').attr('id');
    var itemId = $('.selected3').attr('id');
    var quantity = parseInt($('#text_itemQuantity').val());

    if(!itemId){
      showHelper('No Selected Item!','#ffd700');
      return false;
    }
    if(isNaN(quantity) || quantity <= 0){
      showHelper('Invalid Quantity!','#ffd700');
      $('#text_itemQuantity').select();
      return false;
    }

    $.ajax({
      type: 'post',
      url: 'server/update_returnedItem.php',
      data:{
        returnId: returnId.split('_')[1],
        itemId: itemId.split('_')[1],
        quantity: quantity
      }
    }).done(function(data){
      if(data){
        showHelper(data,'#ffd700');
        return false;
      }

      showHelper('Updated Successfully!','#00ffff');
      close_windowRn();
      read_rnContent(returnId);
    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })
  $(document).on('click','#removeRn',function(){//confirm delete
    var rnId = $('.selected').attr('id');
    if(!rnId){
      showHelper('No Selected Item!','#ffd700');
      return false;
    }

    $.ajax({
      type: 'post',
      url: 'window/removeRn.php'
    }).done(function(data){
      $('#' + rnId).addClass('selectedDelete');
      $('.containerTransaction').animate({scrollTop:$('.selected').offset().top - $('.returnedList').offset().top},250);
      setWindowBack('#materialReturnedWindow',0);
      $('#windowReturned').remove();
      $('.windowArea').append(data);
      setDragggable('#windowReturned');
    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })
  $(document).on('click','#cancel_removeRn',function(){//hide confirmation
    close_windowReturned();
  })
  $(document).on('click','#confirm_removeRn',function(){//remove item from the list
    var rnId = $('.selected').attr('id');

    $.ajax({
      type: 'post',
      url: 'server/remove_rn.php',
      data:{
        rnId: rnId.split('_')[1]
      }
    }).done(function(data){
      if(data){
        showHelper(data,'#ffd700');
        return false;
      }
      showHelper('Removed Successfully!','#00ffff');
      close_windowReturned();
      if($('.selected').next().attr('id')){
        rnId = $('.selected').next().attr('id');
      } else if($('.selected').prev().attr('id')) {
        rnId = $('.selected').prev().attr('id');
      }
      read_materialReturned(rnId);
    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })
  $(document).on('click','#editRn',function(){//show edit ris form
    var rnId = $('.selected').attr('id');
    if(!rnId){
      showHelper('No Selected Item!','#ffd700');
      return false;
    }

    $.ajax({
      type: 'post',
      url: 'window/updateRn.php',
      data: {
        rnId: rnId.split('_')[1]
      }
    }).done(function(data){
      $('.containerTransaction').animate({scrollTop:$('.selected').offset().top - $('.returnedList').offset().top},250);
      setWindowBack('#materialReturnedWindow',0);
      $('#windowReturned').remove();
      $('.windowArea').append(data);
      setDragggable('#windowReturned');
      $('#inputRnNo').select();
    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })



})
function close_windowReturned(){
  $('#windowReturned').remove();
  setWindowFront('#materialReturnedWindow');
  if($('.selected').attr('id')){
    var rnId = $('.selected').attr('id');
    $('#' + rnId).removeClass('selectedDelete');
  }
}
function close_windowRn(){
  $('#windowRn').remove();
  setWindowFront('#windowReturned');
  if($('.selected2').attr('id')){
    var itemId = $('.selected2').attr('id');
    $('#' + itemId).removeClass('selectedDelete');
  }
}
function index_materialRn(row, keyWord){
  $.ajax({
    type: 'post',
    url: 'server/index_materialRn.php',
    data: {
      row: row,
      keyWord: keyWord
    }
  }).done(function(data){
    if(data){
      var rnId = 'rn_' + data;
      indexRow(rnId);
      $('.containerTransaction').animate({scrollTop:$('.selected').offset().top - $('.returnedList').offset().top},250);
      returnedContent(data);
    } else {
      showHelper('No Matched Found!','#ffd700');
    }
  }).fail(function(data){
    alert('Something went wrong!!!');
  })
}
function returnedContent(rnId){
  $.ajax({
    type: 'post',
    url: 'server/read_returnedContent.php',
    data: {
      rnId: rnId
    }
  }).done(function(data){
    $('#bodyReturnedContent').html(data);
  }).fail(function(data){
    alert('Something went wrong!!!');
  })
}
function read_materialReturned(row){
  $.ajax({
    type: 'post',
    url: 'server/read_materialReturned.php'
  }).done(function(data){
    $('#bodyMaterialReturned').html(data);
    indexRow(row);
    $('.containerTransaction').animate({scrollTop:$('.selected').offset().top - $('.returnedList').offset().top},250);
  }).fail(function(data){
    alert('Something went wrong!!!');
  })
}
function read_materialRn(rnId){
  $.ajax({
    type: 'post',
    url: 'window/materialRn.php',
    data: {
      rnId : rnId
    }
  }).done(function(data){
    $('#windowReturned').remove();
    $('.windowArea').append(data);
    setDragggable('#windowReturned');
    indexRow2($('.rnList').eq(0).attr('id'));
  }).fail(function(data){
    alert('Something went wrong!!!');
  })
}
function read_rnContent(returnId){
  var rnId = $('.selected').attr('id').split('_')[1];
  $.ajax({
    type: 'post',
    url: 'server/read_rnContent.php',
    data: {
      rnId : rnId
    }
  }).done(function(data){
    $('#bodyRnContent').html(data);
    returnedContent(rnId);
    indexRow2(returnId);
    $('.containerRnContent').animate({scrollTop:$('.selected2').offset().top - $('.rnList').offset().top},250);
  }).fail(function(data){
    alert('Something went wrong!!!');
  })
}
