@extends('admin/master',['title'=>'الأقســام','active'=>'dashboard'])
@section('content')
<div class="row mt">
        <div class="col-lg-6">
  <div class="form-panel">      
          <h4 class="mb"><i class="fa fa-angle-right"></i> أضف قسم </h4>
          <hr/>
          <?php  echo Form::open(['action' => ['AdminController@addCategory']
                                ,'files'=>TRUE,'class'=>'form-horizontal style-form']);  ?>
              {{ csrf_field() }}
         
        <div class="form-group">
            {!! Form::label('code','كود التصنيف  ', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
            <div class="col-sm-10">
                {!! Form::text('code', null, array('class' => 'form-control')) !!}                
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('name','اسم القسم', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
            <div class="col-sm-10">
                {!! Form::text('name', null, array('class' => 'form-control')) !!}                
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('parent','القسم الأب', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
            <div class="col-sm-10">
                <select name="parent" id="parent" class="form-control">
                    <option value="0">-- اختر قسم</option>
                    @foreach($parents as $value)
                    <option value="{{$value->id}}">{{$value->name}}</option>
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
                <input type="color" value="#abe07b" name="color" id="color" class="form-control" style="width: 20%;">              
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
         <form method="post" action="manageCategories">
            {{ csrf_field() }}
         <table class="table table-striped table-advance table-hover" id="myTbl">
            <h4><i class="fa fa-angle-right"></i> عرض الأقسام </h4>
            <hr>
               @include('admin/include/control_btns')
        <thead>
            <tr>
                <th class="text-center"><input type="checkbox" id="chkAll"/></th>
                <th class="text-center">لون القسم</th>
                <th class="text-center">كود</th>
                <th class="text-center">القسم</th>
                <!--<th>القسم الأب</th>-->   
                <!--<th>الترتيب</th>-->
                <th class="text-center">نشط</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $row)       
             
                <tr>
                    <td><input type="checkbox" class="chkMe" name="chkMe[]" value="{{$row->id}}"/></td>
                    <td class="text-center"><span class="catColor" style="background: {{$row->color}}"></span></td>
                    <td>{{$row->code}}</td>
                    <td>{{ $row->name }}</td>
                    <!--<td></td>-->
                    <!--<td>{{ $row->sort }}</td>-->
                    <td>
                        @if($row->active == 1) <span class="label label-info label-mini"> نعم</span>
                        @else <span class="label label-warning label-mini"> لا </span> @endif
                    </td>
                    <td>
                        <!--<button class="btn btn-success btn-xs"><i class="fa fa-check"></i></button>-->
                        <a href="{{ url('admin/category') }}/{{$row->id}}/edit" class="btn btn-primary btn-xs" title="تعديل"><i class="fa fa-pencil"></i></a>
                        <a href="{{ url('admin/category') }}/{{$row->id}}/delete" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>
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



  