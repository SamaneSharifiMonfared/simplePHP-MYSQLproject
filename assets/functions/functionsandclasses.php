<?php

class sqlConnection{

// Methods
    function mysql_fetch($conn,$query)
    {
        $rows=[];
        $result = $conn->query($query);

        //Fetching all the rows of the result
        $rows = mysqli_fetch_all($result);

        return $rows;

    }

}


