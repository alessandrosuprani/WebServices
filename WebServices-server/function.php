<?php
//questi sono i metodi richiamati nel file index.php necessari a risolvere le queries

//controllo il reparto
 function get_libro($index)
 {
	 $url = file_get_contents('http://localhost/json/libri.json');
	 $libri = json_decode($url, true);
	 $count = 0;
	 foreach($libri as $k=>$v)
	 {
		 foreach($v as $key=>$value)
		 {
			 if($value["reparto"] == $index)
			 {
				 //echo $value["ID"];
				 $status = get_categoria($value["ID"]);
				 if($status)
					 $count++;
			 }
		 }
	 }
	 return $count;
 }
 
 //controllo la categoria
 function get_categoria($valore)
 {
	 $url = file_get_contents('http://localhost/json/libricateg.json');
	 $libricateg = json_decode($url, true);

	 foreach($libricateg as $k=>$v)
	 {
		 foreach($v as $key=>$value)
		 {
			 //echo $value["libro"];
			 if($value["libro"] == $valore)
			 {
				 if($value["categoria"] == "Ultimi arrivi")
					 return true;
				 else return false;
			 }
		 }
	 }
}
 
 //ricerca dei 'fumetti'
 function get_fumetti()
 {	
	$url = file_get_contents('http://localhost/json/reparti.json');
	$categs = json_decode($url, true);
	$array = array();
	
	foreach($categs as $k=>$v)
	{
		foreach ($v as $key=>$value)
		{
			//echo $value["tipo"];
			if($value["tipo"] == "fumetto")
			{
				//$array = $categ["ID"];
				//echo $value["ID"];
				return $value["ID"];
			}
		}
	}
 }
 
 //ricerca degli sconti
 function get_sconti()
 {
	$url = file_get_contents('http://localhost/json/categorie.json');
	$categories = json_decode($url, true);
	$catg = array();
	$i = 0;
	
	foreach($categories as $k=>$v)
	{
		 foreach($v as $key=>$value)
		 {
			 if($value["sconto"] > 0)
			 {
				$catg[$i]["tipo"] = $value["tipo"];
				$catg[$i]["sconto"] = $value["sconto"];
				$i++;
			 }
		 }
	}
	return $catg;
 }
 
 //ricerca dei libri scontati
 function aggiungi_id($sconti)
 {
	 $url = file_get_contents('http://localhost/json/libricateg.json');
	 $libricateg = json_decode($url, true);
	 $indice = 0;
	 $libri = array();
	 foreach ($libricateg as $k=>$v)
	 {
		foreach($v as $key=>$value)
		{
			 foreach ($sconti as $sconto)
			 {
				if($value["categoria"] == $sconto["tipo"])
				{
					$libri[$indice]["id"] = $value["libro"];
					$libri[$indice]["sconto"] = $sconto["sconto"];
					$indice++;
				}
			 }
		}
	 }
	 
	 return $libri;
 }
 
 //ordinamento crescente
 function ordina($libri)
 {
	 $toSort = array();
	 
	 foreach($libri as $key => $value)
	 {
		 $toSort[$key] = $value['sconto'];
	 }
	 
	 array_multisort($toSort, SORT_ASC, $libri);
	 
	 return $libri;
 }
 
 //creazione della stringa da stampare
 function stampa_libri($libriSort)
 {
	 $url = file_get_contents('http://localhost/json/libri.json');
	 $books = json_decode($url, true);
	 $output = "";
	foreach($libriSort as $key=>$value)
	{
		 foreach($books as $k=>$v)
		 {
			 foreach($v as $chiave=>$valore)
			 
				 if($value["id"] == $valore["ID"])
				 {
					$output.= $valore["titolo"]. "\t" . $value["sconto"]. "%\n";
				 }
		 }
	}
	return $output;
 }
 
 //si convertono le date in tempo in modo da effettuare il controllo (maggiore dell'inizio e minore della fine)
 function check_in_range($start_date, $end_date, $given_date)
{
	$str = strtotime($start_date);
	$end = strtotime($end_date);
	$curr = strtotime($given_date);
	//echo $str."<br>".$end."<br>".$curr."<br>";
    return (($curr >= $str) && ($curr <= $end));
}

//si passano al metodo check_in_range le date formattate correttamente
 function control_data($start, $end)
 {
	$url = file_get_contents('http://localhost/json/libri.json');
	$books = json_decode($url, true);
	
    $start = str_replace('/', '-', $start);
    $end = str_replace('/', '-', $end);
	
	$names = array();
	$index = 0;
	
	foreach($books as $key=>$value)
	{
		foreach($value as $k=>$v)
		{
			//echo $v["dataarch"]."<br>";
			//$given_date = str_replace('/', '-', $v["dataarch"]);
			if(check_in_range($start, $end, $v["dataarch"]))
			{
				$names[$index] = $v["titolo"];
				$index++;
			}
		}
	}
	return $names;
 }
 
 //ricerca dei libri e delle rispettive copie vendute
 function get_books_copies($indice)
 {
	$url = file_get_contents('http://localhost/json/libricarrello.json');
	$valori = json_decode($url, true);
	$tostamp = array();
	$index = 0;
	
	foreach($valori as $key=>$value)
	{
		foreach($value as $k=>$v)
		{
			if($indice == $v["carrello"])
			{
				$tostamp[$index]["libro"] = $v["libro"];
				$tostamp[$index]["ncopie"] = $v["ncopie"];
				$index++;
			}
		}
	}
	return $tostamp;
 }
 
 //ricerca dei titoli dei libri
 function ottieni_libri($codici)
 {
	$url = file_get_contents('http://localhost/json/libri.json');
	$books = json_decode($url, true);
	//$nomi = array();
	$index = 0;
	foreach($codici as $key=>$value)
	{
		 foreach($books as $k=>$v)
		 {
			 foreach($v as $chiave=>$valore)
			 {
				 if($value["libro"] == $valore["ID"])
				 {
					$codici[$index]["titolo"] = $valore["titolo"];
					$index++;
				 }
			 }
		 }
	}
	return $codici;
 }
 
 //ricerca dello username associato al carrello (nome + cognome)
 function take_username($numtel)
 {
	$url = file_get_contents('http://localhost/json/utenti.json');
	$utenti = json_decode($url, true);
	
	foreach($utenti as $chiave=>$valore)
	{
		foreach($valore as $k=>$v)
		{
			if($numtel == $v["numtelefono"])
			{
				return $v["nome"]." ".$v["cognome"];
			}
		}
	}
	
 }
 
 //si passa al metodo take_username il numero di telefono da cui cercare lo username
 function get_username($indice)
 {
	$url = file_get_contents('http://localhost/json/carrelli.json');
	$values = json_decode($url, true);
	$numtel = "";
	foreach($values as $key=>$value)
	{
		foreach($value as $k=>$v)
		{
			if($indice == $v["ID"])
			{
				$numtel = $v["utente"];
				break;
			}
		}
	}
	
	$username = take_username($numtel);
	return $username;
 }
?>