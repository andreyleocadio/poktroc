<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pokemon extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$pga=0;
		$itensPorPagina = 20;
		
		if(isset($_GET['pga'])){
			$pga=$_GET['pga'];
		}
		if(isset($_GET['itensPorPagina'])){
			$itensPorPagina=$_GET['itensPorPagina'];
		}
		$pagina = $pga*$itensPorPagina;
		$d["titulo"] = "Listar Pokemon's";
		$d["pagina"] = "listar";
		$d['itensPorPagina'] = $itensPorPagina;
		$d['pga'] = $pga;
		$d['pokemons'] = carregar('https://pokeapi.co/api/v2/pokemon/?offset='.$pagina."&limit=".$itensPorPagina);
		
		$this->load->view('index',$d);
	}
	
	public function getPok()
	{
		iniAjax();
		$url = $_GET['url'];
		$d['retorno'] = carregar($url);
		$detalhes = $this->load->view('detalhes',$d,true);
		$this->jphp->replace('.modal-title',$d['retorno']['name']);
		$this->jphp->replace('.modal-body',$detalhes);
		$this->jphp->executa("$('#pokemon').modal('show')");		
		$this->jphp->send();
	}
}
