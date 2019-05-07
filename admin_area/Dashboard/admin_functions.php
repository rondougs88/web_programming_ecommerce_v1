<?php

if (isset($_POST['admin_reset_pwd'])) {
    reset_password($_POST['userid']);
}

if (isset($_POST['user_reset_pwd'])) {
    user_reset_password($_POST['email']);
}

if (isset($_POST['contact_us'])) {
    send_contact_us();
}

if (isset($_POST['del_order'])) {
    delete_order($_POST['order_id']);
}

$eu_username = "";
$eu_fname = "";
$eu_lname = "";
$eu_usertype = "";
$eu_email = "";

function delete_order($order_id)
{
    include_once "../includes/db.php";

    $del_order_items = "DELETE FROM order_items WHERE order_id = '$order_id'";
    mysqli_query($con, $del_order_items);
    if (empty($con->error)) {
        $del_order_header = "DELETE FROM order_header WHERE order_id = '$order_id'";
        mysqli_query($con, $del_order_header);
        if (empty($con->error)) {
            echo "Order has been deleted.";
            return;
        }
    } else {
        echo "Order cannot be deleted.";
    }
}

function send_contact_us()
{
    $email_body = create_contact_email_body($_POST['fname'], $_POST['lname'], $_POST['email'], $_POST['message']);
    require_once "./contact_us_emailer.php";
    echo "Your message has been sent. Someone from our team will be in touch with you shortly.";
}

