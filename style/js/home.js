$('.search').on('keydown', function(e){
  return ! e.key.match(/[-!$%^&*()_+|~=`{}[:;<>?,.@#\]]/g) == true;
  
});

$('.search').on('change, blur', function(){
  $(this).val($(this) .val().replace(/[-!$%^&*()_+|~=`{}[:;<>?,.@#\]]/g, ""));
});
$(document).ready(function()
{
	$('body').on('click','.btnsearch',function(){
		if($('.search').val().length > 0)
		{
			$('.startsearch').submit();
		}
	});
	$('body').on('submit','.startsearch',function(e)
	{
		if(!($('.search').val().length > 0))
		{
			e.preventDefault();
		}
	})
});
