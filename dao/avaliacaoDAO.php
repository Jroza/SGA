<?php
/**
 * Created by PhpStorm.
 * User: aluno
 * Date: 28/09/2018
 * Time: 21:59
 */
require_once "db/conexao.php";
require_once "alunoDAO.php";
require_once "turmaDAO.php";
require_once "cursoDAO.php";
class avaliacaoDAO
{
    public function remover($curso){
        global $pdo;
        try {
            $statement = $pdo->prepare("DELETE FROM avaliacao WHERE idAvaliacao = :id");
            $statement->bindValue(":id", $curso->getId());
            if ($statement->execute()) {
                return "Registo foi excluído com êxito";
            } else {
                throw new PDOException("Erro: Não foi possível executar a declaração sql");
            }
        } catch (PDOException $erro) {
            return "Erro: ".$erro->getMessage();
        }
    }

    public function save($curso){
        global $pdo;
        try {
            if ($curso->getId() != "") {
                $statement = $pdo->prepare("UPDATE `sga`.`avaliacao`
                                                        SET
                                                        `Curso_idCurso` = :Curso_idCurso,
                                                        `Turma_idTurma` = :Turma_idTurma,
                                                        `Aluno_idAluno` = :Aluno_idAluno,
                                                        `Nota1` = :Nota1,
                                                        `Nota2` = :Nota2,
                                                        `NotaFinal` = :NotaFinal
                                                        WHERE `idAvaliacao` = :id;");
                $statement->bindValue(":id", $curso->getId());
            } else {
                $statement = $pdo->prepare("INSERT INTO `sga`.`avaliacao`
                                                            (`Curso_idCurso`,
                                                            `Turma_idTurma`,
                                                            `Aluno_idAluno`,
                                                            `Nota1`,
                                                            `Nota2`,
                                                            `NotaFinal`)
                                                            VALUES
                                                            (:Curso_idCurso,
                                                            :Turma_idTurma,
                                                            :Aluno_idAluno,
                                                            :Nota1,
                                                            :Nota2,
                                                            :NotaFinal);
                                                            ");
            }
            $statement->bindValue(":Curso_idCurso",$curso->getCurso());
            $statement->bindValue(":Turma_idTurma",$curso->getTurma());
            $statement->bindValue(":Aluno_idAluno",$curso->getAluno());
            $statement->bindValue(":Nota1",$curso->getNota01());
            $statement->bindValue(":Nota2",$curso->getNota02());
            $statement->bindValue(":NotaFinal",$curso->getNotaFinal());

            if ($statement->execute()) {
                if ($statement->rowCount() > 0) {
                    return "Dados cadastrados com sucesso!";
                } else {
                    return "Erro ao tentar efetivar cadastro";
                }
            } else {
                throw new PDOException("Erro: Não foi possível executar a declaração sql");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public static function all()
    {
        global $pdo;
        try {
            $cidades = $pdo->prepare("SELECT * FROM avalicao;");
            if ($cidades->execute()) {
                return $cidades->fetchall(PDO::FETCH_OBJ);
            } else {
                throw new PDOException("<script> alert('Não foi possível executar a declaração SQL !');</script>");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }

    }

    public function atualizar($curso){
        global $pdo;
        try {
            $statement = $pdo->prepare("SELECT    `avaliacao`.`Curso_idCurso`,
                                                            `avaliacao`.`Turma_idTurma`,
                                                            `avaliacao`.`Aluno_idAluno`,
                                                            `avaliacao`.`Nota1`,
                                                            `avaliacao`.`Nota2`,
                                                            `avaliacao`.`NotaFinal`
                                                        FROM `sga`.`avaliacao`
                                                        WHERE idAvaliacao  = :id;");
            $statement->bindValue(":id", $curso->getId());
            if ($statement->execute()) {
                $rs = $statement->fetch(PDO::FETCH_OBJ);
                $curso->setId($rs->id);
                $curso->setCurso($rs->Curso_idCurso);
                $curso->setTurma($rs->Turma_idTurma);
                $curso->setAluno($rs->Aluno_idAluno);
                $curso->setNota01($rs->Nota1);
                $curso->setNota02($rs->Nota2);
                $curso->setNotaFinal($rs->NotaFinal);
                return $curso;
            } else {
                throw new PDOException("Erro: Não foi possível executar a declaração sql");
            }
        } catch (PDOException $erro) {
            return "Erro: ".$erro->getMessage();
        }
    }

    public function tabelapaginada() {

        //carrega o banco
        global $pdo;

        //endereço atual da página
        $endereco = $_SERVER ['PHP_SELF'];

        /* Constantes de configuração */
        define('QTDE_REGISTROS', 10);
        define('RANGE_PAGINAS', 1);

        /* Recebe o número da página via parâmetro na URL */
        $pagina_atual = (isset($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;

        /* Calcula a linha inicial da consulta */
        $linha_inicial = ($pagina_atual -1) * QTDE_REGISTROS;

        /* Instrução de consulta para paginação com MySQL */
        $sql = "select a.idAvaliacao as codigo,
                        c.Nome as curso,
                        t.Nome as turma ,
                        al.Nome as aluno,
                        a.Nota1,
                        a.Nota2,
                        a.NotaFinal
                        from avaliacao a 
                        inner join curso c on a.Curso_idCurso = c.idCurso
                        inner join turma t on a.Turma_idTurma = t.idTurma
                        inner join aluno al on a.Aluno_idAluno = al.idAluno
            LIMIT {$linha_inicial}, " . QTDE_REGISTROS;
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $dados = $statement->fetchAll(PDO::FETCH_OBJ);

        /* Conta quantos registos existem na tabela */
        $sqlContador = "SELECT COUNT(*) AS total_registros FROM avaliacao";
        $statement = $pdo->prepare($sqlContador);
        $statement->execute();
        $valor = $statement->fetch(PDO::FETCH_OBJ);

        /* Idêntifica a primeira página */
        $primeira_pagina = 1;

        /* Cálcula qual será a última página */
        $ultima_pagina  = ceil($valor->total_registros / QTDE_REGISTROS);

        /* Cálcula qual será a página anterior em relação a página atual em exibição */
        $pagina_anterior = ($pagina_atual > 1) ? $pagina_atual -1 : 0 ;

        /* Cálcula qual será a pŕoxima página em relação a página atual em exibição */
        $proxima_pagina = ($pagina_atual < $ultima_pagina) ? $pagina_atual +1 : 0 ;

        /* Cálcula qual será a página inicial do nosso range */
        $range_inicial  = (($pagina_atual - RANGE_PAGINAS) >= 1) ? $pagina_atual - RANGE_PAGINAS : 1 ;

        /* Cálcula qual será a página final do nosso range */
        $range_final   = (($pagina_atual + RANGE_PAGINAS) <= $ultima_pagina ) ? $pagina_atual + RANGE_PAGINAS : $ultima_pagina ;

        /* Verifica se vai exibir o botão "Primeiro" e "Pŕoximo" */
        $exibir_botao_inicio = ($range_inicial < $pagina_atual) ? 'mostrar' : 'esconder';

        /* Verifica se vai exibir o botão "Anterior" e "Último" */
        $exibir_botao_final = ($range_final > $pagina_atual) ? 'mostrar' : 'esconder';

        if (!empty($dados)):
            echo "
     <table class='table table-striped table-bordered'>
     <thead>
       <tr class='active'>
        <th>Código</th>
        <th>Aluno</th>
        <th>Curso</th>
        <th>Turma</th>
        <th>Nota 01</th>
        <th>Nota 02</th>
        <th>NF</th>
        <th>Situação</th>
        <th colspan='2'>Ações</th>
       </tr>
     </thead>
     <tbody>";
            foreach($dados as $inst):
               $media  = ($inst->Nota1 + $inst->Nota1) /2;
                $nf = '';
                if($media >=7){
                   $nf = 'Aprovado';
               }elseif ($media <= 4){
                    $nf = 'Reprovado';
                }
                elseif(($media + $inst->NotaFinal) / 2 >=6){
                    $nf =  'Aprovado';
                }

                echo "<tr>
        <td>$inst->codigo</td>
        <td>$inst->aluno</td>
        <td>$inst->curso</td>
        <td>$inst->turma</td>
        <td>$inst->Nota1</td>
        <td>$inst->Nota2</td>
        <td>$inst->NotaFinal</td>
        <td>$nf</td>
        <td><a href='?act=upd&id=$inst->codigo'><i class='ti-reload'></i></a></td>
        <td><a href='?act=del&id=$inst->codigo'><i class='ti-close'></i></a></td>
       </tr>";
            endforeach;
            echo"
</tbody>
     </table>

     <div class='box-paginacao'>
       <a class='box-navegacao  $exibir_botao_inicio' href='$endereco?page=$primeira_pagina' title='Primeira Página'>Primeira</a>
       <a class='box-navegacao $exibir_botao_inicio' href='$endereco?page=$pagina_anterior' title='Página Anterior'>Anterior</a>
";

            /* Loop para montar a páginação central com os números */
            for ($i=$range_inicial; $i <= $range_final; $i++):
                $destaque = ($i == $pagina_atual) ? 'destaque' : '' ;
                echo "<a class='box-numero $destaque' href='$endereco?page=$i'>$i</a>";
            endfor;

            echo "<a class='box-navegacao $exibir_botao_final' href='$endereco?page=$proxima_pagina' title='Próxima Página'>Próxima</a>
       <a class='box-navegacao $exibir_botao_final' href='$endereco?page=$ultima_pagina' title='Última Página'>Último</a>
     </div>";
        else:
            echo "<p class='bg-danger'>Nenhum registro foi encontrado!</p>
     ";
        endif;

    }

}