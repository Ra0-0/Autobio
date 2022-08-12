var dropZone = $('#picture-uploader-form');

let i = 0;
let temporaryStorage = new Map();

$("#file-input").change(function() {
  let files = this.files;
  for (let file of files) {
    createTemporaryImageBoxItem(file, i++);
  }
});

dropZone.on('drag dragstart dragend dragover dragenter dragleave drop', function(){
  return false;
});

dropZone.on('dragover dragenter', function() {
  dropZone.addClass('draged');
});

dropZone.on('dragleave', function(e) {
  let dx = e.pageX - dropZone.offset().left;
  let dy = e.pageY - dropZone.offset().top;
  if ((dx < 0) || (dx > dropZone.width()) || (dy < 0) || (dy > dropZone.height())) {
       dropZone.removeClass('draged');
  };
});

dropZone.on('drop', function(e) {
  dropZone.removeClass('draged');
  const files = [...e.originalEvent.dataTransfer.items].map(item => item.getAsFile());
  for (let file of files) {
    createTemporaryImageBoxItem(file, i++);
  }
});

let temporaryImageBox = ".temporary-image-box";

function isJson(json) {
  try {
      JSON.parse(json);
  } catch (e) {
      return false;
  }
  return true;
}

function createTemporaryImageBoxItem(file, i) {
  if (file.type.match(/^image/)) {
    temporaryStorage.set(String(i), file);
    
    let reader = new FileReader();
    reader.onload = (file) => {
      let imageSrc = file.target.result;
      let temporaryImageBox_content = 
        `<div class="temporary-image-box__item">
          <img class="temporary-image-box__image" src="${imageSrc}"/>
          <div class="temporary-image-box__hidden-delete-box" data-temporary-storage-id="${i}">
            <svg class="temporary-image-box__hidden-delete-vector" width="24" height="24" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M5.22678 5.22678C5.27903 5.17439 5.3411 5.13283 5.40944 5.10448C5.47778 5.07612 5.55104 5.06152 5.62503 5.06152C5.69902 5.06152 5.77228 5.07612 5.84062 5.10448C5.90895 5.13283 5.97103 5.17439 6.02328 5.22678L9.00003 8.20465L11.9768 5.22678C12.0291 5.17448 12.0912 5.13299 12.1595 5.10469C12.2278 5.07639 12.3011 5.06182 12.375 5.06182C12.449 5.06182 12.5222 5.07639 12.5906 5.10469C12.6589 5.13299 12.721 5.17448 12.7733 5.22678C12.8256 5.27908 12.8671 5.34117 12.8954 5.4095C12.9237 5.47783 12.9382 5.55107 12.9382 5.62503C12.9382 5.69899 12.9237 5.77223 12.8954 5.84056C12.8671 5.90889 12.8256 5.97098 12.7733 6.02328L9.7954 9.00003L12.7733 11.9768C12.8256 12.0291 12.8671 12.0912 12.8954 12.1595C12.9237 12.2278 12.9382 12.3011 12.9382 12.375C12.9382 12.449 12.9237 12.5222 12.8954 12.5906C12.8671 12.6589 12.8256 12.721 12.7733 12.7733C12.721 12.8256 12.6589 12.8671 12.5906 12.8954C12.5222 12.9237 12.449 12.9382 12.375 12.9382C12.3011 12.9382 12.2278 12.9237 12.1595 12.8954C12.0912 12.8671 12.0291 12.8256 11.9768 12.7733L9.00003 9.7954L6.02328 12.7733C5.97098 12.8256 5.90889 12.8671 5.84056 12.8954C5.77223 12.9237 5.69899 12.9382 5.62503 12.9382C5.55107 12.9382 5.47783 12.9237 5.4095 12.8954C5.34117 12.8671 5.27908 12.8256 5.22678 12.7733C5.17448 12.721 5.13299 12.6589 5.10469 12.5906C5.07639 12.5222 5.06182 12.449 5.06182 12.375C5.06182 12.3011 5.07639 12.2278 5.10469 12.1595C5.13299 12.0912 5.17448 12.0291 5.22678 11.9768L8.20465 9.00003L5.22678 6.02328C5.17439 5.97103 5.13283 5.90895 5.10448 5.84062C5.07612 5.77228 5.06152 5.69902 5.06152 5.62503C5.06152 5.55104 5.07612 5.47778 5.10448 5.40944C5.13283 5.3411 5.17439 5.27903 5.22678 5.22678Z" fill="white"/>
            </svg>
          </div>
        </div>`;
      $(temporaryImageBox).append(temporaryImageBox_content);
    }

    reader.readAsDataURL(file);
  }
}

let temporaryImageBoxItem = ".temporary-image-box__item";
$(temporaryImageBox).on('mouseenter', temporaryImageBoxItem, function() {
  $(".temporary-image-box__hidden-delete-box", this).css({"visibility" : "visible"});
});
$(temporaryImageBox).on('mouseleave', temporaryImageBoxItem, function() {
  $(".temporary-image-box__hidden-delete-box", this).css({"visibility" : "hidden"});
});

