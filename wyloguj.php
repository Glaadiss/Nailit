<? require 'config.php';
  if ((empty($_SESSION['id'])))
    {
    	header('Location: index.php');   
    	exit();
    }
session_destroy();
header('Location: index.php');
?>