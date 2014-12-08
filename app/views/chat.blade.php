<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Kuafu Chat: Chat Room</title>
  
  <link href='http://fonts.googleapis.com/css?family=Carrois+Gothic' rel='stylesheet' type='text/css' />
	<?php echo HTML::style('css/style.css');?>
	<?php $user = Sentry::getUser(); ?>
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://cdn.pubnub.com/pubnub.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
        <!-- <link rel="stylesheet" href="/resources/demos/style.css"> -->
        <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>

    <script type="text/javascript">
        var msgCnt = 0;
        var PUBNUB_demo;
        var buddies = [];

        var neutralFace = '{{asset($user->neutral_face)}}';
        var positiveFace = '{{asset($user->positive_face)}}';
        var negativeFace = '{{asset($user->negative_face)}}';

        $( document ).tooltip();

        PUBNUB_demo = PUBNUB.init({
            publish_key: 'pub-c-48ffb314-d672-4aa9-b14a-373932847697',
            subscribe_key: 'sub-c-cc0b928c-7cbf-11e4-8912-02ee2ddab7fe',
            uuid: '{{$user->id}}'
        });

        function sendMessage(message,face) {
            PUBNUB_demo.publish({
                channel: 'demo_tutorial',
                message: {"message":message, "uuid":'{{$user->id}}', "cnt" : msgCnt, "face" : face}
            });
        }

        $(function(){

            PUBNUB_demo.subscribe({
                channel: 'demo_tutorial',
                message: function(m){
                    console.log(m);
                    console.log(buddies);

                    var messageId = 'message' + m.uuid + '-' + m.cnt;

                    var newMessage = "";
                    $( document ).tooltip();

                    if(m.message.languages == '<?php echo $user->languages;?>') {
                        var newMessage = '<div class="msg-wrapper" title="' + m.message.message + '"><div class="chat-board-face ' + messageId + '"><img style="height: 40px;" src="' +
                                            m.face + '"/>:</div><div class="chat-board-name"> '+
                                            buddies[m.uuid].name + ':</div><div class="chat-board-message">' +
                                            m.message.message + '</div></div>';
                        console.log(newMessage);
                        $('.chat-window').append(newMessage); $('.chat-window').scrollTop($('.chat-window:first')[0].scrollHeight);

                    } else {
                        $.get("https://www.googleapis.com/language/translate/v2?key=AIzaSyDU6NLGZPgfZtnOrEYtmSgQsI90UBTexkU&q=" +
                                encodeURIComponent(m.message.message) + "&target=<?php echo $user->languages; ?>",
                                function(data,status){
                                    if(data.data != null) {
                                        if (data.data.translations != null) {
                                            //alert("Data: " + data.data.translations[0].translatedText + "\nStatus: " + status);
                                            var newMessage = '<div class="msg-wrapper" title="' + m.message.message + '">' +
                                                                '<div class="chat-board-face"><img style="height: 40px;" src="' +
                                                                 buddies[m.uuid].face + '"/>:</div><div class="chat-board-name"> '+
                                                                 buddies[m.uuid].name + ':</div><div class="chat-board-message">' +
                                                                 data.data.translations[0].translatedText + '</div></div>';
                                            console.log(newMessage);
                                            $('.chat-window').append(newMessage);
                                            $('.chat-window').scrollTop($('.chat-window:first')[0].scrollHeight);
                                        }
                                    }
                                 });
                    }
                    msgCnt++;
                },
                presence: function(m) {
                    console.log(m);
                },

                state: {
                    name: '{{$user->fullname}}',
                    face: '{{$user->neutral_face}}',
                    timestamp: new Date()
                }
            });

            PUBNUB_demo.here_now({
                channel: 'demo_tutorial',
                state: true,
                callback: function(msg) {
                    if(msg.uuids) {
                        $.each( msg.uuids, function( key, buddy ) {
                            if(!buddies[buddy.uuid]) {
                                buddies[buddy.uuid] = buddy.state;
                                // this dude is new, add him to the list
                                var name = buddy.state.name;
                                var buddyTemplate = '<div class="chat-buddy"><img title="' + name + '" alt="' + name + '" src="' + buddy.state.face +  '"><span class="buddy-usr-handle">' + name + '</span></div>';
                                $('.chat-buddy-list').append(buddyTemplate);
                            }
                        });
                    }
                }
            });

            $('#input-message').keypress(function (e) {
                if (e.which == 13) {
                    //get sentiment data
                    $.ajax({
                        url: '{{Url('chat/predict')}}',
                        type: 'GET',
                        data: { 'uuid' : '{{$user->id}}', 'message' : $('#input-message').val(), 'cnt' : msgCnt},
                        success: function(data) {
                        console.log(data);
                        var face = neutralFace;
                            if(data.result == 0) {
                                face = neutralFace;
                                $('#user_face').attr('src', neutralFace);
                            }
                            else if(data.result < 0) {
                                face = negativeFace;
                                $('#user_face').attr('src', negativeFace);
                            }
                            else {
                                face = positiveFace;
                                $('#user_face').attr('src', positiveFace);
                            }

                            sendMessage({
                                message: $('#input-message').val(),
                                languages: '<?php echo $user->languages;?>'
                            }, face);
                        },
                        error: function(err) { alert(err); }
                    });
                    $('#input-message').val('');
                    return false;    //<---- Add this line
                }
            });
        });

        function unsub() {
            //PUBNUB.unsubscribe({ channel : 'demo_tutorial' });
            PUBNUB_demo.unsubscribe({ channel : 'demo_tutorial' });
            $('form#logoutform').submit();
        }
    </script>

</head>
<body id="profile" class="chatRoom">
    <header>
      <a href="<?php echo url('../');?>">
        <h1>Kuafu</h1>
        <h3>Real Time Chat</h3>
      </a>
    </header>
    <nav>
        <div class="username"><span>You are logged in as:</span><br />{{$user->fullname}}</div>
        <a href="<?php echo url('/');?>">home</a>
        <a href="<?php echo url('user/profile');?>" class="active">profile</a>
        <a href="<?php echo url('chat');?>">chat</a>
        <div class="logout">
            <form action="<?php echo url('user/logout'); ?>" method="post" name="logoutform" id="logoutform">
                <input type="button" onclick="unsub();" value="Logout">
            </form>
        </div>
    </nav>
	<div id="container" class="clearBoth">
		<h2>Welcome to the Chat Room</h2>
		<div class="chatMod">
      <div class="posLeft">
        <div class="usr">
					{{HTML::image($user->neutral_face, '', array('id' => 'user_face'))}}
				</div>
      </div>
      <div class="chat-window">
        <div class="chat-buddy-list">
          <!-- display friends currently logged in -->
        </div>
      </div>
      
    </div>
		
		<div class="msg-console">
			<small>Press enter to send</small>
			<input type="text" id="input-message" />
		</div>
	</div>
</body>
</html>
