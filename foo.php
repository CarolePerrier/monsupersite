<?php
$a = 1;
ob_start();
echo $a;
$a_out = ob_get_clean();
require('bar.php');
echo $a_out;

//21
?>

