<?php

class Core {

  public $dbh;
  private static $instance;

  private function __construct() {

    require_once('Config.php');

    // Building data source name from config.
    $dsn = 'mysql:host=' . Config::read('db.host') .
           ';dbname='    . Config::read('db.basename') .
           ';port='      . Config::read('db.port') .
           ';connect_timeout=15';
    // Getting DB user from config.
    $user = Config::read('db.user');
    // Getting DB password from config.
    $password = Config::read('db.password');

    $this->dbh = new PDO($dsn, $user, $password);
  }

  public static function getInstance() {
    if (!isset(self::$instance)) {
      $object = __CLASS__;
      self::$instance = new $object;
    }
    return self::$instance;
  }

}

?>