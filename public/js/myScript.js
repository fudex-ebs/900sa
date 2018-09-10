/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//---------Select all checkbox ------------->
$("#chkAll").click(function () {
    $(".chkMe").prop('checked', $(this).prop('checked'));
});

//-------- Data Table ---------------------->
$(function(){
  $("#myTbl").dataTable();
})
