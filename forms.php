<? require 'config.php'; 
  if ((empty($_SESSION['id'])))
    {
    	header('Location: index.php');   
    	exit();
    }

date_default_timezone_set('UTC');
$date = date("Y-m-d H:i:s");
$email = $_SESSION['email'];
$row = $connect->query("SELECT * FROM uzytkownicy WHERE id = '$_SESSION[id]'")-> fetch_assoc(); 
$users = $connect->query("SELECT * from uzytkownicy");
$likes = $connect->query("SELECT * from `like`");
$komunikaty = '';
$true = '1';
$false = '0';
//
@$id = $_GET['id'];
@$akcja = $_GET['akcja'];
@$idd = $_GET['idd'];

if($akcja==currentphoto)
{
$content = $_POST['content'];
$sql = "INSERT INTO comment (content, photo_id, user_id, datetime) VALUES('$content', '$id', '$_SESSION[id]', '$date')";
$connect ->query($sql);
$comment = $connect->query("SELECT * FROM foto WHERE id = '$id'")->fetch_assoc();
$user = $connect->query("SELECT * FROM uzytkownicy WHERE id = '$comment[user_id]' ")->fetch_assoc();
$connect->query("INSERT INTO notice(user_id, sender_id, foto_id, `date`, post) VALUES('$user[id]', $_SESSION[id], '$id', '$date', '$true')");
$akcja = '';
header('Location: currentphoto.php?id='.$id);  
exit();
}

if($akcja == friends)
{
$connect->query("DELETE from friends WHERE user_id = '$_SESSION[id]' AND friend_id = '$id' ");
$connect->query("DELETE from friends WHERE user_id = '$id' AND friend_id = '$_SESSION[id]' ");
$akcja = '';
header('Location: friends.php'); 
exit();
}


if ($akcja == friend)
{
$friend = $connect->query("SELECT * from uzytkownicy WHERE id='$id' LIMIT 1");
$friend = $friend -> fetch_assoc();
$user_id = $_SESSION[id]; 
$friend_id = $friend[id];
$relation = $connect->query("SELECT * from friends WHERE user_id = '$user_id' AND friend_id = '$friend_id' ") -> num_rows;
$relation2 = $connect->query("SELECT * from friends WHERE user_id = '$friend_id' AND friend_id = '$user_id' ") -> num_rows;
if($relation == 0 AND $relation2 == 0 AND $user_id != $friend_id) 
$connect->query("INSERT INTO `friends` (user_id, friend_id) VALUES ('$_SESSION[id]', '$friend_id')");
$friendship = $connect->query("SELECT * FROM friends WHERE user_id = '$_SESSION[id]' and friend_id = '$friend_id'")->fetch_assoc();
$connect->query("INSERT INTO notice (user_id,sender_id, friends_id, `date`) VALUES ('$friend_id', '$_SESSION[id]', '$friendship[id]', '$date')");	
$akcja = '';
header('Location: friend.php?id='.$friend[id]); 
exit();
}

if($akcja == usunkoment)
{
$connect->query("DELETE from comment WHERE id = '$idd' ");
$akcja = '';
header('Location: currentphoto.php?id='.$id);  
exit();
}

if($akcja == lubiekoment)
{
$user = $connect->query("SELECT * FROM comment WHERE id = '$idd'")->fetch_assoc();
$connect->query("INSERT INTO `like` ( user_id, lubie, comment_id ) VALUES('$_SESSION[id]', '1','$idd')");
$userr = $connect->query("SELECT * FROM uzytkownicy WHERE id = '$user[user_id]'")->fetch_assoc();
$connect->query("INSERT INTO `notice`( user_id, sender_id, comment_id, `date` ) VALUES('$userr[id]','$_SESSION[id]','$idd', '$date')");
$akcja = '';
header('Location: currentphoto.php?id='.$id);  
exit();
}

if($akcja == nlubiekoment)
{
$connect->query("DELETE from `like` WHERE id='$idd'");
$akcja = '';
header('Location: currentphoto.php?id='.$id);  
exit();
}


if($akcja == usunfoto)
{
$connect->query("DELETE from foto WHERE id = '$id' ");
$akcja = '';
header('Location: photo.php');  
exit();
}

if($akcja == lubiefoto)
{
$connect->query("INSERT INTO `like` ( user_id, lubie, photo_id ) VALUES('$_SESSION[id]', '1','$id')");
$photo = $connect->query("SELECT * FROM foto WHERE id = '$id' ")->fetch_assoc();
$user = $connect->query("SELECT * FROM uzytkownicy WHERE id = '$photo[user_id]' ")->fetch_assoc();
$connect->query("INSERT INTO notice(user_id, sender_id, foto_id, `date`) VALUES('$user[id]', $_SESSION[id], '$id','$date')");
$akcja = '';
header('Location: currentphoto.php?id='.$id);  
exit();
}

