<?php
 function get_price($find){
	/* $books=array(
	 "java"=>299,
	 "c"=>348,
	 "php"=>267
	 );*/
	$str = file_get_contents('http://localhost/json/book.json');
	$books = json_decode($str, true); 
	// echo '<pre>' . print_r($books, true) . '</pre>';
	/* foreach($books as $book=>$price)
	 {
		 if($book==$find)
		 {
			 return $price;
			 break;
		 }
	 }*/
	 
	 foreach($books['book'] as $book)
	 {
		 if($book['name']==$find)
		 {
			 return $book['price'];
			 break;
		 }
	 }
 }

?>