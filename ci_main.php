<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
?>
<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<html>
<head>
<title>Critical Incidents Database</title>
<script type="text/javascript" src="js/qact.js"></script>
<link rel="stylesheet" href="css/ci_main.css" type="text/css">
<link rel="stylesheet" href="css/ci_dash.css" type="text/css">
<script>
<!--
function disp(str) {
   if (str.length == 0) {
      document.getElementById("mTab").innerHTML = "";
      return;
      }
   else {
      if (window.XMLHttpRequest) 
         xmlhttp = new XMLHttpRequest();
      else
         xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

      xmlhttp.onreadystatechange = function () {
         if (this.readyState == 4 && this.status == 200) {
            document.getElementById("mTab").innerHTML = this.responseText;
            }
         }
      xmlhttp.open ("GET", str, true);
      xmlhttp.send ();
      }
}
function tdisp(str) {
   if (str.length == 0) {
      document.getElementById("dTab").innerHTML = "";
      return;
      }
   else {
      if (window.XMLHttpRequest) 
         xmlhttp1 = new XMLHttpRequest();
      else
         xmlhttp1 = new ActiveXObject("Microsoft.XMLHTTP");

      xmlhttp1.onreadystatechange = function () {
         if (this.readyState == 4 && this.status == 200) {
            document.getElementById("dTab").innerHTML = this.responseText;
            }
         }
      xmlhttp1.open ("GET", "func_tbval.php?sql=select seq AS Seq,val AS Value from "+str+" order by seq", true);
      xmlhttp1.send ();
      }
}
//-->
</script>
</head>

<body>
<table class="titleTab">
<tr>
<th>&nbsp;Critical Incidents Database</th>
<td width=15%><img src="/img/s.jpg"></td>
</tr>
</table><p>

<table width=100% cellspacing=0 cellpadding=5 >
<tr>
<td width=12%>

<table class="menuTab">
<tr bgcolor=lightblue><td><a href="javascript:void();" onclick="disp('ci_dash.php')">
Main&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></td></tr>
<tr bgcolor=lightblue><td><a href="javascript:void();" onclick="disp('dis_activity.php')">
Activities&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></td></tr>
<tr bgcolor=lightblue><td><a href="javascript:void();" onclick="disp('dis_critical_terms.php')">
Critical Terms&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></td></tr>
<tr bgcolor=lightblue><td><a href="javascript:void();" onclick="disp('func_tbval.php?sql=SELECT s.hostname, st.val AS Status, s.purpose, s.description, o.OpCo FROM systems s LEFT OUTER JOIN system_status_type st ON s.system_status_id = st.id LEFT OUTER JOIN OpCo o ON s.OpCo_id = o.id ORDER BY s.hostname&title=Systems')">
Systems&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></td></tr>
<tr bgcolor=lightblue><td><a href="javascript:void();" onclick="disp('func_tbval.php?sql=SELECT u.last_nm AS LastNm,u.first_nm AS FirstNm, u.s_global_id AS SonyGlobalID, u.display_nm AS Office, u.description FROM users u ORDER BY u.last_nm&title=Users')">
Users&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></td></tr>
<tr bgcolor=lightblue><td><a href="javascript:void();" onclick="disp('func_tbval.php?sql=SELECT f.filename, f.path, f.purpose, mt.family AS Malware FROM files f LEFT OUTER JOIN malware mt ON f.malware_id=mt.id ORDER BY f.id&title=Files')">
Files&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></td></tr>
<tr bgcolor=lightblue><td><a href="javascript:void();" onclick="disp('func_tbval.php?sql=select family,functionality,description from malware order by id&title=Malware')">
Malware&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></td></tr>
<tr bgcolor=lightblue><td><a href="javascript:void();" onclick="disp('func_tbval.php?sql=select id,parent_org,escalation_org,OpCo from OpCo&title=OpCo')">
OpCo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></td></tr>

<tr bgcolor=darkblue><th>Query</th></tr>
<tr bgcolor=lightblue><td><a href="javascript:void();" onclick="disp('qry_activity.php')">
Query Activities&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></td></tr>
<tr bgcolor=lightblue><td><a href="qry_system.php" target=_blank>Query Systems</a></td></tr>
<tr bgcolor=lightblue><td><a href="ci_sql.php" target=_blank>Query Ad Hoc</a></td>
<tr bgcolor=lightblue><td><a href="javascript:void();" onclick="disp('ci_type.php')">
Type Values&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></td></tr>

<tr bgcolor=darkblue><th>Create</th></tr>
<tr bgcolor=lightblue><td><a href="ifrm_systems.php" target=_blank>Add System</a></td></tr>
<tr bgcolor=lightblue><td><a href="ifrm_crit_terms.php" target=_blank>Add Critical Term</a></td></tr>
<tr bgcolor=lightblue><td><a href="ifrm_domain.php" target=_blank>Add Domain</a></td></tr>
</table>
</td>

<td>

<div id="mTab">
<?php
include ('ci_dash.php');
?>
</div>

</td>
</table>

</body>
</html>

