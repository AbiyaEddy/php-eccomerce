$(document).ready(function(){

    $(document).on("click", ".reload", function(e){
        location.reload(true);
    });

    $(document).on('click','.increment-btn',function(e) {
        e.preventDefault();
        var qty = $(this).closest('.product-data').find('.input-quantity').val();
        
        var value = parseInt(qty,10);
        value =isNaN(value) ? 0:value;
        if(value<10)
        {
            value++;
           
            $(this).closest('.product-data').find('.input-quantity').val(value);

        }
     });
$(document).on('click','.decrement-btn',function(e) {
         e.preventDefault();
         var qty = $(this).closest('.product-data').find('.input-quantity').val();
        
         var value = parseInt(qty,10);
         value =isNaN(value) ? 0:value;
         if(value> 1)
         {
             value--;
           
             $(this).closest('.product-data').find('.input-quantity').val(value);

         }
     });

        $(document).on('click','.addToCartBtn',function(e) {
        

        var qty = $(this).closest('.product-data').find('.input-quantity').val();
        var prod_id = $(this).val();
       
        $.ajax({
            method:"POST",
            url:"functions/handlecart.php",
            data:{
                "prod_id": prod_id,
                 "prod_qty": qty,
                 "scope":"add"
            },
            success: function(response){
                alert(response);
                
            }, 
            error: function(response){
                alert("Something went wrong!");
            }
        });
        
     });
     $(document).on('click','.updateQty',function(){
        var qty = $(this).closest('.product-data').find('.input-quantity').val();
        
   
        var prod_id = $(this).closest('.product-data').find('.prodId').val();

        $.ajax({
            method:"POST",
            url:"functions/handlecart.php",
            data:{
                "prod_id": prod_id,
                 "prod_qty": qty,
                 "scope":"update"
            },
            success: function(response){
                //alert(response);
                
            }, 
            error: function(response){
                alert("Something went wrong!");
            }
        });
        
     });
     $(document).on('click','.deleteItem',function() {
        var cart_id = $(this).val();
       //  alert(cart_id);
       $.ajax({
        method:"POST",
        url:"functions/handlecart.php",
        data:{
            "cart_id": cart_id,
             "scope":"delete"
        },
        success: function(response){
           alert(response);
          
        }, 
        error: function(response){
            alert("Something went wrong!");
        }
    });
     });
       
});