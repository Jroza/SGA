<?php
/**
 * Created by PhpStorm.
 * User: aluno
 * Date: 28/09/2018
 * Time: 21:51
 */

class avaliacao
{
    private $id;
    private $curso;
    private $turma;
    private $aluno;
    private $nota01;
    private $nota02;
    private $notaFinal;

    /**
     * avaliacao constructor.
     * @param $id
     * @param $curso
     * @param $turma
     * @param $aluno
     * @param $nota01
     * @param $nota02
     * @param $notaFinal
     */
    public function __construct($id, $curso, $turma, $aluno, $nota01, $nota02, $notaFinal)
    {
        $this->id = $id;
        $this->curso = $curso;
        $this->turma = $turma;
        $this->aluno = $aluno;
        $this->nota01 = $nota01;
        $this->nota02 = $nota02;
        $this->notaFinal = $notaFinal;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getCurso()
    {
        return $this->curso;
    }

    /**
     * @param mixed $curso
     */
    public function setCurso($curso): void
    {
        $this->curso = $curso;
    }

    /**
     * @return mixed
     */
    public function getTurma()
    {
        return $this->turma;
    }

    /**
     * @param mixed $turma
     */
    public function setTurma($turma): void
    {
        $this->turma = $turma;
    }

    /**
     * @return mixed
     */
    public function getAluno()
    {
        return $this->aluno;
    }

    /**
     * @param mixed $aluno
     */
    public function setAluno($aluno): void
    {
        $this->aluno = $aluno;
    }

    /**
     * @return mixed
     */
    public function getNota01()
    {
        return $this->nota01;
    }

    /**
     * @param mixed $nota01
     */
    public function setNota01($nota01): void
    {
        $this->nota01 = $nota01;
    }

    /**
     * @return mixed
     */
    public function getNota02()
    {
        return $this->nota02;
    }

    /**
     * @param mixed $nota02
     */
    public function setNota02($nota02): void
    {
        $this->nota02 = $nota02;
    }

    /**
     * @return mixed
     */
    public function getNotaFinal()
    {
        return $this->notaFinal;
    }

    /**
     * @param mixed $notaFinal
     */
    public function setNotaFinal($notaFinal): void
    {
        $this->notaFinal = $notaFinal;
    }




}