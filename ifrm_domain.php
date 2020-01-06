<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
?>

<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<html>
<head>
<title>Add New Domain</title>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="styles/ac.css">
<link rel="stylesheet" href="css/ci.css" type="text/css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript">   
<!--
$(function(){
   $('#domainn').autocomplete({
      source: '/ci/ac_domain.php'
      });
   });
function Sub(){
   var errm = "";
   if (document.getElementById("domainn").value == "")
      errm = "Domain name is required!";
      
   if (errm != "")
      alert (errm);
   else
      document.FRM.submit();
   }
//-->
</script>
</head>

<body>
<?php
if (empty($_GET["domainn"])) {
   echo '<table bgcolor=#003366 border=0 width=100% cellpadding=20 cellspacing=0>';
   echo '<tr>';
   echo '<td><font color=white size=3><b>Add New Domain</b></font></td>';
   echo '</tr>';
   echo '</table><p>';
   $domainn="";
   }
else
   $domainn=$_GET["domainn"];

$reg_dt=(empty($_GET["reg_dt"]) ? "" : $_GET["reg_dt"]);
$domain_typ=(empty($_GET["domain_typ"]) ? "" : $_GET["domain_typ"]);
$obs_dt=(empty($_GET["obs_dt"]) ? "" : $_GET["obs_dt"]);
$reg_nm=(empty($_GET["reg_nm"]) ? "" : $_GET["reg_nm"]);
$reg_email=(empty($_GET["reg_email"]) ? "" : $_GET["reg_email"]);
$remail=(empty($_GET["remail"]) ? "" : $_GET["remail"]);
$description=(empty($_GET["description"]) ? "" : $_GET["description"]);

include_once 'includes/ci_connect.php';
include_once 'includes/ci_func.php';


echo '<form name=FRM action="inp_domain.php" method="post">';
echo '<table frame=border cellspacing=0 cellpadding=10>';
echo '<tr>';
echo '<th colspan=4>Please add new Domain Details:</th>';
echo '</tr>';

echo '<tr><td align=right><b>Domain Name:</b></td>';
echo '<td colspan=3><input type=text id=domainn name=domainn maxlength=200 size=80 value="'.$domainn.'"></td></tr>';

echo '<tr><td align=right><b>Registrant Email:</b></td>';
echo '<td><input type=text id=remail name=remail maxlength=200 size=40 value="'.$remail.'"></td>';
echo '<td align=right><b>Domain Type:</b><td>';
seloptions('domain_typ','select id, val from domain_type order by seq', $domain_typ);
echo '</td></tr>';

echo '<tr><td align=right><b>Registration Date:</b></td>';
echo '<td><input type=text id=reg_dt name=reg_dt maxlength=200 size=20 value="'.$reg_dt.'"></td>';
echo '<td align=right><b>Observed Date:</b></td>';
echo '<td><input type=text id=obs_dt name=obs_dt maxlength=200 size=20 value="'.$obs_dt.'"></td></tr>';


echo '<tr><td align=right><b>Registrar Name:</b></td>';
echo '<td><input type=text id=reg_nm name=reg_nm maxlength=200 size=40 value="'.$reg_nm.'"></td>';
echo '<td align=right><b>Registrar Email:</b></td>';
echo '<td><input type=text id=reg_email name=reg_email maxlength=200 size=40 value="'.$reg_email.'"></td></tr>';

echo '<tr><td align=right><b>Description:</b></td>';
echo '<tr><td align=center colspan=4><textarea name=description rows=4 cols=120>'.$description.'</textarea></td></tr>';

?>
</table>
<p>
<button type=button onclick="Sub()">Submit</button>
</form>

</body>
</html>

