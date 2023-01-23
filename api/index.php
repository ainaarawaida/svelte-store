<?php

add_action( 'rest_api_init', 'mypwp_check_user');
function mypwp_check_user(){
    global $wpdb ; 
    // deb(MYPLUGINWP_PATH . 'api/UploadCagamasData.php');exit();
    $user = get_user_by('email', $_POST['user_email']);
    $GLOBALS['mypwp_temp_data']['mypwp_user'] = array();
    // deb($user->ID);exit();
    $GLOBALS['mypwp_temp_data']['mypwp_user']['ID'] = $user; 
    if($_POST['action'] && $_POST['action'] === 'UploadCagamasData'){
        require_once MYPLUGINWP_PATH . 'api/UploadCagamasData.php' ;
    }
    if($_POST['action'] && $_POST['action'] === 'ProsesCagamasData'){
        require_once MYPLUGINWP_PATH . 'api/ProsesCagamasData.php' ;
    }
    if($_POST['action'] && $_POST['action'] === 'ViewCagamasData'){
        require_once MYPLUGINWP_PATH . 'api/ViewCagamasData.php' ;
    }
    if($_POST['action'] && $_POST['action'] === 'ViewCagamasDataProses'){
        require_once MYPLUGINWP_PATH . 'api/ViewCagamasDataProses.php' ;
    }
    if($_POST['action'] && $_POST['action'] === 'ViewLPPSAData'){
        require_once MYPLUGINWP_PATH . 'api/ViewLPPSAData.php' ;
    }
    if($_POST['action'] && $_POST['action'] === 'ViewLPPSADataProses'){
        require_once MYPLUGINWP_PATH . 'api/ViewLPPSADataProses.php' ;
    }
    if($_POST['action'] && $_POST['action'] === 'ReconciledAccount'){
        require_once MYPLUGINWP_PATH . 'api/ReconciledAccount.php' ;
    }


    
    


    

    

    

    


    


    
 //http://demo.test/wp-json/api/v1/data
//  register_rest_route( 'api/v1', '/data', array(
    
    //http://demo.test/wp-json/jwt-auth/data
    // register_rest_route( 'jwt-auth', '/data', array(
    //     'methods' => 'POST',
    //     'callback' => 'mypwp_check_user_callback'
    // ));

    register_rest_route( 'api', '/data', array(
        'methods' => 'POST',
        'callback' => 'mypwp_check_user_callback'
    ));



}

function mypwp_check_user_callback(){
    return json_encode($GLOBALS['mypwp_temp_data']); 
    // return json_encode("salam"); 
}



  
?>