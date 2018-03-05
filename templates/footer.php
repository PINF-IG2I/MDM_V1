<?php
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php");
	die("");
}
?>

</div>
<!-- end of content --> 

<!-- end of wrap -->
</div>
<footer class="panel-footer" data-color="light grey">
	<div class="container-fluid">
		<nav>
			<p class="copyright text-center">
				<?php
				// If the user is connected, a logout link is displayed
				if (secure("isConnected","SESSION"))
				{
					echo "User <b>$_SESSION[last_name]</b> is connected - \t"; 
					echo "<a href=\"controleur.php?action=Logout\">Logout</a><br>";
				}
				?>
				©
				TOPINF - IG2I
				<script>
					document.write(new Date().getFullYear())
				</script>
			</p>
		</nav>
	</div>
</footer>

</body>
</html>