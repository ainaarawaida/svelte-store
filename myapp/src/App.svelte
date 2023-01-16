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

    // if (!_data.user || Object.keys(_data.user).length == 0) {
    //   navigate(mylinkurl + "/login");
    //   // location.reload();
    // } else {
    //   navigate(mylinkurl + "/");
    // }

    // setTimeout(async () => {
    //   await loadScript(`${mypluginurl}/assets/js/oneui.app.min.js`);
    //   console.log("oneui.app.min.js");
    // }, 5100);

    // setTimeout(async () => {
    //   await loadScript(
    //     `${mypluginurl}/assets/js/plugins/chart.js/chart.min.js`
    //   );
    //   console.log("chart.min.js");
    // }, 10300);

    // setTimeout(async () => {
    //   await loadScript(
    //     `${mypluginurl}/assets/js/pages/be_pages_dashboard.min.js`
    //   );
    //   console.log("be_pages_dashboard");
    // }, 15500);

    // await loadScript(`${mypluginurl}/assets/js/lib/jquery.min.js`);
    // await loadScript(
    //   `${mypluginurl}/assets/js/plugins/jquery-validation/jquery.validate.min.js`
    // );
    // setTimeout(async () => {
    //   await loadScript(`${mypluginurl}/assets/js/pages/op_auth_signin.min.js`);
    // }, 500);
  });
  afterUpdate(() => {
    // // ...the DOM is now in sync with the data
    // setTimeout(async () => {
    //   await loadScript(`${mypluginurl}/assets/js/oneui.app.min.js`);
    //   console.log("oneui.app.min.js");
    // }, 5100);
    // setTimeout(async () => {
    //   await loadScript(
    //     `${mypluginurl}/assets/js/plugins/chart.js/chart.min.js`
    //   );
    //   console.log("chart.min.js");
    // }, 10300);
    // setTimeout(async () => {
    //   await loadScript(
    //     `${mypluginurl}/assets/js/pages/be_pages_dashboard.min.js`
    //   );
    //   console.log("be_pages_dashboard");
    // }, 15500);
  });

  onDestroy(() => {
    console.log("bye");
    unsub();
    unsubscribe_data();
  });

  $: console.log("_data", _data);

  // console.log("pathname", pathname);
  // setTimeout(async () => {
  //   data.update((currentPolls) => {
  //     _data.user = "ahamd3";
  //     return {};
  //   });
  // }, 5000);
</script>

<svelte:head>
  <link
    rel="stylesheet"
    href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css"
  />
</svelte:head>

<Router primary={false}>
  {#if _data.loading === true}
    <div class="d-flex justify-content-center">
      <img class="" src="{mypluginurl}/assets/img/loading.gif" alt="" />
    </div>
  {:else if _data.loading === false}
    {#if Object.keys(_data.user).length == 0}
      <Route path={mylinkurl + "/login"}>
        <Login />
      </Route>
    {:else}
      <div
        id="page-container"
        class="sidebar-o sidebar-dark enable-page-overlay side-scroll page-header-fixed main-content-narrow"
      >
        <!-- Side Overlay-->
        <Aside />

        <Sidebar />

        <Header />
        <!-- Main Container -->
        <main id="main-container">
          <!-- Hero -->
          <div class="content">
            <Route path={mylinkurl + "/"}>
              <Home />
            </Route>
            <Route path={mylinkurl + "my-account"}>
              <Dashboard />
            </Route>
            <Route path={mylinkurl + "my-account/senaraiAhli"}>
              <SenaraiAhli />
            </Route>
            <Route path={mylinkurl + "my-account/daftarAhli"}>
              <DaftarAhli />
            </Route>
            <Route path={mylinkurl + "my-account/jenisYuran"}>
              <JenisYuran />
            </Route>
            <Route path={mylinkurl + "my-account/tambahJenisYuran"}>
              <TambahJenisYuran />
            </Route>
            <Route path={mylinkurl + "my-account/kemaskiniJenisYuran/:id"}>
              <KemaskiniJenisYuran />
            </Route>
            <!-- <Route path={mylinkurl + "my-account/test"}>
            <Test />
          </Route> -->

            <Route path={mylinkurl + "my-account/about"} component={About} />
            <Route
              path={mylinkurl + "my-account/maklumatKariah"}
              component={MaklumatKariah}
            />
            <Route
              path={mylinkurl + "my-account/maklumatProfil"}
              component={MaklumatProfil}
            />
            <Route path={mylinkurl + "my-account/blog"}>
              <Blog />
            </Route>
          </div>
          <!-- END Hero -->
        </main>
        <!-- END Main Container -->

        <Footer />
      </div>
      <!-- END Page Container -->
    {/if}
  {/if}
</Router>
