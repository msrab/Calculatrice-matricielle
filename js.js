var choix = 0,texte = '',dim = 0, m1 = [], m2 = [];

$("#choix_op").click(function(){
	choix = $( ".browser-default option:selected" ).val();
	texte = $( ".browser-default option:selected" ).text();
	dim = $( "#dim" ).val();
	//alert(choix + ' ' + dim);

	if(choix == 1 || choix == 2 || choix == 3){
		$('.matrices_space').prepend(generate_matrice(dim, 2));
		$('.menu').empty().append('<h4>'+texte+'</h4><a class="waves-effect waves-light btn" id="refresh" onclick="document.location.reload(false)"> Rafraichir </a >');
		$('#calculer').removeClass('hide');
	}
	else{
		$('.matrices_space').prepend(generate_matrice(dim, 1));
		$('.menu').empty().append('<h4>'+texte+'</h4><a class="waves-effect waves-light btn" id="refresh" onclick="document.location.reload(false)"> Nouveau calcul </a >');
		$('#calculer').removeClass('hide');
	}

});

$('#refresh').on('click', function() {
    location.reload();
});

function generate_matrice(dim, number){
	code = '<div class="row"><form >';

	for(a=1; a<number+1;a++){
		code += '<div class="col s6"><table class="card-panel"><thead>Matrice '+a+'</thead><tbody>';
		for(i=0; i<dim; i++){
			code += '<tr>';
			for(j=0; j<dim; j++){
				code += '<td><input type="number" name="m'+a+'['+i+']['+j+']" /></td>';
			}
			code += '</tr>';
		}
		code += '</tbody></table></div>';
	}
	
	code += '</form></div>';

	return code;
}


$("#calculer").click(function(){

	var matrices = $("form").serializeArray();

	$.ajax({
			url: 'traitement.php',
			method: 'post',
			data: {
				matrices: matrices,
				operation: choix,
				dim: dim
			},
			success : function(data){
				//alert(data);
				code = '<div class="row"><div class="col s6"><table class="card-panel"><thead>Résultat</thead><tbody>';

				if(data.length > 1){
					for(i=0; i<data.length; i++){
						code += '<tr>';
						for(j=0; j<data[i].length; j++){
							code += '<td>'+data[i][j]+'</td>';
						}
						code += '</tr>';
					}
				}
				else{
					code += '<tr><td>'+data+'</td></tr>';
				}
				code += '</tbody></table></div></div>';
				//code =generate_matrice_result(data);
				//alert(code);
				$('#calculer').remove();
				$('.resultats_space').empty().append(code);
				console.log(data);
			},
			error : function(){
				alert('error');
			}
		});
});
