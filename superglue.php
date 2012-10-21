<?php

/**
 * @file
 * Superglue PHP microframework.
 * 
 * See "example.php" for a working example.
 *
 * Original project:
 * http://github.com/jtopjian/gluephp
 * 
 * Enhanced by: Topsitemakers
 * http://www.topsitemakers.com/
 */
class superglue {

  static function stick ($urls) {

    // Guess the method automatically
    $method = strtolower($_SERVER['REQUEST_METHOD']);
    if (strpos($_SERVER['REQUEST_URI'], '?')) {
      $path = substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], '?'));
    }
    else {
      $path = $_SERVER['REQUEST_URI'];
    }
    $url_not_found = true;
    krsort($urls);

    foreach ($urls as $regex => $class) {
      // Replace the regex tokens
      // http://gskinner.com/RegExr/
      $regex = strtr($regex, array(
        '<numeric>' => '(\d+){1,6}',
        '<alpha>' => '([a-z]+)',
        '<alpha|case-insensitive>' => '([a-zA-Z]+)',
        // Without space
        '<alphanumeric>' => '([a-z0-9-_]+)',
        '<alphanumeric|case-insensitive>' => '([a-zA-Z0-9-_]+)',
      ));
      // Append the base path
      $regex = substr(substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], "/")+1) , 0, -1) . $regex;
      // Process the URLs
      $regex = str_replace('/', '\/', $regex);
      $regex = '^' . $regex . '\/?$';
      if (preg_match("/$regex/i", $path, $matches)) {
        $url_not_found = false;
        // Handle calls
        $class_not_found = true;
        $method_not_found = true;
        if (is_array($class)) {
          if (class_exists($class[0])) {
            $obj = new $class[0];
            if (method_exists($obj, $class[1])) {
              $class_not_found = false;
              $method_not_found = false;
              $method = $class[1];
            }
          }
        }
        else {
          if (class_exists($class)) {
            $obj = new $class;
            if (method_exists($obj, $method) || method_exists($obj, 'index')) {
              $class_not_found = false;
              $method_not_found = false;
              $method = method_exists($obj, 'index') ? 'index' : $method;
            }
          }
        }
        if (!$class_not_found && !$method_not_found) {
          // Pass matches as function arguments
          switch (count($matches)-1) {
            case 1:
              $obj->$method($matches[1]);
              break;
            case 2:
              $obj->$method($matches[1], $matches[2]);
              break;
            case 3:
              $obj->$method($matches[1], $matches[2], $matches[3]);
              break;
            case 4:
              $obj->$method($matches[1], $matches[2], $matches[3], $matches[4]);
              break;
            default:
              $obj->$method($matches);
              break;
          }
        }
        if ($class_not_found) throw new Exception("Class, $class, not found.");
        if ($method_not_found) throw new BadMethodCallException("Method, $method, not supported.");
        break;
      }
    }
    if ($url_not_found) throw new Exception("URL, $path, not found.");
  }
}

