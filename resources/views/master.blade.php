<!DOCTYPE html>
<html ng-app="myApp">

<head>
    <meta charset="utf-8" />
    <meta name="author" content="www.frebsite.nl" />
    <meta name="viewport" content="width=device-width initial-scale=1.0 maximum-scale=1.0 user-scalable=yes" />

    <title>900SA |  {{$title}}</title>
      
    <link rel="shortcut icon" href="{{asset('images/logo.png')}}"> 
    <link type="text/css" rel="stylesheet" href="{{asset('css/demo.css')}}" />
    <link type="text/css" rel="stylesheet" href="{{asset('css/fonts-web/font.css')}}" />
    <link type="text/css" rel="stylesheet" href="{{asset('css/bootstrap.css')}}" />
    <link type="text/css" rel="stylesheet" href="{{asset('css/font-awesome.css')}}" />
    <link rel="stylesheet" href="{{asset('css/owl.carousel.css')}}">
	
    <link rel="stylesheet" href="{{asset('css/dev.css')}}">
	
  
</head>
<body>
     

    @yield('content')
    
    <footer>
        <div class="col-xs-12 nopadding">
            <div class="copyright" dir="rtl"> &copy; جميع حقوق الطبع محفوظة</div>
        </div>
    </footer>



    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>-->
    
    <script type="text/javascript" src="{{asset('js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/owl.carousel.js')}}"></script>

 
    <script>
            $(document).ready(function(){
                    $(".owl-carousel").owlCarousel();
            });
    </script>
    
    <!-- menus script -->
    <script src="{{asset('js/menu.js')}}"></script>
    <script>        
        var pushRight = new Menu({
            wrapper: '#o-wrapper',
            type: 'push-right',
            menuOpenerClass: '.c-button',
            maskId: '#c-mask'
        });

        var pushRightBtn = document.querySelector('#c-button--push-right');

        pushRightBtn.addEventListener('click', function(e) {
            e.preventDefault;
            pushRight.open();
        });
    </script>
          
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.4/angular.min.js"></script>  
          
    <script src="{{asset('js/githubIcons.js')}}"></script>
    <script src="{{asset('js/myApp.js')}}"></script>
    
<script>   
    var name = "mediasrca", items;
      $.getJSON("https://query.yahooapis.com/v1/public/yql", {
        q: "select * from json where url='https://www.instagram.com/" + name + "/?__a=1'",
        format: "json",
        _: name
      }, function(data) {
        console.log(data);
        if (data.query.results) {
          items = data.query.results.json.user.media.nodes;
          console.log(items.length);

          $.each(items, function(n, item) {
            $('#insta').append(
              $('<a/>', {
                href: 'https://www.instagram.com/p/'+item.code,
                target: '_blank'
              }).css({
                backgroundImage: 'url(' + item.thumbnail_src + ')'
              }));
          });
        }

});

//---- for app---------------
$(window).load(function(){        
   $('#forApp').modal('show');
});
   
</script>

                    
</body>

</html>