<?php

/**
 * Interfaccia necessaria per rispettare la specifiche del design pattern Factory
 * ma non necessaria tecnicamente.
 */

interface IHalo1Factory
{
   public function createController($category, $page, $args = null);

   public function createModel($category, $page, $args = null);

   public function createView($category, $page, $args = null);
}