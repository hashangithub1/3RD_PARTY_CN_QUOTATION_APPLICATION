<?php session_start();
$_SESSION['product']                =   "";
$_SESSION['vehicleRate']            =   0;
$_SESSION['basicRate']              =   0;
$_SESSION['sumInsured']             =   "";
$_SESSION['companyProduct']         =   "";
$_SESSION['datefrom']               =   "";           
$_SESSION['dateto']                 =   "";            
$_SESSION['sumInsured']             =   "";        
$_SESSION['clientName']             =   "";        
$_SESSION['clientAddress']          =   "";      
$_SESSION['makeModel']              =   "";          
$_SESSION['fuelType']               =   "";         
$_SESSION['registrationStatus']     =   "";
$_SESSION['regNo']                  =   "";             
$_SESSION['usage']                  =   "";              
$_SESSION['seatingCapacity']        =   "";    
$_SESSION['manufactureYear']        =   "";    
$_SESSION['companycode_form']       =   "";
$_SESSION['companyname_form']       =   "";
$_SESSION['companycode_form']       =   "";
$_SESSION['comp_excesses']          =   NULL;
$_SESSION['Age_Exces']              =   NULL;
$_SESSION['remark']                 =   NULL;
$_SESSION['sumInsured_edit']        =   NULL;
$_SESSION['srccTC']                 =   NULL;
header("Location: motor-quotation.php");
?>