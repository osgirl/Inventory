jQuery('td select').change(function(){
	jQuery('form').submit();
});
jQuery('td input[type="checkbox"]').change(function(){
	jQuery('form').submit();
});