$(function(){
  $(document).on('click','.releasedList',function(){//select item
    indexRow($(this).attr('id'));
    var risId = $(this).attr('id').split('_')[1];
    releasedContent(risId);
  })
  $(document).on('change','#text_risDate',function(){//filter list
    index_materialRis('risDate',$(this).val());
  })
  $(document).on('keyup','#text_risNo',function(){//filter list
    index_materialRis('risNo',$(this).val());
  })
  $(document).on('click','#print_materialRis',function(){//print ris
    $.ajax({
      type: 'post',
      url: 'report/materialRis.php'
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
  $(document).on('click','#newRis',function(){//show add ris form
    $.ajax({
      type: 'post',
      url: 'window/newRis.php'
    }).done(function(data){
      setWindowBack('#materialReleasedWindow',0);
      $('#windowReleased').remove();
      $('.windowArea').append(data);
      setDragggable('#windowReleased');
      $('#inputRisNo').select();
    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })
  $(document).on('click','.close_windowReleased',function(){//close window
    close_windowReleased();
  })
  $(document).on('keypress','#inputRisNo',function(){//disable character input
    evt = (event) ? event : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 45 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
  })
  $(document).on('click','#addRis',function(){//save ris
    var risNo = $('#inputRisNo').val().trim();
    var risDate = $('#inputRisDate').val();
    var issuedBy = $('#selectIssuedBy').val();
    var receivedBy = $('#selectReceivedBy').val();
    var purpose = $('#textPurpose').val().trim();

    if(risNo.length < 11 || risNo.split('-').length != 2 || risNo.indexOf('-') != 4 || issuedBy == 0 || receivedBy == 0){
      showHelper('Incomplete/Invalid Input!','#ffd700');
      $('#inputRisNo').select();
      return false;
    }

    $.ajax({
      type: 'post',
      url: 'server/save_materialRis.php',
      data:{
        risNo: risNo,
        risDate: risDate,
        issuedBy: issuedBy,
        receivedBy: receivedBy,
        purpose: purpose
      }
    }).done(function(data){
      if(data.length > 10){
        showHelper(data,'#ffd700');
        return false;
      }
      showHelper('Saved Successfully!','#00ffff');
      releasedContent(data);
      read_materialReleased('ris_' + data);
      read_materialRis(data);
    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })
  $(document).on('click','.risList',function(){//select item
    indexRow2($(this).attr('id'));
  })
  $(document).on('click','#add_releasedItem',function(){//show add item form
    $.ajax({
      type: 'post',
      url: 'window/newReleasedItem.php'
    }).done(function(data){
      setWindowBack('#windowReleased',30);
      $('#windowRis').remove();
      $('.windowArea').append(data);
      setDragggable('#windowRis');
    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })
  $(document).on('click','.close_windowRis',function(){//close window
    close_windowRis();
  })
  $(document).on('click','#viewRis',function(){//show ris window
    var risId = $('.selected').attr('id');
    if(!risId){
      showHelper('No Selected Item!','#ffd700');
      return false;
    }
    $('.containerTransaction').animate({scrollTop:$('.selected').offset().top - $('.releasedList').offset().top},250);
    setWindowBack('#materialReleasedWindow',0);
    read_materialRis(risId.split('_')[1]);
  })
  $(document).on('click','#save_releasedItem',function(){//save released item
    var risId = $('.selected').attr('id').split('_')[1];
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
      url: 'server/save_releasedItem.php',
      data:{
        risId: risId,
        itemId: itemId.split('_')[1],
        quantity: quantity
      }
    }).done(function(data){
      if(data.length > 10){
        showHelper(data,'#ffd700');
        return false;
      }
      showHelper('Saved Successfully!','#00ffff');
      read_risContent('releasedContent_' + data);
      $('.selected3').children().eq(0).html('');
      $('.selected3').removeClass('selected3');
      $('#text_itemQuantity').val(0);
      $('#text_itemSearch').val('');
    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })
  $(document).on('click','#print_releasedItem',function(){//print ris
    var risId = $('.selected').attr('id').split('_')[1];

    $.ajax({
      type: 'post',
      url: 'report/materialReleased.php',
      data: {
        risId: risId
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
  $(document).on('click','#remove_releasedItem',function(){//confirm delete
    var itemId = $('.selected2').attr('id');
    if(!itemId){
      showHelper('No Selected Item!','#ffd700');
      return false;
    }

    $.ajax({
      type: 'post',
      url: 'window/removeReleasedItem.php'
    }).done(function(data){
      $('#' + itemId).addClass('selectedDelete');
      $('.containerRisContent').animate({scrollTop:$('.selected2').offset().top - $('.risList').offset().top},250);
      setWindowBack('#windowReleased',30);
      $('#windowRis').remove();
      $('.windowArea').append(data);
      setDragggable('#windowRis');
    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })
  $(document).on('click','#cancel_removeReleased',function(){//hide confirmation
    close_windowRis();
  })
  $(document).on('click','#confirm_removeReleased',function(){//remove item from the list
    var itemId = $('.selected2').attr('id');

    $.ajax({
      type: 'post',
      url: 'server/remove_releasedItem.php',
      data:{
        itemIndex: itemId.split('_')[1]
      }
    }).done(function(data){
      if(data){
        showHelper(data,'#ffd700');
        return false;
      }
      showHelper('Removed Successfully!','#00ffff');
      close_windowRis();
      if($('.selected2').next().attr('id')){
        itemId = $('.selected2').next().attr('id');
      } else if($('.selected2').prev().attr('id')) {
        itemId = $('.selected2').prev().attr('id');
      }
      read_risContent(itemId);
    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })
  $(document).on('click','#edit_releasedItem',function(){//show add item form
    var itemId = $('.selected2').attr('id');
    if(!itemId){
      showHelper('No Selected Item!','#ffd700');
      return false;
    }

    $.ajax({
      type: 'post',
      url: 'window/updateReleasedItem.php',
      data:{
        releaseId : itemId.split('_')[1]
      }
    }).done(function(data){
      $('.containerRisContent').animate({scrollTop:$('.selected2').offset().top - $('.risList').offset().top},250);
      setWindowBack('#windowReleased',30);
      $('#windowRis').remove();
      $('.windowArea').append(data);
      setDragggable('#windowRis');
      var itemId = $('.selected3').attr('id');
      $('.container_itemList').animate({scrollTop:$('.selected3').offset().top - $('.itemList').offset().top},0);
      indexRow3(itemId);

    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })
  $(document).on('click','#update_releasedItem',function(){//update released item
    var releaseId = $('.selected2').attr('id');
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
      url: 'server/update_releasedItem.php',
      data:{
        releaseId: releaseId.split('_')[1],
        itemId: itemId.split('_')[1],
        quantity: quantity
      }
    }).done(function(data){
      if(data){
        showHelper(data,'#ffd700');
        return false;
      }

      showHelper('Updated Successfully!','#00ffff');
      close_windowRis();
      read_risContent(releaseId);
    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })
  $(document).on('click','#removeRis',function(){//confirm delete
    var risId = $('.selected').attr('id');
    if(!risId){
      showHelper('No Selected Item!','#ffd700');
      return false;
    }

    $.ajax({
      type: 'post',
      url: 'window/removeRis.php'
    }).done(function(data){
      $('#' + risId).addClass('selectedDelete');
      $('.containerTransaction').animate({scrollTop:$('.selected').offset().top - $('.releasedList').offset().top},250);
      setWindowBack('#materialReleasedWindow',0);
      $('#windowReleased').remove();
      $('.windowArea').append(data);
      setDragggable('#windowReleased');
    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })
  $(document).on('click','#cancel_removeRis',function(){//hide confirmation
    close_windowReleased();
  })
  $(document).on('click','#confirm_removeRis',function(){//remove item from the list
    var risId = $('.selected').attr('id');

    $.ajax({
      type: 'post',
      url: 'server/remove_ris.php',
      data:{
        risId: risId.split('_')[1]
      }
    }).done(function(data){
      if(data){
        showHelper(data,'#ffd700');
        return false;
      }
      showHelper('Removed Successfully!','#00ffff');
      close_windowReleased();
      if($('.selected').next().attr('id')){
        risId = $('.selected').next().attr('id');
      } else if($('.selected').prev().attr('id')) {
        risId = $('.selected').prev().attr('id');
      }
      read_materialReleased(risId);
    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })
  $(document).on('click','#editRis',function(){//show edit ris form
    var risId = $('.selected').attr('id');
    if(!risId){
      showHelper('No Selected Item!','#ffd700');
      return false;
    }

    $.ajax({
      type: 'post',
      url: 'window/updateRis.php',
      data: {
        risId: risId.split('_')[1]
      }
    }).done(function(data){
      $('.containerTransaction').animate({scrollTop:$('.selected').offset().top - $('.releasedList').offset().top},250);
      setWindowBack('#materialReleasedWindow',0);
      $('#windowReleased').remove();
      $('.windowArea').append(data);
      setDragggable('#windowReleased');
      $('#inputRisNo').select();
    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })
  $(document).on('click','#updateRis',function(){//update ris
    var risId = $('.selected').attr('id');
    var risNo = $('#inputRisNo').val().trim();
    var risDate = $('#inputRisDate').val();
    var issuedBy = $('#selectIssuedBy').val();
    var receivedBy = $('#selectReceivedBy').val();
    var purpose = $('#textPurpose').val().trim();

    if(risNo.length < 11 || risNo.split('-').length != 2 || risNo.indexOf('-') != 4 || issuedBy == 0 || receivedBy == 0){
      showHelper('Incomplete/Invalid Input!','#ffd700');
      $('#inputRisNo').select();
      return false;
    }


    $.ajax({
      type: 'post',
      url: 'server/update_ris.php',
      data:{
        risId: risId.split('_')[1],
        risNo: risNo,
        risDate: risDate,
        issuedBy: issuedBy,
        receivedBy: receivedBy,
        purpose: purpose
      }
    }).done(function(data){
      if(data){
        showHelper(data,'#ffd700');
        return false;
      }
      showHelper('Updated Successfully!','#00ffff');
      read_materialReleased(risId);
      read_materialRis(risId.split('_')[1]);
    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })



})
function close_windowReleased(){
  $('#windowReleased').remove();
  setWindowFront('#materialReleasedWindow');
  if($('.selected').attr('id')){
    var risId = $('.selected').attr('id');
    $('#' + risId).removeClass('selectedDelete');
  }
}
function close_windowRis(){
  $('#windowRis').remove();
  setWindowFront('#windowReleased');
  if($('.selected2').attr('id')){
    var itemId = $('.selected2').attr('id');
    $('#' + itemId).removeClass('selectedDelete');
  }
}
function index_materialRis(row, keyWord){
  $.ajax({
    type: 'post',
    url: 'server/index_materialRis.php',
    data: {
      row: row,
      keyWord: keyWord
    }
  }).done(function(data){
    if(data){
      var risId = 'ris_' + data;
      indexRow(risId);
      $('.containerTransaction').animate({scrollTop:$('.selected').offset().top - $('.releasedList').offset().top},250);
      releasedContent(data);
    } else {
      showHelper('No Matched Found!','#ffd700');
    }
  }).fail(function(data){
    alert('Something went wrong!!!');
  })
}
function releasedContent(risId){
  $.ajax({
    type: 'post',
    url: 'server/read_releasedContent.php',
    data: {
      risId: risId
    }
  }).done(function(data){
    $('#bodyReleasedContent').html(data);
  }).fail(function(data){
    alert('Something went wrong!!!');
  })
}
function read_materialReleased(row){
  $.ajax({
    type: 'post',
    url: 'server/read_materialReleased.php'
  }).done(function(data){
    $('#bodyMaterialReleased').html(data);
    indexRow(row);
    $('.containerTransaction').animate({scrollTop:$('.selected').offset().top - $('.releasedList').offset().top},250);
  }).fail(function(data){
    alert('Something went wrong!!!');
  })
}
function read_materialRis(risId){
  $.ajax({
    type: 'post',
    url: 'window/materialRis.php',
    data: {
      risId : risId
    }
  }).done(function(data){
    $('#windowReleased').remove();
    $('.windowArea').append(data);
    setDragggable('#windowReleased');
    indexRow2($('.risList').eq(0).attr('id'));
  }).fail(function(data){
    alert('Something went wrong!!!');
  })
}
function read_risContent(releaseId){
  var risId = $('.selected').attr('id').split('_')[1];
  $.ajax({
    type: 'post',
    url: 'server/read_risContent.php',
    data: {
      risId : risId
    }
  }).done(function(data){
    $('#bodyRisContent').html(data);
    releasedContent(risId);
    indexRow2(releaseId);
    $('.containerRisContent').animate({scrollTop:$('.selected2').offset().top - $('.risList').offset().top},250);
  }).fail(function(data){
    alert('Something went wrong!!!');
  })
}