function randomPassword()
{
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

function user_reset_password($email)
{
    include_once "../includes/db.php";

    $gen_pwd = randomPassword();
    $new_password = sha1($gen_pwd);

    $set_password = "UPDATE users SET password = '$new_password' WHERE email = '$email'";

    mysqli_query($con, $set_password);

    $get_user = "SELECT * from users WHERE email = '$email'";

    $run_q = mysqli_query($con, $get_user);
    $user_count = $run_q->num_rows;
    // $error = mysqli_error($con);
    if ($user_count > 0) {
        while ($row_user = mysqli_fetch_array($run_q)) {

            // $email = $row_user['email'];
            $username = $row_user['username'];
        };
        // Send email to user for his new password.
        // $email = $order_details->getEmail();
        $email_body = create_rstpwd_email_body($gen_pwd, $username);
        require_once "./reset_pwd_emailer.php";
        echo "A new password has been sent to the email you provided.";
    } else {
        echo "Email provided is either invalid or not yet registered.";
    }
}

function reset_password($userid)
{
    include_once "../includes/db.php";

    $gen_pwd = randomPassword();
    $new_password = sha1($gen_pwd);

    $set_password = "UPDATE users SET password = '$new_password' WHERE id = '$userid'";

    mysqli_query($con, $set_password);

    $get_user = "SELECT * from users WHERE id = '$userid'";

    $run_q = mysqli_query($con, $get_user);

    while ($row_user = mysqli_fetch_array($run_q)) {

        $email = $row_user['email'];
        $username = $row_user['username'];
    };

    // Send email to user for his new password.
    // $email = $order_details->getEmail();
    $email_body = create_rstpwd_email_body($gen_pwd, $username);
    require_once "./reset_pwd_emailer.php";

    if (empty(mysqli_error($con))) {
        echo "An email has been sent to the user containing his new password.";
    }
}

function create_contact_email_body($fname, $lname, $email, $message)
{
    return "
    <html xmlns:v='urn:schemas-microsoft-com:vml' xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns:m='http://schemas.microsoft.com/office/2004/12/omml' xmlns='http://www.w3.org/TR/REC-html40'>

<head>
<meta http-equiv='Content-Type' content='text/html; charset=unicode'>
<meta name='ProgId' content='Word.Document'>
<meta name='Generator' content='Microsoft Word 15'>
<meta name='Originator' content='Microsoft Word 15'>
<link rel='File-List' href='Social%20Authentication%20Added_files/filelist.xml'>
<link rel='Edit-Time-Data' href='Social%20Authentication%20Added_files/editdata.mso'>
<!--[if !mso]>
<style>
v\:* {behavior:url(#default#VML);}
o\:* {behavior:url(#default#VML);}
w\:* {behavior:url(#default#VML);}
.shape {behavior:url(#default#VML);}
</style>
<![endif]-->
<title>Inquiry</title>
<!--[if gte mso 9]><xml>
 <o:OfficeDocumentSettings>
  <o:AllowPNG/>
 </o:OfficeDocumentSettings>
</xml><![endif]-->
<link rel='themeData' href='Social%20Authentication%20Added_files/themedata.thmx'>
<link rel='colorSchemeMapping' href='Social%20Authentication%20Added_files/colorschememapping.xml'>
<!--[if gte mso 9]><xml>
 <w:WordDocument>
  <w:Zoom>0</w:Zoom>
  <w:TrackMoves/>
  <w:TrackFormatting/>
  <w:ValidateAgainstSchemas/>
  <w:SaveIfXMLInvalid>false</w:SaveIfXMLInvalid>
  <w:IgnoreMixedContent>false</w:IgnoreMixedContent>
  <w:AlwaysShowPlaceholderText>false</w:AlwaysShowPlaceholderText>
  <w:DoNotPromoteQF/>
  <w:LidThemeOther>EN-US</w:LidThemeOther>
  <w:LidThemeAsian>X-NONE</w:LidThemeAsian>
  <w:LidThemeComplexScript>X-NONE</w:LidThemeComplexScript>
  <w:Compatibility>
   <w:DoNotExpandShiftReturn/>
   <w:BreakWrappedTables/>
   <w:SplitPgBreakAndParaMark/>
   <w:EnableOpenTypeKerning/>
  </w:Compatibility>
  <m:mathPr>
   <m:mathFont m:val='Cambria Math'/>
   <m:brkBin m:val='before'/>
   <m:brkBinSub m:val='&#45;-'/>
   <m:smallFrac m:val='off'/>
   <m:dispDef/>
   <m:lMargin m:val='0'/>
   <m:rMargin m:val='0'/>
   <m:defJc m:val='centerGroup'/>
   <m:wrapIndent m:val='1440'/>
   <m:intLim m:val='subSup'/>
   <m:naryLim m:val='undOvr'/>
  </m:mathPr></w:WordDocument>
</xml><![endif]--><!--[if gte mso 9]><xml>
 <w:LatentStyles DefLockedState='false' DefUnhideWhenUsed='false'
  DefSemiHidden='false' DefQFormat='false' DefPriority='99'
  LatentStyleCount='371'>
  <w:LsdException Locked='false' Priority='0' QFormat='true' Name='Normal'/>
  <w:LsdException Locked='false' Priority='9' QFormat='true' Name='heading 1'/>
  <w:LsdException Locked='false' Priority='9' SemiHidden='true'
   UnhideWhenUsed='true' QFormat='true' Name='heading 2'/>
  <w:LsdException Locked='false' Priority='9' SemiHidden='true'
   UnhideWhenUsed='true' QFormat='true' Name='heading 3'/>
  <w:LsdException Locked='false' Priority='9' SemiHidden='true'
   UnhideWhenUsed='true' QFormat='true' Name='heading 4'/>
  <w:LsdException Locked='false' Priority='9' SemiHidden='true'
   UnhideWhenUsed='true' QFormat='true' Name='heading 5'/>
  <w:LsdException Locked='false' Priority='9' SemiHidden='true'
   UnhideWhenUsed='true' QFormat='true' Name='heading 6'/>
  <w:LsdException Locked='false' Priority='9' SemiHidden='true'
   UnhideWhenUsed='true' QFormat='true' Name='heading 7'/>
  <w:LsdException Locked='false' Priority='9' SemiHidden='true'
   UnhideWhenUsed='true' QFormat='true' Name='heading 8'/>
  <w:LsdException Locked='false' Priority='9' SemiHidden='true'
   UnhideWhenUsed='true' QFormat='true' Name='heading 9'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='index 1'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='index 2'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='index 3'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='index 4'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='index 5'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='index 6'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='index 7'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='index 8'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='index 9'/>
  <w:LsdException Locked='false' Priority='39' SemiHidden='true'
   UnhideWhenUsed='true' Name='toc 1'/>
  <w:LsdException Locked='false' Priority='39' SemiHidden='true'
   UnhideWhenUsed='true' Name='toc 2'/>
  <w:LsdException Locked='false' Priority='39' SemiHidden='true'
   UnhideWhenUsed='true' Name='toc 3'/>
  <w:LsdException Locked='false' Priority='39' SemiHidden='true'
   UnhideWhenUsed='true' Name='toc 4'/>
  <w:LsdException Locked='false' Priority='39' SemiHidden='true'
   UnhideWhenUsed='true' Name='toc 5'/>
  <w:LsdException Locked='false' Priority='39' SemiHidden='true'
   UnhideWhenUsed='true' Name='toc 6'/>
  <w:LsdException Locked='false' Priority='39' SemiHidden='true'
   UnhideWhenUsed='true' Name='toc 7'/>
  <w:LsdException Locked='false' Priority='39' SemiHidden='true'
   UnhideWhenUsed='true' Name='toc 8'/>
  <w:LsdException Locked='false' Priority='39' SemiHidden='true'
   UnhideWhenUsed='true' Name='toc 9'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Normal Indent'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='footnote text'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='annotation text'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='header'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='footer'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='index heading'/>
  <w:LsdException Locked='false' Priority='35' SemiHidden='true'
   UnhideWhenUsed='true' QFormat='true' Name='caption'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='table of figures'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='envelope address'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='envelope return'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='footnote reference'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='annotation reference'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='line number'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='page number'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='endnote reference'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='endnote text'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='table of authorities'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='macro'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='toa heading'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='List'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='List Bullet'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='List Number'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='List 2'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='List 3'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='List 4'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='List 5'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='List Bullet 2'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='List Bullet 3'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='List Bullet 4'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='List Bullet 5'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='List Number 2'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='List Number 3'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='List Number 4'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='List Number 5'/>
  <w:LsdException Locked='false' Priority='10' QFormat='true' Name='Title'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Closing'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Signature'/>
  <w:LsdException Locked='false' Priority='1' SemiHidden='true'
   UnhideWhenUsed='true' Name='Default Paragraph Font'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Body Text'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Body Text Indent'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='List Continue'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='List Continue 2'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='List Continue 3'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='List Continue 4'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='List Continue 5'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Message Header'/>
  <w:LsdException Locked='false' Priority='11' QFormat='true' Name='Subtitle'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Salutation'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Date'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Body Text First Indent'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Body Text First Indent 2'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Note Heading'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Body Text 2'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Body Text 3'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Body Text Indent 2'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Body Text Indent 3'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Block Text'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Hyperlink'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='FollowedHyperlink'/>
  <w:LsdException Locked='false' Priority='22' QFormat='true' Name='Strong'/>
  <w:LsdException Locked='false' Priority='20' QFormat='true' Name='Emphasis'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Document Map'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Plain Text'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='E-mail Signature'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='HTML Top of Form'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='HTML Bottom of Form'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Normal (Web)'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='HTML Acronym'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='HTML Address'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='HTML Cite'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='HTML Code'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='HTML Definition'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='HTML Keyboard'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='HTML Preformatted'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='HTML Sample'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='HTML Typewriter'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='HTML Variable'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Normal Table'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='annotation subject'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='No List'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Outline List 1'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Outline List 2'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Outline List 3'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Table Simple 1'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Table Simple 2'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Table Simple 3'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Table Classic 1'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Table Classic 2'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Table Classic 3'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Table Classic 4'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Table Colorful 1'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Table Colorful 2'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Table Colorful 3'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Table Columns 1'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Table Columns 2'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Table Columns 3'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Table Columns 4'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Table Columns 5'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Table Grid 1'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Table Grid 2'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Table Grid 3'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Table Grid 4'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Table Grid 5'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Table Grid 6'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Table Grid 7'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Table Grid 8'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Table List 1'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Table List 2'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Table List 3'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Table List 4'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Table List 5'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Table List 6'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Table List 7'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Table List 8'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Table 3D effects 1'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Table 3D effects 2'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Table 3D effects 3'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Table Contemporary'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Table Elegant'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Table Professional'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Table Subtle 1'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Table Subtle 2'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Table Web 1'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Table Web 2'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Table Web 3'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Balloon Text'/>
  <w:LsdException Locked='false' Priority='39' Name='Table Grid'/>
  <w:LsdException Locked='false' SemiHidden='true' UnhideWhenUsed='true'
   Name='Table Theme'/>
  <w:LsdException Locked='false' SemiHidden='true' Name='Placeholder Text'/>
  <w:LsdException Locked='false' Priority='1' QFormat='true' Name='No Spacing'/>
  <w:LsdException Locked='false' Priority='60' Name='Light Shading'/>
  <w:LsdException Locked='false' Priority='61' Name='Light List'/>
  <w:LsdException Locked='false' Priority='62' Name='Light Grid'/>
  <w:LsdException Locked='false' Priority='63' Name='Medium Shading 1'/>
  <w:LsdException Locked='false' Priority='64' Name='Medium Shading 2'/>
  <w:LsdException Locked='false' Priority='65' Name='Medium List 1'/>
  <w:LsdException Locked='false' Priority='66' Name='Medium List 2'/>
  <w:LsdException Locked='false' Priority='67' Name='Medium Grid 1'/>
  <w:LsdException Locked='false' Priority='68' Name='Medium Grid 2'/>
  <w:LsdException Locked='false' Priority='69' Name='Medium Grid 3'/>
  <w:LsdException Locked='false' Priority='70' Name='Dark List'/>
  <w:LsdException Locked='false' Priority='71' Name='Colorful Shading'/>
  <w:LsdException Locked='false' Priority='72' Name='Colorful List'/>
  <w:LsdException Locked='false' Priority='73' Name='Colorful Grid'/>
  <w:LsdException Locked='false' Priority='60' Name='Light Shading Accent 1'/>
  <w:LsdException Locked='false' Priority='61' Name='Light List Accent 1'/>
  <w:LsdException Locked='false' Priority='62' Name='Light Grid Accent 1'/>
  <w:LsdException Locked='false' Priority='63' Name='Medium Shading 1 Accent 1'/>
  <w:LsdException Locked='false' Priority='64' Name='Medium Shading 2 Accent 1'/>
  <w:LsdException Locked='false' Priority='65' Name='Medium List 1 Accent 1'/>
  <w:LsdException Locked='false' SemiHidden='true' Name='Revision'/>
  <w:LsdException Locked='false' Priority='34' QFormat='true'
   Name='List Paragraph'/>
  <w:LsdException Locked='false' Priority='29' QFormat='true' Name='Quote'/>
  <w:LsdException Locked='false' Priority='30' QFormat='true'
   Name='Intense Quote'/>
  <w:LsdException Locked='false' Priority='66' Name='Medium List 2 Accent 1'/>
  <w:LsdException Locked='false' Priority='67' Name='Medium Grid 1 Accent 1'/>
  <w:LsdException Locked='false' Priority='68' Name='Medium Grid 2 Accent 1'/>
  <w:LsdException Locked='false' Priority='69' Name='Medium Grid 3 Accent 1'/>
  <w:LsdException Locked='false' Priority='70' Name='Dark List Accent 1'/>
  <w:LsdException Locked='false' Priority='71' Name='Colorful Shading Accent 1'/>
  <w:LsdException Locked='false' Priority='72' Name='Colorful List Accent 1'/>
  <w:LsdException Locked='false' Priority='73' Name='Colorful Grid Accent 1'/>
  <w:LsdException Locked='false' Priority='60' Name='Light Shading Accent 2'/>
  <w:LsdException Locked='false' Priority='61' Name='Light List Accent 2'/>
  <w:LsdException Locked='false' Priority='62' Name='Light Grid Accent 2'/>
  <w:LsdException Locked='false' Priority='63' Name='Medium Shading 1 Accent 2'/>
  <w:LsdException Locked='false' Priority='64' Name='Medium Shading 2 Accent 2'/>
  <w:LsdException Locked='false' Priority='65' Name='Medium List 1 Accent 2'/>
  <w:LsdException Locked='false' Priority='66' Name='Medium List 2 Accent 2'/>
  <w:LsdException Locked='false' Priority='67' Name='Medium Grid 1 Accent 2'/>
  <w:LsdException Locked='false' Priority='68' Name='Medium Grid 2 Accent 2'/>
  <w:LsdException Locked='false' Priority='69' Name='Medium Grid 3 Accent 2'/>
  <w:LsdException Locked='false' Priority='70' Name='Dark List Accent 2'/>
  <w:LsdException Locked='false' Priority='71' Name='Colorful Shading Accent 2'/>
  <w:LsdException Locked='false' Priority='72' Name='Colorful List Accent 2'/>
  <w:LsdException Locked='false' Priority='73' Name='Colorful Grid Accent 2'/>
  <w:LsdException Locked='false' Priority='60' Name='Light Shading Accent 3'/>
  <w:LsdException Locked='false' Priority='61' Name='Light List Accent 3'/>
  <w:LsdException Locked='false' Priority='62' Name='Light Grid Accent 3'/>
  <w:LsdException Locked='false' Priority='63' Name='Medium Shading 1 Accent 3'/>
  <w:LsdException Locked='false' Priority='64' Name='Medium Shading 2 Accent 3'/>
  <w:LsdException Locked='false' Priority='65' Name='Medium List 1 Accent 3'/>
  <w:LsdException Locked='false' Priority='66' Name='Medium List 2 Accent 3'/>
  <w:LsdException Locked='false' Priority='67' Name='Medium Grid 1 Accent 3'/>
  <w:LsdException Locked='false' Priority='68' Name='Medium Grid 2 Accent 3'/>
  <w:LsdException Locked='false' Priority='69' Name='Medium Grid 3 Accent 3'/>
  <w:LsdException Locked='false' Priority='70' Name='Dark List Accent 3'/>
  <w:LsdException Locked='false' Priority='71' Name='Colorful Shading Accent 3'/>
  <w:LsdException Locked='false' Priority='72' Name='Colorful List Accent 3'/>
  <w:LsdException Locked='false' Priority='73' Name='Colorful Grid Accent 3'/>
  <w:LsdException Locked='false' Priority='60' Name='Light Shading Accent 4'/>
  <w:LsdException Locked='false' Priority='61' Name='Light List Accent 4'/>
  <w:LsdException Locked='false' Priority='62' Name='Light Grid Accent 4'/>
  <w:LsdException Locked='false' Priority='63' Name='Medium Shading 1 Accent 4'/>
  <w:LsdException Locked='false' Priority='64' Name='Medium Shading 2 Accent 4'/>
  <w:LsdException Locked='false' Priority='65' Name='Medium List 1 Accent 4'/>
  <w:LsdException Locked='false' Priority='66' Name='Medium List 2 Accent 4'/>
  <w:LsdException Locked='false' Priority='67' Name='Medium Grid 1 Accent 4'/>
  <w:LsdException Locked='false' Priority='68' Name='Medium Grid 2 Accent 4'/>
  <w:LsdException Locked='false' Priority='69' Name='Medium Grid 3 Accent 4'/>
  <w:LsdException Locked='false' Priority='70' Name='Dark List Accent 4'/>
  <w:LsdException Locked='false' Priority='71' Name='Colorful Shading Accent 4'/>
  <w:LsdException Locked='false' Priority='72' Name='Colorful List Accent 4'/>
  <w:LsdException Locked='false' Priority='73' Name='Colorful Grid Accent 4'/>
  <w:LsdException Locked='false' Priority='60' Name='Light Shading Accent 5'/>
  <w:LsdException Locked='false' Priority='61' Name='Light List Accent 5'/>
  <w:LsdException Locked='false' Priority='62' Name='Light Grid Accent 5'/>
  <w:LsdException Locked='false' Priority='63' Name='Medium Shading 1 Accent 5'/>
  <w:LsdException Locked='false' Priority='64' Name='Medium Shading 2 Accent 5'/>
  <w:LsdException Locked='false' Priority='65' Name='Medium List 1 Accent 5'/>
  <w:LsdException Locked='false' Priority='66' Name='Medium List 2 Accent 5'/>
  <w:LsdException Locked='false' Priority='67' Name='Medium Grid 1 Accent 5'/>
  <w:LsdException Locked='false' Priority='68' Name='Medium Grid 2 Accent 5'/>
  <w:LsdException Locked='false' Priority='69' Name='Medium Grid 3 Accent 5'/>
  <w:LsdException Locked='false' Priority='70' Name='Dark List Accent 5'/>
  <w:LsdException Locked='false' Priority='71' Name='Colorful Shading Accent 5'/>
  <w:LsdException Locked='false' Priority='72' Name='Colorful List Accent 5'/>
  <w:LsdException Locked='false' Priority='73' Name='Colorful Grid Accent 5'/>
  <w:LsdException Locked='false' Priority='60' Name='Light Shading Accent 6'/>
  <w:LsdException Locked='false' Priority='61' Name='Light List Accent 6'/>
  <w:LsdException Locked='false' Priority='62' Name='Light Grid Accent 6'/>
  <w:LsdException Locked='false' Priority='63' Name='Medium Shading 1 Accent 6'/>
  <w:LsdException Locked='false' Priority='64' Name='Medium Shading 2 Accent 6'/>
  <w:LsdException Locked='false' Priority='65' Name='Medium List 1 Accent 6'/>
  <w:LsdException Locked='false' Priority='66' Name='Medium List 2 Accent 6'/>
  <w:LsdException Locked='false' Priority='67' Name='Medium Grid 1 Accent 6'/>
  <w:LsdException Locked='false' Priority='68' Name='Medium Grid 2 Accent 6'/>
  <w:LsdException Locked='false' Priority='69' Name='Medium Grid 3 Accent 6'/>
  <w:LsdException Locked='false' Priority='70' Name='Dark List Accent 6'/>
  <w:LsdException Locked='false' Priority='71' Name='Colorful Shading Accent 6'/>
  <w:LsdException Locked='false' Priority='72' Name='Colorful List Accent 6'/>
  <w:LsdException Locked='false' Priority='73' Name='Colorful Grid Accent 6'/>
  <w:LsdException Locked='false' Priority='19' QFormat='true'
   Name='Subtle Emphasis'/>
  <w:LsdException Locked='false' Priority='21' QFormat='true'
   Name='Intense Emphasis'/>
  <w:LsdException Locked='false' Priority='31' QFormat='true'
   Name='Subtle Reference'/>
  <w:LsdException Locked='false' Priority='32' QFormat='true'
   Name='Intense Reference'/>
  <w:LsdException Locked='false' Priority='33' QFormat='true' Name='Book Title'/>
  <w:LsdException Locked='false' Priority='37' SemiHidden='true'
   UnhideWhenUsed='true' Name='Bibliography'/>
  <w:LsdException Locked='false' Priority='39' SemiHidden='true'
   UnhideWhenUsed='true' QFormat='true' Name='TOC Heading'/>
  <w:LsdException Locked='false' Priority='41' Name='Plain Table 1'/>
  <w:LsdException Locked='false' Priority='42' Name='Plain Table 2'/>
  <w:LsdException Locked='false' Priority='43' Name='Plain Table 3'/>
  <w:LsdException Locked='false' Priority='44' Name='Plain Table 4'/>
  <w:LsdException Locked='false' Priority='45' Name='Plain Table 5'/>
  <w:LsdException Locked='false' Priority='40' Name='Grid Table Light'/>
  <w:LsdException Locked='false' Priority='46' Name='Grid Table 1 Light'/>
  <w:LsdException Locked='false' Priority='47' Name='Grid Table 2'/>
  <w:LsdException Locked='false' Priority='48' Name='Grid Table 3'/>
  <w:LsdException Locked='false' Priority='49' Name='Grid Table 4'/>
  <w:LsdException Locked='false' Priority='50' Name='Grid Table 5 Dark'/>
  <w:LsdException Locked='false' Priority='51' Name='Grid Table 6 Colorful'/>
  <w:LsdException Locked='false' Priority='52' Name='Grid Table 7 Colorful'/>
  <w:LsdException Locked='false' Priority='46'
   Name='Grid Table 1 Light Accent 1'/>
  <w:LsdException Locked='false' Priority='47' Name='Grid Table 2 Accent 1'/>
  <w:LsdException Locked='false' Priority='48' Name='Grid Table 3 Accent 1'/>
  <w:LsdException Locked='false' Priority='49' Name='Grid Table 4 Accent 1'/>
  <w:LsdException Locked='false' Priority='50' Name='Grid Table 5 Dark Accent 1'/>
  <w:LsdException Locked='false' Priority='51'
   Name='Grid Table 6 Colorful Accent 1'/>
  <w:LsdException Locked='false' Priority='52'
   Name='Grid Table 7 Colorful Accent 1'/>
  <w:LsdException Locked='false' Priority='46'
   Name='Grid Table 1 Light Accent 2'/>
  <w:LsdException Locked='false' Priority='47' Name='Grid Table 2 Accent 2'/>
  <w:LsdException Locked='false' Priority='48' Name='Grid Table 3 Accent 2'/>
  <w:LsdException Locked='false' Priority='49' Name='Grid Table 4 Accent 2'/>
  <w:LsdException Locked='false' Priority='50' Name='Grid Table 5 Dark Accent 2'/>
  <w:LsdException Locked='false' Priority='51'
   Name='Grid Table 6 Colorful Accent 2'/>
  <w:LsdException Locked='false' Priority='52'
   Name='Grid Table 7 Colorful Accent 2'/>
  <w:LsdException Locked='false' Priority='46'
   Name='Grid Table 1 Light Accent 3'/>
  <w:LsdException Locked='false' Priority='47' Name='Grid Table 2 Accent 3'/>
  <w:LsdException Locked='false' Priority='48' Name='Grid Table 3 Accent 3'/>
  <w:LsdException Locked='false' Priority='49' Name='Grid Table 4 Accent 3'/>
  <w:LsdException Locked='false' Priority='50' Name='Grid Table 5 Dark Accent 3'/>
  <w:LsdException Locked='false' Priority='51'
   Name='Grid Table 6 Colorful Accent 3'/>
  <w:LsdException Locked='false' Priority='52'
   Name='Grid Table 7 Colorful Accent 3'/>
  <w:LsdException Locked='false' Priority='46'
   Name='Grid Table 1 Light Accent 4'/>
  <w:LsdException Locked='false' Priority='47' Name='Grid Table 2 Accent 4'/>
  <w:LsdException Locked='false' Priority='48' Name='Grid Table 3 Accent 4'/>
  <w:LsdException Locked='false' Priority='49' Name='Grid Table 4 Accent 4'/>
  <w:LsdException Locked='false' Priority='50' Name='Grid Table 5 Dark Accent 4'/>
  <w:LsdException Locked='false' Priority='51'
   Name='Grid Table 6 Colorful Accent 4'/>
  <w:LsdException Locked='false' Priority='52'
   Name='Grid Table 7 Colorful Accent 4'/>
  <w:LsdException Locked='false' Priority='46'
   Name='Grid Table 1 Light Accent 5'/>
  <w:LsdException Locked='false' Priority='47' Name='Grid Table 2 Accent 5'/>
  <w:LsdException Locked='false' Priority='48' Name='Grid Table 3 Accent 5'/>
  <w:LsdException Locked='false' Priority='49' Name='Grid Table 4 Accent 5'/>
  <w:LsdException Locked='false' Priority='50' Name='Grid Table 5 Dark Accent 5'/>
  <w:LsdException Locked='false' Priority='51'
   Name='Grid Table 6 Colorful Accent 5'/>
  <w:LsdException Locked='false' Priority='52'
   Name='Grid Table 7 Colorful Accent 5'/>
  <w:LsdException Locked='false' Priority='46'
   Name='Grid Table 1 Light Accent 6'/>
  <w:LsdException Locked='false' Priority='47' Name='Grid Table 2 Accent 6'/>
  <w:LsdException Locked='false' Priority='48' Name='Grid Table 3 Accent 6'/>
  <w:LsdException Locked='false' Priority='49' Name='Grid Table 4 Accent 6'/>
  <w:LsdException Locked='false' Priority='50' Name='Grid Table 5 Dark Accent 6'/>
  <w:LsdException Locked='false' Priority='51'
   Name='Grid Table 6 Colorful Accent 6'/>
  <w:LsdException Locked='false' Priority='52'
   Name='Grid Table 7 Colorful Accent 6'/>
  <w:LsdException Locked='false' Priority='46' Name='List Table 1 Light'/>
  <w:LsdException Locked='false' Priority='47' Name='List Table 2'/>
  <w:LsdException Locked='false' Priority='48' Name='List Table 3'/>
  <w:LsdException Locked='false' Priority='49' Name='List Table 4'/>
  <w:LsdException Locked='false' Priority='50' Name='List Table 5 Dark'/>
  <w:LsdException Locked='false' Priority='51' Name='List Table 6 Colorful'/>
  <w:LsdException Locked='false' Priority='52' Name='List Table 7 Colorful'/>
  <w:LsdException Locked='false' Priority='46'
   Name='List Table 1 Light Accent 1'/>
  <w:LsdException Locked='false' Priority='47' Name='List Table 2 Accent 1'/>
  <w:LsdException Locked='false' Priority='48' Name='List Table 3 Accent 1'/>
  <w:LsdException Locked='false' Priority='49' Name='List Table 4 Accent 1'/>
  <w:LsdException Locked='false' Priority='50' Name='List Table 5 Dark Accent 1'/>
  <w:LsdException Locked='false' Priority='51'
   Name='List Table 6 Colorful Accent 1'/>
  <w:LsdException Locked='false' Priority='52'
   Name='List Table 7 Colorful Accent 1'/>
  <w:LsdException Locked='false' Priority='46'
   Name='List Table 1 Light Accent 2'/>
  <w:LsdException Locked='false' Priority='47' Name='List Table 2 Accent 2'/>
  <w:LsdException Locked='false' Priority='48' Name='List Table 3 Accent 2'/>
  <w:LsdException Locked='false' Priority='49' Name='List Table 4 Accent 2'/>
  <w:LsdException Locked='false' Priority='50' Name='List Table 5 Dark Accent 2'/>
  <w:LsdException Locked='false' Priority='51'
   Name='List Table 6 Colorful Accent 2'/>
  <w:LsdException Locked='false' Priority='52'
   Name='List Table 7 Colorful Accent 2'/>
  <w:LsdException Locked='false' Priority='46'
   Name='List Table 1 Light Accent 3'/>
  <w:LsdException Locked='false' Priority='47' Name='List Table 2 Accent 3'/>
  <w:LsdException Locked='false' Priority='48' Name='List Table 3 Accent 3'/>
  <w:LsdException Locked='false' Priority='49' Name='List Table 4 Accent 3'/>
  <w:LsdException Locked='false' Priority='50' Name='List Table 5 Dark Accent 3'/>
  <w:LsdException Locked='false' Priority='51'
   Name='List Table 6 Colorful Accent 3'/>
  <w:LsdException Locked='false' Priority='52'
   Name='List Table 7 Colorful Accent 3'/>
  <w:LsdException Locked='false' Priority='46'
   Name='List Table 1 Light Accent 4'/>
  <w:LsdException Locked='false' Priority='47' Name='List Table 2 Accent 4'/>
  <w:LsdException Locked='false' Priority='48' Name='List Table 3 Accent 4'/>
  <w:LsdException Locked='false' Priority='49' Name='List Table 4 Accent 4'/>
  <w:LsdException Locked='false' Priority='50' Name='List Table 5 Dark Accent 4'/>
  <w:LsdException Locked='false' Priority='51'
   Name='List Table 6 Colorful Accent 4'/>
  <w:LsdException Locked='false' Priority='52'
   Name='List Table 7 Colorful Accent 4'/>
  <w:LsdException Locked='false' Priority='46'
   Name='List Table 1 Light Accent 5'/>
  <w:LsdException Locked='false' Priority='47' Name='List Table 2 Accent 5'/>
  <w:LsdException Locked='false' Priority='48' Name='List Table 3 Accent 5'/>
  <w:LsdException Locked='false' Priority='49' Name='List Table 4 Accent 5'/>
  <w:LsdException Locked='false' Priority='50' Name='List Table 5 Dark Accent 5'/>
  <w:LsdException Locked='false' Priority='51'
   Name='List Table 6 Colorful Accent 5'/>
  <w:LsdException Locked='false' Priority='52'
   Name='List Table 7 Colorful Accent 5'/>
  <w:LsdException Locked='false' Priority='46'
   Name='List Table 1 Light Accent 6'/>
  <w:LsdException Locked='false' Priority='47' Name='List Table 2 Accent 6'/>
  <w:LsdException Locked='false' Priority='48' Name='List Table 3 Accent 6'/>
  <w:LsdException Locked='false' Priority='49' Name='List Table 4 Accent 6'/>
  <w:LsdException Locked='false' Priority='50' Name='List Table 5 Dark Accent 6'/>
  <w:LsdException Locked='false' Priority='51'
   Name='List Table 6 Colorful Accent 6'/>
  <w:LsdException Locked='false' Priority='52'
   Name='List Table 7 Colorful Accent 6'/>
 </w:LatentStyles>
</xml><![endif]-->
<style>
<!--
 /* Font Definitions */
 @font-face
	{font-family:'Cambria Math';
	panose-1:2 4 5 3 5 4 6 3 2 4;
	mso-font-charset:1;
	mso-generic-font-family:roman;
	mso-font-pitch:variable;
	mso-font-signature:0 0 0 0 0 0;}
@font-face
	{font-family:Calibri;
	panose-1:2 15 5 2 2 2 4 3 2 4;
	mso-font-charset:0;
	mso-generic-font-family:swiss;
	mso-font-pitch:variable;
	mso-font-signature:-536858881 -1073732485 9 0 511 0;}
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-parent:'';
	margin:0in;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	font-size:12.0pt;
	font-family:'Times New Roman',serif;
	mso-fareast-font-family:Calibri;
	mso-fareast-theme-font:minor-latin;}
a:link, span.MsoHyperlink
	{mso-style-noshow:yes;
	mso-style-priority:99;
	color:blue;
	text-decoration:underline;
	text-underline:single;}
a:visited, span.MsoHyperlinkFollowed
	{mso-style-noshow:yes;
	mso-style-priority:99;
	color:purple;
	text-decoration:underline;
	text-underline:single;}
p
	{mso-style-noshow:yes;
	mso-style-priority:99;
	margin-top:0in;
	margin-right:0in;
	margin-bottom:7.5pt;
	margin-left:0in;
	mso-pagination:widow-orphan;
	font-size:12.0pt;
	font-family:'Times New Roman',serif;
	mso-fareast-font-family:Calibri;
	mso-fareast-theme-font:minor-latin;}
p.msonormal0, li.msonormal0, div.msonormal0
	{mso-style-name:msonormal;
	mso-style-unhide:no;
	margin-top:0in;
	margin-right:0in;
	margin-bottom:7.5pt;
	margin-left:0in;
	mso-pagination:widow-orphan;
	font-size:12.0pt;
	font-family:'Times New Roman',serif;
	mso-fareast-font-family:Calibri;
	mso-fareast-theme-font:minor-latin;}
.MsoChpDefault
	{mso-style-type:export-only;
	mso-default-props:yes;
	font-size:10.0pt;
	mso-ansi-font-size:10.0pt;
	mso-bidi-font-size:10.0pt;}
@page WordSection1
	{size:8.5in 11.0in;
	margin:1.0in 1.0in 1.0in 1.0in;
	mso-header-margin:.5in;
	mso-footer-margin:.5in;
	mso-paper-source:0;}
div.WordSection1
	{page:WordSection1;}
-->
</style>
<!--[if gte mso 10]>
<style>
 /* Style Definitions */
 table.MsoNormalTable
	{mso-style-name:'Table Normal';
	mso-tstyle-rowband-size:0;
	mso-tstyle-colband-size:0;
	mso-style-noshow:yes;
	mso-style-priority:99;
	mso-style-parent:'';
	mso-padding-alt:0in 5.4pt 0in 5.4pt;
	mso-para-margin:0in;
	mso-para-margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	font-size:10.0pt;
	font-family:'Times New Roman',serif;}
</style>
<![endif]-->
</head>

<body lang='EN-US' link='blue' vlink='purple' style='tab-interval:.5in'>

<div class='WordSection1' style='page: WordSection1;'>

<p class='MsoNormal' style='margin-left: 120.0pt;text-indent: -120.0pt;tab-stops: 120.0pt;mso-layout-grid-align: none;text-autospace: none;mso-style-noshow: yes;mso-style-priority: 99;margin-top: 0in;margin-right: 0in;margin-bottom: .0001pt;mso-pagination: widow-orphan;font-size: 12.0pt;font-family: &quot;Times New Roman&quot;,serif;mso-fareast-font-family: Calibri;mso-fareast-theme-font: minor-latin;mso-style-unhide: no;mso-style-qformat: yes;mso-style-parent: &quot;&quot;;margin: 0in;'><b><span style='font-family:&quot;Calibri&quot;,sans-serif;color:black'>From:<span style='mso-tab-count:1'>  </span></span></b><span style='font-family:&quot;Calibri&quot;,sans-serif;color:black'>$fname $lname
&lt;$email&gt;<o:p></o:p></span></p>

<br>
<div>

<div style='border:none;border-bottom:solid #F2F3F5 1.0pt;mso-border-bottom-alt:
solid #F2F3F5 .75pt;padding:0in 0in 8.0pt 0in;margin-bottom:15.0pt'>

<p style='line-height: 18.0pt;background: white;mso-style-noshow: yes;mso-style-priority: 99;margin-top: 0in;margin-right: 0in;margin-bottom: 7.5pt;margin-left: 0in;mso-pagination: widow-orphan;font-size: 12.0pt;font-family: &quot;Times New Roman&quot;,serif;mso-fareast-font-family: Calibri;mso-fareast-theme-font: minor-latin;'><span style='font-family:&quot;Arial&quot;,sans-serif;
color:#686F7A'><span style='mso-field-code:&quot; HYPERLINK \0022\0022 &quot;'><span style='color:black'>Hi Geek Gadget, </span></span><o:p></o:p></span></p>

<p style='line-height: 18.0pt;background: white;mso-style-noshow: yes;mso-style-priority: 99;margin-top: 0in;margin-right: 0in;margin-bottom: 7.5pt;margin-left: 0in;mso-pagination: widow-orphan;font-size: 12.0pt;font-family: &quot;Times New Roman&quot;,serif;mso-fareast-font-family: Calibri;mso-fareast-theme-font: minor-latin;'><span style='font-family:&quot;Arial&quot;,sans-serif;
color:#686F7A'><span style='mso-field-code:&quot; HYPERLINK \0022\0022 &quot;'><span style='color:black'>$message</span></span><o:p></o:p></span></p>

</div>

</div>

<div>

<p style='background: #F2F3F5;mso-style-noshow: yes;mso-style-priority: 99;margin-top: 0in;margin-right: 0in;margin-bottom: 7.5pt;margin-left: 0in;mso-pagination: widow-orphan;font-size: 12.0pt;font-family: &quot;Times New Roman&quot;,serif;mso-fareast-font-family: Calibri;mso-fareast-theme-font: minor-latin;'><span style='font-size:8.5pt;font-family:&quot;Arial&quot;,sans-serif;
color:#686F7A'>Delivered by Geek Gadget, EIT Hawke's Bay, New Zealand. <o:p></o:p></span></p>

</div>

<p class='MsoNormal' style='mso-style-noshow: yes;mso-style-priority: 99;margin-top: 0in;margin-right: 0in;margin-bottom: .0001pt;margin-left: 0in;mso-pagination: widow-orphan;font-size: 12.0pt;font-family: &quot;Times New Roman&quot;,serif;mso-fareast-font-family: Calibri;mso-fareast-theme-font: minor-latin;mso-style-unhide: no;mso-style-qformat: yes;mso-style-parent: &quot;&quot;;margin: 0in;'><span style='mso-fareast-font-family:&quot;Times New Roman&quot;'><img border='0' width='1' height='1' id='_x0000_i1026' src='http://e.udemymail.com/wf/open?upn=egD0vJ-2Bfz0IZAI4FsdhhWwgjjaBSDYOQS9E4DzLduI-2Bh8lQefKQB1rtYv45WEQpU8V-2BDLdcSzUo0x83RXoWsnEtGGy3R-2Bx88ytlQMyShNrOmFElMy8kfIA1-2FJ6k91DfOSDXOO2lhGouqa-2Bm-2B4BUot4gqCSjLn5qxd-2BpbmegtqTemJhOirV687IoHCoYgJE-2BZ-2BPK1ePpXR1zzacvLCM14Kq3V4Zxcwu04W25F5-2Bh2APQS-2Fub3tVS6XaMuLgrudPYGAYvpKtpIdBiZp5EMkBVPXnD23F5-2BBdasbTbGeBiguJBQeMlv2zTvtIRfUVdLRSmu9T5CgwrlCeVGEoty7kG-2Byw-3D-3D' style='border-bottom-width:0in;border-left-width:0in;border-right-width:0in;
border-top-width:0in;height:1px;margin-bottom:0in;margin-left:0in;margin-right:
0in;margin-top:0in;padding-bottom:0in;padding-left:0in;padding-right:0in;
padding-top:0in;width:1px'><o:p></o:p></span></p>

</div>

</body>

</html>

    ";
}

function create_rstpwd_email_body($newpassword, $username)
{
    return "
    <!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' style='margin: 0;padding: 0;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;'>
<head style='margin: 0;padding: 0;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;'>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' style='margin: 0;padding: 0;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;'>
    <meta name='viewport' content='width=device-width' style='margin: 0;padding: 0;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;'>

    <!-- For development, pass document through inliner -->


    <style type='text/css' style='margin: 0;padding: 0;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;'>

    /* Your custom styles go here */
    * { margin: 0; padding: 0; font-size: 100%; font-family: 'Avenir Next', 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; line-height: 1.65; }

img { max-width: 100%; margin: 0 auto; display: block; }

body, .body-wrap { width: 100% !important; height: 100%; background: #f8f8f8; }

a { color: #71bc37; text-decoration: none; }

a:hover { text-decoration: underline; }

.text-center { text-align: center; }

.text-right { text-align: right; }

.text-left { text-align: left; }

.button { display: inline-block; color: white; background: #71bc37; border: solid #71bc37; border-width: 10px 20px 8px; font-weight: bold; border-radius: 4px; }

.button:hover { text-decoration: none; }

h1, h2, h3, h4, h5, h6 { margin-bottom: 20px; line-height: 1.25; }

h1 { font-size: 32px; }

h2 { font-size: 28px; }

h3 { font-size: 24px; }

h4 { font-size: 20px; }

h5 { font-size: 16px; }

p, ul, ol { font-size: 16px; font-weight: normal; margin-bottom: 20px; }

.container { display: block !important; clear: both !important; margin: 0 auto !important; max-width: 580px !important; }

.container table { width: 100% !important; border-collapse: collapse; }

.container .masthead { padding: 80px 0; background: #71bc37; color: white; }

.container .masthead h1 { margin: 0 auto !important; max-width: 90%; text-transform: uppercase; }

.container .content { background: white; padding: 30px 35px; }

.container .content.footer { background: none; }

.container .content.footer p { margin-bottom: 0; color: #888; text-align: center; font-size: 14px; }

.container .content.footer a { color: #888; text-decoration: none; font-weight: bold; }

.container .content.footer a:hover { text-decoration: underline; }

    </style>
</head>
<body style='margin: 0;padding: 0;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;height: 100%;background: #f8f8f8;width: 100% !important;'>
<table class='body-wrap' style='margin: 0;padding: 0;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;height: 100%;background: #f8f8f8;width: 100% !important;'>
    <tr style='margin: 0;padding: 0;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;'>
        <td class='container' style='margin: 0 auto !important;padding: 0;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;display: block !important;clear: both !important;max-width: 580px !important;'>

            <!-- Message start -->
            <table style='margin: 0;padding: 0;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;border-collapse: collapse;width: 100% !important;'>
                <tr style='margin: 0;padding: 0;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;'>
                    <td align='center' class='masthead' style='margin: 0;padding: 80px 0;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;background: #71bc37;color: white;'>

                        <h1 style='margin: 0 auto !important;padding: 0;font-size: 32px;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.25;margin-bottom: 20px;max-width: 90%;text-transform: uppercase;'>Password Reset</h1>
                        
                    </td>
                </tr>
                <tr style='margin: 0;padding: 0;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;'>
                    <td class='content' style='margin: 0;padding: 30px 35px;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;background: white;'>

                        <h2 style='margin: 0;padding: 0;font-size: 28px;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.25;margin-bottom: 20px;'>Hi $username,</h2>

                        <p style='margin: 0;padding: 0;font-size: 16px;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;font-weight: normal;margin-bottom: 20px;'>Your new password is <strong style='margin: 0;padding: 0;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;'>$newpassword</strong></p>
                        <p style='margin: 0;padding: 0;font-size: 16px;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;font-weight: normal;margin-bottom: 20px;'><a href='http://localhost/web_programming_ecommerce_v1/admin_area/login.php' style='margin: 0;padding: 0;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;color: #71bc37;text-decoration: none;'>Click here to login.</a></p>

                    </td>
                </tr>
            </table>

        </td>
    </tr>
    <tr style='margin: 0;padding: 0;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;'>
        <td class='container' style='margin: 0 auto !important;padding: 0;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;display: block !important;clear: both !important;max-width: 580px !important;'>

            <!-- Message start -->
            <table style='margin: 0;padding: 0;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;border-collapse: collapse;width: 100% !important;'>
                <tr style='margin: 0;padding: 0;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;'>
                    <td class='content footer' align='center' style='margin: 0;padding: 30px 35px;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;background: none;'>
                        <p style='margin: 0;padding: 0;font-size: 14px;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;font-weight: normal;margin-bottom: 0;color: #888;text-align: center;'>Sent by <a href='#' style='margin: 0;padding: 0;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;color: #888;text-decoration: none;font-weight: bold;'>Geek Gadget</a>, 1234 Yellow Brick Road, OZ, 99999</p>
                        <p style='margin: 0;padding: 0;font-size: 14px;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;font-weight: normal;margin-bottom: 0;color: #888;text-align: center;'><a href='mailto:' style='margin: 0;padding: 0;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;color: #888;text-decoration: none;font-weight: bold;'>geekgadget.2019@gmail.com</a> | <a href='#' style='margin: 0;padding: 0;font-size: 100%;font-family: 'Avenir Next', &quot;Helvetica Neue&quot;, &quot;Helvetica&quot;, Helvetica, Arial, sans-serif;line-height: 1.65;color: #888;text-decoration: none;font-weight: bold;'>Unsubscribe</a></p>
                    </td>
                </tr>
            </table>

        </td>
    </tr>
</table>
</body>
</html>
    ";
}

function get_users()
{

    global $con;

    $get_users = "SELECT * from users";

    $run_q = mysqli_query($con, $get_users);

    while ($row_user = mysqli_fetch_array($run_q)) {

        $userid = $row_user['id'];
        $username = $row_user['username'];
        $email = $row_user['email'];
        $user_type = $row_user['user_type'];
        $fname = $row_user['fname'];
        $lname = $row_user['lname'];

        echo "
                <tr>
                    <td>$username</td>
                    <td>$fname $lname</td>
                    <td>$email</td>
                    <td>$user_type</td>
                    
                    <td><a href='./edit_user.php?userid=$userid'>Edit</a></td>
                </tr>
            ";
    }
}

function get_products()
{

    global $con, $siteroot;

    $get_products = "SELECT products.*, categories.*, brands.* from products INNER JOIN categories ON categories.cat_id = products.product_cat INNER JOIN brands ON brands.brand_id = products.product_brand";

    $run_q = mysqli_query($con, $get_products);

    while ($row_prod = mysqli_fetch_array($run_q)) {

        $product_id = $row_prod['product_id'];
        $product_title = $row_prod['product_title'];
        $product_cat = $row_prod['product_cat'];
        $cat_title = $row_prod['cat_title'];
        $product_brand = $row_prod['product_brand'];
        $brand_title = $row_prod['brand_title'];
        $product_price = $row_prod['product_price'];
        $product_image = $row_prod['product_image'];

        echo "
                <tr>
                    <td><img src='$siteroot/admin_area/uploads/product_images/$product_image' border=3 width=50></img></td>
                    <td>$product_title</td>
                    <td>$cat_title</td>
                    <td>$brand_title</td>
                    <td>$product_price</td>
                    <td><a href='./edit_product.php?product_id=$product_id'>Edit</a></td>
                </tr>
            ";
    }
}

function get_prod_categories()
{

    global $con, $siteroot;

    $get_cat = "SELECT * FROM categories";

    $run_q = mysqli_query($con, $get_cat);

    while ($row_prod = mysqli_fetch_array($run_q)) {

        $cat_id = $row_prod['cat_id'];
        $cat_title = $row_prod['cat_title'];

        echo "
                <tr>
                    <td>$cat_title</td>
                    <td><a class='btn btn-danger float-right' href='./categories.php?del_cat_id=$cat_id'>Delete</a></td>
                </tr>
            ";
    }
}

function get_prod_brands()
{

    global $con, $siteroot;

    $get_brand = "SELECT * FROM brands";

    $run_q = mysqli_query($con, $get_brand);

    while ($row_prod = mysqli_fetch_array($run_q)) {

        $brand_id = $row_prod['brand_id'];
        $brand_title = $row_prod['brand_title'];

        echo "
                <tr>
                    <td>$brand_title</td>
                    <td><a class='btn btn-danger float-right' href='./brands.php?del_brand_id=$brand_id'>Delete</a></td>
                </tr>
            ";
    }
}

function set_user_details($userid)
{

    global $con, $eu_username,  $eu_email, $eu_user_type, $eu_fname, $eu_lname;

    $get_user = "SELECT * from users WHERE id = '$userid'";

    $run_q = mysqli_query($con, $get_user);

    while ($row_user = mysqli_fetch_array($run_q)) {

        // $userid = $row_user['id'];
        $eu_username = $row_user['username'];
        $eu_email = $row_user['email'];
        $eu_user_type = $row_user['user_type'];
        $eu_fname = $row_user['fname'];
        $eu_lname = $row_user['lname'];
    }
}

function get_orders()
{
    global $con;

    $get_orders = "SELECT order_items.*,
                                order_header.*,
                                products.*
                    FROM order_items
                            INNER JOIN order_header ON order_items.order_id = order_header.order_id
                            INNER JOIN products ON order_items.p_id = products.product_id ORDER BY order_items.order_id ASC";

    $run_query = mysqli_query($con, $get_orders);

    $prev_id = '';
    $num_rows = $run_query->num_rows;
    $counter = 0;
    while ($row = $run_query->fetch_assoc()) {
        $data[] = $row;
    }
    if (!empty($data)) {
        for ($i = 0; $i < count($data); $i++) {
            $row_order = $data[$i];
            $counter += 1;
            $order = $row_order['order_id'];
            $date = $row_order['created_on'];
            $status = $row_order['status'];
            if (isset($data[$counter])) {
                $next_id = $data[$counter]['order_id'];
            }
            if ($order == $prev_id) {
                $total = $total + $row_order['product_price'] * $row_order['qty'];
            } else {
                $total = $row_order['product_price'] * $row_order['qty'];
            }
            if ($order != $prev_id) {
                $prev_id = $order;
            }
            if ($counter == $num_rows || ($next_id != $order)) {
                $formatted_number = number_format($total, 2);
                echo "
                <tr>
                    <td>$order</td>
                    <td>$date</td>
                    <td>$status</td>
                    <td>$$formatted_number</td>
                    <td><a href='edit_order.php?order=$order'> Edit / Delete</td>
                </tr>
        ";
            }
        }
    }
}

function edit_orders()
{
    global $con;
}
