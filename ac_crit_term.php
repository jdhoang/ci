<?php

if (PHP_SAPI === 'cli') 
   $search = $argv[1];
else
   $search = $_GET["term"];

// ============================================================================
// ============================================================================
include_once 'includes/ci_connect.php';
if ($conn->connect_error)
   trigger_error ('Database connection failed: ' . $conn->connect_error,  E_USER_ERROR);


// ============================================================================
// ============================================================================

$sql='SELECT term FROM critical_terms WHERE term like "%'.$search.'%"';
$cur=$conn->query($sql);
if ($cur == false)
   trigger_error ('SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);

// ==========================================================================
// ==========================================================================

while ($row = $cur->fetch_assoc())
   $data[] = $row["term"];

echo json_encode($data);

// ==========================================================================
// ==========================================================================

$cur->free();
$conn->close();
?>

