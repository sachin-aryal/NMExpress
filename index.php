<html xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<head>
    <title> NME - Nepal Money Exchange</title>
    <meta name="viewport" content="width=device-width" />
    <meta name="title" content="Nepal Money Exchange"/>
    <meta name="description" content="An Australia based Money transfer Company Established in 2016,Sourced by our outstanding professional Team, more or less a pioneer in payments, you can be sure that your funds will Transfer safely and securely."/>
    <meta name="keywords" content="Money transfer,Sending Money To Nepal,Australia,Online Remittance,Faster Transfer,Cargo Service To Nepal,Import Export Nepal,Courier To Nepal,Website development,Remiitance Software,Mobile Money"/>
    <link rel="shortcut icon" type="image/png" href="img/fav.png"/>
    <link href="css/animate.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/lightbox.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link id="css-preset" href="css/preset1.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/demo.css">
    <link rel="stylesheet" href="css/footer-distributed-with-address-and-phones.css">
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
    <script src="js/jquery.js"></script>
    <script src="app/Assets/Js/jquery.blockUI.js"></script>
    <script type="text/javascript">
        $(function(){

            // $("#currencyTodayRate").val(80.50);
            $.ajax({
                url:"app/Controller/latestRate.php",
                success:function(rate){
                    var rateJson = JSON.parse(rate);
                    $(".todayRate").val(rateJson.todayRate);
                    $(".todayRate").html(rateJson.todayRate);
                }
            });
            $.ajax({
                url:"app/Controller/serviceCharge.php",
                success:function(serviceCharge){
                    var serviceChargeJson = JSON.parse(serviceCharge);
                    $(".serviceCharge").html('$' + serviceChargeJson.serviceCharge);
                    $("#serviceChargeValue").val(serviceChargeJson.serviceCharge);
                }
            });

            $("#ausDollar").on('input', function(){

                var ausDollar = $('#ausDollar').val();
                if(ausDollar==''){
                    $('#currencyTodayRate').val('');
                }else{
                    var exchangeRate = $('#ausDollarRate').val();
                    var sCharge = $("#serviceChargeValue").val();
                    var nrs = (ausDollar)*exchangeRate;
                    if(nrs >= 0) {
                        $('#currencyTodayRate').val(nrs.toFixed(2));
                    }else{

                        $('#currencyTodayRate').val("0.00");
                    }
                }
            });

            $("#currencyTodayRate").on('input', function(){

                var nepRuppee = $('#currencyTodayRate').val();
                if(nepRuppee==''){
                    $('#ausDollar').val('');
                }else{
                    var exchangeRate = $('#ausDollarRate').val();
                    var sCharge = $("#serviceChargeValue").val();
                    var ausDollar = nepRuppee/exchangeRate;
                    if(ausDollar >= 0) {
                        $('#ausDollar').val(ausDollar.toFixed(2));
                    }else{

                        $('#ausDollar').val("0.00");
                    }
                }
            });
        });
        function blockUi(){
            $.blockUI({ css: {
                border: 'none',
                padding: '15px',
                backgroundColor: '#000',
                '-webkit-border-radius': '10px',
                '-moz-border-radius': '10px',
                opacity: .5,
                color: '#fff'
            } });
        }

        function unBlockUi(){
            $.unblockUI();
        }
        function saveSubscriber(){

            var email = $("#email").val().trim();
            if(email.match(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/) == null){
                alert('Invalid Email Address');
                return false;
            }
            $("#notifyCloseButton").click();
            blockUi();
            $.ajax({
                url:"app/Controller/saveSubscriber.php",
                data: {email:email},
                type: "POST",
                success:function(success){

                    var successJSON = JSON.parse(success);
                    if(successJSON.success === true){

                        $("#thankyou").modal("show");
                    }
                },complete:function(data){

                    unBlockUi();
                }
            });
        }

    </script>

