<?php
/**
 * File relativo alle pagine
 *
 * @package Halo 1
 */

$factory = Halo1Factory::getInstance(null);
$theme_controller = $factory->createController('theme', 'theme');

$theme_controller->initFrontend('page');
