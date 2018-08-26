<?php
  require_once '../server/globalFunction.php';
  try {
  	$pdo = new PDO( 'mysql:host=localhost;dbname=geawd;charset=utf8;', 'root', 'myLady' );
  	$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

    $stmt = $pdo->prepare(

      "SELECT itemId, itemCount
      FROM materialReturn
      WHERE returnId = :returnId;"

    );
    $stmt->bindValue(':returnId', $_REQUEST["returnId"], PDO::PARAM_INT);
    $stmt->execute();
    $index = $stmt->fetch(PDO::FETCH_ASSOC);


    $stmt = $pdo->prepare(

      "SELECT m.itemId, m.stockNo, m.itemName
      FROM materialRelease i
      JOIN materialList m
      ON m.itemId = i.itemId
      WHERE i.risId =
      (
          SELECT risId
      	FROM materialRn
      	WHERE rnId = :rnId
      )
      ORDER BY m.stockNo;"

    );
    $stmt->bindValue(':rnId', $_REQUEST["rnId"], PDO::PARAM_INT);
    $stmt->execute();
    $content = '';
    $count = 1;
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      $content .= '<tr id="item_' . $row["itemId"] . '" class="itemList ' . compare($row["itemId"], $index["itemId"], 'selected3') . '">';
      $content .= '<td class="mlr1"></td>';
      $content .= '<td class="mlr2">' . $row["stockNo"] . '</td>';
      $content .= '<td class="mlr3">' . $row["itemName"] . '</td>';
      $content .= '</tr>';
      $count ++;
    }

    for($i = $count; $i < 9; $i++){
			$content .= '<tr class="tr_masterList">';
			$content .= '<td class="mlr1"></td>';
			$content .= '<td class="mlr2"></td>';
			$content .= '<td class="mlr3"></td>';
			$content .= '</tr>';
		}

  } catch( PDOException $e ) {
  	echo $e->getMessage();
  }
  $pdo = null;
?>

<div id="windowRn" class="windowDialog">
  <div class="windowContent">
    <div class="windowHead"><span class="windowClose close_windowRn">&times;</span>Update Item</div>
    <div class="windowBody">
      <div>
        <table class="table_masterList">
          <thead>
            <tr>
              <th class="mlr1"></th>
              <th class="mlr2">Stock No.</th>
              <th class="mlr3">Item Description</th>
              <th class="mlr7"></th>
            </tr>
          </thead>
        </table>
      </div>
      <div class="container_itemList">
        <table class="table_masterList">
          <tbody>
            <?php echo $content; ?>
          </tbody>
        </table>
      </div>
      <div class="frameItem">
        <div class="itemInputGroup">
          <span class="itemLabel">Search :</span>
          <input id="text_itemReturnSearch" class="itemText" type="text" />
          <span class="glyphicon glyphicon-search itemIcon"></span>
          <span class="itemLabel">Qty :</span>
          <input id="text_itemQuantity" class="itemText" type="text" value="<?php echo $index["itemCount"] ?>" maxlength="10" />
          <button id="update_returnedItem" class="itemButton">Save <span class="glyphicon glyphicon-save"></span></button>
        </div>
      </div>
    </div>
  </div>
</div>
