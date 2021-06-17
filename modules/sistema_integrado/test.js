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
                        alert("Mauvais format!\nVeuillez saisir le numero au format xxx.xxx.xxx-xx");
                        format=false;
                        retour="";
                   }
                   else retour = car;
                }
                if(i==11)
                {
                  if(cpf.charAt(i)!="-")
                   {
                        alert("Mauvais format!\nVeuillez saisir le numero au format xxx.xxx.xxx-xx");
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

//verifie la validité du format de tel sur la perte de focus du champ
//FONCTION A APPELER SUR l'EVENEMENT "ONBLUR"
function format_tel(tel)
{
        //si la chaine, on renvoie "" (cas ou l'on ne saisi pas de tel) pour ne pas envoyer de message d'erreur
        if(tel=="") return "";
        //sinon, si la longueure de la chaine n'est pas de 14 caractères (chiffres+espaces)
        if(tel.length!=14)
        {
                //on envoie un message d'erreur et on réinitialise le champ à chaine vide
                alert("Mauvais format!\nVeuillez saisir le numero au format xx xx xx xx xx");
                return "";
        }
        //sinon, on valide le format en renvoyant la chaine
        else return tel;
}

/*fonction de saisie semi automatique de la date avec vérification de format*/
//FONCTION A APPELER SUR l'EVENEMENT "ONKEYUP"
function saisie_date(date)
{

        var car="";
        var format=true;
        var i=0;
        var retour="";
        while(i<date.length && format)
        {
                car  = car+ date.charAt(i);
                switch(i)
                {
                case 1 :{
                                jour = date.substring(0,2);
                                if(((jour*1)<=0) || ((jour*1)>31))
                                {
                                        alert("jour invalide !\nLe jour doit etre compris entre 01 et 31");
                                        format = false;
                                        retour = "";
                                }
                                else retour = car  + "/";
                                break;
                            }
                case 2 :{
                                if(date.charAt(i)!="/")
                                {
                                        alert("Mauvais format de date!\nVeuillez saisir la date au format jj/mm/aaaa");
                                        format=false;
                                        retour="";
                                }
                                else retour=car;
                                break;
                           }
                case 4 :{
                                mois = date.substring(3,5);
                                if(((mois*1)<=0) || ((mois*1)>12))
                                {
                                        alert("Mois invalide !\nLe mois doit etre compris entre 01 et 12");
                                        format = false;
                                        retour = date.substring(0,3);
                                }
                                else retour = car  + "/";
                                break;
                           }
                case 5 :{
                                if(date.charAt(i)!="/")
                                 {
                                        alert("Mauvais format de date!\nVeuillez saisir la date au format jj/mm/aaaa");
                                        format=false;
                                        retour="";
                                }
                                else retour=car;
                                break;
                        }
                case 9 :{
                                annee = date.substring(6,10);
                                if(((annee*1)<=1950) || ((annee*1)>2020))
                                {
                                        alert("Année invalide !\nL'année doit etre comprise entre 1950 et 2020");
                                        format = false;
                                        retour = date.substring(0,6);
                                }
                                else retour = car;
                                break;
                        }
                default :{
                                retour = car;
                                break;
                           }
                }
                i++;
        }
        return retour;
}

function format_date(date)
{
         if(date=="")return "";
         if(date.length!=10)
         {
                alert("Mauvais format de date!\nVous devez saisir la date au format jj/mm/aaaa");
                return "";
         }
         return date;
}





/*verification de la validité de l'email*/
function verif_mail(mail)
{
        if(mail=="")return "";
        /*initialisation des variables*/
        var valide=true;
        var i=0;
        /*on parcours la chaine de caractères tant que l'on arrive pas à la fin ou tant que l'on 
        ne trouve pas un des caractères ci apres*/
        while((i<mail.length) && (valide))
        {
        	if( (mail.charAt(i)=="'")||(mail.charAt(i)==",")||(mail.charAt(i)=="é")||(mail.charAt(i)=="è")||(mail.charAt(i)=="~"))
                {
                	valide=false;
                }
                i++;
        }
        /*on teste le drapeau, si il est à faux, c'est que l'email n'est pas valide*/
        if(!valide)
        {
        	alert("E-mail non valide");
                return "";
        }
        /*on teste la présence des caractères "." et "@" qui doivent etre obligatoires*/
        if((mail.indexOf(".")==-1)||(mail.indexOf("@")==-1))
        {
        	alert("E-mail non valide");
                return "";
        }
        return mail;
}

