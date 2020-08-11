<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
  <meta name="author" content="GeeksLabs">
  <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
  <link rel="shortcut icon" href="{{ asset('Admins') }}/img/favicon.png">

  <title>Login Page</title>

  <!-- Bootstrap CSS -->
  <link href="{{ asset('Admins') }}/css/bootstrap.min.css" rel="stylesheet">
  <!-- bootstrap theme -->
  <link href="{{ asset('Admins') }}/css/bootstrap-theme.css" rel="stylesheet">
  <!--external css-->
  <!-- font icon -->
  <link href="{{ asset('Admins') }}/css/elegant-icons-style.css" rel="stylesheet" />
  <link href="{{ asset('Admins') }}/css/font-awesome.css" rel="stylesheet" />
  <!-- Custom styles -->
  <link href="{{ asset('Admins') }}/css/style.css" rel="stylesheet">
  <link href="{{ asset('Admins') }}/css/style-responsive.css" rel="stylesheet" />

 
</head>

<body class="login-img3-body">

  <div class="container">

    <form class="login-form" action="{{ route('login') }}" method="POST">
      {!! csrf_field() !!}
      <div class="login-wrap">
        <p class="login-img"><i class="icon_lock_alt"></i></p>
        <div class="input-group">
          <span class="input-group-addon"><i class="icon_profile"></i></span>
          <input type="text" name="username" class="form-control" placeholder="Username" autofocus autocomplete="off">
        </div>
        <div class="input-group">
          <span class="input-group-addon"><i class="icon_key_alt"></i></span>
          <input type="password" name="password" class="form-control" placeholder="Password">
        </div>
        <label class="checkbox">
                <input type="checkbox" value="remember-me"> Remember me
                <span class="pull-right"> <a href="#"> Forgot Password?</a></span>
            </label>
        <button class="btn btn-primary btn-lg btn-block" type="submit">Login</button>
        <a href="{{ route('userregister') }}" class="btn btn-info btn-lg btn-block">Sign Up</a>
      </div>
    </form>
    <div class="text-right">
      <div class="credits">
          <!--
            All the links in the footer should remain intact.
            You can delete the links only if you purchased the pro version.
            Licensing information: https://bootstrapmade.com/license/
            Purchase the pro version form: https://bootstrapmade.com/buy/?theme=NiceAdmin
          -->
          {{-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> --}}
        </div>
    </div>
  </div>


</body>

</html>
