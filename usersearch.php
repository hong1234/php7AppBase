<?php
require_once 'UserApp.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>User Search</title>
    </head>
    <body>
        <?php
        include 'menu.php';
        ?>
            <h3>User Search</h3> 
            <?php
            if ($validator->num_errors > 0) { ?>
                <span style="color:#ff0000"> <?php echo $validator->num_errors; ?> error(s) found</span>
            <?php
            }
            ?>     
            <form action="usersearch.php" method="POST">
                SearchKey/UserEmail: <br />
                <input type="text" name="useremail" value="<?php echo $validator->getValue("useremail") ?>"> 
                <span style="color:#ff0000"><?php echo $validator->getError("useremail"); ?></span>
                <br />
                <input type="hidden" name="usersearch" value="1">
                <input type="submit" value="Search">
            </form>
            <br />

            <?php
            if (count($userApp->searchResult) > 0) { ?>
            <h3>User List</h3>
            <?php 
               foreach ($userApp->searchResult as $user) {
                    echo $user['id'];?><br/>
                    <?php echo $user['username'];?><br/>
                    <?php echo $user['useremail'];?><br/>
            <?php
               }
            }
            ?>      
    </body>
</html>