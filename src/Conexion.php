<?php
namespace Src;
//require_once __DIR__."./../vendor/autoload.php";

use \PDO;
use \PDOException;
class Conexion{
    protected static $con;

    public function __construct(){
        self::crearConexion();
    }

    protected static function crearConexion(){
        if(self::$con!=null) return;

        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__."/../");
        $dotenv->load();

        $user=$_ENV['USER'];
        $db=$_ENV["DATABASE"];
        $pass=$_ENV['PASS'];
        $host=$_ENV['HOST'];
        $dsn="mysql:dbname=$db;host=$host;charset=utf8mb4";
        $opciones=[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION];
        try{
            self::$con=new PDO($dsn, $user, $pass, $opciones);
        }catch(PDOException $ex){
            die("Error en la conexion->".$ex->getMessage());
        }

    }
}
//new Conexion;