<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Search your object - TSOIISALIVE</title>
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="icon" type="image/png" href="img/favicon.png?v=2.0">
	</head>
  <body>
    <div class="main font">
      <div class="header">
        <div class="header--wrapper">
          <a href="/space" class="header--logo">TSOI<span>IS</span>ALIVE</a>
          <div class="block--form">
            <form action="methods/tsoiisalive.php" methos="POST">
              <input type="text" name="text" placeholder="Enter NORAD number" class="input__text" onkeyup="check()" autocomplete="off" maxlength="5" spellcheck="false">
              <input type="button" value="Reset" class="button__reset" onclick="clean()">
              <input type="submit" value="Send" class="button__send" onclick="send(); return false;">
            </form>
            <div class="tips-list"></div>
          </div>
        </div>
      </div>
      <div class="content">
        <div class="response"></div>
      </div>
      <div class="footer">
        <div class="footer--text"><a href="mailto:pluskika@gmail.com">Kirill</a> 2017</div>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
		<script src="js/main.js"></script>
  </body>
</html>