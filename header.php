<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>
    <?php
    $true = '1';
    $false = '0'; 
    $notice = $connect->query("SELECT * FROM notice WHERE user_id='$_SESSION[id]' and  sender_id != '$_SESSION[id]' and reaad = '$true' ");
    $message = $connect->query("SELECT * FROM message WHERE customer_id='$_SESSION[id]' and reaad='$false' ");
    $message_num = $message->num_rows;
    $notice_num = $notice->num_rows;
    $sum = intval($message_num ) + intval($notice_num);
    if($notice_num > 0 or $message_num > 0){
    echo '('.$sum.')' ;
    }
    ?>
    NaiLit </title>
    </head>
    <script src="//cdn.ckeditor.com/4.5.5/standard/ckeditor.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href='https://fonts.googleapis.com/css?family=Lobster+Two:700italic' rel='stylesheet' type='text/css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js">  </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"> </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.0/TweenMax.min.js"></script>
    <body>

<?php   
date_default_timezone_set('UTC');
$date = date("Y-m-d H:i:s");
$id = $_SESSION['id'];
$email = $_SESSION['email'];
$row = $connect->query("SELECT * FROM uzytkownicy WHERE id = '$_SESSION[id]'")-> fetch_assoc(); 
// Pobieranie tabel !!
$users = $connect->query("SELECT * from uzytkownicy");
$likes = $connect->query("SELECT * from `like`");



// 
?>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
	  <span class="sr-only">Toggle navigation</span>
	  <span class="icon-bar"></span>
	  <span class="icon-bar"></span>
	  <span class="icon-bar"></span>
	</button>
	<a class="navbar-brand" href="http://infoprem.pl/guma/">
	  <img alt="Logo" src="logo.png" width="110px" height="80px">
	</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <?php if ((!empty($id))){ ?>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	<form action="index2.php" method="POST" class="navbar-form navbar-left" role="search">
	  <div class="form-group">
	    <input type="text" class="form-control" placeholder="Wyszukaj..." name="search">
	  </div>
	  <button type="submit" class="btn btn-default">Szukaj</button>
	</form>
	
	<ul class="nav navbar-nav navbar-right">
		<?php if($message_num > 0 ) { ?>
		<li style="margin:3px;" ><button type="button" class="btn btn-danger"><a href="message.php">
		<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
		<?php echo $message_num; ?></a></button></li>
		<?php } else{ ?>
		<li><a href="message.php">
		<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
		<?php echo $message_num; ?></a></li>
		<?php } ?>
		<?php if($notice_num > 0 ) { ?>
		<li style="margin:3px;" ><button type="button" class="btn btn-danger"><a href="powiadomienia.php">
		<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span>
		<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
		<?php echo $notice_num; ?></a></button></li>
		<?php } else{ ?>
		<li><a href="powiadomienia.php"><span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span>
		<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
		<?php echo $notice_num; ?></a></li>
		<?php } ?>
		<li class="dropdown">
		<div class="btn-group">
		<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<img src=" <? echo $row[avatar]; ?>" alt=" Obrazek " width=30px height=30px />
		<?php echo $email; ?><span class="caret"></span>
		</button>
		<ul class="dropdown-menu">
		<li><a href="add.php">Dodaj zdjęcie</a></li>
		<li><a href="photo.php">Twoje zdjęcia</a></li>
		<li><a href="friends.php">Znajomi</a></li>
		<li><a href="profil.php">Ustawienia profilu</a></li>
		<li role="separator" class="divider"></li>
		<li><a href="wyloguj.php">Wyloguj się!</a></li>
	    </ul>
	    </div> 
	  </li>
	</ul>
    </div><!-- /.navbar-collapse -->
    <?php        }?>
  </div><!-- /.container-fluid -->
</nav>



<div class="panel-body">

		