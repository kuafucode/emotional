<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kuafu Chat: Profile</title>

    <link href='http://fonts.googleapis.com/css?family=Carrois+Gothic' rel='stylesheet' type='text/css' />
    <?php echo HTML::style('css/style.css');?>
    <?php
        $user = Sentry::getUser();
        $user = User::find($user->id);
    ?>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <!-- <link rel="stylesheet" href="/resources/demos/style.css"> -->
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <script language="JavaScript" src="//ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js"></script>
    <script language="JavaScript" src="../scriptcam/scriptcam.js"></script>
    <script language="JavaScript">
        $(function() {

            $( "#dialog" ).dialog();
            $( "#dialog" ).dialog('close');
        });

        $(document).ready(function() {
            $("#webcam").scriptcam({
                showMicrophoneErrors:false,
                onError:onError,
                cornerRadius:20,
                disableHardwareAcceleration:1,
                cornerColor:'e3e5e2',
                onWebcamReady:onWebcamReady,
                uploadImage:'../upload.gif',
                onPictureAsBase64:base64_tofield_and_image
            });

            $("#languageselector").val('<?php echo $user->languages;?>');
            $("#languagelabel").text($("#languageselector option[value='<?php echo $user->languages;?>']").text());

            $.get("face",{},
                function(data,status){
                    var obj = jQuery.parseJSON( data);
                    if (obj.positive_face != "")
                        $('#happy-image').css("background", 'url(' + "data:image/png;base64,"+obj.positive_face + ')');
                    if (obj.negative_face != "")
                        $('#sad-image').css("background", 'url(' + "data:image/png;base64,"+obj.negative_face + ')');
                    if (obj.neutral_face != "")
                        $('#neutral-image').css("background", 'url(' + "data:image/png;base64,"+obj.neutral_face + ')');
                });

        });
        function base64_toimage() {
            if(global_emotion == "happy")
                $('#happy-image').css("background", 'url(' + "data:image/png;base64,"+$.scriptcam.getFrameAsBase64() + ')');
            else if(global_emotion == "sad")
                $('#sad-image').css("background", 'url(' + "data:image/png;base64,"+$.scriptcam.getFrameAsBase64() + ')');
            else if(global_emotion == "neutral")
                $('#neutral-image').css("background", 'url(' + "data:image/png;base64,"+$.scriptcam.getFrameAsBase64() + ')');

            $.post("image",
                {
                    emotion: global_emotion,
                    data: $.scriptcam.getFrameAsBase64()
                },
                function(data,status){
                    alert("Data: " + data);
                });

            $("#dialog" ).dialog("close");
        };

        function success() {

        }

        function base64_tofield_and_image(b64) {
            $('#formfield').val(b64);
            $('#image').attr("src","data:image/png;base64,"+b64);
        };
        function changeCamera() {
            $.scriptcam.changeCamera($('#cameraNames').val());
        }
        function onError(errorId,errorMsg) {
            $( "#btn2" ).attr( "disabled", true );
            alert(errorMsg);
        }
        function onWebcamReady(cameraNames,camera,microphoneNames,microphone,volume) {
            $.each(cameraNames, function(index, text) {
                $('#cameraNames').append( $('<option></option>').val(index).html(text) )
            });
            $('#cameraNames').val(camera);
        }

        var global_emotion = "";

        function capture(emotion) {
            global_emotion = emotion;
            $('#dialog' ).dialog({width:650});
        }

        function edit() {
            $("#profile-info").css("display","none");
            $("#profile-edit").css("display","block");
        }

    </script>
</head>
<body id="profile">
<header>
    <a href="<?php echo url('../');?>">
        <h1>Kuafu</h1>
        <h3>Real Time Chat</h3>
    </a>
</header>
<nav>
    <div class="username"><span>You are logged in as:</span><br />user name</div>
    <a href="<?php echo url('/');?>">home</a>
    <a href="<?php echo url('user/profile');?>" class="active">profile</a>
    <a href="<?php echo url('chat');?>">chat</a>
    <div class="logout">
        <form action="http://localhost/emotional/public/user/logout" method="post">
            <input type="submit" value="Log Out">
        </form>
    </div>
