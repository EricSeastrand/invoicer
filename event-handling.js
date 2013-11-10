/* Can be used to grant several key functions (on, off, and trigger) to any object, allowing it to handle events.*/
function GiveThisObjectEventHandlingMethods(object, defaultEvents){
	object.events = {};
	
	object.on = function( events, callback ){
		if( typeof events == 'string' )
			_bindEvents( events, callback );
		
		if( typeof events == 'object' )
			for( var eventName in events ) {
				_bindEvents( eventName, events[eventName] );
			}
	};
	
	function _bindEvents( type, callback ) {
		type = type.split(' ');
		for(var i=0; i<type.length; i++){
			_bindEventHandler( type[i], callback );
		}
	}
	
	function _bindEventHandler( eventName, callback ) {
		object.events[ eventName ] = object.events[ eventName ] || [];
		
		if( typeof callback == 'object' && callback.length )
			object.events[ eventName ] = object.events[ eventName ].concat( callback );
		else
			object.events[ eventName ].push( callback );
	}
	
	object.off = function( type ){
		object.events[type] = [];
	};
	
	object.trigger = function( type ){
		if ( !object.events[type] ) return;
		var args = Array.prototype.slice.call(arguments, 1);
		for (var i = 0, l = object.events[type].length; i < l;  i++)
			switch( typeof object.events[type][i] ) {
				case 'function':
					object.events[type][i].apply(object, args);
				case 'string'  :
					object.trigger( object.events[type][i] );
				default     :
			}
	};
	
	if(defaultEvents) {
		for(var eventName in defaultEvents) {
			object.on(eventName, defaultEvents[eventName]);
		}
	}
};
