<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>CI Query Activities</title>
<script type="text/javascript" src="js/jquery-1.3.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.7.1.custom.min.js"></script>
<script type="text/javascript" src="js/daterangepicker1.jQuery.js"></script>
<link rel="stylesheet" href="css/ui.daterangepicker.css" type="text/css" />
<link rel="stylesheet" href="css/redmond/jquery-ui-1.7.1.custom.css" type="text/css" title="ui-theme" />
<link rel="stylesheet" href="css/ci.css" type="text/css">
<script type="text/javascript">   
<!--
$(function(){
   $('.inp_date').daterangepicker({dateFormat: 'yy-mm-dd'}); 
});
function DisActy() {
   document.getElementById("Area1").innerHTML = "";
   vfrom = document.getElementById("date_from").value;
   vto = document.getElementById("date_to").value;
   vdesc = document.getElementById("descrp").value;
   hostn = document.getElementById("hostn").value;
   if (window.XMLHttpRequest) 
      xmlhttp = new XMLHttpRequest();
   else
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

   xmlhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
         document.getElementById("Area1").innerHTML = this.responseText;
         }
      }
   xmlhttp.open ("GET", "/ci/rqry_activity.php?date_from="+vfrom+"&date_to="+vto+"&desc="+vdesc+"&hostn="+hostn, true);
   xmlhttp.send ();
}
//-->
</script>
</head>

<body>

<table bgcolor=#003366 border=0 width=100% cellpadding=20 cellspacing=0>
<tr>
<td><font color=white size=3><b>CI Query Activities</b></font></td>
</tr>
</table><p>

<form>
<table border=0 cellpadding=0 cellspacing=8>
<tr><td align=right><b>Date Range (yyyy/mm/dd):</b></td>
<td>From: <input class="inp_date" type="text" size=10 maxlength=10 id="date_from" />
To: <input class="inp_date" type="text" size=10 maxlength=10 id="date_to" /></td></tr>
<tr><td align=right><b>Description Contains: </b></td>
<td><input type="text" size=52 maxlength=1000 id="descrp" /></td></tr>
<tr><td align=right><b>Hostname:</b></td>
<td><input type="text" size=52 maxlength=1000 id="hostn" /></td>
</tr>
</table>

<p>
<button type=button onclick="DisActy()">Query Activities</button>
<button type=reset>Reset</button>
</form>
<p>

<div id="Area1"></div>
</body>
</html>

