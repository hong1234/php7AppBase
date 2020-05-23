<?php
require_once 'UserApp.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>User List</title>
    </head>
    <body>
        <?php
        include 'menu.php'; // HEADER
        ?>
            <h3>User List</h3>
            <br/>
            <div>
            <?php 
               foreach ($userDao->getUsers() as $user) {
                        echo $user['id'];?><br/>
                    <?php echo $user['username'];?><br/>
                    <?php echo $user['useremail'];?><br/>
            <?php
               }
            ?>
            </div> 
    </body>
</html>

