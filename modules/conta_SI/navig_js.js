function precedent(i)
{
         //si i est égal à 0, c'est qu'on est sur la 1ère fiche et on ne peut pas aller plus loin
         if(i==0)return i;
         //sinon, on décrémente i pour passer à la fiche précédente
         else return i-1;
}
function suivant(i,nb_enreg)
{
         //si i est égal à nb_enreg, c'est qu'on est sur la dernière fiche et on ne peut pas aller plus loin
         if(i==nb_enreg)return i;
         //sinon, on incrémente i pour passer à la fiche suivante
         else return i+1;
}

function conta(coduser)
{
        this.coduser = coduser;
	
}

function enregistrement(tableau,i,nb_enreg)
{
         if (i<=nb_enreg && i>=0)
         {
                document.utilisateur.coduser.value = tableau[i].coduser; 
//                document.utilisateur.login.value = tableau[i].login;
//                document.utilisateur.cota_impressao.value = tableau[i].cota_impressao;
//	        document.utilisateur.cota_disco1.value = tableau[i].cota_disco;
//                document.utilisateur.cota_mail1.value = tableau[i].cota_mail;
                document.utilisateur.noenreg.value= "Fiche " + (i+1) + " sur " + (nb_enreg+1);
         }
}

function modif_conta(login) 
//vetor,nb_perm)
{
        this.login = login;
//	for (k = 0;k < nb_perm;k++)
//	{
//        this.vetor=vetor[k];
//	}
//	this.nb_perm=nb_perm;
}

function enregistrement_modif(tableau,i,nb_enreg)
{
         if (i<=nb_enreg && i>=0)
         {
                document.utilisateur.login.value = tableau[i].login; 
//		for (k = 0;k < tableau[i].nb_perm;k++)
//		{
//                document.utilisateur.droits0.value = tableau[i].vetor;
//		}
//                document.utilisateur.cota_impressao.value = tableau[i].cota_impressao;
//	        document.utilisateur.cota_disco1.value = tableau[i].cota_disco;
//                document.utilisateur.cota_mail1.value = tableau[i].cota_mail;
                document.utilisateur.noenreg.value= "Fiche " + (i+1) + " sur " + (nb_enreg+1);
         }
}
