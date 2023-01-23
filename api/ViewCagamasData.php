<?php


if(isset($_POST['process']) && $_POST['process'] == "DeleteData"){
    wp_delete_post( $_POST['id'], false);
    wp_delete_post( $_POST['id2'], false);
}else{
    
    $get_data = $wpdb->get_results("SELECT  
    a.ID, 
    a.post_title,
    b.display_name as created_by,
    a.post_date as upload_date,
    c.meta_value as cagamasdatapool,
    d.post_id as cagamasfileid

    FROM {$wpdb->prefix}posts  a
    LEFT JOIN 
    (SELECT ID,display_name FROM {$wpdb->prefix}users) b
    ON a.post_author = b.ID 

    LEFT JOIN 
    (SELECT post_id, meta_value FROM {$wpdb->prefix}postmeta WHERE meta_key = 'cagamasdatapool') c
    ON a.id = c.post_id 

    LEFT JOIN 
    (SELECT post_id, meta_value FROM {$wpdb->prefix}postmeta WHERE meta_key = 'cagamasfileid') d
    ON a.id = d.meta_value 

    WHERE a.post_type = 'cagamasdata'");


}


$GLOBALS['mypwp_temp_data']['mypwp_user']['post']['getcagamasdata'] = $get_data ;


?>