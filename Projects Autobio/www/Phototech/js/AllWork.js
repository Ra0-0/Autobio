$(document).ready(function () {
	let jsonGetAll = {
		category: "",
		subCategory: "",
		lastId: ""
	};
	$.ajax({
		url: '..//php/ImagesApi.php',        
		method: 'get',             
		dataType: 'html',          
		data: jsonGetAll,     
		success: function(data){         
		}
	});
});