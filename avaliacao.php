<?php
/**
 * Created by PhpStorm.
 * User: aluno
 * Date: 28/09/2018
 * Time: 21:26
 */

include_once "estrutura/Template.php";
require_once "dao/avaliacaoDAO.php";
require_once "classes/avaliacao.php";

$template = new Template();
$object = new avaliacaoDAO();

$template->header();
$template->sidebar();
$template->navbar();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
    $curso = (isset($_POST["curso"]) && $_POST["curso"] != null) ? $_POST["curso"] : "";
    $turma = (isset($_POST["turma"]) && $_POST["turma"] != null) ? $_POST["turma"] : "";
    $aluno = (isset($_POST["aluno"]) && $_POST["aluno"] != null) ? $_POST["aluno"] : "";
    $nota01 = (isset($_POST["nota01"]) && $_POST["nota01"] != null) ? $_POST["nota01"] : "";
    $nota02 = (isset($_POST["nota02"]) && $_POST["nota02"] != null) ? $_POST["nota02"] : "";
    $notaFinal = (isset($_POST["notaFinal"]) && $_POST["notaFinal"] != null) ? $_POST["notaFinal"] : "";
} else if (!isset($id)) {
    $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
    $curso = null;
    $turma = null;
    $aluno = null;
    $nota01 = null;
    $nota02 = null;
    $notaFinal = null;
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id != "") {
    echo 'tetetetetetete';
    $avaliacao = new avaliacao($id,'','','','','','');
    $resultado = $object->atualizar($avaliacao);
    $curso = $resultado->getCurso();
    $turma = $resultado->getTurma();
    $aluno = $resultado->getAluno();
    $nota01 = $resultado->getNota01();
    $nota02 = $resultado->getNota02();
    $notaFinal = $resultado->getNotaFinal();
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save"
    && $curso!= ""
    && $turma != ""
    && $aluno != ""
    && $nota01 != ""
    && $nota02 != ""
    && $notaFinal != "") {
    $avaliacao = new avaliacao($id,$curso,$turma
                                        ,$aluno
                                        ,$nota01
                                        ,$nota02
                                        ,$notaFinal);
    $msg = $object->save($avaliacao);
    $id = null;
    $curso = null;
    $turma = null;
    $aluno = null;
    $nota1 = null;
    $nota02 = null;
    $notaFinal = null;
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id != "") {
    $avaliacao = new avaliacao($id,'','','','','','');
    $msg = $object->remover($avaliacao);
    $id = null;
}

?>

<div class='content' xmlns="http://www.w3.org/1999/html">
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-md-12'>
                <div class='card'>
                    <div class='header'>
                        <h4 class='title'>Avaliações</h4>
                        <p class='category'>Lista de avaliações do sistema</p>
                    </div>
                    <div class="content table-responsive">
                        <form action="?act=save" method="POST" name="formAvaliacao">
                            <hr>
                            <i class="ti-save"></i>
                            <input type="hidden" size="5" name="id" value="<?php
                            echo (isset($id) && ($id != null || $id != "")) ? $id : '';
                            ?>"/>
                            <div class="form-group">
                                <label for="curso">Curso:</label>
                                <select class="form-control" name="curso" id="curso" required>
                                    <option value="">Selecione...</option>
                                    <?php
                                    $result = cursoDAO::all();
                                    if (isset($result)) {
                                        foreach ($result as $rs) {
                                            echo "<option value='$rs->idCurso'>$rs->Nome</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="turma">Turma:</label>
                                <select class="form-control" name="turma" id="turma" required>
                                    <option value="">Selecione...</option>
                                    <?php
                                    $result = turmaDAO::all();
                                    if (isset($result)) {
                                        foreach ($result as $rs) {
                                            echo "<option value='$rs->idTurma'>$rs->Nome</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="aluno">Aluno:</label>
                                <select class="form-control" name="aluno" id="aluno" required>
                                    <option value="">Selecione...</option>
                                    <?php
                                    $result = alunoDAO::all();
                                    if (isset($result)) {
                                        foreach ($result as $rs) {
                                            echo "<option value='$rs->idAluno'>$rs->Nome</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="nota01">Nota 01:</label>
                                <input class="form-control" id="nota01"  name="nota01" type="number" min="0" step="0.01" required>
                            </div>
                            <div class="form-group">
                                <label for="nota02">Nota 02:</label>
                                <input  class="form-control" id="nota02"  name="nota02" type="number" min="0" step="0.01" required>
                            </div>
                            <div class="form-group">
                                <label for="notaFinal">Nota da Prova Final:</label>
                                <input class="form-control" id="notaFinal"  name="notaFinal" type="number" min="0" step="0.01" required>
                            </div>
                            <button type="submit">Salvar</button>
                        </form>
                    </div>
                    <?php
                    echo (isset($msg) && ($msg != null || $msg != "")) ? $msg : '';
                    $object->tabelapaginada();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>




