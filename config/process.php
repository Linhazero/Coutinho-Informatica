<?php

session_start();

include_once("connection.php");
include_once("url.php");


$data = $_POST;

// MODIFICAÇÕES NO BANCO
if(!empty($data)) {

  // Criar contato
  if($data["type"] === "create") {

    $nome = $data["nome"];
    $responsavel = $data["responsavel"];
    $telefone = $data["telefone"];
    $cpf = $data["cpf"];
    $cpf_responsavel = $data["cpf_responsavel"];
    $endereco = $data["endereco"];
    $email = $data["email"];
    $cadastro = $data["cadastro"];
    $curso = $data["curso"];
    $dias = $data["dias"];
    $horario = $data["horario"];
    $observacao = $data["observacao"];

    $query = "INSERT INTO testes (nome, responsavel, telefone, cpf, cpf_responsavel, endereco, email, cadastro, curso, dias, horario, observacao ) VALUES (:nome, :responsavel, :telefone, :cpf, :cpf_responsavel, :endereco, :email, :cadastro, :curso, :dias, :horario, :observacao)";

    $stmt = $conn->prepare($query);

    $stmt->bindParam(":nome", $nome);
    $stmt->bindParam(":responsavel", $responsavel);
    $stmt->bindParam(":telefone", $telefone);
    $stmt->bindParam(":cpf", $cpf);
    $stmt->bindParam(":cpf_responsavel", $cpf_responsavel);
    $stmt->bindParam(":endereco", $endereco);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":cadastro", $cadastro);
    $stmt->bindParam(":curso", $curso);
    $stmt->bindParam(":dias", $dias);
    $stmt->bindParam(":horario", $horario);
    $stmt->bindParam(":observacao", $observacao);

    try {

      $stmt->execute();
      $_SESSION["msg"] = "Aluno cadastrado com sucesso!";
  
    } catch(PDOException $e) {
      // erro na conexão
      $error = $e->getMessage();
      echo "Erro: $error";
    }
    
    //atualizando contato
  } else if($data["type"] === "edit") {

    
    $nome = $data["nome"];
    $responsavel = $data["responsavel"];
    $telefone = $data["telefone"];
    $cpf = $data["cpf"];
    $cpf_responsavel = $data["cpf_responsavel"];
    $endereco = $data["endereco"];
    $email = $data["email"];
    $cadastro = $data["cadastro"];
    $curso = $data["curso"];
    $dias = $data["dias"];
    $horario = $data["horario"];
    $observacao = $data["observacao"];
    $id = $data["id"];

    $query = "UPDATE testes 
              SET nome = :nome, responsavel = :responsavel, telefone = :telefone, cpf = :cpf, cpf_responsavel = :cpf_responsavel, endereco = :endereco, email = :email, cadastro = :cadastro, curso = :curso, dias = :dias, horario = :horario, observacao = :observacao 
              WHERE id = :id";

    $stmt = $conn->prepare($query);

    $stmt->bindParam(":nome", $nome);
    $stmt->bindParam(":responsavel", $responsavel);
    $stmt->bindParam(":telefone", $telefone);
    $stmt->bindParam(":cpf", $cpf);
    $stmt->bindParam(":cpf_responsavel", $cpf_responsavel);
    $stmt->bindParam(":endereco", $endereco);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":cadastro", $cadastro);
    $stmt->bindParam(":curso", $curso);
    $stmt->bindParam(":dias", $dias);
    $stmt->bindParam(":horario", $horario);
    $stmt->bindParam(":observacao", $observacao);
    $stmt->bindParam(":id", $id);

    try {

      $stmt->execute();
      $_SESSION["msg"] = "Aluno atualizado com sucesso!";
  
    } catch(PDOException $e) {
      // erro na conexão
      $error = $e->getMessage();
      echo "Erro: $error";
    }

  }/* else if($data["type"] === "delete") {

    $id = $data["id"];

    $query = "DELETE FROM infos WHERE id = :id";

    $stmt = $conn->prepare($query);

    $stmt->bindParam(":id", $id);
    
    try {

      $stmt->execute();
      $_SESSION["msg"] = "Contato removido com sucesso!";
  
    } catch(PDOException $e) {
      // erro na conexão
      $error = $e->getMessage();
      echo "Erro: $error";
    }

  }
*/
  // Redirect HOME
  header("Location:" . $BASE_URL . "../index.php");

// SELEÇÃO DE DADOS
} else {
  
  $id;

  if(!empty($_GET)) {
    $id = $_GET["id"];
  }

  // Retorna o dado de um contato
  if(!empty($id)) {

    $query = "SELECT * FROM testes WHERE id = :id";

    $stmt = $conn->prepare($query);

    $stmt->bindParam(":id", $id);

    $stmt->execute();

    $info = $stmt->fetch();

  } else {

    // Retorna todos os contatos
    $infos = [];

    $query = "SELECT * FROM testes";

    $stmt = $conn->prepare($query);

    $stmt->execute();
    
    $infos = $stmt->fetchAll();

  }

}

// FECHAR CONEXÃO
$conn = null;
