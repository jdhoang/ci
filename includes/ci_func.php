<!-- ======================================================================= -->
<!-- ======================================================================= -->

<?php

// =============================================================================
// Generate SELECT/OPTIONS 
// =============================================================================

function seloptions ($seln, $sql, $sval = NULL, $anyval = NULL, $opt = NULL) {
   global $conn;

   if (empty($opt))
      echo '<select id="'.$seln.'" name="'.$seln.'">';
   else
      echo '<select id="'.$seln.'" name="'.$seln.'" '.$opt.'>';

   if (!empty($anyval))
      echo '<option value="">' . $anyval . '</option>';

   $cur=$conn->query($sql);
   $cur->data_seek(0);
   while ($row = $cur->fetch_row())
      if (empty($sval) or ($sval != $row[0]))
         echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
      else
         echo '<option value="' . $row[0] . '" selected>' . $row[1] . '</option>';
   echo '</select>';
}


// =============================================================================
// Run SQL to return single value
// =============================================================================

function get_val ($sql) {
   global $conn;

   $cntcur = $conn->query($sql);
   if ($cntcur == false)
      trigger_error ('SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
   $cntcur->data_seek(0);
   $cntrow = $cntcur->fetch_row();
   $result = $cntrow[0];

   $cntcur->close();
   return $result;
}

?>

