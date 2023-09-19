<?php
class DB
{

    private $mysqli;
    private $host, $username, $password, $database;

    /**
     * Creates the mysql connection.
     * Kills the script on connection or database errors.
     * 
     * @param string $host
     * @param string $username
     * @param string $password
     * @param string $database
     * @return boolean
     */
    public function __construct($host, $username, $password, $database)
    {
        $this->host        = $host;
        $this->username    = $username;
        $this->password    = $password;
        $this->database    = $database;

        $this->mysqli = new mysqli($this->host, $this->username, $this->password)
            or die("There was a problem connecting to the database.");

        /* check connection */
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }

        $this->mysqli->select_db($this->database);

        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }

        return true;
    }

    /**
     * Prints the currently selected database.
     */
    public function print_database_name()
    {
        /* return name of current default database */
        if ($result = $this->mysqli->query("SELECT DATABASE()")) {
            $row = $result->fetch_row();
            printf("Selected database is %s.\n", $row[0]);
            $result->close();
        }
    }

    /**
     * On error returns an array with the error code.
     * On success returns an array with multiple mysql data.
     * 
     * @param string $query
     * @return array
     */
    public function query($query)
    {
        /* array returned, includes a success boolean */
        $return = array();

        if (!$result = $this->mysqli->query($query)) {
            $return['success'] = false;
            $return['error'] = $this->mysqli->error;

            return $return;
        }

        $return['success'] = true;
        $return['affected_rows'] = $this->mysqli->affected_rows;
        $return['insert_id'] = $this->mysqli->insert_id;

        if (0 == $this->mysqli->insert_id) {
            if (isset($result->num_rows)) {
                $return['count'] = $result->num_rows;
            } else {
                $return['count'] = 0;
            }
            $return['rows'] = array();
            /* fetch associative array */
            if (gettype($result) != "boolean"){
                while ($row = $result->fetch_assoc()) {
                    $return['rows'][] = $row;
                }
                $result->close();
            }
            /* free result set */
        }

        return $return;
    }

    public function query_update($query)
    {
        $return = array();

        if (!$this->mysqli->query($query)) {
            $return['success'] = false;
            $return['error'] = $this->mysqli->error;
        } else {
            $return['success'] = true;
            $return['affected_rows'] = $this->mysqli->affected_rows;
            $return['insert_id'] = $this->mysqli->insert_id;
        }

        return $return;
    }

    public function query_delete($query)
    {
        $return = array();

        if (!$this->mysqli->query($query)) {
            $return['success'] = false;
            $return['error'] = $this->mysqli->error;
        } else {
            $return['success'] = true;
            $return['affected_rows'] = $this->mysqli->affected_rows;
            $return['insert_id'] = $this->mysqli->insert_id;
        }

        return $return;
    }

    public function query_one($query)
    {
        /* array returned, includes a success boolean */
        $return = array();

        if (!$result = $this->mysqli->query($query)) {
            $return['success'] = false;
            $return['error'] = $this->mysqli->error;

            return $return;
        }

        $return['success'] = true;
        $return['affected_rows'] = $this->mysqli->affected_rows;
        $return['insert_id'] = $this->mysqli->insert_id;

        if (0 == $this->mysqli->insert_id) {
            $return['count'] = $result->num_rows;
            $return['rows'] = array();
            /* fetch associative array */
            while ($row = $result->fetch_row()) {
                // print_r($row);die;
                $return['rows'][] = $row;
            }

            /* free result set */
            $result->close();
        }

        return $return;
    }

    /**
     * Automatically closes the mysql connection
     * at the end of the program.
     */
    public function __destruct()
    {
        $this->mysqli->close()
            or die("There was a problem disconnecting from the database.");
    }
}
