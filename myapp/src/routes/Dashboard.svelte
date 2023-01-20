<script>
  import { onMount } from "svelte";
  import { data } from "./../store.js";
  import { onDestroy } from "svelte";
  import { loadScript } from "./../document.js";
  import { getContext } from "svelte";
  import { navigate, Router, Link, Route } from "svelte-navigator";
  let mypluginurl = getContext("mypluginurl");
  let mybaseurl = getContext("mybaseurl");
  let mylinkurl = getContext("mylinkurl");
  let _data;
  data.update((currentPolls) => {
    _data = currentPolls;
    return currentPolls;
  });

  onMount(async () => {
    data.update((currentPolls) => {
      _data.loading = false;
      localStorage.setItem("_data", JSON.stringify(_data));
      return currentPolls;
    });

    if (!_data.user || (_data.user && Object.keys(_data.user).length == 0)) {
      navigate(mylinkurl + "/mylogin");
      location.reload();
    }

    // setTimeout(async () => {
    //   await loadScript(`${mypluginurl}/assets/js/oneui.app.min.js`);
    //   console.log("oneui.app.min.js11");
    // }, 5100);
    //start ----------------------
    // await loadScript(
    //   `${mypluginurl}/assets/js/jquery-3.5.1.min.js`,
    //   `jquery-3.5.1.min.js`
    // );
    // await loadScript(
    //   `${mypluginurl}/assets/js/icons/feather-icon/feather.min.js`
    // );
    // await loadScript(
    //   `${mypluginurl}/assets/js/icons/feather-icon/feather-icon.js`
    // );
    // await loadScript(`${mypluginurl}/assets/js/sidebar-menu.js`);
    // await loadScript(`${mypluginurl}/assets/js/config.js`);
    // await loadScript(`${mypluginurl}/assets/js/bootstrap/popper.min.js`);
    // await loadScript(`${mypluginurl}/assets/js/bootstrap/bootstrap.min.js`);
    // await loadScript(`${mypluginurl}/assets/js/chart/chartjs/chart.min.js`);
    // await loadScript(`${mypluginurl}/assets/js/chart/chartist/chartist.js`);
    // await loadScript(
    //   `${mypluginurl}/assets/js/chart/chartist/chartist-plugin-tooltip.js`
    // );
    // await loadScript(`${mypluginurl}/assets/js/chart/knob/knob.min.js`);
    // await loadScript(`${mypluginurl}/assets/js/chart/apex-chart/apex-chart.js`);
    // await loadScript(
    //   `${mypluginurl}/assets/js/chart/apex-chart/stock-prices.js`
    // );
    // await loadScript(`${mypluginurl}/assets/js/prism/prism.min.js`);
    // await loadScript(`${mypluginurl}/assets/js/clipboard/clipboard.min.js`);
    // await loadScript(
    //   `${mypluginurl}/assets/js/counter/jquery.waypoints.min.js`
    // );

    // await loadScript(
    //   `${mypluginurl}/assets/js/counter/jquery.counterup.min.js`
    // );
    // await loadScript(`${mypluginurl}/assets/js/counter/counter-custom.js`);
    // await loadScript(`${mypluginurl}/assets/js/custom-card/custom-card.js`);
    // await loadScript(`${mypluginurl}/assets/js/owlcarousel/owl.carousel.js`);
    // await loadScript(`${mypluginurl}/assets/js/owlcarousel/owl-custom.js`);
    // await loadScript(`${mypluginurl}/assets/js/dashboard/dashboard_2.js`);
    // await loadScript(`${mypluginurl}/assets/js/script.js`);
    // await loadScript(
    //   `${mypluginurl}/assets/js/theme-customizer/customizery.js/?mypluginurl=${mypluginurl}`
    // );
    // await loadScript(`${mypluginurl}/luqman.js`);
    //end ----------------------
    // await loadScript(
    //   `${mypluginurl}/assets/js/theme-customizer/customizerx.js/?mypluginurl=${mypluginurl}`
    // );
  });

  // console.log("mypluginurl", mypluginurl);
</script>

<div class="page-body dashboard-2-main">
  <!-- Container-fluid starts-->
  <div class="container-fluid">
    <div class="row">Dashboard</div>
  </div>
  <!-- Container-fluid Ends-->
</div>
