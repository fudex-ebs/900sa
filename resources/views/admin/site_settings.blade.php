@extends('admin/master',['title'=>'اعدادات الموقع','active'=>'settings'])
@section('content')
<div class="row mt">
        <div class="col-lg-6">
  <div class="form-panel">      
          <h4 class="mb"><i class="fa fa-angle-right"></i> أضف اعداد </h4>
          <hr/>
          <?php  echo Form::open(['action' => ['AdminController@addSetting']
                                ,'files'=>TRUE,'class'=>'form-horizontal style-form']);  ?>
              {{ csrf_field() }}
         
        <div class="form-group">
            {!! Form::label('title','العنوان', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
            <div class="col-sm-10">
                {!! Form::text('title', null, array('class' => 'form-control')) !!}                
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('value','القيمة', array('class'=>'col-sm-2 col-sm-2 control-label')) !!}                                           
            <div class="col-sm-10">
                {!! Form::text('value', null, array('class' => 'form-control')) !!}                
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
         <form method="post" action="manageSettings">
            {{ csrf_field() }}            
         <table class="table table-striped table-advance table-hover" id="myTbl">
            <h4><i class="fa fa-angle-right"></i> عرض الاعدادات </h4>
            <hr>
               @include('admin/include/control_btns')
        <thead>
            <tr>
                <th><input type="checkbox" id="chkAll"/></th>
                <th>العنوان</th>               
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $row)                    
                <tr>
                    <th><input type="checkbox" class="chkMe" name="chkMe[]" value="{{$row->id}}"/></th>
                    <td>{{ $row->title }}</td>                                        
                    <td>                        
                        <a href="{{ url('admin/setting') }}/{{$row->id}}/edit" class="btn btn-primary btn-xs" title="تعديل"><i class="fa fa-pencil"></i></a>
                        <a href="{{ url('admin/setting') }}/{{$row->id}}/delete" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>
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



  