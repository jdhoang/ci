<?php

// ============================================================================
// ============================================================================

function html_sel ($sname, $tbname) {
   if ($conn->connect_error)
      trigger_error ('Database connection failed: ' . $conn->connect_error,  E_USER_ERROR);
   echo '<select name="' . $sname . '">';

   if ($tbname == 'OpCo')
      $sql='select id, OpCo from '.$tbname.' order by seq';
   else
      $sql='select id, val from '.$tbname.' order by seq';
   $cur=$conn->query($sql);

   $cur->data_seek(0);
   while ($row = $cur->fetch_row())
      echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';

   echo '</select>';
   $conn->close();
   }

?>
