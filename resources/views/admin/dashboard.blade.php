@extends('admin/master',['title'=>'لوحة التحكم','active'=>'dashboard'])
@section('content')
<div class="row mt">
      <div class="col-lg-12">
          <div class="form-panel dashpnl">  
              
               @if($items)
              @foreach($items as $item)
                    <div class="col-md-3 dash">
                        <a href="{{url('admin')}}/{{$item->link}}">
                            <i class="fa fa-{{$item->icon}}"></i><br/>
                            <h4> {{$item->title}}  </h4>
                        </a>
                    </div>
              @endforeach
              @endif
    
     </div>
     </div>
</div>
@stop



  