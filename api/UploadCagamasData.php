<?php

use Shuchkin\SimpleXLSX;
$mydatatablehead = array() ; 

require_once __DIR__.'/assets/simplexlsx/src/SimpleXLSX.php';

if ($xlsx = SimpleXLSX::parse($_FILES['filecagamas']['tmp_name'])) {
    // print_r($xlsx->rows());
} else {
    // echo SimpleXLSX::parseError();
}

$newcount = 0 ;
foreach ($xlsx->rows() AS $key => $val){
  if($val['3'] == ""){
      continue;
  }
 
   if($val['0'] == "MONTHS"){
      for($count = 0 ; $count < count($val); $count++){
        if($val[$count] == ""){
          continue;
        }
            $mydatatablehead[$count] = $val[$count] ;
      }
    }else{
       for($count = 0 ; $count < count($mydatatablehead); $count++){
            $mydatatable[$newcount][$count] = $val[$count] ;
        }
        $mydatatable[$newcount]['key'] = $newcount ;
      $newcount++;
    }
   
}

// deb($mydatatablehead);
// deb($mydatatable);
if(count($mydatatablehead) != '18'){
  $GLOBALS['mypwp_temp_data']['mypwp_user']['error'] = "Salah" ;
}else{
  $GLOBALS['mypwp_temp_data']['mypwp_user']['post']['mydatatablehead'] = $mydatatablehead ;
  $GLOBALS['mypwp_temp_data']['mypwp_user']['post']['mydatatable'] = $mydatatable ;
}


?>