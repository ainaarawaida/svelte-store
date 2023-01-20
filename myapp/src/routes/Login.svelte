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
  let mybaseurl = getContext("mybaseurl");

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

    await loadScript(`${mypluginurl}/assets/js/jquery-3.5.1.min.js`);
    await loadScript(
      `${mypluginurl}/assets/js/icons/feather-icon/feather.min.js`
    );
    await loadScript(
      `${mypluginurl}/assets/js/icons/feather-icon/feather-icon.js`
    );

    await loadScript(`${mypluginurl}/assets/js/config.js`);
    await loadScript(`${mypluginurl}/assets/js/bootstrap/popper.min.js`);
    await loadScript(`${mypluginurl}/assets/js/bootstrap/bootstrap.min.js`);
    await loadScript(`${mypluginurl}/assets/js/script.js`);

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

  // $: console.log("myapiurl", myapiurl);
</script>

<section>
  <div class="container-fluid p-0">
    <div class="row">
      <div class="col-12">
        <div class="login-card">
          <form
            class="theme-form login-form"
            on:submit|preventDefault={submitHandler}
          >
            <h4>Login</h4>
            <h6>Welcome back! Log in to your account.</h6>
            <div class="form-group">
              <label for="username">Email Address</label>
              <div class="input-group">
                <span class="input-group-text"><i class="icon-email" /></span>
                <input
                  id="username"
                  name="username"
                  class="form-control"
                  type="email"
                  required
                  placeholder=""
                  bind:value={fields.username}
                />
              </div>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <div class="input-group">
                <span class="input-group-text"><i class="icon-lock" /></span>
                <input
                  id="password"
                  class="form-control"
                  type="password"
                  name="password"
                  required
                  placeholder=""
                  bind:value={fields.password}
                />
                <div class="show-hide"><span class="show" /></div>
              </div>
            </div>
            <div class="form-group">
              <div class="checkbox">
                <input id="checkbox1" type="checkbox" />
                <label for="checkbox1">Remember password</label>
              </div>
              <a class="link" href="forget-password.html">Forgot password?</a>
            </div>
            <div class="form-group">
              <button class="btn btn-primary btn-block" type="submit"
                >Sign in</button
              >
            </div>
            <div class="login-social-title">
              <h5>Sign in with</h5>
            </div>
            <div class="form-group">
              <ul class="login-social">
                <li>
                  <a href="https://www.linkedin.com/login" target="_blank"
                    ><i data-feather="linkedin" /></a
                  >
                </li>
                <li>
                  <a href="https://www.linkedin.com/login" target="_blank"
                    ><i data-feather="twitter" /></a
                  >
                </li>
                <li>
                  <a href="https://www.linkedin.com/login" target="_blank"
                    ><i data-feather="facebook" /></a
                  >
                </li>
                <li>
                  <a href="https://www.instagram.com/login" target="_blank"
                    ><i data-feather="instagram" /></a
                  >
                </li>
              </ul>
            </div>
            <p>
              Don't have account?<a class="ms-2" href="log-in.html"
                >Create Account</a
              >
            </p>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
