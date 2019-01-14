<?php
    /* ------------------------------------------------------------
        Module #    Wall ( Timeline )
        Author #    Avinash Patil
        Date   #    12-Jan-2018
        Usage  #    This module displays all posted comments from 
        			all users. Also it has a provision to add comments 
        			for the logged in users.
    	------------------------------------------------------------*/

	if(session_id() == '') {
        session_start();
    }

    if(isset($_SESSION['user_id']))
    {
    	$logged_userid = $_SESSION['user_id'];
		$logged_username = ucwords($_SESSION['user_name']);
    } else {
    	$logged_userid = 0;
    	$logged_username = 'Guest';
    }
?>
<!DOCTYPE html>
<html>
	<head>
		<title> WALL App</title>
		<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script type="text/javascript" src="static/js/index.js"></script>
	  	<link href="static/css/wall.css?v=1.0.2" rel="stylesheet">
	</head>
	<body>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		    <a class="navbar-brand" href="#">WALL App</a>
		      <ul class="nav navbar-nav ml-auto">
		        <li class="nav-item">
		          <a class="nav-link" href="#"><span class="fas fa-user"></span> <?= $logged_username?></a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link logout" href="login.php">
		          	<?php echo ($logged_userid > 0)? 'Logout' : 'Log in'; ?> </a>
		        </li>
		      </ul>
		    </div>
		</nav>
	  	<div class="container">
	  		<div class="row">
				<div class="col-lg-6 mx-auto col-md-6">
					<?php if ($logged_userid != 0) { ?>
						<div class="errText"></div>
						<form class="form-horizontal" id="frmWall" name="frmWall">
							<div class="form-group text-right">
								<textarea rows="5" cols="63" id="txtComment" placeholder="What's happening?" class="form-control" required></textarea><br/	>
								<input type="submit" id="submit" value="Post" class="btn btn-primary">
							</div>
						</form>
						<hr/>
					<?php } ?>
					<div class="wall-comments float-right col-md-12 col-lg-12"></div>
				</div>
			</div>
	  	</div>
</body>

</html>