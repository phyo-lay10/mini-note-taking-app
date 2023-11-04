<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Note Taking App</title>

    {{-- bootstrap css --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> 
    {{-- <style>
        .card  {
            max-width: 400px;
            height: 300px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
    </style> --}}
</head>
<body>
    <nav class="navbar bg-info my-1 ">
        <div class="container">
            @if (Auth::check())
                <a class="navbar-brand text-white fw-bold " href="#">
                    {{Auth::user()->name}}
                </a>
            @endif
            <form method="post" action="{{route('logout')}}"> @csrf
                <button class="btn btn-danger btn-sm" onclick="return confirm('Are u sure u wanna log out?')">Log Out</button>
            </form>
        </div>
    </nav>
    <div class="container">
        @yield('content')
    </div>
    {{-- bootstrap js --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>