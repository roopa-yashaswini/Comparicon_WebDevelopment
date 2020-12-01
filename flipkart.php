<?php

include_once "get_html.php";

function flipkart($search){
    
    $search = str_replace(" ", "%20", $search);

    $url = "http://www.flipkart.com/search?q=$search";

    $html= getHTMLcode($url);
    
    $html = trim(preg_replace('/\s+/', ' ', $html));
    
    //scrape title from the search
    $title = '/<div class="_4rR01T">(?P<val>[^>]*)<\/div>/';
    if(preg_match_all($title,$html,$value)){
        
        //scrape price from the search
        $price ='/<div class="_30jeq3 _1_WHN1">(?P<cst>[^>]*)<\/div>/';
    	preg_match_all($price,$html,$cost); 

        //scrape link from the search
        $link = '/<a class="_1fQZEK" .*? href="(?P<lnk>[^>]*)">.*? /';
    	preg_match_all($link,$html,$data);

        $actual_links = Array();
    	foreach(@$data[lnk] as &$x){
    		$x = "https://www.flipkart.com".$x;
            array_push($actual_links, $x);
    	}

    	$result = Array();
    	$result['product_name'] = @$value[val];
    	$result['product_price'] = @$cost[cst];
    	$result['product_url'] = @$actual_links;

    	return $result;

    }

    //scrape title from the search
    $title = '/<a class="s1Q9rs" title="(.*?)" .*?>.*?<\/a>/';
    preg_match_all($title,$html,$value);    

    //scrape price from the search
    $price ='/<div class="_30jeq3">(?P<price>[^>]*)<\/div>/';
    preg_match_all($price,$html,$cost); 

    //scrape link from the search
    $link = '/<a class="_8VNy32" .*? href="(?P<lnk>[^>]*)">.*? /';
    preg_match_all($link,$html,$data);
    $actual_links = Array();
    foreach(@$data[lnk] as &$x){
    	$x = "https://www.flipkart.com".$x;
        array_push($actual_links, $x);
    }

	$result = Array();
    $result['product_name'] = @$value[1];
    $result['product_price'] = @$cost[0];
    $result['product_url'] = @$actual_links;

    return $result;

}

?>