<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
?>

<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<html>
<head>
<title>Test</title>
<link rel="stylesheet" href="css/ci.css" type="text/css">
</head>

<body>
<table bgcolor=#003366 border=0 width=100% cellpadding=20 cellspacing=0>
<tr>
<td><font color=white size=3><b>Test</b></font></td>
</tr>
</table><p>

<?php
// ============================================================================
// ============================================================================

include_once 'includes/ci_connect.php';
include_once 'includes/ci_func.php';

echo '<form>';
seloptions('activity_type_id','select id, val from activity_type order by seq',2);
seloptions('actor_type_id','select id, val from actor_type order by seq');
echo '</form><p>';

echo get_val('select count(*) from activity');

?>

</body>
</html>

