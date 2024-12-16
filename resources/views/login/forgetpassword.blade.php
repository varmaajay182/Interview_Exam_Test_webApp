<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        form {
            max-width: 400px;
            margin: 0 auto;
        }

        h2 {
            margin-top: 0;
        }

        p {
            color: #666;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="email"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            display: block;
            width: 100%;
            padding: 10px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
    <link rel="stylesheet" href="styles.css"> <!-- Link your CSS file -->
</head>

<body>
    <div class="container">
        <form action="/forgetpassword" method="post">
            @csrf
            <h2>Forgot Password</h2>
            <p>Please enter the email address associated with your account. We'll send you a link to reset your
                password.</p>
            @if (Session::has('success'))
                <p class="" style="color:rgb(41, 187, 206)" id="error">{{ Session::get('success') }}</p>
                <script>
                    setTimeout(function() {
                        document.getElementById('error').style.display = 'none';
                    }, 3000);
                </script>
            @endif
            @if (Session::has('errors'))
                <p class="text-danger" style="color:red" id="error">{{ Session::get('errors') }}</p>
                <script>
                    setTimeout(function() {
                        document.getElementById('error').style.display = 'none';
                    }, 3000);
                </script>
            @endif

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <button type="submit">Reset Password</button>
        </form>
    </div>
</body>

</html>
