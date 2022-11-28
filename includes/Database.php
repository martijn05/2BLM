<?php
    function connectWithDatabase()
    {
        // //credentials Lina
        $dbServername = "127.0.0.1:8899";
        $dbUsername = "root";
        $dbPassword = "root";
        $dbName = "imslab";

        // //credentials Brent
        // $dbServername = "127.0.0.1";
        // $dbUsername = "root";
        // $dbPassword = "root";
        // $dbName = "imslab";

        //credentials Online
        // $dbServername = "brentatweb.be.mysql";
        // $dbUsername = "brentatweb_be2blm";
        // $dbPassword = "LinaBasBrentMartijn0831622TM2800";
        // $dbName = "brentatweb_be2blm";

        //make connection
        $conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);

        if ($conn == false) {
            //stop met php code
            die("Connection failed");
        }

        return $conn;
    }

    function closeConnection($connection)
    {
        $connection->close();
    }

    function getQuery($sql)
    {
        $conn = connectWithDatabase();
        $items = mysqli_query($conn, $sql);
        closeConnection($conn);
        return $items->fetch_all(MYSQLI_ASSOC);
    }

    function insertQuery($sql)
    {
        $conn = connectWithDatabase();
        $status = mysqli_query($conn, $sql);
        closeConnection($conn);
        return $status;
    }

// $username = "";
// $email = "";
// $errors = array();

// $servername = "jhtstoveke.be.mysql";
// $username = "jhtstoveke_beimslab";
// $password = "IMSLab5R48B66L";
// $dbname = "jhtstoveke_beimslab";

// // Create connection
// $conn = new mysqli($servername, $username, $password, $dbname);

// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }