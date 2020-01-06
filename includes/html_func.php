<?php

// ============================================================================
// ============================================================================

function html_sel ($sname, $tbname) {
   include_once 'includes/ci_connect.php';
   echo '<select name="' . $sname . '">';

   if ($tbname == 'OpCo')
      $sql='select id, OpCo from '.$tbname.' order by id';
   else
      $sql='select id, val from '.$tbname.' order by seq';
   $cur=$conn->query($sql);

   $cur->data_seek(0);
   while ($row = $cur->fetch_row())
      echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';

   echo '</select>';
   }

?>
