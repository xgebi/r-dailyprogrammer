<?php
$postStr = intval(filter_input(INPUT_POST, "str", FILTER_SANITIZE_STRING));
echo "Cube dimension a=".pow($postStr, 1/3)."m<br>";
$r = pow((3*$postStr)/(4*pi()), 1/3);
echo "Sphere radius r=".$r."m<br>";
$h = pow((12*$postStr)/pi(), 1/3);
echo "Cone h=".$h."m r=".($h/2)."m<br>";
$h = pow((4*$postStr)/(pi()), 1/3);
echo "Cylinder h=".$h."m r=".($h/2)."m<br>";
?>

I didn't know optimal solution for each shape so I have set r = h/2 for cone and cylinder.<br>
r means radius<br>
h means height