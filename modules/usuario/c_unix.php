<?php
  class c_unix
  { 
     //The datas member. 
     var $login;       // The user's login name.
     var $passwd;      // The encrypted passwd.
     var $uid;         // The user's id.
     var $gid;         // The user's login group id.
     var $class;       // The user's login class.
     var $change;      // The password change time.
     var $expire;      // The account expiration time.
     var $gecos;       // The gecos.
     var $homedir;     // The home directorie.
     var $shell;       // The shell.
     var $coduser;     // The coduser of the user.
          
     //The c_unix function is the constructor. It allows to build the c_unix-object
     //and needs to have the login to the unix'user like parameter. This function will
     //be get the data in the data-base and will put them in the object.  
     function get_unix ($login)
     {
       $query="select * from unix where login=?"; $query__p = array($login);
       $result=db_query($query, $query__p);
       $tab=db_fetch_array($result,0);
       $this->login=$tab['login'];
       $this->passwd=$tab['passwd'];   
//       $this->uid='1';//$tab['uid'];         
//       $this->gid='1';//$tab['gid'];         
//       $this->clas='';//$tab['class'];      
       $this->gecos='';//$tab['gecos'];     
       $this->homedir="'/home/'".$login;//$tab['homedir']; 
//       $this->shell=$tab['shell'];   
//       $this->shell="bash";   
//       $this->expire=$tab['expire'];   
//       $this->expire='2007-10-10';   
       $this->coduser=$tab['coduser'];
       db_free_result($result);
     }

     //The create_account function will record this object c_unix in the data-base.
     function create_account()
     {
///////////////////////
	if ($this->status_usuario=="professor")
	{
	$gid="10004";
	$tabela_user="fonctionnaire";
	$cota_impressao="300";
	$cota_disco="500Mb";
	$cota_mail="2000Mb";
	}

	if ($this->status_usuario=="administrativo")
	{
	$gid="10003";
	$tabela_user="fonctionnaire";
	$cota_impressao="9999";
	$cota_disco="500Mb";
	$cota_mail="1000Mb";
	}
	if ($this->status_usuario=="visitor")
	{
	$gid="10002";
	$tabela_user="visitor";
	$cota_impressao="100";
	$cota_disco="100Mb";
	$cota_mail="1000Mb";
	}

	if ($this->status_usuario=="student")
	{
	$tabela_user="student";
	$gid="10001";
	if ($this->tipo_contrato=="doutorado")
		{
		$cota_impressao="200";
		$cota_disco="500Mb";
		$cota_mail="1000Mb";
		}
	//if ($this->tipo_contrato=="mestrado")
	if (($this->tipo_contrato=="mestrado") or ($this->tipo_contrato=="profmat"))
		{
		$cota_impressao="100";
		$cota_disco="300Mb";
		$cota_mail="1000Mb";
		}
	if (($this->tipo_contrato=="graduacao") or ($this->tipo_contrato=="verao") or ($this->tipo_contrato=="especializacao"))
		{
		$cota_impressao="100";
		$cota_disco="300Mb";
		$cota_mail="1000Mb";
		}
	}
     // $query="insert into unix values ('".$this->login."','".$this->passwd."',".$this->uid.",".$this->gid.",'".$this->class."','".$this->expire."',
       //                            '".$this->gecos."','".$this->homedir."','".$this->shell."','".$this->change."','".$this->coduser."')";
        $query_uid="select uid+1 from unix order by uid DESC  limit 1"; $query_uid__p = array();
	$uid=db_query($query_uid, $query_uid__p);
	$uid=db_fetch_array($uid,0);
	$ssh="nao";  // valor padrao para acesso ao ssh
	$query="insert into unix values (?,?,?,?,'1',?,?,'bash',?,?,?,?,?,?)"; $query__p = array($this->login, crypt($this->passwd), $uid[0], $gid, $this->gecos, '/home/'.$this->login, $this->coduser, $cota_impressao, $cota_disco, $cota_mail, $tabela_user, $ssh);
	$result=db_query($query, $query__p);
      $query_mail="insert into mail values (?,?)"; $query_mail__p = array($this->login.'@mat.unb.br', $this->coduser);
	$result_mail=db_query($query_mail, $query_mail__p);     
	// cria_alias
}
	

     //The Set methods allows to access to datas members
     function set_login   ($login)   { $this->login=($login)     ; }
     function set_passwd  ($passwd)  { $this->passwd=($passwd)   ; }
     function set_uid     ($uid)     { $this->uid=($uid)         ; }
     function set_gid     ($gid)     { $this->gid=($gid)         ; }
     function set_class   ($class)   { $this->class=($class)     ; }
     function set_change  ($change)  { $this->change=($change)   ; }
     function set_expire  ($expire)  { $this->expire=($expire)   ; }
     function set_gecos   ($gecos)   { $this->gecos=($gecos)     ; }
     function set_homedir ($homedir) { $this->homedir=($homedir) ; }
     function set_shell   ($shell)   { $this->shell=($shell)     ; }
     function set_coduser ($coduser) { $this->coduser=($coduser)  ; }
     function set_status_usuario ($status_usuario) { $this->status_usuario=($status_usuario)  ; }
     function set_tipo_contrato ($tipo_contrato) { $this->tipo_contrato=($tipo_contrato)  ; }


     //The Get methods allows to return the datas members
     function get_login    () { return $this->login  ; }
     function get_passwd   () { return $this->passwd ; }
     function get_uid      () { return $this->uid    ; }
     function get_gid      () { return $this->gid    ; }
     function get_class    () { return $this->class  ; }
     function get_change   () { return $this->change ; }
     function get_expire   () { return $this->expire ; }
     function get_gecos    () { return $this->gecos   ; }
     function get_homedir  () { return $this->homedir ; }
     function get_shell    () { return $this->shell   ; }
     function get_coduser  () { return $this->coduser ; }
     function get_status_usuario () { return $this->status_usuario ;}
     function get_tipo_contrato () {return $this->tipo_contrato ; }
    
  }//c_unix

?>
