var pathname = window.location.protocol + "//" + window.location.host + "/";


function likers(id)
{
	$.ajax({
		type: "POST",
		url: pathname+"home/likers",
		cache: false,
		data:{ph_id : id},
		success: function(data){
			if(data)
			{
				$(".announceDisplay").show();
				$(".announce").css({'top':$(window).scrollTop()});
				$("html").css({'overflow':'hidden'});
				$(".announce .announceDiv .msg").html("<span>"+data+"</span>");
			}
		}
	});
}

function error(errId)
{
	array = new Array();
	array['1'] = 'Unexpected error when trying to follow, please try again later. We are sorry for the inconvenience.';
	array['2'] = 'You have already followed this person.';
	array['3'] = 'Unexpected error. Please try again later.';
	array['4'] = "You weren't following the user.";
	array['5'] = 'Unexpected error, please try again later. We are sorry for the inconvenience.';
	array['6'] = 'Picture file bigger than 5Mb, please choose a photo less than 5Mb.';
	array['7'] = 'Wrong file format, please upload a jpeg,png or gif file. Keep in mind that photos should be less than 5Mb.';
	array['8'] = "You don't have the required privileges to do that.";
	array['9'] = 'Unexpected error, please try again later. We are sorry for the inconvenience.';
	array['10'] = 'Picture file bigger than 5Mb, please choose a photo less than 5Mb.';
	array['11'] = 'Wrong file format, please upload a jpeg,png or gif file. Keep in mind that photos should be less than 5Mb.';
	array['12'] = "You don't have the required privileges to do that.";
	array['13'] = "Please type a comment before hitting enter.";
		
	//alert(errId);
	$(".announceDisplay").show();
	$(".announce").css({'top':$(window).scrollTop()});
	$("html").css({'overflow':'hidden'});
	$(".announce .announceDiv .msg").append("<span>"+array[errId]+"</span>");

}
function updatepicture(pic)
{
	if (pic!='9' && pic!='10' && pic!='11' && pic!='12' && pic!='13')
	{
		pic = $.parseJSON(pic);
		document.getElementById("profilePic").setAttribute("src",pic['1']);
		document.getElementById("dragimg").setAttribute("src",pic['2']);
	}
	else
	{
		error(pic);
	}
}
function updateupload(pic,id)
{

	if (pic!='5' && pic!='6' && pic!='7' && pic!='8')
	{
		document.getElementById("img1").setAttribute("src",pic);
		$(".uploadedImg").last().show();
		$(".uploadedImg").last().find(".photoDescription").attr("baseID",id);
		$(".uploadedImg").last().find(".photoOptions").attr("baseID",id);
		$(".uploadedImg").last().find("#img1").removeAttr("id");
		$(".photosHolder").find(".uploadedImg").last().after("<div class='uploadedImg'><img id='img1' src='#'><div class='photoOptions'><div class='edit'><img title='Edit photo description' src='../public/cuts/edit-icon.png'></div></div><div class='photoDescription' baseID='#'><div class='triangle'></div><textarea type='text' class='leaveDescription' name='comment' >Write a photo description...</textarea><div class='sendDescription' title='Save description'>Save</div></div></div>");

	}
	else
	{
		error(pic);
	}
}

//liking photo
function likePhoto(object,id)
{

	$.ajax({
		type: "POST",
		url: pathname+"home/likePhoto",
		cache: false,
		data:{id : id},
		success: function(data){
			if(data == "Succesful")
			{
				$(object).attr("src",pathname+"public/cuts/winked.png");
				$(object).attr("onclick","dislikePhoto(this,"+id+")");
				$(object).attr("title","Dislike");
				$(object).parent().parent().parent().find('.likesCount').text(parseInt($(object).parent().parent().parent().find('.likesCount').text()) + 1);
			}
		}
	});
}

function dislikePhoto(object,id)
{
	$.ajax({
		type: "POST",
		url: pathname+"home/dislikePhoto",
		cache: false,
		data:{id : id},
		success: function(data){
			if(data == "Succesful")
			{
				$(object).attr("src",pathname+"public/cuts/wink.png");
				$(object).attr("onclick","likePhoto(this,"+id+")");
				$(object).attr("title","Like");
				$(object).parent().parent().parent().find('.likesCount').text(parseInt($(object).parent().parent().parent().find('.likesCount').text()) - 1);
			}
		}
	});
}


//polling new data
function addmsg(dataRet){
	$('.noNotifications').remove();
	var howMany = 0;
	$.each( dataRet, function( key, value ) {
		if(key == "count")
		{
			$(".notificationCount").css({'display':'inline-block'});
			if($('.notificationCount').text().length >= 1)
				howMany = parseInt($('.notificationCount').text());
			else
				howMany = 0;
			$(".notificationCount").text("");
			$(".notificationCount").append(dataRet[key]+howMany);
		}
		else
		{
			$(".notificationWindowInnerUl").prepend(dataRet[key].link);
		}
	});
}

function notificationUpdate(){
	$.ajax({
		type: "POST",
		url: pathname+"home/poll_aj",
		cache: false,
		timeout:50000, /* Timeout in ms */

		success: function(data){ /* called when request completes */
			if(data != 'err')
			{
				data =  $.parseJSON(data);
				//console.log(data);
				addmsg(data);/* Add response to a .msg div (with the "new" class)*/
			}
			setTimeout(
				notificationUpdate, /* Request next message */
				10 /* ..after 1 seconds */
			);
		},
		error: function(XMLHttpRequest, textStatus, errorThrown){
			addmsg("error", textStatus + " (" + errorThrown + ")");
			setTimeout(
				notificationUpdate, /* Try again after.. */
				15000); /* milliseconds (15seconds) */
		}
	});
};

