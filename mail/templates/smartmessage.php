<?php

$messagecontent = '<p><span style="font-weight:bold;font-size:16px">Received from:</span> '.$sendername.'</p>
<p><span style="font-weight:bold;font-size:16px">Phone:</span> '.$telephone.'</p>';

if($form != "refer"){
    $messagecontent .='<p><span style="font-weight:bold;font-size:16px">Email:</span> '.$emailaddress.'</p>';
}
else{
    $messagecontent .='<p><span style="font-weight:bold;font-size:16px">Friend\'s Name:</span> '.$fname.'</p>';
    $messagecontent .='<p><span style="font-weight:bold;font-size:16px">Friend\'s Contact:</span> '.$fcontact.'</p>';
}

if($form == "campaign"){
    $messagecontent .='<p><span style="font-weight:bold;font-size:16px">City:</span> '.$city.'</p>';
}

if($form == "enroll"){
    $messagecontent .= '<p><span style="font-weight:bold;font-size:16px">Course Code:</span> '.$coursecode.'</p>';
}

if($form == "demo" || $form =="enquire" || $form=='instructor'){
    $messagecontent .= '<p><span style="font-weight:bold;font-size:16px">Course Name:</span> '.$coursename.'</p>';
}

if($form == "demo" ){
    $messagecontent .= '<p><span style="font-weight:bold;font-size:16px">Occupation:</span> '.$occupation.'</p>';
}

if($form == "contact" || $form=="instructor"){
    $messagecontent .= '<p><span style="font-weight:bold;font-size:16px;">Sender message below:</span> </p>
    <p style="margin-bottom:0;"> '.nl2br($sendermessage).' </p>';
}

$message = '
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Smart forms - Email message template </title>    
</head>

<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
    <center>
        <table style="padding:30px 10px;background:#F4F4F4;width:100%;font-family:arial" cellpadding="0" cellspacing="0">
                
                <tbody>
                    <tr>
                        <td>
                        
                            <table style="max-width:540px;min-width:320px" align="center" cellspacing="0">
                                <tbody>
                                
                                    <tr>
                                        <td style="background:#fff;border:1px solid #D8D8D8;padding:30px 30px" align="center">
                                        
                                            <table align="center">
                                                <tbody>
                                                
                                                    <tr>
                                                        <td style="border-bottom:1px solid #D8D8D8;color:#666;text-align:center;padding-bottom:30px">
                                                            
                                                            <table style="margin:auto" align="center">
                                                                <tbody>
                                                                    <tr>
                                                                        <td style="color:#005f84;font-size:22px;font-weight:bold;text-align:center;font-family:arial">
                                                                
                                                                            NEW MESSAGE	DETAILS	
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    
                                                    <tr>
                                               <td style="color:#666;padding:15px; padding-bottom:0;font-size:14px;line-height:20px;font-family:arial;text-align:left">
                                    
                                                    <div style="font-style:normal;padding-bottom:15px;font-family:arial;line-height:20px;text-align:left">'. $messagecontent.'</div>
                                                            
                                                        </td>
                                                    </tr>
                                                    
                                                </tbody>
                                            </table>
                                            
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td style="background:#f9f9f9;border:1px solid #D8D8D8;border-top:none;padding:24px 10px" align="center">
                                            
                                            <table style="width:100%;max-width:650px" align="center">
                                                <tbody>
                                                    <tr>
                                                        <td style="font-size:20px;line-height:27px;text-align:center;max-width:650px">
                                                            <a href="https://spwebconnect.com" style="text-decoration:none;color:#0088cc" target="_blank">
                                                                <span style="color:#00ce00;font-weight:bold;max-width:180px">POWERED BY:</span> 
                                                                Spwebconnect
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            
                                        </td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </td>
                    </tr>
            </tbody>
        </table>
    </center>
</body>
</html>';
?>