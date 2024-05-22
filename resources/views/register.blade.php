<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gematen | Daftar Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<style>
    .main{
        height: 100vh;
    }
    .register-box{
            width: 500px;
            border: solid 1px;
            padding: 40px;
        }
    form div{
            margin-bottom: 20px;
        }
</style>
<body>
    <div class="main d-flex flex-column justify-content-center align-items-center">
        @if ($errors->any())
            <div class="alert alert-danger" style='width: 500px'>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('status') == 'berhasil')
            <div class="alert alert-success" style='width: 500px'>
                {{ session('message') }}
            </div>
        @endif

        <div class="register-box">
            <form action="" method="POST">
                @csrf
                <div>
                    <label for="username" class='form_label'>Nama Pengguna</label>
                    <input type="text" name="username" id="username" class="form-control" required>
                </div>
                <div>
                    <label for="phone" class='form_label'>Nomor telepon</label>
                    <input type="text" name="phone" id="phone" class="form-control" required  >
                </div>
                <div>
                    <label for="email" class='form_label'>Email</label>
                    <input type="text" name="email" id="email" class="form-control" required  >
                </div>
                <div>
                    <label for="password" class='form_label'>Kata Sandi</label>
                    <input type="password" name="password" id="password" class="form-control" required >
                </div>

                <div>
                    <button type="submit" class="btn btn-primary justify-content-end">Daftar Akun</button>
                </div>
                <div>
                    <a href="login">Sudah Punya Akun? Masuk</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
