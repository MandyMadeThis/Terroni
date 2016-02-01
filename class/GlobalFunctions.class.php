<?php
/**************************************************************************
	Name: 	Vincent Kwan
	Date: 	2012 05 15
	Desc: 	This class will contain global functions to be used globally in
		this project
**************************************************************************/

class GlobalFunctions
{
   /**** CONSTANT VARIABLES ****/
	
	/**** PRIVATE VARIABLES ****/

	/**** PUBLIC VARIABLES ****/
	
	/*
	 *	Desc: This is the constructor for this class
	 */
	function __construct(  )
	{

	} // constructor

	/*
	 *	Desc: This is the destructor for this class
	 */
	function __destruct()
	{

	}	// destructor

	/*
	 *	Sets the Metas based on the parameters
	 *	
	 *	@author		Vincent Kwan
	 *	@copyright	2010 11 22
	 * 	
	 *	@param	$_title		Title of the site
	 *	@param	$_keywords	Keywords for the site
	 *	@param	$_description	Description of the site
	*/
	public static function SetMetas( $_title = '', $_keywords = '', $_description = '' )
	{
		if( count($_title) > 0 ) // add the title meta
		{
			sfContext::getInstance()->getResponse()->setTitle( ((strlen($_title)>0) ? $_title . ' | ' : '') . CampaignPortal::getCampaignTitleByCode() );
		} // if
		
		if( count($_keywords) > 0 ) // add the keywords
		{
			sfContext::getInstance()->getResponse()->addMeta('keywords', $_keywords );
		} // if
		
		if( count($_description) > 0 ) // add the descriptions
		{
			sfContext::getInstance()->getResponse()->addMeta('description', $_description );
		} // if		
	} // SetMetas

	/*
	 *	This will strip out characters that are invalid in some formats
	 *	
	 *	@author		Vincent Kwan
	 *	@copyright	2010 11 22
	 *	
	 *	@param		_strValue 	value to be mutated
	 *	
	 *	@return		Remove all escaped characters
	*/		
	public static function RemoveEscapeChars( $_strValue )
	{
		$m_strVal = html_entity_decode($_strValue);
		$m_strVal = str_replace('"','',$m_strVal);
		$m_strVal = str_replace('\'','',$m_strVal);

		return $m_strVal;
	} // RemoveEscapeChars
	
	/*
	 *	Reduce the length of the string
	 *	
	 *	@author		Vincent Kwan
	 *	@copyright	2010 12 04
	 *	
	 *	@param		_strValue 	value to reduce length
	 *	@param		_numLength	length to reduce
	 *	
	 *	@return		_strValue with reduced length
	*/		
	public static function ReduceLength( $_strValue, $_numLength )
	{
		$m_numValue = strlen($_strValue);
		
		return ($m_numValue > $_numLength) ? substr($_strValue, 0, $_numLength) . "..." : $_strValue;
	} // ReduceLength

	/*
	 *	This function will format the string to a specific case
	 *
	 *	@author		Vincent Kwan
	 * 	@copyright	2008 07 17
	 * 	
	 * 	@param		_strValue - value to format
	 * 	@param		_blnCase - which case
	 * 	
	 * 	@return		The string passed in but with a specific case( 0 - lowercase, 1 - UPPERCASE )
	 */
	public static function ChangeStringFormat( $_strValue, $_blnCase )
	{
	    $m_strValue = $_strValue;	// final value

	    if( $_blnCase )	// upper case
	    {
		$m_strValue = strtoupper( $m_strValue );
	    }
	    else	// lower case
	    {
		$m_strValue = strtolower( $m_strValue );
	    } // if

	    return $m_strValue;
	} // ChangeStringFormat

