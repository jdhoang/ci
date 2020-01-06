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
// ============================================================================

$sql='SELECT a.id,DATE_FORMAT(a.activity_date,"%Y-%m-%d") AS "Date", at1.val AS "Activity", at2.val AS Actor,' .
            'a.description AS Description' .
      ' FROM activity a, activity_type at1, actor_type at2' .
     ' WHERE a.activity_type_id = at1.id AND a.actor_type_id = at2.id';

if (!empty($_GET["date_from"]) and !empty($_GET["date_to"]))
   $sql=$sql . ' AND a.activity_date BETWEEN "' . $_GET["date_from"] . '" AND "' . $_GET["date_to"] . '"';

elseif (!empty($_GET["date_from"]) and empty($_GET["date_to"]))
   $sql=$sql . ' AND a.activity_date >= "' . $_GET["date_from"] . '"';

elseif (empty($_GET["date_from"]) and !empty($_GET["date_to"]))
   $sql=$sql . ' AND a.activity_date <= "' . $_GET["date_to"] . '"';

if (!empty($_GET["desc"]))
   $sql=$sql . ' AND a.description like "%' . $_GET["desc"] . '%"';

$sql=$sql . ' ORDER BY a.activity_date DESC';


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

