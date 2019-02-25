<?php
// process client request (via URL)
	header ("Content-Type_application/json");
	$funzione=$_GET['funzione'];
	switch($funzione)
	{
		case '1':
		
			//$dati=datiConversione('libri.json');
			$libri=libriConversione('Libri_Categ.json');
			//$arr=array();
			$i=0;
			//var_dump($dati);
			/*
			foreach ($dati['libro'] as $book)
			{
				$arr[$i] =$book['titolo
				'];
				$i=$i+1;
			}
			break;
			*/
			foreach ($libri['Libri_Categ'] as $book)
			{
				if($book['Categ_tipo'] == "fumetti")
					$id = book['Libro_ID'];
				
			}
			print_r ($id);
			break;
			// seconda query
		case '2':
			$libri=libriConversione('Categorie.json');
			$i=0;
			foreach ($libri['Libri_Categ'] as $book)
			{
				if($book['Categ_tipo'] == "fumetti")
					$id = book['Libro_ID'];
				
			}
			
	}
	
/*	if(!empty($_GET['name'])){
	
			$name=$_GET['name'];
			$price=get_price($name);
	
			if(empty($price))
		//book not found
			deliver_response(200,"book not found", NULL);
			else
			//respond book price
			deliver_response(200,"book found", $price);
				}
	else
	{
		//throw invalid request
		deliver_response(400,"Invalid request", NULL);
	}
	*/
	function deliver_response($status, $status_message, $data)
	{
		header("HTTP/1.1 $status $status_message");
		
		$response ['status']=$status;
		$response['status_message']=$status_message;
		$response['data']=$data;
		
		$json_response=json_encode($response);
		echo $json_response;
	}
/*
	function datiConversione($json)
	{
		$str = file_get_contents($json);
		$dati = json_decode($str, true); 

		return $dati;
	}
*/
	function get_price($find)
	{
		$books=datiConversione('libri.json');
		 foreach($books['book'] as $book)
		 {
			 if($book['name']==$find)
			 {
				 return $book['price'];
				 break;
			 }
		 }
    }
	
	function libriConversione($json)
	{
		$str = file_get_contents($json);
		$libri= json_decode($str, true); 

		return $libr;
	}
?>