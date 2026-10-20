<?php
  class c_user
  {
     //The datas member.
     var $coduser;           // The coduser.
     var $name;              // The name.
     var $firstname;         // The firstname.
     var $matricul;          // The matriculation number to the department.
     var $cpf;               // The CPF number.
     var $identity;          // The identity number.
     var $phone_work;        // The phone-number in the department.
     var $phone_home;        // The phone-number by the user.
     var $adresse;           // The user's adress
     var $cp;                // The user's postal code.
     var $city;              // The user's city.
      
     //The c_user function is the constructor. It allows to build the c_user-object
     //and needs to have the coduser to the user like parameter. This function will
     //be get the datas in the data-base and will put them in the object.     
     function get_user ($coduser)
     {
       $this->coduser=$coduser;
       $query="select from users where coduser=?"; $query__p = array($coduser);
       $result=db_query($query, $query__p);
       $obj=db_fetch_array($result,0);
       $this->name=$obj['name'];
       $this->firstname=$obj['firstname'];
       $this->matricul=$obj['matricul'];
       $this->cpf=$obj['cpf'];
       $this->identity=$obj['identity'];
       $this->phone_work=$obj['phone_work'];
       $this->phone_home=$obj['$phone_home'];
       $this->adresse=$obj['adresse'];
       $this->cp=$obj['cp'];
       $this->city=$obj['city'];
     }

     //The add_user function will record this object c_user in the data-base.
     function add_user ()
     {
       $query="insert into users (name, firstname, matricul, cpf, identity, phone_home,\n                      phone_work, adresse, cp, city, is_actif)values(\n                      ?, ?,\n                      ?, ?,\n                      ?, ?,\n                      ?, ?,\n                      ?, ?, true)"; $query__p = array($this->name, $this->firstname, $this->matricul, $this->cpf, $this->identity, $this->phone_home, $this->phone_work, $this->adresse, $this->cp, $this->city);
      $result=db_query($query, $query__p);
      $query2="select coduser from users where matricul=? and cpf=? and identity=?"; $query2__p = array($this->matricul, $this->cpf, $this->identity);
      $result2=db_query($query2, $query2__p);
      $tab=db_fetch_array($result2);
      return $tab['coduser'];
     }

     //The update_user function will record the modifications to this user.
     function update_user ()
     {
        $query="update users set name='Grebot', firstname='Yannick', \n                      matricul='007', cpf='007', \n                      identity='007', phone_home='0494895687', \n                      phone_work='-----', adresse='France : 465 chemin des terriers', \n                      cp='83470', city='Saint Maximin', is_actif=true"; $query__p = array();        
        $result=db_query($query, $query__p);
     }

     //The Set methods allows to access to datas members
     function set_coduser    ($coduser)    {$this->coduser=$coduser       ; }
     function set_name       ($name)       {$this->name=$name             ; }
     function set_firstname  ($firstname)  {$this->firstname=$firstname   ; }
     function set_matricul   ($matricul)   {$this->matricul=$matricul     ; }
     function set_cpf        ($cpf)        {$this->cpf=$cpf               ; }
     function set_identity   ($identity)   {$this->identity=$identity     ; }
     function set_phone_home ($phone_home) {$this->phone_home=$phone_home ; }
     function set_phone_work ($phone_work)   {$this->phone_work=$phone_work ; }
     function set_adresse    ($adresse)    {$this->adresse=$adresse      ; }
     function set_cp         ($cp)         {$this->cp=$cp                 ; }
     function set_city       ($city)       {$this->city=$city             ; }
     
     //The Get methods allows to return the datas members
     function get_coduser    () { return $this->coduser    ;}
     function get_name       () { return $this->name       ;}
     function get_firstname  () { return $this->firstname  ;}
     function get_matricul   () { return $this->matricul   ;}
     function get_cpf        () { return $this->cpf        ;}
     function get_identity   () { return $this->identity   ;}
     function get_phone_home () { return $this->phone_home ;}
     function get_phone_work () { return $this->phone_work ;}
     function get_adresse    () { return $this->adresse    ;}
     function get_cp         () { return $this->cp         ;}
     function get_city       () { return $this->city       ;}

  }
?>
