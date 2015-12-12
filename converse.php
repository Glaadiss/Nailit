<?php require 'config.php';
    if ((empty($_SESSION['id'])))
    {
    	header('Location: index.php');   
    	exit();
    }
    $true = '1';
   
    require 'header.php';

    $user_id = $_GET['id'];
    $customer_id = $_GET['idd'];
    $connect->query("UPDATE message SET reaad='$true' WHERE customer_id = $_SESSION[id] ");
    $converse = $connect->query("SELECT * FROM message WHERE (user_id = '$user_id' or user_id = '$customer_id') 
    AND (customer_id = '$user_id' or customer_id = '$customer_id') GROUP BY id ORDER BY `date` DESC");
    ?>
    	<div class="board">
		<form action="forms.php?akcja=message&id=<?php echo $user_id ?>&idd=<?php echo $customer_id ?>" method="post">
		<div class="form-group" style="width:350px;">
		<textarea name="content" class="form-control" rows="3" id="comment" placeholder="Treść wiadomości "></textarea>
		<script>
		// CKEDITOR.replace( 'content' );
		</script>
		</div>
		<div class="form-group">
		<button type="submit" class="btn btn-default"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Wyślij!</button> 
		</div>
		</form>


	<div id="messages">
    <?php
    while($row = $converse->fetch_assoc())
    {
    	$writer = $connect->query("SELECT * FROM uzytkownicy WHERE id = '$row[user_id]' LIMIT 1")->fetch_assoc();
				if ($writer[id] == $user_id) echo '<div class="message" style="background: linear-gradient(#303030, blue);">'; 
			  	else 	echo '<div class="message" style="background: linear-gradient(#303030, green);">';
		?>
		<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>  <? echo substr($row[date], 0, -3);?>  <br />
		<img src="<? echo $writer[avatar]; ?>" alt=" Obrazek " width=30px height=30px /> <strong><?php echo $writer[nick];?> </strong>
		<br/>
		<?php echo $row[content]; ?>
		</div>
	
		<?php
		}
		?>

		</div>
	</div>
<?php require 'footer.php'; ?>