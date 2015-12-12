<?php require 'config.php';
		    if ((empty($_SESSION['id'])))
		    {
		    	header('Location: index.php');   
		    	exit();
		    }
		    
		require 'header.php';

		$photo_id = $_GET['id'];
		if(!$photo_id)
		{
			echo '<h3> Zabłądziłeś! <a href="index.php"> Wróć do strony głównej </a> </h3>';
		}

		$sql = "SELECT * FROM foto WHERE id = '$photo_id'";
		$photo = $connect-> query($sql)-> fetch_assoc();
		$sql = "SELECT * FROM uzytkownicy WHERE id ='$photo[user_id]'";
		$photo_user = $connect-> query($sql)-> fetch_assoc();
		$sql = "SELECT * FROM comment WHERE photo_id = '$photo_id' ";
		$comments = $connect ->query($sql);
?>

<div class="container"> 

<div id="info">     
 <h3><a href="friend.php?id=<? echo $photo_user[id]; ?>"<img src=" <? echo $photo_user[avatar]; ?>" alt=" Obrazek " width=40px height=40px /> <?php echo ' '.$photo_user[nick]; ?></a></h3>
 <h4> <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span><? echo substr($photo[datetime], 0, -3);?> </h4>
 <h3> <?php echo ' '.$photo[name]; ?> </h3>

 <br/>

 <form method="post" action="forms.php?id=<?php echo $photo_id; ?>&akcja=currentphoto">
 <div class="form-group">
 <textarea name="content" class="form-control" placeholder="Treść"></textarea>
 <button type="submit" class="btn btn-default">Dodaj komentarz</button>
 </div>
 </form>
 <br/>
 <div id="comments">
<?php 
		while($row = $comments->fetch_assoc()){
		$sql = "SELECT * FROM uzytkownicy WHERE id='$row[user_id]'";
		$user = $connect->query($sql)->fetch_assoc();
		$nick = $user[nick];
?>
		<div class="comment">
		<p> <? echo substr($row[datetime], 0, -3);?> </p>
		<hr />
		<a href="friend.php?id=<? echo $user[id]; ?>">
		<img src="<? echo $user[avatar]; ?>" alt=" Obrazek " width=30px height=30px /> <strong><?php echo $nick;?> </strong>
		</a>
		<br/>
		<? echo $row[content]; ?> 
		<br/>
		<hr />
		<p>
		<?php   if($row[user_id] == $_SESSION[id] or $photo[user_id] == $_SESSION[id]){         ?>
		<a class="button btn btn-danger left" href="forms.php?id=<?php echo $photo_id;?>&akcja=usunkoment&idd=<?php echo $row[id];?>"> <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> </a>   
		<?php 
		}
			$sql = "SELECT * FROM `like` WHERE  comment_id = '$row[id]'";	
			$lubie_num = $connect -> query($sql)->num_rows;
			$sql = "SELECT * FROM `like` WHERE user_id = '$_SESSION[id]' and comment_id = '$row[id]'";
			$lubie = $connect->query($sql)->fetch_assoc();
			if(!$lubie){
		?>
		<a class="button btn btn-info right" href="forms.php?id=<?php echo $photo_id;?>&akcja=lubiekoment&idd=<?php echo $row[id];?>"> 
		<span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>(<?php echo $lubie_num; ?>)</a>
		<?php }
			else if($lubie){
		 ?> 
		 <a class="button btn btn-danger right" href="forms.php?id=<?php echo $photo_id;?>&akcja=nlubiekoment&idd=<?php echo $lubie[id];?>"> 
		<span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span>(<?php echo $lubie_num; ?>)</a>
		<?php } ?>
		</p>  
		</div>

<?php
		}
?>
</div>
</div>
<div id="main">
<img src=" <? echo $photo[file]; ?>" alt="Obrazek" /> 
<br />
<hr />
		<div>
		<?php   if($photo[user_id] == $_SESSION[id]){         ?>
		<a class="button btn btn-danger left" href="forms.php?id=<?php echo $photo_id;?>&akcja=usunfoto"> <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> </a>   
		<?php 
		}
			$sql = "SELECT * FROM `like` WHERE  photo_id = '$photo[id]'";	
			$lubie_num = $connect -> query($sql)->num_rows;
			$sql = "SELECT * FROM `like` WHERE user_id = '$_SESSION[id]' and photo_id = '$photo[id]'";
			$lubie = $connect->query($sql)->fetch_assoc();
			if(!$lubie){
		?>
		<a class="button btn btn-info right" href="forms.php?id=<?php echo $photo_id;?>&akcja=lubiefoto">
		 <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> (<?php echo $lubie_num; ?>)</a>
		<?php }
			else if($lubie){
		 ?> 
		 <a class="button btn btn-danger right" href="forms.php?id=<?php echo $photo_id;?>&akcja=nlubiefoto&idd=<?php echo $lubie[id];?>"> 
		<span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> (<?php echo $lubie_num; ?>)</a>
		<?php } ?>
		</div>  

</div>





</div>
<?php require 'footer.php'; ?>