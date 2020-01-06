<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
?>

<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<html>
<head>
<title>Add New System</title>
<link rel="stylesheet" href="css/ci.css" type="text/css">
</head>

<body>
<table bgcolor=#003366 border=0 width=100% cellpadding=20 cellspacing=0>
<tr>
<td><font color=white size=3><b>Add New System</b></font></td>
</tr>
</table><p>

<?php
// ============================================================================
// ============================================================================

$hostn=$_POST["hostname"];
$ipaddr=$_POST["ip_addr"];
$purpose=$_POST["purpose"];
$description=$_POST["description"];

include_once 'includes/ci_connect.php';
if ($conn->connect_error)
   trigger_error ('Database connection failed: ' . $conn->connect_error,  E_USER_ERROR);

/*
echo 'Hostname: '.$hostn.'<br>';
echo 'System Status: '.$_POST["system_status_id"].'<br>';
echo 'OpCo: '.$_POST["OpCo_id"].'<br>';
echo 'IpAddr: '.$ipaddr.'<br>';
echo 'Description: '.$_POST["description"].'<br>';
echo 'Purpose: '.$_POST["purpose"].'<br>';
*/

// ============================================================================
// Check if hostname already exists
// ============================================================================

$chk_host = $conn->query('select count(*) as cnt from systems where hostname = "'.$hostn.'"');
$cnt = $chk_host->fetch_assoc();

if ($cnt["cnt"] > 0) {
   echo '<font color=red>**Error: <b>"'.$hostn.'"</b> host already exists!</font><br>';
   $purpose=rawurlencode($purpose);
   $description=rawurlencode($description);
   include 'http://10.1.3.94/ci/ifrm_systems.php?hostn='.$hostn.'&ipaddr='.$ipaddr.
           '&description='.$description.'&purpose='.$purpose;
   }
else {

   $host_ins='insert into systems(hostname,system_status_id,OpCo_id,description,purpose,created_by) values("'.
           $hostn.'",'.$_POST["system_status_id"].','.$_POST["OpCo_id"].',"'.$_POST["description"].
           '","'.$_POST["purpose"].'","Test")';

   if ($conn->query($host_ins) === FALSE) {
      echo '<b><font color=red>Error creating new host: ' . $host_ins . '</font></b><br>' . $conn->error;
      include 'http://10.1.3.94/ci/ifrm_systems.php';
      }
   else {
      $sys_id = $conn->insert_id;
      // echo 'New system_id = '.$sys_id.'<br>';

      // ======================================================================
      // Create IP address record if provided
      // ======================================================================

      if (!empty($ipaddr)) {

         $chk_ip = $conn->query('select id from ip_addrs where ip_addr = "'.$ipaddr.'"');
         $iprow = $chk_ip->fetch_assoc();
         $ip_id = $iprow["id"];

         if ($chk_ip->num_rows == 0) {

            $ip_ins='insert into ip_addrs(ip_addr,ip_type,description,created_by) values("'.
                    $ipaddr.'",IF(INSTR("'.$ipaddr.'",":")>0,"IPv6","IPv4"),'.
                    '"'.$hostn.'","Test")';
            // echo $ip_ins . '<br>';

            if ($conn->query($ip_ins) === FALSE)
               echo 'Error creating new IP Address: ' . $ip_ins . '<br>' . $conn->error;
            else {
               $ip_id = $conn->insert_id;
               $is_ins='insert into ip_addrs_systems(ip_addr_id,system_id,created_by) values('.
                       $ip_id.','.$sys_id.',"Test")';
               // echo $is_ins . '<br>';
               
               if ($conn->query($is_ins) === FALSE)
                  echo 'Error associating new IP Address w/new Host: ' . $is_ins . '<br>' . $conn->error;
               }
            }
         else {
            // echo $ip_id.' in ip_addrs';
            $is_ins='insert into ip_addrs_systems(ip_addr_id,system_id,created_by) values('.
                    $ip_id.','.$sys_id.',"Test")';
            // echo $is_ins . '<br>';

            if ($conn->query($is_ins) === FALSE)
               echo 'Error associating old IP Address w/new Host: ' . $is_ins . '<br>' . $conn->error;
            }
         }

      echo '<b>Successfully added New System!</b><p>';
      include 'http://10.1.3.94/ci/det_system.php?id='.$sys_id;
      }
   }

?>

</body>
</html>

