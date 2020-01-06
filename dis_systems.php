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

if (empty($_GET["sys_nm"]))
   trigger_error ('Usage: dis_system?sys_nm=[system name]');
else {

// ============================================================================
// ============================================================================

   $sql='SELECT s.id AS ID, s.hostname AS Hostname, st.val AS Status, s.purpose AS Purpose, s.description AS Description, o.OpCo' .
         ' FROM systems s ' .
         ' LEFT OUTER JOIN system_status_type st ON s.system_status_id = st.id ' .
         ' LEFT OUTER JOIN OpCo o ON s.OpCo_id = o.id ' .
        ' WHERE s.hostname LIKE "%' . $_GET["sys_nm"] . '%"' .
        ' ORDER BY s.hostname';

// echo $sql;
// exit;
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
         echo '<td><a href="javascript:void(0);" onclick="DetSys(' . $row[$i] . ')">' .
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
   }
?>

