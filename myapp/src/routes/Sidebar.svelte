<script>
  import { navigate, Router, Link, Route } from "svelte-navigator";
  import { Collapse, Button, Card } from "sveltestrap";
  let isOpen = false;
  let status = "Closed";

  import { globalHistory } from "svelte-navigator/src/history";
  let pathname = window.location.pathname;
  let unsub;
  import { getContext } from "svelte";
  import { onMount } from "svelte";
  import { onDestroy } from "svelte";
  import { data } from "./../store.js";

  let unsubscribe;
  let mylinkurl = getContext("mylinkurl");
  let mypluginurl = getContext("mypluginurl");
  let mybaseurl = getContext("mybaseurl");
  let menuclick;

  let khai_user = {
    data: {
      noKadPengenalanBaru: "",
    },
  };
  onMount(async () => {
    unsub = globalHistory.listen(({ location, action }) => {
      // console.log(location, action);
      pathname = location.pathname;
    });

    unsubscribe = data.subscribe((value) => {});

    menuclick = (e) => {
      // setTimeout(function () {
      //   let i = e.target.closest(".nav-main-item");
      //   console.log("iii", i.classList);
      //   i.classList.toggle("open");
      // }, 100);
    };
  });
  onDestroy(() => {
    unsub();
    unsubscribe;
  });

  // $: console.log("pathname", pathname);

  // $: console.log("sidebarkhai_user", khai_user.data.noKadPengenalanBaru);
</script>

