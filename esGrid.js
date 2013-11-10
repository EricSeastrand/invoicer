function esGrid(options) {
	var self = {
		wrapper    : $('<div>').addClass('esgrid-wrapper'),
		options    : options,
		columns    : options.columns,
		loadData   : loadData,
		render     : render,
		sortGrid   : sortGrid,
		setColumns : setColumns,
		columnOrder: Object.keys( options.columns ),
		dataSet    : [],
		currentSorting : {
			asc      : false,
			column   : options.keyByColumn
		}
	};
	GiveThisObjectEventHandlingMethods(self, {
		rowClick: function(id, ctrl, evt){
			if( self.options.onRowClicked === false ) return;
			! evt.ctrlKey &&
				self.selectionClear();
			
			self.selectionAdd(id);
		}
	});
	self.on(options.on);
	
	self.header    = new esGrid_headerRow( self );
	self.dataTable = new esGrid_dataTable( self );
	self.columnSelector = new esGrid_columnSelector( self );

	if( typeof( options.columnOrder ) != 'undefined' )
		setColumns( options.columnOrder );

	function loadData( dataSet ) {
		self.dataSet = dataSet;
			
		self.trigger('loadData');
	}
	
	self.selectionRemove = function( id ) {
		var row = getRowByKey(id);
		
		row.unselect();
	}
	
	self.selectionAdd = function( id ) {
		var row = getRowByKey(id);		
		
		row.select();
	}
	
	self.selectionSet = function ( ids ) {
		if( !Array.isArray( ids ) )
			ids = [ids];
		
		self.selectionClear();
		
		for( var i=0; i<ids.length; i++ ) {
			var row = getRowByKey( ids[i] );
			if( row )
				row.select();
		}
	}

	self.selectionClear = function() {
		var rowsDeselected = 0;
		
		for( var key in self.dataTable.rows ) {
			var row = self.dataTable.rows[ key ];
			
			if( row ) {
				if( row.isSelected ) rowsDeselected++;
				row.deselect();
			}
		}
		
		return rowsDeselected;
	}
	
	
	
	function getRowByKey( key ) {
		var row = self.dataTable.rows[ key ];
		
		if( row === undefined )
			console.log('No rows were located with ID ' + key);
		
		return row;
	}
	
	function render() {
		self.container = $(options.container);
		self.wrapper.appendTo(self.container);
		self.header.tableHead.appendTo(self.dataTable.thead);
		window.setTimeout( function(){ self.trigger('render'); }, 0);
	}
	
	function sortGrid( byColumnKey, asc ) {
		byColumnKey = byColumnKey || currentSorting.column;
    
    if( typeof(asc) == 'undefined' )
    	asc = self.currentSorting.asc? false : true;

		self.trigger('beforeSort', self.currentSorting);

		self.currentSorting.column = byColumnKey;
		self.currentSorting.asc    = asc;
		
    self.dataTable.sortTable();
    
    self.trigger('afterSort', self.currentSorting);
  }
  
  function setColumns( arrayOfColNames ) {
		var currentOrder = self.columnOrder;
	
		if( ARRAY_CompareIdentical( currentOrder, arrayOfColNames) )
			return console.log('Attempted to change column order or visibility, but new settings are identical to existing');
	
		for( var i=0; i<arrayOfColNames.length; i++ ) {
			if( self.columns[ arrayOfColNames[i] ] === undefined )
				return console.log('Attempeted to make the "' + arrayOfColNames[i] + '" column visible, but there are no settings for it.');

			else    // This index is used to determine the order in which to show the cells.
				self.columns[ arrayOfColNames[i] ].index = i;
		}
	
		var columnsToHide = ARRAY_FilterNonUniqueValues( Object.keys(self.columns), arrayOfColNames );
		for( var i=0; i<columnsToHide.length; i++ ) {
			  // An index of negative one signifies that it should not be displayed.
			  self.columns[ columnsToHide[i] ].index = -1;
		}

		self.columnOrder = arrayOfColNames;
	
		self.trigger('columnOrderChange');
  }
	render();
	
	return self;
}     

if(!Array.isArray) {
  Array.isArray = function (vArg) {
    return Object.prototype.toString.call(vArg) === "[object Array]";
  };
}

function ARRAY_FilterNonUniqueValues(arr1, arr2) {
	var missingFromArray2 = [];
	
	// First check for stuff that is in @arr1 but not @arr2.
	for( var i=0; i<arr1.length; i++ ) {
		var indexInArr2 = arr2.indexOf( arr1[i] );
		if( indexInArr2 === -1 ) missingFromArray2.push( arr1[i] );
	}
	
	return missingFromArray2;
}
function ARRAY_CompareIdentical( arr1, arr2 ) {
	var length = arr1.length;
	if( arr2.length > length )
	    length = arr2.length;
	    
	for( var i=0; i<length; i++ ) {
		if( arr1[i] !== arr2[i] )
			return false;
	}
	
	return true;
}

// convenience function used to clone an object literal
function cloneObject(source) {
	var clone = {};
	
	for (i in source) {
		if (typeof source[i] == 'source') {
			clone[i] = cloneObject(source[i]);
		}
		else{
			clone[i] = source[i];
		}
	}
	return clone;
}