	/*
	 *	This function will compare two strings to see if they match. Strings are formatted (trim, same case), before compared
	 *
	 *	@author		Vincent Kwan
	 * 	@copyright	2008 07 17
	 *
	 * 	@param		_strValue1 - first string to compare
	 * 	@param		_strValue2 - second string to compare
	 *
	 * 	@return		true - strings match, false - otherwise
	 */
	public static function CompareStrings( $_strValue1, $_strValue2 )
	{
	    $m_blnState = false;	// state of the function
	    $m_strValue1 = self::ChangeStringFormat( $_strValue1, true );
	    $m_strValue2 = self::ChangeStringFormat( $_strValue2, true );

	    if( $m_strValue1 == $m_strValue2 )	// check if they match
	    {
		$m_blnState = true;
	    } // if

	    return $m_blnState;
	} // CompareStrings

	/*
	 *	Retrieves today's date
	 *	
	 *	@author		Vincent Kwan
	 *	@copyright	2010 03 29
	 *	
	 *	@return		returns the current date and time
	*/		
	public static function GetTodaysDate( )
	{
		return date( 'Y-m-d H:i:s' );
	} // GetTodaysDate

	/*
	 *  This will find a url in the string and add anchor tags to the text
	 *   
	 *   @author         	Vincent Kwan
	 *   @copyright      	2010 08 05
	 *   
	 *   @param		$_strURL	url to be examined
	 *   @param          	$_strText       anchor tag inner html
	 *   @param          	$_blnFormat     true: create anchor link, false: send url only
	 *   
	 *   @return         	The string with the urls formatted properly
	 */
	public static function ReplaceURL( $_strURL, $_strText, $_blnFormat )
	{
	    $m_strVal = trim( $_strURL );
	    $pattern = '/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i';
	    
	    preg_match_all($pattern, $m_strVal, $matches, PREG_OFFSET_CAPTURE);   // find any matches
	    
	    if( !empty( $matches ) ) // if there are matches, format the url
	    {
		foreach( $matches as $match )   // dive 1 level into array
		{
		    for( $count = 0; $count < count($match); $count++ ) // second level
		    {
			$m_strUrl = $match[$count][0];
			$m_strNewUrl = ( $_blnFormat ) ? '<a href="%s' . $m_strUrl . '" target="_blank" title="'. $m_strUrl . '">' . ((strlen($_strText)==0) ? $m_strUrl : $_strText) . '</a>' : '%s' . $m_strUrl;
    
			if( strpos( $m_strUrl, 'http://') === false && strpos( $m_strUrl, 'https://') === false && strpos( $m_strUrl, 'ftp://') === false )
			    $m_strStart = 'http://';
			else
			    $m_strStart = '';
			
			$m_strNewUrl = sprintf( $m_strNewUrl, $m_strStart );
			
			$m_strVal = str_replace( $m_strUrl, $m_strNewUrl, $m_strVal );
		    } // for
		} // foreach            
	    } // if
	    
	    return $m_strVal;
	} // replaceURL
	
	/*
	 *	Slugify the text
	 *
	 *	@author		Vincent Kwan
	 *	@copyright	2011 08 30
	 *	@filesource	http://sourcecookbook.com/en/recipes/8/function-to-slugify-strings-in-php
	 *
	 *	@param		$_text		Text to slugify
	 *
	 *	@return		$_text but slugified
	*/	
	public static function Slugify( $_text )
	{
	    // replace non letter or digits by -
	    $m_Return = preg_replace('~[^\\pL\d]+~u', '-', $_text);
	 
	    // trim
	    $m_Return = trim($m_Return, '-');
	 
	    // transliterate
	    if (function_exists('iconv'))
	    {
		$m_Return = iconv('utf-8', 'us-ascii//TRANSLIT', $m_Return);
	    }
	 
	    // lowercase
	    $m_Return = strtolower($m_Return);
	 
	    // remove unwanted characters
	    $m_Return = preg_replace('~[^-\w]+~', '', $m_Return);
	 
	    if (empty($m_Return))
	    {
		return 'n-a';
	    }
	 
	    return $m_Return;
	} // Slugify
    
