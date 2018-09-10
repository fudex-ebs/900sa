@extends('auth/outer_master',['title'=>'اشتراك جديد'])

@section('content')
<div id="login-page">
<div class="container">

    <form class="form-login" action="{{ route('register') }}" method="post">
        {{ csrf_field() }}
        <h2 class="form-login-heading">اشتراك جديد   </h2>
        <div class="login-wrap">
             <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" 
                       required autofocus placeholder="الاسم">

                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif                            
            </div>

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">                
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" 
                           required placeholder="البريد الالكترونى">

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif              
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">                
                    <input id="password" type="password" class="form-control" name="password" required
                           placeholder="كلمة المرور">

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif               
            </div>

            <div class="form-group">                
                <input id="password-confirm" type="password" class="form-control" placeholder="تأكيد كلمة المرور"
                           name="password_confirmation" required>                
            </div>
            <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
                <input id="mobile" type="tel" class="form-control" name="mobile" value="{{ old('mobile') }}" 
                          placeholder="الجوال">                      
            </div>
            
            <div class="form-group">               
                    <button type="submit" class="btn btn-theme">
                        اشتراك
                    </button>                
            </div>
            <hr/>
            <div class="registration">               
                <a class="" href="{{ url('login') }}">
                الرجوع لتسجيل الدخول
                </a>
            </div>
            

        </div>
    </form>
         	

</div>
</div>






@endsection
