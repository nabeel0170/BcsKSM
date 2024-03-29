<?php

include_once(__DIR__ . "/../commons/dbconnection.php");
$dbConnectionObj = new dbConnection();

class customer{
    
    Public function getcustomerdetails(){
        $con = $GLOBALS["con"];
        $sql = " SELECT * FROM customer";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    Public function insertorUpdatecustomerdetails($cus_id,$cusFname,$cusLname,$cusEmail,$cusContactNo){
        $con = $GLOBALS["con"];
        if ($cus_id === '' && !isset($cus_id)) {
            $sql = "INSERT INTO customer (customer_fname, customer_lname, contact_number, customer_email)
                    VALUES ('$cusFname', '$cusLname', '$cusContactNo', '$cusEmail')";
        } else {
            $sql = "INSERT INTO customer (customer_id, customer_fname, customer_lname, contact_number, customer_email)
                    VALUES ('$cus_id', '$cusFname', '$cusLname', '$cusContactNo', '$cusEmail')
                    ON DUPLICATE KEY UPDATE
                    customer_fname = VALUES(customer_fname),
                    customer_lname = VALUES(customer_lname),
                    contact_number = VALUES(contact_number),
                    customer_email = VALUES(customer_email)";
        }
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
    Public function getAcustomersdetails($cusContactNo){
        $con = $GLOBALS["con"];
        $sql = "SELECT * FROM customer WHERE contact_number = '$cusContactNo'  ";
        $result = $con->query($sql) or die($con->error);
        
        return $result;
    }
}