<?php
/**
* \file footer.php
* \brief This page is used to displayed a footer bar at the bottom of every page, except on the login page
* \author
* \version
*/

if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php");
	die("");
}
?>

<!-- end of content --> 

<!-- end of wrap -->
</body>
<footer class="footer" id="footer">
	<div class="container">
			<span class="text-muted">
				<?php
				// If the user is connected, a logout link is displayed
				if (secure("isConnected","SESSION"))
				{
					echo "User <b>$_SESSION[last_name]</b> is connected - \t"; 
				}
				?>
				<span class="float-right">
				©
				TOPINF - IG2I - 
				<script>
					document.write(new Date().getFullYear())
				</script>
				</span>	
			</span>
	</div>
</footer>
</html>