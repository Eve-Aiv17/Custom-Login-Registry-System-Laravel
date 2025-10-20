<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register | My Laravel App</title>
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:500" rel="stylesheet" type="text/css">
    <style>
        body {
           background: url('http://cdn.wallpapersafari.com/13/6/Mpsg2b.jpg') no-repeat center center fixed;
            background-size: 400% 400%;
            animation: gradientBG 10s ease infinite;
            margin: 0;
            font-family: 'Ubuntu', sans-serif;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        h1, h2, h3, h4, h5, h6, a {
            mmargin: 0; padding: 0; color: #4a0b0bff;
        }

        .register {
            margin: 0 auto;
            max-width: 500px;
        }

        .register-header {
            color: #fff;
            text-align: center;
            font-size: 300%;
            margin-top: 40px;
        }

        .register-form {
            border: .5px solid #fff;
            background: linear-gradient(135deg, #dc8706ff, #deaa02ff, #f86641ff);
            border-radius: 10px;
            box-shadow: 0px 0px 10px #894005ff;
            box-sizing: border-box;
            padding-top: 15px;
            padding-bottom: 10%;
            margin: 5% auto;
            text-align: center;
        }

        .register-form h3 {
            text-align: left;
            margin-left: 40px;
            color: #782e03ff;
        }

        .register input[type="text"],
        .register input[type="email"],
        .register input[type="password"] {
            max-width: 400px;
            width: 80%;
            line-height: 3em;
            font-family: 'Ubuntu', sans-serif;
            margin: 1em 2em;
            border-radius: 5px;
            border: 2px solid #110202ff;
            outline: none;
            padding-left: 10px;
        }

        .register-form button {
            height: 35px;
            width: 110px;
            background: #dbbb52ff;
            border: 1px solid #3f0404ff;
            border-radius: 20px;
            color: slategrey;
            text-transform: uppercase;
            font-family: 'Ubuntu', sans-serif;
            cursor: pointer;
        }

        .sign-in {
            display: block;
            color: #1f0303ff;
            margin-top: 15px;
            text-align: center;
            cursor: pointer;
            text-decoration: underline;
        }

        .error-page {
            display: none;
            text-align: center;
            color: #eb8383ff;
            font-size: 22px;
        }

        .try-again {
            color: #f2f2f2;
            text-decoration: underline;
            cursor: pointer;
        }

        /* Responsive */
        @media only screen and (min-width: 150px) and (max-width: 530px) {
            .register-form h3 {
                text-align: center;
                margin: 0;
            }
            .sign-in {
                margin: 10px 0;
            }
            .register-button {
                margin-bottom: 10px;
            }
        }

        /* Laravel Error Styles */
        .alert {
            color: #ffcccc;
            background-color: rgba(255, 0, 0, 0.2);
            border-radius: 10px;
            padding: 10px;
            margin: 10px auto;
            width: 80%;
        }
    </style>
</head>
<body>
    <div class="register">
        <div class="register-header">
            <h1>Register</h1>
        </div>

        <div class="register-form">
            <form action="{{ route('register.post') }}" method="POST">
                @csrf

                <h3>Name:</h3>
                <input type="text" name="name" placeholder="Enter Name" value="{{ old('name') }}" required>

                <h3>Email:</h3>
                <input type="email" name="email" placeholder="Enter Email" value="{{ old('email') }}" required>

                <h3>Password:</h3>
                <input type="password" name="password" placeholder="Enter Password" required>

                <h3>Confirm Password:</h3>
                <input type="password" name="password_confirmation" placeholder="Confirm Password" required>

                <br>
                <button type="submit" class="register-button">Register</button>

                <br><br>
                <a href="{{ route('login') }}" class="sign-in">Already have an account?</a>

                @if ($errors->any())
                    <div class="alert">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
            </form>
        </div>
    </div>

    <div class="error-page">
        <div class="try-again">Error: Try again?</div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('.error-page').hide(0);
        $('.register-button').click(function(){
            $('.register').slideUp(500);
            $('.error-page').slideDown(1000);
        });
        $('.try-again').click(function(){
            $('.error-page').hide(0);
            $('.register').slideDown(1000);
        });
    </script>
</body>
</html>

