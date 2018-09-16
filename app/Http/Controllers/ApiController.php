<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use DB;
use Config;
use Schema;
use App\User;
use Mail;
use Illuminate\Support\Facades\Hash;
use Auth;
use QrCode;


//Dynamic RESTFULL API JSON 
class ApiController extends Controller{
    
    public $Levaral;
    
    public function __construct() {
        
    }

    public function index(){
      $database = Config::get('database.connections.'.Config::get('database.default').'.database');
      $tables = DB::select('SHOW TABLES');
      //print_r($tables);
      
       $models = $this->getModels();
       $all_models = [];
      // dd($all_models);
     /* foreach ($models as $k=>$model){
          $_model = "App\\".str_replace(".php","",$model);
          $class = new $_model;
         //echo $class->getTable()."--";
          if($class->getTable() != 'migrations'){
			$all_models[$class->getTable()] = $model;
		  }else{
			  unset($all_models[$class->getTable()]);
		  }
      }
      */
//      print_r($all_models);
      
      foreach($tables as $k=>$table){
          $tableName = $table->{'Tables_in_'.$database};
          if($tableName != 'migrations'){
			   $table_info_columns = DB::select('SHOW COLUMNS FROM '.$tableName);
			   $tables[$k]->fields = $table_info_columns;
		   }else{
				unset($tables[$k]);
			}
        //  echo $this->getModelFromTable($tableName);
         // echo "<a href='".url('api/'.$tableName)."' >".$tableName."</a><br />";
          
      }
     
      // $arr = $this->urlJsonToArray("http://localhost/demo/laravel_demo/1/cf4it/server.php/api/departments?select=id,name,img_url&order_by=id:DESC&limit=3",true);
      // echo "<pre>";
       //print_r($arr);
      return view('api/main',compact('tables','database','models','all_models'));
    }

    public function select($table,Request $request){
      $database = Config::get('database.connections.'.Config::get('database.default').'.database');

        if(Schema::hasTable($table) == 1){
          $table_info_columns = DB::select('SHOW COLUMNS FROM '.$table);
      //    echo "<pre>";
      //  print_r($table_info_columns);
      //  foreach($table_info_columns as $column){
        // $col_name = $column['Field'];
        //   $col_type = $column['Type'];
        // var_dump($col_name,$col_type);
      //  }
            $inputs = $request->all();
            
            if($request->get('limit')){
              $limit = $request->get('limit');
            }else{
              $limit = null;
            }

            if($request->get('select')){
              $select = explode(",",$request->get('select'));
            }else{
              $select = ['*'];
            }

            $conditions = [];
            $columns = Schema::getColumnListing($table);
            foreach ($columns as $value) {
                if($request->get($value)){
                    
                  
//                    if($_v[0] == '[' && $_v[strlen($_v) - 1] == ']') {
//                        $_v = json_decode($_v);
//                         print_r($_v);
//                    }
                    $_v = $request->get($value);
                    $_v = json_decode($_v);
                    
                  if(strpos($request->get($value),'!') !== FALSE){
                     
                  }else if(strpos($request->get($value),'LIKE:') !== FALSE){
                    
                  }else if(strpos($request->get($value),'>:') !== FALSE || strpos($request->get($value),'<:') !== FALSE || strpos($request->get($value),'>') !== FALSE || strpos($request->get($value),'<') !== FALSE){
                      
                  }else if(is_array($_v)){
//                        print_r($_v);
                  }else{
                      $conditions[$value] = $request->get($value);
                  }
                  
                }
            }
//            exit;
           // print_r($conditions);
            $data = DB::table($table)->select($select);
//             $columns = Schema::getColumnListing($table);
            foreach ($columns as $value) {
                if($request->get($value)){
                    $_v = $request->get($value);
                    $_v = json_decode($_v);
                 //   echo $request->get($value);
                  if(strpos($request->get($value),'!') !== FALSE){
                      $_value = str_replace("!", "", $request->get($value));
                     $data->where($value,'!=',$_value);
                  }else if(strpos($request->get($value),'LIKE') !== FALSE){
                     
                      $_value = str_replace("LIKE:", "", $request->get($value));
                    $_value = urldecode($_value);
                      // echo $_value;
                      $data->whereRaw(" `".$value."` LIKE '%".$_value."%' ");
                  }else if(strpos($request->get($value),'>:') !== FALSE || strpos($request->get($value),'<:') !== FALSE || strpos($request->get($value),'>') !== FALSE || strpos($request->get($value),'<') !== FALSE){
                      if(strpos($request->get($value),'>:') !== FALSE ){
                          $_value = str_replace(">:", "", $request->get($value));
                          $sign = ">=";
                      }else if(strpos($request->get($value),'<:') !== FALSE){
                           $_value = str_replace("<:", "", $request->get($value));
                           $sign = "<=";
                      }else if(strpos($request->get($value),'>') !== FALSE){
                           $_value = str_replace(">", "", $request->get($value));
                           $sign = ">";
                      }else if(strpos($request->get($value),'<') !== FALSE){
                           $_value = str_replace("<", "", $request->get($value));
                           $sign = "<";
                      }
                      
                      $_value = urldecode($_value);
                       $data->where($value,$sign,$_value);
                      
                    }else if(is_array($_v)){
                        $data->whereIn($value,$_v);
                  }
                  
                }
            }
           
           $data = $data->where($conditions)->limit($limit);

            if($request->get('order_by')){
                $orderBy = explode(":",$request->get('order_by'));
                $data = $data->orderBy($orderBy[0],$orderBy[1]);
            }
            
             $sql = json_encode($data->toSql());

            $data = $data->get();
           
          
            $_data = [];
            $_data[$table] = $data;
            $_data['count'] = count($data);
            $_data['fields'] = $table_info_columns;
            $_data['sql'] = $sql;
             $headers= [
                    'Access-Control-Allow-Origin' => '*',
                    'Access-Control-Allow-Methods'=> 'POST, GET, OPTIONS, PUT, DELETE',
                    'Access-Control-Allow-Headers'=> 'Content-Type, X-Auth-Token, Origin'
               ];
            return response()->json($_data,$status=200, $headers, $options=JSON_PRETTY_PRINT);
        }else{
           return redirect(url('/'));
        }
    }


