<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
?>

<html>
<head>
<title>CI Ad-Hoc SQL</title>
<style style="text/css">
<!--
   *              {font-family: Arial; font-size: 12pt}
   h3             {font-family: Arial; font-size: 16pt}
   p              {font-family: Arial; font-size: 12pt}
   option         {font-family: Arial; font-size: 12pt; color: blue}
   td             {font-family: Arial; font-size: 12pt; vertical-align: top}
   th             {font-family: Arial; font-size: 12pt; font-weight:bold;
                   background: #336699; color: white; vertical-align: top;
                   text-align: left}
   input          {font-family:Arial; color: blue}
   ..box          {border-top:1px #999999 solid;border-left:1px #999999 solid;
                   border-right:1px #000000 solid;border-bottom:1px #000000
                   solid;font-family:Arial;text-transform:uppercase;color: blue}
   a              {color: blue; text-decoration: none; font-size: 12pt}
   a:hover        {color: magenta; text-decoration: none}
   ..error        {color: #FF0000; font-family: Arial; font-size: 10pt;
                   font-weight: bold;}
   ..msg          {color: #CC0000; font-family: Arial; font-size: 9pt;
                   font-weight: bold;}
   ..lefttext     {color: #000000; font-family: Arial,Verdana; font-size: 11px;}
   ..footer       {color: #FFFFFF; font-family: Arial,Verdana; font-size: 11px;}
   ..date         {color: #FFFFFF; font-family: Arial, Verdana; font-size: 12pt;}
   a.link         {color:#003399; font-family: Arial; font-size: 12pt;
                   text-decoration: none;}
   a.link:visited {color:#003399; font-family: Arial; font-size: 12pt;
                   text-decoration: none;}
   a.link:hover   {color:#FFFF00; font-family: Arial; font-size: 12pt;
                   text-decoration: underline;}
   ..pwinput      {border-top:1px #999999 solid;border-left:1px #999999
                   solid; border-right:1px #000000 solid;
                   border-bottom:1px #000000 solid; height: 19px;width: 180px;
                   font-family: Arial;}
   .style15       {font-size: 14px}

   .titleTab          {width:100%; border-collapse:collapse}
   .titleTab th       {font-family: Copperplate,"Copperplate Gothic Light",fantasy; font-size: 24pt; font-weight:bold;
                       background: black; color: white; vertical-align: middle;
                       text-align: left; padding: 7px; border:black 1px solid}
   .titleTab td       {font-family: Arial; font-size: 16pt; font-weight:bold;
                       background: black; color: white; vertical-align: middle;
                       text-align: left; padding: 7px; border:black 1px solid}

   .hoverTab          {border-collapse:collapse}
   .hoverTab th       {font-family: Arial; font-size: 12pt; font-weight:bold;
                       background: #336699; color: white; vertical-align: top;
                       text-align: left; padding: 7px; border:#4e95f4 1px solid}
   .hoverTab td       {padding: 7px; border:#4e95f4 1px solid}
   .hoverTab tr:hover {background-color: lightyellow}
//-->
</style>
</head>

<body>
<?php
// ============================================================================
// ============================================================================

include_once 'includes/ci_connect.php';
if ($conn->connect_error)
   trigger_error ('Database connection failed: ' . $conn->connect_error,  E_USER_ERROR);

// ============================================================================
// ============================================================================

if (!empty($_GET["sql"])) {
   //echo 'Insert ' . stripos($_GET["sql"],"insert") . ' Delete ' .stripos($_GET["sql"],"delete") .
        //' Update ' . stripos($_GET["sql"],"update");

   if (stripos($_GET["sql"],"insert") === FALSE and
       stripos($_GET["sql"],"delete") === FALSE and
       stripos($_GET["sql"],"update") === FALSE) {
      $sql=$_GET["sql"];
      $cur=$conn->query($sql);

      if ($cur == false)
         trigger_error ('SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);

      // ==========================================================================
      // Display Column Names
      // ==========================================================================

      echo '<table class="hoverTab">';
      echo '<tr>';
      if ($ccur = $conn->query($sql))
         while ($col = $ccur->fetch_field())
            echo '<th>' . $col->name . '</th>';
      echo '</tr>';
      $ccur->close();

      $cnt=0;
      $cur->data_seek(0);
      while ($row = $cur->fetch_row()) {
         if ($cnt++ % 2 == 0)
            echo '<tr bgcolor="#cccccc">';
         else
            echo '<tr>';

         for ($i=0; $i < $cur->field_count; $i++)
            echo '<td>' . $row[$i] . '</td>';
         echo '</tr>';
         }

      echo '<tr>';
      if ($cnt == 0)
         echo '<th colspan='.$cur->field_count.'>No Values</th>';
      else
         echo '<th colspan='.$cur->field_count.'>Total = ' . $cnt . '</th>';
      echo '</tr>';
      echo '<table>';
      }
   else
      echo  '<b><font color=red>Inserts, Deletes, Updates are not permitted!</font></b>';

   }

$conn->close();
?>

</p>
</body>
</html>

