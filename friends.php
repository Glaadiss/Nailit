<? require 'config.php'; 
  if ((empty($_SESSION['id'])))
    {
    	header('Location: index.php');   
    	exit();
    }
?>
<? require 'header.php'; ?>


<div class="container ">

<?

$friends = $connect->query("SELECT * from friends WHERE user_id='$_SESSION[id]' OR friend_id='$_SESSION[id]' ");

while($row = $friends-> fetch_assoc()){
if($row[user_id] == $_SESSION[id])
{
$zaq = $connect->query("SELECT * from uzytkownicy WHERE id='$row[friend_id]' LIMIT 1") -> fetch_assoc();	
}
else
{
$zaq = $connect->query("SELECT * from uzytkownicy WHERE id='$row[user_id]' LIMIT 1")-> fetch_assoc();	
}
echo '
<form method="POST" action="forms.php?id='.$zaq[id].'&akcja=friends">
<h3><a href="friend.php?id='.$zaq[id].'" class="btn btn-warning btn-lg" role="button">
<img src="'.$zaq[avatar].'" alt=" Obrazek " width=30px height=30px /> '.$zaq[nick].'</a></h3>
<button type="submit" class="btn btn-default"> <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Usuń znajomego</button>
</form><br><a href="converse.php?id='.$zaq[id].'&idd='.$_SESSION[id].'"><button class="btn btn-default"> <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Wiadomość </button></a>
';
}



?>

<?php require 'footer.php'; ?>