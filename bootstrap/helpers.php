<?php

function parse_yesno($string, $ifyes='Yes', $ifno='No') {
    $parts = explode("<-|->", $string);
    if($parts[0] == "YES") {
        return $ifyes.' - '.$parts[1];
    } else {
        return $ifno;
    }
}
function check_empty($string){
    if(is_null($string) || $string==="" || !isset($string)){
        return true;
    }
    return false;
}
