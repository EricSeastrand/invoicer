"use strict";
function musicalScale(rootNote, type) {
	var scale = rootNote.scale(type);
	var notes = [];
	for(var note in scale){
		 notes.push(scale[note]hr);
	}
	notes.type = type.toString();

	return notes;
}

var gridOptions = {
	keyByColumn: 'Tonic',
	onRowClicked: function(chatId, chatObject){
		//parent.loadArbitraryChat(chatId);
	}
	,container  : 'body'
	,resizable	: false
	,sortable		: true
	,columns: {
		Type: { //tonicSupertonicMediantSubdominantDominantSubmediantLeading
			label        : 'Type',
			inputDataKey : 'type'
		},

		Tonic: { //tonicSupertonicMediantSubdominantDominantSubmediantLeading
			label        : 'Tonic',
			inputDataKey : '0',
			dataType : 'note'

		}
		,Supertonic: {
			label        : 'Supertonic',
			inputDataKey : '1',
			dataType : 'Note'
		}
		,Mediant: {
			label        : 'Mediant',
			inputDataKey : '2',
			dataType : 'Note'
		}
		,Subdominant: {
			label        : 'Subdominant',
			inputDataKey : '3',
			dataType : 'Note'
		}
		,Dominant: {
			label        : 'Dominant',
			inputDataKey : '4',
			dataType : 'Note'
		}
		,Submediant: {
			label        : 'Submediant',
			inputDataKey : '5',
			dataType : 'Note'
		}
		,Leading: {
			label        : 'Leading',
			inputDataKey : '6',
			dataType : 'Note'
		}

	}
};
function makeScaleRowData(scaleType) {
	var gridData = [];


	var scaleTonic = Note.fromLatin('C3');

	for(var i=0; i<=12; i++) {
		gridData.push( musicalScale(scaleTonic.add( Interval.fromSemitones(i) ), scaleType));
	}
	return gridData;
}


$(function() {
	window.myGrid = new esGrid( gridOptions );
		
	var gridData = [];
	gridData = gridData.concat(makeScaleRowData('minor'));
	gridData = gridData.concat(makeScaleRowData('major'));

	myGrid.loadData( gridData );
});
