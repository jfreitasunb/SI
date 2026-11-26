<?php
// Equivalencia de codigos das disciplinas do MAT: SIGAA (MAT0025) -> SIGRA (113034).
//
// Uso, em qualquer script:
//   require_once __DIR__ . '/codigos_disciplinas_sigaa.php';
//   $codigos = codigos_disciplinas_sigaa();          // tabela inteira
//   $sigra   = codigo_sigra_da_disciplina('MAT0025'); // '113034', ou null se nao houver
//
// Para incluir ou corrigir uma disciplina, altere so esta tabela.

function codigos_disciplinas_sigaa()
{
    return array(
        'MAT0002' => '105317',
        'MAT0006' => '113825',
        'MAT0010' => '105881',
        'MAT0022' => '113018',
        'MAT0023' => '113026',
        'MAT0025' => '113034',
        'MAT0026' => '113042',
        'MAT0027' => '113051',
        'MAT0028' => '113069',
        'MAT0031' => '113093',
        'MAT0034' => '113107',
        'MAT0038' => '113115',
        'MAT0039' => '113123',
        'MAT0040' => '113131',
        'MAT0041' => '113158',
        'MAT0045' => '113204',
        'MAT0046' => '113212',
        'MAT0047' => '113263',
        'MAT0050' => '113328',
        'MAT0053' => '113417',
        'MAT0054' => '113433',
        'MAT0057' => '113506',
        'MAT0059' => '113522',
        'MAT0060' => '113603',
        'MAT0061' => '113611',
        'MAT0066' => '113671',
        'MAT0068' => '113689',
        'MAT0069' => '113697',
        'MAT0072' => '113808',
        'MAT0075' => '113824',
        'MAT0076' => '113832',
        'MAT0077' => '113841',
        'MAT0078' => '113859',
        'MAT0080' => '113930',
        'MAT0081' => '113948',
        'MAT0082' => '113972',
        'MAT0087' => '117013',
        'MAT0091' => '117030',
        'MAT0097' => '117056',
        'MAT0098' => '117064',
        'MAT0099' => '117072',
        'MAT0100' => '117081',
        'MAT0101' => '117099',
        'MAT0102' => '117102',
        'MAT0103' => '117111',
        'MAT0105' => '117129',
        'MAT0106' => '117137',
        'MAT0107' => '117145',
        'MAT0111' => '117161',
        'MAT0114' => '117170',
        'MAT0115' => '117293',
        'MAT0117' => '117307',
        'MAT0118' => '117323',
        'MAT0119' => '117358',
        'MAT0120' => '117412',
        'MAT0122' => '117421',
        'MAT0124' => '117439',
        'MAT0125' => '117447',
        'MAT0126' => '117455',
        'MAT0127' => '117463',
        'MAT0129' => '117471',
        'MAT0131' => '117480',
        'MAT0132' => '117498',
        'MAT0134' => '117501',
        'MAT0136' => '117510',
        'MAT0137' => '113034',
        'MAT0139' => '139',
        'MAT0140' => '140',
        'MAT0141' => '141',
        'MAT0142' => '200142',
        'MAT0143' => '200143',
        'MAT0144' => '200144',
        'MAT0163' => '163',
        'MAT0164' => '164',
        'MAT0166' => '166',
        'MAT0174' => '174',
        'MAT0141' => '117141',
    );
}

function codigo_sigra_da_disciplina($codigo_sigaa)
{
    static $codigos = null;
    if ($codigos === null) {
        $codigos = codigos_disciplinas_sigaa();
    }
    $codigo_sigaa = strtoupper(trim((string)$codigo_sigaa));
    return isset($codigos[$codigo_sigaa]) ? $codigos[$codigo_sigaa] : null;
}
