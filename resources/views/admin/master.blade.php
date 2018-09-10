<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>  {{$title}} |  900SA </title>
    <link rel="shortcut icon" href="{{asset('admin_asset/img/logo.png')}}"> 
    <!-- Bootstrap core CSS -->
    <link href="{{asset('admin_asset/css/bootstrap.css')}}" rel="stylesheet">
    <!--external css-->
    <link href="{{asset('admin_asset/font-awesome/css/font-awesome.css')}}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{asset('admin_asset/css/zabuto_calendar.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin_asset/js/gritter/css/jquery.gritter.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('admin_asset/lineicons/style.css')}}?>">    
    
    <!-- Custom styles for this template -->
    <link href="{{asset('admin_asset/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('admin_asset/css/style-responsive.css')}}" rel="stylesheet">

    <script src="{{asset('admin_asset/js/chart-master/Chart.js')}}"></script>
    <link href="{{asset('admin_asset/js/fancybox/jquery.fancybox.css')}}" rel="stylesheet" />
     
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="{{asset('admin_asset/dt/jquery.dataTables.css')}}">    
    <link rel="stylesheet" type="text/css" href="{{asset('admin_asset/css/dev.css')}}">
    
     <!------------- Rich text editor ----------->
    <script src="{{asset('admin_asset/nicEdit/nicEdit-latest.js') }}" type="text/javascript"></script>
    <script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
           
  </head>

  <body>

  <section id="container" >
      <!-- **********************************************************************************************************************************************************
      TOP BAR CONTENT & NOTIFICATIONS
      *********************************************************************************************************************************************************** -->
      <!--header start-->
      <header class="header black-bg">
              <div class="sidebar-toggle-box">
                  <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
              </div>
            <!--logo start-->
            <a href="{{ url('admin/dashboard') }}" class="logo">
                <img src="{{asset('admin_asset/img/logo.png')}}" />
            </a>           
            <!--logo end-->
            <div class="nav notify-row" id="top_menu">
                
                <!--  notification start -->
                <ul class="nav top-menu">
                                        <!--<li> <a href="{{url('')}}">زيارة الموقع</a></li>-->

                    <!-- settings start -->
