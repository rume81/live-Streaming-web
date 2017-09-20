<?php

$settings = parse_ini_file('test.ini');

var_dump($settings);
var_dump($settings['db']);