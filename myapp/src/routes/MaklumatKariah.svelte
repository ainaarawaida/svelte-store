<script>
  import { onMount } from "svelte";
  import { onDestroy } from "svelte";
  import { getContext } from "svelte";
  import { navigate, Router, Link, Route } from "svelte-navigator";
  import { createEventDispatcher } from "svelte";
  import { data } from "./../store.js";
  import { Alert } from "sveltestrap";

  let dispatch = createEventDispatcher();
  let mypluginurl = getContext("mypluginurl");
  let myapiurl = getContext("myapiurl");
  let mylinkurl = getContext("mylinkurl");

  let khai_user;

  let role;
  let fields = {};
  let submitpost = {
    error: [],
    post: false,
  };
  let visible = true;
  let unsubscribe;
  onMount(async () => {
    unsubscribe = data.subscribe((value) => {
      khai_user = value.khai_user;
      role = khai_user.data.role;
    });

    if (!khai_user.ID) {
      let apidata = new Promise(function (myResolve, myReject) {
        let dataArray = new FormData();
        dataArray.append("action", "Utama");
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

      khai_user = JSON.parse(await apidata).khai_user;
    }

    fields = {
      id: khai_user.ID,
      kariah_id: khai_user.data.kariah_id,
      namaKariah: khai_user.data.namaKariah,
      alamatKariah: khai_user.data.alamatKariah,
      sitePageUrl: khai_user.data.sitePageUrl,
    };

    role = khai_user.data.role;

    // if (khai_user.data.stage_daftar > 0) {
    //   navigate(mylinkurl + "my-account");
    // }

    // console.log("fields", fields);
  });

  onDestroy(() => {
    unsubscribe;
  });

  const submitHandler = async () => {
    submitpost.error = [];
    submitpost.post = true;

    let apidata = new Promise(function (myResolve, myReject) {
      let dataArray = new FormData();
      dataArray.append("action", "MaklumatKariah");
      dataArray.append("id", fields.id);
      dataArray.append("kariah_id", fields.kariah_id);
      dataArray.append("namaKariah", fields.namaKariah);
      dataArray.append("alamatKariah", fields.alamatKariah);
      dataArray.append("sitePageUrl", fields.sitePageUrl);
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

    submitpost = JSON.parse(await apidata).submitpost;
    fields.kariah_id =
      submitpost.kariah_id == undefined ? "" : submitpost.kariah_id;
    khai_user = JSON.parse(await apidata).khai_user;
    submitpost.post = true;
    // console.log("submitpost.post",submitpost.post);

    data.update((currentPolls) => {
      return { ...currentPolls, khai_user };
    });

    if (submitpost.error.length == 0) {
      // dispatch("menuChange", "Maklumat Profil");
      navigate(mylinkurl + "my-account/maklumatProfil");
      submitpost.post = false;
    }
  };

  const closealert = async () => {
    visible = false;
    submitpost.error = [];
    submitpost.post = false;
    // console.log("submitpost",submitpost)
  };
</script>

<main>
  <div class="container-fluid px-4">
    <span class="fs-3 fw-bold">Maklumat Kariah</span>
    {#if submitpost.post}
      {#if submitpost.error.length > 0}
        {#each submitpost.error as cat}
          <Alert toggle={() => closealert()} color="danger" dismissible
            >{Object.values(cat)}</Alert
          >
        {/each}
      {:else}
        <Alert toggle={() => closealert()} color="info" dismissible
          >Berjaya Hantar</Alert
        >
      {/if}
    {/if}

    <div class="container px-5 my-3">
      <form id="contactForm" on:submit|preventDefault={submitHandler}>
        <input
          class="form-control"
          id="id"
          type="hidden"
          bind:value={fields.id}
        />
        <input
          class="form-control"
          id="kariah_id"
          type="hidden"
          bind:value={fields.kariah_id}
        />
        <div class="mb-3">
          <label class="form-label" for="namaKariah">Nama Kariah</label>
          <input
            readonly={role != "1" ? true : false}
            class="form-control {submitpost.error.findIndex((p) =>
              p.hasOwnProperty('namaKariah')
            ) != -1
              ? 'is-invalid'
              : ''}"
            id="namaKariah"
            type="text"
            placeholder="Nama Kariah"
            required
            data-sb-validations="required"
            bind:value={fields.namaKariah}
          />
          <div class="invalid-feedback" data-sb-feedback="namaKariah:required">
            Nama Kariah is required.
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label" for="alamatKariah">Alamat Kariah</label>
          <textarea
            class="form-control {submitpost.error.findIndex((p) =>
              p.hasOwnProperty('alamatKariah')
            ) != -1
              ? 'is-invalid'
              : ''}"
            id="alamatKariah"
            type="text"
            placeholder="Alamat Kariah"
            style="height: 10rem;"
            data-sb-validations="required"
            required
            readonly={role != "1" ? true : false}
            bind:value={fields.alamatKariah}
          />
          <div
            class="invalid-feedback"
            data-sb-feedback="alamatKariah:required"
          >
            Alamat Kariah is required.
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label" for="sitePageUrl">Site Page URL</label>
          <input
            class="form-control {submitpost.error.findIndex((p) =>
              p.hasOwnProperty('sitePageUrl')
            ) != -1
              ? 'is-invalid'
              : ''}"
            id="sitePageUrl"
            type="text"
            placeholder="Site Page URL"
            data-sb-validations="required"
            bind:value={fields.sitePageUrl}
            required
            readonly={role != "1" ? true : false}
          />
          <div class="invalid-feedback" data-sb-feedback="sitePageUrl:required">
            Site Page URL is required.
          </div>
        </div>
        {#if role == "1"}
          <div class="d-grid">
            <button
              class="btn btn-primary btn-lg"
              id="submitButton"
              type="submit">Submit</button
            >
          </div>
        {/if}
      </form>
    </div>
  </div>
</main>

<!-- <LibLoader src="{mypluginurl}js/sb-forms-latest.js" libraryDetectionObject="sb-forms-latest" /> -->
