function ramdompic() 
{

	var bgArray = ['bckgrnd1.jpg', 'bckgrnd2.jpg', 'bckgrnd3.jpg', 'bckgrnd4.jpg', 'bckgrnd5.jpg', 'bckgrnd6.jpg', 'bckgrnd7.jpg', 'bckgrnd8.jpg'];
	var bgpics = bgArray[Math.floor(Math.random() * bgArray.length)];


// If you have defined a path for the images
var path = 'img/bckgrndpics/';

$('body').css({'background-image' : 'url(' + path+bgpics + ')', 
'background-repeat': 'no-repeat',
'position': 'relative', 
'width' : '1000px' , 
'height' : '100px' , 
'center' : 'center' , 
//'maxWidth' : '100%' , 
//'left' : '100px' , 
//'backgroundPosition' : '100% 100%'
})
//alert(path+bgpics);
} 