    public function join($table,Request $request){
      //api/join/products?leftJoin=categories:sub_cat,products.category_id:sub_cat.id::categories:main_cat,main_cat.id:sub_cat.parent_id&limit=3&order_by=products.id:DESC
//http://ndj.sa/demo/api/join/products?leftJoin=categories:sub_cat,products.category_id:sub_cat.id::categories:main_cat,main_cat.id:sub_cat.parent_id&limit=3&order_by=products.id:DESC
  //  http://ndj.sa/demo/api/join/products?leftJoin=categories,products.category_id:categories.id::categories:main_cat,main_cat.id:categories.parent_id&limit=3&order_by=products.id:DESC
      if($request->get('limit')){
        $limit = $request->get('limit');
      }else{
        $limit = null;
      }

      $conditions = [];
      $columns = [];

      $data = DB::table($table);
      $leftJoin = explode("::",$request->get('leftJoin'));

       $_columns = Schema::getColumnListing($table);
        foreach ($_columns as  $val_col) {
          $columns[] = $table.".".$val_col." as ".$table."_".$val_col;
        }
        
        $_columns = Schema::getColumnListing($table);
        
        $get = $request->all();

         foreach ($_columns as $val_cond) {
           $field_name = $table."_".$val_cond;
         // echo ($get[$field_name]);
           $field_with_table_name = $table.".".$val_cond;
             if(isset($get[$field_name])){
                  if(strpos($get[$field_name],'LIKE:') !== FALSE){
                      $_value = str_replace("LIKE:", "", $get[$field_name]);
                      $_value = urldecode($_value);
                      $data->whereRaw(" ".$field_with_table_name." LIKE '%".$_value."%' ");
                    
                  }else if(strpos($get[$field_name],'>:') !== FALSE || strpos($get[$field_name],'<:') !== FALSE || strpos($get[$field_name],'>') !== FALSE || strpos($get[$field_name],'<') !== FALSE){
                      if(strpos($get[$field_name],'>:') !== FALSE ){
                          $_value = str_replace(">:", "", $get[$field_name]);
                          $sign = ">=";
                      }else if(strpos($get[$field_name],'<:') !== FALSE){
                           $_value = str_replace("<:", "", $get[$field_name]);
                           $sign = "<=";
                      }else if(strpos($get[$field_name],'>') !== FALSE){
                           $_value = str_replace(">", "", $get[$field_name]);
                           $sign = ">";
                      }else if(strpos($get[$field_name],'<') !== FALSE){
                           $_value = str_replace("<", "", $get[$field_name]);
                           $sign = "<";
                      }
                      
                     // $_value = urldecode($_value);
                      echo (" ".$field_with_table_name." ".$sign." '".$_value."' ");
                       $data->whereRaw(" ".$field_with_table_name." ".$sign." '".$_value."' ");
                    
                  }else{
                       $conditions[$field_with_table_name] = $get[$field_name];//$request->get($val_cond);
                  }
              
             }
            
         }
         
         
      foreach ($leftJoin as $key => $value) {
        $exp = explode(",",$value);
        $on  = explode(":",$exp[1]);
         
        $_table = $exp[0];

        if(strpos($_table,':') !== FALSE){
            $_table2 = explode(":", $_table);
            $_table = $_table2[0];
            $asTable = $_table2[1];
            $asTable2 = $_table2[0]." as ".$_table2[1];
        }else{
            $asTable = $_table;
            $asTable2 = $_table;
        }
        
          $_columns = Schema::getColumnListing($_table);
         foreach ($_columns as $val_cond) {
           $field_name = $_table."_".$val_cond;
           $field_with_table_name = $_table.".".$val_cond;
             if(isset($get[$field_name])){
                 
                  if(strpos($get[$field_name],'>:') !== FALSE || strpos($get[$field_name],'<:') !== FALSE || strpos($get[$field_name],'>') !== FALSE || strpos($get[$field_name],'<') !== FALSE){
                      if(strpos($get[$field_name],'>:') !== FALSE ){
                          $_value = str_replace(">:", "", $get[$field_name]);
                          $sign = ">=";
                      }else if(strpos($get[$field_name],'<:') !== FALSE){
                           $_value = str_replace("<:", "", $get[$field_name]);
                           $sign = "<=";
                      }else if(strpos($get[$field_name],'>') !== FALSE){
                           $_value = str_replace(">", "", $get[$field_name]);
                           $sign = ">";
                      }else if(strpos($get[$field_name],'<') !== FALSE){
                           $_value = str_replace("<", "", $get[$field_name]);
                           $sign = "<";
                      }
                      
                     // $_value = urldecode($_value);
                    //  echo (" ".$field_with_table_name." ".$sign." '".$_value."' ");
                       $data->whereRaw(" ".$field_with_table_name." ".$sign." '".$_value."' ");
                    
                  }else{
                       $conditions[$field_with_table_name] = $get[$field_name];//$request->get($val_cond);
                  }
              
             }
            
         }
         
        $_columns = Schema::getColumnListing($_table);
        foreach ($_columns as  $val_col) {
          $columns[] = $asTable.".".$val_col." as ".$asTable."_".$val_col;
        }
         $data = $data->leftJoin($asTable2,$on[0],'=',$on[1]);
       
      }
      
// print_r($conditions);
      if($request->get('order_by')){
          $orderBy = explode(":",$request->get('order_by'));
          $data = $data->orderBy($orderBy[0],$orderBy[1]);
      }
//      print_r($conditions);
        $data = $data->select($columns)
        ->where($conditions)
        ->limit($limit)->get();

        $_data[$table] = $data;
        $_data['count'] = count($data);
        $headers= [
             'Access-Control-Allow-Origin' => '*',
             'Access-Control-Allow-Methods'=> 'POST, GET, OPTIONS, PUT, DELETE',
             'Access-Control-Allow-Headers'=> 'Content-Type, X-Auth-Token, Origin'
        ];
        return response()->json($_data,$status=200, $headers, $options=JSON_PRETTY_PRINT);
    }

