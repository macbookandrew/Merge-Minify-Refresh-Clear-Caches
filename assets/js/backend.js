(function($){
	$('document').ready(function(){
		$('#mmr-cc-force-clear').on('click', function() {
			$.ajax({
				url: ajaxurl,
				method: 'post',
				data: {
					action: 'mmrcc_purge_caches',
					isAjax: true
				}
			})
			.always(function(data) {
				$('.results').html(data);
			});
		});
	});
})(jQuery);
