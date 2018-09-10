@extends('master',['title'=>$item->name])

@section('content')

<div class="header-page">	
			
<div class="container">
        <div class="row">
                <div class="col-xs-7">
<!--                        <div class="menu-page">
                                <a href="#">ميل ديليشز</a>
                                <a href="#">أخبار وعروض</a>
                                <a href="#">المدونة</a>
                                <a href="#">أتصل بنا</a>
                        </div>-->
                </div>
                <div class="col-xs-5">
                        <div class="social-page">
                            @if($company->facebook != null)<a href="{{$company->facebook}}"><img src="{{asset('images/facebook.png')}}" /></a>@endif
                            @if($company->snapshat != null)<a href="{{$company->snapshat}}"><img src="{{asset('images/snapchat.png')}}" /></a>@endif
                            @if($company->twitter != null)<a href="{{$company->twitter}}"><img src="{{asset('images/twitter.png')}}" /></a>@endif
                                <!--<a href="#"><img src="{{asset('images/share.png')}}" /></a>-->
                        </div>
                </div>

                <div class="col-xs-12 text-center">
                        <div class="cont-head">
                                <div class="img-con-head">
                                    @if($company->logo != null)
                                    <img src="{{asset('uploads')}}/{{$company->logo}}" /></div>
                                     @else <img src="{{asset('images/logo.png')}}" /></div>
                                     @endif
                                <h3 ng-if="$item->mobile != NULL">{{$item->mobile}} 
                                    <img src="{{asset('images/icon-1.png')}}" /></h3>
                        </div>
                </div>
        </div>
</div>

<div class="img-page-main">
        <img src="{{asset('images/img-web.jpg')}}" />
</div>

</div>


<div class="pre-offer">			
        <div class="col-xs-5 nopadding">
                <div class="time-open offer-com">
                        <img src="{{asset('images/img-com-2.png')}}" />
                        <div>
                                <h3>العروض</h3>
                                <h2>{{count($offers)}}</h2>						
                        </div>
                </div>
        </div>
        <div class="col-xs-7 nopadding">
                <div class="time-open">
                        <img src="{{asset('images/img-com-1.png')}}" />
                        <div>
                                <h3>مفتوح</h3>
                                <p>{{$company->opining_times}}</p>
<!--                                <p>2:00 <i class="fa fa-arrow-right" aria-hidden="true"></i> 8:00</p>
                                <p>7:00 <i class="fa fa-arrow-right" aria-hidden="true"></i> 4:00</p>-->
                        </div>
                </div>
        </div>

</div>



<div class="clearfix"></div>
    <div id="page">
       <div class="container">
       	<div class="row">
       		<div class="col-md-12">
       			<div class="tit-main-home">
       				<h3>{{$item->name}}  </h3>
                                <p>{!! $company->about !!}</p>
       			</div>
       		</div>
       	</div>
       	
       	<div class="row">
       		<div class="col-xs-12">
       			<div class="tit-main-img">
       				<img src="{{asset('images/icon-tit.png')}}" />       			
       			</div>
       		</div>
       	</div>
       	
       	<div class="row">
       		
       		<div class="col-xs-6 nopadding">
                    @if($latest_offers)
                        @foreach($latest_offers as $offer)
                    <div class="col-xs-12">
       				<div class="block-offer">
                                    @if($offer->img != null)
                                        <img src="{{asset('uploads')}}/{{$offer->img}}" />
                                    @else <img src="{{asset('images/logo.jpg')}}" />
                                    @endif
       					<div>
                                            <h3 style="float: left;direction: rtl;"><a href="{{url('offer')}}/{{$offer->id}}">
                                                    {{ strip_tags( str_limit($offer->title, $limit = 50, $end = '...')) }}</a></h3>
                                            <!--<p>{{ strip_tags( str_limit($offer->description, $limit = 130, $end = '...')) }}</p>-->
       						@if($offer->expire_date != '0000-00-00' && $offer->expire_date != '' )
                                                    <span>ينتهى فى : {{$offer->expire_date}}</span>
                                                @endif
       					</div>
       				</div>
       			</div>
                        @endforeach
                      @endif
       		</div>	
       		
       		<div class="col-xs-6">
                     @if($last_offer)
       			<div class="larg-offer">                           
                            @if($last_offer->img != null)
                            <img src="{{asset('uploads')}}/{{$last_offer->img}}" />
                            @else <img src="{{asset('images/img.png')}}" />
                            @endif
       				<div>
                                    <h3><a href="{{url('offer')}}/{{$last_offer->id}}">{{$last_offer->title}}</a></h3>
                                    @if($last_offer->expire_date != '0000-00-00')
                                        <p> العرض سارى حتى {{$last_offer->expire_date}} </p>
                                    @endif
       				</div>                           
       			</div>
                     @else <p class="no-result">لم تتم اضافة عروض بعد</p>
                            @endif
       		</div>
       		
       	</div>	
       	
       	<div class="row">
       		
       		<div class="col-xs-6 nopadding">
       			<div class="col-xs-12">
       				<div class="tit-main-img">
       					<img src="{{asset('images/icon-cam.png')}}" />       			
       				</div>
       			</div>
                    
                    
                        <span id="insta_count"></span>
                        <div ng-controller="ctrl">
                            <div id="insta"></div>
                        </div>
                        
                      
