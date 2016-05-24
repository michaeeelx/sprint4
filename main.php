<?php
   include("config.php");
   $error = "";
   session_start();
   
   function exportToCSV(){
$db = mysqli_connect("127.0.0.1", "root", "", "sppmdatabase");

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=exported-data.csv');

//select table to export the data
$select_table=mysqli_query($db,'select * from Products');
$rows = mysqli_fetch_assoc($select_table);

if ($rows)
{
getcsv(array_keys($rows));
}
while($rows)
{
getcsv($rows);
$rows = mysqli_fetch_assoc($select_table);
}

// get total number of fields present in the database


}
function getcsv($no_of_field_names)
{
$separate = '';


// do the action for all field names as field name
foreach ($no_of_field_names as $field_name)
{
if (preg_match('/\\r|\\n|,|"/', $field_name))
{
$field_name = '' . str_replace('', $field_name) . '';
}
echo $separate . $field_name;

//sepearte with the comma
$separate = ',';
}

//make new row and line
echo "\r\n";
}
   
   function Delete(&$get){
   $link = mysqli_connect("127.0.0.1", "root", "", "sppmdatabase");
   $ID=$get['ID'];
   $sql = "DELETE FROM Products WHERE ID = $ID";
   if (mysqli_query($link, $sql)) { 
    
    return true; 
} else {
    $message =  "WRONG VALUES";
echo "<script type='text/javascript'>alert('$message');</script>";
return false;
}

}
function Data(&$get, &$name){
   $link = mysqli_connect("127.0.0.1", "root", "", "sppmdatabase");
   $ID=$get['ID'];
   $result =mysqli_query($link,"SELECT * FROM Products Where ID=$ID");
   $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
   return $row[$name];

}

function ChangeData(&$Name, &$QTY, &$sold, &$get){
   $link = mysqli_connect("127.0.0.1", "root", "", "sppmdatabase");
   $ID=$get['ID'];
   $sql = "UPDATE Products SET Product='$Name', Quantity='$QTY', Sold='$sold' WHERE ID= '$ID' ";
   if (mysqli_query($link, $sql)) {
      header('Location: welcome.php' );
       $error = "Updated"; 
   } else {
    $message =  "WRONG VALUES";
   echo "<script type='text/javascript'>alert('$message');</script>";
   //echo $sql;
}
   //$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
   //header(string)
      //return $row['Name'];
}

function Grabuser(&$id){
      $link = mysqli_connect("127.0.0.1", "root", "", "sppmdatabase");
      $result = mysqli_query($link,"SELECT * FROM Users where ID='$id'");
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      return $row['Name'];
   }
   
   function grabid(&$id){
      $link = mysqli_connect("127.0.0.1", "root", "", "sppmdatabase");
      $result = mysqli_query($link,"SELECT * FROM Users where Name='$id'");
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      return $row['ID'];
   }
   
   function addingaproduct(&$data, &$uid){
      $db = mysqli_connect("127.0.0.1", "root", "", "sppmdatabase");

      $userid = grabid($uid);
      $p=$data['PName'];
      $q=$data['QTY'];
      $d=$data['DAdded'];
      $sql = "INSERT INTO Products (`ID`, `Product`, `User ID`, `Quantity`, `Date`) VALUES (NULL, '$p', '$userid', '$q', '$d');";

      if (mysqli_query($db, $sql)) {
    $message = "ADDED Into the Database";
echo "<script type='text/javascript'>alert('$message');</script>";
} else {
    $message =  "Please check the entered values";
echo "<script type='text/javascript'>alert('$message');</script>";
//echo $sql;
} 

   }
?>
