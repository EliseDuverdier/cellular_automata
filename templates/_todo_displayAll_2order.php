<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>cellular automata (0 → 255)</title>
        <link href="style.css" rel="stylesheet" type="text/css">
    </head>
    <body>
<?php  /** Constants **/
    $limit=1000;
    $s = (isset($_GET['s']) && $_GET['s']!='') ? $_GET['s'] : 0 ;
    $random = (isset($_GET['r']) && $_GET['r']=='on') ? false : true ;
?>

<h1>cellular automata — rules 0 to 255</h1>
<p></p>
<form class="inline" action="displayAll_2order.php" method="get">
    <input type="checkbox" name="r" id="r"><label for="r">centered points start</label> /
    <label for="s">start with</label><input type="number" name="s" id="s" min="0" max="134216728" title="0 to 134216728">
    <input type="submit" value="→" size="3">
</form>

//65536

<?php
    /** Generation **/
if ($random)
    echo "<h2>start from random line ($s to ".($s+$limit).")</h2>";
else
    echo "<h2>start from centered points ($s to ".($s+$limit).")</h2>";

for ($i=$s; $i < $s+$limit; $i++) {
    echo '
    <a href="img2order.php?rule='. $i .'&pixel=3&w=400&h=200'.($random ? '' : '&randomstart=on') .'">
    <div class="img">
        <img src="img2order.php?rule='. $i .'&w=90&h=90'.($random ? '' : '&randomstart=on') .'">
        '.$i.'
    </div>
    </a>
    ';
}
?>
    </body>
</html>