</head>
<body>
<input type="hidden" id="serviceChargeValue"/>
<div class="row_self">

    <nav class="navbar navbar-default">
        <div class="navbar-header">
            <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="http://nepalexpress.com.au"><img src="img/logo.png"/></a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="index.php">Home</a></li>
                <li><a href="aboutUs.html">About Us</a></li>
                <li><a href="benefits.html">Benefits</a></li>
                <li><a href="services.html">Services</a></li>
                <li><a href="faq.html">FAQS</a></li>
                <li><a href="contactUs.html">Contact Us</a></li>
                <li><a></a></li>
                <li><a></a></li>
                <li>
                    <div class="dateBox">
                        <a href="#" id="currentDate"></a>
                    </div>
                </li>
                <li class="pull-right"><div class="loginButtonAtTop"><a href="app/index.php"> Login  | Register</a> </div></li>
                <li><a></a></li>
            </ul>
        </div>
    </nav>
</div>
<div class="phoneNumber">
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <h4 class="text-center center-block">
            Call us at 0426602903 , 0450954044
        </h4>
    </div>
    <div class="col-md-4"></div>

</div>
<div class="clearfix"></div>
<!-- row with slider and right sidebar starts  -->
<div class="row no-pad no-margin">
    <div class="col-md-3">
        <div class="currencyConverterBox">
            <div class="modal-header no-pad">
                <div class="row no-pad currencyConverterBoxBody">
                    <p style="color: #0254a3;font-size: 24px;text-transform: none">
                        Today's Rate is <br>
                        <span style="color:blue" class="blink">
                    <span class="todayRate" style="font-size: 23px;color: #ed1b24">
                        <i class="fa fa-circle-o-notch fa-spin" style="font-size:24px"></i>
                    NPR. </span>
                                </span>
                        <input type="hidden" id="ausDollarRate" class="todayRate"/>
                    </p>

                </div>
            </div>
            <div class="modal-body no-pad">
                <div class="currencyConverterBoxBody form-inline">
                    <div class="row text-center">
                        <h4 style="color:#3573a3;font-weight: bold">&nbsp;Currency Converter</h4>
                    </div>
                    <div class="enter"></div><div class="enter"></div>
                    <div class="form-group">
                        <p>
                            <input type="text" class="form-control" id="ausDollar" autofocus placeholder="AUD 0.00" autocomplete="off"/>
                            Aus <img src="img/ausFlag.png"/> </input>
                        </p>
                    </div>
                    <div class="form-group">
                        <p class="text-center">
                            <input type="text" id = "currencyTodayRate" placeholder="NPR 0.00" class="form-control">
                            NPR <img src="img/nepalFlag.png"/><br>
                        </p>
                    </div>

                </div>
                <div class="row no-pad">
                    <div class="col-md-4 col-sm-4 col-xs-4">
                        <div class="">
                            <a href="app/index.php">
                                <button type="button" class="btn btn-success btn-sm buttonRed">Send Money<p>Now<span class="glyphicon glyphicon-menu-right glyphTopRight"></span></p>
                                </button>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-3 col-xs-3 ">
                        <button type="button" class="btn btn-sm btn-primary center-block text-center" data-toggle="modal" data-target="#notify">Notify Me<p>Daily</p></button>
                    </div>

                    <div class="col-md-4 col-sm-3 col-xs-3 ">
                        <a href="moneyTracker.html">
                            <button type="button" class="btn btn-sm btn-primary"> Money<p>Tracker</p>
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div id="myCarousel" class="carousel slide">
            <div class="carousel-inner">
                <div class="item active">
                    <img src="img/slider1.jpg" alt="Slide2">
                </div>
                <div class="item">
                    <img src="img/slider2.jpg" alt="Slide2">
                </div>
                <div class="item">
                    <img src="img/slider3.jpg" alt="Slide3">
                </div>
                <div class="item">
                    <img src="img/slider4.jpg" alt="Slide3">
                </div>
                <div class="item">
                    <img src="img/slider5.jpg" alt="Slide3">
                </div>
            </div>
        </div>
    </div>

