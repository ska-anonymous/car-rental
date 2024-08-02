<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Car Rental | Register</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">

  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="../plugins/toastr/toastr.min.css">
</head>

<style>
  .invalid {
    box-shadow: 0px 0px 0px 2px rgb(255, 0, 0, 0.4);
  }

  .fa-lock,
  .fa-unlock {
    cursor: pointer;
  }
</style>

<body class="hold-transition register-page">
  <div class="register-box">
    <div class="register-logo">
      <a href="#"><b>Car Rental</b></a>
    </div>

    <div class="card">
      <div class="card-body register-card-body">
        <p class="login-box-msg">Register a new membership</p>

        <form id="register_form">
          <div class="input-group mb-3">
            <input type="text" maxlength="20" class="form-control" name="user_name" placeholder="Full name" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="email" maxlength="50" name="user_email" class="form-control" placeholder="Email" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="text" maxlength="20" name="user_login_id" class="form-control" placeholder="Login id" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" minlength="8" maxlength="15" name="user_pass" class="form-control"
              placeholder="Password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock password-toggler"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" minlength="8" maxlength="15" name="user_pass_retype" class="form-control"
              placeholder="Retype password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock password-toggler"></span>
              </div>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-12">
              <button type="submit" name="btn_submit" id="btn_submit"
                class="btn btn-primary btn-block">Register</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <!-- <div class="social-auth-links text-center">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i>
          Sign up using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i>
          Sign up using Google+
        </a>
      </div> -->

        <a href="login.php" class="text-center">Already have a membership? <strong>Login</strong></a>
      </div>
      <!-- /.form-box -->
    </div><!-- /.card -->
  </div>
  <!-- /.register-box -->

  <!-- jQuery -->
  <script src="../plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../dist/js/adminlte.min.js"></script>

  <!-- SweetAlert2 -->
  <script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
  <!-- Toastr -->
  <script src="../plugins/toastr/toastr.min.js"></script>

  <script>
    // submit Registration form through ajax to process Registration
    let form = document.querySelector('#register_form');
    let btnSubmit = form.querySelector('#btn_submit');

    form.addEventListener('submit', (e) => {
      e.preventDefault();

      let formData = new FormData(form);

      btnSubmit.disabled = true;
      btnSubmit.textContent = "Registering.....";

      // make post request using fetch
      let url = "../php_processing/do_ajax_register.php";

      fetch(url, {
        method: "POST",
        body: formData,
      })
        .then(response => {
          return response.json();
        },
          (err) => {
            toastr.error("No Internet Connection");
          })
        .then(jsonData => {
          if (jsonData.error) {
            if (jsonData.invalid_field && jsonData.invalid_field != "") {
              form.querySelector(`input[name=${jsonData.invalid_field}]`).classList.add("invalid");
            }
            toastr.error(jsonData.error_message);
          } else {
            form.reset();
            toastr.success("Registration Successfull");
            setTimeout(() => {
              location.replace("login.php");
            }, 1000)
          }

        })
        .catch(err => {
          toastr.error("Registration Failed! Please try again later");
        })
        .finally(() => {
          btnSubmit.disabled = false;
          btnSubmit.textContent = "Register";
        })

    })

    // remove invalid class styling from form input fields if they are set due to invalid data
    let inputs = form.querySelectorAll('input');
    Array.from(inputs).forEach(input => {
      input.addEventListener('input', () => {
        input.classList.remove('invalid');
      })
    })

    // toggle show/hide password in password fields
    let toggleButtons = document.querySelectorAll('.password-toggler');
    toggleButtons.forEach(button => {
      button.addEventListener('click', (e) => {
        let inputElement = e.target.closest('.input-group.mb-3').querySelector('input');
        if (inputElement.type === "password") {
          inputElement.type = "text";
          button.classList.remove('fa-lock');
          button.classList.add('fa-unlock');
        } else {
          inputElement.type = "password";
          button.classList.remove('fa-unlock');
          button.classList.add('fa-lock');
        }
      })
    })
  </script>
</body>

</html>