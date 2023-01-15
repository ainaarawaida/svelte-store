<script>
  import { onMount } from "svelte";
  import { onDestroy } from "svelte";
  import { getContext } from "svelte";
  import { data } from "./../store.js";

  let mylinkurl = getContext("mylinkurl");
  let mypluginurl = getContext("mypluginurl");
  let mybaseurl = getContext("mybaseurl");
  let myapiurl = getContext("myapiurl");
  let unsubscribe;
  let submitpost;
  let khai_user;
  let loading = true;
  let ptData = [{}];

  import { loadScript } from "./../document.js";

  onMount(async () => {
    unsubscribe = data.subscribe((value) => {
      khai_user = value.khai_user;
    });

    let apidata = new Promise(function (myResolve, myReject) {
      let dataArray = new FormData();
      dataArray.append("action", "Dashboard");
      fetch(myapiurl, {
        method: "POST",
        body: dataArray,
      })
        .then((response) => response.json())
        .then((result) => {
          myResolve(result);
        })
        .catch((error) => console.log("error", error));
    });

    ptData = JSON.parse(await apidata).submitpost.get_senarai_ahli;
    for (let i = 0; i < ptData.length; i++) {
      let status;
      if (ptData[i].stage_daftar == "1") {
        status = "Daftar";
      }
      if (ptData[i].stage_daftar == "2") {
        status = "Pilih Pakej";
      }
      if (ptData[i].stage_daftar == "3") {
        status = "Kemaskini Maklumat Ahli";
      }
      if (ptData[i].stage_daftar == "4") {
        status = "Kelulusan Admin";
      }
      if (ptData[i].stage_daftar == "5") {
        status = "Bayaran";
      }
      if (ptData[i].stage_daftar == "6") {
        status = "Tidak Aktif";
      }
      ptData[i].stage_daftar = status;
    }
    loading = false;

    await loadScript("https://code.jquery.com/jquery-3.5.1.js");
    await loadScript(
      "https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"
    );
    setTimeout(async () => {
      await loadScript(`${mypluginurl}assets/js/datatables/luqtable.js`);
      //   console.log("script loaded successfully!");
    }, 100);
  });

  onDestroy(async () => {
    let mybody = document.querySelector("#example_wrapper");
    if (mybody) {
      mybody.remove();
    }
  });
</script>

