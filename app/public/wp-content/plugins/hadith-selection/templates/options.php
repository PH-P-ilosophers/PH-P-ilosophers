<?php

$options = array();
$options['selection_inteval'] = sanitize_text_field($_POST['selection_interval']);
echo update_option('selection_interval',$options['selection_interval']);
sleep(5);
header("Location:".$_SERVER['HTTP_REFERER']."?message=".$message);
die;

