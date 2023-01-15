

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
   
    <link rel="stylesheet" id="css-main" href="<?php echo MYPLUGINWP_URL ; ?>/public/partials/assets/css/oneui.min.css">

  

</head>
<body>

<?php wp_body_open(); ?>


  <body>



	       <div id="page-container" class="sidebar-dark side-scroll page-header-fixed page-header-dark main-content-boxed">

      <nav id="sidebar" aria-label="Main Navigation">
        <!-- Side Header -->
        <div class="content-header bg-white-5">
          <!-- Logo -->
          <a class="fw-semibold text-dual" href="/">
            <span class="smini-visible">
              <i class="fa fa-circle-notch text-primary"></i>
            </span>
            <span class="smini-hide fs-5 tracking-wider">
              Sistem <span class="fw-normal">Khairat</span>
            </span>
          </a>
          <!-- END Logo -->

          <!-- Extra -->
          <div>
            <!-- Options -->
            <div class="dropdown d-inline-block ms-1">
              <button type="button" class="btn btn-sm btn-alt-secondary" id="sidebar-themes-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-brush"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-end fs-sm smini-hide border-0" aria-labelledby="sidebar-themes-dropdown">
                <!-- Color Themes -->
                <!-- Layout API, functionality initialized in Template._uiHandleTheme() -->
                <a class="dropdown-item d-flex align-items-center justify-content-between fw-medium" data-toggle="theme" data-theme="default" href="#">
                  <span>Default</span>
                  <i class="fa fa-circle text-default"></i>
                </a>
                <a class="dropdown-item d-flex align-items-center justify-content-between fw-medium" data-toggle="theme" data-theme="<?php echo MYPLUGINWP_URL ; ?>/public/partials/assets/css/themes/amethyst.min.css" href="#">
                  <span>Amethyst</span>
                  <i class="fa fa-circle text-amethyst"></i>
                </a>
                <a class="dropdown-item d-flex align-items-center justify-content-between fw-medium" data-toggle="theme" data-theme="<?php echo MYPLUGINWP_URL ; ?>/public/partials/assets/css/themes/city.min.css" href="#">
                  <span>City</span>
                  <i class="fa fa-circle text-city"></i>
                </a>
                <a class="dropdown-item d-flex align-items-center justify-content-between fw-medium" data-toggle="theme" data-theme="<?php echo MYPLUGINWP_URL ; ?>/public/partials/assets/css/themes/flat.min.css" href="#">
                  <span>Flat</span>
                  <i class="fa fa-circle text-flat"></i>
                </a>
                <a class="dropdown-item d-flex align-items-center justify-content-between fw-medium" data-toggle="theme" data-theme="<?php echo MYPLUGINWP_URL ; ?>/public/partials/assets/css/themes/modern.min.css" href="#">
                  <span>Modern</span>
                  <i class="fa fa-circle text-modern"></i>
                </a>
                <a class="dropdown-item d-flex align-items-center justify-content-between fw-medium" data-toggle="theme" data-theme="<?php echo MYPLUGINWP_URL ; ?>/public/partials/assets/css/themes/smooth.min.css" href="#">
                  <span>Smooth</span>
                  <i class="fa fa-circle text-smooth"></i>
                </a>
                <!-- END Color Themes -->
              </div>
            </div>
            <!-- END Options -->

            <!-- Close Sidebar, Visible only on mobile screens -->
            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
            <a class="d-lg-none btn btn-sm btn-alt-secondary ms-1" data-toggle="layout" data-action="sidebar_close" href="javascript:void(0)">
              <i class="fa fa-fw fa-times"></i>
            </a>
            <!-- END Close Sidebar -->
          </div>
          <!-- END Extra -->
        </div>
        <!-- END Side Header -->

        <!-- Sidebar Scrolling -->
        <div class="js-sidebar-scroll">
          <!-- Side Navigation -->
          <div class="content-side">
            <ul class="nav-main">
              <li class="nav-main-item">
                <a class="nav-main-link active" href="<?php echo home_url() ; ?>">
                  <i class="nav-main-link-icon si si-home"></i>
                  <span class="nav-main-link-name">Home</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="javascript:void(0)">
                  <i class="nav-main-link-icon si si-rocket"></i>
                  <span class="nav-main-link-name">Features</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="javascript:void(0)">
                  <i class="nav-main-link-icon si si-wallet"></i>
                  <span class="nav-main-link-name">Pricing</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a class="nav-main-link" href="javascript:void(0)">
                  <i class="nav-main-link-icon si si-envelope"></i>
                  <span class="nav-main-link-name">Contact</span>
                </a>
              </li>
            </ul>
          </div>
          <!-- END Side Navigation -->
        </div>
        <!-- END Sidebar Scrolling -->
      </nav>
      <!-- END Sidebar -->

      <!-- Header -->
      <header id="page-header">
        <!-- Header Content -->
        <div class="content-header">
          <!-- Left Section -->
          <div class="d-flex align-items-center">
            <!-- Logo -->
            <a class="fw-semibold fs-5 tracking-wider text-dual me-3" href="/">
              Sistem <span class="fw-normal">Khairat</span>
            </a>
            <!-- END Logo -->
          </div>
          <!-- END Left Section -->

          <!-- Right Section -->
          <div class="d-flex align-items-center">
            <!-- Menu -->
            <div class="d-none d-lg-block">
              <ul class="nav-main nav-main-horizontal nav-main-hover">
                <li class="nav-main-item">
                  <a class="nav-main-link active" href="<?php echo home_url() ; ?>">
                    <i class="nav-main-link-icon si si-home"></i>
                    <span class="nav-main-link-name">Home</span>
                  </a>
                </li>
                 <li class="nav-main-item">
                  <a class="nav-main-link active" href="<?php echo home_url('wp-admin') ; ?>">
                    <i class="nav-main-link-icon si si-login"></i> 
                    <span class="nav-main-link-name">Login</span>
                  </a>
                </li>

                <!-- <li class="nav-main-item">
                  <a class="nav-main-link" href="javascript:void(0)">
                    <i class="nav-main-link-icon si si-rocket"></i>
                    <span class="nav-main-link-name">Features</span>
                  </a>
                </li>
                <li class="nav-main-item">
                  <a class="nav-main-link" href="javascript:void(0)">
                    <i class="nav-main-link-icon si si-wallet"></i>
                    <span class="nav-main-link-name">Pricing</span>
                  </a>
                </li>
                <li class="nav-main-item">
                  <a class="nav-main-link" href="javascript:void(0)">
                    <i class="nav-main-link-icon si si-envelope"></i>
                    <span class="nav-main-link-name">Contact</span>
                  </a>
                </li> -->
                <li class="nav-main-heading">Extra</li>
                <li class="nav-main-item">
                  <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                    <i class="nav-main-link-icon fa fa-brush"></i>
                  </a>
                  <ul class="nav-main-submenu nav-main-submenu-right">
                    <li class="nav-main-item">
                      <a class="nav-main-link" data-toggle="theme" data-theme="default" href="#">
                        <i class="nav-main-link-icon fa fa-square text-default"></i>
                        <span class="nav-main-link-name">Default</span>
                      </a>
                    </li>
                    <li class="nav-main-item">
                      <a class="nav-main-link" data-toggle="theme" data-theme="<?php echo MYPLUGINWP_URL ; ?>/public/partials/assets/css/themes/amethyst.min.css" href="#">
                        <i class="nav-main-link-icon fa fa-square text-amethyst"></i>
                        <span class="nav-main-link-name">Amethyst</span>
                      </a>
                    </li>
                    <li class="nav-main-item">
                      <a class="nav-main-link" data-toggle="theme" data-theme="<?php echo MYPLUGINWP_URL ; ?>/public/partials/assets/css/themes/city.min.css" href="#">
                        <i class="nav-main-link-icon fa fa-square text-city"></i>
                        <span class="nav-main-link-name">City</span>
                      </a>
                    </li>
                    <li class="nav-main-item">
                      <a class="nav-main-link" data-toggle="theme" data-theme="<?php echo MYPLUGINWP_URL ; ?>/public/partials/assets/css/themes/flat.min.css" href="#">
                        <i class="nav-main-link-icon fa fa-square text-flat"></i>
                        <span class="nav-main-link-name">Flat</span>
                      </a>
                    </li>
                    <li class="nav-main-item">
                      <a class="nav-main-link" data-toggle="theme" data-theme="<?php echo MYPLUGINWP_URL ; ?>/public/partials/assets/css/themes/modern.min.css" href="#">
                        <i class="nav-main-link-icon fa fa-square text-modern"></i>
                        <span class="nav-main-link-name">Modern</span>
                      </a>
                    </li>
                    <li class="nav-main-item">
                      <a class="nav-main-link" data-toggle="theme" data-theme="<?php echo MYPLUGINWP_URL ; ?>/public/partials/assets/css/themes/smooth.min.css" href="#">
                        <i class="nav-main-link-icon fa fa-square text-smooth"></i>
                        <span class="nav-main-link-name">Smooth</span>
                      </a>
                    </li>
                  </ul>
                </li>
              </ul>
            </div>
            <!-- END Menu -->

            <!-- Toggle Sidebar -->
            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
            <button type="button" class="btn btn-sm btn-alt-secondary d-lg-none ms-1" data-toggle="layout" data-action="sidebar_toggle">
              <i class="fa fa-fw fa-bars"></i>
            </button>
            <!-- END Toggle Sidebar -->
          </div>
          <!-- END Right Section -->
        </div>
        <!-- END Header Content -->

        <!-- Header Search -->
        <div id="page-header-search" class="overlay-header bg-body-extra-light">
          <div class="content-header">
            <form class="w-100" method="POST">
              <div class="input-group input-group-sm">
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <button type="button" class="btn btn-alt-danger" data-toggle="layout" data-action="header_search_off">
                  <i class="fa fa-fw fa-times-circle"></i>
                </button>
                <input type="text" class="form-control" placeholder="Search or hit ESC.." id="page-header-search-input" name="page-header-search-input">
              </div>
            </form>
          </div>
        </div>
        <!-- END Header Search -->

        <!-- Header Loader -->
        <!-- Please check out the Loaders page under Components category to see examples of showing/hiding it -->
        <div id="page-header-loader" class="overlay-header bg-primary-lighter">
          <div class="content-header">
            <div class="w-100 text-center">
              <i class="fa fa-fw fa-circle-notch fa-spin text-primary"></i>
            </div>
          </div>
        </div>
        <!-- END Header Loader -->
      </header>
      <!-- END Header -->

      <!-- Main Container -->
      <main id="main-container">
        <div class="bg-body-extra-light">
            <div class="content content-full">
             <?php  
		  
                    if ( have_posts() ) :
                while ( have_posts() ) : the_post(); ?>

                    <?php the_content() ?>
                
                <?php endwhile;

            else :
                echo '<p>There are no posts!</p>';

            endif;

            ?>
        </div></div>
      
       
      </main>
      <!-- END Main Container -->

      <!-- Footer -->
      <footer id="page-footer" class="bg-body-extra-light">
        <div class="content py-4">
          

          <!-- Footer Copyright -->
          <div class="row fs-sm pt-4">
            <div class="col-sm-6 order-sm-2 py-1 text-center text-sm-end">
              Crafted with <i class="fa fa-heart text-danger"></i> by <a class="fw-semibold" href="https://1.envato.market/ydb" target="_blank">4in44.com</a>
            </div>
            <div class="col-sm-6 order-sm-1 py-1 text-center text-sm-start">
              <a class="fw-semibold" href="#" target="_blank">Sistem Khairat</a> &copy; <span data-toggle="year-copy"></span>
            </div>
          </div>
          <!-- END Footer Copyright -->
        </div>
      </footer>
      <!-- END Footer -->
    </div>
    <!-- END Page Container -->


    <script src="<?php echo MYPLUGINWP_URL ; ?>/public/partials/assets/js/oneui.app.min.js"></script>
    <!-- Page JS Plugins -->
    <script src="<?php echo MYPLUGINWP_URL ; ?>/public/partials/assets/js/plugins/chart.js/chart.min.js"></script>
    <!-- Page JS Code -->
    <script src="<?php echo MYPLUGINWP_URL ; ?>/public/partials/assets/js/pages/be_pages_dashboard.min.js"></script>



<?php
wp_footer();

?>

</body>
</html>


