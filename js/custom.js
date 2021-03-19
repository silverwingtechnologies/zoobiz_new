jQuery(document).ready(function($){


});


$("#phoneNumber").keydown(function (e) {
    // Allow: backspace, delete, tab, escape, enter and .
    //110 for dot(.)
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1 ||
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