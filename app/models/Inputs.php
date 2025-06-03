<?php

function clearIn($data) {
    $data = trim($data);
    $data = stripslashes($data);
     $data = htmlspecialchars($data);
    return $data;
 }

 function blueMsg(array $Messages){
    $Message = '';
    foreach($Messages as $Message){
        echo '<div class="alert alert-secondary alert-dismissible fade show" role="alert">'.
            $Message
        .'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
 }

 function blueMsgLog(array $Messages){
    $Message = '';
    for($i=0; $i<count($Messages);$i++){
        $Message = $Messages[$i];
        echo '<div class="alert alert-secondary alert-dismissible fade show" role="alert">'.
            $Message
        .'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
 }
 function greyMsg(array $Messages){
    foreach($Messages as $Message){
        echo '<div class="alert alert-light alert-dismissible fade show" role="alert">'.
            $Message
        .'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
 }

 function btnBackCustomers(bool $btn){
    if ($btn) { 
        echo '<a href="customers.php">
           <button class="btn btn-success">Volver</button>
       </a>';

        } 
 }

 function btnBackProduscts(bool $btn){
    if ($btn) { 
        echo '<a href="products.php">
           <button class="btn btn-success">Volver</button>
       </a>';

        } 
 }
 function btnBackOrders(bool $btn){
    if ($btn) { 
        echo '<a href="orders.php">
           <button class="btn btn-success">Volver</button>
       </a>';

        } 
 }

 function btnAfterClient(bool $btn,){
    if ($btn) { 
        

        } 
 }


 function msgHeader(string $msg, string $link){        
        header("Location: ".$link.$msg);
 }

 function valArray(array $array, string $nameValue)
    {
        $result = [];
        foreach ($array as $item) {
            $result[] = $item[$nameValue];
        }

        $string = $result[0];
        return $string;
    }
?>