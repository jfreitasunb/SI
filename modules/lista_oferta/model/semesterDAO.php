<?php

require_once $ROOT_PATH.'model/dao.php';

class SemesterTO extends stdClass{
	/**
	 * @var integer
	 */
	public $id;

	/**
	 * @var integer
	 */
	public $year;

	/**
	 * @var integer
	 */
	public $semester;

    /**
     * @var string
     */
    public $status;

    /**
     * @var string
     */
    public $beginning;

    /**
     * @var string
     */
    public $end;

	/**
	 * @var float
	 */
	public $average_credits;

	/**
	 * @var float
	 */
	public $reduction_credits;

	/**
	 * @var float
	 */
	public $publications_threshold;

}

class SemesterDAO extends DAO {
	const STATUS_CLOSED = 'closed';
	const STATUS_STAGE_1 = 'etapa1';
	const STATUS_STAGE_2 = 'etapa2';
	const STATUS_STAGE_3 = 'etapa3';

    /**
     * SemesterDAO constructor.
     */
    function __construct() {
		parent::__construct();

		$this->attributeMap["id"] = "codigo";
		$this->attributeMap["year"] = "ano";
		$this->attributeMap["semester"] = "semestre";
		$this->attributeMap["status"] = "status";
		$this->attributeMap["beginning"] = "de";
		$this->attributeMap["end"] = "ao";
		$this->attributeMap["average_credits"] = "carga_media";
		$this->attributeMap["reduction_credits"] = "abatimento_carga";
		$this->attributeMap["publications_threshold"] = "limiar_publicacoes";

		$this->table = "oferta_abertura_tela_lo";
	}
}