<?php
namespace Formap\Base\PDO;

use Formap\Base\PDO\Connection
class Datos
{
    private $PDOLocal;
    private $Rows;
    private $Datos;
    function Conectar()
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
    function Desconectar()
    {
        $this->PDOLocal=NULL;
    }
    function Insert($Query)
    {
        try
        {
            $Resultado=$this->PDOLocal->query($Query);
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
            $Resultado=$this->PDOLocal->query($Query);
            while($Row=$Resultado->fetch(\PDO::FETCH_ASSOC))
            {
                $Datos[]=$Row;
            }
            return $Datos;
        }
        catch(PDOException $e)
        {
            return $Datos;
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
