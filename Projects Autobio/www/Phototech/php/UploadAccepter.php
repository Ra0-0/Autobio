<? // Зашити файл!
  include "DbAdapter.php";
  $originalImagesUploadDir = '..//images-original/';
  $bigProImagesUploadDir = '..//images-big-pro/';
  $tinyProImagesUploadDir = '..//images-tiny-pro/';
  $bigImagesUploadDir = '..//images-big/';
  $tinyImagesUploadDir = '..//images-tiny/';

  $postNameAddCategory = "AddCategory";
  $postNameAddSubCategory = "AddSubCategory";
  $postNameImages = "Images";

  $categoryId;
  $subCategoryId;

  function checkForExistsTextValue($query, $postEl, $error, $dBConnection) {
    if ($value = $dBConnection -> connection -> query($query))
      while ($valueEl = mysqli_fetch_array($value)) {
        $clearValueElName = strtolower(str_replace(' ', '', $valueEl["name"]));
        $clearPostEl = strtolower(str_replace(' ', '', $postEl));
        if (empty($clearPostEl))
          die($error);
        if ($clearValueElName == $clearPostEl)
          return $valueEl["id"];
      } 
    else die("Error: No DB connection; ");
  }

  function addNewTextValue($postEl, $halfQuery, $dBConnection) {
      $valueData = $postEl;
      $clearValueData = mysqli_real_escape_string($dBConnection -> connection, $valueData);
      $halfQuery = $halfQuery . (string) $clearValueData . "');";
      $dBConnection -> insert($halfQuery);
      return mysqli_insert_id($dBConnection -> connection);
  }

  if (isset($_POST[$postNameAddCategory])) {
    $query = "SELECT * FROM `category`;";
    $categoryId = checkForExistsTextValue($query, $_POST[$postNameAddCategory], "Error: Category is empty; ", $dBConnection);
    if (!isset($categoryId)){
      $halfQuery = "INSERT INTO `category`(`name`) VALUES ('";
      $categoryId = addNewTextValue($_POST[$postNameAddCategory], $halfQuery, $dBConnection);
    }
  }

  if (isset($_POST[$postNameAddSubCategory])) {
    $query = "SELECT * FROM `subcategory`;";
    $subCategoryId = checkForExistsTextValue($query, $_POST[$postNameAddSubCategory], "Error: SubCategory is empty; ", $dBConnection);
    if (!isset($subCategoryId)){
      $halfQuery = "INSERT INTO `subcategory`(`name`) VALUES ('";
      $subCategoryId = addNewTextValue($_POST[$postNameAddSubCategory], $halfQuery, $dBConnection);
    }
  }

  function checkDeleteFile(string $fileName) {
    if(file_exists($fileName)){
      unlink($fileName);
    }
  }

  function loadingRise(float $loadingPart) {
    ob_start();
    $loadingJsonArray = array("Loading" => $loadingPart);
    $loadingJson = json_encode($loadingJsonArray);

    
    echo $loadingJson;
    
    ob_flush();
    flush();
    // to do : Обработчик сделать 
  }

  function resizeImage($imageName, $newImageName, $newWidth, $isInterlace) {
    list($width, $height) = getimagesize($imageName);
    $percent = $width / $newWidth;
    $newHeight = $height / $percent;
    $newImageFile = imagecreatetruecolor($newWidth, $newHeight);
    $originalImage = imagecreatefromjpeg($imageName);
    imagecopyresized($newImageFile, $originalImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
    imageinterlace($newImageFile, $isInterlace);
    imagejpeg($newImageFile, $newImageName);
    imagedestroy($originalImage);
  }

  if (isset($_FILES[$postNameImages]) && isset($subCategoryId) && isset($categoryId)) {
    $fileCount = count($_FILES[$postNameImages]['name']);
      for ($i = 0; $i < $fileCount; $i++){
        $dateTime = date('Y-m-d H:i:s');
        $query = "INSERT INTO `images`(`category_id`, `subcategory_id`, `addition_time`) VALUES ('" . $categoryId . "','" . $subCategoryId . "','" . $dateTime . "');";
        $dBConnection -> insert($query);
        $imageId = mysqli_insert_id($dBConnection -> connection);
        $identifierFileName = md5($dateTime) . md5($imageId) . ".jpg";
        $clearIdentifierFileName = mysqli_real_escape_string($dBConnection -> connection, $identifierFileName);
        $originalImagesUploadFileName = $originalImagesUploadDir . $clearIdentifierFileName;
        $bigProImagesUploadFileName = $bigProImagesUploadDir . $clearIdentifierFileName;
        $tinyProImagesUploadFileName = $tinyProImagesUploadDir . $clearIdentifierFileName;
        $bigImagesUploadFileName = $bigImagesUploadDir . $clearIdentifierFileName;
        $tinyImagesUploadFileName = $tinyImagesUploadDir . $clearIdentifierFileName;
        try {
          if (move_uploaded_file($_FILES[$postNameImages]['tmp_name'][$i], $originalImagesUploadFileName)) {
            loadingRise((float) ($i + 0.5) / $fileCount);
            resizeImage($originalImagesUploadFileName, $bigProImagesUploadFileName, 1440, true);
            resizeImage($originalImagesUploadFileName, $tinyProImagesUploadFileName, 256, true);
            resizeImage($originalImagesUploadFileName, $bigImagesUploadFileName, 1440, false);
            resizeImage($originalImagesUploadFileName, $tinyImagesUploadFileName, 256, false);
            throw new Exception(); // Удалить чтобы работало
          }
          else {
            throw new Exception();
          }
          $query = "UPDATE `images` SET `path`='" . $clearIdentifierFileName . "' WHERE id = " . $imageId . ";";
          $dBConnection -> insert($query);
        }catch(Exception $e){
          // echo("Error: " . $e . "; <br>");
          $query = "DELETE FROM `images` WHERE id = " . $imageId . ";";
          $dBConnection -> insert($query);
          checkDeleteFile($originalImagesUploadFileName);
          checkDeleteFile($bigProImagesUploadFileName);
          checkDeleteFile($tinyProImagesUploadFileName);
          checkDeleteFile($bigImagesUploadFileName);
          checkDeleteFile($tinyImagesUploadFileName);
        }
        loadingRise((float) ($i + 1) / $fileCount);
      }
    }else{ 
    echo("Error: No images found; <br>");
  }
  
?>