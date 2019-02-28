<?php
// process client request (via URL)
	header ("Content-Type_application/json");
	include ("function.php");
	if(!empty($_GET['index'])){
		//le parti commentate all'interno del codice sono semplici tentativi durante la fase di debug, ho preferito lasciarli per usi futuri
			$index=$_GET['index'];
			//$index = 3;
			switch($index)
			{
				//query n1
				case 1:
				$id = get_fumetti();
				//echo $ids;
				$count = get_libro($id);
				echo $count;
				break;
				
				//query n2
				case 2:
				$sconti = get_sconti();
				//var_dump($sconti);
				$libri = aggiungi_id($sconti);

				$libri_sort = ordina($libri);
				/*
				foreach($libri_sort as $libro)
				{
					echo($libro["sconto"]."<br>");
				}
				*/
				$output = stampa_libri($libri_sort);
				echo $output;
				break;
				
				//query n3
				case 3:
				$start=$_GET['start_data'];
				$end=$_GET['end_data'];
				
				
				//$start = "15/03/2008";
				//$end = "14/07/2009";
				$output = control_data($start, $end);
				foreach($output as $name)
				{
					echo $name."\n";
				}
				break;
				
				//query n4
				case 4:
				//$indice = 6;
				$indice=$_GET['codice'];
				$codici = get_books_copies($indice);
				$libri = ottieni_libri($codici);
				$username = get_username($indice);
				echo $username."\n";
				foreach($libri as $libro)
				{
					echo $libro["titolo"]."\tCopie: ".$libro["ncopie"]."\n";
				}
				break;
		}
	}

?>