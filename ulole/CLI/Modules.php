<?php
require "ulole/CLI/Custom.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);// */

$CLI = new Custom();

$CLI->register("install", function($args) {
  return "Ulole-Framework Modules are not more supported! Use 'php uppm' instead! (php uppm help)";
});