    public function insert($table,Request $_request){
         
        $request = json_decode($_request->getContent());
      //  print_r($request);
        $data = [];
        $request = (array)$request;
        
        $arr = [];
        if(!empty($request)){
            if($_request->get("hash") && $_request->get("hash") !== null){
                $hash = explode(",", $_request->get("hash"));
                foreach ($hash as $hash_val){
                    $request[$hash_val] = Hash::make($request[$hash_val]);
                }
            }
            
             if($_request->get("files") && $_request->get("files") !== null){
               $n = explode(",",$_request->get("files"));
               foreach($n as $k=>$v){
                       if($request[$v] != ""){
                           $a = $request[$v];
                           $file_name = $this->upload_file($a);
                           $request[$v] = $file_name;
                       }else{
                           unset($request[$v]);
                       }
                    
              }
            }
            DB::enableQueryLog();
           $insert = DB::table($table)->insertGetId($request);
            $arr['request'] = $request;
           if($insert){
               $arr['output'] = $insert;
           }else{
               $arr['output'] = 'error';
                $arr['sql'] = DB::getQueryLog();
               $arr['request'] = $request;
           }
        }else{
               $arr['output'] = 'error';
         }

       $headers= [
             'Access-Control-Allow-Origin' => '*',
             'Access-Control-Allow-Methods'=> 'POST, GET, OPTIONS, PUT, DELETE',
             'Access-Control-Allow-Headers'=> 'Content-Type, X-Auth-Token, Origin'
        ];
        return response()->json($arr,$status=200, $headers, $options=JSON_PRETTY_PRINT);
    }

