<?php 
    function connect() {
        include_once '../config.php';

        // Connecting to mysql database
        $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        // Check for database connection error
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        // returing connection resource
        return $conn;
    }

    $conn = connect();

    function getAlleasy($SQL, $conn){
        $q = $conn->query($SQL) or die("Failed");
        while ($r = $q->FETCH_ASSOC()){
            $data[] = $r;
        }
        return $data;
    }

    function easyqueary($query, $conn) {
        $r = $conn->prepare($query);
        $r->execute();
        $message = $r->fetch(PDO::FETCH_ASSOC);
        return $message;
    }

    $cid = 1;

    $qActual = getAlleasy("SELECT qid FROM questions WHERE course_id = '$cid'", $conn);
    print_r( $qActual['qid'] );


    public function SQLUpdate($table,$fields,$values,$where) {
          $buildSQL = '';
          if (is_array($fields)) {
                foreach($fields as $key => $field) :
                if ($key == 0) {
                    $buildSQL .= $field.' = ?';
                } else {
                    $buildSQL .= ', '.$field.' = ?';
                }
                endforeach;
          } else {
                $buildSQL .= $fields.' = :value';
          }
         
          $prepareUpdate = $this->conn->prepare('UPDATE '.$table.' SET '.$buildSQL.'WHERE '.$where);

          if (is_array($values)) {
            $prepareUpdate->execute($values);
          } else {
            $prepareUpdate->execute(array(':value' => $values));
          }

          $error = $prepareUpdate->errorInfo();
          if ($error[1]){ 
            return $error;
          }
    }
//END: SQLUpdate