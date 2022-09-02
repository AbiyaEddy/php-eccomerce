$(document).ready(function(){

    $('.increment-btn').click(function(e){

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
     $('.decrement-btn').click(function(e){

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

     $('.addToCartBtn').click(function(e){

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
                //alert("Product Added to Cart");
            }, 
            error: function(response){
                alert("Something went wrong!");
            }
        });
        
     });
       
});