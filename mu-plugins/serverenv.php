<?php

/*
  Plugin Name: Pantheon Environment Check
  Description: Used to check environment for environment-specific things
  Author: Bowst
  Author URI: https://www.bowst.com
 */


 /*
  * Singleton ServerEnv class
  * Things will break if you remove this
  */

class ServerEnv {

  private static $instance;
  private $env;

  private function __construct() {

    if ( isset($_ENV['PANTHEON_ENVIRONMENT']) ) :
      switch ($_ENV['PANTHEON_ENVIRONMENT']) :
        case 'lando':
          $this->env = 'local';
          break;
        case 'kalabox':
          $this->env = 'local';
          break;
        case 'dev':
          $this->env = 'dev';
          break;
        case 'test':
          $this->env = 'test';
          break;
        case 'live':
          $this->env = 'live';
          break;
        default: // Multidev catchall... multidevs are named after git branches
          $this->env = 'multidev';
          break;
      endswitch;

    else : $this->env = 'unknown';
    endif;
  }

  private static function getInstance() {

    if ( is_null( self::$instance ) ) :
      self::$instance = new self();
    endif;

    return self::$instance;
  }

  private static function formatQuery($query) {

    if ( is_string($query) ) :
      $query = array_filter( explode(' ', str_replace(',',' ',$query)) );
    endif;

    if ( is_array($query) ) :
      $query = array_map( function($q) {
        return strtolower( trim($q) );
      }, $query);
    endif;

    return $query;
  }

  public static function is($query) {
    $query = self::formatQuery($query);
    $current_env = self::getInstance()->env;
    return in_array($current_env, $query);
  }

  public static function isnt($query) {
    return !self::is($query);
  }

  public static function get() {
    return self::getInstance()->env;
  }
}
