 <?php
        if(isset($_POST['name']))
{



    $name=$email=$phone=$uploadresume="";
    $nameErr=$emailErr=$phoneErr=$uploadresumeErr="";


    function test_input($data)
    {
        $data=trim($data);
        $data=stripslashes($data);
        $data=htmlspecialchars($data);
        return $data;
    }
if ($_SERVER['REQUEST_METHOD']=="POST"){

    $valid=true;
        //name validaton
        if(empty($_POST["name"]))
        {
            $nameErr="* Name is Required";
            $valid=false;
        }
        else
        {
            $name=test_input($_POST["name"]);
    if (!preg_match("/^[a-zA-Z ]*$/",$name))
     {
      $nameErr = "&nbsp;&nbsp;Only letters and white space allowed"; 
      $valid=false;
     }
        }

            //Email Address validaton
        if(empty($_POST["email"]))
        {
            $emailErr="* Email is Required";
            $valid=false;
        }
        else
        {
            $email=test_input($_POST["email"]);
       if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email))
       {
           $emailErr="&nbsp;&nbsp; Enter a valid Email ID";
           $valid=false;
       }
        }

        //Mobile no validaton
        if(empty($_POST["phone"]))
        {
            $phoneErr="* Mobile no is Required";
            $valid=false;
        }
        else
        {
            $phone=test_input($_POST["phone"]);
             if(!preg_match("/^(\d[\s-]?)?[\(\[\s-]{0,2}?\d{3}[\)\]\s-]{0,2}?\d{3}[\s-]?\d{4}$/i",$phone)) 
       {
        $phoneErr="*Enter a valid contact no";
        $valid=false;
       }    
        }


        if(empty($_FILES["filename"]['type']))

        {
            $uploadresumeErr="* Upload Your Resume";
            $valid=false;
        }
        else
        {
            $_FILES["filename"]['type'] = 'application/pdf';
            $_FILES["filename"]['type'] = 'application/msword';
       {
        $uploadresume=test_input($_POST["filename"]);

       }
       }    


    if($valid)
 {

   $to = "ex@example.co.in";

        // Change this to your site admin email


        $from = "$_POST[email]";

        $subject = "Applied for DataEntry FROM $_POST[name] ";

        //Begin HTML Email Message where you need to change the activation URL inside


// Get all the values from input
    $name = $_POST['name'];
    $email_address = $_POST['email'];
    $phone = $_POST['phone'];

 // Now Generate a random string to be used as the boundary marker
   $mime_boundary="==Multipart_Boundary_x".md5(mt_rand())."x";

   // Now Store the file information to a variables for easier access
   $tmp_name = $_FILES['filename']['tmp_name'];
   $type = $_FILES['filename']['type'];
   $file_name = $_FILES['filename']['name'];
   $size = $_FILES['filename']['size'];



   // Now here we setting up the message of the mail
   $message = "

   \n\n Applied For DataEntry
   \n\n Name: $name 
   \n\n Email: $email_address 
   \n\n Phone: $phone"; 


   // Check if the upload succeded, the file will exist
   if (file_exists($tmp_name)){

      // Check to make sure that it is an uploaded file and not a system file
      if(is_uploaded_file($tmp_name)){

         // Now Open the file for a binary read
         $file = fopen($tmp_name,'rb');

         // Now read the file content into a variable
         $data = fread($file,filesize($tmp_name));

         // close the file
         fclose($file);

         // Now we need to encode it and split it into acceptable length lines
         $data = chunk_split(base64_encode($data));
     }

      // Now we'll build the message headers
      $headers = "From: $from\r\n" .
         "MIME-Version: 1.0\r\n" .
         "Content-Type: multipart/mixed;\r\n" .
         " boundary=\"{$mime_boundary}\"";

      // Next, we'll build the message body note that we insert two dashes in front of the  MIME boundary when we use it
      $message = "This is a multi-part message in MIME format.\n\n" .
         "--{$mime_boundary}\n" .
         "Content-Type: text/plain; charset=\"iso-8859-1\"\n" .
         "Content-Transfer-Encoding: 7bit\n\n" .
         $message . "\n\n";

      // Now we'll insert a boundary to indicate we're starting the attachment we have to specify the content type, file name, and disposition as an attachment, then add the file content and set another boundary to indicate that the end of the file has been reached
      $message .= "--{$mime_boundary}\n" .
         "Content-Type: {$type};\n" .
         " name=\"{$file_name}\"\n" .
         //"Content-Disposition: attachment;\n" .
         //" filename=\"{$fileatt_name}\"\n" .
         "Content-Transfer-Encoding: base64\n\n" .
         $data . "\n\n" .
         "--{$mime_boundary}--\n";


      // Thats all.. Now we need to send this mail... :)
      if (@mail($to, $subject, $message, $headers))
      {
         ?>
    <div>
      <center>
        <h1>Your Data Has been submitted we will contact you soon !!</h1>
      </center>
    </div>
    <?php
      }else
      {
         ?>
    <div>
      <center>
        <h1>Error !! Unable to send yor data..</h1>
      </center>
    </div>
    <?php
      }
   }
}
}
}
?>

 <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
  <label>Name:</label>
  <input type="text" name="name"  value="<?php echo $_POST["name"]?>"/>
  <?php echo $nameErr?> <br />
  <br />
  <label>Email-ID:</label>
  <input type="text" name="email" value="<?php echo $_POST["email"]?>"/>
  <?php echo $emailErr?> <br />
  <br />
  <label>Phone No:</label>
  <input type="text" name="phone" value="<?php echo $_POST["phone"]?>"/>
  <?php echo $phoneErr?> <br />
  <br />
  <label for="tele">upload Resume</label>
  <input type="file" name="filename" id="tele"/>
  <?php echo $uploadresumeErr?> <br />
  <br />
  <input style="display:block; margin-left:35em;"type="submit" value="Submit"/>
</form>