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

    <script type="text/javascript">
        var PUBNUB_demo;
        var buddies = [];

        PUBNUB_demo = PUBNUB.init({
            publish_key: 'pub-c-48ffb314-d672-4aa9-b14a-373932847697',
            subscribe_key: 'sub-c-cc0b928c-7cbf-11e4-8912-02ee2ddab7fe',
            uuid: '{{$user->id}}'
        });

        function sendMessage(message) {
            PUBNUB_demo.publish({
                channel: 'demo_tutorial',
                message: {"message":message, "uuid":'{{$user->id}}'}
            });
        }

        $(function(){

            PUBNUB_demo.subscribe({
                channel: 'demo_tutorial',
                message: function(m){
                    console.log(m);
                    console.log(buddies);

                    var newMessage = "";

                    $.get("https://www.googleapis.com/language/translate/v2?key=AIzaSyDU6NLGZPgfZtnOrEYtmSgQsI90UBTexkU&q=" + encodeURIComponent(m.message) + "&target=<?php echo $user->languages; ?>",function(data,status){
                        if(data.data != null) {
                            if (data.data.translations != null) {
                                //alert("Data: " + data.data.translations[0].translatedText + "\nStatus: " + status);
                                var newMessage = '<div class="msg-wrapper"><div class="chat-board-name">' + buddies[m.uuid].name + ':</div><div class="chat-board-message">' + data.data.translations[0].translatedText + '</div></div>';
                                console.log(newMessage);
                                $('.chat-window').append(newMessage); $('.chat-window').scrollTop($('.chat-window:first')[0].scrollHeight);
                            }
                        }
                      });
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
                    sendMessage($('#input-message').val());
                    $('#input-message').val('');
                    return false;    //<---- Add this line
                }
            });
        });
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
      <a href="#">{{$user->fullname}}</a>
      <a href="<?php echo url('/');?>">home</a>
      <a href="<?php echo url('user/profile');?>" class="active">profile</a>
      <a href="<?php echo url('chat');?>">chat</a>
      <a href="<?php echo url('user/setting');?>">setting</a>
    </nav>
	<div id="container">
		<div class="chatMod">
      <div class="posLeft">
        <div class="usr">
					{{HTML::image($user->neutral_face)}}
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


    <script type="text/javascript">

      var clientId = '837050751313';

      var apiKey = '844271735773-3mmlqth0qe6jsma8t2bfjiih65c7ku4f.apps.googleusercontent.com';

      var scopes = 'https://www.googleapis.com/auth/prediction';

      function handleClientLoad() {
        // Step 2: Reference the API key
        gapi.client.setApiKey(apiKey);
        window.setTimeout(checkAuth,1);
      }

      function checkAuth() {
        gapi.auth.authorize({client_id: clientId, scope: scopes, immediate: true}, handleAuthResult);
      }

      function handleAuthResult(authResult) {
        var authorizeButton = document.getElementById('authorize-button');
        if (authResult && !authResult.error) {
          authorizeButton.style.visibility = 'hidden';
          makeApiCall();
        } else {
          authorizeButton.style.visibility = '';
          authorizeButton.onclick = handleAuthClick;
        }
      }

      function handleAuthClick(event) {
        // Step 3: get authorization to use private data
        gapi.auth.authorize({client_id: clientId, scope: scopes, immediate: false}, handleAuthResult);
        return false;
      }

      // Load the API and make an API call.  Display the results on the screen.
      function makeApiCall() {
        // Step 4: Load the Google+ API
        gapi.client.load('predict', 'v1.6').then(function() {
          // Step 5: Assemble the API request
          var request = gapi.client.plus.people.get({
            'userId': 'me'
          });
          // Step 6: Execute the API request
          request.then(function(resp) {
            var heading = document.createElement('h4');
            var image = document.createElement('img');
            image.src = resp.result.image.url;
            heading.appendChild(image);
            heading.appendChild(document.createTextNode(resp.result.displayName));

            document.getElementById('content').appendChild(heading);
          }, function(reason) {
            console.log('Error: ' + reason.result.error.message);
          });
        });
      }
    </script>
    <script src="https://apis.google.com/js/client.js?onload=handleClientLoad"></script>
</body>
</html>
