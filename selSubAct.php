<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
include_once 'includes/ci_connect.php';
include_once 'includes/ci_func.php';


if (!empty($_GET["actid"])) {
   $prompt = (empty($_GET["prompt"]) ? "Any" : $_GET["prompt"]);
   echo '<b>Activity Detail: </b>';
   seloptions('subact_id',
              'select id, val from act_sub_type where act_type_id = '.$_GET["actid"].' order by seq', NULL, $prompt);
   }


?>

