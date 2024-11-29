<h3>RegistrationPage</h3>

<?php

include_once("./pages/lib.php");

if(isset($_POST['buttonRegistration']))
{
  if(strlen($_POST['userLogin']) < 3 || 
     strlen($_POST['userPassword1']) < 4 || 
     $_POST['userPassword1'] !== $_POST['userPassword2']) 
  {
    echo "Некорректные данные";
  }
  else {
    $pathTemp = $_FILES['userImage']['tmp_name'];
    if(is_uploaded_file($pathTemp))
    {
      $path = "./wwwroot/images/".$_FILES['userImage']['name'];
      move_uploaded_file($pathTemp,$path);
      $login = htmlspecialchars(trim($_POST["userLogin"]));
      $password = htmlspecialchars(trim($_POST["userPassword1"]));
      $item = new Customer($login,$password,0,0,$path,2);
      $item->SaveInDb();
    }
  }
}

?>

<form class="row g-3" 
      method="post" 
      action="index.php?page=registration" 
      enctype="multipart/form-data"
      onsubmit="return CheckForm()"
> 
  <div class="col-auto">
    <label class="visually-hidden">Login</label>
    <input type="text" id="userLogin" class="form-control" name="userLogin" placeholder="Input Login">
  </div>
  <div class="col-auto">
    <label class="visually-hidden">Password</label>
    <input type="password" id="userPassword1" class="form-control" name="userPassword1" placeholder="Input password">
  </div>
  <div class="col-auto">
    <label class="visually-hidden">Repeat Password</label>
    <input type="password" id="userPassword2" class="form-control" name="userPassword2" placeholder="Repeat password">
  </div>
  <div class="col-auto">
    <input type="hidden" name="MAX_FILE_SIZE" value="5000000">
    <input type="file" class="form-control" name="userImage">
  </div>
  <div class="col-auto">
    <input type="submit" class="btn btn-primary mb-3" name="buttonRegistration" value="Registration">
  </div>
</form>

<script>
  let loginText = document.getElementById('userLogin');
  let password1Text = document.getElementById("userPassword1");
  let password2Text = document.getElementById("userPassword2");

  function CheckForm() {
    let login = loginText.value;
    let password1 = password1Text.value;
    let password2 = password2Text.value;

    let checkLogin = /^[A-Za-z]{3,}$/; 

    if (!checkLogin.test(login)) {
      loginText.style.backgroundColor = 'red';
      return false;
    } else {
      loginText.style.backgroundColor = ''; 
    }

    let checkPassword = /^[A-Za-z0-9]{4,}$/; 

    if (!checkPassword.test(password1)) {
      password1Text.style.backgroundColor = 'red';
      return false;
    } else {
      password1Text.style.backgroundColor = ''; 
    }

    if (password1 !== password2) {
      password1Text.style.backgroundColor = 'red';
      password2Text.style.backgroundColor = 'red';
      return false;
    } else {
      password2Text.style.backgroundColor = ''; 
    }

    return true; 
  }
</script>
