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
				var fieldName = $input.data('field') || $input.attr('data-field');
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
		var $templateEl = $repeater.find('.vcpc-repeater-template');
		var templateHtml = $templateEl.html();
		// Some browsers/contexts may return empty for <template>. Try native DOM fallback.
		if ( ! templateHtml && $templateEl.length && $templateEl[0].content ) {
			templateHtml = $templateEl[0].innerHTML || $templateEl[0].content.innerHTML || '';
		}
		
		var nextIndex = $rowsContainer.find('.vcpc-repeater-row').length;
		var rowHtml = templateHtml.replace(/__INDEX__/g, nextIndex);
		
		if ( ! rowHtml ) {
			if ( window.console ) console.error( 'vcpc repeater: template HTML empty' );
			return;
		}
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

	// Gallery Field Handlers
	function updateGalleryInput($galleryField) {
		var ids = [];
		$galleryField.find('.vcpc-gallery-thumbnails .vcpc-gallery-item').each(function() {
			var id = $(this).data('id');
			if (id) {
				ids.push(id);
			}
		});
		$galleryField.find('.vcpc-gallery-ids').val(ids.join(',')).trigger('change');
		var $clearBtn = $galleryField.find('.vcpc-gallery-clear-btn');
		if (ids.length > 0) {
			$clearBtn.show();
		} else {
			$clearBtn.hide();
		}
	}

	function initGallerySortable() {
		$('.vcpc-gallery-thumbnails').sortable({
			items: '.vcpc-gallery-item',
			cursor: 'grab',
			placeholder: 'vcpc-gallery-placeholder',
			update: function(event, ui) {
				var $galleryField = ui.item.closest('.vcpc-gallery-field');
				updateGalleryInput($galleryField);
			}
		});
	}

	initGallerySortable();

	$(document).on('click', '.vcpc-gallery-upload-btn', function(e) {
		e.preventDefault();
		var $btn = $(this);
		var $galleryField = $btn.closest('.vcpc-gallery-field');
		var $thumbnails = $galleryField.find('.vcpc-gallery-thumbnails');

		var frame = wp.media({
			title: 'Select Gallery Images',
			button: { text: 'Add to Gallery' },
			multiple: true,
			library: { type: 'image' }
		});

		frame.on('select', function() {
			var selection = frame.state().get('selection');
			selection.each(function(attachment) {
				var data = attachment.toJSON();
				var imgUrl = (data.sizes && data.sizes.thumbnail) ? data.sizes.thumbnail.url : data.url;
				
				// Avoid duplicate if already exists
				if ($thumbnails.find('.vcpc-gallery-item[data-id="' + data.id + '"]').length === 0) {
					var itemHtml = '<div class="vcpc-gallery-item" data-id="' + data.id + '">' +
						'<img src="' + imgUrl + '" />' +
						'<button type="button" class="vcpc-gallery-remove-btn" title="Remove Image">&times;</button>' +
						'</div>';
					$thumbnails.append(itemHtml);
				}
			});

			updateGalleryInput($galleryField);
			initGallerySortable();
		});

		frame.open();
	});

	$(document).on('click', '.vcpc-gallery-remove-btn', function(e) {
		e.preventDefault();
		var $item = $(this).closest('.vcpc-gallery-item');
		var $galleryField = $item.closest('.vcpc-gallery-field');
		$item.remove();
		updateGalleryInput($galleryField);
	});

	$(document).on('click', '.vcpc-gallery-clear-btn', function(e) {
		e.preventDefault();
		var $galleryField = $(this).closest('.vcpc-gallery-field');
		$galleryField.find('.vcpc-gallery-thumbnails').empty();
		updateGalleryInput($galleryField);
	});
});

