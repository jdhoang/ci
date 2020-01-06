<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
?>

<html>
<head>
<title>Critical Incidents Activity Detail</title>
<link rel="stylesheet" href="css/ci.css" type="text/css">
</head>

<body>
<table class="titleTab">
<tr>
<th>&nbsp;CI Activities Detail</th>
<td width=20%><img src="/img/xxx.jpg"></td>
</tr>
</table><p>


<?php
// ============================================================================
// ============================================================================

if (empty($_GET["id"]))
   exit("Activity ID must be specified");

include_once 'includes/ci_connect.php';
if ($conn->connect_error)
   trigger_error ('Database connection failed: ' . $conn->connect_error,  E_USER_ERROR);


// ============================================================================
// Query Table Values if Selected
// ============================================================================

$sql='SELECT a.id,DATE_FORMAT(a.activity_date,"%Y-%m-%d") AS "Date", at1.val AS "Activity", at2.val AS "Detail", ac2.val AS Actor,' .
           ' a.description AS Description,' .
            'a.last_updated AS "Last Updated", a.created AS Created,' .
            'a.created_by AS "CreatedBy", a.last_updated_by AS UpdatedBy,' .
            'a.act_type, a.act_method, a.act_src, a.act_hop_point, a.act_dst' .
      ' FROM activity a' .
           ' INNER JOIN activity_type at1 ON at1.id = a.activity_type_id' .
           ' INNER JOIN act_sub_type at2 ON at2.id = a.act_sub_type_id' .
           ' INNER JOIN actor_type ac2  ON ac2.id = a.actor_type_id' .
    ' WHERE a.id = ' . $_GET["id"];
$cur=$conn->query($sql);

