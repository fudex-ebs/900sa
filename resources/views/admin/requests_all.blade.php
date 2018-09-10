@extends('admin/master',['title'=>'عرض الطلبات','active'=>'requests'])
@section('content')
<div class="row mt">
         
<div class="col-lg-12">
     <div class="form-panel">
         <form method="post" action="manageRequests">
            {{ csrf_field() }}            
         <table class="table table-striped table-advance table-hover" id="myTbl">
            <h4><i class="fa fa-angle-right"></i> عرض الطلبات </h4>
            <hr>
             <li> <a href="{{url('admin/request_add')}}" class="btn btn-success btn-xs" title="حذف ">
            <i class="fa fa-plus-circle "></i></a></li>         
            
               @include('admin/include/control_btns')
        <thead>
            <tr>
                <th><input type="checkbox" id="chkAll"/></th>
                <th>عنوان الطلب</th>               
                <th class="text-center">التصنيف</th>
                <!--<th>التصنيف الفرعى</th>-->
                <th class="text-center">انشأ بواسطة</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $row)                    
                <tr>
                    <th><input type="checkbox" class="chkMe" name="chkMe[]" value="{{$row->reqID}}"/></th>
                    <td>{{ $row->title }}</td>                                        
                    <td class="text-center">{{$row->name}}</td>
                   
                    <td class="text-center">{{$row->userName}}</td>                                                             
                    <td>                        
                        <a href="{{ url('admin/request') }}/{{$row->reqID}}/edit" class="btn btn-primary btn-xs" title="تعديل"><i class="fa fa-pencil"></i></a>
                        <a href="{{ url('admin/request') }}/{{$row->reqID}}/delete" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>
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
