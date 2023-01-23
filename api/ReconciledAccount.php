<?php


if(isset($_POST['process']) && $_POST['process'] == "DeleteData"){
    wp_delete_post( $_POST['id'], false);
    wp_delete_post( $_POST['id2'], false);
}else{
    
    $get_data = $wpdb->get_results("SELECT  
a.ID, 
a.post_title,
b.display_name as maker_name,
a.post_date as upload_date,
c.meta_value as cagamasdatapool,
d.post_id as cagamasfileid,
e.meta_value as file_status,
(
  CASE
    WHEN e.meta_value IS NULL THEN '<span class=\"badge bg-primary\">New</span>'
    WHEN e.meta_value = 'Submit To Checker' THEN '<span class=\"badge bg-secondary\">Submit To Checker</span>'
    WHEN e.meta_value = 'Return To Maker' THEN '<span class=\"badge bg-success\">Return To Maker</span>'
    WHEN e.meta_value = 'Submit To Cagamas' THEN '<span class=\"badge bg-warning\">Submit To Cagamas</span>'
    WHEN e.meta_value = 'Verify By Cagamas' THEN '<span class=\"badge bg-info\">Verify By Cagamas</span>'
    ELSE e.meta_value
  END
) as file_status_html ,
f.meta_value as maker_submit_date,
h.display_name as checker_name,
i.meta_value as checker_verify_date

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

LEFT JOIN 
(SELECT post_id, meta_value FROM {$wpdb->prefix}postmeta WHERE meta_key = 'file_status') e
ON a.id = e.post_id 

LEFT JOIN 
(SELECT post_id, meta_value FROM {$wpdb->prefix}postmeta WHERE meta_key = 'maker_submit_date') f
ON a.id = f.post_id 

LEFT JOIN 
(SELECT post_id, meta_value FROM {$wpdb->prefix}postmeta WHERE meta_key = 'checker_name') g
ON a.id = g.post_id 


LEFT JOIN 
(SELECT ID,display_name FROM {$wpdb->prefix}users) h
ON g.meta_value = h.ID 

LEFT JOIN 
(SELECT post_id, meta_value FROM {$wpdb->prefix}postmeta WHERE meta_key = 'checker_verify_date') i
ON a.id = i.post_id 

 WHERE a.post_type = 'cagamasdata'");


}


$GLOBALS['mypwp_temp_data']['mypwp_user']['post']['getcagamasdata'] = $get_data ;


?>