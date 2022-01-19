<?php

try{

		$bdd=new PDO('mysql:host=localhost;dbname=backend1','root','');
	}
	catch(exeption $e)
	{
		die('erreur'.$e->getMessage());
	}
$anne=date('Y');
$data1=$bdd->query("select sum(montant) as montant,count(id) as nombre,month(dateentre) as mois from heberge where year(dateentre)='$anne' group by month(dateentre)");
//on déclare les données à faire en objet JSON
$data=array();
$mois=array();
$newtab=array();
while ($datafetch=$data1->fetch()) 
{
	$jsonArrayItem=array();
	$jsonArrayItems=array();
	//on afetcte le donnés dans un tableau
	$jsonArrayItems=$datafetch['mois'];
	$jsonArrayItem=$datafetch['nombre'];
	array_push($data,$jsonArrayItem);
	array_push($mois,$jsonArrayItems);
}
$data1->closeCursor();
$data2=array();
for ($i=1; $i <=12 ; $i++) 
{ 
	$j=0;
	$b=0;
	foreach ($mois as $value) {
		 if($i==$value)
		{
			$b=$data[$j];
		}
		$j=$j+1;	
	}
	$newdata['nombre'] = $b;
	array_push($data2, $newdata);

}

print_r( json_encode($data2));
?>