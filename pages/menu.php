<ul class="nav">

    <?php
    $page = $_GET['page'];
    MenuItem::Create("Registration", "index.php?page=registration", $page="registration");
    MenuItem::Create("Admin", "index.php?page=admin", $page="admin");



class MenuItem {
    static function Create($name,$href, $isActive) 
    {
        $value = $isActive==true ? "active" : "";
        echo "<li class='nav-item'>";
        echo "<a class='nav-link $value' href='$href'>$name</a>";
        echo "</li>";
    }
}

?>
</ul>