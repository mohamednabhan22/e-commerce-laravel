$(document).ready(function(){
    $('#current_pwd').on('keyup',function(){
        var current_pwd=$('#current_pwd').val();
        console.log(current_pwd);
$.ajax({
    type:'post',
    url:'check-current-pwd',
    data:{
        "_token": "{{ csrf_token() }}",
        current_pwd:current_pwd},
    success:function(res){
        if(res=="false"){
           $('#chkCurrentPwd').html("<font color='red'>Current password is incorrect</font> ") 
        }else if(res=="true"){
            $('#chkCurrentPwd').html("<font color='green'>Current password is correct</font> ") 
  
        }
    },error:function(){
        alert("error")
    }
})
    });
    $(".updateSectionStatus").click(function(){
        var status=$(this).text();
        var section_id=$(this).attr("section_id");
        $.ajax({
            type:"post",
            url:"/admin/update-section-status",
            data:{ "_token": "{{ csrf_token() }}",
            status:status,section_id:section_id},
            success:function(res){
if(res['status']==0){
    $("#section-"+section_id).html("Inactive")
}else if(res['status']==1){
    $("#section-"+section_id).html("active")
}
            },error:function(){
                alert("error")
            }
        })
    })



    $(".updateCategoryStatus").click(function(){
        var status=$(this).text();
        var category_id=$(this).attr("category_id");
        $.ajax({
            type:"post",
            url:"/admin/update-category-status",
            data:{ "_token": "{{ csrf_token() }}",
            status:status,category_id:category_id},
            success:function(res){
if(res['status']==0){
    $("#category-"+category_id).html("Inactive")
}else if(res['status']==1){
    $("#category-"+category_id).html("active")
}
            },error:function(){
                alert("error")
            }
        })
    })


    //append categories level
    $("#section_id").change(function(){
        var section_id=$(this).val();
        $.ajax({
            type:"post",
            url:"/admin/append-categories-level",
            data:{ "_token": "{{ csrf_token() }}",
            section_id:section_id},
            success:function(res){
                $("#appendCategoriesLevel").html(res);

            },error:function(){
                alert("error")
            }
        })
    })

    //confirm delete of Record
    $(".confirmDelete").click(function(){
        var name =$(this).attr('name');
        if(confirm("Are You sure to delete this "+name+"?")){
            return true
        }{
            return false
        }
    })




    $(".updateProductStatus").click(function(){
        var status=$(this).text();
        var product_id=$(this).attr("product_id");
        $.ajax({
            type:"post",
            url:"/admin/update-product-status",
            data:{ "_token": "{{ csrf_token() }}",
            status:status,product_id:product_id},
            success:function(res){
if(res['status']==0){
    $("#product-"+product_id).html("Inactive")
}else if(res['status']==1){
    $("#product-"+product_id).html("active")
}
            },error:function(){
                alert("error")
            }
        })
    })


    $(".updateAttributeStatus").click(function(){
        var status=$(this).text();
        var attribute_id=$(this).attr("attribute_id");
        $.ajax({
            type:"post",
            url:"/admin/update-attribute-status",
            data:{ "_token": "{{ csrf_token() }}",
            status:status,attribute_id:attribute_id},
            success:function(res){
if(res['status']==0){
    $("#attribute-"+attribute_id).html("Inactive")
}else if(res['status']==1){
    $("#attribute-"+attribute_id).html("active")
}
            },error:function(){
                alert("error")
            }
        })
    })

    $(".updateImageStatus").click(function(){
        var status=$(this).text();
        var image_id=$(this).attr("image_id");
        $.ajax({
            type:"post",
            url:"/admin/update-image-status",
            data:{ "_token": "{{ csrf_token() }}",
            status:status,image_id:image_id},
            success:function(res){
if(res['status']==0){
    $("#image-"+image_id).html("Inactive")
}else if(res['status']==1){
    $("#image-"+image_id).html("active")
}
            },error:function(){
                alert("error")
            }
        })
    })


  $(".updateBrandStatus").click(function(){
        var status=$(this).text();
        var brand_id=$(this).attr("brand_id");
        $.ajax({
            type:"post",
            url:"/admin/update-brand-status",
            data:{ "_token": "{{ csrf_token() }}",
            status:status,brand_id:brand_id},
            success:function(res){
if(res['status']==0){
    $("#brand-"+brand_id).html("Inactive")
}else if(res['status']==1){
    $("#brand-"+brand_id).html("active")
}
            },error:function(){
                alert("error")
            }
        })
    })

     $(".updateBannerStatus").click(function(){
        var status=$(this).text();
        var banner_id=$(this).attr("banner_id");
        $.ajax({
            type:"post",
            url:"/admin/update-banner-status",
            data:{ "_token": "{{ csrf_token() }}",
            status:status,banner_id:banner_id},
            success:function(res){
if(res['status']==0){
    $("#banner-"+banner_id).html("Inactive")
}else if(res['status']==1){
    $("#banner-"+banner_id).html("active")
}
            },error:function(){
                alert("error")
            }
        })
    })

    $(".updateCouponStatus").click(function(){
        
        var status=$(this).text();
       
        var coupon_id=$(this).attr("coupon_id");
        alert(coupon_id);
        $.ajax({
            type:"post",
            url:"/admin/update-coupon-status",
            data:{ "_token": "{{ csrf_token() }}",
            status:status,coupon_id:coupon_id},
            success:function(res){
if(res.status==0){
    $("#coupon-"+coupon_id).html("Inactive")
}else if(res.status==1){
    $("#coupon-"+coupon_id).html("active")
}
            },error:function(){
                alert("error")
            }
        })
    })

    //products attributes add/remove script
 var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div style="margin-top:20px"><input type="text" name="size[]" style="width:120px;margin-right:3px" value="" placeholder="size"/><input type="text" name="sku[]" style="width:120px;margin-right:3px" value="" placeholder="sku"/><input type="text" name="price[]" style="width:120px;margin-right:3px" value="" placeholder="price"/><input type="text" name="stock[]" style="width:120px;margin-right:3px" value="" placeholder="stock"/><a href="javascript:void(0);" class="remove_button">remove</a></div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    
    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });


    $("#manualCoupon").click(function(){
        $("#couponField").show();
    })

    $("#automaticCoupon").click(function(){
        $("#couponField").hide();
    })
})