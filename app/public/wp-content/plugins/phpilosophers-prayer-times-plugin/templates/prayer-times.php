<?php
get_header();
global $result;
$date_set = date('l F j, Y', strtotime('now'));
?>

<div class="wrapper">
<?php
    echo "List of Prayer Times in Port Of Spain on " . $date_set . "<br>";
    echo "<br><br>";
    echo "<div class = 'card-grid'>";
    foreach ($result as $key => $value) {
        echo "<div class = 'time-card'>" . $key . " : " . date('h:i a',strtotime($value)) . "</div>";
    }
    echo "</div>";
?>
</div>
