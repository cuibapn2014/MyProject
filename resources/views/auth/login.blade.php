<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Quốc An">
    <meta name="description" content="">
    <link rel="stylesheet" href="{{ asset('css/app.css')}} " />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/img/favicons/favicon-16x16.png') }}">


    <title>Login | {{config('app.name')}}</title>

</head>
<!-- component -->

<body>
    <section class="min-h-screen flex items-stretch text-white ">
        <div class="lg:flex w-1/2 hidden bg-gray-500 bg-no-repeat bg-cover relative items-center"
            style="background-image: url(https://media.travelmag.vn/files/thuannguyen/2020/04/25/cach-chup-anh-dep-tai-da-lat-1-2306.jpeg);">
            <div class="absolute bg-black opacity-40 inset-0 z-0"></div>
            <div class="w-full px-24 z-10">
                <h1 class="text-5xl font-bold text-left tracking-wide"></h1>
                <p class="text-5xl my-4 text-blod text-center">{{ config('app.name') }}</p>
                <p class="text-xl my-4 text-center">{{ __('Garment Factory Association') }}</p>
            </div>

        </div>
        <div class="lg:w-1/2 w-full flex items-center justify-center text-center md:px-16 px-0 z-0 bg-gray-300">
            <div class="absolute lg:hidden z-10 inset-0 bg-gray-500 bg-no-repeat bg-cover items-center"
                style="background-image: url(https://media.travelmag.vn/files/thuannguyen/2020/04/25/cach-chup-anh-dep-tai-da-lat-1-2306.jpeg);">
                <div class="absolute bg-black opacity-60 inset-0 z-0"></div>
            </div>
            <div class="w-full py-6 z-20 ">
                <h1 class="my-6">
                    <div class="w-auto h-7 sm:h-8 inline-flex text-4xl text-blod lg:text-black md:text-white"> {{
                        config('app.name') }}
                    </div>
                </h1>

                <div class="lg:text-black md:text-white text-blod ">
                    ĐĂNG NHẬP TÀI KHOẢN CỦA BẠN
                </div>
                <form action="{{ route('request.login') }}" class="sm:w-2/3 w-full px-4 lg:px-0 mx-auto" method="post">
                    @csrf
                    @if($errors->any())
                    <p class="bg-red-100 text-red-500 text-left text-lg rounded-lg p-3 shadow-sm">{{
                        $errors->first() }}</p>
                    @endif
                    @if(session('failed'))
                    <p class="bg-red-100 text-red-500 text-left text-lg rounded-lg p-3 shadow-sm">{{
                        session('failed') }}</p>
                    @endif
                    <div class="pb-2 pt-4 ">
                        <input name="email" id="email" placeholder="Email"
                            class=" block w-full p-3 text-lg  text-black rounded-lg">
                    </div>
                    <div class="pb-2 pt-4">
                        <input class="block w-full p-3 text-lg rounded-lg bg-[#ffffff] text-black" type="password"
                            name="password" id="password" placeholder="Mật Khẩu">
                    </div>
                    <div class="py-2 flex items-center">
                        <input class="w-4 h-4 accent-indigo-600 checked:bg-indigo-400" type="checkbox" name="remember"
                            id="chk_remember" />
                        <label class="mx-1 text-[#ffffff] lg:text-black" for="chk_remember">Nhớ tôi</label>
                    </div>
                    <div class="text-right text-black hover:underline hover:text-gray-500 text-base">
                        <a href="{{ route('auth.forgot') }}" class="text-[#ffffff] lg:text-black">Quên Mật Khẩu?</a>
                    </div>
                    <div class="text-right text-black hover:underline hover:text-gray-500 text-base">
                        <a href="{{ route('register') }}" class="text-[#ffffff] lg:text-black">Chưa có Tài Khoản? Đăng Ký!</a>
                    </div>
                    <div class="my-4">
                        <button
                            class="uppercase block w-full p-3 text-lg rounded-lg bg-indigo-600 hover:bg-indigo-700 duration-150 active:bg-indigo-700 focus:outline-none text-blod">Đăng
                            Nhập</button>
                    </div>

                </form>
            </div>
        </div>
</body>
<script type="text/javascript" src="{{ asset('js/app.js') }}" defer></script>

</html>