if($akcja == nlubiefoto)
{
$connect->query("DELETE from `like` WHERE id='$idd'");
$akcja = '';
header('Location: currentphoto.php?id='.$id);  
exit();
}

if($akcja == usunpost)
{
$connect->query("DELETE from post WHERE id = '$id' ");
$akcja = '';
header('Location: index.php');  
exit();
}

if($akcja == lubiepost)
{
$connect->query("INSERT INTO `like` ( user_id, lubie, post_id ) VALUES('$_SESSION[id]', '1','$id')");
$post = $connect->query("SELECT * FROM post WHERE id = '$id'")->fetch_assoc();
$user = $connect->query("SELECT * FROM uzytkownicy WHERE id = '$post[user_id]'")->fetch_assoc();
$connect->query("INSERT INTO notice (user_id, sender_id, post_id, `date`) VALUES('$user[id]', '$_SESSION[id]', '$id', '$date')");
$akcja = '';
header('Location: index.php#'.$id); 
exit();
}

if($akcja == nlubiepost)
{
$connect->query("DELETE FROM `like` WHERE id='$idd'");
$akcja = '';
header('Location: index.php#'.$id);  
exit();
}

if($akcja == post)
{
$content = strip_tags($_POST['content']);
if(strlen($content) > 2)
{
$sql = "INSERT INTO post(content, data, user_id) VALUES('$content', '$date', '$_SESSION[id]')";
$connect->query($sql);
}
$akcja = '';
header('Location: index.php');  
exit();	
}

if($akcja == postkoment)
{
$content = strip_tags($_POST['content']);
$sql = "INSERT INTO comment(content, user_id, post_id, datetime) VALUES ('$content', '$_SESSION[id]', '$id', '$date')";
$connect ->query($sql);
$post = $connect->query("SELECT * FROM post WHERE id = '$id'")->fetch_assoc();
$user = $connect->query("SELECT * FROM uzytkownicy WHERE id = '$post[user_id]'")->fetch_assoc();
$connect->query("INSERT INTO notice (user_id, sender_id, post_id, `date`, post) VALUES('$user[id]', '$_SESSION[id]', '$id', '$date', '$true')");
$akcja = '';
header('Location: index.php#'.$id);  
exit();		
}

if($akcja == usunkomentb)
{
$connect->query("DELETE from comment WHERE id = '$idd' ");
$akcja = '';
header('Location: index.php#'.$id);  
exit();
}

if($akcja == lubiekomentb)
{
$user = $connect->query("SELECT * FROM comment WHERE id = '$idd'")->fetch_assoc();
$user_id = $user[user_id];
$connect->query("INSERT INTO `like` ( user_id, lubie, comment_id ) VALUES('$_SESSION[id]', '1','$idd')");
$userr = $connect->query("SELECT * FROM uzytkownicy WHERE id = '$user_id'")->fetch_assoc();
$connect->query("INSERT INTO `notice`( user_id, sender_id, comment_id,`date` ) VALUES('$userr[id]','$_SESSION[id]','$idd', '$date')");
$akcja = '';
header('Location: index.php#'.$id); 
exit();
}

if($akcja == nlubiekomentb)
{
$connect->query("DELETE from `like` WHERE id='$idd'");
$akcja = '';
header('Location: index.php#'.$id);  
exit();
}