if ($cur == false)
   trigger_error ('SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);

// ==========================================================================
// Display Activity Detail
// ==========================================================================

$row = $cur->fetch_assoc();

echo '<table width=60% border=1 cellpadding=6 cellspacing=6>';
echo '<tr>';
// echo '<td width=25% align=right bgcolor=#cccccc><b>Activity ID:</b> </td>';
// echo '<td align=25%>' . $row["id"] . '</td>';
echo '<td width=25% align=right bgcolor=#cccccc><b>Activity Date:</b> </td>';
echo '<td align=25%>' . $row["Date"] . '</td>';
echo '<td width=25% align=right bgcolor=#cccccc><b>Actor:</b> </td>';
echo '<td width=25%>' . $row["Actor"] . '</td>';
echo '</tr>';

echo '<tr>';
echo '<td align=right bgcolor=#cccccc><b>Activity Type:</b> </td>';
echo '<td>' . $row["Activity"] . '</td>';
echo '<td align=right bgcolor=#cccccc><b>Activity Detail:</b> </td>';
echo '<td>' . $row["Detail"] . '</td>';
echo '</tr>';

echo '<tr>';
echo '<td align=right bgcolor=#cccccc><b>Method:</b> </td>';
echo '<td>' . $row["act_method"] . '</td>';
echo '<td align=right bgcolor=#cccccc><b>Source:</b> </td>';
echo '<td>' . $row["act_src"] . '</td>';
echo '</tr>';

echo '<tr>';
echo '<td align=right bgcolor=#cccccc><b>Hop Point:</b> </td>';
echo '<td>' . $row["act_hop_point"] . '</td>';
echo '<td align=right bgcolor=#cccccc><b>Destination:</b> </td>';
echo '<td>' . $row["act_dst"] . '</td>';
echo '</tr>';

echo '<tr>';
echo '<tr>';
echo '<td colspan=4 bgcolor=#cccccc><b>Description:</b> </td>';
echo '</tr>';
echo '<tr>';
echo '<td colspan=4>' . (($row["Description"]=='' || is_null($row["Description"])) ? '&nbsp;' : $row["Description"]) . '</td>';
echo '</tr>';

echo '<tr>';
echo '<td align=right bgcolor=#cccccc><b>Last Updated:</b> </td>';
echo '<td>' . $row["Last Updated"] . '</td>';
echo '<td align=right bgcolor=#cccccc><b>Last Updated By:</b> </td>';
// echo '<td>' . (($row["UpdatedBy"]=='' || is_null($row["UpdatedBy"])) ? '&nbsp;' : $row["UpdatedBy"]) . '</td>';
echo '<td>' . $row["UpdatedBy"] . '</td>';
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
// Display Associated Systems w/Activity
// ==========================================================================

$sql='SELECT s.hostname, st.val AS Status, s.purpose, s.description, o.OpCo,' .
            's.last_updated AS "Updated", s.created AS Created, ' .
            's.created_by AS "CreatedBy", s.last_updated_by AS UpdatedBy' .
      ' FROM systems s' .
           ' JOIN activity_systems ats ON ats.system_id = s.id' .
           ' LEFT OUTER JOIN system_status_type st ON s.system_status_id = st.id' .
           ' LEFT OUTER JOIN OpCo o ON s.OpCo_id = o.id' .
     ' WHERE ats.activity_id = ' . $_GET["id"];

$fcur=$conn->query($sql);

if ($fcur == false)
   trigger_error ('SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);

echo '<table class="hoverTab">';
echo '<tr>';
echo '<th colspan=6>Associated System(s)</th>';
echo '</tr>';
echo '<tr>';
echo '<th>Hostname</th>';
echo '<th>Status</h>';
echo '<th>Purpose</h>';
echo '<th>OpCo</h>';
echo '<th>Updated</h>';
echo '<th>Created</h>';
echo '</tr>';

$cnt=0;
while ($row = $fcur->fetch_assoc()) {
   if ($cnt++ % 2 == 1)
      echo '<tr bgcolor="#cccccc">';
   else
      echo '<tr>';

   echo '<td>' . $row["hostname"] . '</td>';
   echo '<td>' . $row["Status"] . '</td>';
   echo '<td>' . $row["purpose"] . '</td>';
   echo '<td>' . $row["OpCo"] . '</td>';
   echo '<td>' . $row["Updated"] . '</td>';
   echo '<td>' . $row["Created"] . '</td>';
   echo '</tr>';
   }

echo '<tr>';
if ($cnt == 0)
   echo '<td colspan=6>No Associated Systems</td>';
elseif ($cnt > 2)
   echo '<th colspan=6># Associated Systems = ' . $cnt . '</th>';
echo '</tr>';
echo '</table>';
echo '<p>';


// ==========================================================================
// Display Associated Files w/Activity
// ==========================================================================

$sql='SELECT f.filename, f.path, f.purpose, f.description,' .
            'f.last_updated AS "Updated", f.created AS Created,' .
            'f.created_by AS "CreatedBy", f.last_updated_by AS UpdatedBy' .
      ' FROM files f, activity_files af' .
     ' WHERE af.activity_id = ' . $_GET["id"] .
       ' AND af.file_id = f.id';
$fcur=$conn->query($sql);

if ($fcur == false)
   trigger_error ('SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);

echo '<table class="hoverTab">';
echo '<tr>';
echo '<th colspan=5>Associated File(s)</th>';
echo '</tr>';
echo '<tr>';
echo '<th>Filename</th>';
echo '<th>Path</h>';
echo '<th>Purpose</h>';
echo '<th>Updated</h>';
echo '<th>Created</h>';
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
   echo '<td>' . $row["Updated"] . '</td>';
   echo '<td>' . $row["Created"] . '</td>';
   echo '</tr>';
   }

echo '<tr>';
if ($cnt == 0)
   echo '<td colspan=5>No Associated Files</td>';
elseif ($cnt > 2)
   echo '<th colspan=5># Associated Files = ' . $cnt . '</th>';
echo '</tr>';
echo '</table>';
echo '<p>';


// ==========================================================================
// Display Associated Users w/Activity
// ==========================================================================

$sql='SELECT CONCAT (u.last_nm,", ",u.first_nm) AS "Name", u.s_global_id AS SGlobalID, u.display_nm AS DisplayNm,' .
            'u.description, o.OpCo' .
      ' FROM users u' .
           ' JOIN activity_users atu ON atu.user_id = u.id' .
           ' LEFT OUTER JOIN OpCo o ON u.OpCo_id = o.id' .
     ' WHERE atu.activity_id = ' . $_GET["id"];

$fcur=$conn->query($sql);

if ($fcur == false)
   trigger_error ('SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);

echo '<table class="hoverTab">';
echo '<tr>';
echo '<th colspan=6>Associated User(s)</th>';
echo '</tr>';
echo '<tr>';
echo '<th>User Name</th>';
echo '<th>S GlobalID</h>';
echo '<th>DisplayNm</h>';
echo '<th>OpCo</h>';
echo '<th>Description</h>';
echo '</tr>';

$cnt=0;
while ($row = $fcur->fetch_assoc()) {
   if ($cnt++ % 2 == 1)
      echo '<tr bgcolor="#cccccc">';
   else
      echo '<tr>';

   echo '<td>' . $row["Name"] . '</td>';
   echo '<td>' . $row["SGlobalID"] . '</td>';
   echo '<td>' . $row["DisplayNm"] . '</td>';
   echo '<td>' . $row["OpCo"] . '</td>';
   echo '<td>' . $row["description"] . '</td>';
   echo '</tr>';
   }

echo '<tr>';
if ($cnt == 0)
   echo '<td colspan=6>No Associated Users</td>';
elseif ($cnt > 2)
   echo '<th colspan=6># Associated Users = ' . $cnt . '</th>';
echo '</tr>';
echo '</table>';
echo '<p>';


// ==========================================================================
// Display Associated Critical Terms w/Activity
// ==========================================================================

$sql='SELECT ct.term, ct.description, ctt.val AS "Type", ctc.val as Category,' .
            'cts.val AS Status, o.name AS ORG,' .
            'ct.last_updated AS "Updated", ct.created AS Created, ' .
            'ct.created_by AS "CreatedBy", ct.last_updated_by AS UpdatedBy' .
      ' FROM critical_terms ct' .
           ' JOIN activity_critical_terms act ON act.critical_term_id = ct.id' .
           ' LEFT OUTER JOIN critical_terms_type ctt ON ct.critical_term_type_id = ctt.id' .
           ' LEFT OUTER JOIN ct_category_type ctc  ON ct.ct_category_id = ctc.id' .
           ' LEFT OUTER JOIN ct_status_type cts  ON ct.ct_status_id = cts.id' .
           ' LEFT OUTER JOIN organizations o  ON ct.organization_id = o.id' .
     ' WHERE act.activity_id = ' . $_GET["id"];

$fcur=$conn->query($sql);

if ($fcur == false)
   trigger_error ('SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);

echo '<table class="hoverTab">';
echo '<tr>';
echo '<th colspan=8>Associated Critical Term(s)</th>';
echo '</tr>';
echo '<tr>';
echo '<th>Term</th>';
echo '<th>Description</h>';
echo '<th>Type</h>';
echo '<th>Category</h>';
echo '<th>Status</h>';
echo '<th>Org</h>';
echo '<th>Updated</h>';
echo '<th>Created</h>';
echo '</tr>';

$cnt=0;
while ($row = $fcur->fetch_assoc()) {
   if ($cnt++ % 2 == 1)
      echo '<tr bgcolor="#cccccc">';
   else
      echo '<tr>';

   echo '<td>' . $row["term"] . '</td>';
   echo '<td>' . $row["description"] . '</td>';
   echo '<td>' . $row["Type"] . '</td>';
   echo '<td>' . $row["Category"] . '</td>';
   echo '<td>' . $row["Status"] . '</td>';
   echo '<td>' . $row["Org"] . '</td>';
   echo '<td>' . $row["Updated"] . '</td>';
   echo '<td>' . $row["Created"] . '</td>';
   echo '</tr>';
   }

echo '<tr>';
if ($cnt == 0)
   echo '<td colspan=8>No Associated Critical Term</td>';
elseif ($cnt > 2)
   echo '<th colspan=8># Associated Critical Term = ' . $cnt . '</th>';
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

