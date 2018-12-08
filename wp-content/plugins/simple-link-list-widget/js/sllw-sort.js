jQuery(document).ready(function($) {
	if(!$('body').hasClass('widgets_access')){
		sllwSetupList($);
		$('.sllw-edit-item').addClass('toggled-off');
		sllwSetupHandlers($);
	}
	
	$(document).ajaxSuccess(function() {
		sllwSetupList($);
		$('.sllw-edit-item').addClass('toggled-off');
	});
	
});

function sllwSetupList($){
	$( ".simple-link-list" ).sortable({
		items: '.list-item',
		opacity: 0.6,
		cursor: 'n-resize',
		axis: 'y',
		handle: '.moving-handle',
		placeholder: 'sortable-placeholder',
		start: function (event, ui) {
			ui.placeholder.height(ui.helper.height());
		},
		update: function() {
			updateOrder($(this));
		}
	});
	
	$( ".simple-link-list .moving-handle" ).disableSelection();
}


// All Event handlers
function sllwSetupHandlers($){
	
	$("body").on('click.sllw','.sllw-delete',function() { 
		$(this).parent().parent().fadeOut(500,function(){
			$('.item-title',this).trigger("change"); // Trigger change to enable widget save button
			var sllw = $(this).parents(".widget-content");
			$(this).remove();
			sllw.find('.order').val(sllw.find('.simple-link-list').sortable('toArray'));
			var num = sllw.find(".simple-link-list .list-item").length;
			var amount = sllw.find(".amount");
			amount.val(num);
		});
	});
	
	$("body").on('click.sllw','.sllw-add',function() { 
		var sllw = $(this).parent().parent();
		var num = sllw.find('.simple-link-list .list-item').length + 1;
		
		sllw.find('.amount').val(num);
		
		var item = sllw.find('.simple-link-list .list-item:last-child').clone();
		var item_id = item.prop('id');
		item.prop('id',increment_last_num(item_id));

		$('.toggled-off',item).removeClass('toggled-off');
		$('.number',item).html(num);
		$('.item-title',item).html('');
		
		$('label',item).each(function() {
			var for_val = $(this).prop('for');
			$(this).prop('for',increment_last_num(for_val));
		});
		
		$('input',item).each(function() {
			var id_val = $(this).prop('id');
			var name_val = $(this).prop('name');
			$(this).prop('id',increment_last_num(id_val));
			$(this).prop('name',increment_last_num(name_val));
			if($(this).is(':checkbox')){
				$(this).prop('checked', false);
			}else {
				$(this).val('');
			}
			
		});
		
		sllw.find('.simple-link-list').append(item);
		sllw.find('.order').val(sllw.find('.simple-link-list').sortable('toArray'));
	});
	
	$('body').on('click.sllw','.moving-handle', function() {
		$(this).parent().find('.sllw-edit-item').slideToggle(200);
	} );
}

function increment_last_num(v) {
    return v.replace(/[0-9]+(?!.*[0-9])/, function(match) {
        return parseInt(match, 10)+1;
    });
}

function updateOrder(self){
	var sllw = self.parents(".widget-content");
	sllw.trigger("change"); // Trigger change to enable widget save button
	sllw.find('.order').val(sllw.find('.simple-link-list').sortable('toArray'));
}