// ------------------------------------------------------------------------
if($akcja == avatar)
{
 $max_rozmiar = 4024*4024;
  if (is_uploaded_file($_FILES['plik']['tmp_name'])) {
    $name = $_POST['nazwa'];    
    $file = $_FILES['plik']['name'];
    $file_type = $_FILES['plik']['type'];
    $file_size = $_FILES['plik']['size'];
    if ($file_size > $max_rozmiar) 
    {
        $komunikaty .=  'BÅ‚Ä…d! Plik jest za duÅ¼y!<br>';
    }
    else if($file_type == 'image/jpeg' or $file_type == 'image/png' or $file_type == 'image/bmp' or $file_type == 'image/jpg') 
    {
       if(!$default)
{
$file = 'foto/'.$_SESSION[id].'/'.$file;
$path = getcwd().'/foto/'.$_SESSION[id];
if ( ! is_dir($path)) 
{
  mkdir($path);
}
$avatar = 'avatar'.$_SESSION[id].$file_size;
move_uploaded_file($_FILES['plik']['tmp_name'], getcwd().'/foto/'.$_SESSION[id].'/'.$_FILES['plik']['name']);
$sql="INSERT INTO `foto` (file, type, size, user_id, name, datetime)  VALUES ('$file', '$file_type', '$file_size', '$_SESSION[id]', '$avatar', '$date' )";
$connect ->query($sql);

$connect->query("UPDATE `uzytkownicy` SET avatar='$file', type_avatar='$file_type', size_avatar='$file_size' WHERE id = '$_SESSION[id]'");
}

    }
    else{
        $komunikaty .=  ' Niedozwolony typ plików <br>';        
    }
  } 
$akcja = '';
if($komunikaty)
{
$_SESSION['komunikaty'] = $komunikaty;
header('Location: profil.php'); 
exit();
}
else
{
header('Location: profil.php');  
exit();
}
}
// ------------------------------------------------------------------------
if($akcja == nick)
{
$nick = substr(addslashes(htmlspecialchars($_POST['nick'])),0,32);
$nick = strip_tags(trim($nick));
$spr1 = $connect -> query("SELECT COUNT(*) FROM uzytkownicy WHERE nick='$nick' LIMIT 1") -> num_rows; //czy user o takim nicku istnieje
if(!$nick){
$komunikaty.= "Uzupełnij pola! <br>";}
else if(strlen($nick) < 4)
{
$komunikaty.="Nick jest za krótki! <br>";
}
else if ($spr1[0] >= 1) {
$komunikaty .= "Ten login jest zajęty!<br>"; }
else{
$_SESSION[nick] = $nick;
$connect->query("UPDATE `uzytkownicy` SET nick='$nick' WHERE id = '$_SESSION[id]'");
}

if($komunikaty)
{
$_SESSION['komunikaty'] = $komunikaty;
header('Location: profil.php'); 
exit();
}
else
{
header('Location: profil.php');  
exit();
}
}


// ------------------------------------------------------------------------
if($akcja == haslo)
{
if(isset($_POST['haslo']) AND isset($_POST['vhaslo']))
{
$haslo = $_POST['haslo'];
$vhaslo = $_POST['vhaslo'];
  if($haslo != $vhaslo)
  {
    $komunikaty .= "Hasła nie są identyczne <br>";
  }
  else if(!$haslo)
  {
  $komunikaty.= "Uzupełnij pola! <br>";
  }
  else if(strlen($haslo) < 4)
  {
    $komunikaty .= "Hasło jest za krótkie <br>";
  }
  else
  {
    $haslo = md5($haslo);
    $connect->query("UPDATE `uzytkownicy` SET haslo='$haslo' WHERE id = '$_SESSION[id]'");
  }
}
else
{
$komunikaty .= "Hasła nie są identyczne <br>";
}




if($komunikaty)
{
$_SESSION[komunikaty] = $komunikaty;
header('Location: profil.php'); 
exit();
}
else
{
header('Location: profil.php');  
exit();
}
}

// ------------------------------------------------------------------------

if($akcja == email)
{
if(isset($_POST['email']) AND isset($_POST['vemail']))
{
  $email =$_POST['email'];
  $vemail = $_POST['vemail'];
  $spr2 = $connect -> query("SELECT COUNT(*) FROM uzytkownicy WHERE email='$email' LIMIT 1")-> num_rows; // czy user o takim emailu istnieje
  if ($spr2[0] >= 1) {
  $komunikaty .= "Ten e-mail jest już używany!<br>"; }
  else if ($email != $vemail) {
  $komunikaty .= "E-maile się nie zgadzają ...<br>";}
  else if(strlen($email) < 6)
  {
    $komunikaty .= "email jest za krótkie <br>";
  }
  else
  {
    $_SESSION[email] = $email;
    $connect->query("UPDATE `uzytkownicy` SET email='$email' WHERE id = '$_SESSION[id]'");
  }
}
else
{
$komunikaty .= "Wprowadź wszystkie dane <br>" ;
}

if($komunikaty)
{
$_SESSION[komunikaty] = $komunikaty;
header('Location: profil.php'); 
exit();
}
else
{
header('Location: profil.php');  
exit();
}
}

if($akcja == message)
{
  $content = $_POST['content'];
  if(strlen($content) > 0 )
  {
    $connect->query("INSERT INTO message(user_id, customer_id, `date`, content) VALUES('$idd', '$id', '$date', '$content')");
  }
header('Location: converse.php?id='.$id.'&idd='.$idd); 
}




?>