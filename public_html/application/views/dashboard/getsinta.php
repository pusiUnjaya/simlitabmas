<?php 
	error_reporting(E_ALL);
	//echo "<pre>";

	$url = 'https://sinta.ristekbrin.go.id/authors/detail?id=6077421&view=overview';

	// SINTA
	$data = htmlentities(filter_content($url));
	$pecah = explode('<div class="uk-width-large-1-4 sinta-stat2">',filter_content($url));
	
	$dom = new DOMDocument('1.0','UTF-8');
	$dom->loadHTML($pecah[1]);   
	$node = $dom->getElementsByTagName('div')->item(0);   
	$outerHTML = $node->ownerDocument->saveHTML($node);   
	$innerHTML = '';
	foreach ($node->childNodes as $childNode){
		$innerHTML .= $childNode->ownerDocument->saveHTML($childNode);
	}
	//echo '<h2>innerHTML: </h2>';   
	$kolom1 = htmlspecialchars($innerHTML);    
	$dom = new DOMDocument('1.0','UTF-8');
	$dom->loadHTML($pecah[2]);   
	$node = $dom->getElementsByTagName('div')->item(0);   
	$outerHTML = $node->ownerDocument->saveHTML($node);   
	$innerHTML = '';
	foreach ($node->childNodes as $childNode){
		$innerHTML .= $childNode->ownerDocument->saveHTML($childNode);
	}
	//echo '<h2>innerHTML: </h2>';   
	$kolom2 = htmlspecialchars($innerHTML);
	
	$dom = new DOMDocument('1.0','UTF-8');
	$dom->loadHTML($pecah[3]);   
	$node = $dom->getElementsByTagName('div')->item(0);   
	$outerHTML = $node->ownerDocument->saveHTML($node);   
	$innerHTML = '';
	foreach ($node->childNodes as $childNode){
		$innerHTML .= $childNode->ownerDocument->saveHTML($childNode);
	}
	//echo '<h2>innerHTML: </h2>';   
	$kolom3 = htmlspecialchars($innerHTML);
	
	
	
	$url = 'https://sinta.ristekbrin.go.id/authors/detail?id=6077421&view=overview';

	// USE CASE
	$data = htmlentities(filter_content($url));


	// SOLUTION WRAPPED IN A FUNCTION
	function filter_content($url)
	{
		// FIND ALL OF THE DESIRED DIV
		$htm = file_get_contents($url);
		$str = '<div class="uk-grid uk-grid-collapse uk-width-large-1-1 compact-stat">';
		$arr = explode($str, $htm);
		$new = $arr[1];
		$len = strlen($new);

		// ACCUMULATE THE OUTPUT STRING HERE
		$out = NULL;

		// WE ARE INSIDE ONE DIV TAG
		$cnt = 1;

		// UNTIL THE END OF STRING OR UNTIL WE ARE OUT OF ALL DIV TAGS
		while ($len)
		{
			// COPY A CHARACTER
			$chr = substr($new,0,1);

			// IF THE DIV NESTING LEVEL INCREASES OR DECREASES
			if (substr($new,0,4) == '<div')  $cnt++;
			if (substr($new,0,5) == '</div') $cnt--;

			// ACTIVATE THIS TO FOLLOW THE COUNT OF NESTING LEVELS
			// echo " $cnt";

			// WHEN THE NESTING LEVEL GOES BACK TO ZERO
			if (!$cnt) break;

			// WHEN THE NESTING LEVEL IS STILL POSITIVE
			$len--;
			$out .= $chr;
			$new = substr($new,1);
		}

		// RETURN THE WORK PRODUCT
		return $str . $out . '</div>';
	}
	?>