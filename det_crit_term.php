<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
?>

<html>
<head>
<title>Critical Term Detail</title>
<link rel="stylesheet" href="css/ci.css" type="text/css">
</head>

<body>
<?php
// ============================================================================
// ============================================================================

if (empty($_GET["id"]))
   exit("Critical Term ID must be specified");

include_once 'includes/ci_connect.php';
if ($conn->connect_error)
   trigger_error ('Database connection failed: ' . $conn->connect_error,  E_USER_ERROR);


// ============================================================================
// Query System if ID provided
// ============================================================================


$sql='SELECT ct.id, ct.term, ct.description, ctt.val AS "Type", ctc.val as Category,' .
            'cts.val AS Status, o.name AS Org,' .
            'ct.last_updated AS "Updated", ct.created AS Created,' .
            'ct.created_by AS "CreatedBy", ct.last_updated_by AS UpdatedBy' .
      ' FROM critical_terms ct' .
           ' LEFT OUTER JOIN critical_terms_type ctt ON ct.critical_term_type_id = ctt.id' .
           ' LEFT OUTER JOIN ct_category_type ctc  ON ct.ct_category_id = ctc.id' .
           ' LEFT OUTER JOIN ct_status_type cts  ON ct.ct_status_id = cts.id' .
           ' LEFT OUTER JOIN organizations o  ON ct.organization_id = o.id';

