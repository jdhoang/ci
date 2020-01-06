<?php

// =============================================================================
// Generate SELECT/OPTIONS 
// =============================================================================

function seloptions ($seln, $sql, $sval = NULL) {
   global $conn;

   echo '<select name="'.$seln.'">';
   $cur=$conn->query($sql);

   $cur->data_seek(0);
   while ($row = $cur->fetch_row())
      if (empty($sval) or ($sval != $row[0]))
         echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
      else
         echo '<option value="' . $row[0] . '" selected>' . $row[1] . '</option>';
   echo '</select>';
}

?>

