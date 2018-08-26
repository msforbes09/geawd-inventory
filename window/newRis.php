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

  } catch( PDOException $e ) {
    echo $e->getMessage();
  }
  $pdo = null;
?>

<div id="windowReleased" class="windowDialog">
  <div class="windowContent">
    <div class="windowHead"><span class="windowClose close_windowReleased">&times;</span>New R.I.S.</div>
    <div class="windowBody">
      <div class="frameInvoice">
        <div class="invoiceInputGroup">
          <span class="invoiceLabel">R.I.S. No. :</span>
          <input id="inputRisNo" type="text" maxlength="11" value="<?php echo date("Y-") ?>" />
          <span class="invoiceLabel">Date :</span>
          <input id="inputRisDate" type="date" value="<?php echo date("Y-m-d"); ?>" />
        </div>
        <hr />
        <div class="invoiceInputGroup">
          <span class="invoiceLabel">Issued By :</span>
          <select id="selectIssuedBy" class="invoiceSelect">
            <?php echo $staff; ?>
          </select>
        </div>
        <hr />
        <div class="invoiceInputGroup">
          <span class="invoiceLabel">Received By :</span>
          <select id="selectReceivedBy" class="invoiceSelect">
            <?php echo $staff ?>
          </select>
        </div>
      </div>
      <div class="purposeInputGroup">
        <textarea id="textPurpose" placeholder="type purpose here..." maxlength="255"></textarea>
        <button id="addRis" class="invoiceButton"><span class="glyphicon glyphicon-save"></span><div>Save</div></button>
      </div>
    </div>
  </div>
</div>
