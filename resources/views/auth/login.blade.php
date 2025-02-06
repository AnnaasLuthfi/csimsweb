<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <title>Login</title>
</head>

<body>
    <section>
        <div class="imageBox">
            <img src="{{ asset('image/Frame_98699.png') }}" alt="">
        </div>

        <div class="contentBox">
            <div class="formBox">
                <h4>SIMS Web App</h4>
                <br>
                <h4>Masuk atau buat akun <br>untuk mulai</h4>
                <br>
                <br>

                @if (session('message'))
                <p class="success-message">{{ session('message') }}</p>
                @endif


                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="inputBox">
                        <input id="email" type="email" class="form-control"
                            name="email" required placeholder="masukan email anda">
                    </div>


                    <div class="inputBox">
                        <input id="password" type="password"
                            class="form-control" name="password" required
                            placeholder="masukan password anda">
                    </div>

                    <div class="inputBox">
                        <button type="submit" class="btn btn-primary">
                            Login
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</body>

</html>
