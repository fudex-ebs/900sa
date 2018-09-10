@extends('admin/master',['title'=>'الشركات','active'=>'users'])
@section('content')
<div class="row mt">
         
<div class="col-lg-12">
     <div class="form-panel">
         <form method="post" action="manageUsers">
            {{ csrf_field() }}            
         <table class="table table-striped table-advance table-hover" id="myTbl">
            <h4><i class="fa fa-angle-right"></i> عرض الشركات </h4>
            <hr>
               @include('admin/include/control_btns')
        <thead>
            <tr>
                <th class="text-center"><input type="checkbox" id="chkAll"/></th>
                <td>#</td>               
                <th class="text-center">Short Code</th>
                <th class="text-center">long Code</th>
                 <th class="text-center">Qr Code</th>
                <th class="text-center">الاسم</th>               
                <th class="text-center">الجوال</th>
                <th class="text-center">نشط</th>
                <th class="text-center">مميز؟</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $row)                    
                <tr>
                    <th><input type="checkbox" class="chkMe" name="chkMe[]" value="{{$row->itmID}}"/></th>
                    <th>{{$row->company_id}}</th>
                    <th>{{$row->short_code}}</th>
                    <th>{{$row->long_code}}</th>
                    <th><img ng-if="$row->qr_code != NULL" src="{{asset('uploads/qr_code')}}/{{$row->qr_code}}" width="100"/></th>
                    <td class="text-center"><a href="{{url('company')}}/{{$row->itmID}}" target="_blank">{{ $row->name }}</a></td>                                        
                    <td class="text-center">{{ $row->mobile }}</td>                                        
                     <td class="text-center">
                        @if($row->active == 1) <span class="label label-info label-mini"> نعم</span>
                        @else <span class="label label-warning label-mini"> لا </span> @endif
                    </td>
                    <td class="text-center">
                        <div class="switch switch-square"
                            data-on-label="<i class=' fa fa-check'></i>"
                            data-off-label="<i class='fa fa-times'></i>">
                            <input type="checkbox" class="makeSpecial" value="{{$row->id}}" 
                                   @if($row->special ==1) checked @endif/>                            
                       </div>
                    </td>
                    <td class="text-center">                        
                        <a href="{{ url('admin/user') }}/{{$row->itmID}}/edit" class="btn btn-primary btn-xs" title="تعديل"><i class="fa fa-pencil"></i></a>
                        <a href="{{ url('admin/user') }}/{{$row->itmID}}/delete" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>
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



  