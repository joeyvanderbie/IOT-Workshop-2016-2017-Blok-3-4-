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
     <img src="img/rainbow.png" width="30" height="30" class="d-inline-block pull-left" alt="">
	   Pixel Art
	  </a>
  </nav>
<!--nav-bar ends here-->

<div class="row col-12 site-container">
<div class="col-3">
</div>
<!--container for grid field and coordinates starts here-->
<div class="pixel-grid text-center col-6">

  <!--Pixel Grid with 6x6 fields is created here-->
  <?php 
  	$maxID = 6*6-1;
  	$count = 0;
	for ($x = 0; $x <= 5; $x++) {
		echo "<div class='row pixel-row'>";
    echo "<div class='pixel-y-coordinate text-center'>".(6-$x)."</div>";
	   for ($y = 1; $y <= 6; $y++) {
	   	$id = $x*5+$y+1*$count;
	    echo "<button id='".$id."' class='card pixel'></button>";
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


<!--container for information on pixel that has the own chipid -->
<div class="col-3">
<!-- card for saved pixel -->
<div class="card" id="own-data-display-panel">
  <div class="card-header">
    Your pixel!
  </div>
  <div class="card-block">
    <h4 class="card-title">This is your pixel!</h4>
    <div class="row">
      <div class="col-4">
      <div class="card pixel" id="own-pixel"></div>
      </div>
      <div class="col-8">     
      <div class="row">
        <p class="card-text">Chip-ID:</p>
        <p class="card-text" id="own-chip-id">none</p>
      </div>
       <div class="row">
        <p class="card-text">Coordinates:</p>
        <p class="card-text" id="own-coordinates">none</p>
      </div>
      </div>
    </div>
    <button class="btn btn-primary" id="delete-pixel-button" onclick="onDeleteOwnPixelClicked()">Delete</button>
    </div>
  </div>

<!--card for entering pixel data-->
<div class="card" id="own-data-input-panel">
  <div class="card-header">
    Your pixel!
  </div>
  <div class="card-block form">
    <h4 class="card-title">Select a pixel!</h4>
    <div class="row">
      <div class="col-4">
      <button id="own-pixel-input" class='card pixel' onchange="update(this.jscolor)"></button>
      </div>
      <div class="col-8">   
      <form>  
      <div class="form-group" >
      <label for="chipid">Enter your chip-ID!</label>
      <input type="text" id="chip-id-input" class="form-control"  placeholder="e.g. 1111" disabled="true">
      </div>
      <input class="form-control setting-option jscolor {mode:'HS'}" value="ab2567" onchange="update(this.jscolor)" id="jscolor-picker" disabled="true">
      </div>
    </div>
    <button class="btn btn-primary" id="submit-btn" onclick="onSubmitButtonClicked()" disabled="true">Submit</button>
    </div>
  </div>
</div>
  
  <div class="card" id="color-submit-panel"> 
    <div class="card-block">
  </div>

</div>


<!-- js script for hover-select and select-->
<script type="text/javascript">

var selectID, color, chipid, chipidIsSet = false, ownColor, ownCoordinates, ownID; 

//disable submit button for empty chipid
$("#chip-id-input").on("input", function() {
  if ($('#chip-id-input').val().length > 0)
    $('#submit-btn').prop( "disabled", false);   
  else 
    $('#submit-btn').prop( "disabled", true);   
});


//handle hover events on pixels
for (var i = 1; i <=36; i++) {
  $('#'+i).hover(function() {
    $( this ).addClass( 'pixel-hover' );
  }, function() {
    $( this ).removeClass( 'pixel-hover');
  });

  // handle click events on pixels
  $('#'+i).click(function() {

    $( '.pixel-selected').removeClass('pixel-selected');
    $( this ).addClass( 'pixel-selected' );
    //id of pixel
    selectID = $(this).attr('id');

    //if there is no chipid set for this particular user, leave option for doing so
    if (!chipidIsSet) {
      enablePixelPanel();
      color = $(this).css("background-color");
      document.getElementById('jscolor-picker').jscolor.fromString(color);
      $( '#own-pixel-input').css('background-color', '#' + jscolor);
    }
    
   
    //color of pixel in hex code
    
});


//retrieve hex values instead of rgb, source: https://stackoverflow.com/questions/6177454/can-i-force-jquery-cssbackgroundcolor-returns-on-hexadecimal-format
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

  function enablePixelPanel() {
  
      $('#chip-id-input').prop( "disabled", false);
      $('#own-pixel-input').prop( "disabled", false );      
      $('#jscolor-picker').prop( "disabled", false );       
  }

  function disablePixelPanel() {
      $('#chip-id-input').prop( "disabled", true);
      $('#own-pixel-input').prop( "disabled", true ); 
      $('#submit-btn').prop( "disabled", true );      
      $('#jscolor-picker').prop( "disabled", true );  
  }

  function onSubmitButtonClicked() {
      chipidIsSet = true;
      chipid = $('#chip-id-input').val();
      ownID = $('.pixel-selected').attr('id');
      color = $('#chip-id-input');
      hideCard('own-pixel-input');
      showCard('own-pixel-display');
      $( '#own-pixel').css('background-color');
      $('#own-chip-id').text(chipid);
      $('#own-coordinates').text(ownID);
      console.log("here you find all the information: " + selectID + ", " + color + ", " + chipid);
  }

  function onDeleteOwnPixelClicked() {
    
    $( '#'+ownID).css('background-color', '#fff');
    $('#own-chip-id').text('none');
    $('#own-coordinates').text('none');
    $( '#own-pixel').css('background-color', '#fff');
    $( '#own-pixel').css('background-color', '#fff');

    chipidIsSet = false;
    chipid = null;
    ownID = null;

  }

  //unselect pixels if user clicks somewhere 'random' (needs refactoring)
  $(document).click(function (e)
  {
   if ($('.col-6').is(e.target) || $('.col-3').is(e.target))
    {
        $( '.pixel-selected').removeClass('pixel-selected');
        disablePixelPanel();
     }
  });

  function showCard(cardID) {
    $('#'+cardID).attr('display', 'none');
  }

  function hideCard(cardID) {
    $('#'+cardID).attr('display', 'inline');
  }

}

  function update(jscolor) {
      // 'jscolor' instance can be used as a string
      color = '#' + jscolor;
      $( '.pixel-selected').css('background-color', '#' + jscolor);
      $( '#own-pixel-input').css('background-color', '#' + jscolor);
      console.log(color);
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