    public function update($table,Request $_request){
        $conditions = [];
       
        //print_r($request->input()->all());
        $request = json_decode($_request->getContent());
        
        $data = [];
        if(isset($request->where)){
            $conditions = (array) $request->where;
        }
        
        foreach ($request as $k=>$val){
            if($k == 'where'){
                unset($request->$k);
            }
        }
        
         if($_request->get("files") && $_request->get("files") !== null){
               $n = explode(",",$_request->get("files"));
             
               foreach($n as $k=>$v){
            
                       if($request->$v != "" && $v != null){
                           $a = $request->$v;
                           $file_name = $this->upload_file($a);
                           $request->$v = $file_name;
                       }else{
                           unset($request->$v);
                       }
                    
              }
            }
        
        $request = (array)$request;
        
        $arr = [];
        DB::enableQueryLog();  
        if(!empty($request)){
           $update = DB::table($table)->where($conditions)->update($request);
           if($update){
               $arr['output'] = 'success';
           }else{
               $arr['output'] = 'error';
               $arr['sql'] = DB::getQueryLog();
               $arr['request'] = $request;
           }
        }else{
               $arr['output'] = 'error';
         }

        $headers= [
             'Access-Control-Allow-Origin' => '*',
             'Access-Control-Allow-Methods'=> 'POST, GET, OPTIONS, PUT, DELETE',
             'Access-Control-Allow-Headers'=> 'Content-Type, X-Auth-Token, Origin'
        ];
        return response()->json($arr,$status=200, $headers, $options=JSON_PRETTY_PRINT);
    }


    public function delete($table,Request $_request){
         $conditions = [];
        //print_r($request->input()->all());
        $request = json_decode($_request->getContent());
      //  print_r($request);
        $data = [];

        $request = (array)$request;
        
        $arr = [];
        if(!empty($request)){
           $update = DB::table($table)->where($request)->delete();
           if($update){
               $arr['delete'] = 'success';
           }else{
               // $arr['delete'] = 'error';
           }
        }else{
               $arr['delete'] = 'error';
         }

        $headers= [
             'Access-Control-Allow-Origin' => '*',
             'Access-Control-Allow-Methods'=> 'POST, GET, OPTIONS, PUT, DELETE',
             'Access-Control-Allow-Headers'=> 'Content-Type, X-Auth-Token, Origin'
        ];
        return response()->json($_request,$status=200, $headers, $options=JSON_PRETTY_PRINT);
    }
    
    
    public function login(Request $request){
      $request = json_decode($request->getContent());
      if(!empty($request->mobile) && !empty($request->password)){
            $password = ($request->password);
           if (Auth::attempt(['mobile' => $request->mobile, 'password' => $password])){
                $user = User::where('mobile',$request->mobile)->first();
                $data = ['output'=>true,'user_id'=>$user->id];
            }else{
                $data = [
                    'output'=>false,
                    'message' => 'يجب التأكد من البيانات المدخلة'
                    ];
            }        
      }else{
          $data = [
                    'output'=>false,
                    'message' => 'يجب إدخال اسم المستخدم وكلمة المرور'
                    ];
      }
      $headers= [
                    'Access-Control-Allow-Origin' => '*',
                    'Access-Control-Allow-Methods'=> 'POST, GET, OPTIONS, PUT, DELETE',
                    'Access-Control-Allow-Headers'=> 'Content-Type, X-Auth-Token, Origin'
               ];
       return response()->json($data,$status=200, $headers, JSON_PRETTY_PRINT);
    
    }
    
    public function loginEmail(Request $request){
      $request = json_decode($request->getContent());
      if(!empty($request->email) && !empty($request->password)){
            $password = ($request->password);
           if (Auth::attempt(['email' => $request->email, 'password' => $password])){
                $user = User::where('email',$request->email)->first();
                $data = ['output'=>true,'user_id'=>$user->id];
            }else{
                $data = [
                    'output'=>false,
                    'message' => 'يجب التأكد من البيانات المدخلة'
                    ];
            }        
      }else{
          $data = [
                    'output'=>false,
                    'message' => 'يجب إدخال اسم المستخدم وكلمة المرور'
                    ];
      }
      $headers= [
                    'Access-Control-Allow-Origin' => '*',
                    'Access-Control-Allow-Methods'=> 'POST, GET, OPTIONS, PUT, DELETE',
                    'Access-Control-Allow-Headers'=> 'Content-Type, X-Auth-Token, Origin'
               ];
       return response()->json($data,$status=200, $headers, JSON_PRETTY_PRINT);
    
    }
    