<!--                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="index.html#">
                            <i class="fa fa-tasks"></i>
                            <span class="badge bg-theme">4</span>
                        </a>
                        <ul class="dropdown-menu extended tasks-bar">
                            <div class="notify-arrow notify-arrow-green"></div>
                            <li>
                                <p class="green">You have 4 pending tasks</p>
                            </li>
                            <li>
                                <a href="index.html#">
                                    <div class="task-info">
                                        <div class="desc">DashGum Admin Panel</div>
                                        <div class="percent">40%</div>
                                    </div>
                                    <div class="progress progress-striped">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                            <span class="sr-only">40% Complete (success)</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                           
                            <li class="external">
                                <a href="#">See All Tasks</a>
                            </li>
                        </ul>
                    </li>-->
                    <!-- settings end -->
                    <!-- inbox dropdown start-->
                    
                    <li id="header_inbox_bar" class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="index.html#">
                            <i class="fa fa-envelope-o"></i>
                            <span class="badge bg-theme">0</span>
                        </a>
                        <ul class="dropdown-menu extended inbox">
                            <div class="notify-arrow notify-arrow-green"></div>
                            <li>
                                <p class="green">يوجد عدد  ( 0) طلبات جديدة</p>
                            </li>
                            
                            <li>
                                <a href="">                                    
                                    <span class="subject">
                                    <span class="from">name</span>
                                    <span class="time">Date</span>
                                    </span>
                                    <span class="message">
                                        المبلغ الاجمالى : 000 ريال
                                    </span>
                                </a>
                            </li>
                            
                            <li>
                                <a style="text-align: center;background: #eee;" href="{{ url('admin/orders') }}">عرض الطلبات</a>
                            </li>
                        </ul>
                    </li>
                    <!-- inbox dropdown end -->
                </ul>
                <!--  notification end -->
            </div>
            <div class="top-menu">
            	<ul class="nav pull-right top-menu">
                    <li><a class="logout" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">خروج</a></li>
                    
                     <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
            	</ul>
            </div>
        </header>
      <!--header end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN SIDEBAR MENU
      *********************************************************************************************************************************************************** -->
      <!--sidebar start-->
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">
              
              	  <p class="centered"><a href="{{ url('admin/profile')}}">                              
                          {{!! Html::image('public/admin_asset/img/logo.png', 'Profile picture', array('class' => 'mg-circle')) !!}}
                          </a></p>
              	  <h5 class="centered">{{ Auth::user()->name }}</h5>              	  	                   
                  @if($adminMenu)
                        @foreach($adminMenu as $item)
                            <li class="@if($item->parent == '0') sub-menu @endif">
                                <a href="@if($item->link != '') {{ url('admin/')}}/{{$item->link}} @else javascript:; @endif" 
                                   class="@if($active == $item->flag) active @endif">
                          <i class="fa fa-{{$item->icon}}"></i>
                          <span>{{$item->title}}</span> 
                      </a>
                    @if($item->link == '#')
                        <ul class="sub">                            
                            @foreach($adminMenuSub as $sub)
                                @if($item->id == $sub->parent)
                                    <li><a  href="{{ url('admin/') }}/{{$sub->link}}">{{$sub->title}}</a></li>                         
                                @endif
                            @endforeach
                        </ul>
                   @endif
                  </li>
                        @endforeach
                   @endif

              </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>
      <!--sidebar end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      
        <section id="main-content">
          <section class="wrapper">
          	<h3>
                    <a href="{{ url('admin/dashboard') }}">لوحة التحكم</a> <i class="fa fa-angle-left"></i>
                     {{$title}} </h3>
                @include('include/flash-message')
                @yield('content')
              
          </section>
        </section>
              
      <!--main content end-->
      <!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
              &copy; جميع حقوق الطبع محفوظة  {!! Html::link('#','900SA') !!} {{ date('Y') }}
              <a href="{{ url('') }}" class="go-top">
                  <i class="fa fa-angle-up"></i>
              </a>
          </div>
      </footer>
      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="{{asset('admin_asset/js/jquery.js')}}"></script>
    <script src="{{asset('admin_asset/js/jquery-1.8.3.min.js')}}"></script>
    <script src="{{asset('admin_asset/js/bootstrap.min.js')}}"></script>
    <script class="include" type="text/javascript" src="{{asset('admin_asset/js/jquery.dcjqaccordion.2.7.js')}}"></script>
    <script src="{{asset('admin_asset/js/jquery.scrollTo.min.js')}}"></script>
    <script src="{{asset('admin_asset/js/jquery.nicescroll.js')}}" type="text/javascript"></script>
    <script src="{{asset('admin_asset/js/jquery.sparkline.js')}}"></script>


    <!--common script for all pages-->
    <script src="{{asset('admin_asset/js/common-scripts.js')}}"></script>
    
    <script type="text/javascript" src="{{asset('admin_asset/js/gritter/js/jquery.gritter.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin_asset/js/gritter-conf.js')}}"></script>

    <!--script for this page-->
    <script src="{{asset('admin_asset/js/sparkline-chart.js')}}"></script>    
    <script src="{{asset('admin_asset/js/zabuto_calendar.js')}}"></script>	
    <script src="{{asset('admin_asset/js/bootstrap-switch.js')}}"></script>
	<script type="text/javascript">
             
