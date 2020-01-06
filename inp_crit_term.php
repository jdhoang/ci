<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
?>

<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<html>
<head>
<title>Add New Critical Term</title>
<link rel="stylesheet" href="css/ci.css" type="text/css">
</head>

<body>
<table bgcolor=#003366 border=0 width=100% cellpadding=20 cellspacing=0>
<tr>
<td><font color=white size=3><b>Add New Critical Term</b></font></td>
</tr>
</table><p>

<?php
// ============================================================================
// ============================================================================

$term=$_POST["term"];
$description=$_POST["description"];
$ct_type_id=$_POST["critial_term_type_id"];
$ct_category_id=$_POST["ct_category_id"];
$ct_status_id=$_POST["ct_status_id"];

include_once 'includes/ci_connect.php';
if ($conn->connect_error)
   trigger_error ('Database connection failed: ' . $conn->connect_error,  E_USER_ERROR);


// ============================================================================
// Check if critical term already exists
// ============================================================================

$chk_term = $conn->query('select count(*) as cnt from critical_terms where term = "'.$term.'"');
$cnt = $chk_term->fetch_assoc();

if ($cnt["cnt"] > 0) {
   echo '<font color=red>**Error: <b>"'.$term.'"</b> term already exists!</font><br>';
   $term=rawurlencode($term);
   $description=rawurlencode($description);
   include 'http://10.1.3.94/ci/ifrm_crit_terms.php?term='.$term.'&description='.$description;
   }
else {

   $term_ins='insert into critical_terms(term,description,critical_term_type_id,ct_category_id,'.
             'ct_status_id,created_by) values("'.
             $term.'","'.$description.'",'.$ct_type_id.','.$ct_category_id.','.$ct_status_id.',"Test")';

   if ($conn->query($term_ins) === FALSE) {
      echo '<b><font color=red>Error creating new critical cterm: ' . $term_ins . '</font></b><br>' . $conn->error;
      $term=rawurlencode($term);
      $description=rawurlencode($description);
      include 'http://10.1.3.94/ci/ifrm_crit_terms.php?term='.$term.'&description='.$description;
      }
   else {
      $term_id = $conn->insert_id;
      echo '<b>Successfully added New Critical Term!</b><p>';
      include 'http://10.1.3.94/ci/det_crit_term.php?id='.$term_id;
      }
   }

?>

</body>
</html>

