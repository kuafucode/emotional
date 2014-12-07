<header>
    <h1>Kuafu</h1>

    <h3>Real Time Chat</h3>
</header>

<?php if (Session::has('success')): ?>
    <p>
        <b>Registeration is successful. Click on to the activation link that sent to your email.</b>
    </p>
<?php else: ?>
    <h4>Register</h4>
    <form action="<?php echo url('user/register'); ?>" method="post">
        <div>
            <label for="user">First Name</label>
            <input type="text" placeholder="First Name" id="firstname" name="first_name" class="user"/>
        </div>
        <div>
            <label for="user">Last Namner</label>
            <input type="text" placeholder="Last Name" id="lastname" name="last_name" class="user"/>
        </div>

        <div>
            <label for="email">Email</label>
            <input type="email" placeholder="super@cool.com" id="email" name="email" class="email"/>
        </div>

        <div>
            <label for="confirmEmail">Confirm Email</label>
            <input type="email" id="confirmEmail" name="confirmEmail" class="confirm-email"/>
        </div>

        <div>
            <label for="password">Password</label>
            <input type="password" placeholder="Password" id="password" name="password" class="pwd"/>
        </div>

        <div>
            <label for="confirmPassword">Confirm Password</label>
            <input type="password" id="confirmPassword" name="confirmPassword" class="confirm-pwd"/>
        </div>

        <div>
            <button type="submit" class="btn">Let's Go!</button>
        </div>

    </form>

    <div class="sign-in">
        Already have an account? <a href="<?php echo url('user/login'); ?>" class="sign-in">Sign in</a>
    </div>
<?php endif;?>