	/*
	 *	Delete the file if it exists
	 *
	 *	@author		Vincent Kwan
	 *	@copyright	2011 03 13
	 *
	 *	@param		$_path		Path of the file to delete
	 *	@param		$_filename	Name of the file
	 *
	 *	@return		true - deleted the file, false - no file or couldn't be deleted
	*/
	public static function DeleteFile( $_path, $_filename )
	{
            if( strlen($_filename)>0 && file_exists($file = $_path . $_filename) )
            {
                unlink( $file );
                $m_Return = true;
            }
            else
            {
                $m_Return = false;	
            } // if
            
            return $m_Return;
	} // DeleteFile
	
	/*
	 *	This will make the first character in each work upper case
	 *
	 *	@author		Vincent Kwan
	 *	@copyright	2011 02 28
	 *
	 *	@param		$_str		string to format
	 *
	 *	@return		The formatted $_str
	 */
	public static function CapitalizeString( $_str )
	{
	    $arr = explode( ' ', $_str );
	    
	    for( $i=0; $i<count($arr);$i++ ) // capitalize the first character
	    {
		    $arr[$i] = strtoupper( substr( $arr[$i], 0, 1) ) . substr( $arr[$i], 1, strlen($arr[$i])-1);
	    } // for
	    
	    return implode( " ", $arr );
	} // CapitalizeString
	
	/*
	 *	This will check if the string is null or empty
	 *
	 *	@author		Vincent Kwan
	 *	@copyright	2013 04 13
	 *
	 *	@param		$_str		string to format
	 *
	 *	@return		true		is null or empty
	 *			false		not null nor empty
	 */
	public static function IsNullOrEmpty( $_str )
	{
		$m_str = trim($_str);
		
		return 	(strlen($m_str)==0 || $m_str == null)
			? true
			: false;
	} // IsNullOrEmpty
	
	/*
	 *	This will make the $_number into $_digits length
	 *
	 *	@author		Vincent Kwan
	 *	@copyright	2010 12 22
	 *
	 *	@param		$_number		number to make into x digits
	 *	@param		$_digits		number of digits to make
	 *
	 *	@return		A $_digits digit number
	*/      
	public static function MakeMaxDigits( $_number, $_digits = 6 )
	{
	    $m_numRemaining = $_digits - strlen( $_number );
	    
	    return str_repeat('0', $m_numRemaining) . $_number;
	} // MakeMaxDigits
	
	/*
	 *	This will make the string 2 digits
	 *
	 *	@author		Vincent Kwan
	 *	@copyright	2010 12 27
	 *
	 *	@param		$_number		number to make into 2 digits
	 *	@param		$_last			true - number goes after 0, false - number goes before 0
	 *
	 *	@return		A two digit number
	*/      
	public static function MakeTwoDigits( $_number, $_last = true )
	{
	    $m_Return = 0;
	    
	    if( strlen( $_number ) == 0 )
		    $m_Return = '00';
	    elseif( strlen( $_number ) == 1 )
		    $m_Return =  ($_last) ? '0'.$_number : $_number.'0';
	    else
		    $m_Return = $_number;
	    
	    return $m_Return;
	} // MakeTwoDigits
    
