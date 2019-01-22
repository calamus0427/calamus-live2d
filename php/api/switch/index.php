<?php
isset($_GET['id']) ? $modelId = (int)$_GET['id'] : exit('error');
// $origin = isset($_SERVER['HTTP_ORIGIN'])? $_SERVER['HTTP_ORIGIN'] : '';  
  
// $allow_origin = array(  
//     'https://www.calamus.xyz',  
//     'https://www.cnblogs.com/calamus',
//     'https://calamus0427.github.io/'  
// );  
  
// if(in_array($origin, $allow_origin)){  
//     header('Access-Control-Allow-Origin:'.$origin);       
// }
require '../tools/modelList.php';

$modelList = new modelList();

$modelList = $modelList->get_list();
$modelSwitchId = $modelId + 1;
if (!isset($modelList['models'][$modelSwitchId-1])) $modelSwitchId = 1;

header("Content-type: application/json");
header('Access-Control-Allow-Origin:*');  
echo json_encode(array('model' => array(
    'id' => $modelSwitchId,
    'name' => $modelList['models'][$modelSwitchId-1],
    'message' => $modelList['messages'][$modelSwitchId-1]
)), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
