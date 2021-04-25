<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="author" content="your name">
  <meta name="description" content="include some description about your page">

  <title>Landing Page</title>

  <!--bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
    integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

  <style>
    <?php include '../stylesheets/user/landing_page.css'; ?>
  </style>

</head>

<body>
<?php 
  //starts the user session. just put this in every file that you want the user to be logged in.
    session_start(); 
    if (isset($_SESSION["userID"])){
      header("Location: ./main_feed.php");
    }

     ?>
  <header>
    <nav class="navbar navbar-expand-md bg-light navbar-light">
      <a class="navbar-brand" href="#">Project Finder</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>


      <div class="collapse navbar-collapse justify-content-center" id="collapsibleNavbar">
        <ul class="navbar-nav mx-auto">

        </ul>
      </div>
    </nav>
  </header>
  <div class="container">
    <div class="landing-image">
      <img
        src="https://images.unsplash.com/photo-1580927752452-89d86da3fa0a?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800&q=50">
    </div>

    <div id="login-signup-panel" style="display: block">
      <form id="login-signup-panel-form" onsubmit="return checkLoginCredentials()" action="../php/user/login.php" method="post">
      <h3 id="login-signup-panel-title">User Log In</h3>
      <div class="signup-msg">
            <?php 
              if(isset($_SESSION['signup_success'])) {
                if( $_SESSION["signup_success"]){
                  echo "<div style='color: green'>" . "Sign up success! Please log in." . "</div>";
                } else{
                  echo "<div style='color: red'>" . $_SESSION['signup_error_message'] . "</div>";
                }
              }
              ?>
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Email address</label>
          <input type="email" name="email" class="form-control" id="email-input" aria-describedby="emailHelp"
            placeholder="Enter email">
        </div>
        <div class="feedback">
          <div id="email-msg"></div>
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Password</label>
          <input type="password" name="password" class="form-control" id="password-input" placeholder="Password">
        </div>
        <div class="feedback">
          <div id="password-msg">
          <?php 
            if(isset($_SESSION['login_error_message'])) {
              
              echo $_SESSION['login_error_message'];
            }
            ?>
          </div>
        </div>
        <div class="form-group" id="signup-name">
          <label for="exampleInputName">Name</label>
          <input type="text" name="signup_name" class="form-control" id="signup-name-input" placeholder="Enter your name">
        </div>
        <div class="feedback">
          <div id="name-msg"></div>
        </div>


        <div class="submit-button">
          <button id="login-button" type="submit" class="btn btn-primary" >Log in</button>
        </div>
        <div class="submit-button">
          <button id="signup-button" type="button" class="btn btn-secondary" onclick="togglePanel()">Sign up</button>
        </div>

      </form>
      <div id="login-as-owner">
        <button type="button" class="btn btn-outline-primary" onclick="location.href='../pages_owner/landing_page.php';">Log in as Project Owner</button>
      </div>
    </div>



  </div>

  <!-- JavaScript -->
  <script>

    var addEventListenersToInput = function(){
      function checkPassword() {
        var msg = document.getElementById("password-msg");
        if (this.value.length == 0) {
          msg.textContent = "Password cannot be empty";

        } else if (this.value.length < 3) {
          msg.textContent = "Password cannot be shorter than 3 characters";
        } else
          msg.textContent = "";
      }

      var password = document.getElementById("password-input");
      password.addEventListener('blur', checkPassword, false);

      function checkEmail() {
        var msg = document.getElementById("email-msg");

        var pattern = new RegExp(".{1,}@.{1,}");
        var match_test = pattern.test(this.value);
        console.log(this.value)
        if (match_test) {
          msg.textContent = "";
        } else {
          msg.textContent = "Enter a valid email";
        }
      }

      var email = document.getElementById("email-input");
      email.addEventListener('blur', checkEmail, false);
      var login = function () {
      }

      function checkName(){
        var msg = document.getElementById("name-msg");
        if (this.value.length == 0) {
          msg.textContent = "Name cannot be empty";

        } else if (this.value.length > 15) {
          msg.textContent = "Name cannot be longer than 15 characters";
        } else
          msg.textContent = "";
      }
      var currSignUpName = document.getElementById("signup-name-input");
      currSignUpName.addEventListener('blur', checkName, false);

    }
    addEventListenersToInput()

    var checkLoginCredentials = function () {
      var email = document.getElementById("email-input");
      var pattern = new RegExp(".{1,}@.{1,}");
      var emailValid = pattern.test(email.value);

      var password = document.getElementById("password-input");
      
      // var name = document.getElementBy

      var passwordValid = false
      if (password.value.length >= 3) {
        passwordValid = true
      }
      console.log(emailValid && passwordValid);
      return (emailValid && passwordValid);
    }

    //toggle login or sign up
    var togglePanel = function () {
      var panel = document.getElementById("login-signup-panel");
      var panelTitle = document.getElementById("login-signup-panel-title");
      var panelForm = document.getElementById("login-signup-panel-form");
      var panelFormURL = panelForm.action.toString()
      var loginButton = document.getElementById("login-button");
      var signUpButton = document.getElementById("signup-button");
      var signUpName = document.getElementById("signup-name");

      if (panelFormURL.substr(panelFormURL.length - 9) === "login.php"){
        panelForm.action = "../php/user/signup.php";
        panelTitle.textContent = "User Sign Up";
        loginButton.className = "btn btn-secondary";
        signUpButton.className = "btn btn-primary";

        loginButton.setAttribute("onclick","togglePanel();");
        loginButton.setAttribute("type","button");

        signUpButton.setAttribute("type", "submit");
        signUpButton.removeAttribute("onclick");
        signUpName.style.display = "block";


      } else if (panelFormURL.substr(panelFormURL.length - 10) === "signup.php"){
        panelForm.action = "../php/user/login.php";
        panelTitle.textContent = "User Log In";
        signUpButton.className = "btn btn-secondary";
        loginButton.className = "btn btn-primary";

        signUpButton.setAttribute("onclick", "togglePanel();");
        signUpButton.setAttribute("type","button");

        loginButton.setAttribute("type", "submit");
        loginButton.removeAttribute("onclick");
        signUpName.style.display = "none";
        var msg = document.getElementById("name-msg");
        msg.textContent = "";
      }
      var email = document.getElementById("email-input");
      email.value = "";
      var password = document.getElementById("password-input");
      password.value = "";
      var msg = document.getElementById("email-msg");
      msg.textContent = "";
      var msg = document.getElementById("password-msg");
      msg.textContent = "";
    }

  </script>


  <!-- CDN for JS bootstrap -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns"
    crossorigin="anonymous"></script>


</body>

</html>