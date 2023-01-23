<?php

//check if lppsa file already exist, if exist update 
$checklppsadata = $wpdb->get_results("SELECT  
a.ID, 
a.post_title,
b.display_name as created_by,
a.post_date as upload_date,
c.meta_value as lppsadatapool,
d.meta_value as cagamasfileid

 FROM {$wpdb->prefix}posts  a
 LEFT JOIN 
(SELECT ID,display_name FROM {$wpdb->prefix}users) b
ON a.post_author = b.ID 

 LEFT JOIN 
(SELECT post_id, meta_value FROM {$wpdb->prefix}postmeta WHERE meta_key = 'lppsadatapool') c
ON a.id = c.post_id 

LEFT JOIN 
(SELECT post_id, meta_value FROM {$wpdb->prefix}postmeta WHERE meta_key = 'cagamasfileid') d
ON a.id = d.post_id 

 WHERE a.post_type = 'lppsadata'
 AND d.meta_value = {$check} ");

$lppsadataid = "";
if($checklppsadata){
    $lppsadataid = $checklppsadata[0]->ID ; 

}
$dbhost = "10.23.205.237";
$dbuser = "bi_app";
$dbpass = "bi2020";
$dbname = "ripdbsp";
$myripdbsp = new wpdb($dbuser,$dbpass,$dbname,$dbhost);

$poollppsadata = array() ; 

$poollppsadata['filename'] = $_POST['cagamasdatafilename']  ;
$poollppsadata['pool'] = $_POST['cagamasdatapool'] ; 
$poollppsadata['author'] = $user->ID ; 
$cagamasfileid = $check ;
$poollppsadatarowdata = array();

switch ($_POST['lppsadatapool']) {
    case "POOL 3":
        $startdate = '20050831' ;
        break;
    case "POOL 4":
        $startdate = '20070131' ;
        break;
    case "POOL 5":
        $startdate = '20070228' ;
        break;
    case "POOL 6":
        $startdate = '20070731' ;
        break;
    case "POOL 7":
        $startdate = '20080531' ;
        break;
    case "POOL 8":
        $startdate = '20080531' ;
        break;
    case "POOL 9":
        $startdate = '20080731' ;
        break;
    case "POOL 10":
        $startdate = '20080731' ;
        break;
    case "POOL 11":
        $startdate = '20090131' ;
        break;
    case "POOL 12":
        $startdate = '20090131' ;
        break;
    case "POOL 13":
        $startdate = '20090531' ;
        break;
    case "POOL 14":
        $startdate = '20090531' ;
        break;
    case "POOL 15":
        $startdate = '20090831' ;
        break;
    case "POOL 16":
        $startdate = '20090831' ;
        break;
    case "POOL 17":
        $startdate = '20130930' ;
        break;
    case "POOL 18":
        $startdate = '20130930' ;
        break;
    case "POOL 1A":
        $startdate = '20170930' ;
        break;
    default:
        $startdate = '' ;
} 

if($startdate == ''){
    echo "error start date";
    exit();
}

$cagamasrowdata = json_decode(base64_decode($_POST['cagamasdataarraydata'])) ; 
// deb($_POST);exit();
$listaccount = array();
foreach($cagamasrowdata AS $key => $val){
    $portfoliono = $val->{'1'} ;
    $listaccount[$val->{'2'}] = $val->{'2'} ;
}
$kiradate = 0 ;
foreach($listaccount AS $key => $val){
        $bacarow[0] = trim($val);
        $strlength = strlen($bacarow[0]);
        $actnofiletype = substr($bacarow[0],-2,2);
        $actnofileyear = substr($bacarow[0],-6,4);
        $actnofileno = substr($bacarow[0],0,$strlength-6);
	    $fileno = $actnofileno."/".$actnofileyear."/".$actnofiletype ; 

		
        $data = $myripdbsp->get_results("SELECT actno FROM `clmr` WHERE trim(aano) = '".$fileno."' LIMIT 1");
        $actno = $data[0]->actno ;
        $data = $myripdbsp->get_results("SELECT txday FROM `clhtr` WHERE `actno` = '".$actno."' ORDER BY txday desc, id desc LIMIT 1");
        $getlastdate = $data[0]->txday ;
        $getlastdate = explode('-',$getlastdate) ;
        $enddate = $getlastdate[0].$getlastdate[1].$getlastdate[2] ; 
        $start    = new DateTime($startdate);
        $start->modify('first day of this month');
        $end      = new DateTime($enddate);
        $end->modify('first day of next month');
        $interval = DateInterval::createFromDateString('1 month');
        $period   = new DatePeriod($start, $interval, $end);

        foreach ($period as $dt) {
            $date = new DateTime($dt->format("Ymd"));
            $date->modify('last day of this month');
            $lastdayofthemonth = $date->format('Ymd');
            $currentmonth = $dt->format("Ym") ; 
            
            if($kiradate == 0){
                //opening balance
                $date = new DateTime($startdate); // For today/now, don't pass an arg.
                $date->modify("-3 day");
                $tarikh =  $date->format("Y-m-d H:i:s");
                $previousmonth = date('Ym', strtotime('-1 months', strtotime($tarikh))); 
                $previousdate = date('Ymd', strtotime('-1 months', strtotime($tarikh))); 
                $openingbalance = $myripdbsp->get_results("SELECT curbal FROM `clhtrsubs` WHERE `actno` = ".$actno." and DATE_FORMAT(txday, '%Y%m') = '".$previousmonth."' ORDER BY id desc limit 1");

                
                if(count($openingbalance) == 0){
                    $previousmonth = date('Ym', strtotime('-1 months', strtotime($previousdate))); 
                    $openingbalance = $myripdbsp->get_results("SELECT curbal FROM `clhtrsubs` WHERE `actno` = ".$actno." and DATE_FORMAT(txday, '%Y%m') = '".$previousmonth."' ORDER BY id desc limit 1");
                 
                    if(count($openingbalance) == 0){
                        $previousmonth = date('Ym', strtotime('-1 months', strtotime($previousdate))); 
                        $openingbalance = $myripdbsp->get_results("SELECT curbal FROM `clhtrsubs` WHERE `actno` = ".$actno." and DATE_FORMAT(txday, '%Y%m') = '".$previousmonth."' ORDER BY id desc limit 1");
                        
                        if(count($openingbalance) == 0){
                            $previousmonth = date('Ym', strtotime('-1 months', strtotime($previousdate))); 
                            $openingbalance = $myripdbsp->get_results("SELECT curbal FROM `clhtrsubs` WHERE `actno` = ".$actno." and DATE_FORMAT(txday, '%Y%m') = '".$previousmonth."' ORDER BY id desc limit 1");
                        }
                        
                    }
                    
                }
                    
                $openingbalance = $openingbalance[0]->curbal ;
                
                
            }else{
                $openingbalance = $openingbalance - $AMOUNT_PAID_MI_PRINCIPAL - $FULL_REDEMPTION_PRINCIPAL ;
            }
            
            //full redemption
            $dataredempt = $myripdbsp->get_results("SELECT txday, txamt, glcode FROM `clhtrsubs` where txcd = 'L40' AND code IN ('17') and actno = '".$actno."' ") ;
   
            $FULL_REDEMPTION_PRINCIPAL = 0;
              $statusfullredemption = false ;
                    foreach ($dataredempt as $dataredemptkey) {
                        if($currentmonth == substr($dataredemptkey->txday,0,6)){
                                $FULL_REDEMPTION_PRINCIPAL = $FULL_REDEMPTION_PRINCIPAL + $dataredemptkey->txamt ;
                                $statusfullredemption = true ;
                        }
                    }
               

            $data = $myripdbsp->get_results("SELECT curbal, txday, txcd,code,txamt FROM `clhtrsubs` WHERE `actno` = ".$actno." and DATE_FORMAT(txday, '%Y%m') = '".$currentmonth."' ") ;
            $count = 0 ; 
            $AMOUNT_PAID_MI_INT = 0 ; 
            $AMOUNT_PAID_MI_PRINCIPAL = 0 ; 
            $adjustment = 0 ;
            $FULL_REDEMPTION_OTHER_DEBIT = 0 ;
            $partial = 0 ;
            foreach ($data as $datarow) {
                if(trim($datarow->txcd) == 'L20' && trim($datarow->code) === '17'){
                    $AMOUNT_PAID_MI_PRINCIPAL = $AMOUNT_PAID_MI_PRINCIPAL + $datarow->txamt ; 
                }
                if(trim($datarow->txcd) == 'L29' && trim($datarow->code) === '16'){
                    $AMOUNT_PAID_MI_PRINCIPAL = $AMOUNT_PAID_MI_PRINCIPAL + $datarow->txamt ; 
                }
                if(trim($datarow->txcd) == 'L40' && trim($datarow->code) === '17'){
                    $AMOUNT_PAID_MI_PRINCIPAL = $AMOUNT_PAID_MI_PRINCIPAL + $datarow->txamt ; 
                }
                
                if(trim($datarow->txcd) == 'L20' && trim($datarow->code) === '16'){
                    $AMOUNT_PAID_MI_INT = $AMOUNT_PAID_MI_INT + $datarow->txamt ; 
                }
                if(trim($datarow->txcd) == 'L25' && trim($datarow->code) === '16'){
                        $AMOUNT_PAID_MI_INT = $AMOUNT_PAID_MI_INT + $datarow->txamt ; 
                }
                if(trim($datarow->txcd) == 'L40' && trim($datarow->code) === '16'){
                        $AMOUNT_PAID_MI_INT = $AMOUNT_PAID_MI_INT + $datarow->txamt ; 
                }
                
                if(trim($datarow->txcd) == 'L15' && trim($datarow->code) === '15'){
                    $adjustment = $adjustment + $datarow->txamt ; 
                }
                if(trim($datarow->txcd) == 'L25' && trim($datarow->code) === '17'){
                    $partial = $partial + $datarow->txamt ; 
                }
                
                //FULL REDEMPTION OTHER DEBIT 
                if($statusfullredemption == true){
                    if(trim($datarow->txcd) == 'L40' && trim($datarow->code) === '16'){
                        $FULL_REDEMPTION_OTHER_DEBIT =  $FULL_REDEMPTION_OTHER_DEBIT + $datarow->txamt ; 
                    }
                    if(trim($datarow->txcd) == 'L25' && trim($datarow->code) === '16'){
                        $FULL_REDEMPTION_OTHER_DEBIT =  $FULL_REDEMPTION_OTHER_DEBIT + $datarow->txamt ; 
                    }
                    
                }
            
                $count++;
            }
            
            $poollppsadatarowdata[] = [
                0 => $lastdayofthemonth,
                1 =>  $portfoliono,
                2 => trim($val),
                3 => max($openingbalance, 0),
                4 => $AMOUNT_PAID_MI_PRINCIPAL,
                5 => $AMOUNT_PAID_MI_INT,
                6 => '---',
                7 => $partial,
                8 => $FULL_REDEMPTION_PRINCIPAL,
                9 => $FULL_REDEMPTION_OTHER_DEBIT,
                10 => '---',
                11 => '---',
                12 => '---',
                13 => $adjustment,
                14 => '---',
                15 => '---',
                16 => '---',
                17 => '---',
                'key' =>  $kiradate

            ] ;
            
            // $poollppsadatarowdata[] = [
            //     'MONTHS' => $lastdayofthemonth,
            //     'PORTFOLIO NO.' =>  $portfoliono,
            //     'COMP FILE NUMBER' => trim($val),
            //     'OPENING PRINCIPAL BALANCE' => max($openingbalance, 0),
            //     'AMOUNT PAID MI PRINCIPAL' => $AMOUNT_PAID_MI_PRINCIPAL,
            //     'AMOUNT PAID MI INT' => $AMOUNT_PAID_MI_INT,
            //     'AMOUNT PAID MI COMP INT' => '---',
            //     'PARTIAL PREPAYMENT' => $partial,
            //     'FULL REDEMPTION PRINCIPAL' => $FULL_REDEMPTION_PRINCIPAL,
            //     'FULL REDEMPTION OTHER DEBIT' => $FULL_REDEMPTION_OTHER_DEBIT,
            //     'CREDIT ADJUSTMENT' => '---',
            //     'TOTAL AMOUNT PAID' => '---',
            //     'TOTAL AMOUNT DUE' => '---',
            //     'ADJUSTMENT' => $adjustment,
            //     'ADJUSTED BALANCE' => '---',
            //     'CLOSING PRINCIPAL BALANCE' => '---',
            //     'RENOVATION MI' => '---',
            //     'NET TOTAL AMOUNT PAID' => '---'

            // ] ;

            $kiradate ++;

            if($kiradate > 5)
                break;
            
        }

}

$args = array() ; 
$checkdata = get_post($lppsadataid);
$args = array(
    'ID' =>  $lppsadataid,
    'post_title' => esc_attr( $_POST['cagamasdatafilename'] ),
    'post_content' =>  serialize($poollppsadatarowdata) ,
    'post_author' => $user->ID ,
    'post_type' => 'lppsadata',
    'post_status' => 'publish',
    'post_parent' => '0'
);
if($checkdata){
  $check = wp_update_post( $args );
}else{
  $check = wp_insert_post( $args );
}
update_post_meta($check, 'lppsadatapool', $_POST['cagamasdatapool']) ; 
update_post_meta($check, 'cagamasfileid', $cagamasfileid) ; 




?>