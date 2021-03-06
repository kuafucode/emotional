<header>
    <a href="<?php echo url('./');?>">
        <h1>Kuafu</h1>
        <h3>Real Time Chat</h3>
    </a>
</header>

<?php if (Session::has('success')): ?>
    <p class="registration-success">
        Registeration is successful. <a href="login">You can sign in now!</a>
    </p>
<?php else: ?>

    <?php
    if ($errors) {
        echo $errors->first('register');
    }
    ?>

    <h4>Register</h4>
    <form action="<?php echo url('user/register'); ?>" method="post" class="signup">
        <div>
            <label for="fname">First Name</label>
            <input type="text" placeholder="First Name" id="firstname" name="first_name" class="user"/>
        </div>
        <div>
            <label for="lname">Last Name</label>
            <input type="text" placeholder="Last Name" id="lastname" name="last_name" class="user"/>
        </div>

        <div>
            <label for="email">Email</label>
            <input type="email" placeholder="super@cool.com" id="email" name="email" class="email"/>
        </div>

        <!--<div>
            <label for="confirmEmail">Confirm Email</label>
            <input type="email" id="confirmEmail" name="confirmEmail" class="confirm-email"/>
        </div>-->

        <div>
            <label for="password">Password</label>
            <input type="password" placeholder="Password" id="password" name="password" class="pwd"/>
        </div>

        <!--<div>
            <label for="confirmPassword">Confirm Password</label>
            <input type="password" id="confirmPassword" name="confirmPassword" class="confirm-pwd"/>
        </div>-->

        <div class="btn">
            <input type="submit" value="Let's Go!" />
        </div>

    </form>

    <div class="registration sign-in">
        Already have an account? <a href="<?php echo url('user/login'); ?>" class="sign-in">Sign in</a>
    </div>
<?php endif;?>