$cur=$conn->query($sql);
if ($cur == false)
   trigger_error ('SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);

// ==========================================================================
// Display Critical Term Detail
// ==========================================================================

$row = $cur->fetch_assoc();

   echo '<table border=1 cellpadding=6 cellspacing=0>';
   echo '<tr>';
   echo '<td width=25% align=right bgcolor=#cccccc><b>ID:</b> </td>';
   echo '<td align=25%>' . $row["id"] . '</td>';
   echo '<td width=25% align=right bgcolor=#cccccc><b>Status:</b> </td>';
   echo '<td align=25%>' . $row["Status"] . '</td>';
   echo '</tr>';
   echo '<tr>';
   echo '<td width=25% align=right bgcolor=#cccccc><b>Type:</b> </td>';
   echo '<td align=25%>' . $row["Type"] . '</td>';
   echo '<td width=25% align=right bgcolor=#cccccc><b>Category:</b> </td>';
   echo '<td align=25%>' . $row["Category"] . '</td>';
   echo '</tr>';

   echo '<tr>';
   echo '<td align=right bgcolor=#cccccc><b>Critical Term:</b> </td>';
   echo '<td colspan=3>' . $row["term"] . '</td></tr>';
   echo '<tr><td align=right bgcolor=#cccccc><b>Description:</b> </td>';
   echo '<td colspan=3>' . (($row["description"]=='' || is_null($row["description"])) ? '&nbsp;' : $row["description"]) . '</td>';
   echo '<tr><td align=right bgcolor=#cccccc><b>Organization:</b> </td>';
   echo '<td colspan=3>' . (($row["Org"]=='' || is_null($row["Org"])) ? '&nbsp;' : $row["Org"]) . '</td>';

   echo '<tr>';
   echo '<td align=right bgcolor=#cccccc><b>Last Updated:</b> </td>';
   echo '<td>' . $row["Updated"] . '</td>';
   echo '<td align=right bgcolor=#cccccc><b>Last Updated By:</b> </td>';
   echo '<td colspan=2>' . (($row["UpdatedBy"]=='' || is_null($row["UpdatedBy"])) ? '&nbsp;' : $row["UpdatedBy"]) . '</td>';
   echo '</tr>';

   echo '<tr>';
   echo '<td align=right bgcolor=#cccccc><b>Created:</b> </td>';
   echo '<td>' . $row["Created"] . '</td>';
   echo '<td align=right bgcolor=#cccccc><b>Created By:</b> </td>';
   echo '<td>' . $row["CreatedBy"] . '</td>';
   echo '</tr>';

   echo '</table>';
   echo '<p>';

   // ==========================================================================
   // Display Associated Activities
   // ==========================================================================

   $sql='SELECT a.id,DATE_FORMAT(a.activity_date,"%Y-%m-%d") AS "Date", at1.val AS "Activity", at2.val AS Actor,' .
               'a.description AS Description' .
         ' FROM activity a' .
              ' JOIN activity_critical_terms act ON a.id = act.activity_id' .
              ' LEFT OUTER JOIN activity_type at1 ON a.activity_type_id = at1.id' .
              ' LEFT OUTER JOIN actor_type at2 ON a.actor_type_id = at2.id' .
        ' WHERE act.critical_term_id = ' . $_GET["id"] .
        ' ORDER BY a.activity_date';

   $fcur=$conn->query($sql);

   if ($fcur == false)
      trigger_error ('SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);

   echo '<table class="hoverTab">';
   echo '<tr>';
   echo '<th colspan=5>Associated Activity(ies)</th>';
   echo '</tr>';
   echo '<tr>';
   echo '<th>ID</th>';
   echo '<th>Date</th>';
   echo '<th>Activity</th>';
   echo '<th>Actor</th>';
   echo '<th>Description</th>';
   echo '</tr>';

   $cnt=0;
   while ($row = $fcur->fetch_assoc()) {
   if ($cnt++ % 2 == 1)
      echo '<tr bgcolor="#cccccc">';
   else
      echo '<tr>';

   echo '<td>' . $row["id"] . '</td>';
   echo '<td>' . $row["Date"] . '</td>';
   echo '<td>' . $row["Activity"] . '</td>';
   echo '<td>' . $row["Actor"] . '</td>';
   echo '<td>' . $row["Description"] . '</td>';
   echo '</tr>';
   }

   echo '<tr>';
   if ($cnt == 0)
      echo '<td colspan=5>No Associated Activity</td>';
   elseif ($cnt > 2)
      echo '<th colspan=5># Associated Activities = ' . $cnt . '</th>';
   echo '</tr>';
   echo '</table>';
   echo '<p>';


   // ==========================================================================
   // Display Associated Files
   // ==========================================================================

   $sql='SELECT f.filename, f.path, f.purpose, mt.family AS Malware,'.
               'f.last_updated AS "Updated", f.created AS Created, ' .
               'f.created_by AS "CreatedBy", f.last_updated_by AS UpdatedBy' .
         ' FROM files f' .
              ' JOIN file_critical_terms fct ON fct.file_id = f.id' .
              ' LEFT OUTER JOIN malware mt ON f.malware_id= mt.id' .
        ' WHERE fct.critical_term_id = ' . $_GET["id"] .
        ' ORDER BY f.filename';

   $fcur=$conn->query($sql);

   if ($fcur == false)
      trigger_error ('SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);

   echo '<table class="hoverTab">';
   echo '<tr>';
   echo '<th colspan=5>Associated User(s)</th>';
   echo '</tr>';
   echo '<tr>';
   echo '<th>Filename</th>';
   echo '<th>Path</th>';
   echo '<th>Purpose</th>';
   echo '<th>Malware</th>';
   echo '</tr>';

   $cnt=0;
   while ($row = $fcur->fetch_assoc()) {
      if ($cnt++ % 2 == 1)
         echo '<tr bgcolor="#cccccc">';
      else
         echo '<tr>';

      echo '<td>' . $row["filename"] . '</td>';
      echo '<td>' . $row["path"] . '</td>';
      echo '<td>' . $row["purpose"] . '</td>';
      echo '<td>' . $row["malware"] . '</td>';
      echo '</tr>';
      }

   echo '<tr>';
   if ($cnt == 0)
      echo '<td colspan=4>No Associated Files</td>';
   elseif ($cnt > 2)
      echo '<th colspan=4># Associated Files = ' . $cnt . '</th>';
   echo '</tr>';
   echo '</table>';
   echo '<p>';

   // ==========================================================================
   // ==========================================================================

   $cur->free();
   $fcur->free();
   $conn->close();

?>

</p>
</body>
</html>

