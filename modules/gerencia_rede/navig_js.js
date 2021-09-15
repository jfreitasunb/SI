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

function users(maqcod,ipnet,codloc,host,mac1,mac2,mac3,mac4,mac5,mac6,mouse,keyboard,layout_teclado,resolucao,tipo_maquina,dia,mes,ano)
{
        this.maqcod = maqcod;
        this.ipnet = ipnet;
	this.codloc = codloc;
	this.host = host;
	this.mac1 = mac1;
	this.mac2 = mac2;
	this.mac3 = mac3;
	this.mac4 = mac4;
	this.mac5 = mac5;
	this.mac6 = mac6;
	this.mouse = mouse;
	this.keyboard = keyboard;
	this.layout_teclado = layout_teclado;
	this.resolucao = resolucao;
	this.tipo_maquina = tipo_maquina;
	this.dia = dia;
	this.mes = mes;
	this.ano = ano;
}

function enregistrement(tableau,i,nb_enreg)
{
         if (i<=nb_enreg && i>=0)
         {
                document.utilisateur.patrimonio.value = tableau[i].maqcod;
                document.utilisateur.ipnet.value = tableau[i].ipnet;
                document.utilisateur.sala0.value = tableau[i].codloc;
	        document.utilisateur.host.value = tableau[i].host;
                document.utilisateur.mac1.value = tableau[i].mac1;
                document.utilisateur.mac2.value = tableau[i].mac2;
                document.utilisateur.mac3.value = tableau[i].mac3;
                document.utilisateur.mac4.value = tableau[i].mac4;
                document.utilisateur.mac5.value = tableau[i].mac5;
                document.utilisateur.mac6.value = tableau[i].mac6;
                document.utilisateur.mouse0.value = tableau[i].mouse;
                document.utilisateur.teclado0.value = tableau[i].keyboard;
                document.utilisateur.layout_teclado0.value = tableau[i].layout_teclado;
                document.utilisateur.resolucao0.value = tableau[i].resolucao;
                document.utilisateur.id_maquina0.value = tableau[i].tipo_maquina;
                document.utilisateur.dia.value = tableau[i].dia;
                document.utilisateur.mes.value = tableau[i].mes;
                document.utilisateur.ano.value = tableau[i].ano;
                document.utilisateur.noenreg.value= "Fiche " + (i+1) + " sur " + (nb_enreg+1);
         }
}



