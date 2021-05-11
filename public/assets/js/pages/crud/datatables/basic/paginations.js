"use strict";
var KTDatatablesBasicPaginations = function () {

	var initTable1 = function () {
		var table = $('.kt_table_1');
		// begin first table
		table.DataTable({
			responsive: true,
			pagingType: 'full_numbers',
			columnDefs: [

				{
					responsivePriority: 1,
					targets: 0
				},
				{
					responsivePriority: 2,
					targets: -1
				},
			],

		});
	};
	var initTable2 = function () {
		var table = $('#kt_table_2');
		// begin first table
		table.DataTable({
			responsive: true,
			pagingType: 'full_numbers',
			columnDefs: [

				{
					responsivePriority: 1,
					targets: 0
				},
				{
					responsivePriority: 2,
					targets: -1
				},
			],

		});
	};
	return {

		//main function to initiate the module
		init: function () {
			initTable1();
			initTable2();
		}

	};

}();


jQuery(document).ready(function () {
	KTDatatablesBasicPaginations.init();
});
