<?php
require_once 'UserApp.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Login</title>
    </head>
    <body>
        <?php
        include 'menu.php';

        if (!$userService->logged_in) { ?>
        
            <h3>User Login</h3>
            <br />
            <?php
            if ($validator->num_errors > 0) { ?>
                <span style="color:#ff0000"> <?php echo $validator->num_errors; ?> error(s) found</span>
            <?php
            }
            ?>
            
            <form action="login.php" method="POST">
                Email: <br />
                <input type="text" name="useremail" value="<?php echo $validator->getValue("useremail") ?>"> 
                <span style="color:#ff0000"><?php echo $validator->getError("useremail"); ?></span>
                <br />
                
                Password:<br />
                <input type="password" name="password" value=""> 
                <span style="color:#ff0000"><?php echo $validator->getError("password"); ?></span>
                <br />

                <input type="checkbox" name="rememberme" <?php echo ($validator->getValue("rememberme") != "")?"checked":"" ?> >
                <font size="2">Remember me next time </font>
                <br />

                <input type="hidden" name="login" value="1">
                <input type="submit" value="Login">
            </form>
            <br />
        <?php
        }
        ?>
    </body>
</html>
