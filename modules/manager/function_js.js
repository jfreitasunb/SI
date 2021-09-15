    function champsok()
    {
      if (document.forms["formu"].mod_name.value.length == 0)
      {
         alert("Le champs correpsondant au nom du module est obligatoire. Veuillez le renseigner, svp.");
         document.forms["formu"].mod_name.focus();
         return false;
      }
      if (document.forms["formu"].mod_url.value.length == 0)
      {
         alert("Le champs correpsondant a l'url du module est obligatoire. Veuillez le renseigner, svp.");
         document.forms["formu"].mod_url.focus();
         return false;
      }
      if (document.forms["formu"].descr.value.length == 0)
      {
         alert("Le champs correpsondant a la description du module est obligatoire. Veuillez le renseigner, svp.");
         document.forms["formu"].mod_name.focus();
         return false;
      }
      return true;
    }

  function montre()
      {
        if (count==1)
           document.getElementById("entete1").style.visibility="visible";
        if (count>1)
           document.getElementById("entete2").style.visibility="visible";
        document.getElementById("id"+count).style.visibility="visible";
        document.forms["formu"].nbadd.value=count;
        count++; 
      }

      function cache()
      {
        if (count!=1)count--;
        if (count==2)
           document.getElementById("entete2").style.visibility="hidden";
        if (count==1)
           document.getElementById("entete1").style.visibility="hidden";
        document.getElementById("id"+count).style.visibility="hidden";
        if  (count!=0)
          document.forms["formu"].nbadd.value=count-1;
        else
          document.forms["formu"].nbadd.value=count;
      }
