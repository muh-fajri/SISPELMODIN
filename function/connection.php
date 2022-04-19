<?php

$DB_HOST = "localhost";
$DB_USER = "root";
$DB_PASS = "root";
$DB_NAME = "db_p3l@c4k@N_m0b!L_d!n4$";

// connection with mysqli_connect()
$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if(!$conn) {
  die("Koneksi database gagal : ".mysqli_connect_error());
}

// connection with PDO
try {
  $pdo = new PDO("mysql:host={$DB_HOST};dbname={$DB_NAME}",$DB_USER,$DB_PASS);
  $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  echo $e->getMessage();
}

// function query($query) {
//     global $conn;

//     $result = mysqli_query($conn, $query);
//     $rows[""];
    
//     while($row = mysqli_fetch_assoc($result)) {
//         $rows[] = $row;
//     }
    
//     return $rows;
// }

function add_user($data) {
  global $pdo;

  $name = htmlspecialchars($data["name"]);
  $username = htmlspecialchars($data["username"]);
  $password = htmlspecialchars($data["password"]);
  $re_password = htmlspecialchars($data["re-password"]);
  $level = htmlspecialchars($data["user-level"]);
  
  // get upload image info
  $imgName = $_FILES['photo']['name'];
  /* $tmpDir should define first in file /etc/php/7.4/apache2/php.ini
   * in line upload_tmp_dir = /var/www/tmp_upload
   * and tmp_upload folder should created and change the permission
   * even the user owner
   */
  $tmpDir = $_FILES['photo']['tmp_name'];
  $imgSize = $_FILES['photo']['size'];

  // execute if input type file is not empty
  if($imgName) :
    // prepare image for uploading
    $imgExt = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));
    $allowedExt = ['png', 'jpg'];
    $uploadDir = '../assets/img/avatar/';
    $imgUploadName = $username.'_pic_'.time().".".$imgExt; // Sample output : user_pic_1647141687.jpg

    // execute if allowed file extension is match
    if(in_array($imgExt, $allowedExt)) :
      // execute if file size less than 1MB
      if($imgSize < 1044070) :
        move_uploaded_file($tmpDir, $uploadDir.$imgUploadName);
      else :
        $errMSG = "Ukuran file lebih dari 1MB.";
        setcookie("fail", $errMSG, time()+5);
        header("Location: ".$_SERVER['PHP_SELF']);
      endif;
    else :
      $errMSG = "Hanya file JPG dan PNG yang bisa diunggah.";
      setcookie("fail", $errMSG, time()+5);
      /* $_SERVER['PHP_SELF'] will goes to the wrong place
       * if htaccess url manipulation is in play the value
       */
      header("Location: ".$_SERVER['PHP_SELF']);
    endif;
  else :
    $imgUploadName = NULL;
  endif;

  if(!isset($errMSG)) :
    // execute if username is not empty
    if($username) :
      // fetch username from database
      $stmt = $pdo->prepare('SELECT username FROM user');
      $stmt->execute();
      $result = $stmt->fetchAll();

      $rows = [];
      foreach ($result as $row) :
        $rows[] = $row['username'];
      endforeach;

      if(!in_array($username, $rows)) :
        if(strlen($password) >= 8) :
          if($password == $re_password) :
            // Encrypt password with password_hash()
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('INSERT INTO
              user (name, username, password, password_hash, level, photo)
              VALUES (:name, :username, :password, :password_hash, :level, :photo)');
            $params = [
              ':name' => $name,
              ':username' => $username,
              ':password' => $password,
              ':password_hash' => $password_hash,
              ':level' => $level,
              ':photo' => $imgUploadName
            ];

            if($stmt->execute($params)) : 
              $successMSG = "Data pengguna berhasil ditambahkan!";
              setcookie("success", $successMSG, time()+5);
              header("Location: ./data-user.php");
            else :
              $errMSG = "Data pengguna gagal ditambahkan!";
              setcookie("fail", $errMSG, time()+5);
              header("Location: ./data-user.php");
            endif;
          else :
            $errMSG = "Konfirmasi kata sandi tidak sama!";
            setcookie("fail", $errMSG, time()+5);
            header("Location: ./data-user.php");
          endif;
        else :
          $errMSG = "Kata sandi harus 8 karakter atau lebih.";
          setcookie("fail", $errMSG, time()+5);
          header("Location: ./data-user.php");
        endif;
      else :
        $errMSG = "Nama pengguna sudah digunakan.";
        setcookie("fail", $errMSG, time()+5);
        header("Location: ./data-user.php");
      endif;
    endif;
  endif;

  return $stmt->rowCount();
}

function add_driver($data) {
    global $pdo;

    $name = htmlspecialchars($data["name"]);
    $hp_wa = htmlspecialchars($data["hp-wa"]);

    $stmt = $pdo->prepare('INSERT INTO driver (name, no_hp_wa) VALUES (:name,:hp_wa)');
    
    $stmt->execute([':name' => $name, ':hp_wa' => $hp_wa]);
    return $stmt->rowCount();
}

function add_car($data) {
    global $pdo;

    $no_car = htmlspecialchars($data["no-car"]);
    $type = htmlspecialchars($data["type"]);

    $stmt = $pdo->prepare('INSERT INTO car (no_car, type) VALUES (:no_car,:type)');
    
    $stmt->execute([':no_car' => $no_car, ':type' => $type]);
    return $stmt->rowCount();
}

