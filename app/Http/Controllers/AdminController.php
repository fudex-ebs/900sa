<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Categories;
use App\About;
use App\Site_settings;
use App\Social_links;
use Auth;
use App\Users_role;
use App\User;
use App\Requests_order;
use QrCode;
use App\Company;
use App\Request_point;
use App\Region;
use App\Code;

use Illuminate\Support\Facades\Input;

class AdminController extends Controller
{
    public function index() {        
       $items = DB::table('menus')->where('active','=',1)->where('link','!=','#')->get();
       return view('admin.dashboard',  compact('items'));
    }
    public function get_code() {
        return view('admin.create_codes');
    }
    public function create_codes(Request $request) {
        //update active
        for($i=101;$i<=999;$i++){
            $item = Code::where('code','=',$i)->first();
            $item->active = 1;
            $item->save();
        }
        
//        for($i=1;$i<=9999;$i++){                    
//            $if_exists = Code::where('code','=',$i)->first();
//             
//            if(count($if_exists) <1){
//                $code = new Code();
//                $code->code = $i;
//                $code->reserved = 0;
//                $code->reserved_by = 0;
//                $code->save();
//            }
//        }
        
    }
    public function generateQrcode($txt="",$fileName="img1") {
         echo QrCode::size(300)->generate($txt, public_path().'/uploads/qr_code/'.$fileName.'.svg');
    }
    public function profile() {
        $item = Auth()->user();
        return view('admin/profile',  compact('item'));
    }
    public function updateProfile(Request $request) {
        $curntPass = Auth()->user()->password;
         $user =  Auth()->user();
             
          $user->update($request->all());
        if(isset($request->password)){
            $user->password = bcrypt($request->password);
            $user->save();
        }else{
            $user->password =$curntPass;
            $user->save();
        }
        return back()->with('success','لقد تم تحديث بياناتك بنجاح');
    }
    public function addUser() {
        $roles = Users_role::where('id','!=','1')->get();
        $categories = Categories::where('active','=','1')->where('parent','=','0')->get();
        $company_type = DB::table('company_type')->get(); 
        return view('admin.users_add',  compact('roles','categories','company_type'));
    }
    
