<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
?>

<!-- ======================================================================= -->
<!-- ======================================================================= -->

<?php
if (empty($_GET["sql"]))
   exit("Missing SQL statement");

if (!empty($_GET["title"])) {
   echo '<table bgcolor=#003366 border=0 width=100% cellpadding=20 cellspacing=0>';
   echo '<tr>';
   echo '<td><font color=white size=3><b>'.$_GET["title"].'</b></font></td>';
   echo '</tr>';
   echo '</table><p>';
   }

include_once 'includes/ci_connect.php';
if ($conn->connect_error)
   trigger_error ('Database connection failed: ' . $conn->connect_error,  E_USER_ERROR);


// ============================================================================
// Display Table Values
// ============================================================================

$sql=$_GET["sql"];
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
      echo '<th>' . ucfirst($col->name) . '</th>';
echo '</tr>';
$ccur->close();

$cnt=0;
$cur->data_seek(0);
while ($row = $cur->fetch_row()) {
   if ($cnt++ % 2 == 0)
      echo '<tr bgcolor="#cccccc">';
   else
      echo '<tr>';

   for ($i=0; $i < $cur->field_count; $i++)
      echo '<td>' . $row[$i] . '</td>';
   echo '</tr>';
   }

echo '<tr>';
if ($cnt == 0)
   echo '<th colspan='.$cur->field_count.'>No Values</td>';
else
   echo '<th colspan='.$cur->field_count.'>Total = ' . $cnt . '</td>';
echo '</tr>';
echo '</table>';

$conn->close();
?>