</nav>
<div id="container">
    <div class="profile">
        <h2>Account Information</h2>
        <div class="usr-profile-info">
            <ul>
                <li>Full Name: <?php echo $user->first_name . ' ' . $user->last_name; ?></li>
                <li>User Name: <?php echo $user->username; ?></li>
                <li>Email: <?php echo $user->email; ?></li>
                <li>Password: *****</li>
                <li>Language: <select id="languageselector" name="languageselector">
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
                    </select></li>

    <header>
        <a href="<?php echo url('../');?>">
            <h1>Kuafu</h1>
            <h3>Real Time Chat</h3>
        </a>
    </header>
    <nav>
        <div class="username"><span>You are logged in as:</span><br /><?php echo $user->first_name . ' ' . $user->last_name; ?></div>
        <a href="<?php echo url('/');?>">home</a>
        <a href="<?php echo url('user/profile');?>" class="active">profile</a>
        <a href="<?php echo url('chat');?>">chat</a>
    </nav>
    <div id="container">
        <div class="profile">
            <h2>Account Information</h2>
            <div class="usr-profile-info" id="profile-info" style="display: block;">
                <ul>
                    <li>Full Name: <?php echo $user->first_name . ' ' . $user->last_name; ?></li>
                    <li>User Name: <?php echo $user->username; ?></li>
                    <li>Email: <?php echo $user->email; ?></li>
                    <li>Password: *****</li>
                    <li>Language: <label id="languagelabel"/></li>

                </ul>
                <div class="error">
                    <?php
                        if ($errors->has('loginRequired')) {
                            echo "email info is required<br/><br/>";
                        }
                    ?>
                </div>
                <div class="btn">
                    <input type="button" onclick="edit();" value="Edit"/>
                </div>
            </div>

            <div class="usr-profile-info" id="profile-edit" style="display: none;">
                <form action="profile" method="post">
                    <ul>
                        <li>Full Name: <input type="text" name="fullname" value="<?php echo $user->first_name . ' ' . $user->last_name; ?>"/></li>
                        <li>User Name: <input type="text" name="username" value="<?php echo $user->username; ?>"/></li>
                        <li>Email: <input type="text" name="email" value="<?php echo $user->email; ?>"/></li>
                        <li>Password: <input type="text" name="password" value=""/></li>
                        <!--<li>Confirm Password: <input type="text" name="confirmpassword" value=""/></li>-->
                        <li>Language: <select id="languageselector" name="languageselector">
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
                                <option value='en'>English</option>
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
                            </select></li>

                    </ul>
                    <div class="btn">
                        <input type="submit" onclick="save();" value="Save"/>
                    </div>
                </form>
            </div>
        </div>

        
        <p class="notice">Before proceeding to the chatroom, please take three
        photographs using the table presented below.  Start by hovering over the default blue images;
        a camera icon will appear on hover and you can proceed to taking your photograph. It will make
        your chatting experience more interesting.
        </p>


        <table>
            <tr>
                <th colspan="3" align="center">Expressions</th>
            </tr>
            <tr>
                <td valign="bottom">Happy</td>
                <td valign="bottom">Sad/Angry</td>
                <td valign="bottom">Neutral</td>
            </tr>
            <tr>
                <td class="happy-capture">
                    <div class="user-photo default" onclick="capture('happy')" id="happy-image">
                        <div class="take-photo" >
                            <img title='camera' alt='camera' src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAmCAYAAACGeMg8AAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAI7SURBVHja3JjPSwJBFMenPRidDE+BUJdA6BCB4KkwAsHuQdDZP8I/QPBvCDpHUtClSJBiQ+hU0EnqEhgrSWAYRGEE23fiDQwddNt5Nrs++LiD7Hs7350f+94I3/cFAymwBx784PYMTkCGow9T8sfQMuAcpEP6f4BNcGnSCYdBhGsgQtoMOAN5W0KUiDlhbsZinAiIYBHjRESEsRglRM7xA+ABfwR3YxKhi3ED9MOjPv+sT7lryTd8BVIinvYC1qSQQzS2RLztWArpo5GMuZA3KcQfw1DXQB10wC39v0LzuQi22aeyz2fvoAqSAVKKJN37zvVwLiFPIKd1tAB2wTX4onuu6b+Cdl+OfCMhxAPzFGsRuAF8XLpXkK9nW8hAG4lV0PuDb4981MgMbAqpaiPRC+Hf00amaktIn+oQEXA6DZtmqqbphw1ikv2e0la7YZiC5ymGjLVvI42v0ZUjK1Ax6jaE3NO1wCBExbgJG8Dkyz4LXsEAJAyFfIJpijOwUeqqmpvLEjamlqpJOgwCHrW6yErNLkxPP8gav2L+qxC10xwxCFExijYWu1zoC3R1Db4lckTXqSZqh62NTEZEPrBM7RIJCvMyStQuGxV4DElj1iBpzJNv1rQ24Urj01ry2Azg09SSxXQU0nhl7SGFlT+isGpHqUJUpW7lD6VuhbPUHdfhw/6Iw4cd7sOHcQixYo6YEHNC7v+RO6CTQi4mQEhDrpElNJpxP8SWI9ICy5S4dWMkoEt9ln1vfQswANImngTqX0e+AAAAAElFTkSuQmCC'>
                        </div>
                    </div>
                </td>
                <td class="sad-capture">
                    <div class="user-photo default" onclick="capture('sad')" id="sad-image">
                        <div class="take-photo" >
                            <img width='50' height='38' title='camera' alt='camera' src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAmCAYAAACGeMg8AAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAI7SURBVHja3JjPSwJBFMenPRidDE+BUJdA6BCB4KkwAsHuQdDZP8I/QPBvCDpHUtClSJBiQ+hU0EnqEhgrSWAYRGEE23fiDQwddNt5Nrs++LiD7Hs7350f+94I3/cFAymwBx784PYMTkCGow9T8sfQMuAcpEP6f4BNcGnSCYdBhGsgQtoMOAN5W0KUiDlhbsZinAiIYBHjRESEsRglRM7xA+ABfwR3YxKhi3ED9MOjPv+sT7lryTd8BVIinvYC1qSQQzS2RLztWArpo5GMuZA3KcQfw1DXQB10wC39v0LzuQi22aeyz2fvoAqSAVKKJN37zvVwLiFPIKd1tAB2wTX4onuu6b+Cdl+OfCMhxAPzFGsRuAF8XLpXkK9nW8hAG4lV0PuDb4981MgMbAqpaiPRC+Hf00amaktIn+oQEXA6DZtmqqbphw1ikv2e0la7YZiC5ymGjLVvI42v0ZUjK1Ax6jaE3NO1wCBExbgJG8Dkyz4LXsEAJAyFfIJpijOwUeqqmpvLEjamlqpJOgwCHrW6yErNLkxPP8gav2L+qxC10xwxCFExijYWu1zoC3R1Db4lckTXqSZqh62NTEZEPrBM7RIJCvMyStQuGxV4DElj1iBpzJNv1rQ24Urj01ry2Azg09SSxXQU0nhl7SGFlT+isGpHqUJUpW7lD6VuhbPUHdfhw/6Iw4cd7sOHcQixYo6YEHNC7v+RO6CTQi4mQEhDrpElNJpxP8SWI9ICy5S4dWMkoEt9ln1vfQswANImngTqX0e+AAAAAElFTkSuQmCC'>
                        </div>
                    </div>
                </td>
                <td class="neutral-capture">
                    <div class="user-photo default" onclick="capture('neutral')" id="neutral-image">
                        <div class="take-photo" >
                            <img width='50' height='38' title='camera' alt='camera' src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAmCAYAAACGeMg8AAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAI7SURBVHja3JjPSwJBFMenPRidDE+BUJdA6BCB4KkwAsHuQdDZP8I/QPBvCDpHUtClSJBiQ+hU0EnqEhgrSWAYRGEE23fiDQwddNt5Nrs++LiD7Hs7350f+94I3/cFAymwBx784PYMTkCGow9T8sfQMuAcpEP6f4BNcGnSCYdBhGsgQtoMOAN5W0KUiDlhbsZinAiIYBHjRESEsRglRM7xA+ABfwR3YxKhi3ED9MOjPv+sT7lryTd8BVIinvYC1qSQQzS2RLztWArpo5GMuZA3KcQfw1DXQB10wC39v0LzuQi22aeyz2fvoAqSAVKKJN37zvVwLiFPIKd1tAB2wTX4onuu6b+Cdl+OfCMhxAPzFGsRuAF8XLpXkK9nW8hAG4lV0PuDb4981MgMbAqpaiPRC+Hf00amaktIn+oQEXA6DZtmqqbphw1ikv2e0la7YZiC5ymGjLVvI42v0ZUjK1Ax6jaE3NO1wCBExbgJG8Dkyz4LXsEAJAyFfIJpijOwUeqqmpvLEjamlqpJOgwCHrW6yErNLkxPP8gav2L+qxC10xwxCFExijYWu1zoC3R1Db4lckTXqSZqh62NTEZEPrBM7RIJCvMyStQuGxV4DElj1iBpzJNv1rQ24Urj01ry2Azg09SSxXQU0nhl7SGFlT+isGpHqUJUpW7lD6VuhbPUHdfhw/6Iw4cd7sOHcQixYo6YEHNC7v+RO6CTQi4mQEhDrpElNJpxP8SWI9ICy5S4dWMkoEt9ln1vfQswANImngTqX0e+AAAAAElFTkSuQmCC'>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>Please give a big smile</td>
                <td>Make an angry face</td>
                <td>Well, make a face like "Who cares?!"</td>
            </tr>
            <tr>
                <td>
                    <label for="happy-yellowicon">
                        <img width='128' height='128' title='happy' alt='happy' src='data:image/png;base64,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'>
                    </label>
                </td>
                <td>
                    <label for="sad-yellowicon">
                        <img width='128' height='128' title='angry' alt='angry' src='data:image/png;base64,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'>
                    </label>
                </td>
                <td>
                    <label for="neutral-yellowicon">
                        <img width='128' height='128' title='neutral' alt='neutral' src='data:image/png;base64,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'>
                    </label>
                </td>
            </tr>
        </table>
        
        <div class="go-chat"> All done? Proceed to the <a href="<?php echo url('chat');?>">Chat Room</a></div>

        <div id="dialog" title="Capture Image" style="width:650px;height:500px;" >
            <div style="width:630px;float:left;">
                <div id="webcam"></div>
                <div style="margin:5px;">
                    <?php echo HTML::image('scriptcam/webcamlogo.png', 'cam', array('style' => 'vertical-align:text-top'));?>
                    <select id="cameraNames" size="1" onChange="changeCamera()" style="width:245px;font-size:10px;height:25px;">
                    </select>
                </div>
            </div>
            <div style="width:135px;float:left;">
                <p><button class="btn btn-small" id="btn2" onclick="base64_toimage()">Snapshot to image</button></p>
            </div>
        </div>
    </div>
</body>
</html>
