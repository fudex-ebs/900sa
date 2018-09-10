<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Restful API Web Services</title>

    <!-- Bootstrap css-->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
   
   	<!--Google Icon Font-->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <!-- Propeller css -->
    <link href="{{ asset('api/css/propeller.min.css') }}" rel="stylesheet">
    <style>
        .popover-content hr{
            margin:5px !important;
        }
    </style>
  </head>
  
  <body>
 <div class="container">
     <div class="row">   
    <h1>Restful API Web Services</h1>

    
    <div class="pmd-card pmd-z-depth">
        <div class="table-responsive">
    <table class="table pmd-table table-striped table-hover">
        <thead>
        <tr>
            <th style="width:50px">No.</th>
            <th style="width:150px">Table</th>

            <th>Fields</th>
            <th ></th>
        </tr>
        </thead>
        <tbody>

 @foreach($tables as $k=>$table)
 <?php
 $fileds_content = "";
 foreach($table->fields as $field){
     $fileds_content .= "<b style='color:#900'>".$field->Field." </b> <b>Type:</b> ".$field->Type." | <b>Null:</b> ".$field->Null." | <b>Key:</b>".$field->Key." | <b>Default:</b> ".$field->Default." ".$field->Extra."  <hr />";
 }
 //$fileds_content = print_r($table->fields);
 ?>
 <tr>
    
     <td>{{ $k+1 }}</td>
     <td>
     <?php
          $tableName = $table->{'Tables_in_'.$database};

       ?>
         <a target="_blank" href="{{ url('api/'.$tableName) }}" >{{$tableName}}</a>
     </td>
     
     <td><button data-trigger="click" title="{{$tableName}}" data-toggle="popover"  data-placement="right" data-content="<?= $fileds_content ?>" class="btn btn-primary">Fields</button></td>
     <td></td>
@endforeach
            
      </tr>
        </tbody>
    </table>
        </div>
        </div>
         <hr />
      
     
 
  </div>
    <!-- jQuery before Propeller.js -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	
    <!-- Include all compiled plugins (below), or indexinclude individual files as needed -->
	<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/propeller.min.js"></script>
   
<!-- Propeller ripple effect js -->
<script type="text/javascript" src="http://propeller.in/components/button/js/ripple-effect.js"></script>

<!-- Propeller popover js -->
<script>
	$(document).ready(function(){
		var options = {
                        html : true,
			placement: function(pop, dom_el){
				var range = 200; 
				var curPlacement = $(dom_el).attr("data-placement");
				var scrolled = $(window).scrollTop();
				var winWidth = $(window).width();
				var winHeight = $(window).height();
				var elWidth = $(dom_el).outerWidth();
				var elHeight = $(dom_el).outerHeight();
				var elTop =  $(dom_el).offset().top;
				var elLeft =  $(dom_el).offset().left;
				var curPosTop =  elTop - scrolled;
				var curPosLeft =  elLeft;
				var curPosRight = winWidth - curPosLeft - elWidth;
				var curPosBottom = winHeight - curPosTop - elHeight;
				if(curPlacement == "left" && curPosLeft <= range){
					return 'right';	
				}
				else if(curPlacement == "right" && curPosRight <= range){
					return 'left';	
				}
				else if(curPlacement == "top" && curPosTop <= range){
					return 'bottom';	
				}
				if(curPlacement == "bottom" && curPosBottom <= range){
					return 'top';	
				}else {
					return curPlacement;
				}
			}
		};
		$('[data-toggle="popover"]').popover(options);
                
	});
</script>


  </body>
</html>
