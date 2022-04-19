<?php

include '../function/connection.php';

if(isset($_GET["no-car"])) :
    if (delete_car($_GET) > 0) :
    echo "
        <script>
        alert('Data mobil berhasil dihapus!');
        document.location.href = './data-car.php';
        </script>
        ";
    else :
        echo "
            <script>
            alert('Data mobil gagal dihapus!');
            document.location.href = './data-car.php';
            </script>
        ";
    endif;
endif;

?>