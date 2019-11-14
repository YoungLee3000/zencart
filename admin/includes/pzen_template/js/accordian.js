/**PZENTEMPLATE_BRAND**/

$( function()
{
	var cookieName = 'pzen_sticky_accordian';

	$( '#accordion' ).accordion( {
		active: ( $.cookies.get( cookieName ) || 0 ),
		change: function( e, ui )
		{
			$.cookies.set( cookieName, $( this ).find( 'h3' ).index ( ui.newHeader[0] ) );
		}
	} );
} );
/****************** Custom js for getshopped **************************/
function getGridSize() {
	  if(window.innerWidth<300)return 1;else{
		 if(window.innerWidth<600)return 2;else{
			 if(window.innerWidth<900)return 3;else{
				 if(window.innerWidth<1200)return 4;else return 5;}
			  }
		   }
       }