<?php
$hname = 'localhost';
$uname = 'root';
$pass = '';
$db = 'redison';

$con = mysqli_connect($hname, $uname, $pass, $db);

if (!$con) {
    die("Cannot connect to database" . mysqli_connect_error());
}

function filteration($data)
{
    foreach ($data as $key => $value) {
        $data[$key] = trim($value);
        $data[$key] = stripslashes($value);
        $data[$key] = htmlspecialchars($value);
        $data[$key] = strip_tags($value);
    }
    return $data;

}
function select($sql, $values, $datatypes)
{
    $con = $GLOBALS['con'];
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_get_result($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        } else {
            mysqli_stmt_close($stmt);

            die("Query cant be executed - SELECT");

        }


    } else {
        die("Query cant be prepared - SELECT");
    }

}

function update($sql, $values, $datatypes)
{
    $con = $GLOBALS['con'];
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        } else {
            mysqli_stmt_close($stmt);

            die("Query cant be executed - UPDATE");

        }

    } else {
        die("Query cant be prepared - UPDATE");
    }

}
function insert($sql, $values, $datatypes)
{
    $con = $GLOBALS['con'];
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        } else {
            mysqli_stmt_close($stmt);
            die("Query can't be executed - INSERT");
        }
    } else {
        die("Query can't be prepared - INSERT");
    }
}
function delete($sql, $values, $datatypes)
{
    $con = $GLOBALS['con'];
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        } else {
            mysqli_stmt_close($stmt);
            die("Query can't be executed - DELETE");
        }
    } else {
        die("Query can't be prepared - DELETE");
    }
}

function selectAll($table) {
    global $con;
    $sql = "SELECT * FROM $table";
    $result = mysqli_query($con, $sql);
    return $result;
}



?>