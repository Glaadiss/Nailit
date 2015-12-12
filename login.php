<? require 'config.php'; ?>
<?php

?>
<?php
$login = $_POST['login'];
$haslo = $_POST['haslo'];
$haslo = addslashes($haslo);
$login = addslashes($login);
$login = htmlspecialchars($login);

if ($_GET['login'] != '') { //jezeli ktos przez adres probuje kombinowac
require ('header.php');
exit;
}
if ($_GET['haslo'] != '') { //jezeli ktos przez adres probuje kombinowac
require ('header.php');
exit;
}

$haslo = md5($haslo); //szyfrowanie hasla
    if (!$login OR empty($login)) {
        require ('header.php');
echo '<p class="alert">Wypełnij pole z loginem!</p>';
exit;
}
    if (!$haslo OR empty($haslo)) {
        require ('header.php');
echo '<p class="alert">Wypełnij pole z hasłem!</p>';
exit;
}
$sql = "SELECT * FROM `uzytkownicy` WHERE `nick` = '$login' AND `haslo` = '$haslo'";
$result = @$connect->query($sql);
$istnick = @$result->num_rows;
    if ($istnick == 0) {
        require ('header.php');
echo 'Logowanie nieudane. Sprawdź pisownię nicku oraz hasła.';
    } else {
$user = @$result->fetch_assoc();
$_SESSION['nick'] = $login;
$_SESSION['id'] = $user[id];
$_SESSION['ip'] = $user[ip];
$_SESSION['email'] = $user[email];
$_SESSION['avatar'] = $user[avatar];
header('Location: index.php');


}
?>

<?php  require 'footer.php'; ?>