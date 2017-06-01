<html>
  <head>
      <title>HAIL PETE</title>
       <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
        <link href="css/styles.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Unica+One" />
        

  </head>
  <body>

  <script src="js/jscolor.js"></script>
  <script type="text/javascript" src="jquery-3.2.1.min.js"></script>
    <script src="js/pixelselector.js"></script>

  <nav class="navbar navbar-light bg-faded">
	  <a class="navbar-brand" href="#">
	   Pixel Art
	  </a>
  </nav>

<div class="row">
  <div class="col-3 settings-panel" id="all">
  <div class="form-group">
	  <label for="usr">Enter your chip-ID!</label>
	  <input type="text" class="form-control" id="chip-id" placeholder="e.g. 1111">
  </div>
  <input class="form-control jscolor{value:'ab2567'}" onchange="update(this.jscolor)">

  <script type="text/javascript">
	
  </script>

  <button class="btn btn-primary" >Submit</button>
  </div>

  

  <div class="container pixel-grid text-center col-9">
  	<?php 
  	$maxID = 6*6-1;
  	$count = 0;
	for ($x = 0; $x <= 5; $x++) {
		echo "<div class='row pixel-row'>";
	   for ($y = 1; $y <= 6; $y++) {
	   	$id = $x*5+$y+1*$count;
	    echo "<div id='".$id."'class='card pixel'>".$id." </div>";
		} 
		$count++;
		echo "</div>";
	} 
	?>
	</div>
</div>


<div>Enter your chip ID!</div>
<div class="row">
 <div class="col s2 grey settings">
   <div class="prueba"><br>ID:</div>
 </div>
 <div class="col s2 grey settings">
   <div class="prueba">
     <input type="text">
   </div>
 </div>
</div>

<div class="row">
  <div class="col s3 grey settings">
    <div class="prueba"><br>
      <form action="/action_page.php">
        Select the color:
        <input type="color" name="favcolor" value="#ff0000">
      </form>
    </div>
  </div>
</div>

<div class="row">
  <div class="col s3 grey settings">
    <div class="prueba">
      <br>
      <button>Submit</button>
    </div>
  </div>
</div>

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
});
}

function update(jscolor) {
      // 'jscolor' instance can be used as a string
      $( '.pixel-selected').css('background-color', '#' + jscolor);
    }
</script>



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
