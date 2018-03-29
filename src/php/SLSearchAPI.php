<?php
function get_http_response_code($url) {
    $headers = get_headers($url);
    return substr($headers[0], 9, 3);
}



if(isset($_REQUEST["s"]))
{
  if(isset($_REQUEST["i"]))
  {
    $output=SLSearch($_REQUEST["s"]);
    $output=explode("|",$output);
 
  echo $output[$_REQUEST["i"]];
  }
  else
  {
  echo SLSearch($_REQUEST["s"]); 
  }
}

function SLSearch($input)
{
  $lookup=htmlspecialchars_decode(str_replace(' ','%20',$input));
  $url = 'http://search.secondlife.com/client_search.php?s=people&q='.$lookup;
  $content = file_get_contents($url);
  $first_step = explode( '<h3 class="result_title">' , $content );
    if(isset($first_step[1]))
    {
    $second_step = explode("</h3>" , $first_step[1] );  
    $data = explode( 'http://world.secondlife.com/resident/' , $first_step[1]);
    $uuid = explode( '"' , $data[1]);
    $test = explode( '>' , $second_step[0]);
    $test2= explode( '<' , $test[1]);
    
    $data=$test2[0];
    $data=explode("(",$data);
    $data=$data[count($data)-1];
    $data=explode(")",$data);
    $data=$data[0];
    $data=explode(".",$data);  
    
    $string=trim($uuid[0])."|".trim($test2[0])."|".trim($data[0])." ";
      if(isset($data[1])) $string.= trim($data[1]);
      else $string.= " resident";
    return trim($string);
    }
    else
    {
      if(get_http_response_code("http://world.secondlife.com/resident/".$input) != "200")
      {
        return "non existant user/key not found";
      }
      else
      {
        $urlContents = file_get_contents("http://world.secondlife.com/resident/".$input);
        preg_match("/<title>(.*)<\/title>/i", $urlContents, $matches);
        return $input."|".$matches[1];
      }
    }
}
?>
      
      
    