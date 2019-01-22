<?php
isset($_GET['id']) ? $id = $_GET['id'] : exit('error');
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
require '../tools/modelTextures.php';

$modelList = new modelList();
$modelTextures = new modelTextures();

$id = explode('-', $id);
$modelId = (int)$id[0];
$modelTexturesId = isset($id[1]) ? (int)$id[1] : false;

$modelName = $modelList->id_to_name($modelId);
$modelTexturesList = is_array($modelName) ? ['textures' => $modelName] : $modelTextures->get_list($modelName);

if (count($modelTexturesList['textures']) <= 1) {
    $modelTexturesNewId = 1;
} else {
    $modelTexturesGenNewId = true;
    if ($modelTexturesId == 0) $modelTexturesId = 1;
    while ($modelTexturesGenNewId) {
        $modelTexturesNewId = rand(0, count($modelTexturesList['textures'])-1)+1;
        $modelTexturesGenNewId = $modelTexturesNewId == $modelTexturesId ? true : false;
    }
}

header("Content-type: application/json");
header('Access-Control-Allow-Origin:*');  
echo json_encode(array('textures' => array(
    'id' => $modelTexturesNewId,
    'name' => $modelTexturesList['textures'][$modelTexturesNewId-1],
    'model' => is_array($modelName) ? $modelName[$modelTexturesNewId-1] : $modelName
)), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
