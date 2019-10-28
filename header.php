<?php
/**
 * File richiamato per il singolo header
 *
 * @package Halo 1
 */

$factory = Halo1Factory::getInstance(null);
$theme_controller = $factory->createController('theme', 'theme');

$theme_controller->initFrontend('header');