// function for add-business-trip.php and car-use.php
function add_business_trip($data) {
    global $pdo;

    $no_car = htmlspecialchars($data["no-car"]);
    $id_driver = htmlspecialchars($data["id-driver"]);
    $date_today = htmlspecialchars($data["date-today"]);
    $time_out = htmlspecialchars($data["time-out"]);
    $time_back = htmlspecialchars($data["time-back"]);
    $destination = htmlspecialchars($data["destination"]);

    if(!empty($date_today)) :
        if(!empty($time_out && $time_back)) :
            $query = '
                INSERT INTO business_trip (no_car, id_driver, date_today, time_out, time_back, destination)
                VALUES (:no_car, :id_driver, :date_today, :time_out, :time_back, :destination)';
            $params = [
                ':no_car' => $no_car,
                ':id_driver' => $id_driver,
                ':date_today' => $date_today,
                ':time_out' => $time_out,
                ':time_back' => $time_back,
                ':destination' => $destination
            ];
        else :
            $query = '
                INSERT INTO business_trip (no_car, id_driver, date_today, destination)
                VALUES (:no_car, :id_driver, :date_today, :destination)';
            $params = [
                ':no_car' => $no_car,
                ':id_driver' => $id_driver,
                ':date_today' => $date_today,
                ':destination' => $destination
            ];
        endif;
    else :
        $query = '
            INSERT INTO business_trip (no_car, id_driver, destination)
            VALUES (:no_car, :id_driver, :destination)';
        $params = [
            ':no_car' => $no_car,
            ':id_driver' => $id_driver,
            ':destination' => $destination
        ];
    endif;

    $stmt = $pdo->prepare($query);

    $stmt->execute($params);
    return $stmt->rowCount();
}

/* For edit_user is placed in detail-user.php page
 * on the top of the page
 */

function edit_driver($data) {
    global $pdo;

    $id = htmlspecialchars($data["id-driver"]);
    $name = htmlspecialchars($data["name"]);
    $hp_wa = htmlspecialchars($data["hp-wa"]);

    $stmt = $pdo->prepare('UPDATE driver SET
        name = :name, no_hp_wa = :hp_wa
        WHERE id_driver = :id');

    $stmt->execute([':name' => $name, ':hp_wa' => $hp_wa, ':id' => $id]);
    return $stmt->rowCount();
}

function edit_car($data) {
    global $pdo;

    $no_car = htmlspecialchars($data["no-car"]);
    $type = htmlspecialchars($data["type"]);
    
    $stmt = $pdo->prepare('UPDATE car SET
        no_car = :no_car, type = :type
        WHERE no_car = :no_car');
    $params = [
        ':no_car' => $no_car,
        ':type' => $type,
        ':no_car' => $no_car,
    ];

    $stmt->execute($params);
    return $stmt->rowCount();
}

function edit_business_trip($data) {
    global $conn;
    // global $pdo;

    /* Unable to perform query using PDO with prepared statement
     * so do mysqli. The problem is "how to set to NULL value
     * for date_today variable".
     */

    $id = htmlspecialchars($data["id-business-trip"]);
    $no_car = htmlspecialchars($data["no-car"]);
    $id_driver = htmlspecialchars($data["id-driver"]);
    $date_today = htmlspecialchars($data["date-today"]);
    $time_out = htmlspecialchars($data["time-out"]);
    $time_back = htmlspecialchars($data["time-back"]);
    $destination = htmlspecialchars($data["destination"]);

    $date_today = !empty($date_today) ? "'$date_today'" : "NULL";

    if($date_today == "NULL") :
        $time_out = "NULL";
        $time_back = "NULL";
    else :
        $time_out = !empty($time_out) ? "'$time_out'" : "NULL";
        if($time_out == "NULL") :
            $time_back = "NULL";
        else :
            $time_back = !empty($time_back) ? "'$time_back'" : "NULL";
        endif;
    endif;

    $query = "UPDATE business_trip
        SET no_car = '$no_car', id_driver = '$id_driver', date_today = $date_today, time_out = $time_out,
        time_back = $time_back, destination = '$destination'
        WHERE id_business_trip = '$id'";
    // $query = 'UPDATE business_trip
    //     SET no_car = :no_car, id_driver = :id_driver,
    //     date_today = :date_today, time_out = :time_out
    //     time_back = :time_back, destination = :destination
    //     WHERE id_business_trip = :id';
    // $params = [
    //     ':no_car' => $no_car,
    //     ':id_driver' => $id_driver,
    //     ':date_today' => $date_today,
    //     ':time_out' => $time_out,
    //     ':time_back' => $time_back,
    //     ':destination' => $destination
    // ];

    mysqli_query($conn, $query);
    // $stmt = $pdo->prepare($query);

    // $stmt->execute($params);
    return mysqli_affected_rows($conn);
    // return $stmt->rowCount();
}

function delete_user($data) {
    global $pdo;

    $id = htmlspecialchars($data["id-user"]);

    $stmt = $pdo->prepare('DELETE FROM user WHERE id_user = :id');
    $stmt->execute([':id' => $id]);    

    return $stmt->rowCount();
}

function delete_driver($data) {
    global $pdo;

    $id = htmlspecialchars($data["id-driver"]);

    $stmt = $pdo->prepare('DELETE FROM driver WHERE id_driver = :id');
    $stmt->execute([':id' => $id]);    

    return $stmt->rowCount();
}

function delete_car($data) {
    global $pdo;

    $no_car = htmlspecialchars($data["no-car"]);

    $stmt = $pdo->prepare('DELETE FROM car WHERE no_car = :no_car');
    $stmt->execute([':no_car' => $no_car]);
    
    return $stmt->rowCount();
}

function delete_business_trip($data) {
    global $pdo;

    $id_business_trip = htmlspecialchars($data["id-business-trip"]);

    $stmt = $pdo->prepare('DELETE FROM business_trip WHERE id_business_trip = :id_business_trip');
    $stmt->execute([':id_business_trip' => $id_business_trip]);

    return $stmt->rowCount();
}
?>