$(temporaryImageBox).on('click', ".temporary-image-box__hidden-delete-vector", function() {
  let hiddenDeleteBox = $(this).parent();
  let deleteId = hiddenDeleteBox.attr('data-temporary-storage-id');
  temporaryStorage.delete(deleteId);
  hiddenDeleteBox.parent().remove();
});

// $(document).ready(function () {
//   $('.uploader__form').submit(function (e) {
//     e.preventDefault();
//     $.ajax({
//       type: "POST",
//       url: '..//php/AjaxAccepter.php',
//       data: $(this).serialize(),
//       success: function (response) {
//         alert(response);
//       },
//       error: function(XMLHttpRequest, textStatus, errorThrown) {
//         alert(errorThrown);
//       }
//     });

//     return false;
//   });
// });
let uploaderConsole = $(".uploader__console");

function customConsolePrint(message) {
  let consoleText = `<p class="console__item">${new Date().toLocaleTimeString()}: ${message}</p>`;
  uploaderConsole.append(consoleText);
  uploaderConsole.scrollTop(uploaderConsole.prop('scrollHeight'));
}

function inputDataSet(listEl, inputEl){
  $(listEl).click(function(e) {
    $(inputEl).val($(this).text());
  })
}

function dataListController(trigger, hiddenEl) {
  $(document).click(function(e) {
    if ($(e.target).closest(trigger).length) {
        $(hiddenEl).css({"visibility" : "visible"});
        return;
    }

    $(hiddenEl).css({"visibility" : "hidden"});
  });
}

function inputVariableShow(inputEl, elementArray, elementBox) {
  $(inputEl).on("change keyup paste", function(){
    $(elementArray).each(function (index, el) {
      let clearInputVal = $(inputEl).val().replace(/\s+/g, '').toLowerCase();
      let clearDataEl = $(el).text().replace(/\s+/g, '').toLowerCase();
      $(elementBox).css({"visibility" : "visible"}); 
      if (clearInputVal.length == 0)
        $(el).css({"display" : "block"}); 
      if (clearDataEl.startsWith(clearInputVal, 0)) {
        $(el).css({"display" : "block"});  
        return;
      }
      $(el).css({"display" : "none"});
    });
  })
}

function checkForNewOneDataListEl(inputVal, elementArray, elementBox) {
  let isCategoryElExists = false;
  let newValue = `<div class="drop-down-list-box__hidden-item drop-down-list-box__hidden-item_category">${inputVal}</div>`;

  $(elementArray).each(function (index, el){
    if($(el).text().replace(/\s+/g, '').toLowerCase() == inputVal.replace(/\s+/g, '').toLowerCase())
      isCategoryElExists = true;
  });

  if (!isCategoryElExists)
    $(elementBox).append(newValue)
}

$(document).ready(function () {
  $('#picture-uploader-form').submit(function (e) {

    let formData = new FormData();
    for (let el of temporaryStorage.values()) {
      formData.append("Images[]", el);
    }

    let uploaderTextAreaCategoryText = $('.drop-down-list-box__text-area_category').val();
    let uploaderTextAreaSubCategoryText = $('.drop-down-list-box__text-area_sub-category').val();
      
    if(!uploaderTextAreaCategoryText.replace(/\s+/g, '').toLowerCase().length == 0 && 
    !uploaderTextAreaSubCategoryText.replace(/\s+/g, '').toLowerCase().length == 0){
      temporaryStorage.clear();
      $(temporaryImageBox).empty();
    }

    checkForNewOneDataListEl(uploaderTextAreaCategoryText, ".drop-down-list-box__hidden-item_category", ".drop-down-list-box__hidden-box_category");
    checkForNewOneDataListEl(uploaderTextAreaSubCategoryText, ".drop-down-list-box__hidden-item_sub-category", ".drop-down-list-box__hidden-box_sub-category");

    formData.append("AddCategory", uploaderTextAreaCategoryText);
    formData.append("AddSubCategory", uploaderTextAreaSubCategoryText);

    e.preventDefault();
    $.ajax({
      type: "POST",
      url: '..//php/UploadAccepter.php',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (isJson(response)) {
          customConsolePrint("yes");
          // let loading = JSON.parse(response);
          // $(".uploader__progress-bar").value += loading.Loading;
        }
        else 
          customConsolePrint(response);
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        customConsolePrint(errorThrown);
      }
    });

    return false;
  });

  inputDataSet(".drop-down-list-box__hidden-item_category", ".drop-down-list-box__text-area_category");
  inputDataSet(".drop-down-list-box__hidden-item_sub-category", ".drop-down-list-box__text-area_sub-category");
  dataListController(".drop-down-list-box__vector-box_category", ".drop-down-list-box__hidden_category");
  dataListController(".drop-down-list-box__vector-box_sub-category", ".drop-down-list-box__hidden_sub-category");
  inputVariableShow(".drop-down-list-box__text-area_category", ".drop-down-list-box__hidden-item_category", ".drop-down-list-box__hidden_category");
  inputVariableShow(".drop-down-list-box__text-area_sub-category", ".drop-down-list-box__hidden-item_sub-category", ".drop-down-list-box__hidden_sub-category");
});