<!--       			<div class="col-xs-6">
       				<div class="img-gall"><img src="{{asset('images/img-2.jpg')}}" /></div>
       			</div>	-->
       				
       		</div>	
       		
       		<div class="col-xs-6 nopadding">
       			<div class="col-xs-12">
       				<div class="tit-main-img">
       					<img src="{{asset('images/icon-ma.png')}}" />       			
       				</div>
       			</div>
       			<div class="col-xs-12">
       				<div class="offer-se">
       					<img src="{{asset('images/img-larg.jpg')}}" />
       					<div>
       						<h3>عرض خاص</h3>
       						<p>شويناه! كلاسيك هوت دوغ و تشيلي بيف هوت دوغ بـ15 ريال للوجبة</p>
       					</div>
       				</div>
       			</div>		
       		</div>
       		
       	</div>
       	
       	
       	<div class="row">
       		<div class="col-xs-12">
       			<div class="tit-main-img">
       				<img src="{{asset('images/icon-map.png')}}" />       			
       			</div>
       		</div>
       		
       		<div class="col-xs-12 nopadding">
                    <div id="map" style="height: 250px;width: 100%;"></div>
                         <script>
                        function initMap() {
                           var uluru = {lat: 26.3550636, lng: 50.2728988};
                          var map = new google.maps.Map(document.getElementById('map'), {
                            zoom: 4,
                            center: uluru
                          });
                          var marker = new google.maps.Marker({
                            position: uluru,
                            map: map
                          });
                        }
                      </script>
                      <script async defer
                      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBN8cys7mg64JtPG7lusnBZVivyyaWKwZ8&callback=initMap">
                      </script>

                        
       		</div>
       		
       			
       			
       	</div>
       	
       	
       </div>
    </div>

<!-------------- Fro app ------------------->
 
<!-- Modal -->
<div id="forApp" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
      </div>
      <div class="modal-body forapp text-center">
          <img src="{{asset('images/logo.png')}}" class="logo"/>
          <p>
              تطبيق 900 
              <br/> التطبيق الخدمى الأفضل 
              
              <br/><br/> <span class="blue">أكثر من 14 مليون مستخدم</span> <br/>
              <span class="red">مجاناً اليوم , حمل التطبيق الأن</span> <br/>
              <a href=""><img src="{{asset('images/google-play.png')}}" /></a>
          </p>
      </div>
      <div class="modal-footer text-center footApp">
          <a href="" class="btn btn-success download">حمل التطبيق مجاناَ الأن </a>
      </div>
    </div>

  </div>
</div>

<!-------------- End for app -------------->
@endsection
