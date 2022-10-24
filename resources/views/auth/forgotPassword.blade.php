<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/tailwind.output.css')}} " />
    <link rel="stylesheet" href="{{ asset('css/app.css')}} " />

    <title>Quên mật khẩu - {{ config('app.name') }}</title>
</head>

<body>
    <div class="flex items-center min-h-screen p-6 bg-gray-50 dark:bg-gray-900">
        <div class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-[#ffffff] rounded-lg shadow-xl dark:bg-gray-800">
            <div class="flex flex-col overflow-y-auto md:flex-row">
                <div class="h-32 md:h-auto md:w-1/2">
                    <img aria-hidden="true" class="object-cover w-full h-full dark:hidden"
                        src="{{ asset('img/forgot-password-office.jpeg') }}" alt="Office" />
                    <img aria-hidden="true" class="hidden object-cover w-full h-full dark:block"
                        src="{{ asset('img/forgot-password-office-dark.jpeg') }}" alt="Office" />
                </div>
                <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
                    <div class="w-full">
                        <h1 class="mb-4 text-xl font-semibold text-gray-700 dark:text-gray-200">
                            Quên mật khẩu
                        </h1>
                        <form action="{{ route('auth.forgot.request') }}" method="post">
                            @csrf
                            @if($errors->any())
                            <p class="text-red-500">{{ $errors->first() }}</p>
                            @elseif(session('status'))
                            <p class="text-green-500">{{ session('status') }}</p>
                            @endif
                            <label class="block text-sm">
                                <span class="text-gray-700 dark:text-gray-400">Email</span>
                                <input
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-indigo-400 focus:outline-none focus:shadow-outline-indigo dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                    placeholder="JaneDoe@exam.com" name="email" />
                            </label>

                            <!-- You should use a button here, as the anchor is only used for the example  -->
                            <button
                                class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-indigo-600 border border-transparent rounded-lg active:bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:shadow-outline-indigo">
                                Gửi liên kết
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript" src="{{ asset('js/app.js') }}" defer></script>

</html>