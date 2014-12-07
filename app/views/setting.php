<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kuafu Chat: Setting</title>

    <link href='http://fonts.googleapis.com/css?family=Carrois+Gothic' rel='stylesheet' type='text/css'/>
    <?php echo HTML::style('css/style.css'); ?>
    <?php $user = Sentry::getUser(); ?>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <!-- <link rel="stylesheet" href="/resources/demos/style.css"> -->
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <script language="JavaScript">

        $(document).ready(function () {
            $("#languageselector").val('<?php echo $user->languages;?>')
        });
    </script>
</head>
<body id="profile">
<header>
    <a href="<?php echo url('../'); ?>">
        <h1>Kuafu</h1>

        <h3>Real Time Chat</h3>
    </a>
</header>
<nav>
    <a href="#">janeDoe63</a>
    <a href="<?php echo url('/'); ?>">home</a>
    <a href="<?php echo url('user/profile'); ?>" class="active">profile</a>
    <a href="<?php echo url('chat'); ?>">chat</a>
    <a href="<?php echo url('user/setting'); ?>">setting</a>
</nav>
<div id="container">
    <form action="setting" method="post">
        

        <div class="btn">
            <input type="submit" value="Save"/>
        </div>
    </form>
</div>
</body>
</html>
