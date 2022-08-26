<!-- <?php


if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(isset($_POST['addToCart']))
    {
        if(isset($_SESSION['cart']))
        {
            $count = count($_SESSION['cart']);

            $_SESSION['cart'][$count]=array(
            'product_name'=>$_POST['product_name'],
            'product_price'=>$_POST['product_price'],
            'product_quantity'=>1);
            print_r($_SESSION['cart']);

        }else{
            $_SESSION['cart'][0]=array(
                'product_name'=>$_POST['product_name'],
                'product_price'=>$_POST['product_price'],
                'product_quantity'=>1);
                print_r($_SESSION['cart']);
        }
    }
}
?>