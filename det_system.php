<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
?>

<html>
<head>
<title>CI System Detail</title>
<link rel="stylesheet" href="css/ci.css" type="text/css">
</head>

<body>
<?php
// ============================================================================
// ============================================================================

if (empty($_GET["id"]))
   exit("System ID must be specified");

include_once 'includes/ci_connect.php';
if ($conn->connect_error)
   trigger_error ('Database connection failed: ' . $conn->connect_error,  E_USER_ERROR);


// ============================================================================
// Query System if ID provided
// ============================================================================

if (empty($_GET["id"]))
   trigger_error ('Usage: det_system?id=[system id]');
else {

   $sql='SELECT s.id, s.hostname, st.val AS Status, s.purpose, s.description, o.OpCo,' .
               's.last_updated AS "Last Updated", s.created AS Created,' .
               's.created_by AS "CreatedBy", s.last_updated_by AS UpdatedBy' .
         ' FROM systems s ' .
         ' LEFT OUTER JOIN system_status_type st ON s.system_status_id = st.id ' .
         ' LEFT OUTER JOIN OpCo o ON s.OpCo_id = o.id ' .
        ' WHERE s.id = ' . $_GET["id"];

   $cur=$conn->query($sql);
   if ($cur == false)
      trigger_error ('SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);

   // ==========================================================================
   // Display System Detail
   // ==========================================================================

   $row = $cur->fetch_assoc();

   echo '<table border=1 cellpadding=6 cellspacing=0>';
   echo '<tr>';
   echo '<td width=25% align=right bgcolor=#cccccc><b>System ID:</b> </td>';
   echo '<td align=25%>' . $row["id"] . '</td>';
   echo '<td width=25% align=right bgcolor=#cccccc><b>Status:</b> </td>';
   echo '<td align=25%>' . $row["Status"] . '</td>';
   echo '</tr>';

   echo '<tr>';
   echo '<td align=right bgcolor=#cccccc><b>Hostname:</b> </td>';
   echo '<td>' . $row["hostname"] . '</td>';
   echo '<td align=right bgcolor=#cccccc><b>OpCo:</b> </td>';
   echo '<td>' . $row["OpCo"] . '</td>';
   echo '</tr>';

   echo '<tr>';
   echo '<td colspan=4 bgcolor=#cccccc><b>Description:</b> </td>';
   echo '</tr>';
   echo '<tr>';
   echo '<td colspan=4>' . (($row["description"]=='' || is_null($row["description"])) ? '&nbsp;' : $row["description"]) . '</td>';
   echo '</tr>';

   echo '<tr>';
   echo '<td colspan=4 bgcolor=#cccccc><b>Purpose:</b> </td>';
   echo '</tr>';
   echo '<tr>';
   echo '<td colspan=4>' . (($row["purpose"]=='' || is_null($row["purpose"])) ? '&nbsp;' : $row["purpose"]) . '</td>';
   echo '</tr>';

   echo '<tr>';
   echo '<td align=right bgcolor=#cccccc><b>Last Updated:</b> </td>';
   echo '<td>' . $row["Last Updated"] . '</td>';
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
   // Display Associated IP Addresses
   // ==========================================================================

   $sql='SELECT i.ip_addr, i.description, i.ip_type, i.start_dt,' .
               'i.last_updated AS "Updated", i.created AS Created, ' .
               'i.created_by AS "CreatedBy", i.last_updated_by AS UpdatedBy' .
         ' FROM ip_addrs i' .
              ' JOIN ip_addrs_systems ias ON ias.ip_addr_id = i.id' .
        ' WHERE ias.system_id = ' . $_GET["id"];

   $fcur=$conn->query($sql);

   if ($fcur == false)
      trigger_error ('SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);

   echo '<table class="hoverTab">';
   echo '<tr>';
   echo '<th colspan=5>Associated IP Address(es)</th>';
   echo '</tr>';
   echo '<tr>';
   echo '<th>IP Address</th>';
   echo '<th>IP Type</th>';
   echo '<th>Description</th>';
   echo '<th>Updated</th>';
   echo '<th>Created</th>';
   echo '</tr>';

   $cnt=0;
   while ($row = $fcur->fetch_assoc()) {
      if ($cnt++ % 2 == 1)
         echo '<tr bgcolor="#cccccc">';
      else
         echo '<tr>';

      echo '<td>' . $row["ip_addr"] . '</td>';
      echo '<td>' . $row["ip_type"] . '</td>';
      echo '<td>' . $row["description"] . '</td>';
      echo '<td>' . $row["Updated"] . '</td>';
      echo '<td>' . $row["Created"] . '</td>';
      echo '</tr>';
      }

   echo '<tr>';
   if ($cnt == 0)
      echo '<td colspan=5>No IP Address found</td>';
   echo '</tr>';
   echo '</table>';
   echo '<p>';

   // ==========================================================================
   // Display Associated Activities
   // ==========================================================================

   $sql='SELECT a.id,DATE_FORMAT(a.activity_date,"%Y-%m-%d") AS "Date", at1.val AS "Activity", at2.val AS Actor,' .
               'a.description AS Description' .
         ' FROM activity a' .
              ' JOIN activity_systems ats ON a.id = ats.activity_id' .
              ' LEFT OUTER JOIN activity_type at1 ON a.activity_type_id = at1.id' .
              ' LEFT OUTER JOIN actor_type at2 ON a.actor_type_id = at2.id' .
        ' WHERE ats.system_id = ' . $_GET["id"] .
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
   // Display Associated Users
   // ==========================================================================

   $sql='SELECT u.id, u.first_nm, u.last_nm, u.s_global_id,' .
               'u.display_nm, u.user_role, u.email, u.description, o.OpCo,' .
               'u.last_updated AS "Updated", u.created AS Created, ' .
               'u.created_by AS "CreatedBy", u.last_updated_by AS UpdatedBy' .
         ' FROM users u' .
              ' JOIN users_systems usys ON usys.user_id = u.id' .
              ' LEFT OUTER JOIN OpCo o ON u.OpCo_id = o.id' .
        ' WHERE usys.system_id = ' . $_GET["id"] .
        ' ORDER BY u.last_nm';

   $fcur=$conn->query($sql);

   if ($fcur == false)
      trigger_error ('SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);

   echo '<table class="hoverTab">';
   echo '<tr>';
   echo '<th colspan=5>Associated User(s)</th>';
   echo '</tr>';
   echo '<tr>';
   echo '<th>User</th>';
   echo '<th>SonyGlobalId</th>';
   echo '<th>DisplayNm</th>';
   echo '<th>OpCo</th>';
   echo '<th>Email</th>';
   echo '</tr>';

   $cnt=0;
   while ($row = $fcur->fetch_assoc()) {
      if ($cnt++ % 2 == 1)
         echo '<tr bgcolor="#cccccc">';
      else
         echo '<tr>';

      echo '<td>' . $row["last_nm"] . ', ' . $row["first_nm"] . '</td>';
      echo '<td>' . $row["s_global_id"] . '</td>';
      echo '<td>' . $row["display_nm"] . '</td>';
      echo '<td>' . $row["OpCo"] . '</td>';
      echo '<td>' . $row["email"] . '</td>';
      echo '</tr>';
      }

   echo '<tr>';
   if ($cnt == 0)
      echo '<td colspan=5>No Associated Users</td>';
   elseif ($cnt > 2)
      echo '<th colspan=5># Associated Users = ' . $cnt . '</th>';
   echo '</tr>';
   echo '</table>';
   echo '<p>';

   // ==========================================================================
   // ==========================================================================

   $cur->free();
   $fcur->free();
   $conn->close();
   }

?>

</p>
</body>
</html>

