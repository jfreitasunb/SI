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
  var form = document.forms["formu"];
  if (form.name && form.name.value.trim().length == 0)
  {
    alert("O campo correspondente ao nome do usuario da conta e obrigatorio. Queira informa-lo, por favor.");
    form.name.focus();
    return false;
  }
  if (form.firstname && form.firstname.value.trim().length == 0)
  {
    alert("O campo correspondente ao sobrenome do usuario da conta e obrigatorio. Queira informa-lo, por favor.");
    form.firstname.focus();
    return false;
  }
  if (form.adresse && form.adresse.value.trim().length == 0)
  {
    alert("O campo correspondente ao endereco do usuario da conta e obrigatorio. Queira informa-lo, por favor.");
    form.adresse.focus();
    return false;
  }
  if (form.cp && form.cp.value.trim().length == 0)
  {
    alert("O campo correspondente ao CEP do usuario da conta e obrigatorio. Queira informa-lo, por favor.");
    form.cp.focus();
    return false;
  }
  if (form.city && form.city.value.trim().length == 0)
  {
    alert("O campo correspondente a cidade de origem do usuario da conta e obrigatorio. Queira informa-lo, por favor.");
    form.city.focus();
    return false;
  }
  /* if (form.phone_work.value.length == 0)
  {
    alert("O campo correspondente ao telefone comercial do usuario da conta e obrigatorio. Queira informa-lo, por favor.");
    form.phone_work.focus();
    return false;
  }*/
  if (form.phone_home && form.phone_home.value.trim().length == 0)
  {
    alert("O campo correspondente ao telefone residencial do usuario da conta e obrigatorio. Queira informa-lo, por favor.");
    form.phone_home.focus();
    return false;
  }
  if (form.matricul)
  {
    var matricul = form.matricul.value.trim();
    if (matricul.length == 0)
    {
      alert("O campo correspondente ao numero de matricula e obrigatorio. Queira informa-lo, por favor.");
      form.matricul.focus();
      return false;
    }
    if (matricul.length < 6 && (!form.status_usuario || form.status_usuario.value != "visitor"))
    {
      alert("A matricula deve ter no minimo 6 caracteres.");
      form.matricul.focus();
      return false;
    }
  }
  if (form.cpf && form.cpf.value.trim().length == 0)
  {
    alert("O campo correspondente ao cpf do usuario da conta e obrigatorio. Queira informa-lo, por favor.");
    form.cpf.focus();
    return false;
  }
  if (form.identity && form.identity.value.trim().length == 0)
  {
    alert("O campo correspondente a identidade do usuario da conta e obrigatorio. Queira informar a identidade ou o numero de passaporte, por favor.");
    form.identity.focus();
    return false;
  }
  if (form.dia_dois && form.mes_dois && form.ano_dois &&
      (form.dia_dois.value.trim().length == 0 || form.mes_dois.value.trim().length == 0 || form.ano_dois.value.trim().length == 0))
  {
    alert("O campo correspondente a data e obrigatorio. Queira informa-lo, por favor.");
    form.dia_dois.focus();
    return false;
  }
  /* if (form.mail1.value.length == 0)
  {
    alert("O campo correspondente ao email do usuario da conta e obrigatorio. Queira informa-lo, por favor.");
    form.mail1.focus();
    return false;
  }*/
  return true;
}
