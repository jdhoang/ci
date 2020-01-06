<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
?>

<html>
<head>
<title>Critical Incidents Activities</title>
<link rel="stylesheet" href="css/ci.css" type="text/css">

</head>

<body>
<table bgcolor=#003366 border=0 width=100% cellpadding=20 cellspacing=0>
<tr>
<td><font color=white size=3><b>CI Activities</b></font></td>
</tr>
</table><p>

<?php
// ============================================================================
// ============================================================================

include_once 'includes/ci_connect.php';
if ($conn->connect_error)
   trigger_error ('Database connection failed: ' . $conn->connect_error,  E_USER_ERROR);

// ============================================================================
// ============================================================================

$sql='SELECT a.id,DATE_FORMAT(a.activity_date,"%Y-%m-%d") AS "Date", at1.val AS "Activity", at2.val AS "Detail", ' .
           ' a.description AS Description,' .
           ' IFNULL(s.hostname, "") AS Host, IFNULL(i.ip_addr,"") AS "IP" ' .
      ' FROM activity a' .
           ' INNER JOIN activity_type at1 ON at1.id = a.activity_type_id' .
           ' INNER JOIN act_sub_type at2 ON at2.id = a.act_sub_type_id' .
           ' LEFT OUTER JOIN activity_systems acs ON acs.activity_id = a.id' .
           ' LEFT OUTER JOIN systems s ON s.id = acs.system_id' .
           ' LEFT OUTER JOIN activity_ip_addrs ai ON ai.activity_id = a.id' .
           ' LEFT OUTER JOIN ip_addrs i ON i.id = ai.ip_addr_id' .
     ' ORDER BY a.activity_date DESC';

$cur=$conn->query($sql);

if ($cur == false)
   trigger_error ('SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);

// ==========================================================================
// Display Column Names
// ==========================================================================

echo '<table class="hoverTab">';
echo '<tr>';
echo '<th>Id</th>';
echo '<th width=7%>Date</th>';
echo '<th>Activity</th>';
echo '<th>Detail</th>';
echo '<th width=%>Description</th>';
echo '<th width=8%>Host</th>';
echo '<th width=8%>IP</th>';
echo '</tr>';

$cnt=0;
$cur->data_seek(0);
while ($row = $cur->fetch_row()) {
   if ($cnt++ % 2 == 0)
      echo '<tr bgcolor="lightblue">';
   else
      echo '<tr>';

   for ($i=0; $i < $cur->field_count; $i++)
      if ($i==0)
         echo '<td><a href="activity.php?id=' . $row[$i] . '" target="_blank">' .
              $row[$i] . '</a></td>';
      else
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

