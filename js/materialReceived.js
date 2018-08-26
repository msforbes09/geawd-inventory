$(function(){
  $(document).on('click','.receivedList',function(){//select item
    indexRow($(this).attr('id'));
    var receivedIndex = $(this).attr('id').split('_')[1];
    receivedContent(receivedIndex);
  })
  $(document).on('change','#text_invoiceDate',function(){//filter list
    index_materialInvoice('invoiceDate',$(this).val());
  })
  $(document).on('keyup','#text_invoiceNo',function(){//filter list
    index_materialInvoice('invoiceNo',$(this).val());
  })
  $(document).on('click','#print_materialInvoice',function(){//print invoice
    $.ajax({
      type: 'post',
      url: 'report/materialInvoice.php'
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
  $(document).on('click','#newInvoice',function(){//show add invoice form
    $.ajax({
      type: 'post',
      url: 'window/newInvoice.php'
    }).done(function(data){
      setWindowBack('#materialReceivedWindow',0);
      $('#windowReceived').remove();
      $('.windowArea').append(data);
      setDragggable('#windowReceived');
      $('#inputInvoiceNo').select();
    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })
  $(document).on('click','.close_windowReceived',function(){//close window
    close_windowReceived();
  })
  $(document).on('keypress','#inputInvoiceNo',function(){//disable character input
    return isNumber(event);
  })
  $(document).on('click','#addInvoice',function(){//save invoice
    var invoiceNo = $('#inputInvoiceNo').val().trim();
    var invoiceDate = $('#inputInvoiceDate').val();
    var supplier = $('#selectSupplier').val();
    var receiver = $('#selectReceiver').val();

    if(invoiceNo.length == 0 || supplier == 0 || receiver == 0){
      showHelper('Incomplete/Invalid Input!','#ffd700');
      $('#inputInvoiceNo').select();
      return false;
    }

    $.ajax({
      type: 'post',
      url: 'server/save_materialInvoice.php',
      data:{
        invoiceNo: invoiceNo,
        invoiceDate: invoiceDate,
        supplier: supplier,
        receiver: receiver
      }
    }).done(function(data){
      if(data.length > 10){
        showHelper(data,'#ffd700');
        return false;
      }
      showHelper('Saved Successfully!','#00ffff');
      receivedContent(data);
      read_materialReceived('list_' + data);
      read_materialInvoice(data);
    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })
  $(document).on('click','.invoiceList',function(){//select item
    indexRow2($(this).attr('id'));
  })
  $(document).on('click','#add_receivedItem',function(){//show add item form
    $.ajax({
      type: 'post',
      url: 'window/newReceivedItem.php'
    }).done(function(data){
      setWindowBack('#windowReceived',30);
      $('#windowInvoice').remove();
      $('.windowArea').append(data);
      setDragggable('#windowInvoice');
    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })
  $(document).on('click','.close_windowInvoice',function(){//close window
    close_windowInvoice();
  })
  $(document).on('click','#viewInvoice',function(){//show invoice window
    var itemId = $('.selected').attr('id');
    if(!itemId){
      showHelper('No Selected Item!','#ffd700');
      return false;
    }
    $('.containerTransaction').animate({scrollTop:$('.selected').offset().top - $('.receivedList').offset().top},250);
    setWindowBack('#materialReceivedWindow',0);
    read_materialInvoice(itemId.split('_')[1]);
  })
  $(document).on('click','#save_receivedItem',function(){//save received item
    var invoiceId = $('.selected').attr('id').split('_')[1];
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
      url: 'server/save_receivedItem.php',
      data:{
        invoiceId: invoiceId,
        itemId: itemId.split('_')[1],
        quantity: quantity
      }
    }).done(function(data){
      if(data.length > 10){
        showHelper(data,'#ffd700');
        return false;
      }
      showHelper('Saved Successfully!','#00ffff');
      read_invoiceContent('invoice_' + data);
      $('.selected3').children().eq(0).html('');
      $('.selected3').removeClass('selected3');
      $('#text_itemQuantity').val(0);
      $('#text_itemSearch').val('');
    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })
  $(document).on('click','#print_receivedItem',function(){//print invoice
    var invoiceId = $('.selected').attr('id').split('_')[1];

    $.ajax({
      type: 'post',
      url: 'report/materialReceived.php',
      data: {
        invoiceId: invoiceId
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
  $(document).on('click','#remove_receivedItem',function(){//confirm delete
    var itemId = $('.selected2').attr('id');
    if(!itemId){
      showHelper('No Selected Item!','#ffd700');
      return false;
    }

    $.ajax({
      type: 'post',
      url: 'window/removeReceivedItem.php'
    }).done(function(data){
      $('#' + itemId).addClass('selectedDelete');
      $('.containerInvoiceContent').animate({scrollTop:$('.selected2').offset().top - $('.invoiceList').offset().top},250);
      setWindowBack('#windowReceived',30);
      $('#windowInvoice').remove();
      $('.windowArea').append(data);
      setDragggable('#windowInvoice');
    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })
  $(document).on('click','#cancel_removeReceived',function(){//hide confirmation
    close_windowInvoice();
  })
  $(document).on('click','#confirm_removeReceived',function(){//remove item from the list
    var itemId = $('.selected2').attr('id');

    $.ajax({
      type: 'post',
      url: 'server/remove_receivedItem.php',
      data:{
        itemIndex: itemId.split('_')[1]
      }
    }).done(function(data){
      if(data){
        showHelper(data,'#ffd700');
        return false;
      }
      showHelper('Removed Successfully!','#00ffff');
      close_windowInvoice();
      if($('.selected2').next().attr('id')){
        itemId = $('.selected2').next().attr('id');
      } else if($('.selected2').prev().attr('id')) {
        itemId = $('.selected2').prev().attr('id');
      }
      read_invoiceContent(itemId);
    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })
  $(document).on('click','#edit_receivedItem',function(){//show add item form
    var itemId = $('.selected2').attr('id');
    if(!itemId){
      showHelper('No Selected Item!','#ffd700');
      return false;
    }

    $.ajax({
      type: 'post',
      url: 'window/updateReceivedItem.php',
      data:{
        receiveId : itemId.split('_')[1]
      }
    }).done(function(data){
      $('.containerInvoiceContent').animate({scrollTop:$('.selected2').offset().top - $('.invoiceList').offset().top},250);
      setWindowBack('#windowReceived',30);
      $('#windowInvoice').remove();
      $('.windowArea').append(data);
      setDragggable('#windowInvoice');
      var itemId = $('.selected3').attr('id');
      $('.container_itemList').animate({scrollTop:$('.selected3').offset().top - $('.itemList').offset().top},0);
      indexRow3(itemId);

    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })
  $(document).on('click','#update_receivedItem',function(){//update received item
    var receiveId = $('.selected2').attr('id');
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
      url: 'server/update_receivedItem.php',
      data:{
        receiveId: receiveId.split('_')[1],
        itemId: itemId.split('_')[1],
        quantity: quantity
      }
    }).done(function(data){
      if(data){
        showHelper(data,'#ffd700');
        return false;
      }
      showHelper('Updated Successfully!','#00ffff');
      close_windowInvoice();
      read_invoiceContent(receiveId);
    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })
  $(document).on('click','#removeInvoice',function(){//confirm delete
    var invoiceId = $('.selected').attr('id');
    if(!invoiceId){
      showHelper('No Selected Item!','#ffd700');
      return false;
    }

    $.ajax({
      type: 'post',
      url: 'window/removeInvoice.php'
    }).done(function(data){
      $('#' + invoiceId).addClass('selectedDelete');
      $('.containerTransaction').animate({scrollTop:$('.selected').offset().top - $('.receivedList').offset().top},250);
      setWindowBack('#materialReceivedWindow',0);
      $('#windowReceived').remove();
      $('.windowArea').append(data);
      setDragggable('#windowReceived');
    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })
  $(document).on('click','#cancel_removeInvoice',function(){//hide confirmation
    close_windowReceived();
  })
  $(document).on('click','#confirm_removeInvoice',function(){//remove item from the list
    var invoiceId = $('.selected').attr('id');

    $.ajax({
      type: 'post',
      url: 'server/remove_invoice.php',
      data:{
        invoiceId: invoiceId.split('_')[1]
      }
    }).done(function(data){
      if(data){
        showHelper(data,'#ffd700');
        return false;
      }
      showHelper('Removed Successfully!','#00ffff');
      close_windowReceived();
      if($('.selected').next().attr('id')){
        invoiceId = $('.selected').next().attr('id');
      } else if($('.selected').prev().attr('id')) {
        invoiceId = $('.selected').prev().attr('id');
      }
      read_materialReceived(invoiceId);
    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })
  $(document).on('click','#editInvoice',function(){//show edit invoice form
    var invoiceId = $('.selected').attr('id');
    if(!invoiceId){
      showHelper('No Selected Item!','#ffd700');
      return false;
    }

    $.ajax({
      type: 'post',
      url: 'window/updateInvoice.php',
      data: {
        invoiceId: invoiceId.split('_')[1]
      }
    }).done(function(data){
      $('.containerTransaction').animate({scrollTop:$('.selected').offset().top - $('.receivedList').offset().top},250);
      setWindowBack('#materialReceivedWindow',0);
      $('#windowReceived').remove();
      $('.windowArea').append(data);
      setDragggable('#windowReceived');
      $('#inputInvoiceNo').select();
    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })
  $(document).on('click','#updateInvoice',function(){//update invoice
    var invoiceId = $('.selected').attr('id');
    var invoiceNo = $('#inputInvoiceNo').val();
    var invoiceDate = $('#inputInvoiceDate').val();
    var supplier = $('#selectSupplier').val();
    var receiver = $('#selectReceiver').val();

    if(invoiceNo.length == 0 || supplier == 0 || receiver == 0){
      showHelper('Incomplete/Invalid Input!','#ffd700');
      $('#inputInvoiceNo').select();
      return false;
    }


    $.ajax({
      type: 'post',
      url: 'server/update_invoice.php',
      data:{
        invoiceId: invoiceId.split('_')[1],
        invoiceNo: invoiceNo,
        invoiceDate: invoiceDate,
        supplier: supplier,
        receiver: receiver
      }
    }).done(function(data){
      if(data){
        showHelper(data,'#ffd700');
        return false;
      }
      showHelper('Updated Successfully!','#00ffff');
      read_materialReceived(invoiceId);
      read_materialInvoice(invoiceId.split('_')[1]);
    }).fail(function(data){
      alert('Something went wrong!!!');
    })
  })


})
function close_windowReceived(){
  $('#windowReceived').remove();
  setWindowFront('#materialReceivedWindow');
  if($('.selected').attr('id')){
    var itemId = $('.selected').attr('id');
    $('#' + itemId).removeClass('selectedDelete');
  }
}
function close_windowInvoice(){
  $('#windowInvoice').remove();
  setWindowFront('#windowReceived');
  if($('.selected2').attr('id')){
    var itemId = $('.selected2').attr('id');
    $('#' + itemId).removeClass('selectedDelete');
  }
}
function index_materialInvoice(row, keyWord){
  $.ajax({
    type: 'post',
    url: 'server/index_materialInvoice.php',
    data: {
      row: row,
      keyWord: keyWord
    }
  }).done(function(data){
    if(data){
      var itemId = 'list_' + data;
      indexRow(itemId);
      $('.containerTransaction').animate({scrollTop:$('.selected').offset().top - $('.receivedList').offset().top},250);
      receivedContent(data);
    } else {
      showHelper('No Matched Found!','#ffd700');
    }
  }).fail(function(data){
    alert('Something went wrong!!!');
  })
}
function receivedContent(receivedIndex){
  $.ajax({
    type: 'post',
    url: 'server/read_receivedContent.php',
    data: {
      receivedIndex: receivedIndex
    }
  }).done(function(data){
    $('#bodyReceivedContent').html(data);
  }).fail(function(data){
    alert('Something went wrong!!!');
  })
}
function read_materialReceived(row){
  $.ajax({
    type: 'post',
    url: 'server/read_materialReceived.php'
  }).done(function(data){
    $('#bodyMaterialReceived').html(data);
    indexRow(row);
    $('.containerTransaction').animate({scrollTop:$('.selected').offset().top - $('.receivedList').offset().top},250);
  }).fail(function(data){
    alert('Something went wrong!!!');
  })
}
function read_materialInvoice(invoiceId){
  $.ajax({
    type: 'post',
    url: 'window/materialInvoice.php',
    data: {
      invoiceId : invoiceId
    }
  }).done(function(data){
    $('#windowReceived').remove();
    $('.windowArea').append(data);
    setDragggable('#windowReceived');
    indexRow2($('.invoiceList').eq(0).attr('id'));
  }).fail(function(data){
    alert('Something went wrong!!!');
  })
}
function read_invoiceContent(receiveId){
  var invoiceId = $('.selected').attr('id').split('_')[1];
  $.ajax({
    type: 'post',
    url: 'server/read_invoiceContent.php',
    data: {
      invoiceId : invoiceId
    }
  }).done(function(data){
    $('#bodyInvoiceContent').html(data);
    receivedContent(invoiceId);
    indexRow2(receiveId);
    $('.containerInvoiceContent').animate({scrollTop:$('.selected2').offset().top - $('.invoiceList').offset().top},250);
  }).fail(function(data){
    alert('Something went wrong!!!');
  })
}
