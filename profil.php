<?php require 'config.php'; 
  if ((empty($_SESSION['id'])))
    {
    	header('Location: index.php');   
    	exit();
    }
require 'header.php'; 
?>
<div class="container bg">

<?php
$szukaj = $_POST['szukaj'];
$search = $_POST['search'];
?> 

<h2> Witaj <? echo $_SESSION[nick]; ?>. Chcesz coś zmienić ? </h2>
<?php 
$row = $connect->query("SELECT * FROM uzytkownicy WHERE id = '$_SESSION[id]'")-> fetch_assoc(); 
?>
 <a href="<? echo $row[avatar]; ?>"><img src=" <? echo $row[avatar]; ?>" alt=" Obrazek " width=150px height=150px /></a>

<div id="ustawienia"> <h2> Ustawienia </h2></div>
<?php 
$komunikat = $_SESSION[komunikaty];
if($komunikat)
{
echo $_SESSION[komunikaty]; 
}
unset($_SESSION[komunikaty]);
?>
<div id="zmustawienia">

<div id="haslo"> <h3>Zmiana hasła </h3></div>
<div id="zmhaslo">
					<form class="form-horizontal" method="POST" action="forms.php?akcja=haslo" >

					<div class="form-group">
					<label for="inputPassword3" class="col-sm-3 control-label">Hasło</label>
					<div class="col-sm-6">
					<input type="password" class="form-control" id="inputPassword3" placeholder="Hasło"
					name="haslo" maxlength="32">
					</div>
					</div>

					<div class="form-group">
					<label for="inputPassword3" class="col-sm-3 control-label">Powtórz Hasło</label>
					<div class="col-sm-6">
					<input type="password" class="form-control" id="inputPassword3" placeholder="Hasło"
					name="vhaslo" maxlength="32">
					</div>
					</div>
					<div class="form-group">
					<label class="col-sm-3 control-label"> <button type="submit" class="btn btn-default"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Zmień!</button></label>

					</div>
					</form>
</div>


<div id="profilowe"><h3> Zmień avatar </h3></div>
<div id="zmprofilowe">
					<form class="form-horizontal" method="POST" action="forms.php?akcja=avatar" enctype="multipart/form-data">
					<div class="form-group">
					<label class="col-sm-3 control-label">Avatar</label>
					<div class="col-sm-6">
					<input type="file" class="form-control" name="plik" maxlength="50">
					</div>
					</div>
					<div class="form-group">
					<label class="col-sm-3 control-label"> <button type="submit" class="btn btn-default"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Zmień!</button></label>
					</div>
					</form>
</div>

<div id="email"><h3> Zmień email </h3></div>
<div id="zmemail">	

					<form class="form-horizontal" method="POST" action="forms.php?akcja=email">
					<div class="form-group">
					<label for="inputEmail3" class="col-sm-3 control-label">Email</label>
					<div class="col-sm-6">
					<input type="text" class="form-control" id="inputEmail3" placeholder="email"
					name="email" maxlength="50">
					</div>
					</div>

					<div class="form-group">
					<label for="inputEmail3" class="col-sm-3 control-label">Powtórz email</label>
					<div class="col-sm-6">
					<input type="text" class="form-control" id="inputEmail3" placeholder="email"
					name="vemail" maxlength="50">
					</div>
					</div>		

					<div class="form-group">
					<label class="col-sm-3 control-label"> <button type="submit" class="btn btn-default"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Zmień!</button></label>
					</div>
					</form>
</div>

<div id="nick"><h3> Zmień nick </h3></div>
<div id="zmnick">

					<form class="form-horizontal" method="POST" action="forms.php?akcja=nick" >
					<div class="form-group">
					<label for="inputEmail3" class="col-sm-3 control-label">Login</label>
					<div class="col-sm-6">
					<input type="text" class="form-control" id="inputEmail3" placeholder="Login"
					name="nick" maxlength="18">
					</div>
					</div>		
					<div class="form-group">
					<label class="col-sm-3 control-label"> <button type="submit" class="btn btn-default"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Zmień!</button></label>
					</div>
					</form>
</div>
</div>

<?php require 'footer.php' ?>