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

    $.validator.addMethod("acceptName", function(value, element, param) {
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



    jQuery.validator.addMethod("logo", function (value, element, param) {
        param = typeof param === "string" ? param.replace(/,/g, '|') : "jpeg|jpg|png|gif|JPG|JPEG|PNG";
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
    
    $("#registerUser").validate({
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
            userName: {
                required: true,
                noSpace:true,
                alphaRestSpeChartor:true 
            },
            email:{
                required:true,
                noSpace:true,
                alphaRestSpeChartor:true 
            }, 
            phoneNumber:{
                required:true,
                digits: true,
                maxlength: 10,
                minlength: 10,
            }
        },
        messages: {
            userName: {
                required: "Please enter your name", 
                },
            email:{
                required: "Please enter your email"
            },
            phoneNumber:{
                required:"please your phone number"
            }
            
        },
            submitHandler: function(form) {
                $(':input[type="submit"]').prop('disabled', true);
                form.submit(); 
          }
         
    });

//1july2020
$("#registerFrm").validate({
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
            salutation: {
                required: true 
            },
            user_first_name:{
                required:true,
                noSpace:true,
                alphaRestSpeChartor:true 
            },
            user_last_name:{
                required:true,
                 noSpace:true,
                alphaRestSpeChartor:true 
            },
            user_email:{
                 required:true,
                 noSpace:true,
                alphaRestSpeChartor:true ,
                email:true,
            },
            //7oct2020
            refer_by:{
                required:true
            },
            refere_by_name:{
                required:{
                    depends: function(element) {
                      return $("#refer_by").val()=="2"  ;
                    }
                },
                 noSpace:true 
            },
            refere_by_phone_number:{
                required:{
                    depends: function(element) {
                      return $("#refer_by").val()=="2"  ;
                    }
                },
                 noSpace:true 
            },
            //7oct2020
            user_mobile:{
                required:true,
            },
            business_category_id:{
                required:false,
            },
             business_categories_sub:{
                required:true,
            },
            company_name:{
                required:true,
                 noSpace:true,
                alphaRestSpeChartor:true 
            },
            designation:{
                required:true,
                 noSpace:true,
                alphaRestSpeChartor:true 
            },
            adress:{
                required:true,
                 noSpace:true,
                alphaRestSpeChartor:true 
            },
            country_id:{
                required:true,
            },
            state_id:{
                required:true,
            },
            city_id:{
                required:true,
            },
            plan_id:{
                required:true
            },
             area_id:{
                required:true,
            },
            pincode:{
                 required:true,
                noSpace:true,
                alphaRestSpeChartor:true 
            },
            adress_type:{
                required:true 
            } ,
            user_profile_pic:{
                required: false,
                filesize2MB:true,
                logo: true
            },
            company_logo:{
                required: false,
                filesize2MB:true,
                logo:true
                
            }
        },
        messages: {
            plan_id:{
                required:"Please select membership plan"
            },
            salutation: {
                required: "Please Select salutation" 
            },
            user_first_name:{
                required:"Please provide first name"
            },
            user_last_name:{
                required:"Please provide last name" 
            },
            user_mobile:{
                required:"Please provide mobile number"
            },
             business_categories_sub:{
                required:"Please select sub category"
            },
            //24sept
            user_email:{
                required:"Please provide user email"
            },
            //7oct2020
            refer_by:{
                 required:"Please select refer by" 
            },
            refere_by_name:{
                required:"Please enter refer by person name" 
            },
             refere_by_phone_number:{
                required:"Please enter refer by person Mobile Number" 
            },
            //7oct2020
            company_name:{
                required:"Please provide company name"
            },
            designation:{
                required:"Please provide designation"
            },
            adress:{
                required:"Please provide adderess" 
            },
            country_id:{
                required:"Please select country"
            },
            state_id:{
                required:"Please select state"
            },
            city_id:{
                required:"Please select city"
            },
             area_id:{
                required:"Please select area"
            },
            pincode:{
                 required:"Please provide pin code" 
            },
            adress_type:{
                required:"Please select adderess type" 
            } 
            
        },
            submitHandler: function(form) {
                $(':input[type="submit"]').prop('disabled', true);
                form.submit(); 
          }
         
    });
//1july2020

     $("#loginForm").validate({
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
            
            loginPhone:{
                required:true,
                digits: true,
                maxlength: 10,
                minlength: 10,
            }
        },
        messages: {
            
            phoneNumber:{
                required:"please your phone number"
            }
            
        },
            submitHandler: function(form) {
                $(':input[type="submit"]').prop('disabled', true);
                form.submit(); 
          }
         
    });



});