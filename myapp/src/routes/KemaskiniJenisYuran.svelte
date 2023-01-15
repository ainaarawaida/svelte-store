<script>
  import { onMount } from "svelte";
  import { onDestroy } from "svelte";
  import { data } from "./../store.js";
  import { getContext } from "svelte";
  import { createEventDispatcher } from "svelte";
  import {
    Table,
    Alert,
    Accordion,
    AccordionItem,
    Button,
    Modal,
    ModalBody,
    ModalFooter,
    ModalHeader,
  } from "sveltestrap";
  import { useParams } from "svelte-navigator";
  const params = useParams();
  let passdata = $params.id;
  let dispatch = createEventDispatcher();
  let open;
  let mypluginurl = getContext("mypluginurl");
  let myapiurl = getContext("myapiurl");
  let loading = true;
  let unsubscribe;
  let khai_user;
  let TambahanKadarYuranForm = "tambahKadarYuran";

  let submitpost = {
    error: [],
    post: "",
  };
  let fields;
  let visible;
  let kadarYurans;
  onMount(async () => {
    loading = true;
    let myPromise = new Promise(function (myResolve, myReject) {
      unsubscribe = data.subscribe((value) => {
        myResolve(value); // when successful
      });
    });
    khai_user = (await myPromise).khai_user;

    let apidata = new Promise(function (myResolve, myReject) {
      let dataArray = new FormData();
      dataArray.append("action", "KemaskiniJenisYuran");
      dataArray.append("id", passdata);
      dataArray.append("kariah_id", khai_user.data.kariah_id);
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

    let year = submitpost.get_jenisyuran[0].mulaYuran.substring(0, 4);
    let month = submitpost.get_jenisyuran[0].mulaYuran.substring(5, 7);
    let day = submitpost.get_jenisyuran[0].mulaYuran.substring(8, 10);

    fields = {
      id: passdata,
      kariah_id: khai_user.data.kariah_id,
      tajukYuran: submitpost.get_jenisyuran[0].Tajuk,
      jenisYuran: submitpost.get_jenisyuran[0].jenisYuran,
      jumlahYuran: submitpost.get_jenisyuran[0].Jumlah,
      statusYuran: submitpost.get_jenisyuran[0].statusYuran,
      keteranganYuran: submitpost.get_jenisyuran[0].keteranganYuran,
      paparanYuran: submitpost.get_jenisyuran[0].paparanYuran,
      mulaYuran: [year, month, day].join("-"),
      arraykadarYuran: JSON.stringify(
        submitpost.get_jenisyuran[0].arraykadarYuran
      ),
    };
    kadarYurans = submitpost.get_jenisyuran[0].arraykadarYuran;

    loading = false;
  });
  onDestroy(() => {
    unsubscribe;
  });
  const submitHandler = async (e) => {
    submitpost.post = "";
    submitpost.error = [];
    loading = true;
    if (e.target.getAttribute("id") == "tambahKadarYuran") {
      kadarYurans.push({
        pertalianKeluargaKadarYuran: fields.pertalianKeluargaKadarYuran,
        hadUmurKadarYuran: fields.hadUmurKadarYuran,
        keteranganKadarYuran: fields.keteranganKadarYuran,
        tambahanKadarYuran: fields.tambahanKadarYuran,
      });
      kadarYurans = kadarYurans;
      fields.arraykadarYuran = JSON.stringify(kadarYurans);
      loading = false;
      open = false;
      return;
    } else if (e.target.getAttribute("id") == "editKadarYuran") {
      kadarYurans[fields.editKadarid].pertalianKeluargaKadarYuran =
        fields.pertalianKeluargaKadarYuran;
      kadarYurans[fields.editKadarid].hadUmurKadarYuran =
        fields.hadUmurKadarYuran;
      kadarYurans[fields.editKadarid].keteranganKadarYuran =
        fields.keteranganKadarYuran;
      kadarYurans[fields.editKadarid].tambahanKadarYuran =
        fields.tambahanKadarYuran;

      loading = false;
      open = false;
      return;
    } else {
      let apidata = new Promise(function (myResolve, myReject) {
        let dataArray = new FormData();
        dataArray.append("action", "KemaskiniJenisYuran");
        dataArray.append("id", fields.id);
        dataArray.append("kariah_id", fields.kariah_id);
        dataArray.append("tajukYuran", fields.tajukYuran);
        dataArray.append("jenisYuran", fields.jenisYuran);
        dataArray.append("jumlahYuran", fields.jumlahYuran);
        dataArray.append("keteranganYuran", fields.keteranganYuran);
        dataArray.append("mulaYuran", fields.mulaYuran);
        dataArray.append("statusYuran", fields.statusYuran);
        dataArray.append("paparanYuran", fields.paparanYuran);
        dataArray.append("arraykadarYuran", fields.arraykadarYuran);

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
      loading = false;
    }
  };
  const closealert = async () => {
    visible = false;
    submitpost.error = [];
    submitpost.post = "";
  };

  const toggle = (e) => {
    if (e.target.getAttribute("name") == "tambah") {
      open = !open;
      fields.hadUmurKadarYuran = 0;
      fields.pertalianKeluargaKadarYuran = "";
      fields.keteranganKadarYuran = "";
      fields.tambahanKadarYuran = "";
    }
    if (
      e.target.getAttribute("name") == "cancel" ||
      e.target.getAttribute("class") == "btn-close"
    ) {
      open = !open;
      fields.hadUmurKadarYuran = 0;
    }
  };

  const editKadar = (e) => {
    let dataid = e.target.closest(".editkadar").getAttribute("data-pass");
    let myeditkadar = JSON.parse(fields.arraykadarYuran);

    fields.hadUmurKadarYuran = myeditkadar[dataid].hadUmurKadarYuran;
    fields.pertalianKeluargaKadarYuran =
      myeditkadar[dataid].pertalianKeluargaKadarYuran;
    fields.keteranganKadarYuran = myeditkadar[dataid].keteranganKadarYuran;
    fields.tambahanKadarYuran = myeditkadar[dataid].tambahanKadarYuran;
    fields.editKadarid = dataid;
    TambahanKadarYuranForm = "editKadarYuran";
    open = !open;
  };
  const deleteKadar = (e) => {
    let dataid = e.target.closest(".deleteKadar").getAttribute("data-pass");

    kadarYurans = JSON.parse(fields.arraykadarYuran);
    var result = kadarYurans.filter((wordx, ID) => {
      return ID != dataid;
    });
    kadarYurans = result;
    fields.arraykadarYuran = JSON.stringify(kadarYurans);
  };
</script>

<main>
  <div class="container-fluid px-4">
    <span class="fs-3 fw-bold">Kemaskini Jenis Yuran</span>

    {#if loading === true}
      <div class="d-flex justify-content-center">
        <img class="" src="{mypluginurl}assets/img/loading.gif" alt="" />
      </div>
    {:else}
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
      <div class="m-2" />

      <form id="KemaskiniJenisYuran" on:submit|preventDefault={submitHandler}>
        <input
          class="form-control"
          id="id"
          name="id"
          type="hidden"
          bind:value={fields.id}
        />
        <input
          class="form-control"
          id="kariah_id"
          name="kariah_id"
          type="hidden"
          bind:value={fields.kariah_id}
        />

        <div class="row">
          <div class="col-sm">
            <label class="form-label" for="namaPenuh">Tajuk</label>
            <input
              class="form-control {submitpost.error.findIndex((p) =>
                p.hasOwnProperty('tajukYuran')
              ) != -1
                ? 'is-invalid'
                : ''}"
              id="tajukYuran"
              type="text"
              placeholder="Tajuk Yuran"
              required
              bind:value={fields.tajukYuran}
            />

            <div
              class="invalid-feedback"
              data-sb-feedback="tajukYuran:required"
            >
              Tajuk Yuran is required.
            </div>
          </div>
          <div class="col-sm">
            <label class="form-label" for="jenisYuran">Jenis Yuran</label>
            <select
              bind:value={fields.jenisYuran}
              class="form-control"
              id="jenisYuran"
              name="jenisYuran"
              aria-required="true"
              aria-invalid="false"
              required
            >
              <option value="">Sila Pilih</option>
              <option value="One-off">One-Off</option>
              <option value="Mingguan">Mingguan</option>
              <option value="Bulanan">Bulanan</option>
              <option value="Tahunan">Tahunan</option>
            </select>

            <div
              class="invalid-feedback"
              data-sb-feedback="jenisYuran:required"
            >
              Jenis Yuran is required.
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm">
            <label class="form-label" for="namaPenuh">Jumlah (RM)</label>
            <input
              class="form-control {submitpost.error.findIndex((p) =>
                p.hasOwnProperty('jumlahYuran')
              ) != -1
                ? 'is-invalid'
                : ''}"
              id="jumlahYuran"
              type="number"
              min="0"
              placeholder="Jumlah Yuran"
              required
              bind:value={fields.jumlahYuran}
            />

            <div
              class="invalid-feedback"
              data-sb-feedback="jumlahYuran:required"
            >
              Jumlah Yuran is required.
            </div>
          </div>
          <div class="col-sm">
            <label class="form-label" for="keteranganYuran"
              >Keterangan Yuran</label
            >
            <textarea
              class="form-control {submitpost.error.findIndex((p) =>
                p.hasOwnProperty('keteranganYuran')
              ) != -1
                ? 'is-invalid'
                : ''}"
              id="keteranganYuran"
              type="text"
              placeholder="Keterangan Yuran"
              style="height: 5rem;"
              data-sb-validations="required"
              required
              bind:value={fields.keteranganYuran}
            />

            <div
              class="invalid-feedback"
              data-sb-feedback="tajukYuran:required"
            >
              Status Yuran is required.
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm">
            <label class="form-label" for="mulaYuran">Tarikh Mula</label>
            <input
              class="form-control {submitpost.error.findIndex((p) =>
                p.hasOwnProperty('mulaYuran')
              ) != -1
                ? 'is-invalid'
                : ''}"
              id="mulaYuran"
              type="date"
              placeholder="Mula Yuran"
              required
              bind:value={fields.mulaYuran}
            />
          </div>
          <div class="col-sm">
            <label class="form-label" for="statusYuran">Status</label>
            <select
              bind:value={fields.statusYuran}
              class="form-control"
              id="statusYuran"
              name="statusYuran"
              aria-required="true"
              aria-invalid="false"
              required
            >
              <option value="1">Aktif</option>
              <option value="0">Tidak Aktif</option>
            </select>

            <div
              class="invalid-feedback"
              data-sb-feedback="tajukYuran:required"
            >
              Status Yuran is required.
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm">
            <label class="form-label" for="paparanYuran"
              >Paparkan pada Senarai Pakej</label
            >
            <select
              bind:value={fields.paparanYuran}
              class="form-control"
              id="paparanYuran"
              name="paparanYuran"
              aria-required="true"
              aria-invalid="false"
              required
            >
              <option value="1">Ya</option>
              <option value="0">Tidak</option>
            </select>

            <div
              class="invalid-feedback"
              data-sb-feedback="paparanYuran:required"
            >
              Paparan Yuran is required.
            </div>
          </div>
          <div class="col-sm" />
          <input type="hidden" bind:value={fields.arraykadarYuran} />
        </div>
        <div class="m-4" />
        <div class="row">
          <div class="col">
            <a
              name="tambah"
              class="btn btn-success"
              href="Yuran - Tambah Jenis Yuran"
              on:click|preventDefault={(e) => toggle(e)}
              ><i class="fa fa-plus" /> Tambah Kadar Yuran</a
            >
          </div>
        </div>
        <div class="row">
          <div class="col">
            <Table responsive>
              <thead>
                <tr>
                  <th>#</th>
                  <th>Pertalian</th>
                  <th>Had Umur</th>
                  <th>Keterangan</th>
                  <th>Tambahan Kadar Yuran</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                {#if kadarYurans}
                  {#each kadarYurans as kadarYuran, i}
                    <tr>
                      <th scope="row">{i + 1}</th>
                      <td>{kadarYuran.pertalianKeluargaKadarYuran}</td>
                      <td>{kadarYuran.hadUmurKadarYuran}</td>
                      <td>{kadarYuran.keteranganKadarYuran}</td>
                      <td>{kadarYuran.tambahanKadarYuran}</td>
                      <td
                        ><div style="width:75px;">
                          <button
                            on:click={(e) => {
                              editKadar(e);
                            }}
                            type="button"
                            class="btn btn-primary btn-sm editkadar"
                            data-pass={i}
                            ><svg
                              xmlns="http://www.w3.org/2000/svg"
                              width="16"
                              height="16"
                              fill="currentColor"
                              class="bi bi-pencil-square"
                              viewBox="0 0 16 16"
                            >
                              <path
                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"
                              />
                              <path
                                fill-rule="evenodd"
                                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"
                              />
                            </svg></button
                          ><button
                            type="button"
                            class="btn btn-danger btn-sm deleteKadar"
                            on:click={(e) => {
                              deleteKadar(e);
                            }}
                            data-pass={i}
                            ><svg
                              xmlns="http://www.w3.org/2000/svg"
                              width="16"
                              height="16"
                              fill="currentColor"
                              class="bi bi-trash3-fill"
                              viewBox="0 0 16 16"
                            >
                              <path
                                d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"
                              />
                            </svg></button
                          >
                        </div></td
                      >
                    </tr>
                  {/each}
                {/if}
              </tbody>
            </Table>
          </div>
        </div>
        <div class="m-5" />

        <div class="d-grid">
          <button class="btn btn-primary btn-lg" id="submitButton" type="submit"
            >Submit</button
          >
        </div>
      </form>

      <div>
        <Modal size="lg" isOpen={open} {toggle}>
          <form
            id={TambahanKadarYuranForm}
            on:submit|preventDefault={submitHandler}
          >
            <ModalHeader {toggle}>Tambahan Kadar Yuran</ModalHeader>
            <ModalBody>
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
              <div class="row">
                <div class="col-sm">
                  <label class="form-label" for="pertalianKeluargaKadarYuran"
                    >Pertalian Keluarga</label
                  >
                  <select
                    bind:value={fields.pertalianKeluargaKadarYuran}
                    class="form-control"
                    id="pertalianKeluargaKadarYuran"
                    name="pertalianKeluargaKadarYuran"
                    aria-required="true"
                    aria-invalid="false"
                    required
                  >
                    <option value="">Sila Pilih</option>
                    <option value="PASANGAN">PASANGAN</option>
                    <option value="ANAK">ANAK</option>
                    <option value="IBU/BAPA">IBU/BAPA</option>
                    <option value="DATUK/NENEK">DATUK/NENEK</option>
                    <option value="LAIN-LAIN">LAIN-LAIN</option>
                  </select>
                </div>
                <div class="col-sm">
                  <label class="form-label" for="hadUmurKadarYuran"
                    >Had Umur ke Atas</label
                  >
                  <input
                    class="form-control {submitpost.error.findIndex((p) =>
                      p.hasOwnProperty('hadUmurKadarYuran')
                    ) != -1
                      ? 'is-invalid'
                      : ''}"
                    id="hadUmurKadarYuran"
                    type="number"
                    min="0"
                    max="999"
                    placeholder="Had Umur ke atas. 0 untuk semua umur"
                    bind:value={fields.hadUmurKadarYuran}
                  />
                </div>
              </div>

              <div class="row">
                <div class="col-sm">
                  <label class="form-label" for="keteranganKadarYuran"
                    >Keterangan Yuran</label
                  >
                  <textarea
                    class="form-control {submitpost.error.findIndex((p) =>
                      p.hasOwnProperty('keteranganKadarYuran')
                    ) != -1
                      ? 'is-invalid'
                      : ''}"
                    id="keteranganKadarYuran"
                    type="text"
                    placeholder="Keterangan Kadar Yuran"
                    style="height: 5rem;"
                    data-sb-validations="required"
                    required
                    bind:value={fields.keteranganKadarYuran}
                  />
                </div>
                <div class="col-sm">
                  <label class="form-label" for="tambahanKadarYuran"
                    >Tambahan Kadar (RM)</label
                  >
                  <input
                    class="form-control {submitpost.error.findIndex((p) =>
                      p.hasOwnProperty('tambahanKadarYuran')
                    ) != -1
                      ? 'is-invalid'
                      : ''}"
                    id="tambahanKadarYuran"
                    type="number"
                    min="0"
                    placeholder="Tambahan Kadar Yuran"
                    required
                    bind:value={fields.tambahanKadarYuran}
                  />
                </div>
              </div>

              <div class="m-3" />
            </ModalBody>
            <ModalFooter>
              <Button type="submit" color="primary" on:click={toggle}
                >{TambahanKadarYuranForm == "editKadarYuran"
                  ? "Edit"
                  : "Tambah"}</Button
              >
              <Button
                type="button"
                name="cancel"
                color="secondary"
                on:click={toggle}>Cancel</Button
              >
            </ModalFooter>
          </form>
        </Modal>
      </div>
    {/if}
  </div>
</main>
