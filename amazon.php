<?php

include_once "get_html.php";

function amazon($search){
    $search = str_replace(" ", "+", $search);
    $url="https://www.amazon.in/s?k=$search";
    
    $html= getHTMLcode($url);

    $html = trim(preg_replace('/\s+/', ' ', $html));
    
    //scrape title from the search
    $title = '/a-color-base a-text-normal" dir="auto">(?P<val>[^>]*)<\/span>/';
    preg_match_all($title,$html,$value); 

    //scrape price from the search
    $price ='/<span class="a-offscreen">(?P<price>[^>]*)<\/span>/';
    preg_match_all($price,$html,$cost); 

    //scrape link from the search
    $link = '/<a class="a-link-normal a-text-normal" target="_blank" href="(.*?)">.*?<\/a>/'; 
    preg_match_all($link, $html, $data);
    foreach($data[1] as &$x){
        $x = "https://www.amazon.in".$x;
    }  

    $result = Array();
    $result['product_name'] = @$value[val];
    $result['product_price'] = @$cost[price];
    $result['product_url'] = @$data[1];
    
    return $result;

}

?>

 
