<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>cellular automata (0 → 255)</title>
        <link href="style.css" rel="stylesheet" type="text/css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="/data/favicon.png">
    </head>
    <body>
<h1>cellular automata — rules 0 to 255</h1>
<h2>start from single point</h2>
<?php /** Constants **/
    $from=0;
    $to=256;
?>
<?php
    for ($i = $from ; $i < $to ; $i++) {
        echo '
        <a href="../lib/img.php?rule='.$i.'&width=400&height=200&randomstart=on&pixel=3">
        <div class="img">
            <img src="../lib/img.php?rule='.$i.'&width=90&height=90&randomstart=on">
            '.$i.'
        </div>
        </a>
        ';
    }
?>
<div class="clear"></div>
<h2>start from random line</h2>
<?php
    for ($i = $from ; $i < $to ; $i++) {
        echo '
        <a href="../lib/img.php?rule='.$i.'&width=400&height=200&pixel=3">
        <div class="img">
            <img src="../lib/img.php?rule='.$i.'&width=90&height=90">
            '.$i.'
        </div>
        </a>
        ';
    }
?>
    </body>
</html>
