<?php

class DbHandler {

    private $conn;

    function __construct() {
        require_once 'dbConnect.php';
        // opening db connection
        $db = new dbConnect();
        $this->conn = $db->connect();
    }

    /**
     * Fetching single record
     */
    public function getOneRecord($query) {
        $r = $this->conn->query($query.' LIMIT 1') or die($this->conn->error.__LINE__);
        return $result = $r->fetch_assoc();
    }
    /**
     * Fetching all record
     */
    public function getAllRecords($query) {
        $r = $this->conn->prepare($query);
        $r->execute();
        $tasks = $r->get_result();
        $r->close();
        return $tasks;
    }
    /**
     * Creating new record
     */
    public function insertIntoTable($obj, $column_names, $table_name) {

        $c = (array) $obj;
        $keys = array_keys($c);
        $columns = '';
        $values = '';
        foreach($column_names as $desired_key){ // Check the obj received. If blank insert blank into the array.
           if(!in_array($desired_key, $keys)) {
                $$desired_key = '';
            }else{
                $$desired_key = $c[$desired_key];
            }
            $columns = $columns.$desired_key.',';
            $values = $values."'".$$desired_key."',";
        }
        $query = "INSERT INTO ".$table_name."(".trim($columns,',').") VALUES(".trim($values,',').")";

        $r = $this->conn->query($query) or die($this->conn->error.__LINE__);

        if ($r) {
            $new_row_id = $this->conn->insert_id;
            return $new_row_id;
            } else {
            return NULL;
        }
    }
    /**
     * Update  a record
     */
    public function updateTable($columnsArray, $table, $where) {

            $a = array();
            $w = "";
            $c = "";
            foreach ($where as $key => $value) {
                $w .= " and " .$key. " = '".$value."' "; //equivalent to $w = " and $key = '$value' ";
            }
            foreach ($columnsArray as $key => $value) {
                $c .= $key. " = '".$value."', "; //equivalent to $c = key = 'value'
            }
                $c = rtrim($c,", ");


            $query = "UPDATE $table SET $c WHERE 1=1 ".$w;

            $r = $this->conn->query($query) or die($this->conn->error.__LINE__);

            if($r){
                $response = "success";
            }else{
                $response = NULL;
            }

        return $response;
    }

