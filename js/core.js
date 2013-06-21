$(document).ready(function(){
	console.log(imgURL);
	var imageArray = new Array();
	imageArray.push(imgURL);
	console.log("HEllo");

	for (i = 0; i < imageArray.length; i ++) {
			$('.imageSlider').css('background-image', 'url("' + imageArray[i] + '")');
} delay()

});
