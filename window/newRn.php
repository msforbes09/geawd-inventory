<?php
  try {
    $pdo = new PDO( 'mysql:host=localhost;dbname=geawd;charset=utf8;', 'root', 'myLady' );
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    $stmt = $pdo->prepare(

      "SELECT staffId, concat(firstName, ' ', lastName) as name
      FROM staff
      WHERE removeStatus = 0;"

    );
    $stmt->execute();

    $staff = '<option value="0"></option>';
    while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ){
      $staff .= '<option value="' . $row["staffId"] . '">' . $row["name"] . '</option>';
    }

    $stmt = $pdo->prepare(

      "SELECT risId, risNo
      FROM materialRis
      ORDER BY risDate DESC, risId DESC;"

    );
    $stmt->execute();

    $ris = '<option value="0"></option>';
    while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ){
      $ris .= '<option value="' . $row["risId"] . '">' . $row["risNo"] . '</option>';
    }

  } catch( PDOException $e ) {
    echo $e->getMessage();
  }
  $pdo = null;
?>

<div id="windowReturned" class="windowDialog">
  <div class="windowContent">
    <div class="windowHead"><span class="windowClose close_windowReturned">&times;</span>New Return Slip</div>
    <div class="windowBody">
      <div class="frameInvoice">
        <div class="frameInvoice">
          <div class="invoiceInputGroup">
            <span class="invoiceLabel">R.N. No. :</span>
            <input id="inputRnNo" type="text" maxlength="11" value="<?php echo date("Y-"); ?>" />
            <span class="invoiceLabel">Date :</span>
            <input id="inputRnDate" type="date" value="<?php echo date("Y-m-d"); ?>" />
          </div>
          <hr />
          <div class="invoiceInputGroup">
            <span class="invoiceLabel">Returned By :</span>
            <select id="selectReturnedBy" class="invoiceSelect">
              <?php echo $staff; ?>
            </select>
          </div>
          <hr />
          <div class="invoiceInputGroup">
            <span class="invoiceLabel">Received By :</span>
            <select id="selectReceivedBy" class="invoiceSelect">
              <?php echo $staff; ?>
            </select>
          </div>
          <hr />
          <div class="invoiceInputGroup">
            <span class="invoiceLabel">R.I.S. No. :</span>
            <select id="selectRisNo" class="invoiceSelect">
              <?php echo $ris; ?>
            </select>
            <button id="addRn" class="invoiceButton">Save <span class="glyphicon glyphicon-save"></span></button>
          </div>
    </div>
  </div>
</div>
