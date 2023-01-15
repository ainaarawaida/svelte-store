

<?php


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<?php wp_head(); ?>
	<link rel="stylesheet" id="css-main" href="<?php echo MYPLUGINWP_URL ; ?>/myapp/dist/assets/css/oneui.min.css">
  

<?php 
$files = array();
$files = glob(MYPLUGINWP_PATH . 'myapp/dist/assets/*.js');
$files2 = glob(MYPLUGINWP_PATH . 'myapp/dist/assets/vite/*.js');
$files3 = glob(MYPLUGINWP_PATH . 'myapp/dist/assets/src/*.js');
$files4 = glob(MYPLUGINWP_PATH . 'myapp/dist/assets/src/routes/*.js');
$allfile = array();
foreach($files AS $key => $val){
 
  $allfile[] = ["base" => basename($val) , "path" => "myapp/dist/assets/"] ; 
}
foreach($files2 AS $key => $val){
  $allfile[] = ["base" => basename($val) , "path" => "myapp/dist/assets/vite/"] ; 
}
foreach($files3 AS $key => $val){
  $allfile[] = ["base" => basename($val) , "path" => "myapp/dist/assets/src/"] ; 
}
foreach($files4 AS $key => $val){
  $allfile[] = ["base" => basename($val) , "path" => "myapp/dist/assets/src/routes/"] ; 
}
    
foreach ($allfile AS $key => $val){
  ?>
  <script type="module" crossorigin src="<?php echo MYPLUGINWP_URL.'/'.$val['path'] . $val['base'] ; ?>"></script>
  <?php	
}

?>
   <!-- <script type="module" crossorigin src="<?php echo MYPLUGINWP_URL ; ?>/myapp/dist/assets/vite/modulepreload-polyfill-ec808ebb.js"></script>
    <script type="module" crossorigin src="<?php echo MYPLUGINWP_URL ; ?>/myapp/dist/assets/vendor-cd22089b.js"></script>
    <script type="module" crossorigin src="<?php echo MYPLUGINWP_URL ; ?>/myapp/dist/assets/src/routes/Home-5773d8e2.js"></script>
    <script type="module" crossorigin src="<?php echo MYPLUGINWP_URL ; ?>/myapp/dist/assets/src/routes/About-8b1aea7d.js"></script>
    <script type="module" crossorigin src="<?php echo MYPLUGINWP_URL ; ?>/myapp/dist/assets/src/routes/Blog-7876c5cc.js"></script>
    <script type="module" crossorigin src="<?php echo MYPLUGINWP_URL ; ?>/myapp/dist/assets/src/routes/Aside-dc5d8041.js"></script>
    <script type="module" crossorigin src="<?php echo MYPLUGINWP_URL ; ?>/myapp/dist/assets/src/routes/Sidebar-b723b19b.js"></script>
    <script type="module" crossorigin src="<?php echo MYPLUGINWP_URL ; ?>/myapp/dist/assets/src/routes/Header-c2723796.js"></script>
    <script type="module" crossorigin src="<?php echo MYPLUGINWP_URL ; ?>/myapp/dist/assets/src/routes/Footer-36784853.js"></script>
    <script type="module" crossorigin src="<?php echo MYPLUGINWP_URL ; ?>/myapp/dist/assets/src/App-1fa84e94.js"></script>
    <script type="module" crossorigin src="<?php echo MYPLUGINWP_URL ; ?>/myapp/dist/assets/src/main-052cfacb.js"></script>
   -->


</head>
<body>

<?php wp_body_open(); ?>


  <body>



	<div id="appsvelte"></div>


    <!-- <script src="<?php echo MYPLUGINWP_URL ; ?>/myapp/dist/assets/js/oneui.app.min.js"></script> -->
    <!-- Page JS Plugins -->
    <!-- <script src="<?php echo MYPLUGINWP_URL ; ?>/myapp/dist/assets/js/plugins/chart.js/chart.min.js"></script> -->
    <!-- Page JS Code -->
    <!-- <script src="<?php echo MYPLUGINWP_URL ; ?>/myapp/dist/assets/js/pages/be_pages_dashboard.min.js"></script> -->



<?php
wp_footer();

?>

</body>
</html>


