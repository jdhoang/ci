<?php
//if (empty($_GET["date_from"]) and empty($_GET["date_to"])) {
//   echo '<script>';
//   echo 'document.FRM.date_from.value = Date.today().add(-7).days().toString ("yyyy-M-d");';
//   echo 'document.FRM.date_to.value = Date.today().toString ("yyyy-M-d");';
//   echo '</script>';
//   }


// ============================================================================
// ============================================================================
include_once 'includes/ci_connect.php';
if ($conn->connect_error)
   trigger_error ('Database connection failed: ' . $conn->connect_error,  E_USER_ERROR);


// ============================================================================
// Build Select Statement
// ============================================================================

$sql='SELECT a.id,DATE_FORMAT(a.activity_date,"%Y-%m-%d") AS "Date", at1.val AS "Activity", at2.val AS "Detail",' .
            'a.description AS Description,' .
           ' IFNULL(s.hostname, "") AS Host, IFNULL(i.ip_addr,"") AS "IP" ';
$frm_clause=' FROM activity a ' .
                 ' INNER JOIN activity_type at1 ON at1.id = a.activity_type_id ' .
                 ' INNER JOIN act_sub_type at2 ON at2.id = a.act_sub_type_id' .
                 ' LEFT OUTER JOIN activity_systems acs ON acs.activity_id = a.id' .
                 ' LEFT OUTER JOIN systems s ON s.id = acs.system_id' .
                 ' LEFT OUTER JOIN activity_ip_addrs ai ON ai.activity_id = a.id' .
                 ' LEFT OUTER JOIN ip_addrs i ON i.id = ai.ip_addr_id';

if (!empty($_GET["date_from"]) and !empty($_GET["date_to"]))
   $wh_clause=' where a.activity_date BETWEEN "' . $_GET["date_from"] . '" AND "' . $_GET["date_to"] . '"';
elseif (!empty($_GET["date_from"]) and empty($_GET["date_to"]))
   $wh_clause=' where a.activity_date >= "' . $_GET["date_from"] . '"';
elseif (empty($_GET["date_from"]) and !empty($_GET["date_to"]))
   $wh_clause=' where a.activity_date <= "' . $_GET["date_to"] . '"';
else
   $wh_clause='';

if (!empty($_GET["act_id"])) {
   $wh_clause=(empty($wh_clause) ? ' where' : $wh_clause . ' and') . ' at1.id = ' . $_GET["act_id"];
   if (!empty($_GET["subact_id"])) 
      $wh_clause=$wh_clause . ' and ' . 'at2.id = ' . $_GET["subact_id"];
   }

if (!empty($_GET["desc"]))
   $wh_clause=(empty($wh_clause) ? ' where' : $wh_clause . ' and') . ' a.description like "%' . $_GET["desc"] . '%"';

if (!empty($_GET["hostn"]))
   $wh_clause=(empty($wh_clause) ? ' where' : $wh_clause . ' and') . ' s.hostname like "'.$_GET["hostn"].'%" ';

if (!empty($_GET["ipaddr"]))
   $wh_clause=(empty($wh_clause) ? ' where' : $wh_clause . ' and') . ' i.ip_addr like "'.$_GET["ipaddr"].'%" ';


$sql=$sql . $frm_clause . $wh_clause . ' ORDER BY a.activity_date DESC';
// echo $sql;
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
      if ($col->name == 'Description')
         echo '<th width=40%>' . $col->name . '</th>';
      else
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
      if ($i==0)
         echo '<td><a href="/ci/activity.php?id=' . $row[$i] . '" target="_blank">' .
              $row[$i] . '</a></td>';
      else
         echo '<td>' . $row[$i] . '</td>';
   echo '</tr>';
   }

echo '<tr>';
if ($cnt == 0)
   echo '<td colspan='.$cur->field_count.'>No Records Found</td>';
else
   echo '<th colspan='.$cur->field_count.'>Total = ' . $cnt . '</th>';
echo '</tr>';
echo '</table>';

// ==========================================================================
// ==========================================================================

$cur->free();
$conn->close();

?>

