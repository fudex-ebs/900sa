@extends('admin/master',['title'=>$item->title,'active'=>'settings'])
@section('content')
<div class="row mt">
        <div class="col-lg-12">
  <div class="form-panel">      
          <h4 class="mb"><i class="fa fa-angle-right"></i> تعديل    {{$item->title}} </h4>
          <hr/>
           <?php  echo Form::open(['action' => ['AdminController@updateSetting', $item->id]
                                ,'files'=>TRUE,'class'=>'form-horizontal style-form']);  ?>
                    
              {{ csrf_field() }}
         
        <div class="form-group">
            {!! Form::label('title','العنوان  ', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
            <div class="col-sm-10">
                {!! Form::text('title', $item->title, array('class' => 'form-control','readonly')) !!}                
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('value','القيمة  ', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
            <div class="col-sm-10">
                {!! Form::text('value', $item->value, array('class' => 'form-control')) !!}                
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



  