<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
?>

<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<html>
<head>
<title>Enter Activity</title>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="styles/ac.css">
<link rel="stylesheet" href="css/ci.css" type="text/css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/qact.js"></script>


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
function chkHost(){
   var hostn = document.getElementById("hostn").value;
   var div1  = document.getElementById("hstat1");
   var div2  = document.getElementById("hstat2");
   if (hostn.length > 0) {
      div1.style.visibility = "visible";
      div2.style.visibility = "visible";
      }
   else {
      div1.style.visibility = "hidden";
      div2.style.visibility = "hidden";
      }
}
//-->
</script>
</head>

<body>
<?php
if (empty($_GET["activity_date"])) {
   echo '<table bgcolor=#003366 border=0 width=100% cellpadding=20 cellspacing=0>';
   echo '<tr>';
   echo '<td><font color=white size=3><b>Enter Activity</b></font></td>';
   echo '</tr>';
   echo '</table><p>';
   $activity_date="";
   }
else
   $activity_date=$_GET["activity_date"];

$act_type_id   = (empty($_GET["act_type_id"]) ? "" : $_GET["act_type_id"]);
$actor_type_id = (empty($_GET["actor_type_id"]) ? "" : $_GET["actor_type_id"]);
$description   = (empty($_GET["description"]) ? "" : $_GET["description"]);
$hostn         = (empty($_GET["hostn"]) ? "" : $_GET["hostn"]);
$ipaddr        = (empty($_GET["ipaddr"]) ? "" : $_GET["ipaddr"]);
$OpCo_id       = (empty($_GET["OpCo_id"]) ? "" : $_GET["OpCo_id"]);
$act_method    = (empty($_GET["act_method"]) ? "" : $_GET["act_method"]);
$act_src       = (empty($_GET["act_src"]) ? "" : $_GET["act_src"]);
$act_dst       = (empty($_GET["act_dst"]) ? "" : $_GET["act_dst"]);
$act_hop_point = (empty($_GET["act_hop_point"]) ? "" : $_GET["act_hop_point"]);

include_once 'includes/ci_connect.php';
include_once 'includes/ci_func.php';


echo '<form name=FRM action="inp_activity.php" method="post">';
echo '<table frame=border cellspacing=0 cellpadding=10>';
echo '<tr>';
echo '<th colspan=4>Please enter Activity Details:</th>';
echo '</tr>';
echo '<tr>';
echo '<td align=right><b>Date of Activity:</b></td>';
echo '<td><input class="inp_date" type="text" size=10 maxlength=10 id="activity_date" /></td>';
echo '<td align=right><b>Actor:</b></td>';
echo '<td>';
seloptions('actor_type_id','select id, val from actor_type order by seq', $actor_type_id);
echo '</td></tr>';

echo '<tr>';
echo '<td align=right><b>Activity Type:</b></td>';
echo '<td>';
seloptions('act_type_id','select id, val from activity_type order by seq', $act_type_id, '[Select Activity]', 'onchange="DisSubAct()"');

echo '<td>';
echo '<div id=SubAct style="float: left"></div>';
echo '</td></tr>';

echo '</td>';

echo '<tr><td colspan=4><b>Description:</b></td></tr>';
echo '<tr><td align=center colspan=4><textarea name=description rows=4 cols=120>'.$description.'</textarea></td></tr>';

echo '<tr>';
echo '<td align=right><b>Hostname:</b></td>';
echo '<td><input type=text id=hostn name=hostname maxlength=200 size=40 value="'.$hostn.'" onchange="chkHost()"></td>';
echo '<td align=right>';
echo '<div id=hstat1 style="visibility:hidden">';
echo '<b>Host Status:</b></div></td>';
echo '<td>';
echo '<div id=hstat2 style="visibility:hidden">';
seloptions('system_status_type_id','select id, val from system_status_type order by seq');
echo '</div></td>';
echo '</tr>';

echo '<tr><td align=right><b>IP Address:</b></td>';
echo '<td><input type=text id=ipaddr name=ip_addr maxlength=200 size=40 value="'.$ipaddr.'"></td>';
echo '<td align=right><b>OpCo:</b></td>';
echo '<td>';
seloptions('OpCo_id','select id, OpCo from OpCo where length(trim(OpCo))>0 order by OpCo', $OpCo_id,'[Select OpCo]');
echo '</td>';
echo '</tr>';

echo '<tr>';
echo '<th colspan=4>&nbsp;</th>';
echo '</tr>';

echo '<tr>';
echo '<td align=right><b>Method:</b></td>';
echo '<td colspan=3><input type=text id=act_method name=act_method maxlength=200 size=40 value="'.$act_method.'"></td>';
echo '</tr>';

echo '<tr>';
echo '<td align=right><b>Source:</b></td>';
echo '<td colspan=3><input type=text id=act_src name=act_src maxlength=200 size=40 value="'.$act_src.'"></td>';
echo '</tr>';

echo '<tr>';
echo '<td align=right><b>Hop Point:</b></td>';
echo '<td colspan=3><input type=text id=act_hop_point name=act_hop_point maxlength=200 size=40 value="'.$act_hop_point.'"></td>';
echo '</tr>';

echo '<tr>';
echo '<td align=right><b>Destination:</b></td>';
echo '<td colspan=3><input type=text id=act_dst name=act_dst maxlength=200 size=40 value="'.$act_dst.'"></td>';
echo '</tr>';

?>
</table>
<p>
<button type=button onclick="Sub()">Submit</button>
</form>

</body>
</html>

