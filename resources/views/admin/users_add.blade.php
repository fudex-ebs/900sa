@extends('admin/master',['title'=>'أضف مستخدم','active'=>'users'])
@section('content')

<div class="row mt">
        <div class="col-lg-12">
  <div class="form-panel">      
          <h4 class="mb"><i class="fa fa-angle-right"></i> أضف مستخدم </h4>
          <hr/>
         
          <?php echo Form::open(['action' => ['AdminController@insertUser']
                                ,'files'=>TRUE,'class'=>'form-horizontal style-form']);  ?>
              {{ csrf_field() }}
         
         <div class="form-group">
            {!! Form::label('role','نوع المستخدم', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
            <div class="col-sm-10">
                <select name="role" id="role" class="form-control">
                    <option value="0"> -- اختر نوع المستخدم</option>
                    @foreach($roles as $role)
                         <option value="{{$role->id}}">{{$role->title}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('name','الاسم', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
            <div class="col-sm-10">
                {!! Form::text('name','', array('class' => 'form-control')) !!}                
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('email','البريد الالكترونى', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
            <div class="col-sm-10">
                {!! Form::email('email','', array('class' => 'form-control')) !!}                
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
                {!! Form::text('mobile','', array('class' => 'form-control')) !!}                
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('address','العنوان', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
            <div class="col-sm-10">
            {!! Form::text('address','', array('class' => 'form-control')) !!}         
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('active','نشط؟', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                               
            <div class="col-sm-10">
               <div class="radio">                    
                    <label> <input type="radio" name="active" id="yes" value="1" checked> نعم </label>                    
                    <label> <input type="radio" name="active" id="no" value="0"> لا </label>                    
               </div>
            </div>
        </div>
             
              <div id="companyInfo" style="display: none;">
                 <h4 class="mb"><i class="fa fa-angle-right"></i> بيانات الشركة   </h4>
                <hr/>
                <div class="form-group">
                    {!! Form::label('logo','شعار الشركة', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
                    <div class="col-sm-10">
                    {!! Form::file('logo','', array('class' => 'form-control')) !!}         
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('category','خدمات الشركة', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
                    <div class="col-sm-10">
                    @foreach($categories as $category)
                    <label>
                    <input type="checkbox" value="{{$category->id}}" name="category[]" class="checkbox-inline"/>{{$category->name}}
                    </label>
                    @endforeach
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('about','عن  الشركة', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
                    <div class="col-sm-10">
                    {!! Form::text('about','', array('class' => 'form-control')) !!}         
                    </div>
                </div>
                 <div class="form-group">
                    {!! Form::label('commercial_registration_no','رقم السجل التجارى', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
                    <div class="col-sm-5">
                    {!! Form::text('commercial_registration_no','', array('class' => 'form-control')) !!}         
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('commercial_registration_expire_date','تاريخ انتهاء السجل التجارى', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
                    <div class="col-sm-5">
                    {!! Form::text('commercial_registration_expire_date','', array('class' => 'form-control','placeholder'=>'2017-11-27')) !!}         
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('commercial_registration_img','ارفق صورة من السجل التجارى', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
                    <div class="col-sm-5">
                    {!! Form::file('commercial_registration_img','', array('class' => 'form-control')) !!}         
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('company_type','نوع الشركة', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
                    <div class="col-sm-5">
                        <select name="company_type" id="company_type" class="form-control">
                            <option value="0">-- اختر نوع الشركة</option>
                            @foreach($company_type as $type)
                            <option value="{{$type->id}}">{{$type->name}}</option>
                            @endforeach
                        </select>
                    </div>
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

   

  