    public function loginOTP(Request $request){
        ini_set("allow_url_fopen", 1);
       $request = json_decode($request->getContent());
   //    $request = json_decode(file_get_contents("php://input"));
   
      if(!empty($request->mobile)){
            $user = User::where('mobile',$request->mobile)->first();
            if(count($user) == 1){
               // echo($user->username);
                $rand_num = rand("1000","9999");
                    $message = " رقم تفعيل الدخول ".$rand_num."";
                     //$msg  = iconv("UTF-8","Windows-1256"  , $message);
                    $msg = urlencode($msg);
                    $number = $user->mobile;
                    $url =  "http://sms.rasaelna.com/gw/?userName=ndj&userPassword=123789456&numbers=$number&userSender=ndj&msg=$msg&By=API";
 $mobile_api = file_get_contents($url);
                   if(file_get_contents($url) == '1001'){
                  // if(1){
                        //$request->session()->put('activation_code', $rand_num);
                          $return_msg = "success";
                                    $data = array(
                                      "activation_code" =>$rand_num ,
                                      'user_id' => $user->id,
                                      'output' => TRUE,
                                      'return_msg' => $return_msg,
                                       'email' => $user->email,
                                        'message' => $message,
                                        'mobile_api' => $mobile_api
                                  );
                            
                          
                        }else{
                            
                           $return_msg = " حدث خطأ فى الارسـال";
                            $data = array(
                                      'output' => False,
                                      'return_msg' => $return_msg,
                                      "activation_code" =>$rand_num ,
                                      'user_id' => $user->id,
                                       'email' => $user->email,
                                        'message' => $message,
                                        'mobile_api' => $mobile_api
                                  );
                         }
                         Mail::send('mail.login', ['data'=>$data], function ($message2)  use ($data){
                                    $subject = $data['message'];
                   //                 $message->from($request->email, $request->name);
                                    $message2->to($data['email'])->subject($subject);
                             });
                             
                             
                              if( count(Mail::failures()) > 0 ) {
                                foreach(Mail::failures as $email_address) {
                                    //echo "$email_address <br />";
                                 }
                             } else {
                                 //$request->session()->put('activation_code', $rand_num);
                                  $return_msg = "success";
                                   $data = array(
                                      "activation_code" =>$rand_num ,
                                      'user_id' => $user->id,
                                      'output' => TRUE,
                                      'return_msg' => $return_msg,
                                       'email' => $user->email,
                                        'message' => $message,
                                       'mobile_api' => $mobile_api
                                  );
                             }


            }else{

                 $return_msg = "رقم الجوال غير مسجل من قبل ";
                  $data = array(
                                      'output' => False,
                                      'return_msg' => $return_msg
                                  );
            }
      }
//      $headers= [
//                    'Access-Control-Allow-Origin' => '*',
//                    'Access-Control-Allow-Methods'=> 'POST, GET, OPTIONS, PUT, DELETE',
//                    'Access-Control-Allow-Headers'=> 'Content-Type, X-Auth-Token, Origin'
//               ];
      return response()->json($data);
    
    }
    
    public function urlJsonToArray($url){
        $json = file_get_contents($url,true);
        $arr = json_decode($json, true);
        return $arr;
    }
    
    
   
    
     public function contact_us(Request $request){
         $request = json_decode($request->getContent());  
      //dd($request);
       if(!empty($request->name) && !empty($request->email)){
           
           Mail::send('mail.contact', ['data'=>$request], function ($message)  use ($request){
                 $subject = "أتصل بنا من ".$request->name;
//                 $message->from($request->email, $request->name);
                 $message->to('support@balsam.com.sa')->subject($subject);
//                 $message->to('badr@fudex.com.sa')->subject($subject);
            });
            
            $data = ['send'=>'success'];
            $headers= [
                'Access-Control-Allow-Origin' => '*',
                'Access-Control-Allow-Methods'=> 'POST, GET, OPTIONS, PUT, DELETE',
                'Access-Control-Allow-Headers'=> 'Content-Type, X-Auth-Token, Origin'
           ];
           return response()->json($data,$status=200, $headers, $options=JSON_PRETTY_PRINT);
       }
    }
    
