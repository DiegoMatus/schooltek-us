$(window).load( function()
{
	$('footer').load('footer_copy.html');
	const FOOTER_INDEX_CONTENT = 'footer-index-content';
	const FOOTER_CONTENT = 'footer-content';

	var footer_index_values = {
		'logo-footer'	: {
			'data-hash'	: '#home',
			'href'		: 'index.html#home'
		}
	}

	var footer_values = {
		'logo-footer'	: {
			'data-hash'	: '#home',
			'href'		: 'index.html#home'
		}
	}

	function loadValues()
	{
		console.log("Cargando valores...");
		var footer = $('footer');
		var values = null;
		if ( footer.hasClass( FOOTER_CONTENT )) {
			console.log("Se cargarán valores para " + FOOTER_CONTENT);
			values = generateValues(FOOTER_CONTENT);
		}else if ( footer.hasClass( FOOTER_INDEX_CONTENT )) {
			console.log("Se cargarán valores para " + FOOTER_INDEX_CONTENT);
			values = generateValues(FOOTER_INDEX_CONTENT);
		}
		setValues(values);
	}

	function generateValues(context)
	{
		return (context == FOOTER_INDEX_CONTENT) 
				? footer_index_values : footer_values;
	}

	function setValues(values)
	{
		$.each( values, function(id, properties) {
			console.log("Valores a llenar para " + id + ": " + JSON.stringify(properties));
			console.log($('#logo-footer'));
			$('#'+id).attr(properties);
		});
	}

	loadValues();

});