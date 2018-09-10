@extends('admin/master',['title'=>'أضف طلب','active'=>'requests'])
@section('content')
<div class="row mt">
        <div class="col-lg-12">
  <div class="form-panel">      
          <h4 class="mb"><i class="fa fa-angle-right"></i> أضف طلب </h4>
          <hr/>
         
          <?php echo Form::open(['action' => ['AdminController@insertRequest']
                                ,'files'=>TRUE,'class'=>'form-horizontal style-form']);  ?>
              {{ csrf_field() }}
         
         <div class="form-group">
            {!! Form::label('category','نوع القسم', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
            <div class="col-sm-10">
                <select name="category" id="category" class="form-control">
                    <option value="0"> -- اختر نوع القسم</option>
                    @foreach($categories as $category)
                         <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('sub_category','القسم الفرعى', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
            <div class="col-sm-10">
                <select name="sub_category" id="sub_category" class="form-control">
                    <option value="0"> -- اختر القسم الفرعى  </option>                    
                </select>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('title','عنوان الطلب', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
            <div class="col-sm-10">
                {!! Form::text('title','', array('class' => 'form-control')) !!}                
            </div>
        </div>
         
        <div class="form-group">
            {!! Form::label('file','ارفق ملف', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
            <div class="col-sm-10">
                {!! Form::file('file', array('class' => 'form-control')) !!}                
            </div>
        </div>
        
         <div class="form-group">
            {!! Form::label('description','وصف الطلب', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
            <div class="col-sm-10">
               {!! Form::textarea('description', '', array('class' => 'form-control')) !!}               
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



  