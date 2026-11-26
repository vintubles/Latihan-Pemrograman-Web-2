<?php
if ($_FILES['file']['error'] == 0) {
    echo "Upload berhasil";
} else {
    echo "Upload gagal";
}
?>