    /**
     * Delete  a record
     */
    public function deleteTable($table, $where) {

            $w = "";
            foreach ($where as $key => $value) {
                $w .= " and " .$key. " = '".$value."' ";
            }

            $query = "DELETE FROM $table WHERE 1=1 ".$w;

            $r = $this->conn->query($query) or die($this->conn->error.__LINE__);

            if($r){
                $response = "success";
            }else{
                $response = NULL;
            }

        return $response;
    }
    /**
     * Function to store admin details when logged in
     */
public function getSession(){
    if (!isset($_SESSION)) {
        session_start();
    }
    $sess = array();
    if(isset($_SESSION['_id']))
    {
        $sess["_id"] = $_SESSION['_id'];
        $sess["username"] = $_SESSION['username'];
        $sess["email"] = $_SESSION['email'];
        $sess["firstname"] = $_SESSION['firstname'];
        $sess["lastname"] = $_SESSION['lastname'];
        $sess["createdAt"] = $_SESSION['createdAt'];
    }
    else
    {
        $sess["_id"] = '';
        $sess["username"] = 'Guest';
        $sess["email"] = '';
        $sess["firstname"] = '';
        $sess["lastname"] = '';
        $sess["createdAt"] = '';
    }
    return $sess;
}

/**
     * Function to store student details when logged in
     */
public function getStuSession(){
    if (!isset($_SESSION)) {
        session_start();
    }
    $sess = array();
    if(isset($_SESSION['_id']))
    {
        $sess["_id"] = $_SESSION['_id'];
        $sess["username"] = $_SESSION['username'];
        $sess["fullName"] = $_SESSION['fullName'];
        $sess["level"] = $_SESSION['level'];
        $sess["department"] = $_SESSION['department'];
        $sess["reg_number"] = $_SESSION['reg_number'];
    }
    else
    {
        $sess["_id"] = '';
        $sess["username"] = '';// or u can set this to guest if u want to allow guest mode...depending on the type of app
        $sess["fullName"] = '';
        $sess["level"] = '';
        $sess["department"] = '';
        $sess["reg_number"] = '';
    }
    return $sess;
}

//function to retrieve the exam data from session

public function getExamSession(){
    if (!isset($_SESSION)) {
        session_start();
    }

    $sess = array();
    if(isset($_SESSION['examData'])){
        foreach ($_SESSION['examData'] as $key => $value) {
            $sess['examData'][$key] = $value;
        }
    } else {
        foreach ($_SESSION['examData'] as $key => $value) {
            $sess['examData'][$key] = '';
        }
    }

    return $sess;
}

//clear exam session

public function clearExamSession(){
    if(!isset($_SESSION)){
        session_start();
    }

    if(isset($_SESSION['examData'])){
        foreach ($_SESSION['examData'] as $key => $value) {
            unset($_SESSION['examData'][$key]);
        }
        return true;
    } else {
        return false;
    }
}


/**
     * Function to store admin/staff details when logged in
     */
public function getAdminSession(){
    if (!isset($_SESSION)) {
        session_start();
    }
    $sess = array();
    if(isset($_SESSION['admin_id']))
    {
        $sess["admin_id"] = $_SESSION['admin_id'];
        $sess["admin_username"] = $_SESSION['admin_username'];
        $sess["admin_fullName"] = $_SESSION['admin_fullName'];
        $sess["admin_active"] = $_SESSION['admin_active'];
        $sess["admin_access"] = $_SESSION['admin_access'];
        $sess["admin_course"] = $_SESSION['admin_course'];
    }
    else
    {
        $sess["admin_id"] = '';
        $sess["admin_username"] = '';// or u can set this to guest if u want to allow guest mode...depending on the type of app
        $sess["admin_fullName"] = '';
        $sess["admin_active"] = '';
        $sess["admin_access"] = '';
        $sess["admin_course"] = '';
    }
    return $sess;
}

public function destroyStuSession(){
    if (!isset($_SESSION)) {
    session_start();
    }
    if(isSet($_SESSION['_id']))
    {
        unset($_SESSION['_id']);
        unset($_SESSION['username']);
        unset($_SESSION['fullName']);
        unset($_SESSION['level']);
        unset($_SESSION['reg_number']);
        unset($_SESSION['department']);
        unset($_SESSION['active']);
        $info='info';
        if(isSet($_COOKIE[$info]))
        {
            setcookie ($info, '', time() - $cookie_time);
        }
        $msg="Logged Out Successfully...";
    }
    else
    {
        $msg = "Not logged in...";
    }
    return $msg;
}

/*public function destroySession(){
    if (!isset($_SESSION)) {
    session_start();
    }
    if(isSet($_SESSION['_id']))
    {
        unset($_SESSION['_id']);
        unset($_SESSION['username']);
        unset($_SESSION['email']);
        unset($_SESSION['firstname']);
        unset($_SESSION['lastname']);
        unset($_SESSION['createdAt']);
        $info='info';
        if(isSet($_COOKIE[$info]))
        {
            setcookie ($info, '', time() - $cookie_time);
        }
        $msg="Logged Out Successfully...";
    }
    else
    {
        $msg = "Not logged in...";
    }
    return $msg;
}*/
    public function destroyAdminSession(){
    if (!isset($_SESSION)) {
    session_start();
    }
    if(isSet($_SESSION['admin_id']))
    {
        unset($_SESSION['admin_id']);
        unset($_SESSION['admin_username']);
        unset($_SESSION['admin_fullName']);
        unset($_SESSION['admin_active']);
        unset($_SESSION['admin_access']);
        unset($_SESSION['admin_course']);
        $info='info';
        if(isSet($_COOKIE[$info]))
        {
            setcookie ($info, '', time() - $cookie_time);
        }
        $msg="Logged Out Successfully...";
    }
    else
    {
        $msg = "Not logged in...";
    }
    return $msg;
}
}

?>
