<? require 'config.php';
$ip = $_SERVER['REMOTE_ADDR']; 
?>

<?php require 'header.php';  ?>
<div class="container bg">


<?php
$previous = $connect->query("SELECT * FROM  `uzytkownicy` ORDER BY id DESC LIMIT 1")-> fetch_assoc();
$now = $previous[id] + 1;
$akcja = $_GET['akcja'];
$komunikaty = ''; 
    if ($akcja == wykonaj) {

  $max_rozmiar = 4024*4024;
  if (is_uploaded_file($_FILES['plik']['tmp_name'])) {
    $name = strip_tags($_POST['nazwa']);    
    $file = $_FILES['plik']['name'];
    $file_type = $_FILES['plik']['type'];
    $file_size = $_FILES['plik']['size'];
    if ($file_size > $max_rozmiar) 
    {
        $komunikaty .=  'BÅ‚Ä…d! Plik jest za duÅ¼y!<br>';
    }
    else if($file_type == 'image/jpeg' or $file_type == 'image/png' or $file_type == 'image/bmp' or $file_type == 'image/jpg') 
    {
       // dziaua
    }
    else{
        $komunikaty .=  ' Niedozwolony typ plików <br>';        
    }
  } 
  else
  {
    $default = true;
  }



//
$nick = substr(addslashes(htmlspecialchars($_POST['nick'])),0,32);
$nick = strip_tags(trim($nick));
$haslo = substr(addslashes($_POST['haslo']),0,32);
$vhaslo = substr($_POST['vhaslo'],0,32);
$email = substr($_POST['email'],0,32);
$vemail = substr($_POST['vemail'],0,32);
//kilka sprawdzen co do nicku i maila
$spr1 = $connect -> query("SELECT COUNT(*) FROM uzytkownicy WHERE nick='$nick' LIMIT 1") -> num_rows; //czy user o takim nicku istnieje
$spr2 = $connect -> query("SELECT COUNT(*) FROM uzytkownicy WHERE email='$email' LIMIT 1")-> num_rows; // czy user o takim emailu istnieje
$pos = strpos($email, "@");
$pos2 = strpos($email, ".");
$emailx = explode("@", $email);
$pattern1 = '/^[a-z0-9\-._]+@[a-z]+\.[a-z]{2,4}$/';
$spr4 = strlen($nick);
$spr5 = strlen($haslo);
//sprawdzenie co uzytkownik zle zrobil
if (!$nick || !$email || !$haslo || !$vhaslo || !$vemail ) {
$komunikaty .= "Musisz wypełnić wszystkie pola!<br>"; }
if ($spr4 < 4) {
$komunikaty .= "Login musi mieć przynajmniej 4 znaki<br>"; }
if ($spr5 < 4) {
$komunikaty .= "Hasło musi mieć przynajmniej 4 znaki<br>"; }
if ($spr1[0] >= 1) {
$komunikaty .= "Ten login jest zajęty!<br>"; }
if ($spr2[0] >= 1) {
$komunikaty .= "Ten e-mail jest już używany!<br>"; }
if ($email != $vemail) {
$komunikaty .= "E-maile się nie zgadzają ...<br>";}
if ($haslo != $vhaslo) {
$komunikaty .= "Hasła się nie zgadzają ...<br>";}
if ($pos == false OR $pos2 == false OR !preg_match($pattern1, $email)) {
$komunikaty .= "Nieprawidłowy adres e-mail<br>"; }



//jesli cos jest nie tak to blokuje rejestracje i wyswietla bledy
if ($komunikaty) {
echo '
<b>Rejestracja nie powiodła się, popraw następujące błędy:</b><br>
'.$komunikaty.'<br>';
} else {
//jesli wszystko jest ok dodaje uzytkownika i wyswietla informacje
$nick = str_replace ( ' ','', $nick );
$haslo = md5($haslo); //szyfrowanie hasla
if(!$default)
{
$file = 'foto/'.$now.'/'.$file;
$path = getcwd().'/foto/'.$now;
if ( ! is_dir($path)) 
{
  mkdir($path);
}
$avatar = 'avatar'.$now.$file_size;
move_uploaded_file($_FILES['plik']['tmp_name'], getcwd().'/foto/'.$now.'/'.$_FILES['plik']['name']);
$sql="INSERT INTO `foto` (file, type, size, user_id, name, datetime)  VALUES ('$file', '$file_type', '$file_size', '$now', '$avatar', '$date' )";
$connect ->query($sql)  or die ("Nie mogłem Cie zarejestrować!1");

$connect->query("INSERT INTO `uzytkownicy` (nick, email, haslo, ip, avatar, type_avatar, size_avatar, datetime) VALUES('$nick','$email','$haslo','$ip', 
'$file','$file_type','$file_size', '$date')") or die("Nie mogłem Cie zarejestrować!");
}
else
{
$file='avatar.png';
$file_type='image/png';
$file_size='60000';
$connect->query("INSERT INTO `uzytkownicy` (nick, email, haslo, ip, avatar, type_avatar, size_avatar, datetime) VALUES('$nick','$email','$haslo','$ip', '$file','$file_type','$file_size', '$date')") or die("Nie mogłem Cie zarejestrować!");

}


echo '<br><span style="color: green; font-weight: bold;">Zostałeś zarejestrowany '.$nick.'. Teraz możesz się zalogować</span><br>';
echo '<br><a href="index.php">Logowanie</a>';
}
}
?>

<form class="form-horizontal" method="POST" action="registration.php?akcja=wykonaj" enctype="multipart/form-data">
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-3 control-label">Login</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" id="inputEmail3" placeholder="Login"
      name="nick" maxlength="18">
    </div>
  </div>

  <div class="form-group">
    <label for="inputPassword3" class="col-sm-3 control-label">Hasło</label>
    <div class="col-sm-6">
      <input type="password" class="form-control" id="inputPassword3" placeholder="Hasło"
      name="haslo" maxlength="32">
    </div>
  </div>

    <div class="form-group">
    <label for="inputPassword3" class="col-sm-3 control-label">Powtórz Hasło</label>
    <div class="col-sm-6">
      <input type="password" class="form-control" id="inputPassword3" placeholder="Hasło"
      name="vhaslo" maxlength="32">
    </div>
  </div>

    <div class="form-group">
    <label for="inputEmail3" class="col-sm-3 control-label">Email</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" id="inputEmail3" placeholder="email"
      name="email" maxlength="50">
    </div>
  </div>

    <div class="form-group">
    <label for="inputEmail3" class="col-sm-3 control-label">Powtórz email</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" id="inputEmail3" placeholder="email"
      name="vemail" maxlength="50">
    </div>
  </div>

     <div class="form-group">
    <label class="col-sm-3 control-label">Avatar</label>
    <div class="col-sm-6">
      <input type="file" class="form-control" name="plik" maxlength="50">
    </div>
  </div>


<div class="form-group">
<label class="col-sm-3 control-label"> <button type="submit" class="btn btn-default"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Zarejestruj</button></label>
      
  </div>
</form>


<?php require 'footer.php'; ?>