<!DOCTYPE html>
<html lang="en" onclick="print()">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="image/favicon.ico" type="image/x-icon" />
    <base href="{{asset('')}}" />
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>HÓA ĐƠN</title>

    <!-- Bootstrap cdn 3.3.7 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Custom font montseraat -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700" rel="stylesheet">

    <!-- Custom style invoice1.css -->
    <link rel="stylesheet" type="text/css" href="./css/invoice.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        body {
            cursor: pointer;
        }
    </style>
</head>

<body class="bg-light">

    <section class="back" id="app">
        <div class="container-xxl p-4">
            <div class="row">
                <div class="col-xs-12">
                    <div class="invoice-wrapper">
                        <div class="invoice-top">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="invoice-top-left">
                                        <h2 class="client-company-name fs-1">{{ $order->customer->name }}</h2>
                                        <h6 class="client-address fs-5">
                                            {{ $order->customer->address }}<br />
                                            {{ $order->customer->phone_number }}
                                            <!-- 31 Lake Floyd Circle, <br>Delaware, AC 987869 <br>India -->
                                        </h6>
                                        <!-- <h4>Reference</h4>
										<h5>UX Design &amp; Development for <br> Android App.</h5> -->
                                    </div>
                                </div>
                                <div class="col-sm-6 d-flex flex-row justify-content-end">

                                    <div class="logo-wrapper">
                                        <img src="https://png.pngtree.com/png-vector/20190830/ourmid/pngtree-sewing-machine-needle-and-scisor-icon-vector-illustration-png-image_1715862.jpg" class="img-responsive pull-right logo" width="80px" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-bottom">
                            <div class="row">
                                <div class="col-xs-12">
                                    <h2 class="title">HÓA ĐƠN <span class="badge"></span></h2>
                                </div>
                                <div class="clearfix"></div>

                                <div class="col-sm-3 col-md-3">
                                    <div class="invoice-bottom-left">
                                        </h4>
                                    </div>
                                </div>
                                <div class="col-md-offset-1 col-md-8 col-sm-9 overflow-x-auto">
                                    <div class="invoice-bottom-right">
                                        <table class="table fs-4">
                                            <thead>
                                                <tr>
                                                    <th>Số lượng</th>
                                                    <th>Hình ảnh</th>
                                                    <th>Sản phẩm</th>
                                                    <th>Chất lượng</th>
                                                    <th>Đơn giá</th>
                                                    <th>Thành tiền</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php 
                                                $total = 0;
                                                @endphp
                                                @foreach($order->detail as $od)
                                                <tr>
                                                    <td>{{ $od->amount }}</td>
                                                    <td><img src="/img/{{ $od->image }}" class="object-contain"
                                                            alt="product" width="60px"></td>
                                                    <td>{{ $od->product->Ten }}</td>
                                                    <td>{{ $od->quality->Ten }}</td>
                                                    <td>{{ number_format_str($od->product->GiaThanh) }}</td>
                                                    <td>{{ number_format_str($od->product->GiaThanh * $od->amount) }}</td>
                                                </tr>
                                                @php $total += $od->product->GiaThanh * $od->amount @endphp
                                                @endforeach
                                                <tr style="height: 40px;"></tr>
                                            </tbody>
                                            <thead>
                                                <tr>
                                                    <th>Tổng thành tiền</th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th>{{ number_format_str($total) }}</th>
                                                </tr>
                                            </thead>
                                        </table>
                                        <div class="invoice-top-right">
                                            <h2 class="our-company-name">{{ config('app.name') }}</h2>
                                            <h6 class="our-address">Thành phố Hồ
                                                Chí Minh</h6>
                                            <h5>
                                                <?php
                                                date_default_timezone_set('Asia/Ho_Chi_Minh');
                                                $date = date('jS F Y h:i a', time());
                                                echo $date;
                                                ?>
                                                <!-- 06 September 2017 -->
                                            </h5>
                                        </div>
                                        <!-- <h4 class="terms">Điều kiện</h4>
                                      
                                        <h4 class="terms">Cổng thanh toán MoMo</h4>
                                        <ul class="fs-4">
                                           
                                        </ul>
                                        <h4 class="terms">Thanh toán qua Ngân hàng</h4>
                                        <ul class="fs-4">
                                           
                                        </ul> -->
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-xs-12">
                                    <hr class="divider">
                                </div>
                                <div class="fs-3 col-4">
                                    <h6 class="text-left"></h6>
                                </div>
                                <div class="fs-3 col-4">
                                    <h6 class="text-center">nmtworks.7250@gmail.com</h6>
                                </div>
                                <div class="fs-3 col-4">
                                    <h6 class="text-right">+84 388 794 195</h6>
                                </div>
                            </div>
                            <div class="bottom-bar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13"
        crossorigin="anonymous"></script>
    <!-- jquery slim version 3.2.1 minified -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha256-k2WSCIexGzOj3Euiig+TlR8gA0EmPjuc79OEeY5L45g=" crossorigin="anonymous"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>

    <script src="{{ asset('js/app.js') }}" defer></script>
    <script>window.print()</script>

</body>

</html>