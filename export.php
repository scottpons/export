<?php
/*******EDIT LINES 3-8*******/
$DB_Server = "localhost"; //MySQL Server    
$DB_Username = ""; //MySQL Username     
$DB_Password = "";             //MySQL Password     
$DB_DBName = "";         //MySQL Database Name  
$DB_TBLName = "User"; //MySQL Table Name   
$filename = "StudentScores";         //File Name

/*******YOU DO NOT NEED TO EDIT ANYTHING BELOW THIS LINE*******/    
//create MySQL connection   
$sql = "Select * from $DB_TBLName";
$Connect = mysqli_connect($DB_Server, $DB_Username, $DB_Password) or die("Couldn't connect to MySQL:<br>" . mysqli_error() . "<br>" . mysqli_errno());
//select database   
$Db = mysqli_select_db($Connect,$DB_DBName) or die("Couldn't select database:<br>" . mysqli_error(). "<br>" . mysqli_errno());   
//execute query 
$result = mysqli_query($Connect,$sql) or die("Couldn't execute query:<br>" . mysqli_error(). "<br>" . mysqli_errno());    
$file_ending = "xls";
//header info for browser
header("Content-Type: application/xls");    
header("Content-Disposition: attachment; filename=$filename.xls");  
header("Pragma: no-cache"); 
header("Expires: 0");
/*******Start of Formatting for Excel*******/   
//define separator (defines columns in excel & tabs in word)
$sep = "\t"; //tabbed character
//start of printing column names as names of MySQL fields
$names=mysqli_fetch_assoc($result);
if($names!=NULL){
    $columns=array_keys($names);
    for ($i = 0; $i < mysqli_num_fields($result); $i++) {
    echo  $columns[$i] . "\t";
    }
    print("\n");    
    //end of printing column names  
    //start while loop to get data
        while($row = mysqli_fetch_row($result))
        {
            $schema_insert = "";
            for($j=0; $j<mysqli_num_fields($result);$j++)
            {
                if(!isset($row[$j]))
                    $schema_insert .= "NULL".$sep;
                elseif ($row[$j] != "")
                    $schema_insert .= "$row[$j]".$sep;
                else
                    $schema_insert .= "".$sep;
            }
            $schema_insert = str_replace($sep."$", "", $schema_insert);
            $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
            $schema_insert .= "\t";
            print(trim($schema_insert));
            print "\n";
        }   
}
else{
    print "NO DATA";
}
?>
