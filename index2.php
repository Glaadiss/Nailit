<?php require 'config.php'; 
   if ((empty($_SESSION['id'])))
    {
    	header('Location: index.php');   
    	exit();
    }
require 'header.php';
?>
<div class="container ">

<?php
$search = $_POST['search'];
if($search)
{
$sql = "SELECT * from uzytkownicy WHERE nick like '%".$search."%'";
$result = $connect ->query($sql);
while($row = $result -> fetch_assoc())
{
?>
<h2>
<a href="friend.php?id=<?php echo $row[id];?>" class="btn btn-warning btn-lg" role="button">
<img src=" <?php echo $row[avatar]; ?>" alt=" Obrazek " width=30px height=30px /> 
<?php echo $row[nick]; ?>
</a>
</h2>
<?php
}
}
?>

</div>
<? require 'footer.php' ?>