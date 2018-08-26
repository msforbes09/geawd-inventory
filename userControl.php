<?php
  session_start();
  if(isset($_SESSION["userId"])){
    try {
    	$pdo = new PDO( 'mysql:host=localhost;dbname=geawd;charset=utf8;', 'root', 'myLady' );
    	$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    	$stmt = $pdo->prepare(
        "SELECT l.levelName
        FROM
        systemUser u
        JOIN userLevel l
        ON l.levelId = u.levelId
        WHERE u.userId = :userId"
      );
      $stmt->bindValue(':userId', $_SESSION["userId"], PDO::PARAM_INT);
      $stmt->execute();
      $user = $stmt->fetch(PDO::FETCH_ASSOC)["levelName"];

    } catch( PDOException $e ) {
    	echo $e->getMessage();
    }
    $pdo = null;

    require_once 'window/main.php';
  } else {
    require_once 'window/sign_in.php';
  }
?>
