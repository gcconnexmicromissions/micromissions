<?php
$switch = get_input('switch');

$_SESSION['mission_search_switch'] = $switch;

forward(REFERER);