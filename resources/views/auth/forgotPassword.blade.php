<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css')}} " />

    <title>Quên mật khẩu - {{ config('app.name') }}</title>
</head>

<body class="bg-gradient-to-r from-indigo-500 to-purple-500 flex items-center h-screen overflow-hidden">
    <section class="container">
        <form action="{{ route('auth.forgot.request') }}" method="post">
            @csrf
            <div class="mx-auto w-96 flex flex-col bg-white p-3 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold mb-2">Quên mật khẩu</h2>
                @if($errors->any())
                <p class="text-red-500">{{ $errors->first() }}</p>
                @elseif(session('status'))
                <p class="text-green-500">{{ session('status') }}</p>
                @endif
                <label for="email">Email</label>
                <input class="bg-gray-50 p-2 rounded-md border" id="email" type="email" name="email">
                <button
                    class="px-1 py-2 mt-3 text-sm text-white bg-indigo-600 rounded-md active:bg-indigo-700 hover:bg-indigo-700 duration-150 ease-in">Gửi
                    liên kết</button>
            </div>
        </form>
    </section>
    <script type="text/javascript" src="{{ asset('js/app.js') }}" defer></script>
</body>

</html>