	/*
	 *	This will create the price value to Canadian format
	 *
	 *	@author		Vincent Kwan
	 *	@copyright	2010 12 26
	 *
	 *	@param		$_number		number to make into a price
	 *	@param		$_cents			true - show cents, false - don't show cents
	 *
	 *	@return		$###,###.##, ex: $987,654.32
	*/      
	public static function FormatPrice( $_number, $_cents = true )
	{
	    if( $_number >= 0 ) // create the pricing for this
	    {
		$m_numPrice = round( $_number, 2 );
		$m_arrPrice = explode( '.', $m_numPrice );
		
		$m_strTmp = $m_arrPrice[0];
		$m_strPrice = '';
		
		while( strlen($m_strTmp)>3 ) // add a separater for thousands
		{
			$m_strPrice = ',' . substr($m_strTmp, strlen($m_strTmp)-3, 3 ) . $m_strPrice;
			$m_strTmp = substr($m_strTmp, 0, strlen($m_strTmp)-3);
		} // while
		
		$strDecimal = ( count( $m_arrPrice ) == 1 ) ? '00' : self::MakeTwoDigits($m_arrPrice[1]);
		
		$m_numPrice = '$' . $m_strTmp . $m_strPrice . ( ($_cents ) ? '.' . $strDecimal : '' ); 
	    }
	    else // send "Ask for Price"
	    {
		$m_numPrice = 'Ask For Price';
	    } // if
	    
	    return $m_numPrice;
	} // FormatPrice
    
	/*
	 *	This will create the formatting for the phone number
	 *
	 *	@author		Vincent Kwan
	 *	@copyright	2011 01 16
	 *
	 *	@param		$_phone		number to make into the formatted phone number
	 *
	 *	@return		###.###.####, ie: 416.555.1234
	*/  
	public static function FormatPhone( $_phone )
	{
		
	   $m_strPhone = str_replace(array("(",")"," ","-"), '', $_phone);
		 
		if(strlen($m_strPhone)==11) // long d code maybe in play
		{
		  $m_strLongD = substr($m_strPhone, 0, 1) . '.';
		  $m_strPhone = substr($m_strPhone, 1, strlen($m_strPhone)-1);
		}
		else
		  $m_strLongD = '';

		$m_strPhone =	(strlen($m_strPhone)==10 )
							? sprintf(
							  '%s.%s.%s',
							  substr($m_strPhone,0,3),
							  substr($m_strPhone,3,3),
							  substr($m_strPhone,6,4)
									)
							: $_phone;
							
		return $m_strLongD . $m_strPhone;
	} // FormatPhone
	
	/*
	 *	This will create the formatting for the postal code
	 *
	 *	@author		Vincent Kwan
	 *	@copyright	2011 01 26
	 *
	 *	@param		$_postal	postal code
	 *
	 *	@return		A#A #A#
	*/  
	public static function FormatPostal( $_postal )
	{
	    return (strlen($_postal)==6) ? substr($_postal, 0, 3) . ' ' . substr($_postal, 3, 3) : $_postal;
	} // FormatPostal
    
	/*
	 *	This will create the formatting for the date
	 *
	 *	@author		Vincent Kwan
	 *	@copyright	2011 01 28
	 *
	 *	@param		$_date		date to format
	 *
	 *	@return		D, M j, Y - ie: Sun, April 24, 2010
	*/  
	public static function FormatDate( $_date )
	{
	    return ( strlen($_date)>0 ) ? date(sfConfig::get('app_global_date_format'), strtotime($_date)) : '';
	} // FormatDate
	
	/*
	 *	Formats the file size
	 *
	 *	@author		Vincent Kwan
	 *	@copyright	2011 01 29
	 *
	 *	@param		$_size		Size of the file but in what byte?
	 *
	 *	@return		The file size and with the proper bytes unit
	*/  
	public static function FormatBytes( $_size )
	{
	    $units = array(' B', ' KB', ' MB', ' GB', ' TB');
	    for ($i = 0; $_size >= 1024 && $i < 4; $i++) $_size /= 1024;
	    
	    return ceil($_size).$units[$i];
	} // FormatBytes

	/*
	 *	Replace all linebreaks with one whitespace
	 *
	 *	@author		Vincent Kwan
	 *	@copyright	2011 01 29
	 *
	 *	@param		$_strVal		The string to relace the linebreaks
	 *
	 *	@return		The $_strVal without linebreaks
	*/  
	public static function ReplaceNewLine( $_strVal )
	{
		return (string)str_replace('"','\"',str_replace(array("\r", "\r\n", "\n"), ' ', $_strVal));
	} // ReplaceNewLine
	
