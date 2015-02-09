<?php namespace web;
require './alterraDB.php';

/**
 * Returns information about all the armies of a player
 * @param $return_json: if set to false, it will return result in php format
 */
function GetAllAvatars($return_json = false)
{
    $conn = GetDB();
    $sqlQuery = "SELECT * "
            . "FROM "
            . "student s LEFT JOIN avatar a on s.player_id = a.id_player JOIN "
            . "resources r on s.player_id = r.id_player";
    $result = $conn->query($sqlQuery);
    
    $output = null;
    
    if($result->num_rows > 0)
    {
        $output = array();
        while($row = $result->fetch_assoc())
        {
            $output[] = $row;
        }
    }
    $conn->close();
    
    if($return_json == true)
    {
        return json_encode ($output);
    }
    return $output;
}
?>

<?php
/*
var_dump(\game\GetArmy('1'));

*/