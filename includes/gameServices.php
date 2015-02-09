<?php namespace gameServices;
require './alterraDB.php';

/**
 * Returns information about all the armies of a player
 * @param $return_json: if set to false, it will return result in php format
 */
function GetAllArmies($player_id, $return_json = true)
{
    $conn =  GetDB();
    $sqlQuery = "SELECT id, soldiers_alive, dmg_min, dmg_max, sprite_path from armies a WHERE a.id_player = " .$player_id;

    $result = $conn->query($sqlQuery);
    
    $output = null;
    
    if($result->num_rows > 0)
    {
        $output = array();
        $output['length'] = $result->num_rows;
        $output['armies'] = array();
        while($row = $result->fetch_assoc())
        {
            $output['armies'][] = $row;
        }
    }
    $conn->close();
    if($return_json == true)
    {
        return json_encode ($output);
    }
    return $output;
}

/**
 * Returns only IDs of all the armies of a player
 * @param $return_json: if set to false, it will return result in php format
 */
function GetAllArmiesIDs($player_id, $return_json = true)
{
    $conn =  GetDB();
    $sqlQuery = "SELECT id from armies a WHERE a.id_player = " .$player_id;

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

/**
 * Returns information of a given army
 * @param $return_json: if set to false, it will return result in php format
 */
function GetArmy($army_id, $return_json = true)
{
    $conn =  GetDB();
    $sqlQuery = "SELECT soldiers_alive, dmg_min, dmg_max, sprite_path FROM armies a WHERE a.id = " .$army_id;
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
$MAX_PARAMS = 3;

if (!isset($_GET) || empty($_GET)) {
    die("Parameters missing.");
}
$queryType = $_GET['q'];

if(!is_numeric($queryType))
{
    die("queryType should be numeric");
}

$parameters = array($MAX_PARAMS);

for($i=0; $i < $MAX_PARAMS; $i++)
{
    $parameters[$i] = -1;
}

$index = 0;
while($index < $MAX_PARAMS)
{
    $parameter = 'param'.($index+1);
    
    if(isset($_GET[$parameter]))
    {
        $parameters[$index] = $_GET[$parameter];
    }
    $index++;
}

switch ((int)$queryType)
{
    case 0:
        echo \gameServices\GetAllArmies($parameters[0]);
        break;
    case 1:
        echo \gameServices\GetAllArmiesIDs($parameters[0]);
        break;
    case 2:
        echo \gameServices\GetArmy($parameters[0]);
        break;
}



