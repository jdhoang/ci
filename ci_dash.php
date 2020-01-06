<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<html>
<head>
<title>CI Dashboard</title>
<link rel="stylesheet" href="css/ci_dash.css" type="text/css">
</head>

<body>
<?php
// ============================================================================
// ============================================================================

include_once 'includes/ci_connect.php';
include_once 'includes/ci_func.php';
if ($conn->connect_error)
   trigger_error ('Database connection failed: ' . $conn->connect_error,  E_USER_ERROR);


// ============================================================================
// ============================================================================

echo '<table class="dashTab" width=100% cellpadding=10 cellspacing=10>';
echo '<tr><th width=50%># Activities</th><th width=50%># Campaigns</th>';
echo '<tr>';
echo '<td>' . get_val('select count(*) from activity') . '</td>';
echo '<td>' . get_val('select count(*) from campaigns') . '</td>';
echo '</tr>';
echo '</table>';

echo '<table class="dashTab" width=100% cellpadding=10 cellspacing=10>';
echo '<tr><th width=33%># Systems</th><th width=33%># Users</th><th width=33%># IP Addresses</th></tr>';
echo '<tr>';
echo '<td>' . get_val('select count(*) from systems') . '</td>';
echo '<td>' . get_val('select count(*) from users') . '</td>';
echo '<td>' . get_val('select count(*) from ip_addrs') . '</td>';
echo '</tr>';
echo '</table>';

echo '<table class="dashTab" width=100% cellpadding=10 cellspacing=10>';
echo '<tr><th width=33%># Critical Terms</th><th width=33%># Malware</th><th width=33%># Domains</th></tr>';
echo '<tr>';
echo '<td>' . get_val('select count(*) from critical_terms') . '</td>';
echo '<td>' . get_val('select count(*) from malware') . '</td>';
echo '<td>' . get_val('select count(*) from domains') . '</td>';
echo '</tr>';
echo '</table>';


$conn->close();
?>

</body>
</html>