    public function mail(Request $_request){
        $request = json_decode($_request->getContent());  
      //dd($request);
       if($request->to != "" && $request->msg != ""){
           $to = $request->to;
           $subject = $request->subject;
           $msg = $request->msg;
           
         $this->send_mail2($to,$subject,$msg);
        /* $message = $request->msg;
          Mail::send('mail.template', ['data'=>$request], function ($message)  use ($request){
                 $subject = $request->subject;
//                 $message->from($request->email, $request->name);
                 $message->to($request->to)->subject($subject);
//                 $message->to('badr@fudex.com.sa')->subject($subject);
            });
            */
         $data = ['send'=>'success'];
       }else{
           $data = ['send'=>'fail'];
       }
       

            $headers= [
                'Access-Control-Allow-Origin' => '*',
                'Access-Control-Allow-Methods'=> 'POST, GET, OPTIONS, PUT, DELETE',
                'Access-Control-Allow-Headers'=> 'Content-Type, X-Auth-Token, Origin'
           ];
           return response()->json($data,$status=200, $headers, $options=JSON_PRETTY_PRINT);
    }
    
    
    public function insert_token(Request $request){
         //$request = json_decode($_request->getContent());
        $data = array();
        
        if($request->get('device_token') != '' && $request->get('device_token') != 'null'){
            $device_token = DB::table("device_tokens")->where('token',$request->get('device_token'))->first();
            if(count($device_token) == 0){
                $insert_data = [
                    'token' => $request->get('device_token'),
                    'created_at' => date("Y-m-d H:i:s")
                ];
                $insert = DB::table("device_tokens")->insert($insert_data);
                $data = ['status'=>'done'];
            }else{
                $data = ['status'=>'exist'];
            }
        }else{
            $data = ['status'=>'empty_token'];
        }
        $headers= [
                'Access-Control-Allow-Origin' => '*',
                'Access-Control-Allow-Methods'=> 'POST, GET, OPTIONS, PUT, DELETE',
                'Access-Control-Allow-Headers'=> 'Content-Type, X-Auth-Token, Origin'
           ];
       return response()->json($data,$status=200, $headers, JSON_PRETTY_PRINT);
    }

    
    private function getCurlContent($url, $postdata = false){
        // check if cURL installed or not in your system?
         if (!function_exists('curl_init')){
             return 'Sorry cURL is not installed!';
         }
         $ch = curl_init();
         curl_setopt($ch, CURLOPT_URL, $url);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
         curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
         curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
         if ($postdata)
         {
             curl_setopt($ch, CURLOPT_POST, 1);
             curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
         }
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
         curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 ;Windows NT 6.1; WOW64; AppleWebKit/537.36 ;KHTML, like Gecko; Chrome/39.0.2171.95 Safari/537.36");
         $contents = curl_exec($ch);
         $headers = curl_getinfo($ch);
         curl_close($ch);
         return array($contents, $headers);
     }
     
      private function clean_url($url){
         $search = array(' ','"',"'",'(',')','!','<','>',',','%','=','+','--','&','/');
         $replace_with = array('-','','','','','','','','','','','','-','','-');
         $final_url = str_replace($search, $replace_with, $url);
         $final_url = trim(trim(trim($final_url,"-"),"."));
         return $final_url;

    }
    
    private function getModels(){
       
        $path = app_path() . "";
        $out = [];
        $results = scandir($path);
        foreach ($results as $result) {
            if ($result === '.' or $result === '..') continue;
            $filename = $path . '/' . $result;
            if (is_dir($filename)) {
                //$out = array_merge($out, getModels($filename));
            }else{
                //$out[] = ltrim(substr($filename,0,-4),app_path());
              //  echo $filename."<br >".$path;
                $out[] = ltrim($filename,app_path());
            }
        }

            return $out;
    }
    
    function upload_file($file){
            $data = $file;
         //   echo $data;
            $pos  = strpos($data, ';');
            $mime_type = explode(':', substr($data, 0, $pos))[1];
            
            
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);
            
            $type= strtolower($mime_type);
            $uploadPath = base_path() . '/public/uploads/';
            if($type == 'image/jpg'){
                $ext = "jpg";
               
            }else if($type == 'image/jpeg'){
                $ext = "jpeg";
              
            }else if ($type == 'image/png'){
                $ext = "png";
                
            }else if ($type == 'image/gif'){
                $ext = "gif";
                 
            }else if ($type == 'application/pdf'){
                $ext = "pdf";
                 
            }else if ($type == 'application/msword'){
                $ext = "doc";
                
            }else if ($type == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'){
                $ext = "docx";
                 
            }else{
                
            }
            
