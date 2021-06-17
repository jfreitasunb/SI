<?php
  class c_admin
  {
     //The datas member.
     var $login;
     var $passwd;
     var $coduser;

     //The c_admin function is the constructor. It allows to build the c_admin-object
     //and needs to have the login to the admin's user like parameter. This function will
     //be get the data in the data-base and will put them in the object.
     function get_admin($login)
     {
       $query="select * from admin where login=".$login;
       $result=pg_query($query);
       $tab=pg_fetch_array($result, 0);
       $this->login=$tab['login'];
       $this->passwd=$tab['passwd'];
       $this->coduser=$tab['coduser'];
       pg_free_result($result);
     }

      //The create_account function will record this object c_samba into the data-base.
     function create_account()
     {
       //We create the account in the database
       $query="insert into admin values('".$this->login."','".md5($this->passwd)."',".$this->coduser.")";
       $result=pg_query($query);
       pg_free_result($result);
       //Foreach module we give the default right 0 for the new user
       $query2="select idmodule from module";
       $result2=pg_query($query2);
       $count2=pg_num_rows($result2);
       for ($i=0; $i<$count2; $i++)
       { 
          $tab2=pg_fetch_array($result2,$i);
          $query3="insert into permission values('".$this->login."',".$tab2['idmodule'].",0)";
          $result3=pg_query($query3);
          pg_free_result($result3); 
       } 
       pg_free_result($result2);
     }

     //The Set methods allows to access to datas members
     function set_login   ($login)   { $this->login=$login     ; }
     function set_passwd  ($passwd)  { $this->passwd=$passwd   ; }
     function set_coduser ($coduser) { $this->coduser=$coduser ; }

     //The Get methods allows to return the datas members
     function get_login   () { return $this->login    ; }
     function get_passwd  () { return $this->passwd   ; }
     function get_coduser () { return $this->coduser  ; }

  }//c_samba
?>
