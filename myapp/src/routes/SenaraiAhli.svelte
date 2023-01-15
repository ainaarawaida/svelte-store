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
      dataArray.append("action", "SenaraiAhli");
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
    unsubscribe;
    let mybody = document.querySelector("#example_wrapper");
    mybody.remove();
  });
</script>

<main>
  <div class="container-fluid px-4">
    <span class="fs-3 fw-bold">Senarai Ahli</span>

    <div class="alert alert-warning alert-dismissible fade show" role="alert">
      Semua ahli yang berdaftar dan telah diluluskan akan dipaparkan dibahagian
      ini. <br />Pentadbir perlu klik <i>edit</i> untuk melihat perincian ahli,
      bayaran, tanggungan dan faedah khairat yang diterima.
      <button
        type="button"
        class="btn-close"
        data-bs-dismiss="alert"
        aria-label="Close"
      />
    </div>

    <div class="text-end">
      <a class="btn btn-primary" href="Daftar Ahli">Daftar Ahli</a>&nbsp;
      <a class="btn btn-danger" href="Senarai Ahli tidak Aktif"
        >Senarai Ahli Tidak Aktif</a
      >
    </div>

    <div class="card mb-4">
      <div class="card-header">
        <i class="fas fa-table me-1" />
        Senarai Aktif Ahli Khairat
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
