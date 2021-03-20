$(document).ready(function(){
   
    $.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
    $("#sort").change(function(){
       
        // this.form.submit();
        var sort=$(this).val();
        var url=$("#url").val();
        var fabric=git_filter("fabric") ;

        var sleeve=git_filter("sleeve") ;
        var pattern=git_filter("pattern") ;

        var fit=git_filter("fit") ;
        var occasion=git_filter("occasion") ;

        $.ajax({
            method:"post",
            url:url,
            data:{ "_token": "{{ csrf_token() }}",
            sort:sort,
            url,url,
            sleeve,
        fabric:fabric,
        fit:fit,
        pattern:pattern,
        occasion:occasion


        
        },
            success:function(data){
                $(".filter-products").html(data);

            },error:function(){
                alert("error")
            }
        })

    })

    $(".fabric").click(function(){
        var fabric=git_filter("fabric") ;

        var sleeve=git_filter("sleeve") ;
        var pattern=git_filter("pattern") ;

        var fit=git_filter("fit") ;
        var occasion=git_filter("occasion") ;

       var sort=$("#sort option:selected").val();
       var url=$("#url").val();
       $.ajax({
        method:"post",
        url:url,
        data:{ "_token": "{{ csrf_token() }}",
        sort:sort,
        url,url,
        sleeve,
        fabric:fabric,
        fit:fit,
        pattern:pattern,
        occasion:occasion
    
    },
        success:function(data){
            $(".filter-products").html(data);

        },error:function(){
            alert("error")
        }
    })
    })
    $(".sleeve").click(function(){
        var fabric=git_filter("fabric") ;

        var sleeve=git_filter("sleeve") ;
        var pattern=git_filter("pattern") ;

        var fit=git_filter("fit") ;
        var occasion=git_filter("occasion") ;

        var sort=$("#sort option:selected").val();
        var url=$("#url").val();
        $.ajax({
         method:"post",
         url:url,
         data:{ "_token": "{{ csrf_token() }}",
         sort:sort,
         url,url,
         sleeve,
         fabric:fabric,
         fit:fit,
         pattern:pattern,
         occasion:occasion
     },
         success:function(data){
             $(".filter-products").html(data);
 
         },error:function(){
             alert("error")
         }
     })
     })




     $(".pattern").click(function(){
        var fabric=git_filter("fabric") ;

        var sleeve=git_filter("sleeve") ;
        var pattern=git_filter("pattern") ;

        var fit=git_filter("fit") ;
        var occasion=git_filter("occasion") ;
        $.ajax({
         method:"post",
         url:url,
         data:{ "_token": "{{ csrf_token() }}",
         sort:sort,
         url,url,
         sleeve,
        fabric:fabric,
        fit:fit,
        pattern:pattern,
        occasion:occasion
     
     },
         success:function(data){
             $(".filter-products").html(data);
 
         },error:function(){
             alert("error")
         }
     })
     })
     $(".fit").on('click',function(){
         
        var fabric=git_filter("fabric") ;

        var sleeve=git_filter("sleeve") ;
        var pattern=git_filter("pattern") ;

        var fit=git_filter("fit") ;
        var occasion=git_filter("occasion") ;
        $.ajax({
         method:"post",
         url:url,
         data:{ "_token": "{{ csrf_token() }}",
         sort:sort,
         url,url,
         sleeve,
        fabric:fabric,
        fit:fit,
        pattern:pattern,
        occasion:occasion
     
     },
         success:function(data){
             $(".filter-products").html(data);
 
         },error:function(){
             alert("error")
         }
     })
     })
     $(".occasion").on('click',function(){
        var fabric=git_filter("fabric") ;

        var sleeve=git_filter("sleeve") ;
        var pattern=git_filter("pattern") ;

        var fit=git_filter("fit") ;
        var occasion=git_filter("occasion") ;
        var sort=$("#sort option:selected").val();
        var url=$("#url").val();
        $.ajax({
         method:"post",
         url:url,
         data:{ "_token": "{{ csrf_token() }}",
         sort:sort,
         url,url,
         sleeve,
         fabric:fabric,
         fit:fit,
         pattern:pattern,
         occasion:occasion
     
     },
         success:function(data){
             $(".filter-products").html(data);
 
         },error:function(){
             alert("error")
         }
     })
     })

    function git_filter(class_name){
        var filter=[];
        $("."+class_name+":checked").each(function(){
            filter.push($(this).val());
        })
        return filter
    }

    $("#getPrice").change(function(){
       
      
        if(size=""){
            alert("please select size ")
            return false
        }
        var size=$(this).val();
        var product_id=$(this).attr("product-id");
        $.ajax({
            type:"post",
            url:"/get-product-price",
            data:{
            size:size,
            product_id:product_id
        }, 
            success:function(res){
                if(res['discounted_price']>0){
                    $(".getAtrrPrice").html("<del> RS. "+ res['product_price']+"</del> Rs."+res['discounted_price']);
                    $(".st").hide();

                }else{
                    $(".getAtrrPrice").html("RS. "+ res['product_price']);

                }

            },error:function(){
                alert("error")
            }
        })
    })



    $(document).on('click','.btnItemUpdate',function(){
        if($(this).hasClass('qtyMinus')){
            var quantity=$(this).prev().val();//عشان عاوز القيمة الحالية قبل اما تزيد او تنقص بعد ما ضغط
            if(quantity<=1){
                alert("item quantity must be 1 or greater");
                return false
            }else{
                new_qty=parseInt(quantity)-1;
            }
        }
        if($(this).hasClass('qtyPlus')){
            var quantity=$(this).prev().prev().val();//عشان عاوز القيمة الحالية قبل اما تزيد او تنقص بعد ما ضغط
            new_qty=parseInt(quantity)+1;

        }
        var cartId=$(this).attr('cartId');
        $.ajax({
            type:"post",
            url:"/update-cart-item-qty",
            data:{
            cartId:cartId,
            qty:new_qty
        }, 
            success:function(res){
                if(res.status==false){
                    alert(res.message);
                   
                }
                $('.totalCartItems').html(res.totalCartItems);
              $(".AppendCartItems").html(res.view);

            },error:function(){
                alert("error")
            }
        })
    })


    $(document).on('click','.btnItemDelete',function(){
        var cartId=$(this).attr('cartId');
      var result=confirm("Do you want to delete this cart item ?")
      if(result){
        $.ajax({
            type:"post",
            url:"/delete-cart-item",
            data:{
            cartId:cartId
           
        }, 
            success:function(res){
                $('.totalCartItems').html(res.totalCartItems);

                $(".AppendCartItems").html(res.view);

            },error:function(){
                alert("error")
            }
        })
      }
       
   
 
    })

    $("#applyCoupon").submit(function(){
                    var user=$(this).attr("user");
                    if(user==1){
                        alert("s");
                    }else{
                        alert("please login to apply Coupon");
                        return false;
                    }
        
                    var code=$("#code").val();
                    alert(code);

                    $.ajax({
                        type:"post",
                        url:"/apply-coupon",
                        data:{
                        code:code
                       
                    }, 
                        success:function(res){
                          if(res.message!=""){
                              alert(res.message)
                          } 
                          $(".totalCartItems").html(res.totalCartItems);
                          $(".appendCartItems").html(res.view);
                          if(res.couponAmount>=0){
                            $("couponAmount").text("Rs."+ res.couponAmount);

                          }else{
                            $(".couponAmount").text("Rs.0");
                          }

                          if(res.grand_total>=0){
                          $(".grand_total").text("Rs."+ res.grand_total);
        
                          }else{
                            $(".grand_total").text("Rs.0");
                          }
                          $('.totalCartItems').html(res.totalCartItems);
        
                          $(".AppendCartItems").html(res.view);
                        },error:function(){
                            alert("error")
                        }
                    })
                })
}) 
