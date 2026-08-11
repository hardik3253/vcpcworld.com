jQuery(document).ready(function($) {
	'use strict';

	// Helper to re-index ids and serialize fields
	function serializeRepeater($repeater) {
		var rows = [];
		$repeater.find('.vcpc-repeater-rows .vcpc-repeater-row').each(function(rowIndex) {
			var rowData = {};
			var $row = $(this);
			
			// Re-index attributes for accessibility and consistency
			$row.attr('data-index', rowIndex);
			
			$row.find('.vcpc-repeater-input').each(function() {
				var $input = $(this);
				var fieldName = $input.attr('data-anim') || $input.data('field');
				if (!fieldName) {
					fieldName = $input.attr('data-field');
				}
				var val = $input.val();
				rowData[fieldName] = val;

				// Update id and label for
				var newId = $repeater.data('field-name') + '_' + rowIndex + '_' + fieldName;
				$input.attr('id', newId);
				$input.closest('.vcpc-repeater-field-wrapper').find('label').attr('for', newId);
			});
			rows.push(rowData);
		});

		var jsonStr = JSON.stringify(rows);
		$repeater.find('.vcpc-repeater-value').val(jsonStr);
	}

	// Init sortable on all repeaters
	function initSortable() {
		$('.vcpc-repeater-rows').sortable({
			handle: '.vcpc-repeater-drag-handle',
			placeholder: 'vcpc-repeater-row-placeholder',
			axis: 'y',
			update: function(event, ui) {
				var $repeater = ui.item.closest('.vcpc-repeater');
				serializeRepeater($repeater);
			}
		});
	}

	initSortable();

	// Add row event
	$(document).on('click', '.vcpc-repeater-add-row', function(e) {
		e.preventDefault();
		var $repeater = $(this).closest('.vcpc-repeater');
		var $rowsContainer = $repeater.find('.vcpc-repeater-rows');
		var templateHtml = $repeater.find('.vcpc-repeater-template').html();
		
		var nextIndex = $rowsContainer.find('.vcpc-repeater-row').length;
		var rowHtml = templateHtml.replace(/__INDEX__/g, nextIndex);
		
		var $newRow = $(rowHtml);
		$rowsContainer.append($newRow);
		
		serializeRepeater($repeater);
		initSortable();
	});

	// Delete row event
	$(document).on('click', '.vcpc-repeater-delete-row', function(e) {
		e.preventDefault();
		var $row = $(this).closest('.vcpc-repeater-row');
		var $repeater = $row.closest('.vcpc-repeater');
		$row.remove();
		serializeRepeater($repeater);
	});

	// Input changes serialize
	$(document).on('input change', '.vcpc-repeater-input', function() {
		var $repeater = $(this).closest('.vcpc-repeater');
		serializeRepeater($repeater);
	});

	// Media Uploader
	$(document).on('click', '.vcpc-media-upload-btn', function(e) {
		e.preventDefault();
		var $btn = $(this);
		var $uploader = $btn.closest('.vcpc-media-uploader');
		var $input = $uploader.find('.vcpc-media-id');
		var $preview = $uploader.find('.vcpc-media-preview');
		var $removeBtn = $uploader.find('.vcpc-media-remove-btn');
		
		var frame = wp.media({
			title: 'Select or Upload Media',
			button: { text: 'Use this media' },
			multiple: false
		});

		frame.on('select', function() {
			var attachment = frame.state().get('selection').first().toJSON();
			$input.val(attachment.id).trigger('change');
			
			if (attachment.sizes && attachment.sizes.thumbnail) {
				$preview.html('<img src="' + attachment.sizes.thumbnail.url + '" />');
			} else {
				$preview.html('<div class="vcpc-media-file-preview">' + attachment.filename + '</div>');
			}
			$removeBtn.show();
		});

		frame.open();
	});

	$(document).on('click', '.vcpc-media-remove-btn', function(e) {
		e.preventDefault();
		var $btn = $(this);
		var $uploader = $btn.closest('.vcpc-media-uploader');
		$uploader.find('.vcpc-media-id').val('').trigger('change');
		$uploader.find('.vcpc-media-preview').empty();
		$btn.hide();
	});

	// Single Image/Media Uploader (for non-repeater fields)
	$(document).on('click', '.vcpc-single-media-upload-btn', function(e) {
		e.preventDefault();
		var $btn = $(this);
		var targetId = $btn.data('target');
		var $input = $('#' + targetId);
		var $preview = $('#' + targetId + '-preview');
		var $removeBtn = $('[data-remove-target="' + targetId + '"]');

		var frame = wp.media({
			title: 'Select or Upload Media',
			button: { text: 'Use this media' },
			multiple: false
		});

		frame.on('select', function() {
			var attachment = frame.state().get('selection').first().toJSON();
			$input.val(attachment.id).trigger('change');
			
			if (attachment.sizes && attachment.sizes.thumbnail) {
				$preview.html('<img src="' + attachment.sizes.thumbnail.url + '" style="max-width:150px; height:auto; display:block; margin-bottom:10px;" />');
			} else {
				$preview.html('<div style="margin-bottom:10px;">' + attachment.filename + '</div>');
			}
			$removeBtn.show();
		});

		frame.open();
	});

	$(document).on('click', '.vcpc-single-media-remove-btn', function(e) {
		e.preventDefault();
		var $btn = $(this);
		var targetId = $btn.data('remove-target');
		$('#' + targetId).val('').trigger('change');
		$('#' + targetId + '-preview').empty();
		$btn.hide();
	});
});
