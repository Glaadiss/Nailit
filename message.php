    <?php require 'config.php';
    if ((empty($_SESSION['id'])))
    {
       header('Location: index.php');   
       exit();
   }

   $true = '1';
   $false = '0';
   $connect->query("UPDATE message SET reaad='$true' WHERE customer_id = $_SESSION[id] or user_id = $_SESSION[id] ");
   require 'header.php';
   $sql = "SELECT * FROM  `message` WHERE customer_id ='$_SESSION[id]'  GROUP BY user_id  ORDER BY  `date` DESC";
   $wiadomosc = $connect->query($sql);
   while($converse=$wiadomosc->fetch_assoc())
   {
    $userr  = $connect->query("SELECT * FROM uzytkownicy WHERE id = '$converse[user_id]'")->fetch_assoc();
    $talk = $connect->query("SELECT * FROM message WHERE (user_id = '$converse[user_id]' or user_id = '$_SESSION[id]') 
        AND (customer_id = '$_SESSION[id]' or customer_id = '$converse[user_id]') ORDER BY `date` DESC LIMIT 1")->fetch_assoc();
        ?>
        <a href="converse.php?id=<? echo $converse[user_id];?>&idd=<? echo $converse[customer_id];?>">
            <div class="message">
                <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>  <? echo substr($converse[date], 0, -3);?>  <br />
                <img src="<? echo $userr[avatar]; ?>" alt=" Obrazek " width=30px height=30px /> <strong><?php echo $userr[nick];?> </strong>
                <br/>
                <?php echo $talk[content]; ?>
            </div>
        </a>
        <?php 
    } 
    ?>
    <?php require 'footer.php'; ?>