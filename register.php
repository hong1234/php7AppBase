<?php
require_once 'UserApp.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        include 'menu.php'; // HEADER
        ?>
            <h3>User Registration</h3><br/>
            <?php
            if ($validator->num_errors > 0) { ?>
                <span style="color:#ff0000;"> <?php echo $validator->num_errors;?> error(s) found</span>
            <?php
            }
            ?>
            <form action="register.php" method="POST">
                Name: <br />
                <input type="text" name="username" value="<?php echo $validator->getValue("username");?>"> 
                <span style="color:#ff0000"><?php echo $validator->getError("username");?></span>
                <br />

                Email: <br />
                <input type="text" name="useremail" value="<?php echo $validator->getValue("useremail");?>"> 
                <span style="color:#ff0000"><?php echo $validator->getError("useremail");?></span>
                <br />

                Password:<br />
                <input type="text" name="password" value=""> 
                <span style="color:#ff0000"><?php echo $validator->getError("password");?></span>
                <br /><br />

                <input type="hidden" name="register" value="1">
                <input type="submit" value="Register">
            </form>    
    </body>
</html>
