function precedent(i)
{
         //si i est ?al ?0, c'est qu'on est sur la 1?e fiche et on ne peut pas aller plus loin
         if(i==0)return i;
         //sinon, on d?r?ente i pour passer ?la fiche pr??ente
         else return i-1;
}
function suivant(i,nb_enreg)
{
         //si i est ?al ?nb_enreg, c'est qu'on est sur la derni?e fiche et on ne peut pas aller plus loin
         if(i==nb_enreg)return i;
         //sinon, on incr?ente i pour passer ?la fiche suivante
         else return i+1;
}

function conta(coduser,login,cota_impressao,cota_disco,cota_mail,ssh)
{
        this.coduser = coduser;
        this.login = login;
	this.cota_impressao = cota_impressao;
	this.cota_disco = cota_disco;
	this.cota_mail = cota_mail;
	this.ssh = ssh;
		
}

function enregistrement(tableau,i,nb_enreg)
{
         if (i<=nb_enreg && i>=0)
         {
                document.utilisateur.coduser.value = tableau[i].coduser; 
                document.utilisateur.login.value = tableau[i].login;
                document.utilisateur.cota_impressao.value = tableau[i].cota_impressao;
	        document.utilisateur.cota_disco1.value = tableau[i].cota_disco;
                document.utilisateur.cota_mail1.value = tableau[i].cota_mail;
                document.utilisateur.ssh1.value = tableau[i].ssh;
                document.utilisateur.noenreg.value= "Fiche " + (i+1) + " sur " + (nb_enreg+1);
         }
}
