@extends('admin/master',['title'=>$item->name,'active'=>'regions'])
@section('content')
<div class="row mt">
        <div class="col-lg-12">
  <div class="form-panel">      
          <h4 class="mb"><i class="fa fa-angle-right"></i> تعديل    {{$item->code}} </h4>
          <hr/>
           <?php  echo Form::open(['action' => ['AdminController@updateRegion', $item->id]
                                ,'files'=>TRUE,'class'=>'form-horizontal style-form']);  ?>
                    
              {{ csrf_field() }}
        <div class="form-group">
            {!! Form::label('country','البلد ', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
            <div class="col-sm-10">
                <select name="country" id="country" class="form-control">
                    <option value="0">-- اختر البلد -- </option>
                    @foreach($countries as $country)
                    <option value="{{$country->id}}" @if($country->id == $item->country) selected @endif>{{$country->title_ar}}</option>
                    @endforeach
                </select>
            </div>
        </div>
         <div class="form-group">
            {!! Form::label('airport_type','نوع المطار  ', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
            <div class="col-sm-10">
                <select name="airport_type" id="airport_type" class="form-control">
                    <option value="0">-- اختر نوع المطار -- </option>
                    @foreach($airport_types as $air)
                    <option value="{{$air->id}}" @if($air->id == $item->airport_type) selected @endif>{{$air->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
         <div class="form-group">
            {!! Form::label('name','اسم المطار', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
            <div class="col-sm-10">
                {!! Form::text('name', $item->name, array('class' => 'form-control')) !!}                
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('position','الموقع', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
            <div class="col-sm-10">
                {!! Form::text('position', $item->position, array('class' => 'form-control')) !!}                
            </div>
        </div> 
        <div class="form-group">
            {!! Form::label('code','الكود  ', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
            <div class="col-sm-10">
                {!! Form::text('code', $item->code, array('class' => 'form-control')) !!}                
            </div>
        </div>
       <div class="form-group">
            {!! Form::label('lat','Latitude  ', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
            <div class="col-sm-4">
                {!! Form::text('lat', $item->lat, array('class' => 'form-control')) !!}                
            </div>
            
            {!! Form::label('lng','Langitude  ', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
            <div class="col-sm-4">
                {!! Form::text('lng', $item->lng, array('class' => 'form-control')) !!}                
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('active','نشط؟', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                               
            <div class="col-sm-10">
               <div class="radio">                    
                    <label> <input type="radio" name="active" id="yes" value="1" @if($item->active == 1) checked @endif> نعم </label>                    
                    <label> <input type="radio" name="active" id="no" value="0" @if($item->active == 0) checked @endif> لا </label>                    
               </div>
            </div>
        </div>
      <div class="form-group">
            {!! Form::label('sort','الترتيب', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                               
            <div class="col-sm-2">
                <select name="sort" id="sort" class="form-control">
                    @for($i=0 ; $i<=10 ; $i++)
                    <option value="{{$i}}" @if($item->sort == $i) selected @endif>{{ $i }}</option>
                    @endfor
                </select>
            </div>
        </div>
              <div class="form-group">
                  <div class="col-sm-2"></div>
                  <div class="col-sm-10">
                      {!! Form::submit('حفظ', array('class'=>'btn btn-theme')) !!}
      {!! Form::close() !!}
                  </div>
              </div>
      
  </div>
        </div>
             
</div>

@stop



  