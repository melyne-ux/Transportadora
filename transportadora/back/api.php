<?php
//CONFIGURAÇÃO
//DEFINE A RESPOSTA DA API, NESSE CASO EM JSON
header("Content-Type: application/json;charset=utf-8");
//DEFINE O ACESSO DA API, NESSE * QUER DIZER TODAS AS ORIGENS
header("Access-Control-Allow-Origin: *");
// DEFINE OS METODOS QUE PODEM SER FEITOS NA API
header("Access-Allow-Methods: GET, POST, DELETE");

require "config.php";

$rota = $_GET["rota"] ?? "";
$metodo = $_SERVER["REQUEST_METHOD"];

//VARIAVEL PARA CAPTURAR AS INFORMAÇÕES DAS REQUISIÇÕES 
$corpo = json_decode(file_get_contents("php://input"), true) ?? [];

function teste(){
    echo json_encode(["mensagem" => "Back-end respodendo com sucesso¹" ]);
    exit;
}

//FUNÇÕES - CRUD
function createCliente($con, $dados){
    $stmt = $con->prepare(
        "INSERT INTO CLIENTE (NOME, ENDERECO, TELEFONE, EMAIL)
        VALUES (?,?,?,?)"
    );
    $stmt->execute([$dados["nome"],
    $dados["endereco"],
    $dados["telefone"],
    $dados["email"]]);

    http_response_code(201);
    echo json_encode(
        ["mensagem" => "Cliente criado com sucesso!",
        "id" => $con-> lastInsertId()]
    );
}
function readCliente($con){
    $stmt = $con->query("SELECT * FROM Cliente");
    echo json_encode( $stmt->fetchAll(PDO::FETCH_ASSOC)
    );
}
function updateCliente($con, $id, $dados){
    $stmt = $con->prepare(
        "UPDATE Cliente SET nome = ?, endereco = ?, telefone = ?, email = ?
        WHERE idCliente = ?"
    );
    $stmt->execute([   $dados["nome"],
                       $dados["endereco"],
                       $dados["telefone"],
                       $dados["email"],
                       $id]);
    echo json_encode(["mensagem" => "Cliente criado com sucesso!"]);
}

//DELETE CLIENTE 
function deleteCliente($con, $id){
    $stmt= $con->prepare("DELETE FROM Cliente WHERE idCliente = ?");
    $stmt->execute([$id]);
    echo json_encode(["mensagem" => "Cliente removido com sucesso!"]);
}
//ROTAS NOMEADAS
if ($rota === "cliente") {
    switch($metodo){
        case "POST":
            createCliente($con, $corpo);
            break;
        case "GET":
            readCliente($con);
            break;
        case "PUT":
            updateCliente($con, $_GET["id"], $corpo);
            break;
        case "DELETE":
            deleteCliente($con, $_GET["id"]);
            break;
        default:
            teste();
    }

}
else if($rota === "funcionario");

//FUNÇÕES - CRUD

function createFuncionario($con, $dados){
    $stmt = $con->prepare(
        "INSERT INTO FUNCIONARIO (NOME, CARGO, SALARIO)
        VALUES (?,?,?)"
    );
    $stmt->execute([$dados["nome"],
    $dados["cargo"],
    $dados["salario"]]);

    http_response_code(201);
    echo json_encode(
        ["mensagem" => "Funcionario criado com sucesso!",
        "id" => $con-> lastInsertId()]
    );
}
function readFuncionario($con){
    $stmt = $con->query("SELECT * FROM Funcionario");
    echo json_encode( $stmt->fetchAll(PDO::FETCH_ASSOC)
    );
}
function updateFuncionario($con, $id, $dados){
    $stmt = $con->prepare(
        "UPDATE Funcionario SET nome = ?, cargo = ?, salario = ?
         WHERE idFuncionario = ?"
    );
    $stmt->execute([   $dados["nome"],
                       $dados["cargo"],
                       $dados["salario"],
                       $id]);
    echo json_encode(["mensagem" => "Funcionario cadastrado com sucesso!"]);
}

//DELETE CLIENTE 
function deleteFuncionario($con, $id){
    $stmt= $con->prepare("DELETE FROM Funcionario WHERE idFuncionario = ?");
    $stmt->execute([$id]);
    echo json_encode(["mensagem" => "Funcionario removido com sucesso!"]);
}
//ROTAS NOMEADAS
if ($rota === "funcionario") {
    switch($metodo){
        case "POST":
            createFuncionario($con, $corpo);
            break;
        case "GET":
            readFuncionario($con);
            break;
        case "PUT":
            updateFuncionario($con, $_GET["id"], $corpo);
            break;
        case "DELETE":
            deleteFuncionario($con, $_GET["id"]);
            break;
        default:
            teste();
    }

}