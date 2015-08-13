var xmlHttp = XmlHttpRequestObject();
function XmlHttpRequestObject()
{ 
	var objXmlHttp = null
	if (navigator.userAgent.indexOf("Opera")>=0)
	{
		alert("Error creating the XMLHttpRequest object.") 
		return 
	}

	if (navigator.userAgent.indexOf("MSIE")>=0)
	{ 
		var strName	="MSXML2.XMLHTTP"
		if (navigator.appVersion.indexOf("MSIE 5.5")>=0)
		{
			strName="Microsoft.XMLHTTP"
		} try { 
			objXmlHttp	= new ActiveXObject(strName)
			return objXmlHttp
		} catch(e) { 
			alert("Error. Scripting for ActiveX might be disabled") 
			return 
		} 
	} 

	if (navigator.userAgent.indexOf("Mozilla")>=0)
	{
		objXmlHttp				= new XMLHttpRequest()
		objXmlHttp.onload	= handler
		objXmlHttp.onerror	= handler 
		return objXmlHttp
	}
} 
