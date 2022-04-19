<?php

include '../function/connection.php';

if(isset($_GET["id-business-trip"])) :
    if (delete_business_trip($_GET) > 0) :
    echo "
        <script>
        alert('Data perjalanan berhasil dihapus!');
        document.location.href = './data-business-trip.php';
        </script>
        ";
    else :
        echo "
            <script>
            alert('Data perjalanan gagal dihapus!');
            document.location.href = './data-business-trip.php';
            </script>
        ";
    endif;
endif;

?>