<?php
  function setDisable(){
    if($_SESSION["userLevel"] != 1 ){
      return "disabled";
    }
  }
  function ifSelected($value, $compare){
  	if($value == $compare){
  		return 'selected';
  	}
  }
  function compare($value, $compare, $prompt){
    if($value == $compare){
  		return $prompt;
  	}
  }
?>
