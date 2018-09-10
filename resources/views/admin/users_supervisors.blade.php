@extends('admin/master',['title'=>'المشرفين','active'=>'users'])
@section('content')
<div class="row mt">
         
<div class="col-lg-12">
     <div class="form-panel">
         <form method="post" action="manageUsers">
            {{ csrf_field() }}            
         <table class="table table-striped table-advance table-hover" id="myTbl">
            <h4><i class="fa fa-angle-right"></i> عرض المشرفين </h4>
            <hr>
               @include('admin/include/control_btns')
        <thead>
            <tr>
                <th><input type="checkbox" id="chkAll"/></th>
                <th>الاسم</th>               
                <th>الجوال</th>
                <th>نشط</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $row)                    
                <tr>
                    <th><input type="checkbox" class="chkMe" name="chkMe[]" value="{{$row->id}}"/></th>
                    <td>{{ $row->name }}</td>                                        
                    <td>{{ $row->mobile }}</td>                                        
                     <td>
                        @if($row->active == 1) <span class="label label-info label-mini"> نعم</span>
                        @else <span class="label label-warning label-mini"> لا </span> @endif
                    </td>
                    <td>                        
                        <a href="{{ url('admin/user') }}/{{$row->id}}/edit" class="btn btn-primary btn-xs" title="تعديل"><i class="fa fa-pencil"></i></a>
                        <a href="{{ url('admin/user') }}/{{$row->id}}/delete" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>
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



  