<nav id="sidebar" aria-label="Main Navigation">
  <!-- Side Header -->
  <div class="content-header">
    <!-- Logo -->
    <a class="fw-semibold text-dual" href={mybaseurl}>
      <span class="smini-visible">
        <i class="fa fa-circle-notch text-primary" />
      </span>
      <span class="smini-hide fs-5 tracking-wider"
        >Sistem <span class="fw-normal">Khairat </span></span
      >
    </a>
    <!-- END Logo -->

    <!-- Extra -->
    <div>
      <!-- Dark Mode -->
      <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
      <button
        type="button"
        class="btn btn-sm btn-alt-secondary"
        data-toggle="layout"
        data-action="dark_mode_toggle"
      >
        <i class="far fa-moon" />
      </button>
      <!-- END Dark Mode -->

      <!-- Options -->
      <div class="dropdown d-inline-block ms-1">
        <button
          type="button"
          class="btn btn-sm btn-alt-secondary"
          id="sidebar-themes-dropdown"
          data-bs-toggle="dropdown"
          aria-haspopup="true"
          aria-expanded="false"
        >
          <i class="fa fa-brush" />
        </button>
        <div
          class="dropdown-menu dropdown-menu-end fs-sm smini-hide border-0"
          aria-labelledby="sidebar-themes-dropdown"
        >
          <!-- Color Themes -->
          <!-- Layout API, functionality initialized in Template._uiHandleTheme() -->
          <a
            class="dropdown-item d-flex align-items-center justify-content-between fw-medium"
            data-toggle="theme"
            data-theme="default"
            href="#"
          >
            <span>Default</span>
            <i class="fa fa-circle text-default" />
          </a>
          <a
            class="dropdown-item d-flex align-items-center justify-content-between fw-medium"
            data-toggle="theme"
            data-theme="{mypluginurl}/assets/css/themes/amethyst.min.css"
            href="#"
          >
            <span>Amethyst</span>
            <i class="fa fa-circle text-amethyst" />
          </a>
          <a
            class="dropdown-item d-flex align-items-center justify-content-between fw-medium"
            data-toggle="theme"
            data-theme="{mypluginurl}/assets/css/themes/city.min.css"
            href="#"
          >
            <span>City</span>
            <i class="fa fa-circle text-city" />
          </a>
          <a
            class="dropdown-item d-flex align-items-center justify-content-between fw-medium"
            data-toggle="theme"
            data-theme="{mypluginurl}/assets/css/themes/flat.min.css"
            href="#"
          >
            <span>Flat</span>
            <i class="fa fa-circle text-flat" />
          </a>
          <a
            class="dropdown-item d-flex align-items-center justify-content-between fw-medium"
            data-toggle="theme"
            data-theme="{mypluginurl}/assets/css/themes/modern.min.css"
            href="#"
          >
            <span>Modern</span>
            <i class="fa fa-circle text-modern" />
          </a>
          <a
            class="dropdown-item d-flex align-items-center justify-content-between fw-medium"
            data-toggle="theme"
            data-theme="{mypluginurl}/assets/css/themes/smooth.min.css"
            href="#"
          >
            <span>Smooth</span>
            <i class="fa fa-circle text-smooth" />
          </a>
          <!-- END Color Themes -->

          <div class="dropdown-divider" />

          <!-- Sidebar Styles -->
          <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
          <a
            class="dropdown-item fw-medium"
            data-toggle="layout"
            data-action="sidebar_style_light"
            href="javascript:void(0)"
          >
            <span>Sidebar Light</span>
          </a>
          <a
            class="dropdown-item fw-medium"
            data-toggle="layout"
            data-action="sidebar_style_dark"
            href="javascript:void(0)"
          >
            <span>Sidebar Dark</span>
          </a>
          <!-- END Sidebar Styles -->

          <div class="dropdown-divider" />

          <!-- Header Styles -->
          <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
          <a
            class="dropdown-item fw-medium"
            data-toggle="layout"
            data-action="header_style_light"
            href="javascript:void(0)"
          >
            <span>Header Light</span>
          </a>
          <a
            class="dropdown-item fw-medium"
            data-toggle="layout"
            data-action="header_style_dark"
            href="javascript:void(0)"
          >
            <span>Header Dark</span>
          </a>
          <!-- END Header Styles -->
        </div>
      </div>
      <!-- END Options -->

      <!-- Close Sidebar, Visible only on mobile screens -->
      <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
      <a
        class="d-lg-none btn btn-sm btn-alt-secondary ms-1"
        data-toggle="layout"
        data-action="sidebar_close"
        href="javascript:void(0)"
      >
        <i class="fa fa-fw fa-times" />
      </a>
      <!-- END Close Sidebar -->
    </div>
    <!-- END Extra -->
  </div>
  <!-- END Side Header -->
  <!-- {pathname} || {mylinkurl} my-account/maklumatKariah -->
  <!-- Sidebar Scrolling -->
  <div class="js-sidebar-scroll">
    <!-- Side Navigation -->
    <div class="content-side">
      <ul class="nav-main">
        {#if khai_user.data.stage_daftar == "0"}
          <li class="nav-main-heading">Daftar Kariah</li>
          <li class="nav-main-item">
            <Link
              class="nav-main-link {pathname.includes('maklumatKariah')
                ? `active`
                : ``}"
              data-toggle="submenu"
              aria-haspopup="true"
              aria-expanded="false"
              to={mylinkurl + "my-account/maklumatKariah"}
            >
              <i class="nav-main-link-icon si si-energy" />
              <span class="nav-main-link-name">Maklumat Kariah</span>
            </Link>
          </li>
        {:else if khai_user.data.stage_daftar == "1" && khai_user.data.noKadPengenalanBaru == ""}
          <li class="nav-main-item">
            <Link
              class="nav-main-link {pathname.includes('maklumatProfil')
                ? `active`
                : ``}"
              data-toggle="submenu"
              aria-haspopup="true"
              aria-expanded="false"
              to={mylinkurl + "my-account/maklumatProfil"}
            >
              <i class="nav-main-link-icon si si-cup" />
              <span class="nav-main-link-name">Maklumat Profil</span>
            </Link>
          </li>
        {:else}
          <li class="nav-main-heading">Core</li>
          <li class="nav-main-item">
            <Link
              class="nav-main-link {pathname == mylinkurl + 'my-account'
                ? `active`
                : ``}"
              to={mylinkurl + "my-account"}
              ><i class="nav-main-link-icon si si-magic-wand" />
              <span class="nav-main-link-name">Dashboard</span></Link
            >
          </li>

          <li class="nav-main-item" on:click={(e) => menuclick(e)}>
            <a
              class="nav-main-link nav-main-link-submenu"
              data-toggle="submenu"
              aria-haspopup="true"
              aria-expanded="false"
              href="#"
            >
              <i class="nav-main-link-icon si si-energy" />
              <span class="nav-main-link-name">Ahli Khairat</span>
            </a>
            <ul class="nav-main-submenu">
              <li class="nav-main-item">
                <Link
                  class="nav-main-link {pathname ==
                  mylinkurl + 'my-account/senaraiAhli'
                    ? `active`
                    : ``}"
                  to={mylinkurl + "my-account/senaraiAhli"}
                  ><i class="nav-main-link-icon si si-wrench" />
                  <span class="nav-main-link-name">Senarai Ahli</span></Link
                >
              </li>
              <li class="nav-main-item">
                <Link
                  class="nav-main-link {pathname ==
                  mylinkurl + 'my-account/daftarAhli'
                    ? `active`
                    : ``}"
                  to={mylinkurl + "my-account/daftarAhli"}
                  ><i class="nav-main-link-icon si si-speedometer" />
                  <span class="nav-main-link-name">Daftar Ahli</span></Link
                >
              </li>
            </ul>
          </li>

          <!-- <li class="nav-main-item">
            <Link
              class="nav-main-link active"
              to={mylinkurl + "my-account/about"}
              ><i class="nav-main-link-icon si si-note" />
              <span class="nav-main-link-name">About</span></Link
            >
          </li>
          <li class="nav-main-item">
            <Link
              class="nav-main-link active"
              to={mylinkurl + "my-account/blog"}
              ><i class="nav-main-link-icon si si-grid" />
              <span class="nav-main-link-name">Blog</span></Link
            >
          </li>

          <li class="nav-main-item">
            <a class="nav-main-link active" href="be_pages_dashboard.html">
              <i class="nav-main-link-icon si si-badge" />
              <span class="nav-main-link-name">Dashboard</span>
            </a>
          </li> -->
          <li class="nav-main-heading">Konfigurasi</li>
          <li class="nav-main-item">
            <Link
              class="nav-main-link {pathname ==
              mylinkurl + 'my-account/maklumatKariah'
                ? `active`
                : ``}"
              to={mylinkurl + "my-account/maklumatKariah"}
              ><i class="nav-main-link-icon si si-trophy" />
              <span class="nav-main-link-name">Maklumat Kariah</span></Link
            >
          </li>

          <li class="nav-main-item" on:click={(e) => menuclick(e)}>
            <a
              class="nav-main-link nav-main-link-submenu"
              data-toggle="submenu"
              aria-haspopup="true"
              aria-expanded="false"
              href="#"
            >
              <i class="nav-main-link-icon si si-energy" />
              <span class="nav-main-link-name">Yuran</span>
            </a>
            <ul class="nav-main-submenu">
              <li class="nav-main-item">
                <Link
                  class="nav-main-link {pathname ==
                  mylinkurl + 'my-account/jenisYuran'
                    ? `active`
                    : ``}"
                  to={mylinkurl + "my-account/jenisYuran"}
                  ><i class="nav-main-link-icon si si-wrench" />
                  <span class="nav-main-link-name">Jenis Yuran</span></Link
                >
              </li>
              <li class="nav-main-item">
                <Link
                  class="nav-main-link {pathname ==
                  mylinkurl + 'my-account/tambahJenisYuran'
                    ? `active`
                    : ``}"
                  to={mylinkurl + "my-account/tambahJenisYuran"}
                  ><i class="nav-main-link-icon si si-speedometer" />
                  <span class="nav-main-link-name">Tambah Jenis Yuran</span
                  ></Link
                >
              </li>
            </ul>
          </li>
        {/if}

        <li class="nav-main-item">
          <Link
            class="nav-main-link {pathname == mylinkurl + 'my-account/test'
              ? `active`
              : ``}"
            to={mylinkurl + "my-account/test"}
            ><i class="nav-main-link-icon si si-trophy" />
            <span class="nav-main-link-name">Test</span></Link
          >
        </li>
      </ul>
    </div>
    <!-- END Side Navigation -->
  </div>
  <!-- END Sidebar Scrolling -->
</nav>
<!-- END Sidebar -->