            $new_name = date("YmdHis").rand(10000,1000000).".".$ext;
            
            file_put_contents($uploadPath.$new_name, $data);
            return $new_name;
            
            }
    
    public function generateQR($userID) {
          $qrUrl = url('company/'.$userID);
          echo QrCode::size(300)->generate($qrUrl, public_path().'/uploads/qr_code/'.$userID.'.svg');        
    }
     
      /**------------------------- New Distance Quries ------------------*/
    public function allRequests($lat,$lng) {     
        $data = DB::table('requests_orders as req')
                     ->select(DB::raw(' *,req.id as ReqId ,req.created_at as created_date,users.name as username ,'
                             . ' ( 6371 * acos( cos( radians(' . $lat . ') ) * cos( radians( req.lat ) ) * cos( radians( req.lng ) - radians(' . $lng . ') ) + sin( radians(' . $lat . ') ) * sin( radians( req.lat ) ) ) ) AS distance'))
                     ->join("users","req.created_by","=","users.id")  
                     ->join("categories as cat","req.category","=","cat.id")
                     ->orderBy('distance', 'asc')
//                     ->where('users.role','=',$role)                     
                     ->get();
        
        $headers= [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods'=> 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Headers'=> 'Content-Type, X-Auth-Token, Origin'
       ];
       return response()->json($data,$status=200, $headers, JSON_PRETTY_PRINT);
    }
    
    public function requests_by_role($lat,$lng,$role) {     
        $data = DB::table('requests_orders as req')
                     ->select(DB::raw(' *,req.id as ReqId ,req.created_at as created_date,users.name as username ,'
                             . ' ( 6371 * acos( cos( radians(' . $lat . ') ) * cos( radians( req.lat ) ) * cos( radians( req.lng ) - radians(' . $lng . ') ) + sin( radians(' . $lat . ') ) * sin( radians( req.lat ) ) ) ) AS distance'))
                     ->join("users","req.created_by","=","users.id")  
                     ->join("categories as cat","req.category","=","cat.id")
                     ->orderBy('distance', 'asc')
                     ->where('users.role','=',$role)                     
                     ->get();
        
        $headers= [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods'=> 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Headers'=> 'Content-Type, X-Auth-Token, Origin'
       ];
       return response()->json($data,$status=200, $headers, JSON_PRETTY_PRINT);
    }
    
     public function requests_by_category_role($lat,$lng,$role,$category) {     
        $data = DB::table('requests_orders as req')
                     ->select(DB::raw(' *,req.id as ReqId ,req.created_at as created_date,users.name as username ,'
                             . ' ( 6371 * acos( cos( radians(' . $lat . ') ) * cos( radians( req.lat ) ) * cos( radians( req.lng ) - radians(' . $lng . ') ) + sin( radians(' . $lat . ') ) * sin( radians( req.lat ) ) ) ) AS distance'))
                     ->join("users","req.created_by","=","users.id")  
                     ->join("categories as cat","req.category","=","cat.id")
                     ->orderBy('distance', 'asc')
                      ->where('users.role','=',$role)
                     ->where('req.category','=',$category)
                     ->get();
        
        $headers= [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods'=> 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Headers'=> 'Content-Type, X-Auth-Token, Origin'
       ];
       return response()->json($data,$status=200, $headers, JSON_PRETTY_PRINT);
    }
    
      public function requests_by_category($lat,$lng,$category) {     
        $data = DB::table('requests_orders as req')
                     ->select(DB::raw(' *,req.id as ReqId ,req.created_at as created_date,users.name as username ,'
                             . ' ( 6371 * acos( cos( radians(' . $lat . ') ) * cos( radians( req.lat ) ) * cos( radians( req.lng ) - radians(' . $lng . ') ) + sin( radians(' . $lat . ') ) * sin( radians( req.lat ) ) ) ) AS distance'))
                     ->join("users","req.created_by","=","users.id")  
                     ->join("categories as cat","req.category","=","cat.id")
                     ->orderBy('distance', 'asc')
                     ->where('req.category','=',$category)
                     ->get();
        
        $headers= [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods'=> 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Headers'=> 'Content-Type, X-Auth-Token, Origin'
       ];
       return response()->json($data,$status=200, $headers, JSON_PRETTY_PRINT);
    }
    
    
    public function single_request($lat,$lng,$requestID) {     
        $data = DB::table('requests_orders as req')
                     ->select(DB::raw(' *,req.id as ReqId ,req.created_at as created_date,users.name as username ,'
                             . ' ( 6371 * acos( cos( radians(' . $lat . ') ) * cos( radians( req.lat ) ) * cos( radians( req.lng ) - radians(' . $lng . ') ) + sin( radians(' . $lat . ') ) * sin( radians( req.lat ) ) ) ) AS distance'))
                     ->join("users","req.created_by","=","users.id")  
                     ->join("categories as cat","req.category","=","cat.id")
                     ->where('req.id','=',$requestID)                     
                     ->first();
        
        $headers= [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods'=> 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Headers'=> 'Content-Type, X-Auth-Token, Origin'
       ];
       return response()->json($data,$status=200, $headers, JSON_PRETTY_PRINT);
    }
    //------------------- Nearest airport -----------------
    public function nearest_airport($lat,$lng) {     
        $data = DB::table('regions')
                     ->select(DB::raw(' * ,'
                             . ' ( 6371 * acos( cos( radians(' . $lat . ') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(' . $lng . ') ) + sin( radians(' . $lat . ') ) * sin( radians( lat ) ) ) ) AS distance'))                     
                     ->orderBy('distance', 'asc')                    
                     ->first();
        
        $headers= [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods'=> 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Headers'=> 'Content-Type, X-Auth-Token, Origin'
       ];
       return response()->json($data,$status=200, $headers, JSON_PRETTY_PRINT);
    }
    
    public function nearest_offers($lat,$lng) {     
        $data = DB::table('users')
                     ->select(DB::raw(' *,users.id as userID ,users.created_at as created_date,users.name as username,'
                             . ' ( 6371 * acos( cos( radians(' . $lat . ') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(' . $lng . ') ) + sin( radians(' . $lat . ') ) * sin( radians( lat ) ) ) ) AS distance')
                             ,'offers.id as itmId','companies.id as companyID','offers.category as offerCat','categories.name as categoryName',
                             'offers.img as offerImg')
                     ->join("offers","users.id","=","offers.created_by")  
                     ->join("categories","categories.id","=","offers.category")  
                     ->join("companies","companies.user_id","=","offers.created_by")
                     ->orderBy('distance', 'asc')                                                               
                    ->get();
        
        $headers= [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods'=> 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Headers'=> 'Content-Type, X-Auth-Token, Origin'
       ];
       return response()->json($data,$status=200, $headers, JSON_PRETTY_PRINT);
    }
    
    //------------------- Company Location -----------------
    public function company_location($lat,$lng) {     
        $data = DB::table('users')
                     ->select(DB::raw(' * ,'
                             . ' ( 6371 * acos( cos( radians(' . $lat . ') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(' . $lng . ') ) + sin( radians(' . $lat . ') ) * sin( radians( lat ) ) ) ) AS distance'))                     
                     ->where('lat','!=',null) 
                     ->orderBy('distance', 'asc')                    
                     ->first(['users.*','users.distance as distance']);
        
        $headers= [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods'=> 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Headers'=> 'Content-Type, X-Auth-Token, Origin'
       ];
       return response()->json($data,$status=200, $headers, JSON_PRETTY_PRINT);
    }
    
    /**------------------------- End New Distance Quries ------------------*/
     
    public function viewPDF($id) {
        header('Access-Control-Allow-Origin: *'); 
            header("Access-Control-Allow-Credentials: true");
            header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
            header('Access-Control-Max-Age: 1000');
            header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');
            header("Content-type:application/pdf");
        
            $data = DB::table('offers')->where('id','=',$id)->first();            
            if($data->link != null) $file = $data->link;
            else 
            $file =  "http://bsamat.com/demo/900sa/public/uploads/".$data->file;            
            echo file_get_contents($file);       
        //echo file_get_contents("http://bsamat.com/demo/900sa/public/uploads/sea_food.pdf");
    }
    
    public function sendNotification($id,$page,$title,$msg) {
             $postData = [];        
             $device_tokens = DB::table("device_tokens")->get();
             $token_ids = [];
             foreach($device_tokens as $device_token){
                 $token_ids[] = $device_token->token;
             }
             $other_data = array('id' => $id,'page'=>$page);
             $token_ids2 = array_values($token_ids);
             $postData['title'] = $title;
             $postData['message'] = $msg;
             $postData['token_ids'] = json_encode($token_ids2);
             $postData['other_data'] = json_encode($other_data);

             $url = url("resources/fcm/run.php");
             $this->getCurlContent($url, $postData);
    }
    
    
}
