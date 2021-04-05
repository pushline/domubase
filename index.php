<!DOCTYPE html>
<html><head><meta charset="utf-8"></head>
<body>
<h1>Teste</h1>
<?php

if(isset($_FILES['arquivo'])){

$conn = new mysqli('localhost', 'root', '', 'jsonkk');

$file = $_FILES['arquivo']['tmp_name'];

    $json = file_get_contents($file);
    $post = json_decode($json); 
    
        $query = "INSERT INTO json ( name, json) VALUES ('aaa', '$json')";
        mysqli_query($conn, $query);
}
?>

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

function getValuesArray(array $array){
  foreach ($array as $key => $value){
      if(is_array($value) && count($value) > 0){
          getValuesArray($value);
      }
      else{
        echo '<p>' . $key . ': ' . $value . "</p><br>\n";
      }
  }
}


          if(isset($_POST['pesquisa'])){
               $pesquisar = $_POST['pesquisar'];


                  $result_fundos = "SELECT JSON_UNQUOTE(JSON_EXTRACT(json, '$.DadosGerais.NomeFundo')) as nomefundo FROM json"; 
                      $resultado = mysqli_query($conn, $result_fundos);
                      
                      while($rows_fundos = mysqli_fetch_assoc($resultado)){
                          echo "Nome do Fundo: ".$rows_fundos['nomefundo']."<br>";
                            echo PHP_EOL;
                            echo PHP_EOL;
                        
                            $sql = "SELECT JSON_EXTRACT(json, '$.DadosGerais') as dataAll FROM json";
                      $resultado = mysqli_query($conn, $sql);
                          $dados_gerais = array();
                  while($dado = mysqli_fetch_assoc($resultado)) {
                  $dados_gerais[] = $dado;
        }

          $dadosGerais = json_decode($dados_gerais[0]['dataAll'], true);

          getValuesArray($dadosGerais);
                        
                      
                          }

    }
  
?>
</form> 

</body>
</html>

 