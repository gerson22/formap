<?php
  namespace Formap\Base\PDO;
  class Connection{

      public $server,

      $user,

      $pwd;

      function __construct(){
        $this->server = getenv('DB_CONNECTION').":host=".getenv('DB_HOST').";dbname=".getenv('DB_DATABASE');
        $this->user = getenv('DB_USERNAME');
        $this->pwd = getenv('DB_PASSWORD');
      }
 }
?>
