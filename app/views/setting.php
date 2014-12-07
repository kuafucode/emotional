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
        <select id="languageselector" name="languageselector">
            <option>Select a Language</option>
            <option value='af'>Afrikaans</option>
            <option value='sq'>Albanian</option>
            <option value='ar'>Arabic</option>
            <option value='hy'>Armenian</option>
            <option value='az'>Azerbaijani</option>
            <option value='eu'>Basque</option>
            <option value='be'>Belarusian</option>
            <option value='bg'>Bulgarian</option>
            <option value='ca'>Catalan</option>
            <option value='zh-CN'>Chinese (Simplified)</option>
            <option value='zh-TW'>Chinese (Traditional)</option>
            <option value='hr'>Croatian</option>
            <option value='cs'>Czech</option>
            <option value='da'>Danish</option>
            <option value='nl'>Dutch</option>
            <option value='et'>Estonian</option>
            <option value='tl'>Filipino</option>
            <option value='fi'>Finnish</option>
            <option value='fr'>French</option>
            <option value='gl'>Galician</option>
            <option value='ka'>Georgian</option>
            <option value='de'>German</option>
            <option value='el'>Greek</option>
            <option value='ht'>Haitian Creole</option>
            <option value='iw'>Hebrew</option>
            <option value='hi'>Hindi</option>
            <option value='hu'>Hungarian</option>
            <option value='is'>Icelandic</option>
            <option value='id'>Indonesian</option>
            <option value='ga'>Irish</option>
            <option value='it'>Italian</option>
            <option value='ja'>Japanese</option>
            <option value='ko'>Korean</option>
            <option value='la'>Latin</option>
            <option value='lv'>Latvian</option>
            <option value='lt'>Lithuanian</option>
            <option value='mk'>Macedonian</option>
            <option value='ms'>Malay</option>
            <option value='mt'>Maltese</option>
            <option value='no'>Norwegian</option>
            <option value='fa'>Persian</option>
            <option value='pl'>Polish</option>
            <option value='pt'>Portuguese</option>
            <option value='ro'>Romanian</option>
            <option value='ru'>Russian</option>
            <option value='sr'>Serbian</option>
            <option value='sk'>Slovak</option>
            <option value='sl'>Slovenian</option>
            <option value='es'>Spanish</option>
            <option value='sw'>Swahili</option>
            <option value='sv'>Swedish</option>
            <option value='th'>Thai</option>
            <option value='tr'>Turkish</option>
            <option value='uk'>Ukrainian</option>
            <option value='ur'>Urdu</option>
            <option value='vi'>Vietnamese</option>
            <option value='cy'>Welsh</option>
            <option value='yi'>Yiddish</option>
        </select>

        <div class="btn">
            <input type="submit" value="Save"/>
        </div>
    </form>
</div>
</body>
</html>
