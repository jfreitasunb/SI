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
  if (document.forms["formu"].name.value.length == 0)
  {
    alert("Le champs correpsondant au nom du proprietaire du compte est obligatoire. Veuillez le renseigner, svp.");
    document.forms["formu"].name.focus();
    return false;
  }
  if (document.forms["formu"].firstname.value.length == 0)
  {
    alert("Le champs correpsondant au prenom du proprietaire du compte est obligatoire. Veuillez le renseigner, svp.");
    document.forms["formu"].firstname.focus();
    return false;
  }
  if (document.forms["formu"].adresse.value.length == 0)
  {
    alert("Le champs correpsondant a l'adresse du proprietaire du compte est obligatoire. Veuillez le renseigner, svp.");
    document.forms["formu"].adresse.focus();
    return false;
  }
  if (document.forms["formu"].cp.value.length == 0)
  {
    alert("Le champs correpsondant au code postal du proprietaire du compte est obligatoire. Veuillez le renseigner, svp.");
    document.forms["formu"].cp.focus();
    return false;
  }
  if (document.forms["formu"].city.value.length == 0)
  {
    alert("Le champs correpsondant au nom de la ville du proprietaire du compte est obligatoire. Veuillez le renseigner, svp.");
    document.forms["formu"].city.focus();
    return false;
  }
   if (document.forms["formu"].phone_work.value.length == 0)
  {
    alert("Le champs correpsondant au telephone du proprietaire du compte sur son lieu de travail est obligatoire. Veuillez le renseigner, svp.");
    document.forms["formu"].phone_work.focus();
    return false;
  }
 if (document.forms["formu"].phone_home.value.length == 0)
  {
    alert("Le champs correpsondant au telephone au domicile du proprietaire du compte est obligatoire. Veuillez le renseigner, svp.");
    document.forms["formu"].phone_home.focus();
    return false;
  }
  if (document.forms["formu"].matricul.value.length != 6)
  {
    document.forms["formu"].cpf.focus();
    return false;
  }
  if (document.forms["formu"].cpf.value.length == 0)
  {
    alert("Le champs correpsondant au numero cpf du proprietaire du compte est obligatoire. Veuillez le renseigner, svp.");
    document.forms["formu"].cpf.focus();
    return false;
  }
  if (document.forms["formu"].identity.value.length == 0)
  {
    alert("Le champs correpsondant au numero d'identite du proprietaire du compte est obligatoire. Veuillez le renseigner, svp.");
    document.forms["formu"].identity.focus();
    return false;
  }
   if (document.forms["formu"].mail1.value.length == 0)
  {
    alert("Le champs correpsondant au mail du proprietaire du compte est obligatoire. Veuillez le renseigner, svp.");
    document.forms["formu"].mail1.focus();
    return false;
  }
  return true;
}
