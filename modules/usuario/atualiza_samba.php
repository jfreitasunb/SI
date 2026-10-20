<?php

// funcoes para criptografar e salvar no banco

 function ntPasswordHash($password) 
    {
        return pack('H*',hash('md4', str2unicode($password)));
    }
    
    /**
     * Converts ascii to unicode.
     *
     * @access public
     * @return string
     */
    function str2unicode($str) 
    {
        $uni = '';
        $str = (string) $str;
        for ($i = 0; $i < strlen($str); $i++) {
            $a = ord($str{$i}) << 8;
            $uni .= sprintf("%X", $a);
        }
        return pack('H*', $uni);
    }


  function lmPasswordHash($password)
    {
        $plain = $password;

        $plain = substr(strtoupper($plain), 0, 14);
        while (strlen($plain) < 14) {
             $plain .= "\0";
        }

        return _desHash(substr($plain, 0, 7)) . _desHash(substr($plain, 7, 7));
    }

   function _desHash($plain)
    {
        $key = _desAddParity($plain);
        $td = mcrypt_module_open(MCRYPT_DES, '', MCRYPT_MODE_ECB, '');
        $iv = mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td, $key, $iv);
        $hash = mcrypt_generic($td, 'KGS!@#$%');
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        return $hash;
    }

    /**
     * Adds the parity bit to the given DES key.
     *
     * @access private
     * @param  string  $key 7-Bytes Key without parity
     * @return string
     */
    function _desAddParity($key)
    {
        static $odd_parity = array(
                1,  1,  2,  2,  4,  4,  7,  7,  8,  8, 11, 11, 13, 13, 14, 14,
                16, 16, 19, 19, 21, 21, 22, 22, 25, 25, 26, 26, 28, 28, 31, 31,
                32, 32, 35, 35, 37, 37, 38, 38, 41, 41, 42, 42, 44, 44, 47, 47,
                49, 49, 50, 50, 52, 52, 55, 55, 56, 56, 59, 59, 61, 61, 62, 62,
                64, 64, 67, 67, 69, 69, 70, 70, 73, 73, 74, 74, 76, 76, 79, 79,
                81, 81, 82, 82, 84, 84, 87, 87, 88, 88, 91, 91, 93, 93, 94, 94,
                97, 97, 98, 98,100,100,103,103,104,104,107,107,109,109,110,110,
                112,112,115,115,117,117,118,118,121,121,122,122,124,124,127,127,
                128,128,131,131,133,133,134,134,137,137,138,138,140,140,143,143,
                145,145,146,146,148,148,151,151,152,152,155,155,157,157,158,158,
                161,161,162,162,164,164,167,167,168,168,171,171,173,173,174,174,
                176,176,179,179,181,181,182,182,185,185,186,186,188,188,191,191,
                193,193,194,194,196,196,199,199,200,200,203,203,205,205,206,206,
                208,208,211,211,213,213,214,214,217,217,218,218,220,220,223,223,
                224,224,227,227,229,229,230,230,233,233,234,234,236,236,239,239,
                241,241,242,242,244,244,247,247,248,248,251,251,253,253,254,254);

        $bin = '';
        for ($i = 0; $i < strlen($key); $i++) {
            $bin .= sprintf('%08s', decbin(ord($key{$i})));
        }

        $str1 = explode('-', substr(chunk_split($bin, 7, '-'), 0, -1));
        $x = '';
        foreach($str1 as $s) {
            $x .= sprintf('%02s', dechex($odd_parity[bindec($s . '0')]));
        }

        return pack('H*', $x);

    }

  function update_account($login,$password)
     {
	echo "estou no update_account"; //.hash('md4', str2unicode($password));
       $nt_hash=ntPasswordHash($password);
       echo "o nt_has e: ".$nt_hash;
       $lan_hash=lmPasswordHash($password);
       echo "o lan_hash e: ".$lan_hash;
       $query="insert into samba_test values(?,?,?)"; $query__p = array($login, $lan_hash, $nt_hash);
       echo $query;
       $result=db_query($query, $query__p);
       db_free_result($result);
     }

// fim funcoes cript e salvar no banco
?>

