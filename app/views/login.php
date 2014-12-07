<header>
    <h1>Kuafu</h1>

    <h3>Real Time Chat</h3>
</header>

<h4>Sign in</h4>
<form action="<?php echo url('user/login'); ?>" method="post">
    <div>
        <label for="email">Email</label>
        <input type="text" placeholder="Enter Email" id="email" name="email" class="email"/>
    </div>
    <div>
        <label for="password">Password</label>
        <input type="password" placeholder="password" id="pwd" name="pwd" class="pwd"/>
    </div>
    <div>
        <button type="submit" class="btn">Let's Go!</button>
    </div>

</form>

<?php
if ($errors) {
    echo $errors->first('login');
    if ($errors->has('activation')) {
        echo "User is not activated<br/><br/>";
        echo "Resend activation mail.";
    } else if ($errors->has('usernotfound')) {
        echo "User is not found<br/><br/>";
        ?>
        <p>
            <b>Don't have an account?</b>
            <a href="<?php echo url('user/register'); ?>">Create one to get started</a>
        </p>
    <?php
    }
}
?>
