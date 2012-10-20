<?php

/**
 * @file
 * Example using superglue microframework.
 *
 * Created by: Topsitemakers
 * http://www.topsitemakers.com/
 */

require 'superglue.php';

// Define URLs
$urls = array(
  // This will be binded to class "sample" and method "index"
  '/' => 'sample',
  // This will be binded to class "sample" and method "page"
  '/sample' => array('sample', 'page'),
);

// Our sample class
// Classes are better than direct functions for code organization and for
// avoiding name clashes.
class sample {
  function index() {
    print 'home page';
  }
  function page() {
    print 'sample page';
  }
}

// Start the app
glue::stick($urls);
