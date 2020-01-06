<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
?>

<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<html>
<head>
<title>Add New System</title>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="styles/ac.css">
<link rel="stylesheet" href="css/ci.css" type="text/css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript">   
<!--
$(function(){
   $('#ipaddr').autocomplete({
      source: '/ci/ac_ip_addr.php'
      });
   });
$(function(){
   $('#hostn').autocomplete({
      source: '/ci/ac_system.php'
      });
   });
function Sub(){
   var errm = "";
   if (document.getElementById("hostn").value == "")
      errm = "Hostname is required!";
      
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
if (empty($_GET["hostn"])) {
   echo '<table bgcolor=#003366 border=0 width=100% cellpadding=20 cellspacing=0>';
   echo '<tr>';
   echo '<td><font color=white size=3><b>Add New System</b></font></td>';
   echo '</tr>';
   echo '</table><p>';
   $hostn="";
   }
else
   $hostn=$_GET["hostn"];

$ipaddr=(empty($_GET["ipaddr"]) ? "" : $_GET["ipaddr"]);
$description=(empty($_GET["description"]) ? "" : $_GET["description"]);
$purpose=(empty($_GET["purpose"]) ? "" : $_GET["purpose"]);

echo '<form name=FRM action="inp_system.php" method="post">';
echo '<table frame=border cellspacing=0 cellpadding=10>';
echo '<tr>';
echo '<th colspan=4>Please add new System Details:</th>';
echo '</tr>';
echo '<tr>';
echo '<td align=right><b>Hostname:</b></td>';
echo '<td><input type=text id=hostn name=hostname maxlength=200 size=40 value="'.$hostn.'"></td>';
echo '<td align=right><b>Status:</b></td>';
echo '<td>';

include_once 'includes/ci_connect.php';
   echo '<select name="system_status_id">';
   $sql='select id, val from system_status_type order by seq';
   $cur=$conn->query($sql);

   $cur->data_seek(0);
   while ($row = $cur->fetch_row())
      echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
   echo '</select>';

echo '</td>';
echo '</tr><tr>';
echo '<td align=right><b>IP Address:</b></td>';
echo '<td><input type=text id=ipaddr name=ip_addr maxlength=200 size=40 value="'.$ipaddr.'"></td>';
echo '<td align=right><b>OpCo:</b></td>';
echo '<td>';

   $sql='select id, OpCo from OpCo where length(trim(OpCo))>0 order by OpCo';
   echo '<select name="OpCo_id">';
   $cur=$conn->query($sql);

   $cur->data_seek(0);
   while ($row = $cur->fetch_row())
      echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
   echo '</select>';

echo '</td>';
echo '</tr>';

echo '<tr><td colspan=4><b>Description:</b></td></tr>';
echo '<tr><td align=center colspan=4><textarea name=description rows=4 cols=120>'.$description.'</textarea></td></tr>';
echo '<tr><td colspan=4><b>Purpose:</b></td></tr>';
echo '<tr><td align=center colspan=4><textarea name=purpose rows=4 cols=120>'.$purpose.'</textarea></td></tr>';
?>
</table>
<p>
<button type=button onclick="Sub()">Submit</button>
</form>

</body>
</html>

