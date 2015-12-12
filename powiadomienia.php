<?php require 'config.php'; 
  	if ((empty($_SESSION['id'])))
    {
    	header('Location: index.php');   
    	exit();
    }
	require 'header.php';
?>
<?php
			$false = '0';
			$noticee = $connect->query("SELECT * FROM notice WHERE user_id = '$_SESSION[id]' and sender_id != '$_SESSION[id]' ORDER BY `date` DESC LIMIT 8");
			while ($line = $noticee->fetch_assoc()) 
			{
			$connect->query("UPDATE `notice` SET reaad ='$false' WHERE user_id = '$_SESSION[id]'");
			$sender = $connect->query("SELECT * FROM uzytkownicy WHERE id = '$line[sender_id]'");
			$sender = $sender->fetch_assoc();
			$sende = $sender[nick];
			$avatar = $sender[avatar];
			if($line[comment_id])
			{
			$comment = $connect->query("SELECT * FROM comment WHERE id = '$line[comment_id]' ")->fetch_assoc();
			if($comment[foto_id])
			{
			?>
			<a href="currentphoto.php?id=<?php echo $comment[foto_id];?>"><h2> <img src="<? echo $avatar; ?>" alt="Obrazek" width=30px height=30px />
			<?php echo $sende;?> polubił twój komentarz! </h2>
			<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
			<? echo substr($line[date], 0, -3);?> 
			</a>
			<?php 
			}
			else if($comment[post_id])
			{
			?>
			<a href="index.php#<?php echo $comment[post_id] ?>"><h2> <img src="<? echo $avatar; ?>" alt="Obrazek" width=30px height=30px />
			<?php echo $sende;?> polubił twój komentarz! </h2>
			<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
			<? echo substr($line[date], 0, -3);?> 
			</a>
			<?php
			}
			}
			if($line[foto_id])
			{
			?>
			<a href="currentphoto.php?id=<?php echo $line[foto_id];?>"><h2> <img src="<? echo $avatar; ?>" alt="Obrazek" width=30px height=30px />
			<?php  if($line[post] == '0') 
			echo $sende.' polubił ';  
			else 
			echo $sende.' skomentował '; 
			?> 
			 twoje zdjęcie!</h2>
			<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
			<? echo substr($line[date], 0, -3);?> 
			</a>
			<?php
			}
			if($line[friends_id])
			{
			?>
			<a href="friend.php?id=<?php echo $line[sender_id];?>"><h2> <img src="<? echo $avatar; ?>" alt="Obrazek" width=30px height=30px />
			<?php echo $sende;?> zaprosił Cię do grona znajomych!</h2>
			<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
			<? echo substr($line[date], 0, -3);?> 
			</a>
			<?php
			}
			if($line[post_id])
			{
			?>
			<a href="index.php#<?php echo $line[post_id] ?>"><h2><img src="<? echo $avatar; ?>" alt="Obrazek" width=30px height=30px />
			<?php  if($line[post] == '0') 
			echo $sende.' polubił ';  
			else 
			echo $sende.' skomentował '; 
			?> 
			 twój post!</h2>
			<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
			<? echo substr($line[date], 0, -3);?> 
			</a>
			<?php
			}
			}
			?>
<?php require 'footer.php';?>

		