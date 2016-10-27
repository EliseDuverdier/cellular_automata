<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>3-states cellular automata</title>
        <link href="style.css" rel="stylesheet" type="text/css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="/data/favicon.png">
    </head>
    <body>

<?php  /** Constants **/
    $limit=500;
    $start_with = (isset($_GET['start_with']) && $_GET['start_with']!='') ? $_GET['start_with'] : 0 ;
    $random = (isset($_GET['random_start']) && $_GET['random_start']=='on') ? false : true ;
?>

<h1>3-states cellular automata</h1>
<p>As there is <abbr title="2^3^3">134 217 728</abbr> possible rules, only the n → n + <?=$limit?> ones are shown here. By default, <em>n</em>=0, and the first line is random. To change settings, use the form below.</p>
<form class="inline" action="displayAll_3states.php" method="get">
    <input type="checkbox" name="random_start" id="random_start"><label for="random_start">centered points start</label> /;
    <label for="start_with">start with</label><input type="number" name="start_with" id="start_with" min="0" max="" title="0 to 134216728">
    <input type="submit" value="→" size="3">
</form>

<p>Use the <a href="display_3states.html">3-states cellular automata generator</a> to generate others ! </p>

<?php
    /** Generation **/
if ($random)
    echo "<h2>start from random line ($start_with to ".($start_with+$limit).")</h2>";
else
    echo "<h2>start from centered points ($start_with to ".($start_with+$limit).")</h2>";

for ($i = $start_with ; $i < $start_with+$limit ; $i++) {
    echo '
    <a href="../lib/img_3states.php?rule='. $i .'&pixel=3&width=500&height=500'.($random ? '' : '&randomstart=on') .'">
    <div class="img">
        <img src="../lib/img_3states.php?rule='. $i .'&width=90&height=90'.($random ? '' : '&randomstart=on') .'">
        '.$i.'
    </div>
    </a>
    ';
}
?>
    </body>
</html>
