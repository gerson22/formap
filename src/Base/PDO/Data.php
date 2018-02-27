<?php
namespace Formap\Base\PDO;

use Formap\Base\PDO\Connection;
class Data
{
    private $PDOLocal;
    private $Rows;
    private $data;
    function __construct(){
      $this->connect();
    }
    function connect()
    {
        try
        {
            $StringConn= new Connection();
            $this->PDOLocal=new \PDO($StringConn->server, $StringConn->user,$StringConn->pwd);
        }
        catch(PDOException $e)
        {
            echo "Error ".$e->getMessage();
        }
    }
    function disconnect()
    {
        $this->PDOLocal=NULL;
    }
    function Insert($Query)
    {
        try
        {
            $Result=$this->PDOLocal->query($Query);
        }
        catch(PDOException $e)
        {
            echo "Error: ".$e->getMessage();
        }
    }
    function Select($Query)
    {
        try
        {
            $Result=$this->PDOLocal->query($Query);
            while($Row=$Result->fetch(\PDO::FETCH_ASSOC))
            {
                $data[]=$Row;
            }
            return $data;
        }
        catch(PDOException $e)
        {
            return $data;
        }
    }
    function Delete($Query)
    {
        $this->Select($Query);
    }
    function Update($Query)
    {
        $this->Select($Query);
    }
    function SelectJson($Query)
    {
        return json_encode($this->Select($Query));
    }
}

?>
