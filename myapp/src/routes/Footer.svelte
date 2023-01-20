<script>
  import { onMount } from "svelte";
  import { loadScript } from "./../document.js";
  import { getContext } from "svelte";
  let mypluginurl = getContext("mypluginurl");
  onMount(async () => {
    await loadScript(
      `${mypluginurl}/assets/js/jquery-3.5.1.min.js`,
      `jquery-3.5.1.min.js`
    );
    await loadScript(
      `${mypluginurl}/assets/js/icons/feather-icon/feather.min.js`,
      `feather.min.js`
    );
    await loadScript(
      `${mypluginurl}/assets/js/icons/feather-icon/feather-icon.js`,
      `feather-icon.js`
    );
    await loadScript(
      `${mypluginurl}/assets/js/sidebar-menu.js`,
      `sidebar-menu.js`
    );
    await loadScript(`${mypluginurl}/assets/js/config.js`, `config.js`);
    await loadScript(
      `${mypluginurl}/assets/js/bootstrap/popper.min.js`,
      `popper.min.js`
    );
    await loadScript(
      `${mypluginurl}/assets/js/bootstrap/bootstrap.min.js`,
      `bootstrap.min.js`
    );
    await loadScript(
      `${mypluginurl}/assets/js/chart/chartjs/chart.min.js`,
      `chart.min.js`
    );
    await loadScript(
      `${mypluginurl}/assets/js/chart/chartist/chartist.js`,
      `chartist.js`
    );
    await loadScript(
      `${mypluginurl}/assets/js/chart/chartist/chartist-plugin-tooltip.js`,
      `chartist-plugin-tooltip.js`
    );
    await loadScript(
      `${mypluginurl}/assets/js/chart/knob/knob.min.js`,
      `knob.min.js`
    );
    await loadScript(
      `${mypluginurl}/assets/js/chart/apex-chart/apex-chart.js`,
      `apex-chart.js`
    );
    await loadScript(
      `${mypluginurl}/assets/js/chart/apex-chart/stock-prices.js`,
      `stock-prices.js`
    );
    await loadScript(
      `${mypluginurl}/assets/js/prism/prism.min.js`,
      `prism.min.js`
    );
    await loadScript(
      `${mypluginurl}/assets/js/clipboard/clipboard.min.js`,
      `clipboard.min.js`
    );
    await loadScript(
      `${mypluginurl}/assets/js/counter/jquery.waypoints.min.js`,
      `jquery.waypoints.min.js`
    );

    await loadScript(
      `${mypluginurl}/assets/js/counter/jquery.counterup.min.js`,
      `jquery.counterup.min.js`
    );
    await loadScript(
      `${mypluginurl}/assets/js/counter/counter-custom.js`,
      `counter-custom.js`
    );
    await loadScript(
      `${mypluginurl}/assets/js/custom-card/custom-card.js`,
      `custom-card.js`
    );
    await loadScript(
      `${mypluginurl}/assets/js/owlcarousel/owl.carousel.js`,
      `owl.carousel.js`
    );
    await loadScript(
      `${mypluginurl}/assets/js/owlcarousel/owl-custom.js`,
      `owl-custom.js`
    );
    await loadScript(
      `${mypluginurl}/assets/js/dashboard/dashboard_2.js`,
      `dashboard_2.js`
    );
    await loadScript(`${mypluginurl}/assets/js/script.js`, `script.js`);
    await loadScript(
      `${mypluginurl}/assets/js/theme-customizer/customizery.js/?mypluginurl=${mypluginurl}`,
      `customizery.js`
    );
  });
</script>

<!-- footer start-->
<footer class="footer">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6 footer-copyright">
        <p class="mb-0">Copyright 2021-22 © viho All rights reserved.</p>
      </div>
      <div class="col-md-6">
        <p class="pull-right mb-0">
          Hand crafted & made with <i class="fa fa-heart font-secondary" />
        </p>
      </div>
    </div>
  </div>
</footer>
