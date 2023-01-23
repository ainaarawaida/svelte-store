<?php


$args = array() ; 
$checkdata = get_post($_POST['cagamasdataid']);
$args = array(
    'ID' =>  $_POST['cagamasdataid'],
    'post_title' => esc_attr( $_POST['cagamasdatafilename'] ),
    'post_content' =>  serialize(json_decode(base64_decode($_POST['cagamasdataarraydata']))) ,
    'post_author' => $user->ID ,
    'post_type' => 'cagamasdata',
    'post_status' => 'publish',
    'post_parent' => '0'
);

if($checkdata){
    $check = wp_update_post( $args );
  }else{
    $check = wp_insert_post( $args );
  }
update_post_meta($check, 'cagamasdatapool', $_POST['cagamasdatapool']) ; 
// include_once dirname( __FILE__ ) . '/generatepoollppsadata.php';
$GLOBALS['mypwp_temp_data']['mypwp_user']['post']['id'] = $check;



// if(count($mydatatablehead) != '18'){
//     $GLOBALS['mypwp_temp_data']['mypwp_user']['error'] ;
//   }else{
//     $GLOBALS['mypwp_temp_data']['mypwp_user']['post']['mydatatablehead'] = $mydatatablehead ;
//     $GLOBALS['mypwp_temp_data']['mypwp_user']['post']['mydatatable'] = $mydatatable ;
//   }


?>