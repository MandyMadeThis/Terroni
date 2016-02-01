/*
 *	This script is for all admin client side logic
 */
(function($) {
	// POST -> POP!
	var popID = 2; // this is the id of the pop category
	var variantNormal = 'normal'; // this is the name of the variant that is regular
	
	// 2015-01-18 -> Now that we created post_categories, we'll need to fix the select tags
	var acfFieldsHide = ['franchise', 'set_series', 'exclusive_list'];
	var acfFieldsSingle = {'release_year' : 'release year', 'figure_size' : 'figure size', 'category' : 'category', 'franchise' : 'franchise', 'set_series' : 'set/series', 'character_status' : 'character status', 'custom_box' : 'custom box', 'variants' : 'variants', 'status' : 'status', 'exclusive_list' : 'exclusive list', 'event' : 'event'};
	
	// when a post is being published, we need to initially hack it
	$(document).on('click', '#publish', function(e){
		var postCat = $('#categorydiv');
		
		// only do this if "All POP!" category is selected
		var allPopCat = postCat.find('#in-category-'+popID);
		
		if(allPopCat.length>0 && allPopCat.prop('checked'))
		{
			// we need to auto-select "Normal" for variant, if none is selected
			var acfVariants = $('#acf-variants');
			var variantsVal = acfVariants.find('input[type="checkbox"]:checked');
			
			if(variantsVal.length==0) // need to find normal and select it
			{
				var tmpVariants = acfVariants.find('input[type="checkbox"]');
				
				tmpVariants.each(function(){
					var selectit = $(this).parent().clone();
					var inputVal = selectit.find('input').val();
					selectit.find('input').remove();
					selectit = $.trim(selectit.html().toLowerCase());
					
					if(selectit == variantNormal) // select normal
					{
						acfVariants.find('input[value="'+inputVal+'"]').prop('checked', true);
						return false;
					} // if
				});
			} // if
				
			var catVals = [];
			
			for(var key in acfFieldsSingle) // get the values so that we can mark the category
			{
				var acfObj = $('#acf-'+key);
			
				if(acfObj.length > 0) // check if the field is there
				{
					var inputChecked = acfObj.find('.acf-checkbox-list input:checked');
					
					if(inputChecked.length>0) // if there is checked values, then let's pick up the ids
					{
						inputChecked.each(function(){
							catVals.push($(this).val());
						});
					} // if
				} // if
			} // for
			
			postCat.find('input[type="checkbox"]').prop('checked', false);
			
			$.each(catVals, function(i, index){
				var obj = postCat.find('input[value="'+catVals[i]+'"]');
				obj.prop('checked', true);
			});
			
			postCat.find('input[value="'+popID+'"]').prop('checked', true); // always check POP!			
		} // if
	});
	
	// when we are selecting the "pop" category, we need to fix the view of the ACF
	$(document).on('click', '#categorydiv input[type="checkbox"]', function(e){
		var checked = $(this).is(':checked');
		
		if(checked && parseInt($(this).val()) == popID)
			setTimeout(function(){checkACFPublish()}, 1000)
	});
		
	// We need to hook Franchise and Set/Series so that it only shows the Category
	// For certain categories that have multiple franchises in it, it will show all franchises
	// Miscellaneous will always be shown
	
	// try to find this acf input
	var acfFields = {'franchise' : 'franchise', 'set_series' : 'set/series'};
	var showAllCat = ['freddy funko', 'giants', 'minis', 'miscellaneous', 'rides', 'wreck-it ralph'];
	var catMisc = 'miscellaneous';
	
	// if this change, we need to change the checkbox list for franchise and set/series
	$(document).on('change', '#acf-category .acf-checkbox-list input[type="radio"]', function(){
		setCategoryListView(false);
	});

	// if this change, we need to change the set/series
	$(document).on('change', '#acf-franchise .acf-checkbox-list input[type="checkbox"]', function(){
		setSeriesListView(false);
	});
	
	// if this change, we need to show or hide the exclusive list
	$(document).on('change', '#acf-status .acf-checkbox-list input[type="checkbox"]', function(){
		setExclusiveListView(false);
	});
	
	setACFFields();
	setCategoryListView(true);
	setExclusiveListView(true);
	
	// sets the category list view based on the category selected
	// @param		_init			true - function called on init, false - otherwise
	function setCategoryListView(_init)
	{
		// get the value of the category
		var categoryObj = $('#acf-category .acf-checkbox-list input[type="radio"]:checked');
		var showAll = false;
		
		if(categoryObj.length > 0)
		{
			var selectit = categoryObj.parent().clone();
			selectit.find('input').remove();
			var categoryName = $.trim(selectit.html().toLowerCase());
			
			$.each(showAllCat, function(i, index){
				if(showAllCat[i] == categoryName) // check if we need to show all categories
				{
					showAll = true;
					return false;
				} // if
			});			
		} // if
		
		for(var key in acfFields)
		{
			var currentItem = acfFields[key];
			
			if(categoryObj.val() !== undefined) // need to show the fields
			{
				var obj = $('#acf-'+key);
				
				var checkboxList = obj.find('.acf-checkbox-list .selection-list'); // this has the checklist
				
				if(showAll) // remove all hideObj
					checkboxList.find('.pop-sel').removeClass('hideObj');
				else // must only show the category
				{
					checkboxList.find('.pop-sel').addClass('hideObj'); // hide all.
					checkboxList.find('.pop-sel[data-cat-id="'+categoryObj.val()+'"]').removeClass('hideObj');					
				} // if
				
				// if user changes category, we need to make sure all values are removed
				if(!_init)
					obj.find('.acf-checkbox-list input[type="checkbox"]').prop('checked', false);
				
				obj.show();
			} // if
		} // for
		
		/*
		// we need to show/hide for character status
		if(categoryObj.val() !== undefined) // need to show the fields
		{
			var categoryStatus = ['marvel', 'heroes'];
			
			var categoryClone = categoryObj.parent().clone();
			categoryClone.find('input').remove();
			
			var categoryName = $.trim(categoryClone.html().toLowerCase());
			var characterStatusObj = $('#acf-character_status');
			
			if($.inArray(categoryName, categoryStatus) != -1) // show character status
				characterStatusObj.show();
			else
				characterStatusObj.hide();
		} // if
		*/
	} // setCategoryListView
	
	// this will set the set/series based on franchise
	function setSeriesListView()
	{
		var seriesObj = $('#acf-set_series');
		
		if(seriesObj.length>0) // let's find the sub-series
		{
			var franchiseVals = $('#acf-franchise input[type="checkbox"]:checked');
			var arrFranchise = [];	
			
			franchiseVals.each(function(){
				var selectit = $(this).parent().clone();
				selectit.find('input').remove();
				arrFranchise.push($.trim(selectit.html().toLowerCase()));
			});
			
			arrFranchise.push('miscellaneous');

			var parent = seriesObj.find('.sub-set-series-parent .sub-set-series');
			
			parent.each(function(){
				if($.inArray($(this).data('sub-set-series'), arrFranchise) != -1)
					$(this).removeClass('hideObj');
				else
				{
					$(this).addClass('hideObj');
					$(this).find('input[type="checkbox"]').prop('checked', false);
				} // if
			});
		} // if
	} // setSeriesListView
	
	// this will show/hide the exclusive list.
	function setExclusiveListView()
	{
		var statusObj = $('#acf-status');
		
		if(statusObj.length>0) // need to check if the status is an exclusive
		{
			var checkboxList = statusObj.find('.acf-checkbox-list input[type="checkbox"]:checked');
			
			if(checkboxList.length>0) // there is a checked value
			{
				var parent = checkboxList.parent().clone();
				parent.find('input').remove();
				
				var exclusiveListObj = $('#acf-exclusive_list');
				
				if($.trim(parent.html().toLowerCase()) == 'exclusive')
					exclusiveListObj.show();
				else
				{
					exclusiveListObj.hide();
					
					// we also need to make sure all values are unchecked
					exclusiveListObj.find('input[type="checkbox"]').prop('checked', false);
				} // if
			} // if
		} // if
	} // setExclusiveListView
	
	// sets the ACF Fields for selection
	function setACFFields()
	{
		var franchiseVal = [];
		
		for(var key in acfFieldsSingle) // need to populate these fields properly
		{
			var acfObj = $('#acf-'+key);
			
			if(acfObj.length > 0) // check if the field is there
			{
				var checkboxList = acfObj.find('.acf-checkbox-list');
				
				$.each(checkboxList.children(), function(i, item){
					var selectIt = $(this).find('.selectit').clone();
					selectIt.find('input').remove();
					
					var tmpKey = acfFieldsSingle[key];
					
					if(acfFieldsSingle[key] == 'franchise' || acfFieldsSingle[key] == 'set/series')
						tmpKey = 'category';
					
					if($.trim(selectIt.html().toLowerCase()) != tmpKey) // if we don't find this, delete
						$(this).remove();
					else
					{
						$(this).find('.selectit').first().remove();
						
						if(key == 'category') // we need to remove sub children
						{
							var children = $(this).find('ul.children').first();
							
							$.each(children.children(), function(i, item){
								$(this).find('.children').remove();
							});
						}
						else if(key == 'franchise' || key == 'set_series') // need to remove all the set/series 
						{
							var children = $(this).find('ul.children').first();
							var parentCat = '';
							
							children.addClass('selection-list');
							
							$.each(children.children(), function(i, item){
								var subChildren = $(this).find('ul.children').first();
								var selectIt = $(this).find('.selectit').clone();
								
								$(this).find('.selectit input').first().prop('disabled', true);
								
								// hide this and update object
								$(this).data('cat-id', selectIt.find('input').val()).attr('data-cat-id', selectIt.find('input').val());
								selectIt.find('input').remove();
								
								parentCat = $.trim(selectIt.html().toLowerCase());
								
								if(parentCat != 'miscellaneous')
									$(this).addClass('hideObj pop-sel');
								
								$.each(subChildren.children(), function(i, item){
									var selectIt = $(this).find('.selectit').clone();
									selectIt.find('input').remove();
									
									if($.trim(selectIt.html().toLowerCase()) != acfFieldsSingle[key])
										$(this).remove();
									else
									{
										$(this).find('.selectit input').first().prop('disabled', true);
										
										var level2Children = $(this).find('ul.children').first();
										
										// get franchises
										if(key == 'franchise')
										{
											var level2Checked = level2Children.find('input[type="checkbox"]:checked');
											
											if(level2Checked.length>0) // save the values
											{
												// get all the values
												level2Checked.each(function(){
													var parent = $(this).parent().clone();
													parent.find('input').remove();
													
													franchiseVal.push($.trim(parent.html().toLowerCase()));
												});
												
												franchiseVal.push('miscellaneous');
											} // if
										} // if
										
										if(key == 'set_series') // with this, we need to go lower so we can hide the objects when franchise is picked
										{
											level2Children.addClass('sub-set-series-parent');
											
											if(parentCat != 'miscellaneous') // need to hide
											{
												$.each(level2Children.children(), function(i, item){
												var selectIt = $(this).find('.selectit').clone();
												selectIt.find('input').remove();
												
												var tmpName = $.trim(selectIt.html().toLowerCase());
												
												$(this).data('sub-set-series', tmpName).attr('data-sub-set-series', tmpName);
												
												if($.inArray(tmpName, franchiseVal) == -1) // hide the object
													$(this).addClass('hideObj');
												
												$(this).addClass('sub-set-series');
											});
											} // if
										} // if
									} // if
								});
							});
						} // if
					} // if
				});
			} // if
		} // for
		
		// hide these fields
		$.each(acfFieldsHide, function(i, item){
			var obj = $('#acf-'+acfFieldsHide[i]);
			
			if(obj.length>0)
				obj.hide();
		});
		
	} // setACFFields
	
	// This will change the view of the object
	// @param		_obj		Object to show/hide
	// @param		_show		true - show, false - hide
	// @param		_remove	true - remove values, false - don't touch the values
	function changeCategoryView(_obj, _show, _remove)
	{
		if(_show)
			_obj.removeClass('hideObj')
		else
			_obj.addClass('hideObj');
			
		if(_remove) // need to uncheck all checkboxes
			_obj.find('input[type="checkbox"]').prop('checked', false);
	} // checkCategory
	
	// checks if the ACF has shown up yet
	function checkACFPublish()
	{
		if($(document).find('#acf-number').length>0)
			setACFFields();
		else
			setTimeout(function(){checkACFPublish();}, 1000);
			
		return;
	} // checkACFPublish
})(jQuery);