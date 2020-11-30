<?php

include_once "get_html.php";
function snapdeal($search){
    
    $search = str_replace(" ", "%20", $search);
    $url = "https://www.snapdeal.com/search?keyword=$search";

    $html= getHTMLcode($url);

    $html = trim(preg_replace('/\s+/', ' ', $html));
    
    $title = '/<p class="product-title.*?" .*?>(?P<val>[^>]*)<\/p>/';
    preg_match_all($title,$html,$value);
  
    $price ='/<span class="lfloat product-price.*?" .*?>(?P<price>[^>]*)<\/span>/';
    preg_match_all($price,$html,$cost); 

    $link = '/<div class="product-desc-rating ">.*?<a\s[^>]*href=\"([^\"]*)\"[^>]* .*?>.*?<\/a>.*?<\/div>.*?<div class="clearfix row-disc">/';
    preg_match_all($link,$html,$data);

    $result = Array();
    $result['product_name'] = @$value[val];
    $result['product_price'] = @$cost[price];
    $result['product_url'] = @$data[1];

    return $result;

}


?>