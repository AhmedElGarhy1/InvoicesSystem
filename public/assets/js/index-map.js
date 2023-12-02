$(function(e){
  'use strict'

	$('#vmap').vectorMap({
		map: 'world_en',
		backgroundColor: 'transparent',
		color: '#ffffff',
		hoverOpacity: 0.7,
		selectedColor: '#666666',
		enableZoom: true,
		showTooltip: true,
		scaleColors: ['#BC8DB9','#7550f6'],
		values: sample_data,
		normalizeFunction: 'polynomial'
	});

});