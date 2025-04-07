<?php

get_header();

$title = get_the_title();
$eHadith = get_field('english_hadith');
$aHadith = get_field('arabic_hadith');

echo "<h1>" . $title . "</h1>";
echo "<h3 style='font-style:italic;'>English</h3>";
?>
<blockquote style="font-style: italics;">
    <?php
    echo "<p>" . $eHadith . "</p>";
    ?>
</blockquote>
<?php
echo "<h3 style='font-style:italic;'>Arabic</h3>";
?>
<blockquote style="font-style: italics;">
    <?php
    echo "<p>" . $aHadith . "</p>";
    ?>
</blockquote>
<h5>-<?php echo get_field('hadith_writer')?> <cite></cite></h5>
<?php


get_sidebar();
get_footer();
?>