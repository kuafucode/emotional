<div class="inner-wrapper">
    <header>
        <h1>Kuafu</h1>
        <h3>Real Time Chat</h3>
    </header>
    <?php if (!Sentry::check()):?>
        <a href="<?php echo url('user/login'); ?>" class="sign-in">Sign in</a>
        <span class="icon-login"><img title='' alt=''
                                      src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADwAAAAkCAYAAADVeVmEAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAJcSURBVHja5JrBR0RBHMdn31JiiVgiStdOEVE2XSMiolP/RJTt0qlbYnmH/o/E5t1SdtWpS9lE1KlTl5aUzfT76TcZ27b73mu++4a+fLy0u9+Zr9l5O/Obl9Naq4QaIZaIRWKayMuVdUV8yPWUOCGe5bUhYpMoEwWVXB89/OOJA8dklYh0ckXyWeMzShxrd2r370qcN80SNQcdq4mX8d0lWg6Dt/snDpwnKtq9KuLNbaw7Dt3uHzvwMFHVOLF3ARja9u8ZmMNea7yupS1ucwvs/2vgPHhkO42E+fpVwf4dA1d0/1WRtovEC9D/R+CSzk4l6UMZ7K9y1sLjjCipbHROLMji5I4YA/mrQP6xmmFYJW1zH16JQ6D/9wjXiDmVrerEPDFO3MuS1bk/B+YGHpQfmiAegdNrgr/Sy8ofLVtzDuIfZDx3O8011iXKnwNPeRTY9OUW5R/ITcIXmb48ofz5pvVGfwx4EvidGJQ7dAvhHyg/BRsADtz0KGjTKiNB/AP53fNFpi9FlH8AvCOm0Y1cJ1H+gVT/fJFZcMyg/P/l0vJRFtZZqy59GQdtZOpmDrP2PQhs+rAB2Cl9+/tSADBbwwHZGo6B/JW98NjJcHS35boJCGv7/yjihRnUs0JwES/sVaaN+hg2Apdpo15lWlOIb/QhbANciG/EKcQbRsAjHUkbqKMW2z/RYVoImlPIw7QwzWFae4H+wkFHLqyC+BBx4Dio7f+n82HDWspz4pp81vgsEneOz4XX4ubIpXjkgZd+K+rrMYdujzwwR9aWj08V9uS3Nq26+cfSpwADAEHufLgmdPYhAAAAAElFTkSuQmCC'></span>

        <p class="register">
            Don't have an account?<br />
            <a href="<?php echo url('user/register'); ?>">Create one</a> to get started
        </p>
    <?php else: ?>
        <div class="about">

					<h4 class="posLeft">Welcome</h4>
					<div class="nav">
						<a href="<?php echo url('user/profile');?>" class="active">profile</a> |
						<a href="<?php echo url('chat');?>">chat</a> |
						<form action="<?php echo url('user/logout'); ?>" method="post">
							<input type="submit" value="logout">
						</form>
					</div>

					<p class="clearBoth">The Kuafu real time chat application provides a creative/interactive
					solution for individuals to reflect their moods in the chat environment,
					instead of setting a profile image should you choose.
					Everyone in your buddy list will see a happy or unhappy face each time you
					send out a message.</p><p>Our application supports automatic translation
					so you can communicate globally, which you can change or update on your
					profile page.</p>

					<div style="display: none">
						The Kuafu real time chat application provides a creative/interactive
						solution individuals to reflect their moods in the chat environment,
						without selecting emoticons.
						instead of setting a profile image should you choose.
						Everyone in your buddy list will see a happy or sad face each time you
						send out a message.  Our application supports automatic translation
						so you can communicate globally, which you can change or update on your
						profile page.
					</div>
					
					
					
        </div>
    <?php endif;?>
</div>
