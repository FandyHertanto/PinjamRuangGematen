<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gematen | Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

    <style>
        .main{
            height: 100vh;
            box-sizing: border-box;
        }
        .login-box{
            width: 500px;
            border: solid 1px;
            padding: 40px;
        }
        form div{
            margin-bottom: 20px;
        }
    </style>
<body>
    <div class='main d-flex flex-column justify-content-center align-items-center'>
        @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }} <br>
            @endforeach
        </div>
        @endif
        <div class="login-box">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div>
                    <label for="email" class='form_label'>Email / Nama Pengguna</label>
                    <input type="text" name="email" id="email" class="form-control"   >
                </div>
                <div>
                    <label for="password" class='form_label'>password</label>
                    <input type="password" name="password" id="password" class="form-control"  >
                </div>
                <div>
                    <button type="submit" class="btn btn-primary justify-content-end">Masuk</button>
                </div>
                <div>
                    <a href="register">Belum Punya Akun? Daftar</a>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>