    public function insertUser(Request $request) {        
        $this->validate($request, [
           'name' => 'required|string|max:255',
           'email' => 'required|string|email|max:255|unique:users',
           'password' => 'required|string|min:6',      
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->address = $request->address;
        $user->active = $request->active;
        $user->role = $request->role;
        $user->password = bcrypt($request->password);        
        $user->save();
        
        if($user->role == 3){
            $qrUrl = url('company/'.$user->id);
            $this->generateQrcode($qrUrl,$user->id);
           
            $company = new Company();
            if( $request->hasFile('logo')){                
//                $img_name = date('ishdmY').'.'.$request->file('logo')->getClientOriginalExtension();
                $img_name = $request->file('logo')->getClientOriginalName();
                $request->file('logo')->move(base_path().'/public/uploads/',$img_name);        
                $company->logo = $img_name;           
           }
           if( $request->hasFile('commercial_registration_img')){
//                $comr_name = date('ishdmY').'.'.$request->file('commercial_registration_img')->getClientOriginalExtension();
                $comr_name = $request->file('commercial_registration_img')->getClientOriginalName();
                $request->file('commercial_registration_img')->move(base_path().'/public/uploads/',$comr_name);        
                $company->commercial_registration_img = $comr_name;           
           }
           
            $company->user_id = $user->id;                        
            $company->qr_code = $user->id.'.'.'svg';
            $company->about = $request->about;
            $company->commercial_registration_no = $request->commercial_registration_no;
            $company->commercial_registration_expire_date = $request->commercial_registration_expire_date;
            $company->company_type = $request->company_type;
            
            $cats = $request->category;
            $categories =  implode(',', $cats);
            $company->category = $categories;
                    
            $company->save();
            
             return back()->with('success','لقد تمت الاضافة بنجاح وتفعيل رمز ال QR الخاص بالشركة');
        }else
             return back()->with('success','لقد تمت الاضافة بنجاح ');
        
    }
    public function companies() {        
       $data = DB::table('users as user')                                        
                    ->join('companies as comp','comp.user_id','=','user.id')                    
                    ->get(['user.*','comp.*','user.id as itmID']);
        
        return view('admin.users_companies',  compact('data'));
    }
    public function users_all() {
        $data = User::where('role','=',4)->get();
        return view('admin.users_all',  compact('data'));
    }
    public function users_supervisors() {
        $data = User::where('role','=',2)->get();
        return view('admin.users_supervisors',  compact('data'));
    }
    public function deleteUser(User $item) {
        $item->delete();
        return back()->with('success','لقد تم حذف العضو بنجاح');
    }
    public function editUser(User $item) {
         $roles = Users_role::where('id','!=','1')->get();
         $company = Company::where('user_id','=',$item->id)->first();
         if($company) $company = $company; else $company = NULL;
         
         $categories = Categories::where('active','=','1')->where('parent','=','0')->get();
         $company_type = DB::table('company_type')->get(); 
        
         return view('admin.user_edit',  compact('item','roles','company','categories','company_type'));
    }
    public function updateUser(Request $request,User $item) {
        $curntPass = $item->password;
        $item->update($request->all());
         if($item->role == 3){
             $qrUrl = url('company/'.$item->id);
             $this->generateQrcode($qrUrl,$item->id);           
             
             $company = DB::table('companies')->where('user_id','=',$item->id)->first();             
             if($company){                               
                    $updateItem = Company::find($company->id);
               
                     if( $request->hasFile('logo')){                
                            $img_name = $request->file('logo')->getClientOriginalName();
                            $request->file('logo')->move(base_path().'/public/uploads/',$img_name);        
                            $updateItem->logo = $img_name;           
                       }
                    if( $request->hasFile('commercial_registration_img')){
                         $comr_name = $request->file('commercial_registration_img')->getClientOriginalName();
                         $request->file('commercial_registration_img')->move(base_path().'/public/uploads/',$comr_name);        
                         $updateItem->commercial_registration_img = $comr_name;           
                    }                     
                    $updateItem->qr_code = $item->id.'.'.'svg';
                    $updateItem->about = $request->about;
                    $updateItem->commercial_registration_no = $request->commercial_registration_no;
                    $updateItem->commercial_registration_expire_date = $request->commercial_registration_expire_date;
                    $updateItem->company_type = $request->company_type;
                    
                    $cats = $request->category;
                    $categories =  implode(',', $cats);
                    $updateItem->category = $categories;
                                      
                    $updateItem->save();
             }else{
                 $newCompany = new Company();
                 $newCompany->user_id = $item->id;
                 $newCompany->qr_code = $item->id.'.'.'svg';
                 $newCompany->save();
             }
         }
        if(isset($request->password)){
            $item->password = bcrypt($request->password);
            $item->save();
        }else{
            $item->password =$curntPass;
            $item->save();
        }
        return back()->with('success','لقد تم تحديث بيانات العضو بنجاح');
           
    }
     public function manageUsers(Request $request) {
        $action = Input::get('action','none');
        if($action == 'delete'){
            $flag = 0;
            $ids = $request->chkMe;
            if($ids){
                foreach ($ids as $value) {
                     $row = User::find($value);
                     $row->delete();
                     $flag += 1;
            }}
            if($flag > 0) return back ()->with ('success','لقد تم الحذف بنجاح');
        }else{
            return back();
        }
    }
    public function about() {
       $item = About::where('id','=',1)->first();
       return view('admin.about_edit',  compact('item'));
    }
    public function updateAbout(Request $request,  About $item) {
        $item->update($request->all());                
        if( $request->hasFile('img')){
//                unlink(public_path('uploads/'.$item->img));
                $img_name = date('ishdmY').'.'.$request->file('img')->getClientOriginalExtension();
                $request->file('img')->move(base_path().'/public/uploads/',$img_name);        
                $item->img = $img_name;
                $item->save();
           }
        return back()->with('success','لقد تم التحديث بنجاح');  
    }
    public function categories() {
        $parents = Categories::where('parent','=','0')->get();
        $data = DB::table('categories')->get();
        return view('admin.categories',  compact('parents','data'));
    }
    public function addCategory(Request $request) {
        $this->validate($request, [
           'name' => 'required|max:255',           
        ]);
        $fileName = "";
        if( $request->hasFile('img')){
            $fileName = date('ishdmY').'.'.$request->file('img')->getClientOriginalExtension();
            $request->file('img')->move(base_path().'/public/uploads/',$fileName);                    
       }
        $category = new Categories();
        $category->name = $request->name;
        $category->parent = $request->parent;
        $category->img = $fileName;
        $category->sort = $request->sort;
        $category->active = $request->active;
        $category->color = $request->color;
        $category->code = $request->code;
        
        $category->save();
        return back()->with('success','لقد تمت الاضافة بنجاح');        
    }
    public function deleteCategory(Categories $id) {
        $id->delete();
        return back()->with('success','تم الحذف بنجاح');
    }
    public function editCategory(Categories $item) {
        $parents = DB::table('categories')->where('parent','=',0)->get();
        return view('admin.category_edit',  compact('item','parents'));
    }
     public function updateCategory(Request $request,  Categories $item) {
        $item->update($request->all());
        if( $request->hasFile('img')){
//                unlink(public_path('uploads/'.$item->img));
                $img_name = date('ishdmY').'.'.$request->file('img')->getClientOriginalExtension();
                $request->file('img')->move(base_path().'/public/uploads/',$img_name);        
                $item->img = $img_name;
                $item->save();
           }
        return redirect('admin/categories');
    }
    public function manageCategories(Request $request) {
        $action = Input::get('action','none');
        if($action == 'delete'){
            $flag = 0;
            $ids = $request->chkMe;
            if($ids){
                foreach ($ids as $value) {
                     $row = Categories::find($value);
                     $row->delete();
                     $flag += 1;
            }}
            if($flag > 0) return back ()->with ('success','لقد تم الحذف بنجاح');
        }else{
            return back();
        }
    }
     public function site_settings() {
       $data = Site_settings::get();
       return view('admin.site_settings',  compact('data'));
    }
    public function addSetting(Request $request) {
        $item = new Site_settings();
        $item->title = $request->title;
        $item->value = $request->value;
        $item->save();
        return back()->with('success','لقد تمت الاضافة بنجاح');
    }
    public function editSetting(Site_settings $item) {        
        return view('admin.site_setting_edit',  compact('item'));
    }
    public function updateSetting(Request $request,  Site_settings $item) {
        $item->update($request->all());
        return redirect('admin/site_settings');
    }
     public function deleteSetting(Site_settings $item) {
        $item->delete();
        return back()->with('success','تم الحذف بنجاح');
    }
     public function manageSettings(Request $request) {
        $action = Input::get('action','none');
        if($action == 'delete'){
            $flag = 0;
            $ids = $request->chkMe;
            if($ids){
                foreach ($ids as $value) {
                     $row = Site_settings::find($value);
                     $row->delete();
                     $flag += 1;
            }}
            if($flag > 0) return back ()->with ('success','لقد تم الحذف بنجاح');
        }else{
            return back();
        }
    }
     public function social_links() {
       $data = Social_links::get();
       return view('admin.social_links',  compact('data'));
    }
    public function addSocialLink(Request $request) {
        $item = new Social_links();
        $item->title = $request->title;
        $item->value = $request->value;
        $item->active = $request->active;
        $item->sort = $request->sort;
        
        $item->save();
        return back()->with('success','لقد تمت الاضافة بنجاح');
    }
    
    public function deleteSocial(Social_links $item) {
        $item->delete();
        return back()->with('success','تم الحذف بنجاح');
    }
     public function manageSocial(Request $request) {
        $action = Input::get('action','none');
        if($action == 'delete'){
            $flag = 0;
            $ids = $request->chkMe;
            if($ids){
                foreach ($ids as $value) {
                     $row = Site_settings::find($value);
                     $row->delete();
                     $flag += 1;
            }}
            if($flag > 0) return back ()->with ('success','لقد تم الحذف بنجاح');
        }else{
            return back();
        }
    }
    
    public function editSocial(Social_links $item) {        
        return view('admin.social_link_edit',  compact('item'));
    }
    public function updateSocial(Request $request, Social_links $item) {
        $item->update($request->all());
        return redirect('admin/social_links');
    }
    public function request_add() {
        $categories = Categories::where('active','=','1')->where('parent','=','0')->get(); 
        return view('admin.request_add',  compact('categories'));
    }
    public function insertRequest(Request $request) {
        $myRequest = new Requests_order(); 
        
        $this->validate($request, [
           'title' => 'required|max:255',
           'description' => 'required|min:5',  
           'category' => 'required|not_in:0'
        ]);
        
        $fileName = "";
        if( $request->hasFile('file')){
            $fileName = date('ishdmY').'.'.$request->file('file')->getClientOriginalExtension();
            $request->file('file')->move(base_path().'/public/uploads/',$fileName);                    
       }
        $myRequest->title = $request->title;
        $myRequest->category = $request->category;
        $myRequest->sub_category = $request->sub_category;        
        $myRequest->description  = $request->description;
        $myRequest->created_by = Auth()->user()->id;
        $myRequest->file = $fileName;
        
        $myRequest->save();
        
         //------------- Send notification --------------------
         $this->sendNotification($request->id,'request','طلب جديد من 900',$request->title);
        
        return back()->with('success','لقد تمت الاضافة بنجاح');
    }

    public function requests_all() {        
       $data = DB::table('requests_orders as req')                                        
                    ->join('categories as cat','cat.id','=','req.category')
                    ->join('users as user','user.id','=','req.created_by')                    
//                    ->join('categories as sub_cat','sub_cat.id','=','req.sub_category')
                    ->get(['req.*','cat.*','user.name as userName','req.id as reqID']);
        return view('admin.requests_all',  compact('data'));
    }
    public function editRequest(Requests_order $item) {
        $categories = Categories::where('active','=','1')->where('parent','=','0')->get(); 
        return view('admin.request_edit',  compact('item','categories'));
    }
    public function updateRequest(Request $request,  Requests_order $item) {
          $item->update($request->all());                
        if( $request->hasFile('file')){
//                unlink(public_path('uploads/'.$item->img));
                $img_name = date('ishdmY').'.'.$request->file('file')->getClientOriginalExtension();
                $request->file('file')->move(base_path().'/public/uploads/',$img_name);        
                $item->file = $img_name;
                $item->save();
           }
        return back()->with('success','لقد تم التحديث بنجاح');  
    }
    public function deleteRequest(Requests_order $item) {
        
        $item->delete();
        return back()->with('success','تم الحذف بنجاح');
    }
    public function manageRequests(Request $request) {
        $action = Input::get('action','none');
        if($action == 'delete'){
            $flag = 0;
            $ids = $request->chkMe;
            if($ids){
                foreach ($ids as $value) {
                     $row = Requests_order::find($value);
                     $row->delete();
                     $flag += 1;
            }}
            if($flag > 0) return back()->with ('success','لقد تم الحذف بنجاح');
        }else{
            return back();
        }
    }
    public function getSubCategories(Request $request) {
        $category = $request->input('category'); 
        
        if($category){
            $subCategories = Categories::where('parent','=',$category)->get();
            if($subCategories){
                echo "<option value='0'>-- اختر قسم فرعى</option>";
                foreach ($subCategories as $value) {
                    echo "<option value='".$value->id."'>".$value->name."</option>";
            }}
            
        }
    }

    public function points() {
        $status = DB::table('requests_status')->where('active','=','1')->get();
            $data = DB::table('request_points as rp')                                        
                    ->join('users','rp.user_id','=','users.id')                    
                    ->join('requests_status as rs','rs.id','=','rp.status')                    
                    ->get(['users.*','rs.*','rp.*','rp.id as itmID']);

        return view('admin/points',  compact('data','status'));
    }
    
    public function managePoints(Request $request) {
        $action = Input::get('action','none');
        if($action == 'delete'){
            $flag = 0;
            $ids = $request->chkMe;
            if($ids){
                foreach ($ids as $value) {
                     $row = Request_point::find($value);
                     $row->delete();
                     $flag += 1;
            }}
            if($flag > 0) return back()->with ('success','لقد تم الحذف بنجاح');
        }else if($action == 'changeStatus'){
            $status = $request->status;
            $flag = 0;
            $ids = $request->chkMe;
            if($ids){
                foreach ($ids as $value) {
                     $row = Request_point::find($value);
                     $row->status = $status;
                     $row->save();
                     
                     if($status == 3){
                         //------ Update company points ------
                         $company = DB::table('companies')->where('user_id','=',$row->user_id)->first();                         
                         $new_points = $company->points + $row->points;                         
                         Company::where('user_id', $row->user_id)->update(array('points' => $new_points));
                     }
                     $flag += 1;
            }}
            if($flag > 0) return back()->with ('success','لقد تم تغير حالة الطلبات  بنجاح');
            
            
        }
        else{
            return back();
        }
    }
    public function deleteRequestPoint(Request_point $item) {
        $item->delete();
        return back()->with('success','لقد تم حذف العضو بنجاح');
    }
    
    public function regions() {
        $airport_types = DB::table('ariport_types')->where('active','=','1')->get();
        $countries = DB::table('countries')->where('active','=','1')->get();
        $data = DB::table('regions')->get();
        return view('admin.regions',  compact('data','airport_types','countries'));
    }
    public function addRegion(Request $request) {
         $this->validate($request, [
           'code' => 'required|max:255',            
        ]);
         
        $region = new Region();
        $region->country = $request->country;
        $region->airport_type = $request->airport_type;
        $region->code = $request->code;
        $region->name = $request->name;
        $region->position = $request->position;
        $region->lat = $request->lat;
        $region->lng = $request->lng;
        $region->sort = $request->sort;
        $region->active = $request->active;
        $region->save();
        return back()->with('success','تمت اضافة منطقه جغرافية بنجاح');
    }
    
    public function manageRegions(Request $request) {
        $action = Input::get('action','none');
        if($action == 'delete'){
            $flag = 0;
            $ids = $request->chkMe;
            if($ids){
                foreach ($ids as $value) {
                     $row = Region::find($value);
                     $row->delete();
                     $flag += 1;
            }}
            if($flag > 0) return back ()->with ('success','لقد تم الحذف بنجاح');
        }else{
            return back();
        }
    }
    
    public function editRegion(Region $item) {
        $airport_types = DB::table('ariport_types')->where('active','=','1')->get();
        $countries = DB::table('countries')->where('active','=','1')->get();
        return view('admin.region_edit',  compact('item','airport_types','countries'));
    }
    public function updateRegion(Region $item,Request $request) {
        $item->update($request->all());
        return redirect('admin/regions');
    }

    public function makeSpecial(Request $request) {
        $itmId = $request->input('itmId'); 
        $item = Company::find($itmId);
        if($item->special == 0) $special = 1;
        else $special = 0;
        
        $item->special = $special;
        $item->save();                
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
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$postdata);
        }
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 ;Windows NT 6.1; WOW64; AppleWebKit/537.36 ;KHTML, like Gecko; Chrome/39.0.2171.95 Safari/537.36");
        $contents = curl_exec($ch);
        $headers = curl_getinfo($ch);
        curl_close($ch);
        return array($contents, $headers);         
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
    
    public function get_distance() {
        $lat = "31.1752206";
        $lng = "2.213749";
        $query = DB::select('SELECT *, ( 6371 * acos( cos( radians(' . $lat . ') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(' . $lng . ') ) + sin( radians(' . $lat . ') ) * sin( radians( lat ) ) ) ) AS distance FROM users ');
        return $query;
    }
}