	/*
	 *	Remove all paragraph and break tags
	 *
	 *	@author		Vincent Kwan
	 *	@copyright	2012 03 10
	 *
	 *	@param		$_str			String to format
	 *
	 *	@return		Formatted string without the p and br tags
	*/  
	public static function StripPTags( $_str )
	{
		return str_replace("<br />", "", str_replace("<br>", "", str_replace("</p>", "", str_replace("<p>", "", trim($_str)))));
	} // StripPTags
	
	/*
	 *	Creates a random string 
	 *
	 *	@author		Vincent Kwan
	 *	@copyright	2013 03 31
	 *
	 *	@param		$_length		length of the string (default:10)
	 *
	 *	@return		Random string based on the char array
	*/
	public static function generateRandomString($_length = 10)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		
		for ($i = 0; $i < $_length; $i++)
		    $randomString .= $characters[rand(0, strlen($characters) - 1)];
		
		return $randomString;
	} // generateRandomString
	
	/*
	 *	Attemps to clean the value
	 *
	 *	@author		Vincent Kwan
	 *	@copyright	2013 04 09
	 *
	 *	@param		$_val		value to be cleaned
	 *
	 *	@return		Cleaned $_val
	*/
	public static function cleanParamData($_val = '')
	{
		return strip_tags(trim($_val));	
	} // cleanParamData
	
	/*
	 *	Retrieve the translated date based on $_lang
	 *
	 *	@author		Vincent Kwan
	 *	@copyright	2013 04 29
	 *
	 *	@param		$_date		date to translate
	 *	@param		$_lang		language to use to translate
	 *
	 *	@return		array			day
	 *									month
	 *									year
	*/	
	public static function TranslateDate($_date, $_lang = 'en')
	{
		// get date information
		$m_time = strtotime($_date);
		$m_day = date('d', $m_time);
		$m_month = date('F', $m_time);
		$m_year = date('Y', $m_time);
		
		return sprintf(
								GT::__('%2$s %1$s, %3$s'),
								$m_day,
								GT::__($m_month),
								$m_year
							);
	} // TranslateDate
	
	/*
	 *	Calculates how many days from today's date to $_date
	 *
	 *	@author		Vincent Kwan
	 *	@copyright	2012 11 13
	 *
	 *	@param		$_date1		First Date to compare (usually the static date)
	 *	@param		$_date2		Second Date to compare (usually a dynamic date)
	 *
	 *	@return		integer value of days
	*/  
   public static function ComputeDaysApart( $_date1, $_date2 )
   {
      $datediff = $_date1 - $_date2;	    
      return floor($datediff/(60*60*24));
   } // ComputeDaysApart
	
	/*
	 *	Retrieves the current time of the date based on timezone
	 *
	 *	@author		Vincent Kwan
	 *	@copyright	2013 05 07
	 *
	 * @param		$_timezone (@see http://php.net/manual/en/timezones.php)
	 *
	 *	@return		time
	*/ 
	public static function GetDateByTimeZone($_timezone = "Etc/GMT")
	{
		$tzObj = new DateTimeZone($_timezone);
		$tzDate = new DateTime("now", $tzObj);
		
		return mktime(0, 0, 0, $tzDate->format('m'), $tzDate->format('d'), $tzDate->format('Y'));
	} // GetDateByTimeZone
	
	/*
	 *	Retrieves the full URL
	 *
	 *	@author		Vincent Kwan
	 *	@copyright	2014 02 26
	 *
	 *	@param		$_s      server object
	 *	
	 *	@return		Full URL
	*/	
   public static function FullURL($_s)
   {
      $ssl = (!empty($_s['HTTPS']) && $_s['HTTPS'] == 'on') ? true:false;
      $sp = strtolower($_s['SERVER_PROTOCOL']);
      $protocol = substr($sp, 0, strpos($sp, '/')) . (($ssl) ? 's' : '');
      $port = $_s['SERVER_PORT'];
      $port = ((!$ssl && $port=='80') || ($ssl && $port=='443')) ? '' : ':'.$port;
      $host = isset($_s['HTTP_X_FORWARDED_HOST']) ? $_s['HTTP_X_FORWARDED_HOST'] : isset($_s['HTTP_HOST']) ? $_s['HTTP_HOST'] : $_s['SERVER_NAME'];
      return $protocol . '://' . $host . $port . $_s['REQUEST_URI'];
   } // FullURL
	
	/*
	 *	Replace dashes with underscore
	 *
	 *	@author		Vincent Kwan
	 *	@copyright	2013 09 04
	 *
	 *	@param		$_val				value to filter
	 *	
	 *	@return		String with dashes are now underscore
	*/
	public static function ReplaceDashWithUnderscore($_val = '')
	{
		$m_return = trim($_val);
		
		if(strlen($m_return)==0) // use the promotion
			$m_return = sfConfig::get('sf_amd4u_promotion');
		
		return str_replace("-", "_", trim($m_return));
	} // ReplaceDashWithUnderline

	/*
	 *	Filters the email to remove all elements that can be used as an alias.
	 *	This is more for gmail for now
	 *
	 *	@author		Vincent Kwan
	 *	@copyright	2013 12 27
	 *
	 *	@param		$_val				value to filter
	 *	
	 *	@return		Filtered email
	*/	
	public static function FilterEmailForAlias($_val = '')
	{
		$m_return = trim($_val);
		
		$m_parts = explode('@', $m_return);
		
		if(count($m_parts)==2) // email is valid
		{
				$m_tmp = $m_parts[0];
				$m_tmp = str_replace('.', '', $m_tmp);
				$m_tmp = str_replace('+', '', $m_tmp);
				$m_parts[0] = $m_tmp;
				
				$m_return = implode('@', $m_parts);
		} // if
		
		return $m_return;
	} // FilterEmailForAlias
	
	/**
	 * simple method to encrypt or decrypt a plain text string
	 * initialization vector(IV) has to be the same when encrypting and decrypting
	 * PHP 5.4.9
	 *
	 * this is a beginners template for simple encryption decryption
	 * before using this in production environments, please read about encryption
	 *
	 * @param string $action: can be 'encrypt' or 'decrypt'
	 * @param string $string: string to encrypt or decrypt
	 *
	 * @return string
	 */
	public static function encrypt_decrypt($action, $string)
	{
		$output = false;
	
		$encrypt_method = "AES-256-CBC";
		$secret_key = 'AdvancedMICROdeviceS';
		$secret_iv = 'VideoCardS';
  
		// hash
		$key = hash('sha256', $secret_key);
		
		// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
		$iv = substr(hash('sha256', $secret_iv), 0, 16);
  
		if( $action == 'encrypt' ){
			 $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
			 $output = base64_encode($output);
		}
		else if( $action == 'decrypt' ){
			 $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
		}
  
		return $output;
	} // encrypt_decrypt
	
	/*
	 *	@see http://chriswiegman.com/2014/05/getting-correct-ip-address-php/
	 */
	public static function get_ip()
	{
		// Just get the headers if we can or else use the SERVER global
		if( function_exists( 'apache_request_headers' ) )
			$headers = apache_request_headers();
		else
			$headers = $_SERVER;
 
		//Get the forwarded IP if it exists
		if( array_key_exists( 'X-Forwarded-For', $headers ) && filter_var( $headers['X-Forwarded-For'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) )
			$the_ip = $headers['X-Forwarded-For'];
		elseif ( array_key_exists( 'HTTP_X_FORWARDED_FOR', $headers ) && filter_var( $headers['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) )
			$the_ip = $headers['HTTP_X_FORWARDED_FOR'];
		else
			$the_ip = filter_var( $_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 );
 
		return $the_ip;
	} // get_ip	
}
