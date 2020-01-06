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

$sql='SELECT hostname FROM systems WHERE hostname like "%'.$search.'%"';
$cur=$conn->query($sql);
if ($cur == false)
   trigger_error ('SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);

// ==========================================================================
// ==========================================================================

while ($row = $cur->fetch_assoc())
   $data[] = $row["hostname"];

echo json_encode($data);

// ==========================================================================
// ==========================================================================

$cur->free();
$conn->close();
?>

