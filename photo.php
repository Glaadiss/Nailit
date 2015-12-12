<?php require 'config.php';
    if ((empty($_SESSION['id'])))
    {
    	header('Location: index.php');   
    	exit();
    }
    
require 'header.php';
?>
<?php
$sql = "SELECT * FROM foto WHERE user_id = '$_SESSION[id]'";
$result = @$connect->query($sql);
$result2 = @$connect->query($sql);
if($result->num_rows == 0)
{
echo '<div class="container ">
<div id="pole2">
<h2> Nie masz zdjęć ! </h2> </br> 
 <p><a class="btn btn-default btn-lg" href="add.php" role="button"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Dodaj je teraz!</a></p>
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
<?php require 'footer.php'; ?>