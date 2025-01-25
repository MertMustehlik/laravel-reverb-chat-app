<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
</head>
<body class="bg-body-tertiary">
<div class="d-flex justify-content-center">
    <div class="card" style="margin-top: 150px">
        <b>Accounts</b>
        <small>test@example.com --- 123123</small>
        <small>test2@example.com --- 123123</small>
        <div class="card-header text-center">
            <h4>Chat - App</h4>
            <small>Login</small>
        </div>
        <div class="card-body">
            <form id="loginForm" class="row g-3">
                @csrf
                <div class="col-12">
                    <label for="email">E-Mail</label>
                    <input id="email" type="text" name="email" class="form-control" value="test@example.com">
                </div>
                <div class="col-12">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" class="form-control" value="123123">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/js/popper.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function (){
        $(document).on('submit', '#loginForm', function (e){
            e.preventDefault()
            $.ajax({
                type: 'POST',
                url: '{{route('auth.login-post')}}',
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                processData: false,
                cache: false,
                beforeSend: function () {
                    //
                },
                success: function(res) {
                    Swal.fire({
                        title: "Successful",
                        text: 'Login Successful. You are being redirected...',
                        icon: "success",
                        showConfirmButton: 0,
                        allowOutsideClick: false,
                    })
                    setTimeout(() => {
                        window.location.href = res.redirectUrl;
                    }, 1000)
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: "Error",
                        text: xhr.responseJSON?.message ?? '',
                        icon: "error",
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        showCancelButton: true,
                        cancelButtonText: 'Close',
                        customClass: {
                            cancelButton: 'btn btn-secondary btn-sm'
                        }
                    })
                },
                complete: function() {
                    //
                }
            })
        })
    })
</script>
</body>
</html>
