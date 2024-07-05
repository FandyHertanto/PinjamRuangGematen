<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gematen | Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        .main {
            height: 100vh;
            box-sizing: border-box;
        }
        .login-box {
            width: 500px;
            border: solid 1px;
            padding: 40px;
        }
        form div {
            margin-bottom: 20px;
        }
        .google-btn {
            display: flex;
            align-items: center;
        }
        .google-icon {
            margin-right: 10px;
        }
    </style>
</head>
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
                
                {{-- <div>
                    <label for="email" class='form_label'>Nama Pengguna</label>
                    <input type="text" name="email" id="email" class="form-control">
                </div>
                <div>
                    <label for="password" class='form_label'>Password</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div> --}}
                <h3 class="text-center">Masuk GematenRuang</h3>
                <div class="text-center">
                    <a href="register" style="text-decoration: none; color:black;">Belum Punya Akun GematenRuang? <span
                            style="color: blue">Daftar</span> </a>
                </div>
                <div>
                    <label for="email" class='form_label'>email</label>
                    <input type="email" name="email" id="email" class="form-control">
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-block w-100" style="border-radius: 5px; padding: 15px;">Masuk</button>
                </div>

                <div class="text-center">
                    <span>atau</span>
                </div>
                
                <div class="w-3/5 mx-auto mt-4">
                    
                <div style="border: 1px solid #cccccc; border-radius: 5px; padding: 5px; display: flex; align-items: center; justify-content: center;">
                    <a href="auth/redirect" style="text-decoration: none; display: inline-block; padding: 10px ;">
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="30" height="30" viewBox="0 0 48 48">
                            <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"></path>
                            <path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"></path>
                            <path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"></path>
                            <path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"></path>
                        </svg>
                        <span style="vertical-align: middle; margin-left: 10px;">Masuk dengan Google</span>
                    </a>
                </div>
                
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
