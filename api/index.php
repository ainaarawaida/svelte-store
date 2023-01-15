<?php

add_action( 'rest_api_init', 'mypwp_check_user');
function mypwp_check_user(){
   
    global $wpdb ; 

    // deb($_SERVER);exit();
    
    $GLOBALS['mypwp_temp_data']['mypwp_user'] = wp_get_current_user(); //<- production

    
  
    // // $GLOBALS['mypwp_temp_data']['mypwp_user'] =  get_user_by( 'id', 77 ); // development
    // $GLOBALS['mypwp_temp_data']['mypwp_user'] =  get_user_by( 'id', 3 ); // admin
    // $GLOBALS['mypwp_temp_data']['mypwp_user']->role = get_user_meta( $GLOBALS['mypwp_temp_data']['mypwp_user']->ID, 'role', true ) ;
    // $GLOBALS['mypwp_temp_data']['mypwp_user']->stage_daftar = get_user_meta( $GLOBALS['mypwp_temp_data']['mypwp_user']->ID, 'stage_daftar', true ) ;
    // $GLOBALS['mypwp_temp_data']['mypwp_user']->kariah_id = get_user_meta( $GLOBALS['mypwp_temp_data']['mypwp_user']->ID, 'kariah_id', true ) ;
    // $GLOBALS['mypwp_temp_data']['mypwp_user']->noKadPengenalanBaru = get_user_meta( $GLOBALS['mypwp_temp_data']['mypwp_user']->ID, 'noKadPengenalanBaru', true ) ;
    // $GLOBALS['mypwp_temp_data']['mypwp_user']->nomborTelefon = get_user_meta( $GLOBALS['mypwp_temp_data']['mypwp_user']->ID, 'nomborTelefon', true ) ;
    // $GLOBALS['mypwp_temp_data']['mypwp_user']->pakej = get_user_meta( $GLOBALS['mypwp_temp_data']['mypwp_user']->ID, 'pakej', true ) ;
    
    if($GLOBALS['mypwp_temp_data']['mypwp_user']->kariah_id){
        $GLOBALS['mypwp_temp_data']['mypwp_user']->namaKariah = get_post($GLOBALS['mypwp_temp_data']['mypwp_user']->kariah_id )->post_title;
        $GLOBALS['mypwp_temp_data']['mypwp_user']->alamatKariah = get_post_meta(  $GLOBALS['mypwp_temp_data']['mypwp_user']->kariah_id, 'alamatKariah', true ) ;
        $GLOBALS['mypwp_temp_data']['mypwp_user']->sitePageUrl = get_post($GLOBALS['mypwp_temp_data']['mypwp_user']->kariah_id )->post_name;
    }
    

  

    if($_POST['action'] && $_POST['action'] === 'MaklumatProfil'){
        require_once mypwp_PATH . '/public/api/MaklumatProfil.php' ;
    }
    else if($_POST['action'] && $_POST['action'] === 'Dashboard'){
        require_once mypwp_PATH . '/public/api/Dashboard.php' ;
    }
    else if($_POST['action'] && $_POST['action'] === 'MaklumatKariah'){
        require_once mypwp_PATH . '/public/api/MaklumatKariah.php' ;
    }
    else if($_POST['action'] && $_POST['action'] === 'SenaraiAhli'){
        require_once mypwp_PATH . '/public/api/SenaraiAhli.php' ;
    }
    else if($_POST['action'] && $_POST['action'] === 'TidakAktifAhli'){
        require_once mypwp_PATH . '/public/api/TidakAktifAhli.php' ;
    }
    else if($_POST['action'] && $_POST['action'] === 'DeleteAhli'){
        require_once mypwp_PATH . '/public/api/DeleteAhli.php' ;
    }
    else if($_POST['action'] && $_POST['action'] === 'SenaraiAhliTidakAktif'){
        require_once mypwp_PATH . '/public/api/SenaraiAhliTidakAktif.php' ;
    }
    else if($_POST['action'] && $_POST['action'] === 'DaftarAhli'){
        require_once mypwp_PATH . '/public/api/DaftarAhli.php' ;
    }
    else if($_POST['action'] && $_POST['action'] === 'KemaskiniAhli'){
        require_once mypwp_PATH . '/public/api/KemaskiniAhli.php' ;
    }
     else if($_POST['action'] && $_POST['action'] === 'UserKemaskiniAhli'){
        require_once mypwp_PATH . '/public/api/UserKemaskiniAhli.php' ;
    }
    else if($_POST['action'] && $_POST['action'] === 'TambahAhliTanggungan'){
        require_once mypwp_PATH . '/public/api/TambahAhliTanggungan.php' ;
    }
     else if($_POST['action'] && $_POST['action'] === 'UserTambahAhliTanggungan'){
        require_once mypwp_PATH . '/public/api/UserTambahAhliTanggungan.php' ;
    }
    else if($_POST['action'] && $_POST['action'] === 'KemaskiniAhliTanggungan'){
        require_once mypwp_PATH . '/public/api/KemaskiniAhliTanggungan.php' ;
    }
    else if($_POST['action'] && $_POST['action'] === 'UserKemaskiniAhliTanggungan'){
        require_once mypwp_PATH . '/public/api/UserKemaskiniAhliTanggungan.php' ;
    }
    else if($_POST['action'] && $_POST['action'] === 'DeleteTanggungan'){
        require_once mypwp_PATH . '/public/api/DeleteTanggungan.php' ;
    } 
    else if($_POST['action'] && $_POST['action'] === 'UserDeleteTanggungan'){
        require_once mypwp_PATH . '/public/api/UserDeleteTanggungan.php' ;
    } 
    else if($_POST['action'] && $_POST['action'] === 'JenisYuran'){
        require_once mypwp_PATH . '/public/api/JenisYuran.php' ;
    }
    else if($_POST['action'] && $_POST['action'] === 'TambahJenisYuran'){
        require_once mypwp_PATH . '/public/api/TambahJenisYuran.php' ;
    }
    else if($_POST['action'] && $_POST['action'] === 'KemaskiniJenisYuran'){
        require_once mypwp_PATH . '/public/api/KemaskiniJenisYuran.php' ;
    }
    else if($_POST['action'] && $_POST['action'] === 'DeleteJenisYuran'){
        require_once mypwp_PATH . '/public/api/DeleteJenisYuran.php' ;
    }
     else if($_POST['action'] && $_POST['action'] === 'GenerateYuran'){
        require_once mypwp_PATH . '/public/api/GenerateYuran.php' ;
    }
     else if($_POST['action'] && $_POST['action'] === 'KemaskiniAhliMaklumatBayaranAhli'){
        require_once mypwp_PATH . '/public/api/KemaskiniAhliMaklumatBayaranAhli.php' ;
    }
    else if($_POST['action'] && $_POST['action'] === 'KemaskiniAhliTerimaSumbangan'){
        require_once mypwp_PATH . '/public/api/KemaskiniAhliTerimaSumbangan.php' ;
    }
    else if($_POST['action'] && $_POST['action'] === 'DeleteTerimaSumbangan'){
        require_once mypwp_PATH . '/public/api/DeleteTerimaSumbangan.php' ;
    }
    else if($_POST['action'] && $_POST['action'] === 'TambahTerimaSumbangan'){
        require_once mypwp_PATH . '/public/api/TambahTerimaSumbangan.php' ;
    }
    else if($_POST['action'] && $_POST['action'] === 'TambahMuatnaikDokumen'){
        require_once mypwp_PATH . '/public/api/TambahMuatnaikDokumen.php' ;
    }
     else if($_POST['action'] && $_POST['action'] === 'KemaskiniAhliMuatnaikDokumen'){
        require_once mypwp_PATH . '/public/api/KemaskiniAhliMuatnaikDokumen.php' ;
    }
     else if($_POST['action'] && $_POST['action'] === 'DeleteMuatnaikDokumen'){
        require_once mypwp_PATH . '/public/api/DeleteMuatnaikDokumen.php' ;
    }
     else if($_POST['action'] && $_POST['action'] === 'PilihPakej'){
        require_once mypwp_PATH . '/public/api/PilihPakej.php' ;
    }
     else if($_POST['action'] && $_POST['action'] === 'UserKemaskiniAhliMaklumatBayaranAhli'){
        require_once mypwp_PATH . '/public/api/UserKemaskiniAhliMaklumatBayaranAhli.php' ;
    }
     else if($_POST['action'] && $_POST['action'] === 'UserKemaskiniAhliTerimaSumbangan'){
        require_once mypwp_PATH . '/public/api/UserKemaskiniAhliTerimaSumbangan.php' ;
    }
    else if($_POST['action'] && $_POST['action'] === 'UserKhairat'){
        require_once mypwp_PATH . '/public/api/UserKhairat.php' ;
    }
     else if($_POST['action'] && $_POST['action'] === 'KemaskiniAhliPakejYuran'){
        require_once mypwp_PATH . '/public/api/KemaskiniAhliPakejYuran.php' ;
    }
    else if($_POST['action'] && $_POST['action'] === 'SemakanAdmin'){
        require_once mypwp_PATH . '/public/api/SemakanAdmin.php' ;
    }


       
   


    

    

    

    


    


    

    

    //http://demo.test/wp-json/api/v1/data
    register_rest_route( 'api/v1', '/data', array(
        'methods' => 'POST',
        'callback' => 'mypwp_check_user_callback'
    ));



}

function mypwp_check_user_callback(){
    return json_encode($GLOBALS['mypwp_temp_data']); 
}

?>