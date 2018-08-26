<?php
	try {
		$pdo = new PDO( 'mysql:host=localhost;dbname=geawd;charset=utf8;', 'root', 'myLady' );
		$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		$stmt = $pdo->prepare(

	  "SELECT * FROM unit;"

	  );
		$stmt->execute();

		$option = '<option value="0"></option>';
		while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ){
			$option .= '<option value="' . $row["unitId"] . '">' . $row["unitName"] . '</option>';
		}

	} catch( PDOException $e ) {
		echo $e->getMessage();
	}
	$pdo = null;
?>

<div id="windowMaterial" class="windowDialog">
  <div class="windowContent">
    <div class="windowHead"><span class="close_windowMaterial windowClose">&times;</span>New Material</div>
    <div class="windowBody">
      <div class="frameMaterial">
        <div class="materialInputGroup">
          <span class="materialLabel">Stock No. :</span>
          <input id="textStock" class="materialText" type="text" maxlength="30" />
          <span class="materialLabel">Unit :</span>
          <select id="selectUnit" class="materialSelect">
            <?php echo $option; ?>
          </select>
        </div>
        <hr />
        <div class="materialInputGroup">
          <span class="materialLabel">Item Desc. :</span>
          <input id="text_itemDesc" class="materialText" type="text" maxlength="50" />
        </div>
        <hr />
        <div class="materialInputGroup">
          <span class="materialLabel">Beg. Balance :</span>
          <input id="textBalance" class="materialText" type="text" value="0" maxlength="5" />
          <span class="materialLabel">Reorder Point :</span>
          <input id="textReorder" class="materialText" type="text" value="0" maxlength="5" />
          <button id="addMaterial" class="materialButton">Save <span class="glyphicon glyphicon-save"></span></button>
        </div>
      </div>
    </div>
  </div>
</div>
