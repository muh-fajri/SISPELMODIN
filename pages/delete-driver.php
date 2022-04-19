<?php

include '../function/connection.php';

if(isset($_GET["id-driver"])) :
    if (delete_driver($_GET) > 0) :
    echo "
        <script>
        alert('Data supir berhasil dihapus!');
        document.location.href = './data-driver.php';
        </script>
        ";
    else :
        echo "
            <script>
            alert('Data supir gagal dihapus!');
            document.location.href = './data-driver.php';
            </script>
        ";
    endif;
endif;

?>