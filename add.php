<?php require"config.php";
  if ((empty($_SESSION['id'])))
    {
      header('Location: index.php');   
      exit();
    }
require 'header.php'; 
?>
<div class="container bg">
<?php
if($_POST){
echo $_POST['plik']. '  -  '. $_FILES['plik']['tmp_name']. ' - ';
$max_rozmiar = 4024*4024;
if (is_uploaded_file($_FILES['plik']['tmp_name'])) {
        $name = $_POST['nazwa'];    
        $file = $_FILES['plik']['name'];
        $file_type = $_FILES['plik']['type'];
        $file_size = $_FILES['plik']['size'];
    if ($file_size > $max_rozmiar) {
        echo 'Błąd! Plik jest za duży!';
    }
    else if($file_type == 'image/jpeg' or $file_type == 'image/png' or $file_type == 'image/bmp' or $file_type == 'image/jpg') {
        echo 'Odebrano plik. Początkowa nazwa:'.$file;
        echo '<br/>';
        if (isset($file_type)) {
            echo 'Typ: '.$file_type;
        }
        $file = 'foto/'.$_SESSION[id].'/'.$file;
        $path = getcwd().'/foto/'.$_SESSION[id];
        if ( ! is_dir($path)) {
            mkdir($path);
        }
     
         move_uploaded_file($_FILES['plik']['tmp_name'], getcwd().'/foto/'.$_SESSION[id].'/'.$_FILES['plik']['name']);
         $sql="INSERT INTO foto(file,type,size, user_id, name, datetime) VALUES('$file','$file_type','$file_size', '$_SESSION[id]', '$name', '$date')";
         $connect ->query($sql); 
    }
    else{
    echo ' Niedozwolony typ plik�w ';        

    }
  
} 

else {
   echo 'Błąd przy przesyłaniu danych!';
}





}
?>






<div class="container bg">
<form class="form-horizontal" method="POST" action="?" enctype="multipart/form-data">
</br>
</br>
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-3 control-label">Opis</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" name="nazwa" maxlength="30">
    </div>
  </div>

  <div class="form-group">
    <label for="inputPassword3" class="col-sm-3 control-label">Plik </label>
    <div class="col-sm-6">
      <input type="file" class="form-control" name="plik" maxlength="32">
    </div>
  </div>
   <div class="form-group">
      <button type="submit" class="btn btn-default"> Dodaj Fotografię! </button>
  </div>
</form>

</div>
<?php require 'footer.php';  ?>








	