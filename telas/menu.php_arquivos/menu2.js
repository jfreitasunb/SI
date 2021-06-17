function ClicRub(nu_rub) 
{
  with(parent) 
  {
    if ((menu[nu_rub].page!="")&&(menu[nu_rub].aff=="N")) 
    {
      frames['right'].location.href=menu[nu_rub].page
    }
    if (menu[nu_rub].aff=="O")
    {
      menu[nu_rub].aff="N"
    }
    else 
    {
         menu[nu_rub].aff="O";
     }
   }
  if (parent.menu[nu_rub].nb_lien>0)
  {
    window.location=document.location;
  }
}

function AffImg(img) 
{
  document.write("<img src='../img/"+img+"' border=0 align='top' vspace=0>");
}

function Aff(men) 
{
  for(var i=0;i<men.nb_rub;i++) 
  {
    if (men[i].aff=="N") 
    {
      document.write("<A HREF='javascript:ClicRub("+i+")' class=menu>");
      // document.write("<A HREF='accueil.php' target='right' onclick='javascript:ClicRub("+i+")' class=menu>");
      AffImg(men.imgF);
      document.write(men[i].txt+"</A><BR>");
    }
    else 
    {
      document.write("<A HREF='javascript:ClicRub("+i+")' class=menu>");
      AffImg(men.imgO);
      document.write(men[i].txt+"</A><BR>");
      for(var j=0;j<men[i].nb_lien;j++) 
      {
        if (j==men[i].nb_lien-1)
        {
          AffImg(men.imgOptFin);
        }
        else
        {
          AffImg(men.imgOpt);
        }
        document.write("<A target='right' HREF='"+men[i][j].page+"' class=menu>");
        document.write(men[i][j].txt+"</A><BR>");
      }
      document.write("</FONT>");
    }
  }
}
