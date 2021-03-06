<?php
define('TITLE', 'When It Rains, It S!zzles...');
require __DIR__.'/header.php';
?>
  <style>
  html{height:100%;}
  body {
  background:#0D343A;
  background:-webkit-gradient(linear,0% 0%,0% 100%, from(rgba(13,52,58,1) ), to(#000000)  );
  background: -moz-linear-gradient(top, rgba(13,52,58,1) 0%, rgba(0,0,0,1) 100%);

  overflow:hidden;}


  .drop {
    background:-webkit-gradient(linear,0% 0%,0% 100%, from(rgba(13,52,58,1) ), to(rgba(255,255,255,0.6))  );
    background: -moz-linear-gradient(top, rgba(13,52,58,1) 0%, rgba(255,255,255,.6) 100%);
  	width:1px;
  	height:89px;
  	position: absolute;
  	bottom:200px;
  	-webkit-animation: fall .63s linear infinite;
    -moz-animation: fall .63s linear infinite;

  }

  /* animate the drops*/
  @-webkit-keyframes fall {
  	to {margin-top:900px;}
  }
  @-moz-keyframes fall {
  	to {margin-top:900px;}
  }
  </style>
</head>
<body>
  <div>
    <?php require_once __DIR__.'/navbar.php';?>
  </div>
  <section class="rain"></section>
  <div style="margin-top:600px;">
    <?php require __DIR__.'/footer.php';?>
  </div>
  <script>
  // Rain code from https://codepen.io/wogsland/pen/dXwpxP

  // number of drops created.
  var nbDrop = <?= $_GET['drops'] ?? 1000 ?>;

  // function to generate a random number range.
  function randRange( minNum, maxNum) {
    return (Math.floor(Math.random() * (maxNum - minNum + 1)) + minNum);
  }

  // function to generate drops
  function createRain() {

  	for( i=1;i<nbDrop;i++) {
  	var dropLeft = randRange(0,1600);
  	var dropTop = randRange(-1000,1400);

  	$('.rain').append('<div class="drop" id="drop'+i+'"></div>');
  	$('#drop'+i).css('left',dropLeft);
  	$('#drop'+i).css('top',dropTop);
  	}

  }
  // Make it rain
  createRain();
  </script>
</body>
</html>
