@extends('admin/master',['title'=>'طلبات النقاط  ','active'=>'points'])
@section('content')
<div class="row mt">
         
<div class="col-lg-12">
     <div class="form-panel">
         <form method="post" action="managePoints">
            {{ csrf_field() }}            
         <table class="table table-striped table-advance table-hover" id="myTbl">
            <h4><i class="fa fa-angle-right"></i> عرض الطلبات </h4>
            <hr>
            
            <label>حالة الطلبات : </label> &nbsp;
            <select name="status" id="status">
                <option value="0" selected="">-- اختر حالة</option>
                @foreach($status as $s)
                <option value="{{$s->id}}">{{$s->title}}</option>
                @endforeach
            </select> &nbsp;
            <button name="action" value="changeStatus" class="btn btn-success btn-xs" title="عدل ">
            <i class="fa fa-edit "></i> تعديل</button>
                         
               @include('admin/include/control_btns')
        <thead>
            <tr>
                <th><input type="checkbox" id="chkAll"/></th>
                <th>#</th>               
                <th class="text-center">عدد النقاط</th>
                <th class="text-center">مقدم من  </th>
                <th>حالة الطلب  </th>
                <th>بتاريخ</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $row)                    
                <tr>
                    <th><input type="checkbox" class="chkMe" name="chkMe[]" value="{{$row->itmID}}"/></th>
                    <td>{{ $row->itmID }}</td>                                        
                    <td class="text-center">{{$row->points}}</td>                   
                    <td class="text-center">{{$row->name}}</td> 
                    <td class="text-center">{{$row->title}}</td>
                    <td class="text-center">{{$row->created_at}}</td>
                    <td>                        
                        <!--<a href="{{ url('admin/request') }}/{{$row->itmID}}/edit" class="btn btn-primary btn-xs" title="تعديل"><i class="fa fa-pencil"></i></a>-->
                        <a href="{{ url('admin/requestPoint') }}/{{$row->itmID}}/delete" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>
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
