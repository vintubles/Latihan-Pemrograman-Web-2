
<?php
/****************************************************
Halaman ini merupakan halaman logout, di mana kita menghapus session yang ada.
*****************************************************/

session_start();

if (isset($_SESSION['login'])) {

    // menghapus session
    unset($_SESSION);
    session_destroy();

    // menampilkan pesan logout
    echo "<h1>Anda sudah berhasil LOGOUT</h1>";
    echo "<h2>Klik <a href='session1.php'>di sini</a> untuk
    LOGIN kembali</h2>";

    echo "<h2>Anda sekarang tidak bisa masuk ke halaman
    <a href='session2.php'>session2.php</a> lagi</h2>";

} else {
    echo "<h1>Anda belum login atau sudah logout!</h1>";
}
?>