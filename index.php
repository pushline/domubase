<!DOCTYPE html>
<html><head><meta charset="utf-8"></head>
<body>
<h1>Teste</h1>




<form action="index.php" method="POST" enctype="multipart/form-data">
  Arquivo: <input type="file" required name="arquivo">
  <input type="submit" value="Salvar">
</form>


<br>
<br>

<form action="index.php" method="POST" enctype="multipart/form-data">
Pesquisar os dados gerais e o informe mensal:
<br><br>
<input type="text" name="pesquisar" placeholder="PESQUISAR">

<br><br>

<input type="submit" value="ENVIAR" name="pesquisa"><br><br>

<?php
$conn = new mysqli('localhost', 'root', '', 'jsonkk');

if (isset($_FILES['arquivo']))
{

    $file = $_FILES['arquivo']['tmp_name'];

    $json = file_get_contents($file);
    $post = json_decode($json);

    $query = "INSERT INTO json ( name, json) VALUES ('aaa', '$json')";
    mysqli_query($conn, $query);
}

////////////////////////
function getValuesArray(array $array)
{
    foreach ($array as $key => $value)
    {
        if (is_array($value) && count($value) > 0)
        {
            getValuesArray($value);
        }
        else
        {
            echo '<p>' . $key . ': ' . $value . "</p><br>\n";
        }
    }
}

function getValuesArray2(array $array){
    foreach ($array as $key => $value){
      if(is_array($value) && count($value) > 0){
          getValuesArray2($value);
      }
      else{
          echo '<p>' . $key . ': ' . $value . "</p><br>\n";
      }
    }
}
////////////////////////
if (isset($_POST['pesquisa']))
{
    $pesquisar = $_POST['pesquisar'];

    $result_fundos = "SELECT * FROM `json` as allData WHERE JSON_SEARCH(json, 'all', '%$pesquisar%') IS NOT NULL";
    $resultado = mysqli_query($conn, $result_fundos);
     while ($rows_fundos = mysqli_fetch_assoc($resultado))
    {
        // echo "Nome do Fundo: " . $rows_fundos['DadosGerais']['NomeFundo'] . "<br>";
        // echo PHP_EOL;

        var_dump($rows_fundos);
        $obj = json_encode($rows_fundos['allData']);       
        $allData = json_decode($rows_fundos['allData'], true);
        $dadosGerais = $allData['DadosGerais'];
        $informeMensal = $allData['InformeMensal'];

        getValuesArray($dadosGerais, $informeMensal);           


     }

}




?>
</form> 
</body>
</html>
