<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Quốc An">
    <meta name="description" content="">
    @if(session('success'))
    <meta http-equiv="refresh" content="2; url={{ route('login') }}">
    @endif
    <link rel="stylesheet" href="{{ asset('css/app.css')}} " />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/img/favicons/favicon-16x16.png') }}">

    <title>Register | {{config('app.name')}}</title>

</head>
<!-- component -->

<body>

    <section class="min-h-screen flex items-stretch text-white ">
        <div class="lg:flex w-1/2 hidden bg-gray-500 bg-no-repeat bg-cover relative items-center"
            style="background-image: url(https://media.travelmag.vn/files/thuannguyen/2020/04/25/cach-chup-anh-dep-tai-da-lat-1-2306.jpeg);">
            <div class="absolute bg-black opacity-40 inset-0 z-0"></div>
            <div class="w-full px-24 z-10">
                <h1 class="text-5xl font-bold text-left tracking-wide"></h1>
                <p class="text-5xl my-4 text-blod text-center">LYUN HOUSE</p>
                <p class="text-xl my-4 text-center">The Confidence Of Ladies Makes Beauty And Charm</p>
            </div>

        </div>
        <div class="lg:w-1/2 w-full flex items-center justify-center text-center md:px-16 px-0 z-0 bg-gray-300">
            <div class="absolute lg:hidden z-10 inset-0 bg-gray-500 bg-no-repeat bg-cover items-center"
                style="background-image: url(https://media.travelmag.vn/files/thuannguyen/2020/04/25/cach-chup-anh-dep-tai-da-lat-1-2306.jpeg);">
                <div class="absolute bg-black opacity-60 inset-0 z-0"></div>
            </div>
            <div class="w-full py-6 z-20 ">
                <h1 class="my-6">
                    <div class="w-auto h-7 sm:h-8 inline-flex text-4xl text-blod lg:text-black md:text-white">Xưởng May
                        Lyun House
                    </div>
                </h1>

                <div class="lg:text-black md:text-white text-blod ">
                    Đăng ký tài khoản
                </div>
                <form action="{{ route('request.register') }}" class="sm:w-2/3 w-full px-4 lg:px-0 mx-auto"
                    method="post">
                    @csrf
                    @if(session('success'))
                    <p class="bg-green-100 text-green-500 text-left text-lg rounded-lg p-3 shadow-sm">{{
                        session('success') }}</p>
                    @endif
                    @if($errors->any())
                    <p class="bg-red-100 text-red-500 text-left text-lg rounded-lg p-3 shadow-sm">{{
                        $errors->first() }}</p>
                    @endif
                    <div class="py-4">
                        <input name="fullname" type="text" id="fullname" placeholder="Tên của bạn"
                            class=" block w-full p-3 text-lg  text-black rounded-lg">
                    </div>
                    <div class="py-2">
                        <input name="email" type="email" id="email" placeholder="Email"
                            class=" block w-full p-3 text-lg  text-black rounded-lg">
                    </div>
                    <div class="py-2">
                        <input class="block w-full p-3 text-lg rounded-lg bg-[#ffffff] text-black" type="password"
                            name="password" id="password" placeholder="Mật Khẩu">
                    </div>
                    <div class="py-2">
                        <input class="block w-full p-3 text-lg rounded-lg bg-[#ffffff] text-black" type="password"
                            name="password_confirmation" id="password_confirm" placeholder="Xác nhận mật Khẩu">
                    </div>
                    <div class="text-right text-black hover:underline hover:text-gray-500 text-base">
                        <a href="{{ route('login') }}" class="">Đã có tài khoản? Đăng nhập</a>
                    </div>
                    <div class="my-4">
                        <button
                            class="uppercase block w-full p-3 text-lg rounded-lg bg-indigo-600 focus:outline-none text-blod">
                            Đăng Ký</button>
                    </div>

                </form>
            </div>
        </div>
</body>
<script type="text/javascript" src="{{ asset('js/app.js') }}" defer></script>

</html>