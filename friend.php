<? require 'config.php';
  if ((empty($_SESSION['id'])))
    {
    	header('Location: index.php');   
    	exit();
    }
 ?>
<?php
require 'header.php'; 
?>
<div class="container ">
<?
$id = $_GET['id'];
$friend = $connect->query("SELECT * from uzytkownicy WHERE id='$id' LIMIT 1")->fetch_assoc();
$user_id = $_SESSION[id]; 
$friend_id = $friend[id];
$relation = $connect->query("SELECT * from friends WHERE user_id = '$user_id' AND friend_id = '$friend_id' ") -> num_rows;
$relation2 = $connect->query("SELECT * from friends WHERE user_id = '$friend_id' AND friend_id = '$user_id' ") -> num_rows;
echo '<h2> '. $friend[nick].' '.$friend[email].'</h2>';
?>
</br>

<?
if($relation == 0 AND $relation2 == 0  AND $user_id != $friend_id)
{
echo ' 
<form method="POST" action="forms.php?id='.$friend[id].'&akcja=friend">
<button type="submit" class="btn btn-default"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Dodaj znajomego!</button></form>
<br><a href="converse.php?id='.$friend[id].'&idd='.$_SESSION[id].'"><button class="btn btn-default"> <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Wiadomość </button></a>';
}
?>

<?php
$sql = "SELECT * FROM foto WHERE user_id = '$friend[id]'";
$result = @$connect->query($sql);
$result2 = @$connect->query($sql);
if($result->num_rows == 0)
{
echo '<div class="container ">
<div id="pole2">
<h2> Nie ma zdjęć ! </h2> </br> 
 </div></div>';
}
else
{
?>

<div class="container" >
<div id="poleh">
    <div id="contentContainer" class="trans3d"> 
	<section id="carouselContainer" class="trans3d">
<?php    
$count = 0;                 
while($rowww = $result->fetch_assoc() or $count < 3 ){
$count +=1;
?>
<figure id="item<?php echo $count; ?>" class="carouselItem trans3d">
<a href="currentphoto.php?id=<?php echo $rowww[id];  ?>" target = "_blank">
<div class="carouselItemInner trans3d cent" style="background-image: url('<?php echo $rowww[file]; ?>')"></div></a></figure>
<?php } ?>

	</section>
	</div>
	</div>
	</div>

<?php } ?>




<?php require 'footer.php' ?>