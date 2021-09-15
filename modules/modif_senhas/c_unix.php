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
     var $ssh;     // acesso ao ssh.
     
     //The c_unix function is the constructor. It allows to build the c_unix-object
     //and needs to have the login to the unix'user like parameter. This function will
     //be get the data in the data-base and will put them in the object.  
     function pega_unix ($login)
     {
       $query="select * from unix where login='".$login."'";
       $result=pg_query($query);
       $tab=pg_fetch_array($result,0);
       $this->login=$tab['login'];
       $this->passwd=$tab['passwd'];   
       $this->uid=$tab['uid'];         
       $this->gid=$tab['gid'];         
       $this->class=$tab['class'];      
       $this->change=$tab['change'];   
       $this->expire=$tab['expire'];   
       $this->gecos=$tab['gecos'];     
       $this->homedir=$tab['homedir']; 
       $this->shell=$tab['shell'];   
       $this->coduser=$tab['coduser'];
       $this->ssh=$tab['ssh'];
       pg_free_result($result);
     } 

     //The create_account function will record this object c_unix in the data-base.
     function create_account()
     {
	if ($this->status_usuario=="") $gid="10000";

	if ($this->status_usuario=="professor")
	{
	$gid="1004";
	$tabela_user="fonctionnaire";
	$cota_impressao="300";
	$cota_disco="500Mb";
	$cota_mail="100Mb";
	}

	if ($this->status_usuario=="administrativo")
	{
	$gid="1003";
	$tabela_user="fonctionnaire";
	$cota_impressao="9999";
	$cota_disco="500Mb";
	$cota_mail="100Mb";
	}
	if ($this->status_usuario=="visitor")
	{
	$gid="1002";
	$tabela_user="visitor";
	$cota_impressao="100";
	$cota_disco="100Mb";
	$cota_mail="50Mb";
	}

	if ($this->status_usuario=="student")
	{
	$tabela_user="student";
	$gid="1001";
	if ($this->tipo_contrato=="doutorado")
		{
		$cota_impressao="200";
		$cota_disco="500Mb";
		$cota_mail="100Mb";
		}
	if ($this->tipo_contrato=="mestrado")
		{
		$cota_impressao="100";
		$cota_disco="300Mb";
		$cota_mail="50Mb";
		}
	if (($this->tipo_contrato=="graduacao") or ($this->tipo_contrato=="verao"))
		{
		$cota_impressao="100";
		$cota_disco="300Mb";
		$cota_mail="50Mb";
		}
	}
     // $query="insert into unix values ('".$this->login."','".$this->passwd."',".$this->uid.",".$this->gid.",'".$this->class."','".$this->expire."',
       //                            '".$this->gecos."','".$this->homedir."','".$this->shell."','".$this->change."','".$this->coduser."')";
        $query_uid="select uid+1 from unix order by uid DESC  limit 1";
	$uid=pg_query($query_uid);
	$uid=pg_fetch_array($uid,0);
	$ssh="nao";  //valor default de acesso ao ssh
 	$query="insert into unix values 
('".$this->login."','".crypt($this->passwd)."','".$uid[0]."','".$gid."','1','','/home/".$this->login."','bash','".$this->coduser."','".$cota_impressao."','".$cota_disco."','".$cota_mail."','".$tabela_user."','".$ssh."')";
	$result=pg_query($query);
      $query_mail="insert into mail values ('".$this->login."@mat.unb.br','".$this->coduser."')";
	$result_mail=pg_query($query_mail);     
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
     function set_ssh ($ssh) { $this->ssh=($ssh)  ; }

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
     function get_ssh  () { return $this->ssh ; }
    
  }//c_unix

?>
