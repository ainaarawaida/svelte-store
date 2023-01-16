<script>
  import { navigate, Router, Link, Route } from "svelte-navigator";
  import { getContext } from "svelte";
  import { onMount } from "svelte";
  import { onDestroy } from "svelte";
  import { data } from "./../store.js";
  import { loadScript } from "./../document.js";
  import { beforeUpdate, afterUpdate } from "svelte";
  let mypluginurl = getContext("mypluginurl");
  let mybaseurl = getContext("mybaseurl");
  let mylinkurl = getContext("mylinkurl");
  let unsubscribe;
  let khai_user = {
    data: {
      display_name: "",
    },
  };
  let _data;

  data.update((currentPolls) => {
    _data = currentPolls;
    return currentPolls;
  });

  onMount(async () => {
    unsubscribe = data.subscribe((value) => {});
    // setTimeout(async () => {
    await loadScript(`${mypluginurl}/assets/js/oneui.app.min.js`);
    console.log("oneui.app.min.js");
    // }, 1000);
  });
  onDestroy(() => {
    unsubscribe;
  });

  afterUpdate(async () => {
    // ...the DOM is now in sync with the data
    // if (_data.loading == false) {
    //   // setTimeout(async () => {
    //   console.log("load oneui.app.min.js");
    //   await loadScript(`${mypluginurl}/assets/js/oneui.app.min.js`);
    //   // }, 2000);
    // }
  });

  const logout = async (ele) => {
    data.update((currentPolls) => {
      _data.user = {};
      localStorage.setItem("_data", JSON.stringify(_data));
      return currentPolls;
    });
    navigate(mylinkurl + "/mylogin");
    location.reload();
  };
</script>

