

//This function allows to verify that the all formulary is not empty
function valid_form()
{
  if (document.forms["utilisateur"].instituicao.value.length ==0)
  {
    alert("O campo correspondente a instituicao e obrigatorio. Queira informa-lo, por favor.");
    document.forms["utilisateur"].instituicao.focus();
    return false;
  }
  if (document.forms["utilisateur"].cidade.value.length == 0)
  {
    alert("O campo correspondente a cidade e obrigatorio. Queira informa-lo, por favor.");
    document.forms["utilisateur"].cidade.focus();
    return false;
  }
  if (document.forms["utilisateur"].estado.value.length == 0)
  {
    alert("O campo correspondente ao estado e obrigatorio. Queira informa-lo, por favor.");
    document.forms["utilisateur"].estado.focus();
    return false;
  }
  if ((document.forms["utilisateur"].dia_ida.value.length == 0)||(document.forms["utilisateur"].mes_ida.value.length == 0)||(document.forms["utilisateur"].ano_ida.value.length == 0))
  {
    alert("O campo correspondente a data de ida e obrigatorio. Queira informa-lo, por favor.");
    document.forms["utilisateur"].dia_ida.focus();
    return false;
  }
  if ((document.forms["utilisateur"].dia_volta.value.length == 0)||(document.forms["utilisateur"].mes_volta.value.length == 0)||(document.forms["utilisateur"].ano_volta.value.length == 0))
  {
    alert("O campo correspondente a data de retorno e obrigatorio. Queira informa-lo, por favor.");
    document.forms["utilisateur"].dia_volta.focus();
    return false;
  }
  return true;
}
