function CreerMenu(imgO,imgF,imgOption,imgOptionFin)
{
  this.nb_rub=0;
  this.imgO=imgO;
  this.imgF=imgF;
  this.imgOpt=imgOption;
  this.imgOptFin=imgOptionFin;
  this.AddRub=AddRubrique;
  this.AddLien=AddLink;
}

function AddRubrique(txt,aff)
{
   var rub = new Object;
   rub.txt=txt;
   rub.aff=aff;
   rub.page="accueil.php";
   rub.nb_lien=0;
   this[this.nb_rub]=rub;
   this.nb_rub++;
}

function AddLink(txt,page)
{
   var no_rub = this.nb_rub-1;
   var no_lien= this[no_rub].nb_lien;
   var lien = new Object;
   lien.txt=txt;
   lien.page=page;
   lien.target="right";
   this[no_rub][no_lien]=lien;
   this[no_rub].nb_lien++;
}