</div><!-- row with slider and right sidebar ends -->

<div class="row" style="">
    <div class="col-md-3 pad">
        <div class="aboutUs" id="aboutUs">
            <h3 class="text-center"> About Us</h3>
            <p class="pad">
                An Australia based Money transfer Company Established in 2016,Sourced by our outstanding professional Team, more or less a pioneer in payments, you can be sure that your funds will Transfer safely and securely.
                Through our strategic business relationships and worldwide network
                ...
            </p>
            <div class="enter"></div>
            <a href="aboutUs.html"><button type="button" class="btn btn-primary center-block">Read More</button></a>
            <div class="enter"></div>
        </div>
    </div>
    <div class="col-md-3 pad">
        <div class="sendMoney pad">
            <h3 class="text-center" style="color:red"> Send Money Online</h3>
            <div class="row pad">

                <div class="col-md-12 text-center">
                    <span style="color:blue;font-size: 25px" class="blink serviceCharge"><i class="fa fa-circle-o-notch fa-spin" style="font-size:24px"></i></span> service charge for online transaction only
                    <div class="enter"></div>
                    <span style="color: red;font-size: 10px;">* Terms and Conditions apply</span>
                </div>

            </div>
            <div class="enter"></div>
            <div class="enter"></div>
            <div class="row pad">
                <div class="col-md-12">
                    <a href="appnet/login.php">
                        <button type="button" class="btn btn-danger buttonRed center-block wid72"> Send Money Now
                            <span class="glyphicon glyphicon-menu-right glyphTopRight pull-right"></span>
                        </button>
                    </a>
                </div>

            </div>
            <div class="enter"></div>
            <div class="enter"></div>
            <div class="enter"></div>
            <div class="enter"></div>
            <div class="enter"></div>
            <div class="enter"></div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="mission">
            <h3 class="text-center"> Our Mission </h3>
            <p class="pad">
                We assure all of its clients that we can deliver reliably and efficiently all our payments for any of the parties, Business and Individuals. Through our strategic business relationships and worldwide network of trading we help our clients remain competitive and efficient when sending funds around the world.
            </p>
            <div class="enter"></div>
            <a href="aboutUs.html"><button type="button" class="btn btn-primary center-block">Read More</button></a>
            <div class="enter"></div>
        </div>
    </div>
    <div class="col-md-3 pad lft5 " style="margin-bottom:5px;">
        <ins style="width:100%;height:45px;" class="nepalipatro-wg" widget="daysmall"/><script src="//nepalipatro.com.np/widget/js"></script>
    </div>

    <div class="col-md-3 pad lft5" style="margin-bottom:5px;">
        <div class="currencyConverterBox" id="rate_chart">
            <div id="curve_chart" style="min-width: 250px; width:100%;height: 145px;"></div>
        </div>
    </div>

    <div class="col-md-3 pad lft5" style="margin-bottom:5px;">
        <div class="currencyConverterBox" id="rate_chart">
            <iframe src="https://www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fnmeaustralia&width=240&layout=standard&action=like&size=small&show_faces=true&share=true&height=80&appId=935979369796491" width="270" height="90" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>

        </div>
    </div>


    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script>
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() { // Create the data table.

            $.ajax({
                url:"app/chart.php",
                success:function(rate){
                    var rateJson = JSON.parse(rate);
                    var data = new google.visualization.DataTable();
                    data.addColumn("string", "Date");
                    data.addColumn("number", "Rate");

                    data.addRows(rateJson);
                    var options = {
                        title: 'Rate Graph',axes: {
                            x: {
                                0: {side: 'top'}
                            }
                        },
                        vAxis: {
                            title: 'Rate',
                            gridlines: { count: 6 }
                        },
                        pointSize: 3,
                        legend:{position: 'bottom'}
                    };

                    var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

                    chart.draw(data, options);

                }
            });



        }
    </script>



</div>


