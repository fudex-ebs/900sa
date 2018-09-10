@extends('admin/master',['title'=>$item->name,'active'=>'dashboard'])
@section('content')
<div class="row mt">
        <div class="col-lg-9">
  <div class="form-panel">      
          <h4 class="mb"><i class="fa fa-angle-right"></i> تعديل     بيانات {{$item->name}} </h4>
          <hr/>
           <?php  echo Form::open(['action' => ['AdminController@updateUser', $item->id]
                                ,'files'=>TRUE,'class'=>'form-horizontal style-form']);  ?>
                    
              {{ csrf_field() }}
         
        <div class="form-group">
            {!! Form::label('role','نوع المستخدم', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
            <div class="col-sm-10">
                <select name="role" id="role" class="form-control">
                    <option value="0"> -- اختر نوع المستخدم</option>
                    @foreach($roles as $role)
                         <option value="{{$role->id}}" 
                                 @if($item->role == $role->id) selected @endif>{{$role->title}}</option>
                    @endforeach
                </select>
            </div>
        </div>
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
                {!! Form::password('password', array('class' => 'form-control')) !!}                
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('confirm_password','تأكيد كلمة المرور', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
            <div class="col-sm-10">
                {!! Form::password('confirm_password', array('class' => 'form-control')) !!}                
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
            {!! Form::label('active','نشط؟', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                               
            <div class="col-sm-10">
               <div class="radio">                    
                    <label> <input type="radio" name="active" id="yes" value="1" @if($item->active == 1) checked @endif> نعم </label>                    
                    <label> <input type="radio" name="active" id="no" value="0" @if($item->active == 0) checked @endif> لا </label>                    
               </div>
            </div>
        </div>
             
        @if($item->role == 3)
        <div id="companyInfo">
                 <h4 class="mb"><i class="fa fa-angle-right"></i> بيانات الشركة   </h4>
                <hr/>
                <div class="form-group">
                    {!! Form::label('logo','شعار الشركة', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
                    <div class="col-sm-10">
                    {!! Form::file('logo', array('class' => 'form-control')) !!}         
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('category','خدمات الشركة', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                                               
                    <div class="col-sm-10">
                    @foreach($categories as $category)
                    <?php $cats = explode(',', $company->category);
                    if($cats){
                        foreach ($cats as $value) { ?>
                    @if($value == $category->id)
                          <label>
                              <input type="checkbox" value="{{$category->id}}" name="category[]" class="checkbox-inline" checked=""/>{{$category->name}}
                    </label>
                    
                    @endif
                    <?php }}
                    ?>
                    <label>
                    <input type="checkbox" value="{{$category->id}}" name="category[]" class="checkbox-inline"/>{{$category->name}}
                    </label>
                    @endforeach
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('about','عن  الشركة', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
                    <div class="col-sm-10">
                    {!! Form::text('about',$company->about, array('class' => 'form-control')) !!}         
                    </div>
                </div>
                 <div class="form-group">
                    {!! Form::label('commercial_registration_no','رقم السجل التجارى', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
                    <div class="col-sm-5">
                    {!! Form::text('commercial_registration_no',$company->commercial_registration_no, array('class' => 'form-control')) !!}         
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('commercial_registration_expire_date','تاريخ انتهاء السجل التجارى', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
                    <div class="col-sm-5">
                    {!! Form::text('commercial_registration_expire_date',$company->commercial_registration_expire_date, array('class' => 'form-control','placeholder'=>'2017-11-27')) !!}         
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('commercial_registration_img','ارفق صورة من السجل التجارى', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
                    <div class="col-sm-5">
                    {!! Form::file('commercial_registration_img', array('class' => 'form-control')) !!}         
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('company_type','نوع الشركة', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
                    <div class="col-sm-5">
                        <select name="company_type" id="company_type" class="form-control">
                            <option value="0">-- اختر نوع الشركة</option>
                            @foreach($company_type as $type)
                            <option value="{{$type->id}}" @if($company->company_type == $type->id) selected @endif>{{$type->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
              </div>    
        
        @endif
              
              <div class="form-group">
                  <div class="col-sm-2"></div>
                  <div class="col-sm-10">
                      {!! Form::submit('حفظ', array('class'=>'btn btn-theme')) !!}
      {!! Form::close() !!}
                  </div>
              </div>
      
  </div>
        </div>
             
    @if($item->role == 3)
    @if($company)
    <div class="col-lg-3">
         <div class="form-panel"> 
             <h4>Qr Code</h4><hr/>
                <img ng-if="$company->qr_code != NULL" src="{{asset('uploads/qr_code')}}/{{$company->qr_code}}" class="img img-rounded img-responsive"/>            
                
                <h4>شعار الشركة</h4><hr/>
                <img ng-if="$company->logo != NULL" src="{{asset('uploads')}}/{{$company->logo}}" class="img img-rounded img-responsive"/>
                
                <h4>صورة السجل التجارى</h4><hr/>
                <img ng-if="$company->commercial_registration_img != NULL" src="{{asset('uploads')}}/{{$company->commercial_registration_img}}" class="img img-rounded img-responsive"/>
         </div>
    </div>
    @endif
    @endif
</div>

@stop



  