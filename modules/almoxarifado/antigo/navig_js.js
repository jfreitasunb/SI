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

function users(coduser,name,firstname,matricul,cpf,identity,phone_work,phone_home,adresse,cp,city,si,unix,samba)
{
        this.coduser = coduser;
        this.name = name;
	this.firstname = firstname;
	this.matricul = matricul;
	this.cpf = cpf;
	this.identity = identity;
	this.phone_work = phone_work;
	this.phone_home = phone_home;
	this.adresse = adresse;
	this.cp = cp;
	this.city = city;
        this.si = si; 
        this.unix = unix;
        this.samba = samba;
}

function enregistrement(tableau,i,nb_enreg)
{
         if (i<=nb_enreg && i>=0)
         {
                document.utilisateur.user.value = tableau[i].coduser; 
                document.utilisateur.name.value = tableau[i].name;
                document.utilisateur.firstname.value = tableau[i].firstname;
	        document.utilisateur.adresse.value = tableau[i].adresse;
                document.utilisateur.cp.value = tableau[i].cp;
                document.utilisateur.city.value = tableau[i].city;
                document.utilisateur.matricul.value = tableau[i].matricul;
                document.utilisateur.cpf.value = tableau[i].cpf;
                document.utilisateur.identity.value = tableau[i].identity;
                document.utilisateur.phone_work.value = tableau[i].phone_work;
                document.utilisateur.phone_home.value = tableau[i].phone_home;
                if (tableau[i].unix!=0) {document.utilisateur.unix.checked = true;} else {document.utilisateur.unix.checked = false ;}
                if (tableau[i].si!=0) { document.utilisateur.si.checked = true; } else { document.utilisateur.si.checked = false;}
                if (tableau[i].samba!=0){document.utilisateur.samba.checked = true;}else {document.utilisateur.samba.checked = false;}
                document.utilisateur.noenreg.value= "Fiche " + (i+1) + " sur " + (nb_enreg+1);
         }
}
