|<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php

//Array principal sendo a primeira dimensão.
$multidimensionalArray = array(
  //Array numérico sendo a segunda dimensão.
  'numericArray' => array(
    'Item 1',
    'Item 2',
    'Item 3',
  ),
  //Array associativo sendo a segunda dimensão.
  'associativeArray' => array(
    'chave1' => 'valor1',
    'chave2' => 'valor2',
    'chave3' => 'valor3',
  ),
  //Array Associativo sendo a segunda dimensão.
  'sub_array_1' => array(
    //Array numérico sendo a terceira dimensão.
    'sub_array_2' => array(
    'Item 1',
    'Item 2',
    )
  )
);?>
<pre>
  <?= print_r($multidimensionalArray);?>
</pre>








    
</body>
</html>