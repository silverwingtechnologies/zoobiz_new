jQuery(document).ready(function($){
    //your custom2.js code here
});

// function checkMobileUser() {
//   var userMobile= $('#userMobile').val();
  
//      $.ajax({
//         url: "controller/registerController.php",
//         cache: false,
//         type: "POST",
//         data: {userMobile : userMobile,checkUserMobile:'checkUserMobile'},
//         success: function(response){
//            if (response==1) {
//                // document.getElementById("addNewMember").disabled=true;
//               Lobibox.notify('error', {
//                 pauseDelayOnHover: true,
//                 continueDelayOnInactiveTab: false,
//                 position: 'top right',
//                 icon: 'fa fa-times-circle',
//                 msg: 'This mobile number is Already Used.'
//                 });
                  
//            } else {
//               // document.getElementById("addNewMember").disabled=false;
//            }
//         }
//       });
// }

function  getStates() {
  var country_id = $("#country_id").val();
  $.ajax({
        url: "ajax/getStates.php",
        cache: false,
        type: "POST",
        data: {country_id : country_id,getStates:'getStates'},
        success: function(response){

         

             $('#state_id').html(response);
          
            
        }
     });
}




function  getCity() {
  var state_id = $("#state_id").val();
  $.ajax({
        url: "ajax/getCities.php",
        cache: false,
        type: "POST",
        data: {state_id : state_id,getCity:'getCity'},
        success: function(response){
            $('#city_id').html(response);
          
            
        }
     });
}


function  getArea() {
  var city_id = $("#city_id").val();
  $.ajax({
        url: "ajax/getArea.php",
        cache: false,
        type: "POST",
        data: {city_id : city_id,getArea:'getArea'},
        success: function(response){
            $('#area_id').html(response);
          
            
        }
     });
}

function  getLatLong() {
  var area_id = $("#area_id").val();
  $.ajax({
        url: "ajax/getArea.php",
        cache: false,
        type: "POST",
        data: {area_id : area_id,getLatLong:'getLatLong'},
        success: function(response){
             // $('#area_id').html(response);
            var fields = response.split('~');
            document.getElementById('lat').value = fields[0];
            document.getElementById('lng').value = fields[1];

            initialize();
            
        }
     });
}

 

function  getSubCategory() {
  var business_categories = $("#business_categories").val();
  $.ajax({
        url: "ajax/getBusSubCategory.php",
        cache: false,
        type: "POST",
        data: {business_categories : business_categories},
        success: function(response){
            $('#business_categories_sub').html(response);
        }
     });
}

 


              

function  getSubCategorySp() {
  var local_service_master_id = $("#local_service_master_id").val();
  $.ajax({
        url: "ajax/getSubCategory.php",
        cache: false,
        type: "POST",
        data: {local_service_master_id : local_service_master_id,getSubCategory:'getSubCategory'},
        success: function(response){
            $('#local_service_provider_sub_id').html(response);
          
            
        }
     });
}
 
  $("#refer_friend_name").keypress(function (e) {
   
  setTimeout(function() {
       var refer_friend_name = $("#refer_friend_name").val();

       if(refer_friend_name.length >  2 ){
      $.ajax({
        url: "ajax/getRefUsers.php",
        cache: false,
        type: "POST",
        data: {refer_friend_name : refer_friend_name},
        success: function(response){
            $('#refer_friend_id').html(response);
          
            
        }
     });
   }


    }, 0);
   
  
});
  
 var inputxx = document.getElementById('refer_friend_name');
inputxx.onkeydown = function() {
    var key = event.keyCode || event.charCode;
     
    if( key == 8 ){
      var refer_friend_name = $("#refer_friend_name").val();
 
           if(refer_friend_name.length > 3 ){
              $.ajax({
                url: "ajax/getRefUsers.php",
                cache: false,
                type: "POST",
                data: {refer_friend_name : refer_friend_name},
                success: function(response){
                    $('#refer_friend_id').html(response);
                  
                    
                }
             });
           } else {
            $('#refer_friend_id').html('');
           }
    }
};




 $(".onlyNumber,#secretary_mobile,#trlDays,#emp_sallary,#no_of_option,#month_working_days,#working_days,#leave_days,#no_of_person,#no_of_month,#expAmoint,#no_of_unit_bill,#no_of_unit,#no_of_blocks,#no_of_floor,#emrNumber,#userMobile,#ownerMobile,#empNumber,#cMobile,#editMobile1,#noofCar,#noofBike,#person_limit_day,#person_limit").keydown(function (e) {
    // Allow: backspace, delete, tab, escape, enter and .
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
         // Allow: Ctrl+A, Command+A
        (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
         // Allow: home, end, left, right, down, up
        (e.keyCode >= 35 && e.keyCode <= 40)) {
             // let it happen, don't do anything
             return;
    }
    // Ensure that it is a number and stop the keypress
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
    }
});



$(".docOnly").change(function () {
     var fileExtension = ['jpeg', 'jpg', 'png', 'doc','docx', 'pdf', 'jpg','csv', 'xls' , 'xlsx'];
    if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
        // alert("Only formats are allowed : "+fileExtension.join(', '));
        swal("Only formats are allowed : "+fileExtension.join(', '), {icon: "error", });
        $('.idProof').val('');
    }
});

$(".idProof").change(function () {
     var fileExtension = ['jpeg', 'jpg', 'png', 'doc','docx', 'pdf', 'jpg'];
    if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
        // alert("Only formats are allowed : "+fileExtension.join(', '));
        swal("Only formats are allowed : "+fileExtension.join(', '), {icon: "error", });
        $('.idProof').val('');
    }
});

$(".photoOnly").change(function () {
     // alert(this.files[0].size);
     var fileExtension = ['jpeg', 'jpg', 'png'];
    if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
        // alert("Only formats are allowed : "+fileExtension.join(', '));
        swal("Only formats are allowed : "+fileExtension.join(', '), {icon: "error", });
        $('.photoOnly').val('');
    }
});

 $(".mem-alphanumeric").keypress(function (e) {
  var keyCode = e.which;
 
  if ( !( (keyCode >= 48 && keyCode <= 57) 
   ||(keyCode >= 65 && keyCode <= 90) 
   || (keyCode >= 97 && keyCode <= 122) 
    
   ) 
   && ( keyCode != 8 &&  keyCode != 32 )  ) {
   e.preventDefault();
  }
});



function  referBy() {
    var refer_by = $("#refer_by option:selected").val();
    if(refer_by=="2"){
      $('#remark_div').css('display','none');
      $('#refere_by_user_div').css('display','block');

      $('#refere_by_user_div2').css('display','block');
      
      $('#refere_by_phone_number_div').css('display','none');
       $('#refere_by_name_div').css('display','none');
    } else if(refer_by=="3"){
       $('#refere_by_user_div').css('display','none');
      $('#refere_by_user_div2').css('display','none');
      $('#refere_by_name_div').css('display','none');
      $('#refere_by_phone_number_div').css('display','none');
      $('#remark_div').css('display','block');
    } else {
       $('#refere_by_user_div').css('display','none');
      $('#refere_by_user_div2').css('display','none');
      $('#refere_by_name_div').css('display','none');
      $('#refere_by_phone_number_div').css('display','none');
      $('#remark_div').css('display','none');
    }
}