<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Link to Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
 
    <style>
        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            font-family: 'Poppins', sans-serif; /* Apply Poppins font */
        }
        .header-menu {
            position: absolute;
            top: 0;
            width: 100%;
            height: 73px; /* Set a fixed height for the header */
            box-shadow: 0px 2px 5px 0px #0000;
            background: linear-gradient(to right, #0061A6, #7B9894, #D27100); /* Gradient background */
            z-index: 1000; /* Ensure it stays on top */
            display: flex;
            align-items: center; /* Center items vertically */
            justify-content: space-between; /* Adjust spacing to fit logo and menu */
            padding: 0 20px; /* Adjust horizontal padding as needed */
        }
        .logo {
            display: flex;
            align-items: center;
        }
        .logo img {
            width: 150px; /* Adjust the width as needed */
            height: auto; /* Maintain aspect ratio */
        }
        .main-menu {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
            flex-grow: 1; /* Allow menu to take remaining space */
            justify-content: center; /* Center menu items */
        }
        .main-menu li {
            display: inline-block;
            margin: 0 60px; /* Adjust spacing between menu items */
        }
        .main-menu a {
            font-weight: 500;
            color: white;
            font-size: 15px;
            text-decoration: none;
            padding: 25px 10px; /* Adjust padding as needed */
            display: block;
        }
        .content {
            padding: 100px 20px;
        }
        a:hover {
            background-color: #266EA2;
        }
    </style>

    @yield('head')
</head>
<body>
    <div class="header-menu">
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
        </div>
        <ul class="main-menu">
            <li><a href="{{ url('/') }}">BUsina Online</a></li>
            <li><a href="{{ url('/login') }}">Account</a></li>
            <li><a href="{{ url('/privacy-policy') }}">Privacy Policy</a></li>
            <li><a href="{{ url('/guidelines') }}">Guidelines</a></li>
            <li><a href="{{ url('/faq') }}">FAQ</a></li>
        </ul>
    </div>
    @yield('content')
</body>
</html>
