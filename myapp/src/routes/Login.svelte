<script>
  import { onMount } from "svelte";
  import { setContext } from "svelte";
  import { data } from "./../store.js";
  import { onDestroy } from "svelte";
  import { loadScript } from "./../document.js";
  import { getContext } from "svelte";
  import { navigate, Router, Link, Route } from "svelte-navigator";
  import { globalHistory } from "svelte-navigator/src/history";
  let mylinkurl = getContext("mylinkurl");
  let pathname = window.location.pathname;
  let unsub;
  let mypluginurl = getContext("mypluginurl");
  let myapiurl = getContext("myapiurl");

  let _data;
  let fields = {
    username: "",
    password: "",
  };

  data.update((currentPolls) => {
    _data = currentPolls;
    return currentPolls;
  });
  onMount(async () => {
    unsub = globalHistory.listen(({ location, action }) => {
      pathname = location.pathname;
    });

    if (_data.user && Object.keys(_data.user).length != 0) {
      navigate(mylinkurl + "/");
      location.reload();
    }
  });
  onDestroy(() => {
    unsub();
  });

  const submitHandler = async () => {
    data.update((currentPolls) => {
      _data.loading = true;
      localStorage.setItem("_data", JSON.stringify(_data));
      return currentPolls;
    });
    // console.log("myapiurl", myapiurl);
    let apidata = new Promise(function (myResolve, myReject) {
      let dataArray = new FormData();
      dataArray.append("action", "Login");
      dataArray.append("id", fields.username);
      dataArray.append("namaPenuh", fields.password);
      fetch(
        myapiurl +
          `/jwt-auth/v1/token?username=${fields.username}&password=${fields.password}`,
        {
          method: "POST",
          body: dataArray,
        }
      )
        .then((response) => response.json())
        .then((result) => {
          myResolve(result);
        })
        .catch((error) => console.log("error", error));
    });

    let savedata = await apidata;
    // console.log("mypluginurl", savedata.token);
    if (savedata.token) {
      data.update((currentPolls) => {
        _data.user = savedata;
        _data.loading = false;
        localStorage.setItem("_data", JSON.stringify(_data));
        return currentPolls;
      });
      navigate(mylinkurl + "/");
      location.reload();
    } else {
      data.update((currentPolls) => {
        _data.loading = false;
        localStorage.setItem("_data", JSON.stringify(_data));
        return currentPolls;
      });
      alert("salah credential");
    }
  };
</script>

<div id="page-container">
  <!-- Main Container -->
  <main id="main-container">
    <!-- Page Content -->
    <div class="hero-static d-flex align-items-center">
      <div class="content">
        <div class="row justify-content-center push">
          <div class="col-md-8 col-lg-6 col-xl-4">
            <!-- Sign In Block -->
            <div class="block block-rounded mb-0">
              <div class="block-header block-header-default">
                <h3 class="block-title">Sign In</h3>
                <div class="block-options">
                  <a class="btn-block-option fs-sm" href="op_auth_reminder.html"
                    >Forgot Password?</a
                  >
                  <a
                    class="btn-block-option"
                    href="op_auth_signup.html"
                    data-bs-toggle="tooltip"
                    data-bs-placement="left"
                    title="New Account"
                  >
                    <i class="fa fa-user-plus" />
                  </a>
                </div>
              </div>
              <div class="block-content">
                <div class="p-sm-3 px-lg-4 px-xxl-5 py-lg-5">
                  <h1 class="h2 mb-1">Svelte</h1>
                  <p class="fw-medium text-muted">Welcome, please login.</p>

                  <!-- Sign In Form -->
                  <!-- jQuery Validation (.js-validation-signin class is initialized in js/pages/op_auth_signin.min.js which was auto compiled from _js/pages/op_auth_signin.js) -->
                  <!-- For more info and examples you can check out https://github.com/jzaefferer/jquery-validation -->
                  <form
                    on:submit|preventDefault={submitHandler}
                    class="js-validation-signin"
                  >
                    <div class="py-3">
                      <div class="mb-4">
                        <input
                          type="text"
                          class="form-control form-control-alt form-control-lg"
                          id="login-username"
                          name="username"
                          placeholder="Username"
                          bind:value={fields.username}
                        />
                      </div>
                      <div class="mb-4">
                        <input
                          type="password"
                          class="form-control form-control-alt form-control-lg"
                          id="login-password"
                          name="password"
                          placeholder="Password"
                          bind:value={fields.password}
                        />
                      </div>
                      <div class="mb-4">
                        <div class="form-check">
                          <input
                            class="form-check-input"
                            type="checkbox"
                            value=""
                            id="login-remember"
                            name="login-remember"
                          />
                          <label class="form-check-label" for="login-remember"
                            >Remember Me</label
                          >
                        </div>
                      </div>
                    </div>
                    <div class="row mb-4">
                      <div class="col-md-6 col-xl-5">
                        <button type="submit" class="btn w-100 btn-alt-primary">
                          <i class="fa fa-fw fa-sign-in-alt me-1 opacity-50" /> Sign
                          In
                        </button>
                      </div>
                    </div>
                  </form>
                  <!-- END Sign In Form -->
                </div>
              </div>
            </div>
            <!-- END Sign In Block -->
          </div>
        </div>
        <div class="fs-sm text-muted text-center">
          <strong>Svelte</strong> &copy; <span data-toggle="year-copy" />
        </div>
      </div>
    </div>
    <!-- END Page Content -->
  </main>
  <!-- END Main Container -->
</div>
<!-- END Page Container -->
