<link href="css/sign_in.css" rel="stylesheet">

<div id="signinWindow" class="windowDialog">
  <div class="windowContent">
    <div class="windowHead">Sign In</div>
    <div class="windowBody">
      <div class="frame">
        <img class="signinImage" src="../images/geawd.png" />
        <form id="signinForm">
          <div class="signinInput">
            <div class="signinLabel" >User Name :</div>
            <input id="username" class="signinText" type="text" value=""/>
          </div>
          <div class="signinInput">
            <div class="signinLabel" >Password :</div>
            <input id="password" class="signinText" type="password" value=""/>
          </div>
          <button class="signinButton">Sign In</button>
        </form>
      </div>
    </div>
  </div>
</div>
<script src="../bootstrap/js/jquery-3.2.1.js"></script>
<script src="../bootstrap/js/jquery-ui.min.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script>
  $(document).on('submit','#signinForm',function(e){
    e.preventDefault();
    $.ajax({
      type: 'post',
      url: '../sign_in/server/check_user.php',
      data:	{
        username: $('#username').val(),
        password: $('#password').val()
      }
    }).done(function(data){
      if (data == 1){
        location.reload(true);
      } else {
        $('.signinButton').tooltip('show')
        $('.signinText').val('');
        $('#username').focus();
      }
    }).fail(function(data){
      alert('Something went wrong!');
    })
  })
  $('.signinButton').tooltip({
		html: true,
		title: '<h4 style="color: yellow;"> Invalid Log In </h4>',
		trigger: 'manual',
		placement: 'left'
	})
  $('#username').focus();
  $('#signinWindow').draggable({
    cursor: "move",
    handle: ".windowHead"
  });
</script>