<div id="notify" class="modal fade no-pad" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id = "notifyCloseButton" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Notify Me Daily</h4>
            </div>
            <div class="modal-body">
                <form method="POST" onSubmit="return false;">
                    <div class="form-group">
                        <label class="control-label">Email Address</label>
                        <input type="email" name="email" class="form-control" id = "email" placeholder="Email Address" required="required">
                    </div>
                    <button type="submit" class="btn btn-primary btn-md" onClick="saveSubscriber();">Subscribe</button>
                </form>
            </div>
        </div>

    </div>
</div>

<div id="thankyou" style="margin: 0 auto;width: 50%;" class="modal fade no-pad" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content" style="background-color: rgb(224, 223, 255)">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="form-group center-block">
                    <h3 class="text-center" style="color: #2e3741">Thank you for Subscribing us. <br><br>
                        We will notify you about rates daily.</h3>
                    <img class="center-block" style="width: 300px;height: 180px" src="img/logo.png">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="enter"></div>
<div class="enter"></div>
<div class="enter"></div>
<div class="enter"></div>
<div class="enter"></div>
<div class="enter"></div>
<!--circle banner start-->
<div class="row  no-pad no-margin">
    <div class="col-lg-12 col-md-12">
        <div class="circle-tile">
            <div class="col-md-1 col-sm-2 col-xs-0"></div>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <div class="circle-tile-heading red"><center><h1 class="">NME</h1><p><small class="">MELBOURNE</small></p></center></div>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <div class="circle-tile-heading blue"><center><h1 class="">NME</h1><p><small class="">PERTH</small></p></center></div>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <div class="circle-tile-heading green"><center><h1 class="">NME</h1><p><small class="">BRISBANE</small></p></center></div>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <div class="circle-tile-heading purple"><center><h1 class="">NME</h1><p><small class="">TASMANIA</small></p></center></div>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <div class="circle-tile-heading gray"><center><h1 class="">NME</h1><p><small class="">DARWIN</small></p></center></div>
            </div>
            <div class="col-md-1 col-sm-2 col-xs-0"></div>

            <div class="circle-tile-content red">
                <div class="circle-tile-description text-faded"><center>NME ON YOUR CITIES</center></div>
                <!--<a class="circle-tile-footer" href="#">More Info <i class="fa fa-chevron-circle-right"></i></a>-->
            </div>
        </div>
    </div>
</div>
<!--circle banner ends-->

<div class="enter"></div>
<div class="enter"></div>
<!--

<div class="row no-pad no-margin" >
    <div class="col-md-6 no-pad">
        <div class="clearfix"></div>
        <div class="aboutUs" id="aboutUs">
            <div class="circle"><img src="img/about.png"/></div>
            <div class="enter"></div>
            <h3> About Us</h3>
            <p class="pad">
                An Australia based Money transfer Company Established in 2016,Sourced by our outstanding professional Team, more or less a pioneer in payments, you can be sure that your funds will Transfer safely and securely.
                Through our strategic business relationships and worldwide network of trading we help our clients remain competitive and efficient when sending funds around the world.
            </p>
            <a href="aboutUs.html"><button type="button" class="btn btn-danger center-block">Read More</button></a>
            <div class="enter"></div>
        </div>
    </div>

    <div class="col-md-6 no-pad">
        <div class="mission">
            <div class="circle"><img src="img/mission.png"/></div>
            <div class="enter"></div><div class="enter"></div>
            <h3> Our Mission </h3>
            <p class="pad">
                We assure all of its clients that we can deliver reliably and efficiently all our payments for any of the parties, Business and Individuals. Through our strategic business relationships and worldwide network of trading we help our clients remain competitive and efficient when sending funds around the world.
            </p>
            <div class="enter"></div>

            <a href="aboutUs.html"><button type="button" class="btn btn-danger center-block">Read More</button></a>
            <div class="enter"></div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>

