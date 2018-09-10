@extends('master',['title'=>$item->title])

@section('content')

<div class="header-page">	
			
<div class="container">
        <div class="row">
                <div class="col-xs-7">
                        <div class="menu-page">
                                <a href="#">ميل ديليشز</a>
                                <a href="#">أخبار وعروض</a>
                                <a href="#">المدونة</a>
                                <a href="#">أتصل بنا</a>
                        </div>
                </div>
                <div class="col-xs-5">
                        <div class="social-page">
                                <a href="#"><img src="{{asset('images/facebook.png')}}" /></a>
                                <a href="#"><img src="{{asset('images/snapchat.png')}}" /></a>
                                <a href="#"><img src="{{asset('images/twitter.png')}}" /></a>
                                <a href="#"><img src="{{asset('images/share.png')}}" /></a>
                        </div>
                </div>

                <div class="col-xs-12 text-center">
                        <div class="cont-head">
                                <div class="img-con-head">
                                    @if($company->logo != null)
                                    <img src="{{asset('uploads')}}/{{$company->logo}}" /></div>
                                     @else <img src="{{asset('images/logo.png')}}" /></div>
                                     @endif
                                <h3 ng-if="$item->mobile != NULL">{{$user->mobile}} 
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
        <div class="col-xs-6 nopadding">
                <div class="time-open offer-com">
                        <img src="{{asset('images/img-com-2.png')}}" />
                        <div>
                                <h3>العروض</h3>
                                <h2>{{count($offers)}}</h2>						
                        </div>
                </div>
        </div>
        <div class="col-xs-6 nopadding">
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
                    <div class="col-md-8">
                        <div class="tit-main-home">
       				<h3>{{$item->title}}  </h3>
                                <p>{!! $item->description !!}</p>
       			</div>
                    </div>
                    <div class="col-md-4">
                        <img src="{{asset('uploads')}}/{{$item->img}}" />
                    </div>
       			
       		</div>
       	</div>
       	
       	<div class="row">
       		<div class="col-xs-12">
       			<div class="tit-main-img">
       				<!--<img src="{{asset('images/icon-tit.png')}}" />-->       
                            <h3>شاهد أيضا</h3>
       			</div>
       		</div>
       	</div>
       	
       	<div class="row">
       		
       		<div class="col-xs-12 nopadding">
                    @if($offers)
                        @foreach($offers as $offer)
                    <div class="col-xs-6">
       				<div class="block-offer">
                                    @if($offer->img != null)
                                        <img src="{{asset('uploads')}}/{{$offer->img}}" />
                                    @else <img src="{{asset('images/logo.jpg')}}" />
                                    @endif
       					<div>
                                            <h3><a href="{{url('offer')}}/{{$offer->id}}">{{$offer->title}}</a></h3>
                                            <p>{{ strip_tags( str_limit($offer->description, $limit = 130, $end = '...')) }}</p>
       						@if($offer->expire_date != '0000-00-00' && $offer->expire_date != '' )
                                                    <span>ينتهى فى : {{$offer->expire_date}}</span>
                                                @endif
       					</div>
       				</div>
       			</div>
                        @endforeach
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
       			<div class="col-xs-6">
       				<div class="img-gall"><img src="{{asset('images/img-2.jpg')}}" /></div>
       			</div>	
       			<div class="col-xs-6">
       				<div class="img-gall"><img src="{{asset('images/img-3.jpg')}}" /></div>
       			</div>
       			<div class="col-xs-6">
       				<div class="img-gall"><img src="{{asset('images/img-2.jpg')}}" /></div>
       			</div>
       			<div class="col-xs-6">
       				<div class="img-gall"><img src="{{asset('images/img-3.jpg')}}" /></div>
       			</div>	
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
       			<iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d13803.90341849937!2d31.268358950000003!3d30.1235044!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2seg!4v1509004392366" width="100%" height="150" frameborder="0" style="border:0" allowfullscreen></iframe>
       		</div>
       		
       			
       			
       	</div>
       	
       	
       </div>
    </div>

@endsection
