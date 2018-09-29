<?php
include_once "estrutura/Template.php";
require_once "dao/professorDAO.php";
require_once "classes/professor.php";

$template = new Template();
$object = new professorDAO();

$template->header();
$template->sidebar();
$template->navbar();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
    $nome = (isset($_POST["nome"]) && $_POST["nome"] != null) ? $_POST["nome"] : "";
    $cargo = (isset($_POST["cargo"]) && $_POST["cargo"] != null) ? $_POST["cargo"] : "";
} else if (!isset($id)) {
    $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
    $nome = NULL;
    $cargo = NULL;
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id != "") {
    echo 'tetetetetetete';
    $professor = new professor($id, '', '');
    $resultado = $object->atualizar($professor);
    $nome = $resultado->getNome();
    $cargo = $resultado->getCargo();
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $nome != "" && $cargo != "") {
    $professor = new professor($id,$nome,$cargo);
    $msg = $object->save($professor);
    $id = null;
    $nome = null;
    $cargo = null;
}

if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id != "") {
    $professor = new professor($id, '', '');
    $msg = $object->remover($professor);
    $id = null;
}

?>

<div class='content' xmlns="http://www.w3.org/1999/html">
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-md-12'>
                <div class='card'>
                    <div class='header'>
                        <h4 class='title'>Professores</h4>
                        <p class='category'>Lista de professores do sistema</p>
                    </div>
                    <div class='content table-responsive'>
                        <form action="?act=save" method="POST" name="form1">
                            <hr>
                            <i class="ti-save"></i>
                            <input type="hidden" size="5" name="id" value="<?php
                            echo (isset($id) && ($id != null || $id != "")) ? $id : '';
                            ?>"/>
                            Nome:
                            <input type="text" size="50" name="nome" value="<?php
                            echo (isset($nome) && ($nome != null || $nome != "")) ? $nome : '';
                            ?>"/>
                            <label for="cargo">Cargo:</label>
                            <select id="cargo" name="cargo">
                                <option value="PROFESSOR ASSISTENTE I" <?php if (isset($cargo) && $cargo == "PROFESSOR ASSISTENTE I") echo 'selected' ?>>
                                    PROFESSOR ASSISTENTE I
                                </option>
                                <option value="PROFESSOR ASSISTENTE II" <?php if (isset($cargo) && $cargo == "PROFESSOR ASSISTENTE II") echo 'selected' ?>>
                                    PROFESSOR ASSISTENTE II
                                </option>
                                <option value="PROFESSOR ADJUNTO I" <?php if (isset($cargo) && $cargo == "PROFESSOR ADJUNTO I") echo 'selected' ?> >
                                    PROFESSOR ADJUNTO I
                                </option>
                                <option value="PROFESSOR ADJUNTO II" <?php if (isset($cargo) && $cargo == "PROFESSOR ADJUNTO II") echo 'selected' ?>>
                                    PROFESSOR ADJUNTO II
                                </option>
                                <option value="PROFESSOR TITUTLAR I" <?php if (isset($cargo) && $cargo == "PROFESSOR TITULAR I") echo 'selected' ?>>
                                    PROFESSOR TITUTLAR I
                                </option>
                                <option value="PROFESSOR TITUTLAR II" <?php if (isset($cargo) && $cargo == "PROFESSOR TITULAR II") echo 'selected' ?>>
                                    PROFESSOR TITUTLAR II
                                </option>
                                <option value="PROFESSOR TITUTLAR III" <?php if (isset($cargo) && $cargo == "PROFESSOR TITULAR III") echo 'selected' ?>>
                                    PROFESSOR TITUTLAR III
                                </option>
                            </select>
                            <input type="submit" VALUE="Cadastrar"/>
                            <hr>
                        </form>
                        <?php
                        echo (isset($msg) && ($msg != null || $msg != "")) ? $msg : '';
                        $object->tabelapaginada();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



