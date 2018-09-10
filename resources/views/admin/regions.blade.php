@extends('admin/master',['title'=>'المناطق الجغرافية','active'=>'regions'])
@section('content')
<div class="row mt">
        <div class="col-lg-6">
  <div class="form-panel">      
          <h4 class="mb"><i class="fa fa-angle-right"></i> أضف منطقة </h4>
          <hr/>
          <?php  echo Form::open(['action' => ['AdminController@addRegion']
                                ,'files'=>TRUE,'class'=>'form-horizontal style-form']);  ?>
              {{ csrf_field() }}
        <div class="form-group">
            {!! Form::label('country','البلد ', array('class'=>'col-sm-3 col-sm-3 control-label')) !!}                                           
            <div class="col-sm-9">
                <select name="country" id="country" class="form-control">
                    <option value="0">-- اختر البلد -- </option>
                    @foreach($countries as $country)
                    <option value="{{$country->id}}">{{$country->title_ar}}</option>
                    @endforeach
                </select>
            </div>
        </div>
         <div class="form-group">
            {!! Form::label('airport_type','نوع المطار  ', array('class'=>'col-sm-3 col-sm-3 control-label')) !!}                                           
            <div class="col-sm-9">
                <select name="airport_type" id="airport_type" class="form-control">
                    <option value="0">-- اختر نوع المطار -- </option>
                    @foreach($airport_types as $air)
                    <option value="{{$air->id}}">{{$air->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
         <div class="form-group">
            {!! Form::label('name','اسم المطار', array('class'=>'col-sm-3 col-sm-3 control-label')) !!}                                           
            <div class="col-sm-9">
                {!! Form::text('name', null, array('class' => 'form-control')) !!}                
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('position','الموقع', array('class'=>'col-sm-3 col-sm-3 control-label')) !!}                                           
            <div class="col-sm-9">
                {!! Form::text('position', null, array('class' => 'form-control')) !!}                
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('code','كود المنطقة', array('class'=>'col-sm-3 col-sm-3 control-label')) !!}                                           
            <div class="col-sm-9">
                {!! Form::text('code', null, array('class' => 'form-control')) !!}                
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('lat','Latitude  ', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
            <div class="col-sm-4">
                {!! Form::text('lat', null, array('class' => 'form-control')) !!}                
            </div>
            
            {!! Form::label('lng','Langitude  ', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
            <div class="col-sm-4">
                {!! Form::text('lng', null, array('class' => 'form-control')) !!}                
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
      <div class="form-group">
            {!! Form::label('sort','الترتيب', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                               
            <div class="col-sm-2">
                <select name="sort" id="sort" class="form-control">
                    @for($i=0 ; $i<=10 ; $i++)
                    <option value="{{$i}}">{{ $i }}</option>
                    @endfor
                </select>
            </div>
        </div>       
        <div class="form-group">
            <div class="col-sm-2"></div>
            <div class="col-sm-10">
                {!! Form::submit('أضف', array('class'=>'btn btn-theme')) !!}
                {!! Form::close() !!}
            </div>
        </div>
      
  </div>
        </div>
<div class="col-lg-6">
     <div class="form-panel">
         <form method="post" action="manageRegions">
            {{ csrf_field() }}            
         <table class="table table-striped table-advance table-hover" id="myTbl">
            <h4><i class="fa fa-angle-right"></i> عرض المناطق الجغرافية </h4>
            <hr>
               @include('admin/include/control_btns')
        <thead>
            <tr>
                <th><input type="checkbox" id="chkAll"/></th>
                <th class="text-center">الاسم</th>               
                <th class="text-center">الكود</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $row)                    
                <tr>
                    <th><input type="checkbox" class="chkMe" name="chkMe[]" value="{{$row->id}}"/></th>
                    <th class="text-center">{{ $row->name }}</th>
                    <td class="text-center">{{ $row->code }}</td>                                        
                    <td>                        
                        <a href="{{ url('admin/regions') }}/{{$row->id}}/edit" class="btn btn-primary btn-xs" title="تعديل"><i class="fa fa-pencil"></i></a>
                        <!--<a href="{{ url('admin/regions') }}/{{$row->id}}/delete" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>-->
                    </td>
                </tr>             
            @endforeach            
        </tbody>
        </table>
         </form>
         <div class="clearfix"></div>
     </div>
            
            
    </div>
</div>

@stop



  