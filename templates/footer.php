<?php
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php");
	die("");
}
?>

<!-- end of content --> 

<!-- end of wrap -->
</div>
<footer class="footer" >
	<div class="container">
			<span class="text-muted">
				<?php
				// If the user is connected, a logout link is displayed
				if (secure("isConnected","SESSION"))
				{
					echo "User <b>$_SESSION[last_name]</b> is connected - \t"; 
					echo "<a href=\"controleur.php?action=Logout\">Logout</a>";
				}
				?>
				
			</span>
			<span>
				©
				TOPINF - IG2I - 
				<script>
					document.write(new Date().getFullYear())
				</script>	
			</span>
	</div>
</footer>
</main>
</body>
</html>