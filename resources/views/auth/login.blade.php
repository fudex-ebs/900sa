@extends('auth/outer_master',['title'=>'تسجيل الدخول'])

@section('content')
<div id="login-page">
<div class="container">

    <form class="form-login" action="{{ url('/login') }}" method="post">
        {{ csrf_field() }}
        <h2 class="form-login-heading">تسجيل دخول الأدمن </h2>
        <div class="login-wrap">
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <input type="email" name="email" class="form-control" placeholder="البريد الالكترونى" value="{{ old('email') }}" autofocus>
             @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
            </div>
            <br>
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <input type="password" name="password" class="form-control" placeholder="كلمة المرور">
             @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember"> &nbsp; &nbsp; &nbsp; تذكرنى
                        </label>
                    </div>
                </div>
                <div class="col-md-12">
                     <a data-toggle="modal" href="login.html#myModal"> نسيت كلمة المرور؟</a>
                </div>
                    
            </div>
            <div class="clearfix"></div><br/>
            <button class="btn btn-theme btn-block" type="submit"><i class="fa fa-lock"></i> دخول</button>
            <hr>
             
            <div class="registration">
               لا تمتلك حساب<br/>
                <a class="" href="{{ url('register') }}">
                  تسجيل اشتراك جديد
                </a>
            </div>

        </div>
    </form>
          <!-- Modal -->
          <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                        {{ csrf_field() }}
          <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
              <div class="modal-dialog">
                  <div class="modal-content">
                       @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title">نسيت كلمة المرور</h4>
                      </div>
                      <div class="modal-body form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                          <div class="col-md-12">
                          <p>ادخل بريدك الالكترونى  المسجل به</p>
                          <input type="email" id="email" name="email" placeholder="البريد الالكترونى" autocomplete="off" 
                                 class="form-control placeholder-no-fix" value="{{ old('email') }}" required="">
                             @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                          </div>
                      </div>
                      <div class="modal-footer">
                          <button class="btn btn-theme" type="submit">استرجاع</button>
                          <button data-dismiss="modal" class="btn btn-default" type="button">الغاء</button>                          
                      </div>
                  </div>
              </div>
          </div>
         </form>
          <!-- modal -->

        	

</div>
</div>
 
@endsection


 