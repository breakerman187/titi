<?php 
session_start();
sleep(1);
?>
<html>

<head>
  <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
  <META HTTP-EQUIV="EXPIRES" CONTENT="Mon, 22 Jul 2002 11:12:01 GMT">
  <title> Faith Checker Automatic 3DS Viewer </title>
</head>

<body>
  <div class="iframe">
  <?php
   require('functions.php');
   $oop = new PayMaya(['', '', '', '']);
   $oop->exhibitForm($_SESSION['values']);
  ?>
  </div>
</body>

</html>
