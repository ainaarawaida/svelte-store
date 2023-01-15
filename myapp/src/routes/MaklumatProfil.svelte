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
    let year = khai_user.data.user_registered.substring(0, 4);
    let month = khai_user.data.user_registered.substring(5, 7);
    let day = khai_user.data.user_registered.substring(8, 10);
    fields.tarikhDaftar = [year, month, day].join("-");

    fields = {
      id: khai_user.ID,
      namaPenuh: khai_user.data.display_name,
      emel: khai_user.data.user_email,
      katalaluan: "",
      katalaluanSemula: "",
      noKadPengenalanBaru: khai_user.data.noKadPengenalanBaru,
      nomborTelefon: khai_user.data.nomborTelefon,
      tarikhDaftar: [year, month, day].join("-"),
      nomborKeahlian: `000${khai_user.ID}`,
      jenisAhliView:
        khai_user.data.role == "1"
          ? "Pentadbir"
          : khai_user.data.role == "2"
          ? "Ahli"
          : "",
      jenisAhli: khai_user.data.role,
      namaKariah: khai_user.data.namaKariah,
    };
  });

  onDestroy(() => {
    unsubscribe;
  });

  // import LibLoader from '../../LibLoader.svelte';
  // import { loadScript } from '../../document.js';
  const submitHandler = async () => {
    submitpost.error = [];

    if (fields.katalaluan !== fields.katalaluanSemula) {
      submitpost.error.push({
        katalaluanSemula: "Kata Laluan Ulangan tidak sama",
      });
    }
    if (submitpost.error.length > 0) {
      return;
    }

    let apidata = new Promise(function (myResolve, myReject) {
      let dataArray = new FormData();
      dataArray.append("action", "MaklumatProfil");
      dataArray.append("id", fields.id);
      dataArray.append("namaPenuh", fields.namaPenuh);
      dataArray.append("emel", fields.emel);
      dataArray.append("katalaluan", fields.katalaluan);
      dataArray.append("katalaluanSemula", fields.katalaluanSemula);
      dataArray.append("noKadPengenalanBaru", fields.noKadPengenalanBaru);
      dataArray.append("nomborTelefon", fields.nomborTelefon);
      dataArray.append("tarikhDaftar", fields.tarikhDaftar);
      dataArray.append("nomborKeahlian", fields.nomborKeahlian);
      dataArray.append("jenisAhli", fields.jenisAhli);
      dataArray.append("namaKariah", fields.namaKariah);

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
    khai_user = JSON.parse(await apidata).khai_user;

    data.update((value) => {
      return { ...value, khai_user };
    });

    submitpost.post = true;
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
    <span class="fs-3 fw-bold">Maklumat Profil</span>

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
        <div class="row">
          <div class="col-sm">
            <label class="form-label" for="namaPenuh">Nama Penuh</label>
            <input
              class="form-control {submitpost.error.findIndex((p) =>
                p.hasOwnProperty('namaPenuh')
              ) != -1
                ? 'is-invalid'
                : ''}"
              id="namaPenuh"
              type="text"
              placeholder="Nama Penuh"
              required
              bind:value={fields.namaPenuh}
            />

            <div class="invalid-feedback" data-sb-feedback="namaPenuh:required">
              Nama Penuh is required.
            </div>
          </div>
          <div class="col-sm">
            <label class="form-label" for="emel">Emel</label>
            <input
              class="form-control {submitpost.error.findIndex((p) =>
                p.hasOwnProperty('email')
              ) != -1
                ? 'is-invalid'
                : ''}"
              id="emel"
              type="email"
              placeholder="Emel"
              required
              bind:value={fields.emel}
            />

            <div class="invalid-feedback" data-sb-feedback="emel:required">
              Emel is required.
            </div>
            <div class="invalid-feedback" data-sb-feedback="emel:email">
              Emel Email is not valid.
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm">
            <label class="form-label" for="katalaluan"
              >Katalaluan <i>(Kosongkan jika tidak ingin ubah)</i></label
            >
            <input
              class="form-control {submitpost.error.findIndex((p) =>
                p.hasOwnProperty('katalaluan')
              ) != -1
                ? 'is-invalid'
                : ''}"
              id="katalaluan"
              type="password"
              placeholder="Katalaluan"
              bind:value={fields.katalaluan}
            />

            <div
              class="invalid-feedback"
              data-sb-feedback="katalaluan:required"
            >
              Katalaluan is required.
            </div>
          </div>
          <div class="col-sm">
            <label class="form-label" for="katalaluanSemula"
              >Katalaluan Semula <i>(Kosongkan jika tidak ingin ubah)</i></label
            >
            <input
              class="form-control {submitpost.error.findIndex((p) =>
                p.hasOwnProperty('katalaluanSemula')
              ) != -1
                ? 'is-invalid'
                : ''}"
              id="katalaluanSemula"
              type="password"
              placeholder="Katalaluan Semula"
              bind:value={fields.katalaluanSemula}
            />

            <div
              class="invalid-feedback"
              data-sb-feedback="katalaluanSemula:required"
            >
              Katalaluan Semula is required.
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm">
            <label class="form-label" for="noKadPengenalanBaru"
              >No. Kad Pengenalan Baru</label
            >
            <input
              class="form-control {submitpost.error.findIndex((p) =>
                p.hasOwnProperty('noKadPengenalanBaru')
              ) != -1
                ? 'is-invalid'
                : ''}"
              id="noKadPengenalanBaru"
              type="number"
              min="100000000000"
              max="999999999999"
              placeholder="No. Kad Pengenalan Baru"
              required
              bind:value={fields.noKadPengenalanBaru}
            />

            <div
              class="invalid-feedback"
              data-sb-feedback="noKadPengenalanBaru:required"
            >
              No. Kad Pengenalan Baru is required.
            </div>
          </div>
          <div class="col-sm">
            <label class="form-label" for="nomborTelefon">Nombor Telefon</label>
            <input
              class="form-control {submitpost.error.findIndex((p) =>
                p.hasOwnProperty('nomborTelefon')
              ) != -1
                ? 'is-invalid'
                : ''}"
              id="nomborTelefon"
              type="number"
              placeholder="Nombor Telefon"
              required
              bind:value={fields.nomborTelefon}
            />

            <div
              class="invalid-feedback"
              data-sb-feedback="nomborTelefon:required"
            >
              Nombor Telefon is required.
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm">
            <label class="form-label" for="tarikhDaftar">Tarikh Daftar</label>
            <input
              readonly
              class="form-control {submitpost.error.findIndex((p) =>
                p.hasOwnProperty('tarikhDaftar')
              ) != -1
                ? 'is-invalid'
                : ''}"
              id="tarikhDaftar"
              type="date"
              placeholder="Tarikh Daftar"
              required
              bind:value={fields.tarikhDaftar}
            />

            <div
              class="invalid-feedback"
              data-sb-feedback="tarikhDaftar:required"
            >
              Tarikh Daftar is required.
            </div>
          </div>
          <div class="col-sm">
            <label class="form-label" for="nomborKeahlian"
              >Nombor Keahlian</label
            >
            <input
              class="form-control {submitpost.error.findIndex((p) =>
                p.hasOwnProperty('nomborKeahlian')
              ) != -1
                ? 'is-invalid'
                : ''}"
              id="nomborKeahlian"
              readonly
              type="text"
              placeholder="Nombor Keahlian"
              required
              bind:value={fields.nomborKeahlian}
            />

            <div
              class="invalid-feedback"
              data-sb-feedback="nomborKeahlian:required"
            >
              Nombor Keahlian is required.
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm">
            <label class="form-label" for="jenisAhliView">Jenis Ahli</label>
            <input
              readonly
              class="form-control {submitpost.error.findIndex((p) =>
                p.hasOwnProperty('jenisAhli')
              ) != -1
                ? 'is-invalid'
                : ''}"
              id="jenisAhliView"
              type="text"
              placeholder="Jenis Ahli"
              required
              bind:value={fields.jenisAhliView}
            />

            <div class="invalid-feedback" data-sb-feedback="jenisAhli:required">
              Jenis Ahli is required.
            </div>
            <input type="hidden" id="jenisAhli" bind:value={fields.jenisAhli} />
          </div>
          <div class="col-sm">
            <label class="form-label" for="namaKariah">Kariah</label>
            <input
              readonly
              class="form-control {submitpost.error.findIndex((p) =>
                p.hasOwnProperty('namaKariah')
              ) != -1
                ? 'is-invalid'
                : ''}"
              id="namaKariah"
              type="text"
              placeholder="Kariah"
              required
              bind:value={fields.namaKariah}
            />

            <div
              class="invalid-feedback"
              data-sb-feedback="namaKariah:required"
            >
              Kariah is required.
            </div>
          </div>
        </div>

        <div class="m-5" />

        <div class="d-grid">
          <button class="btn btn-primary btn-lg" id="submitButton" type="submit"
            >Submit</button
          >
        </div>
      </form>
    </div>
  </div>
</main>

<!-- <LibLoader src="{mypluginurl}js/sb-forms-latest.js" libraryDetectionObject="sb-forms-latest" /> -->
