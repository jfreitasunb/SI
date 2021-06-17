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

function users(coduser,name,firstname,matricul)
{
        this.coduser = coduser;
        this.name = name;
	this.firstname = firstname;
	this.matricul = matricul;
}

function enregistrement(tableau,i,nb_enreg)
{
         if (i<=nb_enreg && i>=0)
         {
                document.utilisateur.user.value = tableau[i].coduser;
                document.utilisateur.name.value = tableau[i].name;
                document.utilisateur.firstname.value = tableau[i].firstname;
                document.utilisateur.matricul.value = tableau[i].matricul;
                document.utilisateur.noenreg.value= "Fiche " + (i+1) + " sur " + (nb_enreg+1);
         }
}



