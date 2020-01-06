<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<html>
<head>
<title>CI Critical Terms</title>
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
<table bgcolor=#003366 border=0 width=100% cellpadding=20 cellspacing=0>
<tr>
<td><font color=white size=3><b>CI Critical Terms</b></font></td>
</tr>
</table><p>

<?php
// ============================================================================
// ============================================================================

include_once 'includes/ci_connect.php';
mysqli_set_charset($conn,"utf8");
if ($conn->connect_error)
   trigger_error ('Database connection failed: ' . $conn->connect_error,  E_USER_ERROR);


// ============================================================================
// Display Table Values if Selected
// ============================================================================

$sql='SELECT ct.id, ct.term, ct.description, ctt.val AS "Type", ctc.val as Category,' .
            'cts.val AS Status,' .
            'DATE_FORMAT (ct.last_updated,"%Y-%m-%d") AS "Updated", DATE_FORMAT (ct.created,"%Y-%m-%d") AS Created' .
      ' FROM critical_terms ct' .
           ' LEFT OUTER JOIN critical_terms_type ctt ON ct.critical_term_type_id = ctt.id' .
           ' LEFT OUTER JOIN ct_category_type ctc  ON ct.ct_category_id = ctc.id' .
           ' LEFT OUTER JOIN ct_status_type cts  ON ct.ct_status_id = cts.id' .
           ' LEFT OUTER JOIN organizations o  ON ct.organization_id = o.id';

$cur=$conn->query($sql);

if ($cur == false)
   trigger_error ('SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);

// ==========================================================================
// Display Column Names
// ==========================================================================

echo '<table class="hoverTab">';
echo '<tr>';
if ($ccur = $conn->query($sql))
   while ($col = $ccur->fetch_field())
      echo '<th>' . $col->name . '</th>';
echo '</tr>';
$ccur->close();

$cnt=0;
$cur->data_seek(0);
while ($row = $cur->fetch_row()) {
   if ($cnt++ % 2 == 0)
      echo '<tr bgcolor="lightblue">';
   else
      echo '<tr>';

   for ($i=0; $i < $cur->field_count; $i++)
      /*
      if ($i==0)
         echo '<td><a href="/activity.php?id=' . $row[$i] . '" target="_blank">' .
              $row[$i] . '</a></td>';
      else
      */
         echo '<td>' . $row[$i] . '</td>';
   echo '</tr>';
   }

echo '<tr>';
if ($cnt == 0)
   echo '<td colspan='.$cur->field_count.'>No Values</td>';
else
   echo '<th colspan='.$cur->field_count.'>Total = ' . $cnt . '</th>';
echo '</tr>';
echo '</table>';


$conn->close();
?>

</p>
</body>
</html>