//        $(document).ready(function () {
//        var unique_id = $.gritter.add({
//            // (string | mandatory) the heading of the notification
//            title: 'Welcome to Dashgum!',
//            // (string | mandatory) the text inside the notification
//            text: 'Hover me to enable the Close Button. You can hide the left sidebar clicking on the button next to the logo. Free version for <a href="http://blacktie.co" target="_blank" style="color:#ffd777">BlackTie.co</a>.',
//            // (string | optional) the image to display on the left
//            image: 'assets/img/ui-sam.jpg',
//            // (bool | optional) if you want it to fade out on its own or just sit there
//            sticky: true,
//            // (int | optional) the time you want it to be alive for before fading out
//            time: '',
//            // (string | optional) the class name you want to apply to that specific message
//            class_name: 'my-sticky-class'
//        });
//
//        return false;
//        });
	</script>
	
	<script type="application/javascript">
        $(document).ready(function () {
            $("#date-popover").popover({html: true, trigger: "manual"});
            $("#date-popover").hide();
            $("#date-popover").click(function (e) {
                $(this).hide();
            });
        
            $("#my-calendar").zabuto_calendar({
                action: function () {
                    return myDateFunction(this.id, false);
                },
                action_nav: function () {
                    return myNavFunction(this.id);
                },
                ajax: {
                    url: "show_data.php?action=1",
                    modal: true
                },
                legend: [
                    {type: "text", label: "Special event", badge: "00"},
                    {type: "block", label: "Regular event", }
                ]
            });
        });
        
        
        function myNavFunction(id) {
            $("#date-popover").hide();
            var nav = $("#" + id).data("navigation");
            var to = $("#" + id).data("to");
            console.log('nav ' + nav + ' to: ' + to.month + '/' + to.year);
        }
    </script>
    
     <script src="{{asset('js/myScript.js')}}"></script>
     <script src="{{asset('admin_asset/js/admin.js')}}"></script>
     
<script src="{{asset('admin_asset/js/fancybox/jquery.fancybox.js')}}"></script>   
<script type="text/javascript">
      $(function() {
        //    fancybox
          jQuery(".fancybox").fancybox();
      });

  </script>  

    <script src="{{asset('admin_asset/dt/jquery.dataTables.min.js')}}"></script>
<script>



$(".cart_list").find(".product-remove").click(function(){ 
    var _token = "{{ csrf_token() }}";  
    var item = $(this).next().val();      
//     var price = $(this).closest("tr").find(".unit_price").text();
//     var q = $(this).closest("tr").find(".quantity").val();

//    var mince = price*q;
//    var total =  $('.total_price').html();                      
//    $(".total_price").html(total-mince);

     $.ajax({
             type: 'post',
             url: "{{ url('removeFromCart/"+item+"') }}",
             data: { id: item , _token:_token },
             success: function(response) {
//                 $('.red_cart').html(response);
//                 $(".total_price").html(total-mince);
//                 $(".prods_cost").html(total-mince);
             }
         });
//
     $(this).closest('li').remove(); 
      $(this).closest('tr').remove(); 
 });

 
 $("#category").change(function (){
    var _token = "{{ csrf_token() }}"; 
    var category = $(this).val();
    
    $.ajax({
        type: 'POST',
        url: "{{ url('admin/getSubCategories') }}",
        data: {  _token:_token ,category:category },
        success: function(response) {                        
            $("#sub_category").html(response);            
        }
    });    
});

$("#parent").change(function (){
    var _token = "{{ csrf_token() }}"; 
    var parent = $(this).val();
    $.ajax({
        type: 'POST',
        url: "{{ url('admin/getSubParent') }}",
        data: {  _token:_token ,parent:parent },
        success: function(response) {                        
            $("#sub_parent").html(response);            
        }
    });    
});

$("#sub_category").change(function (){
    var _token = "{{ csrf_token() }}"; 
    var sub_category = $(this).val();    
    $.ajax({
        type: 'POST',
        url: "{{ url('admin/getSubCategory') }}",
        data: {  _token:_token ,sub_category:sub_category },
        success: function(response) {                        
            $("#sub_category2").html(response);            
        }
    });    
});

$(".makeSpecial").change(function (){
    var _token = "{{ csrf_token() }}"; 
    var itmId =  $(this).val();   
    
    $.ajax({
        type: 'POST',
        url: "{{ url('admin/makeSpecial') }}",
        data: {  _token:_token ,itmId:itmId },
        success: function(response) {                        
            $("#sub_category2").html(response);            
        }
    });    
});

$("#role").change(function (){
   var role = $(this).val();
   if(role == 3) $("#companyInfo").show();
   else $("#companyInfo").hide();   
});

$(function () {
    $('#commercial_registration_expire_date').datetimepicker();
});

function printThis() {
    window.print();
}


</script>


  </body>
</html>
