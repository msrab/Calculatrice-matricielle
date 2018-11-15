<?php

$operation = $_POST['operation'];
$matrices = $_POST['matrices'];
$dim = $_POST['dim'];


$matrices = convert_matrice($matrices, $dim);

//Addition
if($operation == 1){
	$result = addition($matrices, $dim);
}
//Soustraction
elseif($operation == 2){
	$result = soustraction($matrices, $dim);
}
//Multiplication
elseif($operation == 3){
	$result = multiplication($matrices, $dim);
}
//Inverse
elseif($operation == 4){
	$result = inverse($matrices[0]);
}
//Transposée
elseif($operation == 5){
	$result = transposee($matrices, $dim);
}
//Déterminant
elseif($operation == 6){
	if(sizeof($matrices[0]) == 2){
		$return = ($matrices[0][0][0] * $matrices[0][1][1]) - ($matrices[0][0][1] * $matrices[0][1][0]);
	}else{
		$return = 0;

		for($i=0; $i<sizeof($matrices[0][0]); $i++){
			$result = mineur($matrices, $dim,0,$i);
			if($i%2 == 0)
				$return += ($matrices[0][0][$i] * $result);
			else
				$return -= ($matrices[0][0][$i] * $result);
		}
	}
	$result = $return;
}

header('Content-Type:application/json');
	echo json_encode($result);



function transposee($matrices, $dim){
	$result = [];
	for($i=0; $i<$dim; $i++){
		for($j=0; $j<$dim; $j++){
			$result[$j][$i] = $matrices[0][$i][$j];
		}
	}
	
	return $result;
}

function addition($matrices, $dim){
	$result = [];
	for($i=0; $i<$dim; $i++){
		for($j=0; $j<$dim; $j++){
			$result[$i][$j] = $matrices[0][$i][$j] + $matrices[1][$i][$j];
		}
	}
	
	return $result;
}

function soustraction($matrices, $dim){
	$result = [];
	for($i=0; $i<$dim; $i++){
		for($j=0; $j<$dim; $j++){
			$result[$i][$j] = $matrices[0][$i][$j] - $matrices[1][$i][$j];
		}
	}
	
	return $result;
}

function multiplication($matrices, $dim){
	$result = [];
	for($i=0; $i<$dim; $i++){
		for($j=0; $j<$dim; $j++){
			for($k=0; $k<$dim; $k++){
				$result[$i][$j] += $matrices[0][$i][$k] * $matrices[1][$k][$j];
			}
			
		}
	}
	
	return $result;
}

function convert_matrice($matrice, $dim){
	$m1 = [];
	$m2 = [];
	$n = 0;
	for($i=0; $i<$dim; $i++){
		for($j=0; $j<$dim; $j++){
			$m1[$i][$j] = $matrice[$n]['value'];
			$n++;
		}
	}

	if(sizeof($matrice) > $dim*$dim){
		
		for($i=0; $i<$dim; $i++){
			for($j=0; $j<$dim; $j++){
				$m2[$i][$j] = $matrice[$n]['value'];
				$n++;
			}
		}
	}

	return [0 => $m1, 1 =>$m2];
}

function mineur($matrice, $dim, $posI, $posJ){
	$result =[]; $a= 0;

	for($i = 0; $i<$dim; $i++){
		if($i == $posI)
			continue;

		for($j=0; $j<$dim; $j++){
			if($j == $posJ)
				continue;

			$result[$a][] = $matrice[0][$i][$j];
		}
		$a++;
	}
	$return = calcul_mineur($result);
	return $return;
}

function calcul_mineur($matrice){

	if(sizeof($matrice) == 2){
		$return = ($matrice[0][0] * $matrice[1][1]) - ($matrice[0][1] * $matrice[1][0]);
	}
	else{
		$return = calcul_mineur_mn($matrice);
	}
	return $return;
}

function calcul_mineur_mn($matrice){
	$a = 0;

   //+
   do{
   		$j = $a;
   		$nbr = 1;
		for($i=0; $i<sizeof($matrice); $i++){
			if($j>=sizeof($matrice))
				$j=0;
			$nbr *= $matrice[$i][$j];
			$j++;
		}
		$return += $nbr;
		$a++;
	}while($a < sizeof($matrice));

	//-
	$a = sizeof($matrice)-1;
	do{
   		$j = $a;
   		$nbr = 1;
		for($i=0; $i<sizeof($matrice); $i++){
			if($j<0)
				$j=sizeof($matrice)-1;
			$nbr *= $matrice[$i][$j];
			$j--;
		}
		$return -= $nbr;
		$a--;
	}while($a >= 0);
	return $return;
}

function inverse($A)
{
	
	$n = count($A);
	$I = identite($n);
	for ($i = 0; $i < $n; ++ $i) {
		$A[$i] = array_merge($A[$i], $I[$i]);
	}

	for ($j = 0; $j < $n-1; ++ $j) {

		for ($i = $j+1; $i < $n; ++ $i) {

			if ($A[$i][$j] != 0) {

				$scalar = $A[$j][$j] / $A[$i][$j];
				for ($jj = $j; $jj < $n*2; ++ $jj) {
					$A[$i][$jj] *= $scalar;
					$A[$i][$jj] -= $A[$j][$jj];
				}
			}
		}
	}

	for ($j = $n-1; $j > 0; -- $j) {
		for ($i = $j-1; $i >= 0; -- $i) {
			if ($A[$i][$j] != 0) {
				$scalar = $A[$j][$j] / $A[$i][$j];
				for ($jj = $i; $jj < $n*2; ++ $jj) {
					$A[$i][$jj] *= $scalar;
					$A[$i][$jj] -= $A[$j][$jj];
				}
			}
		}
	}

	for ($j = 0; $j < $n; ++ $j) {
		if ($A[$j][$j] != 1) {
			$scalar = 1 / $A[$j][$j];
			for ($jj = $j; $jj < $n*2; ++ $jj) {
				$A[$j][$jj] *= $scalar;
				$A[$j][$jj] = round($A[$j][$jj],2);
			}
		}
	}

	$Inv = array();
	for ($i = 0; $i < $n; ++ $i) {
		$Inv[$i] = array_slice($A[$i], $n);
	}
	return $Inv;
}

function identite($n)
{
	$I = array();
	for ($i = 0; $i < $n; ++ $i) {
		for ($j = 0; $j < $n; ++ $j) {
			$I[$i][$j] = ($i == $j) ? 1 : 0;
		}
	}
	return $I;
}