<section id="blog" style="background-image:url(img/wallpaper.jpg)">
    <div class="container">
        <div class="row">
            <div class="heading text-center col-sm-8 col-sm-offset-2 wow fadeInUp" data-wow-duration="1200ms" data-wow-delay="300ms">
                <h2>Services</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <h3 class="text-center"> Money Transfer</h3>
            </div>
            <div class="col-md-6">
                <h3 class="text-center"> Cargo Transfer</h3>
            </div>
        </div>
        <div class="blog-posts">
            <div class="row">
                <div class="moneyTransfer">
                    <div class="col-sm-3 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="400ms">
                        <div class="post-thumb">
                            <img class="img-responsive center-block" src="img/cash-to-cash.png" alt="">
                        </div>
                        <div class="entry-header">
                            <h4 class="text-center">Cash To Cash</h4>
                        </div>
                    </div>

                    <div class="cargoFacility">
                        <div class="col-sm-3 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="400ms">
                            <div class="post-thumb">
                                <img class="img-responsive center-block" src="img/cash-to-account.png" alt="">
                            </div>
                            <div class="entry-header">
                                <h4 class="text-center">Cash To Account</h4>
                            </div>
                        </div>

                        <div class="col-sm-2 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="400ms">
                            <div class="post-thumb">
                                <img class="img-responsive center-block" src="img/import-service.png" alt="">
                            </div>
                            <div class="entry-header">
                                <h4 class="text-center">Import Facility</h4>
                            </div>
                        </div>

                        <div class="col-sm-2 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="400ms">
                            <div class="post-thumb">
                                <img class="img-responsive center-block" src="img/export-service.png" alt="">
                            </div>
                            <div class="entry-header">
                                <h4 class="text-center">Export Facility</h4>
                            </div>
                        </div>

                        <div class="col-sm-2 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="400ms">
                            <div class="post-thumb">
                                <img class="img-responsive center-block" src="img/courier.jpg" alt="">
                            </div>
                            <div class="entry-header">
                                <h4 class="text-center">Courier Service</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</section>&lt;!&ndash;/#blog&ndash;&gt;


<div class="benefits">
    <div class="row">
        <div class="col-md-4 no-pad">
            <div class="enter"></div>
            <div class="enter"></div>
            <div class="enter"></div>
            <div class="enter"></div>
            <div class="enter"></div>
            <ul>
                <li> -> Keeps Tracks Of Money</li>
                <li> -> Excellent Rates </li>
                <li> -> Fixed Fees </li>
                <li> -> Customer Service </li>
            </ul>
        </div>
        <div class="col-md-4 no-pad center-block;">
            <div class="enter"></div>
            <div class="enter"></div>
            <div class="enter"></div>
            <div class="enter"></div>
            <div class="enter"></div>
            <div class="enter"></div>
            <h2>< Benefits ></h2>
        </div>
        <div class="col-md-4 no-pad">
            <div class="enter"></div>
            <div class="enter"></div>
            <div class="enter"></div>
            <div class="enter"></div>
            <div class="enter"></div>
            <ul>
                <li> -> Easy To Use</li>
                <li> -> Safe and Secure</li>
                <li> -> Quick Turnaround </li>
                <li> -> Sending Mobile Online</li>
            </ul>
        </div>
    </div>
</div>

<section id="blog" style="background-image:url(img/benefitWallpaper.jpg)" class="receive">
    <div class="container">
        <div class="row">
            <div class="heading text-center col-sm-8 col-sm-offset-2 wow fadeInUp" data-wow-duration="1200ms" data-wow-delay="300ms">
                <h2>How To Receive Money</h2>
            </div>
        </div>
        <div class="blog-posts">
            <div class="row">
                <div class="moneyTransfer">
                    <div class="col-sm-4 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="400ms">
                        <div class="post-thumb">
                            <img class="img-responsive center-block" src="img/cash.jpg" alt="">
                        </div>
                        <div class="entry-header">
                            <h4 class="text-center">Cash</h4>
                        </div>
                    </div>

                    <div class="col-sm-4 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="400ms">
                        <div class="post-thumb">
                            <img class="img-responsive center-block" src="img/bankDeposit.jpg" alt="">
                        </div>
                        <div class="entry-header">
                            <h4 class="text-center">Bank Deposit</h4>
                        </div>
                    </div>

                    <div class="col-sm-4 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="400ms">
                        <div class="post-thumb">
                            <img class="img-responsive center-block" src="img/transfer.jpg" alt="">
                        </div>
                        <div class="entry-header">
                            <h4 class="text-center">NetBank Transfer</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>&lt;!&ndash;/#blog&ndash;&gt;
