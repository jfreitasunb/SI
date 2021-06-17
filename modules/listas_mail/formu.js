function saisie_cpf(cpf)
{
        var car="";
        var format=true;
        var i=0;
        var retour="";
        while(i<cpf.length && format)
        {
               car  = car + cpf.charAt(i);
               if(i==3||i==7)
               {
                   if(cpf.charAt(i)!=".")
                   {
                        alert("Formato errado!\n Digitar o numero na forma xxx.xxx.xxx-xx");
                        format=false;
                        retour="";
                   }
                   else retour = car;
                }
                if(i==11)
                {
                  if(cpf.charAt(i)!="-")
                   {
                        alert("Formato errado!\n Digitar o numero na forma xxx.xxx.xxx-xx");
                        format=false;
                        retour="";
                   }
                   else retour = car;
                }
                else
                {
                     if(i==2||i==6)
                     {
                       retour = car + ".";
                     }
                     else
                     {
                        if(i==10)
                        {
                           retour = car + "-";
                        }
                        else
                        {
                           retour = car;
                        }
                     }
                }
                i++;
        }
        return retour;
}

/*function verif_data(e)
{
        if(e.keyCode)touche = e.keyCode;
        else touche = e.which;
        if((touche <>0 && touche <= 2)||touche==4) return true;
        else return false;
}
*/
function verif_touche(e)
{
        if(e.keyCode)touche = e.keyCode;
        else touche = e.which;
        if((touche>=48 && touche <= 57)||touche==9 || touche==8)return true;
        else return false;
}

function verif_log(e)
{
        if(e.keyCode)touche = e.keyCode;
        else touche = e.which;
        if((touche>=48 && touche <= 57)||touche==9 || touche==8 || (touche>= 97 && touche <= 122))return true;
        else return false;
}

function verif_mail(mail)
{
        if(mail=="")return "";
         var valide=true;
        var i=0;
         while((i<mail.length) && (valide))
        {
                if( (mail.charAt(i)=="'")||(mail.charAt(i)==",")||(mail.charAt(i)=="é")||(mail.charAt(i)=="è")||(mail.charAt(i)=="~"))
                {
                        valide=false;
                }
                i++;
        }
         if(!valide)
        {
                alert("E-mail invalido");
                return "";
        }
         if((mail.indexOf(".")==-1)||(mail.indexOf("@")==-1))
        {
                alert("E-mail invalido");
                return "";
        }
        return mail;
}

function prem_lettre_majuscule(chaine)
{
         var nouveau = chaine.charAt(0).toUpperCase();
         var i;
         for (i=1;i<chaine.length;i++)
         {
         	nouveau = nouveau + chaine.charAt(i);
         }
         return nouveau;
}
