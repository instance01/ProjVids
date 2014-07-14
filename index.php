<?php
ob_start("ob_gzhandler");
session_start();
include("config.php");

// mysql connect
connect();


$user = "-";

if(isset($_SESSION['username']))
{
	$user = $_SESSION['username'];
	$pw = $_SESSION['password'];
} 

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>ProjVids</title>
</head>

<body>

<div class="ui inverted pointing secondary main menu">
    <a class="active red item home" data-tab="home">Home</a>
    <a class="red item scontacts" data-tab="scontacts">SContacts</a>
    <div class="green item">
        <div class="ui icon input">
        <input placeholder="Search..." type="text" id="search">
        <i class="search inverted circular link icon"></i>
        </div>
    </div>
    <div class="right menu">
    	<?php
        if($user != "-"){
        	echo('<a class="red item" href="upload.php?u='.$user.'&p='.$pw.'">Upload</a>');  
        }
        ?>
        <a class="red item login">
        <?php
        if($user != "-"){
        	echo("Logout");  
        }else{
        	echo("Login");  
        }
        ?>
        </a>
        <div class="ui pointing dropdown link item lang">
            Languages <i class="dropdown icon"></i>
            <div class="menu">
            <a class="item" href="de/">DE</a>
            <a class="item" href="index.php">US/EN</a>
            </div>
        </div>
    </div>
</div>


<div class="ui active tab" data-tab="home">
    <div class="ui divided grid">
      <div class="row">
        <div class="one wide column">
        	
            <div class="ui inverted secondary vertical categories menu">
            <a class="item" href="index.php">NEW VIDEOS</a>
            <?php
			$c = "";
			if(isset($_GET["c"]))
			{
				$c = $_GET["c"];
			}
			
			$result0 = mysql_query("SELECT * FROM categories ORDER BY id") or die(mysql_error()); 

			while($row0 = mysql_fetch_array($result0)){
				$p1 = $row0['category'];
				$currentc = '<a class="';
				if($p1 == $c){
					$currentc .= 'active ';
				}
				$currentc .= 'item" href="index.php?c='.$p1.'">'.$p1.'</a>';
				echo($currentc);
			}
			
			?>
            </div>
            
        </div>
        <div class="eight wide column">
            <?php
			$query1 = "SELECT * FROM videos";
			if(isset($_GET["c"]))
			{
				$query1 .= " WHERE categories LIKE '%".mysql_real_escape_string($_GET["c"])."%'";
			}
			$query1 .= " ORDER BY id";
			
			// load video instead if requested
			if(isset($_GET["v"]))
			{
				$query1 = "SELECT * FROM videos WHERE id='".mysql_real_escape_string($_GET["v"])."'";
				$result1 = mysql_query($query1) or die(mysql_error()); 
				while($row1 = mysql_fetch_array($result1)){
					$currentpost = "";
					$p0 = $row1['id'];
					$p1 = $row1['author'];
					$p2 = $row1['like'];
					$p3 = $row1['dislike'];
					$p4 = $row1['url'];
					$p5 = $row1['thumburl'];
					$p6 = $row1['title'];
					$p7 = $row1['desc'];
					$p8 = $row1['categories'];
					$date = $row1['date'];
					$currentpost .= $p6.'<br>'.$p7.'<center><video width="640" height="480" src="'.$p4.'" poster="'.$p5.'" controls>TODO: FALLBACK FLASH!</video></center>';
				}
				echo($currentpost);
			}else if(isset($_GET["s"])){
				$sq = mysql_real_escape_string($_GET["s"]);
				if($sq == ""){
					$sq = "hq";
				}
				$query1 = "SELECT * FROM videos WHERE title LIKE '%".$sq."%' OR videos.desc LIKE '%".$sq."%' OR categories LIKE '%".$sq."%'";
				$args = explode(" ", $sq);
				foreach ($args as $arg) {
					$query1 .= " OR title LIKE '%".$arg."%' OR videos.desc LIKE '%".$arg."%' OR categories LIKE '%".$arg."%'";
				}
				
				//$query1 = "SELECT * FROM videos WHERE MATCH (title, videos.desc, categories) AGAINST('".$sq."')";
				$result1 = mysql_query($query1) or die(mysql_error()); 
				
				$count = 0;
				$currentcount = 0;
				$maxcount = mysql_num_rows($result1);
				while($row1 = mysql_fetch_array($result1)){
					$currentpost = "";
					if($currentcount == 0){
						$currentpost .= '<div class="ui row"><div class="ui three column page grid">';
					}
					$p0 = $row1['id'];
					$p1 = $row1['author'];
					$p2 = $row1['like'];
					$p3 = $row1['dislike'];
					$p4 = $row1['url'];
					$p5 = $row1['thumburl'];
					$p6 = $row1['title'];
					$p7 = $row1['desc'];
					$p8 = $row1['categories'];
					$date = $row1['date'];

					$currentpost .= '<div class="column">'.$p6.'<a href="index.php?v='.$p0.'"><img class="ui large link image" src="'.$p5.'" alt="'.$p6.' preview Image"></a></div>';
					
					$count += 1;
					$currentcount += 1;
					if($currentcount == 3 || $count == $maxcount){
						$currentcount = 0;
						$currentpost .= "</div></div>";
					}
					echo($currentpost);
				}
			}else{
				$result1 = mysql_query($query1) or die(mysql_error()); 

				$count = 0;
				$currentcount = 0;
				$maxcount = mysql_num_rows($result1);
				while($row1 = mysql_fetch_array($result1)){
					$currentpost = "";
					if($currentcount == 0){
						$currentpost .= '<div class="ui row"><div class="ui three column page grid">';
					}
					$p0 = $row1['id'];
					$p1 = $row1['author'];
					$p2 = $row1['like'];
					$p3 = $row1['dislike'];
					$p4 = $row1['url'];
					$p5 = $row1['thumburl'];
					$p6 = $row1['title'];
					$p7 = $row1['desc'];
					$p8 = $row1['categories'];
					$date = $row1['date'];

					$currentpost .= '<div class="column">'.$p6.'<a href="index.php?v='.$p0.'"><img class="ui large link image" src="'.$p5.'" alt="'.$p6.' preview Image"></a></div>';
					
					$count += 1;
					$currentcount += 1;
					if($currentcount == 3 || $count == $maxcount){
						$currentcount = 0;
						$currentpost .= "</div></div>";
					}
					echo($currentpost);
				}
			}
			
			?>
            <div style="height: 1000px"></div>
        </div>
        <div class="two wide column">
        	Ads 
        </div>
      </div>
	</div>
