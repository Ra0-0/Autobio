 <?
  include "DbAdapter.php";
  ob_end_flush();
  ob_start();
  echo "21";
  ob_flush();
  flush();
  sleep(1);
  echo "41";
  ob_flush();
  flush();
?>
<!-- <!DOCTYPE html> 
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet/less" type="text/css" href="..//css-less/Style.less">
  <link rel="stylesheet" type="text/css" href="..//css-less/bootstrap.min.css">
  <title>Document</title>
</head>

  <body>

    <div class="uploader d-flex justify-content-center align-items-center flex-column">

      <p class="uploader__description">It's console with answers for many questions.</p>
      <div class="uploader__console console row"></div>
      <progress class="uploader__progress-bar" value="0" max="1"></progress>

      <form id="picture-uploader-form" class="uploader__form d-flex justify-content-center flex-column align-items-center">
        <input name ="img-input" id="file-input" type="file" class="uploader__hidden-upload-area" multiple/>
        <label for="file-input" class="uploader__upload-area d-flex flex-column">
          <svg class="uploader__vector-upload" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M37.888 22.224C37.014 15.34 31.12 10 24 10C18.488 10 13.7 13.222 11.514 18.3C7.218 19.584 4 23.64 4 28C4 33.514 8.486 38 14 38H36C40.412 38 44 34.412 44 30C43.9969 28.2072 43.3933 26.4672 42.2854 25.0577C41.1775 23.6482 39.6293 22.6505 37.888 22.224V22.224ZM26 28V34H22V28H16L24 18L32 28H26Z" fill="black"/>
          </svg>
          Drag & Drop here!</label>
         
        <div class="uploader__drop-down-list-box drop-down-list-box">
          <div class="drop-down-list-box__text-area-box">
            <input list="AddCategory" type="text" class="drop-down-list-box__text-area drop-down-list-box__text-area_category" placeholder="Category"/>
            <div class="drop-down-list-box__vector-box drop-down-list-box__vector-box_category">
              <svg class="drop-down-list-box__vector-more" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12.4425 6.4425L9 9.8775L5.5575 6.4425L4.5 7.5L9 12L13.5 7.5L12.4425 6.4425Z" fill="white"/>
              </svg>
            </div>
          </div>
          <div class="drop-down-list-box__hidden drop-down-list-box__hidden_category">
            <div class="drop-down-list-box__hidden-box drop-down-list-box__hidden-box_category">
                <?
                  $query = "SELECT * FROM `category`;";
                  if ($category = $dBConnection -> connection -> query($query))
                    while ($categoryEl = mysqli_fetch_array($category)) {
                      echo '<div class="drop-down-list-box__hidden-item drop-down-list-box__hidden-item_category">' . $categoryEl["name"] . '</div>';
                    }
                ?>
            </div>
          </div>
        </div>

                    
        <div class="uploader__drop-down-list-box drop-down-list-box">
          <div class="drop-down-list-box__text-area-box">
            <input list="AddSubCategory" type="text" class="drop-down-list-box__text-area drop-down-list-box__text-area_sub-category" placeholder="SubCategory"/>
            <div class="drop-down-list-box__vector-box drop-down-list-box__vector-box_sub-category">
              <svg class="drop-down-list-box__vector-more" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12.4425 6.4425L9 9.8775L5.5575 6.4425L4.5 7.5L9 12L13.5 7.5L12.4425 6.4425Z" fill="white"/>
              </svg>
            </div>
          </div>
          <div class="drop-down-list-box__hidden drop-down-list-box__hidden_sub-category">
            <div class="drop-down-list-box__hidden-box drop-down-list-box__hidden-box_sub-category">
                <?
                  $query = "SELECT * FROM `subcategory`;";
                  if ($subCategory = $dBConnection -> connection -> query($query))
                    while ($subCategoryEl = mysqli_fetch_array($subCategory)) {
                      echo '<div class="drop-down-list-box__hidden-item drop-down-list-box__hidden-item_sub-category">' . $subCategoryEl["name"] . '</div>';
                    }
                ?>
            </div>
          </div>
        </div>

        <input type="submit" value="Upload" class="uploader__submit-button"/>
      </form>

      <p class="uploader__description">There will be U'r imgs before uploading.</p>
      <div class="uploader__temporary-image-box temporary-image-box row">

      </div>
    </div>

  </body>

  <script src="..//js/less.min.js" type="text/javascript"></script>
  <script src="..//js/jquery-3.6.0.min.js" type="text/javascript"></script>
  <script src="..//js/bootstrap.min.js" type="text/javascript"></script>
  <script src="..//js/Uploader.js" type="text/javascript"></script>
</html>
Зашити файл! -->