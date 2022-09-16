<?php

$n= 5;
$comp = 1;
for ($i = 0; $i <= 10; $i++) {
    $comp = $n * $i;
    echo $n . ' fois ' . $i . ' = ' . $comp . '<br>';

}
$nombre = 6;
$fact = 1;
for ($i = 1; $i <= $nombre; $i++) {
    $fact = $fact * $i;
}
echo 'Le factoriel de ' . $nombre . ' est ' . $fact. '<br>';

$n =31;
for($x=2; $x<$n; $x++)
{
    if($n %$x ==0)
    {
        return 0;
    }
}
if ($n==0)
    echo 'le nombre est pas premier.....'."\n";
else
    echo 'le nombre est premier..'."\n";