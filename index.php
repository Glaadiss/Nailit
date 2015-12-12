<? require 'config.php'; ?>
<? 
require 'header.php';
if ((empty($id))){ 
echo <<< HTML
  <div class="container bg">	
  </br>
  <h1>Witaj w NaiLit!!</h1>
  <p></p>
  <p><a class="btn btn-default btn-lg" href="registration.php" role="button"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Dołącz teraz!</a></p>
  <p>Jeśli posiadasz konto:</p>
  <div class="container ">
HTML;

require 'logowanie.php';
echo <<<HTML

</div>

HTML;
}
else{
?>
<div class="container ">
<div class="board">
<form action="forms.php?akcja=post" method="post">
<div class="form-group">
  <textarea name="content" class="form-control" rows="3" id="comment" placeholder="O czym myślisz ?"></textarea>
      <script>
           // CKEDITOR.replace( 'content' );
        </script>
</div>
<div class="form-group">
<button type="submit" class="btn btn-default"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Wyślij!</button> 
  </div>
</form>
</div>

<?php 
$sql = "SELECT * FROM post as p,(SELECT * FROM friends WHERE user_id ='$_SESSION[id]' or friend_id = '$_SESSION[id]') as f WHERE p.user_id = f.user_id or p.user_id = f.friend_id GROUP BY p.id ORDER BY p.data DESC LIMIT 10";
$result = $connect->query($sql);
$result2 = $connect->query($sql);
$sprawdz = $result2->fetch_assoc();
if(!$sprawdz)
{
$sql="SELECT * FROM post WHERE user_id='$_SESSION[id]' ORDER BY data DESC";
$result = $connect->query($sql); 
}
$licznik = 0;
?>

<?
while($row = $result->fetch_array()){
$licznik++;
$sql = "SELECT * FROM uzytkownicy WHERE id = '$row[2]'";
$user = $connect->query($sql)->fetch_assoc();
		
?>
		<div class="post" id=<?php echo $row[0] ?> >
		<p><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>  <? echo substr($row[data], 0, -3);?> </p>
		<hr />
		<a href="friend.php?id=<? echo $user[id]; ?>"><img src="<? echo $user[avatar]; ?>" alt=" Obrazek " width=50px height=50px /> <strong><?php echo $user[nick];?> </strong></a>
		<br/>
		<? echo $row[content]; ?> 
		<br/>
		<hr />
		<p>
		<?php   if($row[2] == $_SESSION[id]){         ?>
		<a class="button btn btn-danger left" href="forms.php?id=<?php echo $row[0];?>&akcja=usunpost"> <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> </a>   
		<?php 
		}
			$sql = "SELECT * FROM `like` WHERE  post_id = '$row[0]'";	
			$lubie_num = $connect -> query($sql)->num_rows;
			$sql = "SELECT * FROM `like` WHERE user_id = '$_SESSION[id]' and post_id = '$row[0]'";
			$lubie = $connect->query($sql)->fetch_assoc();
			if(!$lubie){
		?>
		<a class="button btn btn-info right" href="forms.php?id=<?php echo $row[0];?>&akcja=lubiepost"> <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>(<?php echo $lubie_num; ?>)</a>
		<?php }
			else if($lubie){
		 ?> 
		 <a class="button btn btn-danger right" href="forms.php?id=<?php echo $row[0];?>&akcja=nlubiepost&idd=<?php echo $lubie[id];?>"> <span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span> (<?php echo $lubie_num; ?>)</a>
		<?php } 
        
        $sql = "SELECT * FROM `comment` WHERE post_id = '$row[0]'";
        $comment_num = $connect -> query($sql)->num_rows;

		?>
		<a class=" btn btn-success right komentarze"  > Komentarze! (<?php echo $comment_num; ?>) </a> 


		</p>
        <br/>
        <hr />
		<div class="komentarz"> 
<div class="forma">
 <form method="post" action="forms.php?id=<?php echo $row[0];?>&akcja=postkoment">
 <div class="form-group">
 <textarea name="content" class="form-control" placeholder="Treść"></textarea>
 <button type="submit" class="btn btn-default">Dodaj komentarz</button>
 </div>
 </form>
 <br/>
</div>
         <div class="comments">
<?php 
     
	
		$sql = "SELECT * FROM comment WHERE post_id = '$row[0]' ";
		$comments = $connect ->query($sql);
    	while($comment = $comments->fetch_assoc()){
		$sql = "SELECT * FROM uzytkownicy WHERE id='$comment[user_id]'";
		$user = $connect->query($sql)->fetch_assoc();
?>
		<div class="comment">
		<p> <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span><? echo substr($comment[datetime], 0, -3);?> </p>
		<hr />
		<a href="friend.php?id=<? echo $user[id]; ?>">
		<img src="<? echo $user[avatar]; ?>" alt=" Obrazek " width=30px height=30px /> <strong><?php echo $user[nick];?> </strong>
		</a>
		<br/>
		<? echo $comment[content]; ?> 
		<br/>
		<hr />
		<p>
		<?php   if($comment[user_id] == $_SESSION[id] or $row[2] == $_SESSION[id]){         ?>
		<a class="button btn btn-danger left" href="forms.php?id=<?php echo $row[0];?>&akcja=usunkomentb&idd=<?php echo $comment[id];?>"> <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> </a>   
		<?php 
		}
			$sql = "SELECT * FROM `like` WHERE  comment_id = '$comment[id]'";	
			$lubie_num = $connect -> query($sql)->num_rows;
			$sql = "SELECT * FROM `like` WHERE user_id = '$_SESSION[id]' and comment_id = '$comment[id]'";
			$lubie = $connect->query($sql)->fetch_assoc();
			if(!$lubie){
		?>
		<a class="button btn btn-info right" href="forms.php?id=<?php echo $row[0];?>&akcja=lubiekomentb&idd=<?php echo $comment[id];?>"> <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> (<?php echo $lubie_num; ?>)</a>
		<?php }
			else if($lubie){
		 ?> 
		 <a class="button btn btn-danger right" href="forms.php?id=<?php echo $row[0];?>&akcja=nlubiekomentb&idd=<?php echo $lubie[id];?>"> <span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span> (<?php echo $lubie_num; ?>)</a>
		<?php } ?>
		</p>  
		</div>

<?php
		}
?>
</div>
        
        </div>
        </div>
        <br/>
        <hr/>
        <hr/>
        <br/>
      
<?php 
}}
?>

	


<? require 'footer.php';?>

		