<script>
  import { navigate, Router, Link, Route } from "svelte-navigator";
  import { globalHistory } from "svelte-navigator/src/history";
  let pathname = window.location.pathname;
  let unsub;
  let unsubscribe;
  let unsubscribe_data;
  import { onMount } from "svelte";
  import { setContext } from "svelte";
  import { data } from "./store.js";
  import { onDestroy } from "svelte";
  import { loadScript } from "./document.js";
  import { beforeUpdate, afterUpdate } from "svelte";

  import Home from "./routes/Home.svelte";
  import Login from "./routes/Login.svelte";
  import About from "./routes/About.svelte";
  import Blog from "./routes/Blog.svelte";
  import Default from "./routes/Default.svelte";
  import Dashboard from "./routes/Dashboard.svelte";
  import MaklumatKariah from "./routes/MaklumatKariah.svelte";
  import MaklumatProfil from "./routes/MaklumatProfil.svelte";
  import SenaraiAhli from "./routes/SenaraiAhli.svelte";
  import DaftarAhli from "./routes/DaftarAhli.svelte";
  import JenisYuran from "./routes/JenisYuran.svelte";
  import TambahJenisYuran from "./routes/TambahJenisYuran.svelte";
  import KemaskiniJenisYuran from "./routes/KemaskiniJenisYuran.svelte";

  import Aside from "./routes/Aside.svelte";
  import Sidebar from "./routes/Sidebar.svelte";
  import Header from "./routes/Header.svelte";
  import Footer from "./routes/Footer.svelte";
  // import Test from "./routes/Test.svelte";

  let mypluginurl = import.meta.env.VITE_MYPLUGINURL;
  setContext("mypluginurl", import.meta.env.VITE_MYPLUGINURL);
  let mylinkurl = import.meta.env.VITE_MYLINKURL;
  setContext("mylinkurl", import.meta.env.VITE_MYLINKURL);
  let mybaseurl = import.meta.env.VITE_MYBASEURL;
  setContext("mybaseurl", import.meta.env.VITE_MYBASEURL);
  let myapiurl = import.meta.env.VITE_MYAPIURL;
  setContext("myapiurl", import.meta.env.VITE_MYAPIURL);

  let _data;
  unsubscribe_data = data.subscribe((value) => {
    _data = value;
  });
  data.update((currentPolls) => {
    _data.loading = true;
    localStorage.setItem("_data", JSON.stringify(_data));
    return currentPolls;
  });

  onMount(async () => {
    unsub = globalHistory.listen(({ location, action }) => {
      pathname = location.pathname;
    });

    _data.loading = false;
  });
  afterUpdate(() => {});

  onDestroy(() => {
    console.log("bye");
    unsub();
    unsubscribe_data();
  });

  $: console.log("_data", _data);
  // $: console.log("_data2", _data.user);
  // $: console.log("_data2", _data.user ? Object.keys(_data.user).length : "");
</script>

<svelte:head>
  <link rel="stylesheet" href="{mypluginurl}/assets/css/fontawesome.css" />
  <link rel="stylesheet" href="{mypluginurl}/assets/css/icofont.css" />
  <link rel="stylesheet" href="{mypluginurl}/assets/css/themify.css" />
  <link rel="stylesheet" href="{mypluginurl}/assets/css/flag-icon.css" />
  <link rel="stylesheet" href="{mypluginurl}/assets/css/feather-icon.css" />
  <link rel="stylesheet" href="{mypluginurl}/assets/css/animate.css" />
  <link rel="stylesheet" href="{mypluginurl}/assets/css/chartist.css" />
  <link rel="stylesheet" href="{mypluginurl}/assets/css/chartist.css" />
  <link rel="stylesheet" href="{mypluginurl}/assets/css/owlcarousel.css" />
  <link rel="stylesheet" href="{mypluginurl}/assets/css/prism.css" />
  <link rel="stylesheet" href="{mypluginurl}/assets/css/bootstrap.css" />
  <link rel="stylesheet" href="{mypluginurl}/assets/css/style.css" />
  <link rel="stylesheet" href="{mypluginurl}/assets/css/color-1.css" />
  <link rel="stylesheet" href="{mypluginurl}/assets/css/responsive.css" />
</svelte:head>

<Router primary={false}>
  {#if _data.loading === true}
    <!-- Loader starts-->
    <div class="loader-wrapper">
      <div class="theme-loader">
        <div class="loader-p" />
      </div>
    </div>
    <!-- Loader ends-->
  {:else if _data.loading === false}
    {#if !_data.user || (_data.user && Object.keys(_data.user).length == 0)}
      <!-- <Route path={mylinkurl + "/*"}> -->
      <Route path={mylinkurl + "/mylogin"}>
        <Login />
      </Route>
      <Route path={mylinkurl + "/"}>
        <Home />
      </Route>
      <Route>
        <Home />
      </Route>
      <!-- </Route> -->
    {:else}
      <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <Header />
        <div class="page-body-wrapper sidebar-icon">
          <Sidebar />
          <Route path={mylinkurl + "/"}>
            <Home />
          </Route>
          <Route path={mylinkurl + "/dashboard"}>
            <Dashboard />
          </Route>
          <Footer />
        </div>
      </div>
      <!-- END Page Container -->
    {/if}
  {/if}
</Router>
