<?php
function add_user($file, $line)
{
  $fd=fopen($file, 'a');
  fwrite($fd, $line);
  fclose($fd);  
}

function modif_user($file, $line, $login)
{

  //array  explode ( string   separator  , string   string  , int   limit  )

  $filetemp="../temp.temp";
  touch($filetemp);
  $fdt=fopen($filetemp,"w+");

  $fd=fopen($file, 'r');
  while (!feof ($fd)) 
  {
    $buffer = fgets($fd, 4096);
    $array= explode (';', $buffer);
    if ($array[0]!=$login)
    {
      fwrite($fdt,$buffer);
    }
    else 
    {
      fwrite($fdt,$line."\n");
    }
  }
  fclose($fd); 
  fclose($fdt);
  unlink ($file);
  rename($filetemp,$file);
} 

function getid()
{
  $lines=exec("pw nextuser");
  echo $lines;  
}

function getshells()
{
  echo "<select>";
  exec("cat /etc/shells", $tab);
  foreach ($tab as $i)
    if($i[0]=='/')
      echo "<option>".$i."</option>";
  echo "</select>";
}

function unix_srypt($pass)
{
  return $pass=crypt ($pass,"yann");
}

//modif_user("../test", "rororo", "greyan ");
$pass="root";
echo $pass."<br>";
$pass=md5($pass);
echo $pass."<br>";
echo unix_srypt("test");
echo "aaaaaaaa".chr(13)."aaaaaaaaaaaaa";
getshells() ;

?>
