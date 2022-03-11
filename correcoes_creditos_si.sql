insert into oferta_lista_de_ofertas values(113018,'I','Noturno',979,2,2021,'46N12');
insert into oferta_lista_de_ofertas values(113034,'Q','Noturno',851,2,2021,'246N12');
insert into oferta_lista_de_ofertas values (113018,'N','Noturno',741,2,2021,'24N12');
insert into oferta_lista_de_ofertas values (113018,'N','Noturno',627,1,2021,'24N12');
delete from oferta_grupos_magistral_teoria where codigo=113018 and ano=2021 and semestre=2 and id=591;
update oferta_grupos_magistral_teoria set grupo=25 where codigo=113034 and semestre=2 and ano=2021 and id=608;
