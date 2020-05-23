<?php
if (isset($validator->statusMsg)) { ?>
    <span style="color:#207b00"> <?php echo $validator->statusMsg; ?></span>
<?php
}
?>
<h2>Welcome !</h2>
<a href='index.php'>Home</a>
| <a href='register.php'>Add User</a> 

<?php
if (!$userService->logged_in) { ?>
    | <a href='login.php'>Login</a>
<?php
}
?>

<?php
if ($userService->logged_in) { ?>
    | <a href='showusers.php'>Show Users</a>
    | <a href='usersearch.php'>Search Users</a>  
    | <a href='UserApp.php?logout=1'>Logout</a>
<?php
}
?>