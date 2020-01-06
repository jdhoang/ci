<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
?>

<html>
<head>
<title>Critical Incidents TYPE Tables</title>
<style>
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

   .hoverTab          {width:100%; border-collapse:collapse}
   .hoverTab th       {font-family: Arial; font-size: 12pt; font-weight:bold;
                       background: #336699; color: white; vertical-align: top;
                       text-align: center; padding: 7px; border:#4e95f4 1px solid}
   .hoverTab td       {padding: 7px; border:#4e95f4 1px solid}
   .hoverTab tr:hover {background-color: lightyellow}
//-->
</style>
</head>

<body>
<table bgcolor=#003366 border=0 width=100% cellpadding=10 cellspacing=0>
<tr>
<td><font color=white size=3><b>Critical Incidents TYPE Tables</b></font></td>
</tr>
</table><p>

<?php
// ============================================================================
// ============================================================================

include_once 'includes/ci_connect.php';
if ($conn->connect_error) {
   trigger_error ('Database connection failed: ' . $conn->connect_error,  E_USER_ERROR);
   }


// ============================================================================
// ============================================================================

echo '<form method="post" action="dis_typ.php">';
echo '<b>Select TYPE Table: </b>';
echo '<select name="tbname" onchange="this.form.submit()">';
if (empty($_POST["tbname"])) {
   echo '<option value="">-Select Table to Display-</option>';
   }

$sql='show tables like "%_type"';
$cur=$conn->query($sql);

$cur->data_seek(0);
while ($row = $cur->fetch_row()) {
   $cntsql = 'select count(*) from ' . $row[0];
   $cntcur = $conn->query($cntsql);
   $cntcur->data_seek(0);
   $cntrow = $cntcur->fetch_row();

   if ($_POST["tbname"] == $row[0]) {
      echo '<option value="' . $row[0] . '" selected>' . $row[0] . ' ('.$cntrow[0].')' . '</option>';
      }
   else {
      echo '<option value="' . $row[0] . '">' . $row[0] . ' ('.$cntrow[0].')' . '</option>';
      }
   }

echo '</select></form><p>';

// ============================================================================
// ============================================================================

if (!empty($_POST["tbname"])) {
   $sql='SELECT seq, val FROM ' . $_POST["tbname"] . ' ORDER BY seq';
   $cur=$conn->query($sql);

   if ($cur == false) {
      trigger_error ('SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
      }

   echo '<table class="hoverTab">';
   echo '<tr>';
   echo '<th width=10%>Seq</th>';
   echo '<th>Value</h>';
   echo '</tr>';

   $cnt=0;
   $cur->data_seek(0);
   while ($row = $cur->fetch_assoc()) {
      if ($cnt++ % 2 == 0) {
         echo '<tr bgcolor="#cccccc">';
         }
      else {
         echo '<tr>';
         }
      echo '<td>' . $row['seq'] . '</td>';
      echo '<td>' . $row['val'] . '</td>';
      echo '</tr>';
      }

   if ($cnt == 0) {
      echo '<td colspan=2>No Values</td>';
      }
   else {
      echo '<td colspan=2>Total = ' . $cnt . '</td>';
      }

   }
?>

</p>
</body>
</html>

