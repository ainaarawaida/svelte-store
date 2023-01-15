<script>
  import { onMount, tick, afterUpdate } from "svelte";
  import { onDestroy } from "svelte";
  import { Alert } from "sveltestrap";
  import { createEventDispatcher } from "svelte";
  import { navigate, Router, Link, Route } from "svelte-navigator";
  import { Button, Tooltip } from "sveltestrap";
  import { getContext } from "svelte";
  import { data } from "./../store.js";
  import { loadScript } from "./../document.js";

  export let passdata = {};

  let el;
  let myapiurl = getContext("myapiurl");
  let dispatch = createEventDispatcher();
  let visible;
  let loading;
  let mypluginurl = getContext("mypluginurl");
  let mylinkurl = getContext("mylinkurl");
  let MyPowerTable;
  let ptData = [{}];
  let unsubscribe;

  let ptInstructs = [];
  let submitpost = {};

  onMount(async () => {
    loading = true;
    if (Object.keys(passdata).length == 0) {
      submitpost.post = "";
    } else {
      submitpost.post = passdata.passdata;
      submitpost.error = [];
    }

    let apidata = new Promise(function (myResolve, myReject) {
      let dataArray = new FormData();
      dataArray.append("action", "JenisYuran");
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
    ptData = JSON.parse(await apidata).submitpost.get_jenisyuran;

    for (let i = 0; i < ptData.length; i++) {
      // console.log("ptData1", ptData[i]);
      ptData[i].action = `<div style="width:85px;"><button
                          
                          type="button" 
                          class="btn btn-sm btn-success js-bs-tooltip-enabled actionbutton"
                          data-bs-toggle="tooltip"
                          data-pass = ${ptData[i].ID}
                          name= "edit"
                          aria-label="Remove Client"
                          data-bs-original-title="Remove Client"
                        ><i class="fa fa-fw fa-pencil-alt"></i></button>
                       
                        <button
                          
                          type="button"
                          class="btn btn-sm btn-danger js-bs-tooltip-enabled actionbutton"
                           name= "delete"
                          data-bs-toggle="tooltip"
                          data-pass = ${ptData[i].ID}
                          aria-label="Remove Client"
                          data-bs-original-title="Remove Client"
                        ><i class="fa fa-fw fa-times"></i></button></div>
                      `;
    }

    // <Link
    //   type="button"
    //   class="btn btn-sm btn-success js-bs-tooltip-enabled"
    //   aria-label="Edit Client"
    //   to={mylinkurl +
    //     "my-account/kemaskiniJenisYuran/" +
    //     btoa(JSON.stringify(cat))}
    // >
    //   <i class="fa fa-fw fa-pencil-alt" />
    // </Link>
    // <button
    //   on:click|preventDefault={(e) =>
    //     deleteyuran(e, cat.ID)}
    //   type="button"
    //   class="btn btn-sm btn-danger js-bs-tooltip-enabled"
    //   data-bs-toggle="tooltip"
    //   aria-label="Remove Client"
    //   data-bs-original-title="Remove Client"
    // >
    //   <i class="fa fa-fw fa-times" />
    // </button>

    loading = false;

    await loadScript("https://code.jquery.com/jquery-3.5.1.js");
    await loadScript(
      "https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"
    );
    // setTimeout(async () => {
    //   window.$(el).DataTable();
    // }, 100);
    window.$(el).DataTable({
      data: ptData,
      columns: [
        { title: "Tajuk", data: "Tajuk" },
        { title: "Jenis Yuran", data: "jenisYuran" },
        { title: "Jumlah (RM)", data: "Jumlah" },
        { title: "Keterangan Yuran", data: "keteranganYuran" },
        { title: "Mula Yuran", data: "mulaYuran" },
        { title: "Status Yuran", data: "statusYuran" },
        { title: "Paparan Pakej", data: "paparanYuran" },
        { title: "Action", data: "action" },
      ],
    });

    var element = document.querySelector(".maindatatables");
    element.addEventListener("click", function (e) {
      let datatarget = e.target.closest(".actionbutton").getAttribute("name");
      if (datatarget == "edit") {
        let dataid = e.target
          .closest(".actionbutton")
          .getAttribute("data-pass");
        navigate(mylinkurl + "my-account/kemaskiniJenisYuran/" + dataid);
      } else {
        //delete
        let dataid = e.target
          .closest(".actionbutton")
          .getAttribute("data-pass");
        if (confirm("Anda pasti untuk delete data") != true) {
          return;
        }

        let apidata = new Promise(function (myResolve, myReject) {
          let dataArray = new FormData();
          dataArray.append("action", "DeleteJenisYuran");
          dataArray.append("ID", dataid);
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

        var result = ptData.filter((wordx) => {
          return wordx.ID != dataid;
        });
        ptData = result;
        window.$(el).DataTable().destroy();
        window.$(el).DataTable({
          data: ptData,
          columns: [
            { title: "Tajuk", data: "Tajuk" },
            { title: "Jenis Yuran", data: "jenisYuran" },
            { title: "Jumlah (RM)", data: "Jumlah" },
            { title: "Keterangan Yuran", data: "keteranganYuran" },
            { title: "Mula Yuran", data: "mulaYuran" },
            { title: "Status Yuran", data: "statusYuran" },
            { title: "Paparan Pakej", data: "paparanYuran" },
            { title: "Action", data: "action" },
          ],
        });
      }
    });
  });

  onDestroy(() => {
    unsubscribe;
    let mybody = document.querySelector("#example_wrapper");
    if (mybody) {
      mybody.remove();
    }
  });
  const submitHandler = async () => {};

  const closealert = async () => {
    visible = false;
    submitpost.error = [];
    submitpost.post = false;
    // console.log("submitpost", submitpost);
  };

  const deleteyuran = async (ele, dataid) => {
    // if (confirm("Anda pasti untuk delete data") != true) {
    //   return;
    // }
    // let apidata = new Promise(function (myResolve, myReject) {
    //   let dataArray = new FormData();
    //   dataArray.append("action", "DeleteJenisYuran");
    //   dataArray.append("ID", dataid);
    //   fetch(myapiurl, {
    //     method: "POST",
    //     body: dataArray,
    //   })
    //     .then((response) => response.json())
    //     .then((result) => {
    //       myResolve(result);
    //     })
    //     .catch((error) => console.log("error", error));
    // });
    // passdata = JSON.parse(await apidata).submitpost;
    // console.log("passdata", JSON.parse(atob(dataid)));
    // var result = ptData.filter((wordx) => {
    //   return wordx.ID != dataid;
    // });
    // ptData = result;
    // await tick();
    // let mybody = document.querySelector("#example_wrapper");
    // mybody.remove();
    // setTimeout(async () => {
    //   window.$(el).DataTable().destroy();
    //   console.log("script loaded successfully!");
    // }, 3000);
    // setTimeout(async () => {
    //   // ptData.then(() => {
    //   //   window.$(el).DataTable();
    //   // });
    //   window.$(el).DataTable().destroy();
    //   // window.$(el).DataTable().clear();
    //   // window.$(el).DataTable();
    //   console.log("script loaded successfully!");
    // }, 3000);
  };

  // $: console.log("ptDataxx", ptData);
</script>

<main>
  <div class="container-fluid px-4">
    <span class="fs-3 fw-bold">Jenis Yuran</span>
    {#if submitpost.post && submitpost.post != ""}
      {#if submitpost.error.length > 0}
        {#each submitpost.error as cat}
          <Alert toggle={() => closealert()} color="danger" dismissible
            >{Object.values(cat)}</Alert
          >
        {/each}
      {:else}
        <Alert toggle={() => closealert()} color="info" dismissible
          >{submitpost.post}</Alert
        >
      {/if}
    {/if}

    <div class="text-end">
      <Link
        class="btn btn-primary"
        to={mylinkurl + "my-account/tambahJenisYuran"}>Tambah Jenis Yuran</Link
      >
    </div>
    <div class="m-2" />

    <div class="card mb-4">
      <div class="card-header">
        <i class="fas fa-table me-1" />
        Jenis Yuran
      </div>
      <div class="card-body">
        <div class="MuonW PowerTable">
          {#if loading === true}
            <div class="d-flex justify-content-center">
              <img class="" src="{mypluginurl}assets/img/loading.gif" alt="" />
            </div>
          {:else}
            <table
              bind:this={el}
              class="display maindatatables"
              style="width:100%"
            />
          {/if}
        </div>
      </div>
    </div>
  </div>
</main>
