/*++++++++++防止转义字符造成的bug++++++++++*/
function escapeSequenceAway(keyword)
{
	var EscapeSequence = '\\';
	var keylength = keyword.length;

	while ( keyword.lastIndexOf(EscapeSequence) == (keyword.length-1) )
	{
		keylength = keyword.length;
		keyword = keyword.substring(0, keylength-1);
	}

	return keyword;
}
/*==========防止转义字符造成的bug==========*/

function search_function_sindex()
{
	var sindex = 1;
	var keyword = $('#search-form-search-input').val();
/*++++++++++防止转义字符造成的bug++++++++++*/
	if ( keyword.length > 0 )
	{
		keyword = escapeSequenceAway(keyword);
	}
	
/*==========防止转义字符造成的bug==========*/
	var hash = window.location.hash;
	var URL = window.location.href;
	if (URL.indexOf("#key") == -1)
	{
		sindex = 1;
	}
	else
	{
		var index = URL.split("sindex=");
		sindex = index[1];
	}
	window.location.href = "detail.php?keyword="+keyword+"&sindex="+sindex;
}

function update_search_category(keyword, sindex) 
{
	var url = 'search/detail.php?keyword='+keyword+'&sindex='+sindex;
	visit(url);
}