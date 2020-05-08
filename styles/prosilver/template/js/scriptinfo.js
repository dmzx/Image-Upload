function imageuploadClick(e){
	var src = $(e).find('img').attr('src');
	var title = $(e).find('img').attr('title');
	var info = $(e).find('img').attr('alt');
	var htmlText = "";
	if (imageUpload.imageupload_enable_direct_link == true)
	{
		htmlText = htmlText + '<input type="text" onclick="this.focus();this.select()" class="swal2-input" value=' + src + ' id="link" /><i class="buttoncopy" data-copytarget="#link">' + imageUpload.lang.copy + '</i>'
	};
	if (imageUpload.imageupload_enable_url_link == true)
	{
		htmlText = htmlText + '<input type="text" onclick="this.focus();this.select()" class="swal2-input" value=' + '[url=' + src + ']' + imageUpload.lang.uploadBy + '[/url]' + ' id="url" /><i class="buttoncopy" data-copytarget="#url">' + imageUpload.lang.copy + '</i>'
	};
	if (imageUpload.imageupload_enable_img_link == true)
	{
		htmlText = htmlText + '<input type="text" onclick="this.focus();this.select()" class="swal2-input" value=' + '[img]' + src + '[/img]' + ' id="img" /><i class="buttoncopy" data-copytarget="#img">' + imageUpload.lang.copy + '</i>'
	};
	if (imageUpload.imageupload_enable_url_img_link == true)
	{
		htmlText = htmlText + '<input type="text" onclick="this.focus();this.select()" class="swal2-input" value=' + '[url=' + src + ']' + '[img]' + src + '[/img]' + '[/url]' + ' id="urlimg" /><i class="buttoncopy" data-copytarget="#urlimg">' + imageUpload.lang.copy + '</i>'
	};

	swal.fire({
		title: title + '<br>' + info,
		html: htmlText,
		imageUrl: src,
		imageAlt: title,
		imageHeight: 150,
		customClass: 'imagealert',
		animation: true,
		confirmButtonText: imageUpload.lang.closed,
		confirmButtonColor: '#82c545',
	});
}