<!-- Header -->
<header id="page-header">
  <!-- Header Content -->
  <div class="content-header">
    <!-- Left Section -->
    <div class="d-flex align-items-center">
      <!-- Toggle Sidebar -->
      <!-- Layout API, functionality initialized in Template._uiApiLayout()-->
      <button
        type="button"
        class="btn btn-sm btn-alt-secondary me-2 d-lg-none"
        data-toggle="layout"
        data-action="sidebar_toggle"
      >
        <i class="fa fa-fw fa-bars" />
      </button>
      <!-- END Toggle Sidebar -->

      <!-- Toggle Mini Sidebar -->
      <!-- Layout API, functionality initialized in Template._uiApiLayout()-->
      <button
        type="button"
        class="btn btn-sm btn-alt-secondary me-2 d-none d-lg-inline-block"
        data-toggle="layout"
        data-action="sidebar_mini_toggle"
      >
        <i class="fa fa-fw fa-ellipsis-v" />
      </button>
      <!-- END Toggle Mini Sidebar -->

      <!-- Open Search Section (visible on smaller screens) -->
      <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
      <button
        type="button"
        class="btn btn-sm btn-alt-secondary d-md-none"
        data-toggle="layout"
        data-action="header_search_on"
      >
        <i class="fa fa-fw fa-search" />
      </button>
      <!-- END Open Search Section -->

      <!-- Search Form (visible on larger screens) -->
      <!-- <form
        class="d-none d-md-inline-block"
        action="be_pages_generic_search.html"
        method="POST"
      >
        <div class="input-group input-group-sm">
          <input
            type="text"
            class="form-control form-control-alt"
            placeholder="Search.."
            id="page-header-search-input2"
            name="page-header-search-input2"
          />
          <span class="input-group-text border-0">
            <i class="fa fa-fw fa-search" />
          </span>
        </div>
      </form> -->
      <!-- END Search Form -->
    </div>
    <!-- END Left Section -->

    <!-- Right Section -->
    <div class="d-flex align-items-center">
      <!-- User Dropdown -->
      <div class="dropdown d-inline-block ms-2">
        <button
          type="button"
          class="btn btn-sm btn-alt-secondary d-flex align-items-center"
          id="page-header-user-dropdown"
          data-bs-toggle="dropdown"
          aria-haspopup="true"
          aria-expanded="false"
        >
          <img
            class="rounded-circle"
            src={mypluginurl + "/assets/media/avatars/avatar10.jpg"}
            alt="Header Avatar"
            style="width: 21px;"
          />
          <span class="d-none d-sm-inline-block ms-2"
            >{khai_user.data.display_name}</span
          >
          <i
            class="fa fa-fw fa-angle-down d-none d-sm-inline-block opacity-50 ms-1 mt-1"
          />
        </button>
        <div
          class="dropdown-menu dropdown-menu-md dropdown-menu-end p-0 border-0"
          aria-labelledby="page-header-user-dropdown"
        >
          <div class="p-3 text-center bg-body-light border-bottom rounded-top">
            <img
              class="img-avatar img-avatar48 img-avatar-thumb"
              src="{mypluginurl}/assets/media/avatars/avatar10.jpg"
              alt=""
            />
            <p class="mt-2 mb-0 fw-medium">{khai_user.data.display_name}</p>
            <p class="mb-0 text-muted fs-sm fw-medium">--</p>
          </div>
          <!-- <div class="p-2">
            <a
              class="dropdown-item d-flex align-items-center justify-content-between"
              href="be_pages_generic_inbox.html"
            >
              <span class="fs-sm fw-medium">Inbox</span>
              <span class="badge rounded-pill bg-primary ms-2">3</span>
            </a>
            <a
              class="dropdown-item d-flex align-items-center justify-content-between"
              href="be_pages_generic_profile.html"
            >
              <span class="fs-sm fw-medium">Profile</span>
              <span class="badge rounded-pill bg-primary ms-2">1</span>
            </a>
            <a
              class="dropdown-item d-flex align-items-center justify-content-between"
              href="javascript:void(0)"
            >
              <span class="fs-sm fw-medium">Settings</span>
            </a>
          </div> -->
          <div role="separator" class="dropdown-divider m-0" />
          <div class="p-2">
            <!-- <a
              class="dropdown-item d-flex align-items-center justify-content-between"
              href="op_auth_lock.html"
            >
              <span class="fs-sm fw-medium">Lock Account</span>
            </a> -->

            <Link
              class="dropdown-item d-flex align-items-center justify-content-between"
              to={mylinkurl + "my-account/maklumatProfil"}
            >
              <span class="fs-sm fw-medium">Profil</span>
            </Link>
            <a
              href="/"
              class="dropdown-item d-flex align-items-center justify-content-between"
              on:click|preventDefault={(e) => logout(e)}
            >
              <span class="fs-sm fw-medium">Log Out</span>
            </a>
          </div>
        </div>
      </div>
      <!-- END User Dropdown -->

      <!-- Toggle Side Overlay -->
      <!-- Layout API, functionality initialized in Template._uiApiLayout() -->

      <!-- END Toggle Side Overlay -->
    </div>
    <!-- END Right Section -->
  </div>
  <!-- END Header Content -->

  <!-- Header Search -->
  <div id="page-header-search" class="overlay-header bg-body-extra-light">
    <div class="content-header">
      <form class="w-100" action="be_pages_generic_search.html" method="POST">
        <div class="input-group">
          <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
          <button
            type="button"
            class="btn btn-alt-danger"
            data-toggle="layout"
            data-action="header_search_off"
          >
            <i class="fa fa-fw fa-times-circle" />
          </button>
          <input
            type="text"
            class="form-control"
            placeholder="Search or hit ESC.."
            id="page-header-search-input"
            name="page-header-search-input"
          />
        </div>
      </form>
    </div>
  </div>
  <!-- END Header Search -->

  <!-- Header Loader -->
  <!-- Please check out the Loaders page under Components category to see examples of showing/hiding it -->
  <div id="page-header-loader" class="overlay-header bg-body-extra-light">
    <div class="content-header">
      <div class="w-100 text-center">
        <i class="fa fa-fw fa-circle-notch fa-spin" />
      </div>
    </div>
  </div>
  <!-- END Header Loader -->
</header>
<!-- END Header -->
