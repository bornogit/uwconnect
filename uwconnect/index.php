<html>
	<head>
		<title> Connect </title>
		<!-- Bootstrap -->
		<link href="styles/bootstrap.styles" rel="stylesheet">
		<link href="styles/connect.styles" rel="stylesheet">
		<script src="http://code.jquery.com/jquery-latest.scripts"></script>
		<script src="scripts/bootstrap.min.scripts"></script>
		<script src="scripts/bootstrap-transition.scripts"></script>
		<script src="scripts/bootstrap-alert.scripts"></script>
		<script src="scripts/bootstrap-modal.scripts"></script>
		<script src="scripts/bootstrap-dropdown.scripts"></script>
		<script src="scripts/bootstrap-scrollspy.scripts"></script>
		<script src="scripts/bootstrap-tab.scripts"></script>
		<script src="scripts/bootstrap-tooltip.scripts"></script>
		<script src="scripts/bootstrap-popover.scripts"></script>
		<script src="scripts/bootstrap-button.scripts"></script>
		<script src="scripts/bootstrap-collapse.scripts"></script>
		<script src="scripts/bootstrap-carousel.scripts"></script>
		<script src="scripts/bootstrap-typeahead.scripts"></script>
		<script src="http://connect.facebook.net/en_US/all.scripts"></script>
		<script src="scripts/jquery-1.8.2.scripts"> </script>
		<script src="scripts/jquery.validate.scripts"> </script>
		<script type="text/javascript">  
			FB.init
			({
				appId:'278629895590946', cookie:true,
				status:true, xfbml:true
			});
			
			var handle;
			
			function scrollBox()
			{
				$("chatTexts").scrollTop(200); // this was an attempt to make the chatText textarea autoscroll but something is missing. May be you can have a look.
			}
			
			function submitChat()
			{
				if ($('#inputTextArea').val() != "")
				{
					$.post("ajax.php", {newMessage:$('#inputTextArea').val(),sender:$("#handle").html()}, 
						function(data)
						{
							$("#inputTextArea").val("");
							scrollBox();
						}
					);
				}
			}
			
			
			
			function update()
			{
				$.post("ajax.php", {chat:$('#inputTextArea').val(),sender:$("#handle").html()}, 
				function(data)
					{
						if (data != "")
						{
							var messages = data.split("<br>");
							var numNewMessages = messages.length;
							for (i = 0; i < numNewMessages-1; i++)
							{
								$("#chatTexts").val($("#chatTexts").val()+ "\n"+messages[i]);
							}
						}
						
					}
				); 
				
				$.post("ajax.php", {friendList:"friendList"}, 
				function(data)
					{
						var frndList = data.split("<br>");
						$('#friendList').empty();
						var length = frndList.length;
						for (i = 0; i < length-1; i++)
						{
							var row = $("<tr><td>" + frndList[i] +"</td><td> <image src = 'image/online.png' width='10px' height='10px' /></td></tr>");
							$('#friendList').append(row);
						}
					}
				); 
				setTimeout('update()', 1000);
			}
			function checkUserName()
			{	
				if (!$("#handle").val())
				{
					$("#error2").text("");
				}
				else
				{
					$.post("ajax.php", {handle:$("#handle").val()}, 
					function(data)
						{
							if (data == "false")
							{
								$("#error2").text("User name not available");
							}
						}		
					);
				}				
			}
			
			$(document).ready
			(
				function()
				{$("#error").text("");
					update();
					$("#loginForm").validate({ 
					rules: { 
						loginHandle: "required",
						loginPassword: "required"
					}}); 
					$("#signup").validate({ 
						rules: { 
						fname: "required",
						lname: "required",
						email: {
							required: true, 
							email: true 
					},
					handle: "required",
					passwd: "required"
					}}); 
	     
				});
		</script>
	</head>
	<body >
		<?php
			include("library.php");
			session_start();
			if(!sessionCheck()){
		?>
		<div id="body" class="hero-unit">
			<h2> Welcome to Connect : Madison's Distributed Chat System </h2>
			<h3>Login</h3>
			<?php
				if (isset($_SESSION['error']))
				{
					echo "<h4 id='loginerror'>".$_SESSION['error']. "</h4></br>";
					unset($_SESSION['error']);
				}
			?>	
			<form class="form-horizontal" id="loginForm" method="POST" name="loginForm" action="login.php">
				<div class="control-group">
					<label class="control-label"><strong> Username: </strong></label>
					<div class ="controls">
						<input type="text" id="loginHandle" name="loginHandle"/>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><strong> Password: </strong></label>
					<div class ="controls">
						<input type="password" id="loginPassword" name="loginPassword"/>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<input class="btn btn-large btn-primary" type="submit" value="Log In!!" ">
						<h4> OR </h4>
						<fb:login-button>Login with Facebook</fb:login-button>
					</div>
				</div>
			</form>
			
			<h3>Register now</h3>
			<form class="form-horizontal" id="signup" name="signup" action="signup.php" method="post">
				<div class="control-group">
					<label class="control-label"><strong> First Name: </strong></label>
					<div class ="controls">
						<input type="text" name="fname"/>
						<em>*</em>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><strong> Last Name: </strong></label>
					<div class="controls">
						<input type="text" name="lname"/>
						<em>*</em>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"> <strong> Connect Handle: </strong></label>
					<div class="controls">
						<input type="text" id="handle" name="handle" onchange="checkUserName();"/> 
						<label class="error" id="error2">  </label>
						<em>*</em>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><strong> Connect Password: </strong></label>
					<div class="controls">
						<input type="password" name="passwd"/>
						<em>*</em>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><strong> E-mail: </strong> </label>
					<div class="controls">
						<input clas="btn" type="text" name="email"/>
						<em>*</em>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<input class="btn btn-large btn-primary" type="submit" value="Sign Up!!">
					</div>
				</div>
			</form>
		</div>
		<div id="footer">
			<div class="headerDiv">
				<p class="muted credit" align='center'> Connect Service brought to you by Irtiza Ahmed Akhtar and Zainab Ghadiyali	</p>
			</div>
		</div>
		<?php
		}
		else
		{
			if (isset($_POST['handleName']))
			{
				echo $_SESSION['connected'];
			}
			drawLoginStatus();
		?>
		<div id="contentWrap" class="contentWrap">
			<div id="upperPanel" class="hero-unit">
				<textarea id="chatTexts"  name="chatTexts" readOnly="readOnly"></textarea> 
			</div>
			<div id="rightPanel">
				<label> Online Friends</label>
				<table id="friendList" name="friendList" class="table table-hover">
					
				</table>
			</div>
		</div>
		
		<div id="bottomPanel" class="contentWrap">
			<div id="bottomLeftPanel" class="hero-unit">
				<textarea id="inputTextArea" name="inputTextArea" placeholder="Enter Your Text Here"></textArea>
			</div>
			<div id="bottomRightPanel">
				<?php
					drawButton("submitChat", "Enter", "submitChat()");
				?>
			</div>
		</div>
			
		
		<div id="footer">
			<div class="headerDiv">
				<p class="muted credit" align='center'> Connect Service brought to you by Irtiza Ahmed Akhtar and Zainab Ghadiyali	</p>
			</div>
		</div>
	
		<?php 
			} 
		?>
		
	</body>
</html>
