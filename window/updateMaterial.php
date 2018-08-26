<?php
	require_once '../server/globalFunction.php';
	try {
		$pdo = new PDO( 'mysql:host=localhost;dbname=geawd;charset=utf8;', 'root', 'myLady' );
		$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

		$stmt = $pdo->prepare(

		  "SELECT stockNo, itemName, unitId, reorderPoint, startBalance
			FROM materialList
			WHERE itemId = :itemIndex;"

	  );
		$stmt->bindValue(':itemIndex', $_REQUEST["itemIndex"], PDO::PARAM_STR);
		$stmt->execute();
		$info = $stmt->fetch(PDO::FETCH_ASSOC);

		$stmt = $pdo->prepare(

		  "SELECT * FROM unit;"

	  );
		$stmt->execute();

		$option = '';
		while( $unit = $stmt->fetch(PDO::FETCH_ASSOC) ){
			$option .= '<option value="' . $unit["unitId"] . '" ' . ifSelected($unit["unitId"], $info["unitId"]) . '>' . $unit["unitName"] . '</option>';
		}

	} catch( PDOException $e ) {
		echo $e->getMessage();
	}
	$pdo = null;
?>

<div id="windowMaterial" class="windowDialog">
  <div class="windowContent">
    <div class="windowHead"><span class="windowClose close_windowMaterial">&times;</span>Update Material</div>
    <div class="windowBody">
      <div class="frameMaterial">
        <div class="materialInputGroup">
          <span class="materialLabel">Stock No. :</span>
          <input id="textStock" class="materialText" type="text" value="<?php echo preg_replace('(\")', '&#34', $info["stockNo"]) ?>" maxlength="30" />
          <span class="materialLabel">Unit :</span>
          <select id="selectUnit" class="materialSelect">
            <?php echo $option; ?>
          </select>
        </div>
        <hr />
        <div class="materialInputGroup">
          <span class="materialLabel">Item Desc. :</span>
          <input id="text_itemDesc" class="materialText" type="text" value="<?php echo preg_replace('(\")', '&#34', $info["itemName"]) ?>" maxlength="50" />
        </div>
        <hr />
        <div class="materialInputGroup">
          <span class="materialLabel">Beg. Balance :</span>
          <input id="textBalance" class="materialText" type="text" value="<?php echo $info["startBalance"] ?>" maxlength="5" />
          <span class="materialLabel">Reorder Point :</span>
          <input id="textReorder" class="materialText" type="text" value="<?php echo $info["reorderPoint"] ?>" maxlength="5" />
          <button id="editMaterial" class="materialButton">Save <span class="glyphicon glyphicon-save"></span></button>
        </div>
      </div>
    </div>
  </div>
</div>
