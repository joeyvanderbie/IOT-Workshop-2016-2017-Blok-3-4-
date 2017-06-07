<html>
  <head>
      <title>PIXEL FUN!</title>
       <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
        <link href="css/styles.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Unica+One"/>
  </head>
  <body>

  <script src="js/jscolor.js"></script>
  <script type="text/javascript" src="jquery-3.2.1.min.js"></script>
    <script src="js/pixelselector.js"></script>

<!--nav-bar starts here-->
  <nav class="navbar navbar-light bg-faded">
	  <a class="navbar-brand" href="#">
	   Pixel Art
	  </a>
  </nav>
<!--nav-bar ends here-->

<div class="row">
<!--settings panel for setting color and chip-id (temporary solution) starts here-->
<div class="col-3 settings-panel">
  <div class="form-group">
	  <label for="usr">Enter your chip-ID!</label>
	  <input type="text" class="form-control" id="chip-id" placeholder="e.g. 1111">
  </div>
    <!--simple color picker, see http://jscolor.com/ for more informatíon-->
    <input class="form-control jscolor {mode:'HS'}" id="color-picker" value="ab2567" onchange="update(this.jscolor)">
  <button class="btn btn-primary">Submit</button>
</div>
<!--settings-panel ends here-->

<!--container for grid field and coordinates starts here-->
<div class="container pixel-grid text-center col-9">

  <!--Pixel Grid with 6x6 fields is created here-->
  	<?php 
  	$maxID = 6*6-1;
  	$count = 0;
	for ($x = 0; $x <= 5; $x++) {
		echo "<div class='row pixel-row'>";
    echo "<div class='pixel-y-coordinate text-center'>".$x."</div>";
	   for ($y = 1; $y <= 6; $y++) {
	   	$id = $x*5+$y+1*$count;
	    echo "<div id='".$id."'class='card pixel'></div>";
		} 
		$count++;
		echo "</div>";
	} 
	?>
  <!--Pixel Grid ends here-->
  <div class="row coordinate-row">
    <div class="pixel-x-coordinate"></div>
    <div class="pixel-x-coordinate text-center">A</div>
    <div class="pixel-x-coordinate text-center">B</div>
    <div class="pixel-x-coordinate text-center">C</div>
    <div class="pixel-x-coordinate text-center">D</div>
    <div class="pixel-x-coordinate text-center">E</div>
    <div class="pixel-x-coordinate text-center">F</div>
  </div>
</div>
<!--container for grid field and coordinates ends here-->
</div>


<!-- js script for hover-select and select-->
<script type="text/javascript">
for (var i = 1; i <=36; i++) {
  $('#'+i).hover(function() {
    $( this ).addClass( 'pixel-hover' );
  }, function() {
    $( this ).removeClass( 'pixel-hover');
  });

  $('#'+i).click(function() {
   $( '.pixel-selected').removeClass('pixel-selected');
   $( this ).addClass( 'pixel-selected' );
   //id of pixel
   var selectID = $(this).attr('id');
   console.log("here you find the selected ID" + selectID);
   //color of pixel in hex code
   var color = $(this).css("background-color");
   console.log(color);
  document.getElementById('color-picker').jscolor.fromString(color);
});


//retrieve hex values instead of rgb source: https://stackoverflow.com/questions/6177454/can-i-force-jquery-cssbackgroundcolor-returns-on-hexadecimal-format
  $.cssHooks.backgroundColor = {
    get: function(elem) {
        if (elem.currentStyle)
            var bg = elem.currentStyle["backgroundColor"];
        else if (window.getComputedStyle)
            var bg = document.defaultView.getComputedStyle(elem,
                null).getPropertyValue("background-color");
        if (bg.search("rgb") == -1)
            return bg;
        else {
            bg = bg.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
            function hex(x) {
                return ("0" + parseInt(x).toString(16)).slice(-2);
            }
            return "#" + hex(bg[1]) + hex(bg[2]) + hex(bg[3]);
        }
    }
}
}

function update(jscolor) {
      // 'jscolor' instance can be used as a string
      $( '.pixel-selected').css('background-color', '#' + jscolor);
}

</script>
<!-- js script for hover-select and select ends here-->


<script type="text/javascript">
var o;
//$(document).ready(function() 
//{
//pasghetti
	/**setInterval(function() 
	{
	
	function checkchip()
	{
		for (var i =0; i <= 35; i++)
		{
			if ( typeof users[i].chipid === 'undefined' || !users[i].chipid)
			{
			document.getElementById(i+1).style.background='#e01111';
			} else 
				{
			//document.getElementById(i+1).style.background='#4286f4';
			document.getElementById(i+1).style.background=users[i].color;
				}
		}
	}
		function callback(msg)
		{
			users = JSON.parse(msg);
			//console.log(JSON.stringify(users));
			checkchip();
		}
		o = $.ajax({type:"GET", url:"getuser.php"}).done(callback).fail(function(msg){console.log("ka niet");});
		
		
		
	//},2000); **/
//}); 
</script>

<script type="text/javascript">
function toggle_element(element)
{
//console.log("works for: " + element);
//$(element).css('border', '3px solid black'); 
var koekje = document.getElementById(element);
   $(koekje).css({"border-color": "#000000", 
             "border":" 2px solid",
			 "border-radius":" -25px"});
}
</script>
</body>
</html>