<main>
  <div class="container-fluid px-4">
    <span class="fs-3 fw-bold">Dashboard</span>

    <!-- Overview -->
    <div class="row items-push">
      <div class="col-sm-6 col-xxl-3">
        <!-- Pending Orders -->
        <div class="block block-rounded d-flex flex-column h-100 mb-0">
          <div
            class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center"
          >
            <dl class="mb-0">
              <dt class="fs-3 fw-bold">{ptData.length}</dt>
              <dd class="fs-sm fw-medium fs-sm fw-medium text-muted mb-0">
                Permohonan Baru
              </dd>
            </dl>
            <div class="item item-rounded-lg bg-body-light">
              <i class="far fa-gem fs-3 text-primary" />
            </div>
          </div>
          <div class="bg-body-light rounded-bottom">
            <a
              class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex align-items-center justify-content-between"
              href="javascript:void(0)"
            >
              <span>View all data</span>
              <i class="fa fa-arrow-alt-circle-right ms-1 opacity-25 fs-base" />
            </a>
          </div>
        </div>
        <!-- END Pending Orders -->
      </div>
      <div class="col-sm-6 col-xxl-3">
        <!-- New Customers -->
        <div class="block block-rounded d-flex flex-column h-100 mb-0">
          <div
            class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center"
          >
            <dl class="mb-0">
              <dt class="fs-3 fw-bold">124</dt>
              <dd class="fs-sm fw-medium fs-sm fw-medium text-muted mb-0">
                Jumlah Bayaran (RM)
              </dd>
            </dl>
            <div class="item item-rounded-lg bg-body-light">
              <i class="far fa-user-circle fs-3 text-primary" />
            </div>
          </div>
          <div class="bg-body-light rounded-bottom">
            <a
              class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex align-items-center justify-content-between"
              href="javascript:void(0)"
            >
              <span>View all data</span>
              <i class="fa fa-arrow-alt-circle-right ms-1 opacity-25 fs-base" />
            </a>
          </div>
        </div>
        <!-- END New Customers -->
      </div>
      <div class="col-sm-6 col-xxl-3">
        <!-- Messages -->
        <div class="block block-rounded d-flex flex-column h-100 mb-0">
          <div
            class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center"
          >
            <dl class="mb-0">
              <dt class="fs-3 fw-bold">45</dt>
              <dd class="fs-sm fw-medium fs-sm fw-medium text-muted mb-0">
                Jumlah Tunggakan (RM)
              </dd>
            </dl>
            <div class="item item-rounded-lg bg-body-light">
              <i class="far fa-paper-plane fs-3 text-primary" />
            </div>
          </div>
          <div class="bg-body-light rounded-bottom">
            <a
              class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex align-items-center justify-content-between"
              href="javascript:void(0)"
            >
              <span>View all data</span>
              <i class="fa fa-arrow-alt-circle-right ms-1 opacity-25 fs-base" />
            </a>
          </div>
        </div>
        <!-- END Messages -->
      </div>
      <div class="col-sm-6 col-xxl-3">
        <!-- Conversion Rate -->
        <div class="block block-rounded d-flex flex-column h-100 mb-0">
          <div
            class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center"
          >
            <dl class="mb-0">
              <dt class="fs-3 fw-bold">4.5%</dt>
              <dd class="fs-sm fw-medium fs-sm fw-medium text-muted mb-0">
                Ahli Berdaftar (Aktif)
              </dd>
            </dl>
            <div class="item item-rounded-lg bg-body-light">
              <i class="fa fa-chart-bar fs-3 text-primary" />
            </div>
          </div>
          <div class="bg-body-light rounded-bottom">
            <a
              class="block-content block-content-full block-content-sm fs-sm fw-medium d-flex align-items-center justify-content-between"
              href="javascript:void(0)"
            >
              <span>View all data</span>
              <i class="fa fa-arrow-alt-circle-right ms-1 opacity-25 fs-base" />
            </a>
          </div>
        </div>
        <!-- END Conversion Rate-->
      </div>
    </div>

    <div class="card mb-4">
      <div class="card-header">
        <i class="fas fa-table me-1" />
        Pendaftaran Online
      </div>
      <div class="card-body">
        <div class="MuonW PowerTable">
          {#if loading === true}
            <div class="d-flex justify-content-center">
              <img class="" src="{mypluginurl}assets/img/loading.gif" alt="" />
            </div>
          {:else}
            <table id="example" class="display" style="width:100%">
              <thead>
                <tr>
                  <th>No Ahli</th>
                  <th>Nama</th>
                  <th>No IC</th>
                  <th>Nama Kariah</th>
                  <th>No Tel</th>
                  <th>Status</th>
                  <th>Tarikh Daftar</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                {#each ptData as cat, i}
                  <tr>
                    <td>{cat.no_ahli}</td>
                    <td>{cat.display_name}</td>
                    <td>{cat.noKadPengenalanBaru}</td>
                    <td>{cat.namaKariah}</td>
                    <td>{cat.nomborTelefon}</td>
                    <td>{cat.stage_daftar}</td>
                    <td>{cat.user_registered}</td>
                    {#if khai_user.ID == cat.ID}
                      <td> <i class="fa fa-address-card text-success" /></td>
                    {:else}
                      <td> <i class="fa fa-address-card text-success" /></td>
                    {/if}
                  </tr>
                {/each}
              </tbody>
              <tfoot>
                <tr>
                  <th>No Ahli</th>
                  <th>Nama</th>
                  <th>No IC</th>
                  <th>Nama Kariah</th>
                  <th>No Tel</th>
                  <th>Status</th>
                  <th>Tarikh Daftar</th>
                  <th>Action</th>
                </tr>
              </tfoot>
            </table>
          {/if}
        </div>
      </div>
    </div>
  </div>
</main>
