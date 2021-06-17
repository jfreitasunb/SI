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

function users(coduser,name,firstname,matricul,cpf,identity,phone_work,phone_home,adresse,cp,city,mail1,mail2,mail3,mail4,status_usuario,tipo_contrato,data_de_entrada,dia_dois,mes_dois,ano_dois,especialidade,funcional,prof_orientador,prof_orientador2,bolsista,situacao,fim_credencia_dia,fim_credencia_mes,fim_credencia_ano,orientacao)
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
        this.mail1 = mail1;
        this.mail2 = mail2;
        this.mail3 = mail3;
        this.mail4 = mail4;
        this.status_usuario = status_usuario;
        this.tipo_contrato = tipo_contrato;
        this.data_de_entrada = data_de_entrada;
        this.dia_dois = dia_dois;
        this.mes_dois = mes_dois;
        this.ano_dois = ano_dois;
        this.especialidade = especialidade;
        this.funcional = funcional;
        this.prof_orientador = prof_orientador;
	this.prof_orientador2 = prof_orientador2;
        this.bolsista = bolsista;
        this.situacao=situacao;
	this.fim_credencia_dia = fim_credencia_dia;
	this.fim_credencia_mes = fim_credencia_mes;
	this.fim_credencia_ano = fim_credencia_ano;
	this.orientacao = orientacao;
        console.log(this.orientacao);
	}

function enregistrement(tableau,i,nb_enreg)
{
         if (i<=nb_enreg && i>=0)
         {
                document.utilisateur.user.value = tableau[i].coduser;                
		document.utilisateur.coduser.value = tableau[i].coduser;
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
//                if (tableau[i].unix!=0) {document.utilisateur.unix.checked = true;} else {document.utilisateur.unix.checked = false ;}
//                if (tableau[i].si!=0) { document.utilisateur.si.checked = true; } else { document.utilisateur.si.checked = false;}
//                if (tableau[i].samba!=0){document.utilisateur.samba.checked = true;}else {document.utilisateur.samba.checked = false;}
	        document.utilisateur.mail1.value = tableau[i].mail1;
	        document.utilisateur.mail2.value = tableau[i].mail2;
	        document.utilisateur.mail3.value = tableau[i].mail3;
	        document.utilisateur.mail4.value = tableau[i].mail4;
	        document.utilisateur.status_usuario.value = tableau[i].status_usuario;
	        document.utilisateur.tipo_contrato1.value = tableau[i].tipo_contrato;
	        document.utilisateur.data_de_entrada.value = tableau[i].data_de_entrada;
	        document.utilisateur.dia_dois.value = tableau[i].dia_dois;
	        document.utilisateur.mes_dois.value = tableau[i].mes_dois;
	        document.utilisateur.ano_dois.value = tableau[i].ano_dois;
	        document.utilisateur.especialidade1.value = tableau[i].especialidade;
	        document.utilisateur.funcional1.value = tableau[i].funcional;
		document.utilisateur.fim_credencia_dia.value = tableau[i].fim_credencia_dia;
		document.utilisateur.fim_credencia_mes.value = tableau[i].fim_credencia_mes;
		document.utilisateur.fim_credencia_ano.value = tableau[i].fim_credencia_ano;
		document.utilisateur.orientacao.value = tableau[i].orientacao;
	        document.utilisateur.prof_orientador1.value = tableau[i].prof_orientador;
		document.utilisateur.prof_orientador2.value = tableau[i].prof_orientador2;
	        document.utilisateur.bolsista1.value = tableau[i].bolsista;
	        document.utilisateur.situacao1.value = tableau[i].situacao;
                // document.utilisateur.noenreg.value= "Fiche " + (i+1) + " sur " + (nb_enreg+1);
                console.log(document)
         }
}



