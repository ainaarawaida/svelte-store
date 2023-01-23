<?php


if(isset($_POST['process']) && $_POST['process'] == "DeleteData"){
    wp_delete_post( $_POST['id'], false);
    wp_delete_post( $_POST['id2'], false);
}else if(isset($_POST['process']) && $_POST['process'] == "UpdateData"){
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
   
}else{
    
    $get_data = $wpdb->get_results("SELECT a.post_title, a.post_content, b.meta_value as cagamasdatapool FROM {$wpdb->prefix}posts a
        LEFT JOIN 
    (SELECT post_id, meta_value FROM {$wpdb->prefix}postmeta WHERE meta_key = 'cagamasdatapool') b
    ON a.id = b.post_id 

      WHERE post_type = 'cagamasdata'
      AND ID = '{$_POST['cagamasdataid']}'");

$get_data[0]->post_content = unserialize($get_data[0]->post_content) ;
$get_data[0]->post_content_head = array(0 => 'MONTHS',
1 => 'PORTFOLIO NO.',
2 =>'COMP FILE NUMBER',
3 =>'OPENING PRINCIPAL BALANCE',
4 =>'AMOUNT PAID MI PRINCIPAL',
5 =>'AMOUNT PAID MI INT',
6 =>'AMOUNT PAID MI COMP INT',
7 =>'PARTIAL PREPAYMENT',
8 =>'FULL REDEMPTION PRINCIPAL',
9 =>'FULL REDEMPTION OTHER DEBIT',
10 =>'CREDIT ADJUSTMENT',
11 =>'TOTAL AMOUNT PAID',
12 =>'TOTAL AMOUNT DUE',
13 =>'ADJUSTMENT',
14 =>'ADJUSTED BALANCE',
15 =>'CLOSING PRINCIPAL BALANCE',
16 =>'RENOVATION MI',
17 =>'NET TOTAL AMOUNT PAID'
) ;


}

$GLOBALS['mypwp_temp_data']['mypwp_user']['post']['getcagamasdataproses'] = $get_data ;

?>