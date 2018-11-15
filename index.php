<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Calculatrice matricielle</title>
	<!-- Compiled and minified CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
            
</head>
<body>
	<div class="container">
		<div class="row">
			<h3>Calculatrice matricielle</h3>

			<div class="menu input-field row">
				<div class="input-field col s4">
		          <input id="dim" type="number" min='2' class="validate">
		          <label for="dim">Quelle est la dimension des matrices ?</label>
		        </div>
		  		<select class="browser-default col s3">
		    		<option value="" disabled selected>Que voulez-vous faire ?</option>
					<option value="1">Addition</option>
					<option value="2">Soustraction</option>
					<option value="3">Multiplication</option>
					<option value="4">Inverse</option>
					<option value="5">Transposée</option>
					<option value="6">Déterminant</option>
				</select>
				
				<div class="col s2">
					<a class="waves-effect waves-light btn" id="choix_op">OK</a>
				</div>
			</div>

			<div class="matrices_space">
				<button type="submit" class="waves-effect waves-light btn hide" id="calculer">Calculer</button>
			</div>

			<div class="resultats_space ">
			</div>

			




		</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('select').formSelect();
		});
        
	</script>
	<script src="js.js">

	</script>
</body>
</html>