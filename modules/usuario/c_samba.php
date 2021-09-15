<?php
  class c_samba
  {
     //The datas member.
     var $login;
     var $passwd;
//     var $lan_hash;
//     var $nt_hash;
//     var $expire;
//     var $date;
//     var $coduser;

// funcoes para criacao de hash

     require 'atualiza_samba.php';

     //The c_samba function is the constructor. It allows to build the c_samba-object
     //and needs to have the login to the samba's user like parameter. This function will
     //be get the data in the data-base and will put them in the object.
     function get_samba($login)
     {
       $query="select * from samba where login=".$login;
       $result=pg_query($query);
       $tab=pg_fetch_array($result, 0);
       $this->login=$tab['login'];
       $this->passwd=$tab['passwd'];
//       $this->expire=$tab['expire'];
//       $this->date= $tab['date'];
//       $this->coduser=$tab['coduser'];

       pg_free_result($result);
     }


      //The create_account function will record this object c_samba into the data-base.
     function create_account()
     {
//       $query="insert into samba values('".$this->login."','".$this->passwd."','".$this->date."','".$this->expire."',".$this->coduser.")";
       $nt_hash=ntPasswordHash($this->password);
       $lan_hash=lmPasswordHash($this->password);
       $query="update unix set nt_hash=".$nt_hash."',lan_hash='".$lan_hash."' where login='".$this->login."'";
  echo $query;    
       $result=pg_query($query);
       pg_free_result($result);
     }

     //The Set methods allows to access to datas members
     function set_login   ($login)   { $this->login=$login     ; }
     function set_passwd  ($passwd)  { $this->passwd=$passwd   ; }
     function set_expire  ($expire)  { $this->expire=$expire   ; }
     function set_date    ($date   ) { $this->date=$date       ; }
     function set_coduser ($coduser) { $this->coduser=$coduser ; }

     //The Get methods allows to return the datas members
     function get_login   () { return $this->login    ; }
     function get_passwd  () { return $this->passwd   ; }
     function get_expire  () { return $this->expire   ; }
     function get_date    () { return $this->date     ; }
     function get_coduser () { return $this->coduser  ; }

  }//c_samba
?>