-->



<div class="footer-distributed" style="background-color:rgb(51, 56, 59) ">
    <div class="container">
        <div class="row no-pad no-margin">
            <div class="col-md-3 no-pad">
                <div class="footer-left">

                    <img src="img/logo.png" class="center-block" style="height:120px;width:220px;"/>
                    <h3 style="text-decoration:underline;color:white;font-size:24px;text-align:center"> Find Us On </h3><br>
                    <div class="row no-pad">
                        <div class="col-md-3 col-sm-3 col-xs-3 no-pad">
                            <a href="#"><img src="img/androidLogo.png"/></a>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-3 no-pad">
                            <a href="#"><img src="img/apple.png" class="center-block"/></a>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-3 ">
                            <a href="https://www.facebook.com/nmeaustralia/?fref=ts" target="_parent"><button class="btn btn-primary"><strong>f</strong></button></a>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-3">
                            <a href="#" class=""><button class="btn btn-primary"><i class="fa fa-twitter fa-2x"></i></button></a></a>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-5 no-pad">
                <br>
                <div class="footer-center">
                    <h3 style="text-decoration:underline;color:white;font-size:24px;padding-left: 29px"> Contacts </h3>
                    <div>
                        <i class="fa fa-map-marker"></i>
                        <p><span>12,3A Railway PDE,Kogarah,NSW 2217,SYDNEY,AUSTRALIA </p>
                    </div>

                    <p> <i class="fa fa-phone"></i>
                        0426602903, 0450954044</p>

                    <div>
                        <i class="fa fa-envelope"></i>
                        <p><a href="mailto:info@nepalexpress.com.au" style="color:white">info@nepalexpress.com.au</a></p>
                    </div>
                    <div class="viberImage">
                        <img src="img/viber.png"/>
                        <span class="colorWhite viberNumber">  &nbsp;&nbsp;&nbsp;0426602903
                               ,&nbsp;0450954044</span>
                    </div>

                </div>
            </div>
            <div class="col-md-4 no-pad">
                <div class="footer-right">
                    <br>
                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <h3 style="text-decoration:underline;color:white;font-size:24px;"> Links </h3>
                            <br>
                            <a href="bankDetails.html"> Bank Details</a><br><br>
                            <a href="privacy.html"> Privacy Policy</a><br><br>
                            <a href="amlPolicy.html"> AML Policy</a><br><br>
                            <a href="benefits.html"> Benefits</a><br><br>
                            <br><br>
                        </div>
                    </div>
                    <p class="footer-company-name text-center"> Nepal Money Express (NME) &copy; 2016</p><br>

                </div>
            </div>
        </div>
    </div>

</div>



<div class="clearfix"></div>

<!-- Trigger the modal with a button -->
<script>
    var d = new Date();
    document.getElementById("currentDate").innerHTML = d.toDateString();

</script>

<script type="text/javascript" src="js/jquery.inview.min.js"></script>
<script type="text/javascript" src="js/wow.min.js"></script>
<script type="text/javascript" src="js/mousescroll.js"></script>
<script type="text/javascript" src="js/smoothscroll.js"></script>
<script type="text/javascript" src="js/jquery.countTo.js"></script>
<script type="text/javascript" src="js/lightbox.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script>
    $('#myCarousel').carousel({
        interval:   4000
    });
</script>
</body>
</html>
