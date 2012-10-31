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

  // RESTful example
  // If we do not pass an array here, superglue will check if the class has
  // method named as the request method (GET, POST, DELETE, PUSH)
  '/restful' => 'restful',

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

// Example RESTful class
// Each method corresponds with the request method.
class restful {
  function GET() {
    print 'GET method.';
  }
  function POST() {
    print 'POST method.';
  }
  function PUSH() {
    print 'PUSH method.';
  }
  function DELETE() {
    print 'DELETE method.';
  }
}

// Start the app
superglue::stick($urls);
