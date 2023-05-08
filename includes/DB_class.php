<?php
class Database{
    const DB_HOST='localhost';
    const DB_USER="phpuser";
    const DB_PASSWORD="Iti123456";
    const DB_DATABASE="cafeteria_db";
    
// ------------------------------(( Connect ))
   static function connect(){
        try {
            $dsn ='mysql:dbname=cafeteria_db;host=127.0.0.1;port=3306;';
            $db = new PDO($dsn, self::DB_USER, self::DB_PASSWORD);
            return $db;


    
        } catch (Exception $e) {
            echo $e->getMessage();
         }
    } 
    //  -----------------------------------(( Select ))
   static function select($table_name){
    try {
        $db=self::connect();
        if($db){
    $query = "select * from  `cafeteria_db`.`$table_name`;";
    $select_stmt = $db->prepare($query);
    $res=$select_stmt->execute();
    $data = $select_stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h1 class='text-primary'>These are all data<h1/>";
echo "add new user<a href='../admin/add_user_form.php'><img width='50rem' src='../images/add.png' /></a>";
    echo "<table class='table'><tr class='text-primary'><th>ID<th/><th>Name<th/><th>Email<th/>
    <th>Password<th/><th>Room_no<th/><th>Ext<th/><th>Image<th/>
    <th>Action<th/> <tr/>";
//    <th>Created_at<th/><th>Updated_at<th/>

    foreach($data as $row){
        echo "<tr>";
        foreach($row as $field){
            if($field=='admin.png'){
                echo "<td><img src='../images/$field'/></td>";
                break;
            }else{ echo "<td>$field<td/>";}
        }
        echo "<td><a href='editForm.php?id=$row[id]' class='btn btn-warning'>edit<a/><td/>";
        echo "<td><a href='delete.php?id=$row[id]' class='btn btn-danger'>delete<a/><td/>";
        echo "<tr/>";
    }
    echo "<table/>";
}
} catch (Exception $e) {
echo $e->getMessage();
}
}
// -------------------------------- get_user_by_email
static function get_user_by_email($table_name,$userEmail){
    try {
        $db=self::connect();
        if($db){
    $query = "select * from  `cafeteria_db`.`$table_name` where email='${userEmail}';";
    $select_stmt = $db->prepare($query);
    $res=$select_stmt->execute();
    $data = $select_stmt->fetch(PDO::FETCH_ASSOC);
    return $data;
        }
    } catch (Exception $e) {
        echo $e->getMessage();
        }
    }
// ----------------------------------------(( Insert ))
static function insert($table_name,$name,$email,$password,$room,$ext,$image){
    $db=self::connect();
    if($db){
$queryInsert="Insert into `cafeteria_db`.`$table_name`(name,email,password,room_no,ext,profile_picture)values(?,?,?,?,?,?);";
$insert_stmt = $db->prepare($queryInsert);
$insert_stmt->execute(["$name","$email","$password","$room","$ext","$image"]);
$res= $insert_stmt->rowCount();
$id=$db->lastInsertId();

echo "<h1>data inserted successfully</h1>";

}
}
    // -------------------------------------(( Delete ))
    static function delete($table_name,$id){
        try{
            $db=self::connect();
            if($db){
                $query = "delete from `cafeteria_db`.`$table_name` where id=$id";
            $select_stmt = $db->prepare($query);
            $res=$select_stmt->execute();
        
                if($select_stmt->rowCount()){
                    echo "<h1>data <span class='fs-3 bg-success text-danger'>deleted</span> successfully</h1>";
        
                }
        
            }
        
        }catch(Exception $e){
            echo $e->getMessage();
        }
        
        }
            // -------------------------------------(( Update ))
    static function update($table_name,$id,$name,$email,$password,$room,$ext,$image){
        $db=self::connect();
        if($db){
            $select_query= "update `cafeteria_db`.`$table_name`  set `name`=:name, `email`=:email ,
            `password`=:password,`room_no`=:room,`ext`=:ext,
            `profile_picture`=:profile_picture  where id=:id";
            $stmt = $db->prepare($select_query);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->bindParam(':room', $room, PDO::PARAM_INT);
            $stmt->bindParam(':ext', $ext, PDO::PARAM_STR);
            $stmt->bindParam(':profile_picture', $image, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $res = $stmt->execute();
    
            if($stmt->rowCount()){
                echo "<h1>data <span class='fs-3 bg-success text-warning'>updated</span> successfully</h1>";
    
            }
    
        }}
}