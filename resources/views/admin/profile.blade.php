@extends('admin/master',['title'=>$item->name,'active'=>'dashboard'])
@section('content')
<div class="row mt">
        <div class="col-lg-9">
  <div class="form-panel">      
          <h4 class="mb"><i class="fa fa-angle-right"></i> تعديل     بياناتى </h4>
          <hr/>
           <?php  echo Form::open(['action' => ['AdminController@updateProfile', $item->id]
                                ,'files'=>TRUE,'class'=>'form-horizontal style-form']);  ?>
                    
              {{ csrf_field() }}
         
        
        <div class="form-group">
            {!! Form::label('name','الاسم', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
            <div class="col-sm-10">
                {!! Form::text('name',$item->name, array('class' => 'form-control')) !!}                
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('email','البريد الالكترونى', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
            <div class="col-sm-10">
                {!! Form::email('email',$item->email, array('class' => 'form-control')) !!}                
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('password','كلمة المرور', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
            <div class="col-sm-10">
                {!! Form::password('password','', array('class' => 'form-control')) !!}                
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('confirm_password','تأكيد كلمة المرور', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
            <div class="col-sm-10">
                {!! Form::password('confirm_password','', array('class' => 'form-control')) !!}                
            </div>
        </div>  
        <div class="form-group">
            {!! Form::label('mobile','الجوال', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
            <div class="col-sm-10">
                {!! Form::text('mobile',$item->mobile, array('class' => 'form-control')) !!}                
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('address','العنوان', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
            <div class="col-sm-10">
                {!! Form::text('address',$item->address, array('class' => 'form-control')) !!}                
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
            <img src="{{asset('admin_asset/img/logo.png')}}" class="img img-rounded img-responsive"/>
         </div>
    </div>
</div>

@stop



  