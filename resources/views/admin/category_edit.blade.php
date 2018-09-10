@extends('admin/master',['title'=>$item->name,'active'=>'products'])
@section('content')
<div class="row mt">
        <div class="col-lg-9">
  <div class="form-panel">      
          <h4 class="mb"><i class="fa fa-angle-right"></i> تعديل  القسم  {{$item->name}} </h4>
          <hr/>
           <?php  echo Form::open(['action' => ['AdminController@updateCategory', $item->id]
                                ,'files'=>TRUE,'class'=>'form-horizontal style-form']);  ?>
                    
              {{ csrf_field() }}
         
        <div class="form-group">
            {!! Form::label('code','كود التصنيف  ', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
            <div class="col-sm-10">
                {!! Form::text('code', $item->code, array('class' => 'form-control')) !!}                
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('name','اسم القسم', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
            <div class="col-sm-10">
                {!! Form::text('name', $item->name, array('class' => 'form-control')) !!}                
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('parent','القسم الأب', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
            <div class="col-sm-10">
                <select name="parent" id="parent" class="form-control">
                    <option value="0">-- اختر قسم</option>
                    @foreach($parents as $value)
                    <option value="{{$value->id}}" @if($item->parent == $value->id) selected @endif>{{$value->name}}</option>
                    @endforeach
                </select>            
            </div>
        </div>
         <div class="form-group">
            {!! Form::label('img','صورة الخدمة', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
            <div class="col-sm-10">
                {!! Form::file('img', array('class' => 'form-control')) !!}                
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('color','لون  القسم', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
            <div class="col-sm-10">
                <input type="color" value="{{$item->color}}" name="color" id="color" class="form-control" style="width: 20%;">              
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
             
    <div class="col-lg-3">
         <div class="form-panel">     
             @if($item->img == '')
                <img src="{{asset('admin_asset/img/logo.png')}}" class="img img-rounded img-responsive"/>             
             @else
                <img src="{{asset('uploads')}}/{{$item->img}}" class="img img-rounded img-responsive"/>
             @endif
             
             
         </div>
    </div>
</div>

@stop



  