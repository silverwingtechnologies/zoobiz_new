$().ready(function() {

    $.validator.addMethod("pwcheck", function(value) {
        return /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) // consists of only these
           && /[A-Z]/.test(value) // has a lowercase letter
           && /\d/.test(value) // has a digit
    });
 
    $.validator.addMethod("addressCheck", function(value) {
        /*alert(value);*/
        /*alert((/^[A-Za-z ]+/.test(value) || value==""  ))*/
         return /^[A-Za-z 0-9\d=!,\n\-@._*]*$/.test(value) // consists of only these
            && (/\w*[a-zA-Z ]\w*/.test(value) || value==''  )// has a lowercase letter
           // && /\d/.test(value) // has a digit
    });

    jQuery.validator.addMethod("acceptName", function(value, element, param) {
        return value.match(new RegExp("." + param + "$"));
    });


    $.validator.addMethod("alpha", function(value, element) {
        return this.optional(element) || value == value.match(/^[a-zA-Z ]*$/);
    }, jQuery.validator.format("Please enter a Valid Name."));

    $.validator.addMethod("alphaRestSpeChartor", function(value, element) {
        return this.optional(element) || value == value.match(/^[A-Za-z 0-9\d=!,:\n\-@&()/?%._*]*$/);
    }, jQuery.validator.format("special characters not allowed"));


    $.validator.addMethod("noSpace", function(value, element) { 
        return value == '' || value.trim().length != 0;  
    }, "No space please and don't leave it empty");

    $.validator.addMethod('minStrict', function (value, el, param) {
        return value >= param;
    });

    jQuery.validator.addMethod("greaterThan", 
        function(value, element, params) {

            if (!/Invalid|NaN/.test(new Date(value))) {
                return new Date(value) > new Date($(params).val());
            }

            return isNaN(value) && isNaN($(params).val()) 
            || (Number(value) > Number($(params).val())); 
    },'Must be greater than {0}.');

    jQuery.validator.addMethod("image", function (value, element, param) {
        param = typeof param === "string" ? param.replace(/,/g, '|') : "png|jpe?g";
        return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
    }, jQuery.validator.format("Please add a valid image file."));


    $('input[type="file"]').change(function(){
        $(this).valid()
    });

    //IS_639 divya
    $.validator.addMethod('filesize', function (value, element, arg) {
        var size =3000000;
        if(element.files.length){
            if(element.files[0].size<=size)
            {
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }

    }, $.validator.format("file size must be less than or equal to 3MB."));

    //21FEB2020
    $.validator.addMethod('filesize1MB', function (value, element, arg) {
        var size =1097152;
        if(element.files.length){
            if(element.files[0].size<size)
            {
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }
    }, $.validator.format("file size must be less than  1MB."));

    $.validator.addMethod('MaxUploadFile', function (value, element, arg) {
        var FIlelength = 20;

        if(element.files.length <= FIlelength){

            return true;
        }else{
            return false;
        }
    }, $.validator.format("You are allowed to upload only maximum 20 files at a time"));

    //21FEB2020


    //24feb2020
    $.validator.addMethod("extension", function(value, element, param) {
        param = typeof param === "string" ? param.replace(/,/g, '|') : "png|jpe?g|gif";
        return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
    },$.validator.format("Please select a file with a valid extension (png,jpeg,jpg,gif)."));

    $.validator.addMethod("extensionDoc", function(value, element, param) {
        param = typeof param === "string" ? param.replace(/,/g, '|') : "png|jpe?g|gif|pdf";
        return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
    }, $.validator.format("Please select a file with a valid extension (png,jpeg,jpg,gif,pdf)."));

    $.validator.addMethod('filesize4MB', function (value, element, arg) {
        var size =4000000;
        if(element.files.length){
            if(element.files[0].size<=size)
            {
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }
    }, $.validator.format("file size must be less than or equal to 4MB."));
    //24feb2020
    $.validator.addMethod('filesize2MB', function (value, element, arg) {
        var size =2000000;
        if(element.files.length){
            if(element.files[0].size<=size)
            {
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }
    }, $.validator.format("file size must be less than or equal to 2MB."));

    $.validator.addMethod("extensionDocument", function(value, element, param) {
        param = typeof param === "string" ? param.replace(/,/g, '|') : "png|jpe?g|txt|xls|csv|pdf|docx|odt|ods|xlsx";
        return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
    },$.validator.format("Please select a file with a valid extension (png,jpeg,jpg,txt,xls,csv,pdf,docx,odt,ods,xlsx)."));

    $.validator.addMethod('compare', function (value, element, param) {
        return this.optional(element) || parseInt(value) > 0 || parseInt($(param).val()) > 0;
    }, $.validator.format('Invalid value'));


    //19march2020 eve
    $.validator.addMethod('filesize12MB', function (value, element, arg) {
        var size =12000000;
        if(element.files.length){
            if(element.files[0].size<=size)
            {
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }
    }, $.validator.format("file size must be less than or equal to 12MB."));
 //19march2020   

    $("#personal-info").validate({
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
            error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        }
    });
    $("#personal-info1").validate({
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
            error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
            parking_name:
            {
                required: true,
                noSpace: true,
                remote:
                {
                    url: 'UniqueParkingName.php',
                    type: "post",
                    data:
                    {
                        oldParkingName: function()
                        {
                            return $('#personal-info1 :input[name="parking_name"]').val();
                        },
                        society_parking_id: function()
                        {
                            return $('#personal-info1 :input[name="society_parking_id"]').val();
                        }, 
                        society_id: function()
                        {
                            return $('#personal-info1 :input[name="society_id"]').val();
                        } 
                        , 
                        parking_id: function()
                        {
                            return $('#personal-info1 :input[name="parking_id"]').val();
                        } 
                    } 
                }
            }
        },
        messages: {
            parking_name: {
            //2march2020 -new
            required: "Please enter Parking Name", 
            remote: "Parking Name is already exists, please use another parking name to avoid confusion"
            },
            submitHandler: function(form) {
                $(':input[type="submit"]').prop('disabled', true);
                form.submit(); 
          }
     }
    //28feb2020
    });




    //IS_914  //2march2020 -new
    $("#addAddress").validate({
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
                error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
            adress: {
                required: true,
                noSpace:true 
            },
            pincode:{
                required:true
            }, 
            booked_date:{
                required:true
            }
            
        },
        messages: {
            adress: {
                required: "Please enter address", 
                },
            pincode:{
                required: "Please enter pincode"
            },
            booked_date:{
                required:"please select booking date"
            }
        },
            submitHandler: function(form) {
                $(':input[type="submit"]').prop('disabled', true);
                form.submit(); 
          }
         
    });
    $("#payFacilityFrm").validate({
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
                error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
            payment_type: {
                required: true,
                noSpace:true 
            } ,
            payment_bank:{
                required:{
                    depends: function(element) { 
                      return $('#payFacilityFrm :input[name="payment_type"]').val() =="1"  || $('#payFacilityFrm :input[name="payment_type"]')=="2" ;
                    }
                },
                 noSpace:true 
            },
            payment_number:{
                required:{
                    depends: function(element) {
                       return $('#payFacilityFrm :input[name="payment_type"]').val() =="1"  || $('#payFacilityFrm :input[name="payment_type"]')=="2" ;
                  }
                },
                 noSpace:true 
            }
        },
        messages: {
            payment_type: {
                required: "Please select Payment Type", 
            },
            
            payment_bank:{
                required:"Please enter bank name"
            },
            payment_number:{
                required:"Please enter reference number"
            }
         },
            submitHandler: function(form) {
                $(':input[type="submit"]').prop('disabled', true);
                form.submit(); 
          }
     
    });
    
    //IS_914 //2march2020 -new




    
    $("#personal-info2").validate({
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
            error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        }
    });
    $("#personal-info3").validate({
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
                error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules:{
            employment_type:{
                required:true,
            },
            business_categories:{
                required:true,
            },
            business_categories_sub:{
                required:true,
            },
            company_name:{
                required:true,
                noSpace:true,
                alphaRestSpeChartor: true,
            },
            designation:{
                required:true,
                noSpace:true,
                alpha: true,
            },
            company_address:{
                required:true,
                noSpace:true,
            },
            company_contact_number:{
                required:true,
                digits: true,
                maxlength: 10,
                minlength: 10,
            }
        },
            submitHandler: function(form) {
                $(':input[type="submit"]').prop('disabled', true);
                form.submit(); 
          }
    });
    $(".common-form").validate({
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
            error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        }
    });
    $("#companyDetails").validate({
       errorPlacement: function (error, element) {
           if (element.parent('.input-group').length) { 
                error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
            firstname: "required",
            lastname: "required",
            username: {
                required: true,
                minlength: 2,
                alpha:true
            },
            password: {
                required: true,
                minlength: 5
            },
            confirm_password: {
                required: true,
                minlength: 5,
                equalTo: "#password"
            },
            email: {
                required: true,
                email: true
            },
            contactnumber: {
                required: true,
                minlength: 10,
                maxlength:10

            },
            topic: {
                required: "#newsletter:checked",
                minlength: 2
            },
            agree: "required"
        },
        messages: {
            firstname: "Please enter your firstname",
            lastname: "Please enter your lastname",
            username: {
                required: "Please enter a username",
                minlength: "Your username must consist of at least 2 characters"
            },
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long"
            },
            confirm_password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long",
                equalTo: "Please enter the same password as above"
            },
            email: "Please enter a valid email address",
            contactnumber: "Please enter your 10 digit number",
            agree: "Please accept our policy",
            topic: "Please select at least 2 topics"
        },
            submitHandler: function(form) {
                $(':input[type="submit"]').prop('disabled', true);
                form.submit(); 
          }
    });
    
    $("#documentTypeAdd").validate({
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
                error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
            document_type_name: {
                required: true,
                noSpace:true,
                alphaRestSpeChartor: true,
            },
            employee_type_name_edit: {
                required: true,
                noSpace:true,
                alphaRestSpeChartor: true,
            }
            
            
        },
        messages: {
            document_type_name: {
                required : "Please enter type name",
                noSpace: "No space please and don't leave it empty",
            },
            employee_type_name_edit: {
                required : "Please enter type name",
                noSpace: "No space please and don't leave it empty",
            },

        },
            submitHandler: function(form) {
                $(':input[type="submit"]').prop('disabled', true);
                form.submit(); 
          }
    });
    $("#empTypeAdd").validate({
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
                error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
            employee_type_name_add: {
                required: true,
                noSpace:true,
                alphaRestSpeChartor: true,
            },
            employee_type_name_edit: {
                required: true,
                noSpace:true,
                alphaRestSpeChartor: true,
            }
            ,emp_type_icon:{
                filesize2MB:true
            }
            
            
        },
        messages: {
            employee_type_name_add: {
                required : "Please enter type name",
                noSpace: "No space please and don't leave it empty",
            },
            employee_type_name_edit: {
                required : "Please enter type name",
                noSpace: "No space please and don't leave it empty",
            },

        },
            submitHandler: function(form) {
                $(':input[type="submit"]').prop('disabled', true);
                form.submit(); 
          }
    });
    

 $("#addCategoryForm").validate({
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
            error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
            category_name: {
                required: true,
                noSpace:true
            },
            game_date:{
                required: true,
                noSpace:true
            },
           
             
          },
        messages: {
            category_name: {
                required : "Please enter name"
            },
            game_date: {
                required : "Please enter date"
            } 
        }
        , submitHandler: function(form) {
            form.submit();
        }
    });

  $("#editCatForm").validate({
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
            error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
            category_name_edit: {
                required: true,
                noSpace:true
            },
            game_date:{
                required: true,
                noSpace:true
            },
           
             
          },
        messages: {
            category_name_edit: {
                required : "Please enter name"
            },
            game_date: {
                required : "Please enter date"
            } 
        }
        , submitHandler: function(form) {
            form.submit();
        }
    });


  $("#addSubCat").validate({
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
            error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
            sub_category_name: {
                required: true,
                noSpace:true
            },
            business_category_id:{
                required: true,
                noSpace:true
            },
           
             
          },
        messages: {
            sub_category_name: {
                required : "Please enter name"
            },
            business_category_id: {
                required : "Please select category"
            } 
        }
        , submitHandler: function(form) {
            form.submit();
        }
    });



 $("#addHousieQuestion").validate({
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
            error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
            "question_name[]": "required",
            "answer[]": "required"
        },
        messages: {
            "question_name[]": "Please enter question",
            "answer[]": "Please enter answer",
        }
    });


 $("#addKbgQuestion").validate({
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) { 
            error.insertAfter(element.parent());      // radio/checkbox?
            } else if (element.hasClass('select2-hidden-accessible')) {     
                error.insertAfter(element.next('span'));  // select2
                element.next('span').addClass('error').removeClass('valid');
            } else {                                      
                error.insertAfter(element);               // default
            }
        },
        rules: {
            "kbg_question[]": "required",
            "kbg_option_1[]": "required"
        },
        messages: {
            "kbg_question[]": "Please enter question",
            "kbg_option_1[]": "Please enter option a",
        }
    });


//30march2020

   
   $("[name^=opening_time]").each(function () {
        $(this).rules("add", {
            required: true,
        });
    });

    $("[name^=closing_time]").each(function () {
        $(this).rules("add", {
            required: true,
        });
    });
});