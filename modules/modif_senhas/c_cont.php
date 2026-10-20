<?php
  class c_conta_unix
  { 
     //The datas member. 
     var $login;       // The user's login name.
     var $passwd0;      // The encrypted passwd.
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
     var $cota_impressao; // cota de impressao
     var $cota_disco;   // espaço de disco
     var $cota_mail;    // espaço de mail
     var $ssh;    // acesso ao ssh

     //The c_unix function is the constructor. It allows to build the c_unix-object
     //and needs to have the login to the unix'user like parameter. This function will
     //be get the data in the data-base and will put them in the object.
     function get_unix ($login)
     {
       $query="select * from unix where login=?"; $query__p = array($login);
       $result=db_query($query, $query__p);
       $tab=db_fetch_array($result,0);
       $this->login=$tab['login'];
       $this->passwd0=$tab['passwd0'];
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
       $this->cota_impressao=$tab['cota_impressao'];
       $this->cota_disco=$tab['cota_disco'];
       $this->cota_mail=$tab['cota_mail'];
       $this->tabela_user=$tab['tabela_user'];
       $this->ssh=$tab['ssh'];
       db_free_result($result);
     }

     //The create_account function will record this object c_unix in the data-base.
     function update_account()
     {
     // $query="insert into unix values ('".$this->login."','".$this->passwd."',".$this->uid.",".$this->gid.",'".$this->class."','".$this->expire."',
       //                            '".$this->gecos."','".$this->homedir."','".$this->shell."','".$this->change."','".$this->coduser."')";

	// SEGURANCA: alvo sempre o usuario autenticado (sessao), nunca um coduser do cliente.
	$coduser = coduser_sessao();
	if ($coduser === null) {
		die(error("Sessao invalida."));
	}

	$query_confere_senha="select passwd from unix where coduser=?"; $query_confere_senha__p = array($coduser);
	$confere_senha=db_query($query_confere_senha, $query_confere_senha__p);
	$confere_senha_array=db_fetch_array($confere_senha,0);

	$senha_a_conferir=crypt($this->passwd0);
//echo "senha que esta no banco: ".$confere_senha_array[0];
//echo "";
//echo "senha que eu entrei como sendo a que esta no banco: ".$senha_a_conferir;
//echo "";
//echo "senha que eu quero conferir com a do banco: ".crypt($this->passwd0,$confere_senha_array[0]);
//echo "";

	if ((!empty($this->passwd)) and (crypt($this->passwd0,$confere_senha_array[0])==$confere_senha_array[0]))
//	if ((!empty($this->passwd)) and ($this->passwd0==$confere_senha_array[0]))
	{
	$query="update unix set passwd=?, \ncota_impressao=?,cota_disco=?,cota_mail=?,ssh=? where coduser=?"; $query__p = array(cripta_senha_unix($this->passwd), $this->cota_impressao, $this->cota_disco, $this->cota_mail, $this->ssh, $coduser);
	}
	else
	{
	$query="update unix set \ncota_impressao=?,cota_disco=?,cota_mail=?,ssh=? \nwhere coduser=?"; $query__p = array($this->cota_impressao, $this->cota_disco, $this->cota_mail, $this->ssh, $coduser);
	}
	$result=db_query($query, $query__p);
        }
	

     //The Set methods allows to access to datas members
     function set_login   ($login)   { $this->login=($login)     ; }
     function set_passwd  ($passwd)  { $this->passwd=($passwd)   ; }
     function set_passwd0  ($passwd0)  { $this->passwd0=($passwd0)   ; }
     function set_uid     ($uid)     { $this->uid=($uid)         ; }
     function set_gid     ($gid)     { $this->gid=($gid)         ; }
     function set_class   ($class)   { $this->class=($class)     ; }
     function set_change  ($change)  { $this->change=($change)   ; }
     function set_expire  ($expire)  { $this->expire=($expire)   ; }
     function set_gecos   ($gecos)   { $this->gecos=($gecos)     ; }
     function set_homedir ($homedir) { $this->homedir=($homedir) ; }
     function set_shell   ($shell)   { $this->shell=($shell)     ; }
     function set_coduser ($coduser) { $this->coduser=($coduser)  ; }
     function set_cota_impressao ($cota_impressao) { $this->cota_impressao =($cota_impressao)  ; }
     function set_cota_disco ($cota_disco) { $this->cota_disco =($cota_disco)  ; }
     function set_cota_mail ($cota_mail) { $this->cota_mail =($cota_mail)  ; }
     function set_tabela_user ($tabela_user) { $this->tabela_user =($tabela_user)  ; }
     function set_ssh ($ssh) { $this->ssh =($ssh)  ; }



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
     function get_cota_impressao () { return $this->cota_impressao ; }
     function get_cota_disco () { return $this->cota_disco  ; }
     function get_cota_mail () { return $this->cota_mail  ; }
     function get_ssh () { return $this->ssh  ; }
  
  }//c_unix

?>
