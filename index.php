<?php
require_once("./function/connection.php");

// check whether login button has clicked
if (isset($_POST['login'])) :
  $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
  $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

  // Check whether the user has input login data
  if(empty($username)) :
    $errMSG = "Nama pengguna belum diisi.";
    setcookie("user_fail", $errMSG, time()+5);
    header("Location: ".$_SERVER['PHP_SELF']);
  elseif(empty($password)) :
    $errMSG = "Kata sandi belum diisi.";
    setcookie("user_fail", $errMSG, time()+5);
    header("Location: ".$_SERVER['PHP_SELF']);
  endif;

  // Check whether data is submitted exist in database
  if(!isset($errMSG)) :
    $query = "SELECT * FROM user WHERE username=:username AND password=:password";
    $stmt = $pdo->prepare($query);
    $params = [":username" => $username, ":password" => $password];
    $stmt->execute($params);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!empty($row)) :
      if(password_verify($password, $row["password_hash"])) :
          session_start();
          // create session named "user"
          $_SESSION["user"] = $row;
          // delete cookie message
          setcookie("user_fail", "delete", time()-1);
          header("Location: ./pages/index.php");
      endif;
    else :
      setcookie("user_fail", "Nama pengguna atau kata sandi tidak sesuai.", time()+5);
      header("Location: ".$_SERVER['PHP_SELF']);
    endif;
  endif;
endif;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>SISPELMODIN</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="./node_modules/bootstrap-social/bootstrap-social.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="./assets/css/style.css">
  <link rel="stylesheet" href="./assets/css/components.css">
</head>

<body style="background-image: url('./assets/img/bg-login.jpg');background-size: cover">
  <div id="app">
    <section class="section">
      <div class="container mt-3">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
              <img src="./assets/img/logo-tut-wuri-handayani.png" alt="logo" width="100" class="p-2 shadow-light rounded bg-white">
            </div>

            <div class="card card-primary">
              <div class="card-header"><h4>Masuk</h4></div>              
              <div class="card-body">
                <form method="POST" action="">
                  <?php
                    // Check whether there is a cookie named "user_fail"
                    if(isset($_COOKIE['user_fail'])) :
                      echo" <div class='alert alert-danger alert-dismissible show fade'>
                        <div class='alert-body'>
                          <button class='close' data-dismiss='alert'>
                            <span>&times;</span>
                          </button>".
                          $_COOKIE['user_fail'].
                        "</div>
                      </div>";
                    endif;
                  ?>
                  <div class="form-group">
                    <label for="username">Nama Pengguna</label>
                    <input id="username" type="text" class="form-control" name="username" tabindex="1" autofocus autocomplete="off">
                    <!-- <div class="invalid-feedback">
                      Tolong masukkan username
                    </div> -->
                  </div>

                  <div class="form-group">
                    <div class="d-block">
                    	<label for="password" class="control-label">Kata Sandi</label>
                    </div>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2"autocomplete="off">
                    <!-- <div class="invalid-feedback">
                      Tolong masukkan kata sandi
                    </div> -->
                  </div>

                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4" name="login">
                      Masuk
                    </button>
                  </div>
                </form>
              </div>
            </div>
            <div class="simple-footer bg-whitesmoke">
              <p>
                SISPELMODIN - BP-PAUD DIKMAS SULSEL<br />
                <a href="https://akba.ac.id/website/" target="_blank">TIM KKLP STMIK AKBA 2022</a> - HAK CIPTA &copy; <?= date('Y') ?>
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="./assets/js/stisla.js"></script>

  <!-- JS Libraies -->

  <!-- Template JS File -->
  <script src="./assets/js/scripts.js"></script>
  <script src="./assets/js/custom.js"></script>

  <!-- Page Specific JS File -->
</body>
</html>
