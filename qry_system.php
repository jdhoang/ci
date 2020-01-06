
<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="styles/ac.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript">   
<!--
$(function(){
   $('#sys_nm').autocomplete({
      source: '/ci/ac_system.php'
      });
   });
function DisSys() {
   document.getElementById("Area1").innerHTML = "";
   document.getElementById("Area2").innerHTML = "";
   snm = document.getElementById("sys_nm").value;
   if (window.XMLHttpRequest) 
      xmlhttp = new XMLHttpRequest();
   else
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

   xmlhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
         document.getElementById("Area1").innerHTML = this.responseText;
         }
      }
   xmlhttp.open ("GET", "/ci/dis_systems.php?sys_nm="+snm, true);
   xmlhttp.send ();
}
function DetSys(sid) {
   document.getElementById("Area2").innerHTML = "";
   snm = document.getElementById("sys_nm").value;
   if (window.XMLHttpRequest) 
      xmlhttp = new XMLHttpRequest();
   else
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

   xmlhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
         document.getElementById("Area2").innerHTML = this.responseText;
         }
      }
   xmlhttp.open ("GET", "/ci/det_system.php?id="+sid, true);
   xmlhttp.send ();
}
//-->
</script>
   
<title>CI Query Sytems</title>
<style style="text/css">
<!--
*              {font-family: Arial; font-size: 12pt}
h3             {font-family: Arial; font-size: 16pt}
   p              {font-family: Arial; font-size: 12pt}
   option         {font-family: Arial; font-size: 12pt; color: blue}
   td             {font-family: Arial; font-size: 12pt; vertical-align: top}
   th             {font-family: Arial; font-size: 12pt; font-weight:bold;
                   background: #336699; color: white; vertical-align: top;
                   text-align: left}
   input          {font-family:Arial; color: blue}
   ..box          {border-top:1px #999999 solid;border-left:1px #999999 solid;
                   border-right:1px #000000 solid;border-bottom:1px #000000
                   solid;font-family:Arial;text-transform:uppercase;color: blue}
   a              {color: blue; text-decoration: none; font-size: 12pt}
   a:hover        {color: magenta; text-decoration: none}
   ..error        {color: #FF0000; font-family: Arial; font-size: 10pt;
                   font-weight: bold;}
   ..msg          {color: #CC0000; font-family: Arial; font-size: 9pt;
                   font-weight: bold;}
   ..lefttext     {color: #000000; font-family: Arial,Verdana; font-size: 11px;}
   ..footer       {color: #FFFFFF; font-family: Arial,Verdana; font-size: 11px;}
   ..date         {color: #FFFFFF; font-family: Arial, Verdana; font-size: 12pt;}
   a.link         {color:#003399; font-family: Arial; font-size: 12pt;
                   text-decoration: none;}
   a.link:visited {color:#003399; font-family: Arial; font-size: 12pt;
                   text-decoration: none;}
   a.link:hover   {color:#FFFF00; font-family: Arial; font-size: 12pt;
                   text-decoration: underline;}
   ..pwinput      {border-top:1px #999999 solid;border-left:1px #999999
                   solid; border-right:1px #000000 solid;
                   border-bottom:1px #000000 solid; height: 19px;width: 180px;
                   font-family: Arial;}
   .style15       {font-size: 14px}

   .titleTab          {border-radius: 10px; width:100%; border-collapse:collapse}
   .titleTab th       {font-family: Copperplate,"Copperplate Gothic Light",fantasy; font-size: 24pt; font-weight:bold;
                       background: black; color: white; vertical-align: middle;
                       text-align: left; padding: 7px; border:black 1px solid}
   .titleTab td       {font-family: Arial; font-size: 12pt; font-weight:bold;
                       background: black; color: white; vertical-align: middle;
                       text-align: left; padding: 7px; border:black 1px solid}

   .hoverTab          {border-radius: 10px; border-collapse:collapse}
   .hoverTab th       {font-family: Arial; font-size: 12pt; font-weight:bold;
                       background: #336699; color: white; vertical-align: top;
                       text-align: left; padding: 7px; border:#4e95f4 1px solid}
   .hoverTab td       {padding: 7px; border:#4e95f4 1px solid}
   .hoverTab tr:hover {background-color: yellow}
//-->
</style>
</head>

<body>

<table bgcolor=#003366 border=0 width=100% cellpadding=20 cellspacing=0>
<tr>
<td><font color=white size=3><b>CI Query Systems</b></font></td>
</tr>
</table><p>

<div class="ui-widget">
   <label for="sys_nm">Host/System Name:</label>
   <input id="sys_nm" onchange="DisSys()">
<button type=button onclick="DisSys()">Query System</button>
</div>
<p>

<table border=0 cellspacing=0 cellpadding=6>
<tr>
<td>
<div id="Area1"></div>
<p>
</td>
<td>
<div id="Area2"></div>
</td>
</tr>
</table>

</body>
</html>

