//This function allows to just have number
//function verif_touche(e)
//{
   //     if(e.keyCode)touche = e.keyCode;
     //   else touche = e.which;
       // if((touche>=48 && touche <= 57)||touche==9 || touche==8)return true;
      //  else return false;
//}

//This function allows to verify that a system is choiced
function controle_choix()
{
  if (  (document.forms["formu"].unix.checked)==false && (document.forms["formu"].samba.checked)==false && (document.forms["formu"].si.checked)==false )
  {
    alert("Au moins un des types de compte doit ete choisi. Veuillez le renseigner, svp.");
    document.forms["formu"].name.focus();
    return false;
  }
  return valid_form();
}

//This function allows to verify that the all formulary is not empty
function valid_form()
{
  if (document.forms["formu"].name.value.length ==0)
  {
    alert("O campo correspondente ao nome do usuario da conta e obrigatorio. Queira informa-lo, por favor.");
    document.forms["formu"].name.focus();
    return false;
  }
  if (document.forms["formu"].firstname.value.length == 0)
  {
    alert("O campo correspondente ao sobrenome do usuario da conta e obrigatorio. Queira informa-lo, por favor.");
    document.forms["formu"].firstname.focus();
    return false;
  }
  if (document.forms["formu"].adresse.value.length == 0)
  {
    alert("O campo correspondente ao endereco do usuario da conta e obrigatorio. Queira informa-lo, por favor.");
    document.forms["formu"].adresse.focus();
    return false;
  }
  if (document.forms["formu"].cp.value.length == 0)
  {
    alert("O campo correspondente ao CEP do usuario da conta e obrigatorio. Queira informa-lo, por favor.");
    document.forms["formu"].cp.focus();
    return false;
  }
  if (document.forms["formu"].city.value.length == 0)
  {
    alert("O campo correspondente a cidade de origem do usuario da conta e obrigatorio. Queira informa-lo, por favor.");
    document.forms["formu"].city.focus();
    return false;
  }
  /* if (document.forms["formu"].phone_work.value.length == 0)
  {
    alert("O campo correspondente ao telefone comercial do usuario da conta e obrigatorio. Queira informa-lo, por favor.");
    document.forms["formu"].phone_work.focus();
    return false;
  }*/
 if (document.forms["formu"].phone_home.value.length == 0)
  {
    alert("O campo correspondente ao telefone residencial do usuario da conta e obrigatorio. Queira informa-lo, por favor.");
    document.forms["formu"].phone_home.focus();
    return false;
  }
  if ((document.forms["formu"].matricul.value.length < 6) && (document.forms["formu"].status_usuario.value!="visitor"))  
  {
    alert("A matricula deve ser fornecida.");
    document.forms["formu"].matricul.focus();
    return false;
  }



  if ((document.forms["formu"].cpf.value.length == 0) && (document.forms["formu"].status_usuario.value!="visitor"))
  {
    alert("O campo correspondente ao cpf do usuario da conta e obrigatorio. Queira informa-lo, por favor.");
    document.forms["formu"].cpf.focus();
    return false;
  }
  if (document.forms["formu"].identity.value.length == 0)
  {
    alert("O campo correspondente a identidade do usuario da conta e obrigatorio. Queira informar a identidade ou o numero de passaporte, por 
favor.");
    document.forms["formu"].identity.focus();
    return false;
  }
 if ((document.forms["formu"].dia_dois.value.length ==0) ||(document.forms["formu"].mes_dois.value.length ==0) || (document.forms["formu"].ano_dois.value.length ==0))
  {
    alert("O campo correspondente a data e obrigatorio. Queira informa-lo, por favor.");
    document.forms["formu"].dia_dois.focus();
    return false;
  }
  /* if (document.forms["formu"].mail1.value.length == 0)
  {
    alert("O campo correspondente ao email do usuario da conta e obrigatorio. Queira informa-lo, por favor.");
    document.forms["formu"].mail1.focus();
    return false;
  }*/
  return true;
}
