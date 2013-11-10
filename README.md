# Superglue

### Legacy PHP "microframework" for quick prototyping

This is basically a modified version of the existing [Glue]() class for mapping URLs to classes. Its purpose is mainly for quick and dead-simple prototyping, with as little overhead as possible.  
It does not use any of the PHP 5.3+ features, and should work everywhere with PHP 5.x+ installed.

Differences between this and the original class are:

- Matching classes and methods instead of direct functions. This allows better app organization.
- Using regex tokens for arguments (e.g. <numeric>, <alpha>, <alpha|case-insensitive>, <alphanumeric>, <alphanumeric|case-insensitive>).
- Removed protocol functions (<code>GET()</code> and <code>POST()</code>).

Shipped with a very simple <code>.htaccess</code> for readable URLs.

### Usage:

You first need to define URLs that will be accessible:

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

Define classes that will be called on appropriate routes:

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

That's it - start the app!

    superglue::stick($urls);

### Credits

[Glue](http://github.com/jtopjian/gluephp)

<hr>

By: [topsitemakers.com](http://www.topsitemakers.com).

