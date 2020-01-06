<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
?>

<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<html>
<head>
<title>Add New Critical Term</title>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="styles/ac.css">
<link rel="stylesheet" href="css/ci.css" type="text/css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript">   
<!--
$(function(){
   $('#cterm').autocomplete({
      source: '/ci/ac_crit_term.php'
      });
   });
function Sub(){
   var errm = "";
   if (document.getElementById("term").value == "")
      errm = "Critical Term is required!";
      
   if (errm != "")
      alert (errm);
   else
      document.FRM.submit();
   }
//-->
</script>
</head>

<body>
<?php
if (empty($_GET["term"])) {
   echo '<table bgcolor=#003366 border=0 width=100% cellpadding=20 cellspacing=0>';
   echo '<tr>';
   echo '<td><font color=white size=3><b>Add New Critical Term</b></font></td>';
   echo '</tr>';
   echo '</table><p>';
   $term="";
   }
else
   $term=$_GET["term"];

$description=(empty($_GET["description"]) ? "" : $_GET["description"]);

echo '<form name=FRM action="inp_crit_term.php" method="post">';
echo '<table frame=border cellspacing=0 cellpadding=10>';
echo '<tr>';
echo '<th colspan=6>Please add new Critial Term Details:</th>';
echo '</tr>';
echo '<tr>';
echo '<td align=right><b>Critical Term:</b></td>';
echo '<td colspan=5><input type=text id=cterm name=term maxlength=512 size=100 value="'.$term.'"></td></tr>';

// =============================================================================
// Select Critical Term Type
// =============================================================================

echo '<td align=right><b>Type:</b></td>';
echo '<td>';
   include_once 'includes/ci_connect.php';
   echo '<select name="critial_term_type_id">';
   $sql='select id, val from critical_terms_type order by seq';
   $cur=$conn->query($sql);

   $cur->data_seek(0);
   while ($row = $cur->fetch_row())
      echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
   echo '</select>';
echo '</td>';

// =============================================================================
// Select Critical Term Category Type
// =============================================================================

echo '<td align=right><b>Category:</b></td>';
echo '<td>';
   echo '<select name="ct_category_id">';
   $sql='select id, val from ct_category_type order by seq';
   $cur=$conn->query($sql);

   $cur->data_seek(0);
   while ($row = $cur->fetch_row())
      echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
   echo '</select>';
echo '</td>';

// =============================================================================
// Select Critical Term Status
// =============================================================================

echo '<td align=right><b>Status:</b></td>';
echo '<td>';
   echo '<select name="ct_status_id">';
   $sql='select id, val from ct_status_type order by seq';
   $cur=$conn->query($sql);

   $cur->data_seek(0);
   while ($row = $cur->fetch_row())
      echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
   echo '</select>';
echo '</td>';

echo '</tr>';
echo '<tr><td colspan=6><b>Description:</b></td></tr>';
echo '<tr><td align=center colspan=6><textarea name=description rows=4 cols=120>'.$description.'</textarea></td></tr>';
?>
</table>
<p>
<button type=button onclick="Sub()">Submit</button>
</form>

</body>
</html>

