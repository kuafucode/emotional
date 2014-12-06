<!-- @extends ('landing'); -->
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Kuafu Chat</title>
  
  <link href='http://fonts.googleapis.com/css?family=Carrois+Gothic' rel='stylesheet' type='text/css' />
	<style>
		@import url(//fonts.googleapis.com/css?family=Lato:700);

		body {
			margin:0;
			font-family:'Carrois Gothic', sans-serif;
			text-align:center;
			color: #fff;
		}

		a, a:visited {
      color: #fff;
      display: block;
			text-decoration:none;
		}
    a:hover {
      text-decoration: underline;
    }

		h1 {
			font-size: 48px;
			margin: 16px 0 0 0;
      padding: 0;
		}

    h3 {
      font-size: 18px;
      font-weight: normal;
      margin: 0;
      padding: 0;
      text-transform: lowercase;
    }

    #container .mod {
      margin: auto;
      background: #40404a;
      background: #40404a; /* Old browsers */
      background: #40404a; /* Old browsers */
      background: -moz-linear-gradient(top,  #40404a 0%, #68686b 100%); /* FF3.6+ */
      background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#40404a), color-stop(100%,#68686b)); /* Chrome,Safari4+ */
      background: -webkit-linear-gradient(top,  #40404a 0%,#68686b 100%); /* Chrome10+,Safari5.1+ */
      background: -o-linear-gradient(top,  #40404a 0%,#68686b 100%); /* Opera 11.10+ */
      background: -ms-linear-gradient(top,  #40404a 0%,#68686b 100%); /* IE10+ */
      background: linear-gradient(to bottom,  #40404a 0%,#68686b 100%); /* W3C */
      filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#40404a', endColorstr='#68686b',GradientType=0 ); /* IE6-9 */

      border-radius: 50%;
      color: #fff;
      width: 500px;
      height: 500px;
      text-align: center;
      border: 1px solid #fff;
    }
	</style>
</head>
<body>
	<div id="container">
    <div class="mod">
      <header>
        <h1>Kuafu</h1>
        <h3>Real Time Chat</h3>
      </header>
      
      <h4>Sign in</h4>
      <form action="<?php echo url('user/login');?>" method="post">
        <div>
          <label for="user">User</label>
          <input type="text" placeholder="Enter User Name" id="user" name="user" class="user" />
        </div>
        <div>
          <label for="password">Password</label>
          <input type="password" placeholder="super@cool.com" id="pwd" name="pwd" class="pwd" />
        </div>
        <div>
          <button type="submit" class="btn">Let's Go!</button> 
        </div>
        
      </form>
    </div>
  </div>
</body>
</html>