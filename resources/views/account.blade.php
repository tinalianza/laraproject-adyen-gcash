@extends('layouts.app')

@section('title', 'Guidelines - BUsina Online')

@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - BUsina Online</title>
    <!-- Link to Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
            body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f8f9fa; /* Light background color */
        }
        .login-container {
            width: 400px;
            padding: 20px;
            background-image: url('{{ asset('images/loginbg.png') }}'); /* Background image */
            background-size: cover; /* Cover the entire container */
            background-position: center; /* Center the background image */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }
        .login-container h1 {
            font-size: 24px;
            color: black;
        }
        .login-container h1 .bee {
            color: #0061A6;
        }
        .login-container h1 .per {
            color: #F2752B;
        }
        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 5px;
            margin: 5px;
            border: 1px solid #ccc;
            border-radius: 30px;
            box-sizing: border-box; /* Ensure padding is included in width */
           /** font-size: 10px;**/
        }
        .login-container button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .login-container button:hover {
            background-color: #0056b3;
        }
        .login-container a {
            display: block;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        }
        .login-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>My <span class="bee">Bee</span><span class="per">per</span> Account</h1>
        <input type="text" placeholder="Enter Application Codeee" required>
        <input type="password" placeholder="Enter Password" required>
        <a href="{{ url('view') }}">View Account</a>
        <a href="{{route('register')}}">Apply Now</a>
        <a href="#">Forget Password</a>
    </div>
</body>
</html>
@endsection