var globalFunctions = {
    init : function(){},
    
    // checks if the input value is an integer
    // @param       _obj        object to check
    // @return      value of integers or blank
    checkInteger : function( _obj ){
        var m_return = '';
        var m_arrStr = _obj.val().split(''); // convert this to a character array
        
        for(i=0;i<m_arrStr.length;i++) // goes through each value to see if it's an integer
        {
            if(m_arrStr[i].match(/^[0-9]$/gi) != null) // add to the return string
                m_return += m_arrStr[i];
        } // for
        
        return m_return;
    },
    
    // checks if the input value is a valid postal code
    // @param       _obj        object to check
    // @return      value of postal code or blank
    checkPostal : function( _obj )
    {
        var m_return = '';
        var m_blnAdd = false;
        var m_arrStr = _obj.val().split(''); // convert this to a character array
        
        for(i=0;i<m_arrStr.length;i++) // goes through each value to see if it's an integer
        {
            // add to return string
            if
            (
                ( i % 2 == 0 && m_arrStr[i].match(/^[A-Za-z]$/gi) != null) ||
                ( i % 2 == 1 && m_arrStr[i].match(/^[0-9]$/gi) != null)
            )
                m_return += m_arrStr[i];
        } // for
        
        return m_return;
    },
	 
    // checks if the input value is a valid email
    // @param	_val		value to filter
    // @return	true 		valid
    //		false 		invalid
    checkEmail : function( _val )
    {
		  return 	(_val.match(/^[A-Za-z0-9][_\-\d\w\.\+]*@([\d\w\-]+\.)+[A-Za-z]{2,7}$/gi) != null);
    },	 
    
    // makes a value two digits
    // @param       _val        value to format
    // @param	    _date	true: 0[_val], false: [_val]0
    // @return      _val.length = 0 => 00
    //              _val.length = 1 => _val + '0'
    //              _val.length >= 2 => substr(_val, 2)
    makeTwoDigits : function( _val, _date )
    {
        var m_return = '00'; // default value
        
        if( _val.length == 1 ) // add a zero to the end
            m_return = (_date) ? '0' + _val : _val + '0';
        else if( _val.length >= 2 ) // make 2 digits
            m_return = _val.substr(0,2);
            
        return m_return;
    },
    
    // this will format a value to thousands view
    // @param       _val        Value of the number to format
    // @param       _decimal    true - show decimal, false - do not show decimal
    formatThousands : function( _val, _decimal )
    {       
        var m_thousandsDelim = (fb.lang == 'fr') ? ' ' : ',';
        var m_decimalDelim = (fb.lang == 'fr') ? '.' : ',';
        var m_numPrice = ( isNaN(_val) ) ? -1 : parseInt(_val);
        
        if( m_numPrice >= 0) // format the number
        {
            m_numPrice = Math.round( m_numPrice * 100 ) / 100; // round to 2 decimal places
            var m_arrPrice = m_numPrice.toString().split('.'); // create an array
            
            var m_strTmp = m_arrPrice[0];
            var m_strPrice = '';
            
            while( m_strTmp.length > 3 ) // format the number
            {
                m_strPrice = m_thousandsDelim + m_strTmp.substr(m_strTmp.length-3, 3) + m_strPrice;
                m_strTmp = m_strTmp.substr(0, m_strTmp.length-3);
            } // while
            
            var m_strDecimal = ( m_arrPrice.length == 1 ) ? '00' : globalFunctions.makeTwoDigits( m_arrPrice[1] );
            m_numPrice = m_strTmp + m_strPrice + ( ( _decimal ) ? m_decimalDelim + m_strDecimal : '' );
        } // if
        
        return m_numPrice;
    },
    
    // this will reduce the length of the string (primarily for the textarea)
    // @param		_obj		Object of the string to reduce
    // @param		_length		Max Length of the string
    // @return		Reduced String if necessary
    reduceLength : function( _obj, _length )
    {
	return ( $(_obj).val().length > _length ) ? $(_obj).val().substr(0, _length) : $(_obj).val();
    },
    
    // check if the user is on mobile
    isMobile: function()
    {
        var mobile = {
            Android: function() {
                return navigator.userAgent.match(/Android/i) ? true : false;
            },
            BlackBerry: function() {
                return navigator.userAgent.match(/BlackBerry/i) ? true : false;
            },
            iOS: function() {
                return navigator.userAgent.match(/iPhone|iPad|iPod/i) ? true : false;
            },
            Windows: function() {
                return navigator.userAgent.match(/IEMobile/i) ? true : false;
            },
            any: function() {
                return (mobile.Android() || mobile.BlackBerry() || mobile.iOS() || mobile.Windows());
            }
        };
        
        return mobile.any();
    },
	 // converts text to slug
	 // http://stackoverflow.com/questions/1053902/how-to-convert-a-title-to-a-url-slug-in-jquery
	 convertToSlug : function(_text)
	 {
		  return _text
				.toLowerCase()
				.replace(/[^\w ]+/g,'')
				.replace(/ +/g,'-');
	 }
};

jQuery(document).ready(function($) {
    globalFunctions.init();
});