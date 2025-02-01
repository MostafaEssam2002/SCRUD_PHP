<?php 
$email="dd@gmail.com";
$pattern="/^[a-z0-9-]+[_a-z0-9-]*[a-z0-9-]+@[a-z0-9]+\.([a-z]{2,4})$/";
echo preg_match($pattern,$email);
?>