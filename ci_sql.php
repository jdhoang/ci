<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
?>
<!DOCTYPE html>
<html>
<head>
<title>Critical Incidents Ad-Hoc SQL</title>
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

   .titleTab          {width:100%; border-collapse:collapse}
   .titleTab th       {font-family: Copperplate,"Copperplate Gothic Light",fantasy; font-size: 24pt; font-weight:bold;
                       background: black; color: white; vertical-align: middle;
                       text-align: left; padding: 7px; border:black 1px solid}
   .titleTab td       {font-family: Arial; font-size: 16pt; font-weight:bold;
                       background: black; color: white; vertical-align: middle;
                       text-align: left; padding: 7px; border:black 1px solid}

   .hoverTab          {border-collapse:collapse}
   .hoverTab th       {font-family: Arial; font-size: 12pt; font-weight:bold;
                       background: #336699; color: white; vertical-align: top;
                       text-align: left; padding: 7px; border:#4e95f4 1px solid}
   .hoverTab td       {padding: 7px; border:#4e95f4 1px solid}
   .hoverTab tr:hover {background-color: yellow}
//-->
</style>
<script>
<!--
function disp(str) {
   document.getElementById("Area1").innerHTML = "";
   if (window.XMLHttpRequest) 
      xmlhttp = new XMLHttpRequest();
   else
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

   xmlhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
         document.getElementById("Area1").innerHTML = this.responseText;
         }
      }
   xmlhttp.open ("GET", "/ci/tbdesc1.php?tbname="+str, true);
   xmlhttp.send ();
}
function esql() {
   sql = document.getElementById("sql").value;
   document.getElementById("Area2").innerHTML = "";
   if (window.XMLHttpRequest) 
      xmlhttp2 = new XMLHttpRequest();
   else
      xmlhttp2 = new ActiveXObject("Microsoft.XMLHTTP");

   xmlhttp2.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
         document.getElementById("Area2").innerHTML = this.responseText;
         }
      }
   xmlhttp2.open ("GET", "/ci/exec_sql.php?sql="+sql, true);
   xmlhttp2.send ();
}
//-->
</script>
</head>

<body>
<table class="titleTab">
<tr>
<th>&nbsp;Critical Incidents Database</th>
<td width=15%><img src="/img/sony.jpg"></td>
<tr>
<td colspan=2>&nbsp;Ad Hoc Query</td>
</tr>
</table><p>


<form>
<table cellpadding=3>
<tr>
<td>
<b>Enter SQL Statement:</b><p>
<textarea id="sql" rows=10 cols=80>
</textarea>
<p>
<input type=button value="Run SQL" onclick="esql()">
</form>

</td>
<td>
<form method="get">
<b>View Table Description (optional): </b>
<select name="tbname" onchange="disp(this.value)">
<?php
// ============================================================================
// ============================================================================
include_once 'includes/ci_connect.php';
if ($conn->connect_error)
   trigger_error ('Database connection failed: ' . $conn->connect_error,  E_USER_ERROR);

if (empty($_POST["tbname"]))
   echo '<option value="">-Select Table to Display-</option>';

$sql='show tables';
$cur=$conn->query($sql);

$cur->data_seek(0);
while ($row = $cur->fetch_row()) {
   $cntsql = 'select count(*) from ' . $row[0];
   $cntcur = $conn->query($cntsql);
   $cntcur->data_seek(0);
   $cntrow = $cntcur->fetch_row();

   echo '<option value="' . $row[0] . '">' . $row[0] . ' ('.$cntrow[0].')' . '</option>';
   }

echo '</select></form><p>';
$conn->close();
?>

<div id="Area1">
</div>
<p>
</td>
</tr>
</table>

<div id="Area2">
</div>

</body>
</html>