</div>
<div class="ui tab" data-tab="scontacts">
	Coming Soon!
    <div style="height: 1000px"></div>
</div>





<!-- Modals -->
<?php
if(isset($_GET["error"]))
{
echo <<< EOT
<div class="ui active basic modal"><div class="content"><div class="ui form inverted segment">An error occurred while trying to log you in: Wrong username or password. <a href="index.php">Close</a></div></div></div>
EOT;
}
?>

<div class="ui small basic modal loginmodal">
  <i class="close icon"></i>
  <div class="header"></div>
  <div class="content">
    <div class="ui form segment">
      <div class="field">
          <label>Username</label>
            <div class="ui left labeled icon input">
              <input placeholder="Username" type="text" id="userinput">
              <i class="user icon"></i>
            </div>
          </div>
          <div class="field">
            <label>Password</label>
            <div class="ui left labeled icon input">
              <input type="password" id="pwinput">
              <i class="lock icon"></i>
            </div>
          </div>
          <div class="ui right floated blue submit button loginbtn">Login</div>
    </div>
  </div>
</div>


<!-- Stuff -->
<link rel="stylesheet" type="text/css" href="index.css">
<link rel="stylesheet" type="text/css" href="s/css/semantic.min.css">
<script type="text/javascript" src="jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
<script type="text/javascript" src="s/javascript/s.js"></script>
<script type="text/javascript" src="s/javascript/jquery.address.js"></script>
<script type="text/javascript">

$(document).ready(function(){

	$('.main.menu .item').tab();
	$('.home').click(function(e) {
		$('.main.menu .item').tab('change tab', 'home');
	});
	$('.scontacts').click(function(e) {
		$('.main.menu .item').tab('change tab', 'scontacts');
	});
	
	$('.login').click(function(e) {
		if($(this).text().indexOf("Logout") < 0){
			$('.loginmodal.modal').modal('show');
		}else{
			location.href = "logout.php";	
		}
	});
	
	$('#search').keypress(function(e) {
		if (e.which == 13) {
			location.href = "index.php?s=" + $(this).val();	
			e.preventDefault();
		}
	});
	
	$('.ui.dropdown').dropdown();
	$('.lang').click(function(e) {
		$('.ui.dropdown').dropdown();
	});
	
	$('.loginbtn').click(function(e) {
        location.href = "login.php?u=" + $('#userinput').val() + "&p=" + $('#pwinput').val();
    });

});

</script>
</body>
</html>