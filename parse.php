<?php

function parse($str){
        
  preg_match_all('#(?<![\d])\d{4}(?![??\d])#miu', $str, $code);
  preg_match_all('#(\d{1,},\d{1,}[??]|\d{1,}[??])#miu', $str, $sum);
  preg_match_all('#\d{11,}#miu', $str, $purse);
  return [
    'code'  => $code[0][0],
    'sum'   => $sum[0][0],
    'purse' => $purse[0][0],
  ];

};
