var domain = "http://fudexsb.com/demo/balsam/";
var imgPath = domain+"/public/uploads/";

//var domain = "http://localhost:8000/";
//var imgPath = domain+"uploads/";=

var app = angular.module("myApp", ["ngRoute"]);
app.run(function ($rootScope,$http){
    
    $rootScope.imgPath = imgPath;       
    $rootScope.userID = window.localStorage.getItem("USER_ID");  
    
    var url2 =  domain+"api/carts?user_id="+$rootScope.userID+"&bought=0";     
    $http.get(url2).success(function(response) {         
       $rootScope.cartCount = parseInt(response.carts.length);
    });
        
    $rootScope.addToCart=function(id){          
        var user_id = window.localStorage.getItem("USER_ID");        
        if(user_id == null) user_id = 0; else user_id = user_id;
                
        var ip = "";
        var json = 'http://ipv4.myexternalip.com/json';
         $http.get(json).then(function(result) {
           ip = result.data.ip;
        });
    
      var data = {
            user_id: user_id,
            user_ip : ip,
            qty : 1,
            product_id : id
     };    
      $http({
            method: 'POST',
            url: domain+'api/insert/carts',
            data: data,
            dataType: 'jsonp',
            jsonp: 'jsoncallback',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
    }).success(function(data) {        
        $.growl.notice({ title: "تم ", message: "لقد تمت الاضافة للسلة بنجاح" });     
        $("#newItms").removeClass('hidden');
        var url =  domain+"api/products?id="+id;     
        $http.get(url).success(function(response) {         
           $rootScope.newItm = response.products[0];             
        });                
        $rootScope.cartCount = parseInt($rootScope.cartCount)+1;
        
    });              
    };
    
    
    $rootScope.addToFav=function(id){          
        var user_id = window.localStorage.getItem("USER_ID");        
        if(user_id == null) user_id = 0; else user_id = user_id;
                
        var ip = "";
        var json = 'http://ipv4.myexternalip.com/json';
         $http.get(json).then(function(result) {
           ip = result.data.ip;
        });
    
      var data = {
            user_id: user_id,
            user_ip : ip,            
            product_id : id
     };    
      $http({
            method: 'POST',
            url: domain+'api/insert/favourites',
            data: data,
            dataType: 'jsonp',
            jsonp: 'jsoncallback',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
    }).success(function(data) {        
        $.growl.notice({ title: "تم ", message: "لقد تمت الاضافة للمفضلة  بنجاح" });            
        
    });              
    };
    
    
    $rootScope.deleteFromCart = function(id,index){      
        var data = {
            id:id,                
        };
        $http({
            method: 'POST',
            url: domain+ 'api/delete/carts',
            data: data,
            dataType: 'jsonp',
            jsonp: 'jsoncallback',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).success(function(data) {
            if(data.delete == 'success'){                   
                    $rootScope.cartsItems.splice(index,1);
//                   $rootScope.count_al = 0;
//                    $http.get(domain+ 'api/getCart?user_id='+$rootScope.userID).success(function(response) {
//                            $rootScope.count_all = 0;
//                            angular.forEach(response.cart, function(value, key){
//                                           $rootScope.count_all += parseInt(response.cart[key].quantity);
//                            });
//                            $rootScope.cart = response.cart;
//                            $rootScope.price_all = response.price_all;
//                            $rootScope.price_all_number = response.price_all2;
//                            if(response.count_all == '0'){
//                                    $rootScope.noItems = true;
//                            }else{
//                                    $rootScope.noItems = false;
//                            }
//                   });
            }else{

            }

        });
    };
    
});

/** ********************** Push Notification ***********/
document.addEventListener("deviceready", onDeviceReady, false);

function onDeviceReady() {

setTimeout(function(){

//****************** notifications ******************
FCMPlugin.getToken(function(token){
window.localStorage.setItem("_token", token);

// alert(token);
//document.getElementById("_token").value = token;
// alert(token);
//document.getElementById("_token").innerHTML = JSON.stringify(token);
FCMPlugin.onNotification(
function(data){
if(data.wasTapped){
//Notification was received on device tray and tapped by the user.
// alert(JSON.stringify(data));

if(data.page == 'article'){
    window.location.href = "#/article/"+data.id;
}else if(data.page == 'product'){
window.location.href = "#/product/"+data.id;
}else if(data.page == 'offer'){
window.location.href = "#/product/"+data.id;
}else if(data.page == 'notify'){
window.location.href = "#/notify/"+data.id;
}
// document.getElementById("pre_data").innerHTML = JSON.stringify(data);
}else{
//Notification was received in foreground. Maybe the user needs to be notified.
// alert( JSON.stringify(data) );
// document.getElementById("data22").innerHTML = JSON.stringify(data);
}
},
function(msg){
//console.log('onNotification callback successfully registered: ' + msg);
//alert('onNotification callback successfully registered: ' + msg);
},
function(err){
console.log('Error registering onNotification callback: ' + err);
//alert('onNotification callback successfully registered: ' + err);
}
);
},
function(err){
console.log('error retrieving token: ' + err);
}
);

//********************************************//
},4000);

 
}



    app.config(function($routeProvider) {
        $routeProvider
        .when("/", {
            templateUrl : "new.html"
        })         
        .when("/#", {
            templateUrl : "new.html"
        }) 
        .when("/home", {
            templateUrl : "category.html"
        })       
        .when("/login", {
            templateUrl : "login.html"
        })
        .when("/forget", {
            templateUrl : "forget.html"
        })
        .when("/about" ,{
            templateUrl:"about.html" 
        })
        .when("/address" ,{
            templateUrl:"address.html" 
        })
        .when("/purchases" ,{
            templateUrl:"purchases.html" 
        })
        .when("/following" ,{
            templateUrl:"following.html" 
        })        
        .when("/profile" ,{
            templateUrl:"profile.html" 
        })
        .when("/update_profile" ,{
            templateUrl:"update_profile.html" 
        })
        .when("/cart" ,{
            templateUrl:"cart.html" 
        })
        .when("/fav" ,{
            templateUrl:"fav.html" 
        })
        .when("/success" ,{
            templateUrl:"success.html" 
        })        
        .when("/shipping" ,{
            templateUrl:"shipping.html" 
        })
        .when("/follow/:id" ,{
            templateUrl:"follow.html" 
        })        
        .when("/contact" ,{
            templateUrl:"contact.html" 
        })
        .when("/search" ,{
            templateUrl:"search.html" 
        })
        .when("/articles" ,{
            templateUrl:"articles.html" 
        }) 
        .when("/article/:id",{
            templateUrl:"article.html"
        })
        .when("/new" ,{
            templateUrl:"new.html" 
        })
        .when("/most_ordered" ,{
            templateUrl:"most_ordered.html" 
        })
        .when("/offers" ,{
            templateUrl:"offers.html" 
        })
        .when("/product/:id",{
            templateUrl:"product.html"
        })
        .when("/notify/:id",{
            templateUrl:"notify.html"
        })        
        .when("/sub_category/:id",{
            templateUrl:"sub_category.html"
        })        
        .when("/products/:id",{
            templateUrl:"products.html"
        })
        .when("/logout", {
            templateUrl : "logout.html"
        })
        ;

});
app.controller('homeCtrl', function($scope,$http) {  
     $("#loadDv").removeClass('hidden');
    var url =  domain+"api/categories?active=1&parent='0'";     
    $http.get(url).success(function(response) { 
         $("#loadDv").addClass('hidden');
       $scope.rows = response.categories;       
    });
});
app.controller('sub_categoryCtrl', function($scope,$http,$routeParams) {   
     $("#loadDv").removeClass('hidden');
    var id = $routeParams.id; 
    var url =  domain+"api/categories?active=1&sub_parent=0&parent="+id;     
    $http.get(url).success(function(response) {          
       $scope.rows = response.categories; 
        $("#loadDv").addClass('hidden');
    });
});
app.controller('productsCtrl', function($scope,$http,$routeParams) {  
     $("#loadDv").removeClass('hidden');
    var id = $routeParams.id; 
    var url =  domain+"api/products?sub_category2="+id+"&order_by=id:DESC";     
    $http.get(url).success(function(response) {           
         $("#loadDv").addClass('hidden');
       $scope.rows = response.products;       
    });    
});
app.controller('newCtrl', function($scope,$http) {  
    $("#loadDv").removeClass('hidden');
    setTimeout(function(){
        var _token = window.localStorage.getItem("_token");
        $http.get(domain+'api/insert_token?device_token='+_token).success(function(response) {
        //console.log(response);
        // document.getElementById("pre_data").innerHTML = JSON.stringify(response);
        });
    },5000);

    var url =  domain+"api/products?active=1&order_by=id:DESC&limit=100";     
    $http.get(url).success(function(response) {           
        $("#loadDv").addClass('hidden');
       $scope.rows = response.products;       
    });
});
app.controller('offersCtrl', function($scope,$http) {
     $("#loadDv").removeClass('hidden');
    var url =  domain+"api/products?offer!=0&order_by=id:DESC";     
    $http.get(url).success(function(response) {         
         $("#loadDv").addClass('hidden');
       $scope.rows = response.products;   
       $scope.imgPath = imgPath;       
    });
});
app.controller('articlesCtrl', function($scope,$http) {   
     $("#loadDv").removeClass('hidden');
    var url =  domain+"api/articles?publish=0&order_by=id:DESC";     
    $http.get(url).success(function(response) {         
         $("#loadDv").addClass('hidden');
       $scope.items = response.articles;          
    });
});
app.controller('mostOrderdCtrl', function($scope,$http) {   
     $("#loadDv").removeClass('hidden');
    var url =  domain+"api/join/carts?leftJoin=products,products.id:carts.product_id&order_by=carts.id:DESC&limit=100";     
    $http.get(url).success(function(response) {       
         $("#loadDv").addClass('hidden');
       $scope.rows = response.carts; 
       $scope.imgPath = imgPath;
    });
});
app.controller('cartCtrl', function($scope,$http,$rootScope) {   
     $("#loadDv").removeClass('hidden');
    var user_id = window.localStorage.getItem("USER_ID");          
    var url =  domain+'api/join/carts?leftJoin=products,products.id:carts.product_id&&carts_bought="0"&carts_user_id='+user_id+'&order_by=carts.id:DESC';    
    $http.get(url).success(function(response) {           
         $("#loadDv").addClass('hidden');
//       $scope.items = response.carts;     
       $rootScope.cartsItems = response.carts;     
    });   
    
    $scope.getTotal = function(){
        var total = 0;
        for(var i = 0; i < $scope.cartsItems.length; i++){
            var product = $scope.cartsItems[i];
            total += (product.products_price * product.carts_qty);              
        }                
        window.localStorage.setItem('total', total);            
        return total;
    }
});

app.controller('favCtrl', function($scope,$http,$rootScope) {   
    $("#loadDv").removeClass('hidden');
    var user_id = window.localStorage.getItem("USER_ID");          
    var url =  domain+'api/join/favourites?leftJoin=products,products.id:favourites.product_id&favourites_user_id='+user_id+'&order_by=favourites.id:DESC';    
    $http.get(url).success(function(response) {           
         $("#loadDv").addClass('hidden');
//       $scope.items = response.carts;     
       $rootScope.items = response.favourites;     
    });   
        
    $rootScope.deleteFromFav = function(id,index){      
        var data = {
            id:id,                
        };
        $http({
            method: 'POST',
            url: domain+ 'api/delete/favourites',
            data: data,
            dataType: 'jsonp',
            jsonp: 'jsoncallback',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).success(function(data) {
            if(data.delete == 'success'){    
                    $scope.items.splice(index,1);
                    $.growl.notice({ title: "تم ", message: "تم الحذف بنجاح" });             
            }else{

            }
        });
    };
     
});


app.controller('addressCtrl', function($scope,$http,$rootScope,$route) {   
     $("#loadDv").removeClass('hidden');
    var user_id = window.localStorage.getItem("USER_ID");          
    var url =  domain+"api/join/addresses?leftJoin=cities,cities.id:addresses.city&addresses_user_id="+user_id;     
    $http.get(url).success(function(response) {           
         $("#loadDv").addClass('hidden');
       $scope.items = response.addresses;       
    }); 
    
    var url2 =  domain+"api/countries?active=1";     
    $http.get(url2).success(function(response) {           
       $scope.countries = response.countries;       
    });
    
    var url3 =  domain+"api/cities?active=1";     
    $http.get(url3).success(function(response) {           
       $scope.cities = response.cities;       
    });
    
    $scope.addAddress=function(){            
    if($scope.country != 0 && $scope.city != 0 && $scope.postal != undefined){
      var data = {
            country: $scope.country,
            city: $scope.city,
            postal: $scope.postal,
            street: $scope.street,    
            user_id: $rootScope.userID
     };    
      $http({
            method: 'POST',
            url: domain+'api/insert/addresses',
            data: data,
            dataType: 'jsonp',
            jsonp: 'jsoncallback',
            headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
            }
    }).success(function(data) {        
        $.growl.notice({ title: "تم ", message: "لقد تم اضافة عنوان شحن بنجاح" });
        $route.reload();
    });              
      }else{
          $.growl.warning({ title: "تنبيه ", message: "من فضلك أدخل بياناتك أولا!" });
      }
    }
    
    
    $scope.deleteAddress = function(id,index){      
        var data = {
            id:id,                
        };
        $http({
            method: 'POST',
            url: domain+ 'api/delete/addresses',
            data: data,
            dataType: 'jsonp',
            jsonp: 'jsoncallback',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).success(function(data) {
            if(data.delete == 'success'){                   
                    $.growl.notice({ title: "تم ", message: "لقد تم الحذف بنجاح" });
                    $scope.items.splice(index,1);
            }
        });
    };
    
    
});
app.controller('purchasesCtrl', function($scope,$http) {   
     $("#loadDv").removeClass('hidden');
    var user_id = window.localStorage.getItem("USER_ID");          
    var url =  domain+"api/orders?user_id="+user_id+"&status=5&order_by=id:desc";     
    $http.get(url).success(function(response) {           
         $("#loadDv").addClass('hidden');
       $scope.items = response.orders;       
    });  
    
    $scope.deleteOrder = function(id,index){      
        var data = {
            id:id,                
        };
        $http({
            method: 'POST',
            url: domain+ 'api/delete/orders',
            data: data,
            dataType: 'jsonp',
            jsonp: 'jsoncallback',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).success(function(data) {
            if(data.delete == 'success'){                   
                    $.growl.notice({ title: "تم ", message: "لقد تم الحذف بنجاح" });
                    $scope.items.splice(index,1);
            }
        });
    };
    
});
app.controller('followingCtrl', function($scope,$http) {   
     $("#loadDv").removeClass('hidden');
    var user_id = window.localStorage.getItem("USER_ID");          
    var url =  domain+"api/orders?user_id="+user_id+"&status!=5&order_by=id:desc";     
    $http.get(url).success(function(response) {           
         $("#loadDv").addClass('hidden');
       $scope.items = response.orders;       
    });  
    
    $scope.deleteOrder = function(id,index){      
        var data = {
            id:id,                
        };
        $http({
            method: 'POST',
            url: domain+ 'api/delete/orders',
            data: data,
            dataType: 'jsonp',
            jsonp: 'jsoncallback',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).success(function(data) {
            if(data.delete == 'success'){                   
                    $.growl.notice({ title: "تم ", message: "لقد تم الحذف بنجاح" });
                    $scope.items.splice(index,1);
            }
        });
    };
    
});

app.controller('shippingCtrl', function($scope,$http) {   
     $("#loadDv").removeClass('hidden');
    var user_id = window.localStorage.getItem("USER_ID");          
    var url =  domain+"api/join/addresses?leftJoin=cities,cities.id:addresses.city&addresses_user_id="+user_id;     
    $http.get(url).success(function(response) {           
         $("#loadDv").addClass('hidden');
       $scope.items = response.addresses;       
    });   
    
    $scope.makeOrder=function(){                
      var address = $scope.address;      
      if(address != 0){
        var total = window.localStorage.getItem("total");          
        var data = {
              address:address,
              user_id :user_id,
              total: total,
       };    
        $http({
              method: 'POST',
              url: domain+'api/insert/orders',
              data: data,
              dataType: 'jsonp',
              jsonp: 'jsoncallback',
              headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
              }
      }).success(function(data) {  
           
//          console.log('In');
           $.growl.notice({ title: "تم ", message: "لقد تم ارسال طلبك  بنجاح" });
            window.location.href = "#/success";
      });              
      }
    }
    
});

app.controller('successCtrl', function($scope,$http,$route,$rootScope) {     
     $("#loadDv").removeClass('hidden');
    //------ Get last order id -------    
      var url2 =  domain+"api/orders?order_by=id:desc";          
      $http.get(url2).success(function(response) {                 
           $("#loadDv").addClass('hidden');
          order_id = response.orders[0].id; 
          $scope.order_no = order_id;
          $rootScope.order_no = order_id;
          
          window.localStorage.setItem('orderID', order_id);            
      });
 
    var oID = parseInt(window.localStorage.getItem("orderID"))+1;
          
     var url =  domain+'api/carts?user_id='+$rootScope.userID+'&bought="0"&order_by=id:DESC';        
     $http.get(url).success(function(response) {                         
          $scope.items = response.carts;  
          angular.forEach(response.carts, function(value, key) {
//   console.log(response.carts[key].id);

               var data = {            
                bought: 1,    
                order_id:oID   
               };    
              data.where = {
                id : response.carts[key].id,
              };
           $http({
                 method: 'POST',
                 url: domain+'api/update/carts',
                data: data,
                 dataType: 'jsonp',
                 jsonp: 'jsoncallback',
                 headers: {
                         'Content-Type': 'application/x-www-form-urlencoded'
                }
         }).success(function(result) {        
console.log(result);
         });
         
         });
   
   });
   
});

app.controller('followCtr', function($scope,$http,$routeParams) {   
     $("#loadDv").removeClass('hidden');
    var id = $routeParams.id; 
    var url =  domain+"api/orders?id="+id;        
    $http.get(url).success(function(response) {        
         $("#loadDv").addClass('hidden');
       $scope.item = response.orders[0];         
  });
});

app.controller('searchCtrl', function($scope,$http,$routeParams) {       
     $scope.search=function(){  
          $("#loadDv").removeClass('hidden');
        var searchTxt = $scope.searchTxt;
        
        var url =  domain+"api/products?title=LIKE:="+searchTxt+"&active=1&order_by=id:DESC&limit=100";        
        $http.get(url).success(function(response) {        
             $("#loadDv").addClass('hidden');
             $scope.items = response.products;             
        });     
               
    }
});


app.controller('aboutCtrl', function($scope,$http) {   
     $("#loadDv").removeClass('hidden');
    var url =  domain+"api/abouts?id=1";        
    $http.get(url).success(function(response) {        
         $("#loadDv").addClass('hidden');
       $scope.row = response.abouts[0];  
       $scope.url = imgPath;
  });
});

app.controller('updateProfileCtrl',function ($scope,$http,$route,$rootScope){  
    var ifLoged = window.localStorage.getItem("USER_ID");          
     if(ifLoged == null) window.location.href = "#/login";
     
    var url =  domain+"api/users?id="+$rootScope.userID;        
    $http.get(url).success(function(response) {                        
       $scope.item = response.users[0];         
       $scope.first_name = response.users[0].first_name;
       $scope.last_name = response.users[0].last_name;
       $scope.email = response.users[0].email;
       $scope.mobile = response.users[0].mobile;
       $scope.birth_date = response.users[0].birth_date;
       $scope.gender = response.users[0].gender;
    });
  
  $scope.updateData=function(){      
      var data = {            
            first_name: $scope.first_name,
            last_name: $scope.last_name,
            email: $scope.email,
            mobile: $scope.mobile,
            gender: $scope.gender,
            birth_date: $scope.birth_date, 
//            password: bcrypt($scope.password)
     };    
    data.where = {
            id : $rootScope.userID,
    };     
      $http({
            method: 'POST',
            url: domain+'api/update/users',
            data: data,
            dataType: 'jsonp',
            jsonp: 'jsoncallback',
            headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
            }
    }).success(function(data) {        
        $.growl.notice({ title: "تم ", message: "لقد تم تعديل بياناتك بنجاح" });
        $route.reload();
    });              
    }
    
});
app.controller('contactCtr',function ($scope,$http,$route){
    var url =  domain+"api/site_settings?keyword=contact_text";        
    $http.get(url).success(function(response) {                        
       $scope.data = response.site_settings[0];         
    });
  
  $scope.insertData=function(){      
      
    if($scope.email != undefined && $scope.message != undefined){
      var data = {
            name: $scope.name,
            email: $scope.email,
            mobile: $scope.mobile,
            subject: $scope.subject,
            message: $scope.message
     };    
      $http({
            method: 'POST',
            url: domain+'api/insert/contacts',
            data: data,
            dataType: 'jsonp',
            jsonp: 'jsoncallback',
            headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
            }
    }).success(function(data) {        
        $.growl.notice({ title: "تم ", message: "لقد تم ارسال رسالتك بنجاح" });
        $route.reload();
    });              
      }else{
          $.growl.warning({ title: "تنبيه ", message: "من فضلك أدخل بياناتك أولا!" });
      }
    }
    
});

app.controller('productCtr', function($scope,$http,$routeParams) {   
     $("#loadDv").removeClass('hidden');
    var id = $routeParams.id; 
    var url =  domain+"api/products?id="+id;     
    $http.get(url).success(function(response) {         
         $("#loadDv").addClass('hidden');
       $scope.item = response.products[0];  
       $scope.imgPath = imgPath;        
    });
    
    var url2 =  domain+"api/product_images?product_id="+id;     
    $http.get(url2).success(function(response) {          
       $scope.itemImgs = response.product_images;         
    });    
});
app.controller('articleCtrl', function($scope,$http,$routeParams) {   
     $("#loadDv").removeClass('hidden');
    var id = $routeParams.id; 
    var url =  domain+"api/articles?id="+id;     
    $http.get(url).success(function(response) {         
         $("#loadDv").addClass('hidden');
       $scope.row = response.articles[0];               
    });    
});
app.controller('notifyCtrl', function($scope,$http,$routeParams) {   
    var id = $routeParams.id; 
    var url =  domain+"api/notifications?id="+id;     
    $http.get(url).success(function(response) {         
       $scope.row = response.notifications[0];         
    });    
});
app.controller('profileCtrl',function ($scope,$http,$window) {
    var ifLoged = window.localStorage.getItem("USER_ID");          
     if(ifLoged == null) window.location.href = "#/login";
});
app.controller('loginCtrl', function($scope,$http,$window) {   
    $scope.submitForm = function () {             
        var email = $scope.email;
        var password = $scope.password;
        if(email != undefined && password != undefined){
            var login_data = {
                email: email,
                password: password
            };
        $http({
            method: 'POST',
            url: domain+ 'api/login',
            data: login_data,
            dataType: 'jsonp',
            jsonp: 'jsoncallback',
            headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).success(function(data) {
        if(data.output == true){
             window.localStorage.setItem('USER_ID', data.user_id);            
             $.growl.notice({ title: "تم ", message: "لقد تم تسجيل دخولك بنجاح" });
               
            window.location.href = "#/update_profile";
            $window.location.reload();
        }else{
          alet("", data.message, "error");
        }

        });

    }else{
          $.growl.warning({ title: "تنبية ", message: "من فضلك أدخل بريدك الالكترونى وكلمة المرور" });
    }
    }
});

app.controller('forgetCtrl', function($scope,$http,$window) {   
    $scope.submitForm = function () {             
        var email = $scope.email;        
        var msg = "كلمة مرورك الجديدة  5965203";
        var subject = "لقد طلبت كلمة مرور جديدة";
        if(email != undefined){
            var data = {
                to: email,  
                mag : msg,
                subject :subject
            };
        $http({
            method: 'POST',
            url: domain+ 'api/mail',
            data: data,
            dataType: 'jsonp',
            jsonp: 'jsoncallback',
            headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).success(function(data) {
       if(data.output == true){
             $.growl.notice({ title: "تم ", message: "لقد تم ارسال بريد الكترونى بكلمة المرور الجديدة الى بريدك الالكترونى " });
               
            window.location.href = "#/";
            $window.location.reload();
        }else{
          alet("", data.message, "error");
        }

        });

    }else{
          $.growl.warning({ title: "تنبية ", message: "من فضلك أدخل بريدك الالكترونى  " });
    }
    }
});


app.filter('strpTags', function() {
    return function(text) {
      return  text ? String(text).replace(/<[^>]+>/gm, '') : '';
    };
});

 
app.controller('logoutCtrl',function($window) {
//    $scope.logout = function (){
            window.localStorage.clear();
            window.location.href = "#/";
            $window.location.reload();
//        }
});

 
//------------ Menu Close ----------------
$("aside li").click(function () {
    $(".c-menu__close").trigger('click');
});
 
$("#checkout").click(function () {
    $(".closeMnu").trigger('click');
});
