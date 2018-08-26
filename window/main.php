<div class="helper"></div>
<div class="background">
  <img class="backgroundImage" src="../images/geawd.png" />
  <div class="header1">Gen. E. Aguinaldo Water District</div>
  <div class="header2">Inventory Control System</div>
  <div class="backgroundForm">
    <div class="backgroundLabel" >User :</div>
    <input class="backgroundText" type="text" tabindex="-1" value="<?php echo $user ?>"/>
  </div>
  <div class="backgroundForm">
    <div class="backgroundLabel" >Date :</div>
    <input class="backgroundText" type="text" tabindex="-1" value="<?php echo date("l, F d, Y") ?>"/>
  </div>
</div>
<div class="menu">
  <div id="masterList" class="menuItem" title="View Stocks">Masterlist</div>
  <div id="materialReceived" class="menuItem" title="Material Received">Receipts</div>
  <div id="materialReleased" class="menuItem" title="Material Released">Issues</div>
  <div id="materialReturned" class="menuItem">Returns</div>
  <div id="report" class="menuItem">Reports</div>
  <div id="others" class="menuItem">Miscellaneous</div>
  <div class="menuItem emptyCode">About</div>
  <div id="quit" class="menuItem" title="Sign Out">Quit</div>
</div>
<div class="menuContent"></div>

<div class="windowArea">
  <?php //require_once 'window/materialRn.php' ?>
</div>

<script src="../bootstrap/js/jquery-3.2.1.js"></script>
<script src="../bootstrap/js/jquery-ui.min.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="js/main.js"></script>
<script src="js/masterList.js"></script>
<script src="js/materialReceived.js"></script>
<script src="js/materialReleased.js"></script>
<script src="js/materialReturned.js"></script>
<script src="js/transaction.js"></script>
