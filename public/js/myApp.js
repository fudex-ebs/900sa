//var domain = "http://fudexsb.com/demo/balsam/";
//var imgPath = domain+"/public/uploads/";

var domain = "http://localhost:8000/";
var imgPath = domain+"uploads/";

var app = angular.module("myApp");

app.controller('ctrl', taskCtrl);

function taskCtrl($scope){
 console.log('sssssssssssssssssss');
}

//
//app.controller('companyCtrl', function($scope,$http,$routeParams,$rootScope) {   
//    console.log('res');
//    var instgram_name = "mediasrca";
// 
//    $http.get('https://www.instagram.com/'+instgram_name+'/?__a=1')
//       .then(function(res){
//           $scope.insta_count = res.data.user.media.count;
//           $scope.insta_fllowers = res.data.user.followed_by.count;
//           $scope.insta_fllow = res.data.user.follows.count;
//           
//           var items = res.data.user.media.nodes;
//            $.each(items, function(n, item) {
//            $('#insta').append(
//              $('<a/>', {
//                href: 'https://www.instagram.com/p/'+item.code,
//                target: '_blank'
//              }).css({
//                backgroundImage: 'url(' + item.thumbnail_src + ')'
//              }));
//          });
//        });  
// 
//    
//});
