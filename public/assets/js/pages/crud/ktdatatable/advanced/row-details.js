"use strict";
// Class definition

var KTDatatableAutoColumnHideDemo = function() {
	// Private functions

	// basic demo
	var demo = function() {

		var datatable = $('#kt_datatable').KTDatatable({
			// datasource definition
			

			layout: {
				scroll: false
			},

			// column sorting
			sortable: true,

			pagination: true,

			search: {
				input: $('#kt_datatable_search_query'),
				key: 'generalSearch'
			},

			// columns definition
			columns: [
				],

		});

		$('#kt_datatable_search_status').on('change', function() {
			datatable.search($(this).val().toLowerCase(), 'Status');
		});

		$('#kt_datatable_search_type').on('change', function() {
			datatable.search($(this).val().toLowerCase(), 'Type');
		});

		$('#kt_datatable_search_status, #kt_datatable_search_type').selectpicker();
	};

	return {
		// public functions
		init: function() {
			demo();
		},
	};
}();

jQuery(document).ready(function() {
	KTDatatableAutoColumnHideDemo.init();
});
