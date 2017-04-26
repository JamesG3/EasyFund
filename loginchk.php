<?php
    
    $db = new mysqli('127.0.0.1', 'root', 'root','easyfund') or die('Could not connect: ' . mysqli_error());

    $input_name = $_POST["uname"];

   	if ((!ctype_alnum($input_name) and strpos('adfa', ' ')!==false) or (!ctype_alnum($_POST["keyword"]) and $_POST["keyword"] != '' and strpos('adfa', ' ')!==false)){
   		echo "The input is not valid!";
   		exit;						#prevent sql injection
   	}

    $auth1 = "SELECT password FROM user where username = ";
    $auth1 .= "'".$input_name."'";
    # 需改为prepare statement
   	$authen1 = $db->query($auth1);
   	if (!$authen1){
   		echo "Something wrong!!";
   		showerror();				# if query faild, show error message.
   	}



    $auth2 = "SELECT password FROM user where email = ";
    $auth2 .= "'".$input_name."'";
    # 需改为prepare statement
    $authen2 = $db->query($auth2);
    if (!$authen2){
      echo "Something wrong!!";
      showerror();        # if query faild, show error message.
    }


	session_start();

    #check username
   	if(mysqli_num_rows($authen1)==1){
      while ($row = $authen1->fetch_assoc()){
        $password = $row['password'];
      }
      if ($_POST["psw"] == $password){
        $_SESSION["loginUsername"] = $input_name;
        $_SESSION["keyword"] = $_POST["keyword"];
        header("Location: show.php");
      }

      else{
        $_SESSION["message"] = "Wrong username or passwrod! ";
        // Relocate to the logout page
        echo $_SESSION["message"];
        session_destroy();
        exit;
      }

   }

   #check email
   else if(mysqli_num_rows($authen2)==1){
      while ($row = $authen2->fetch_assoc()){
        $password = $row['password'];
      }
      if ($_POST["psw"] == $password){
        $_SESSION["loginUsername"] = $input_name;
        $_SESSION["keyword"] = $_POST["keyword"];
        header("Location: show.php");
      }

      else{
        $_SESSION["message"] = "Wrong username or passwrod! ";
        // Relocate to the logout page
        echo $_SESSION["message"];
        session_destroy();
        exit;
      }

   }

	 else{					#if no such user, echo error
	 $_SESSION["message"] = "Wrong username or passwrod! ";
    	// Relocate to the logout page
  	 echo $_SESSION["message"];

  	 session_destroy();
  	 exit;
	}

