<form method="post" action="{{url('admin/create_codes')}}">
     {{ csrf_field() }}
    <input type="submit" value="Create" />
</form>