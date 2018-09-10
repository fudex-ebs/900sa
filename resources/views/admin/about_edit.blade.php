@extends('admin/master',['title'=>$item->title,'active'=>'about'])
@section('content')
<div class="row mt">
        <div class="col-lg-9">
  <div class="form-panel">      
          <h4 class="mb"><i class="fa fa-angle-right"></i> تعديل    {{$item->title}} </h4>
          <hr/>
           <?php  echo Form::open(['action' => ['AdminController@updateAbout', $item->id]
                                ,'files'=>TRUE,'class'=>'form-horizontal style-form']);  ?>
                    
              {{ csrf_field() }}
         
        <div class="form-group">
            {!! Form::label('img','الصورة التوضيحية', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
            <div class="col-sm-10">
               {!! Form::file('img', null) !!}                
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('title','العنوان', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
            <div class="col-sm-10">
                {!! Form::text('title',$item->title, array('class' => 'form-control')) !!}                
            </div>
        </div>
         <div class="form-group">
            {!! Form::label('body','المحتوى', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
            <div class="col-sm-10">
               {!! Form::textarea('body', $item->body, array('class' => 'form-control')) !!}               
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
            <img src="{{asset('uploads')}}/{{$item->img}}" class="img img-rounded img-responsive"/>
         </div>
    </div>
</div>

@stop



  