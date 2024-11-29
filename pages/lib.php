

<?php

class MySql {
    static function getConnect() {
        $host = 'localhost';
        $dbname = 'perfectsite';
        $user = 'root';
        $password = 'root';
        $stringConnect = "mysql:host=$host;dbname=$dbname;charset=utf8";
        $option = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8" 
        );
        
        try {
            return new PDO($stringConnect, $user, $password, $option);
        }
        catch(PDOException $e) {
            $message = $e->getMessage();
            echo "<div style='background-color:red;'>$message</div>";
        }
    }
}

class Customer {
    public $id;
    public $login;
    public $pass;
    public $total;
    public $discount;
    public $imagepath;
    public $roleid;

    public function __construct( $login, $pass, $total, $discount, $imagepath, $roleid, $id=null) {
        $this->login = $login;
        $this->pass = $pass;
        $this->total = $total;
        $this->discount = $discount;
        $this->imagepath = $imagepath;
        $this->roleid = $roleid;
        $this->id = $id;
    }

    public function SaveInDb() {
        try 
        {
            $db = MySql::getConnect(); 
            $query =  $db->prepare("INSERT INTO customers 
            (login, pass, total, discount, imagepath, roleid) 
            VALUES (:login, :pass, :total, :discount, :imagepath, :roleid)"); //чтоб не прописать вредоносный скрипт
            $param =(array)$this;
            array_shift($param);
            $query->execute($param); //метод для выполнения
            return true;

        }
        catch(PDOException $e) {
            $message = $e->getMessage();
            echo "<div style='background-color:red;'>$message</div>";
        }
    }

    public static function GetById($id)  {
        try 
        {
            $db = Mysql::getConnect();
            $query = $db->prepare("SELECT * FROM customers WHERE id = :id");
            $query->execute(array('id' => $id));
            if($row = $query->fetch()) // для отправки запросов на сервер и получения данных.
            {
                return new Customer($row['login'], $row['pass'], $row['total'], $row['discount'], $row['imagepath'], $row['roleid'], $row['id']);
            } 
            return false;

        }
        catch(PDOException $e) {
            $message = $e->getMessage();
            echo "<div style='background-color:red;'>$message</div>";
        }
    }


}

class Item {
    public $id;
    public $name;
    public $categoriesid;
    public $price;
    public $info;
    public $rate;
    public $imagepath;

    public function __construct($name, $categoriesid, $price, $info, $rate, $imagepath, $id=null) {
        $this->id = $id;
        $this->name = $name;
        $this->categoriesid = $categoriesid;
        $this->price = $price;
        $this->info = $info;
        $this->rate = $rate;
        $this->imagepath = $imagepath;
    }

    public function Add() {
        try {
            $connection = MySql::getConnect();
            $query = $connection->prepare("INSERT INTO items (name,categoriesid,price,info,rate,imagepath)
                                              values (:name,:categoriesid,:price,:info,:rate,:imagepath)");
            $array = (array)$this;
            array_shift($array);
            $query->execute($array);    
            return true;

        }
        catch(PDOException $e) {
            $message = $e->getMessage();
            echo "<div style='background-color:red;'>$message</div>";
            return false;
        }
    }

    public static function Show($id) {
        try {
            $connection= MySql::getConnect();
            $query = $connection->prepare("SELECT * FROM items WHERE id =?");
            $query->bindParam(1,$id);
            $query->execute();
            if($row = $query->fetch()) {
                return new Item($row['name'], $row['categoriesid'], $row['price'], $row['info'], $row['rate'], $row['imagepath'], $row['id']);
            }
            return false;
        }
        catch(PDOException $e) {
            $message = $e->getMessage();
            echo "<div style='background-color:red;'>$message</div>";
            return false;
        }
    }
}

class Categories {
    public $id;
    public $name;

    public function __construct($name, $id=null) {
        $this->id = $id;
        $this->name = $name;
    }

    public function Add() {
        try {
            $connection = MySql::getConnect();
            $query = $connection->prepare("INSERT INTO categories (name) values (?);");
            $query->bindParam(1,$this->name);
            $query->execute();    
            return true;
        }
        catch(PDOException $e) {
            $message = $e->getMessage();
            echo "<div style='background-color:red;'>$message</div>";
            return false;
        }
    }

     static function Show() {
        try 
        {
            $db = Mysql::getConnect();
            $query = $db->prepare("SELECT * FROM categories");
            $query->execute();
            $array = array();
            while($row = $query->fetch()) {
            $array[] = new Categories($row['name'], $row['id']);

           }
           return $array;
        }
        catch (PDOException $e)
        {
            $message = $e->getMessage();
            echo "<div style='background-color:red;'>$message</div>";
            return false;
        }
    }
}

?>
