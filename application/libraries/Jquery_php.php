<?php
class Jquery_php{
	private $s = array();
	private $encode = 'utf8';
	private $XMLHttpRequest;
	private function array_utf8($arr){
		if(is_array($arr)){
			foreach($arr as $k => $v){
				$arr[$k] = $this->array_utf8($v);
			}
		}else{
			$arr = utf8_encode($arr);
		}
		return $arr;
	}
	function __construct($enc='utf8'){
	    $this->encode = $enc;
	    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'){
		    $this->XMLHttpRequest = true;
	    }else{
		    $this->XMLHttpRequest = false;
	    }
	}
	function set_iso(){
		$this->encode = 'iso';
	}
	function set_utf8(){
		$this->encode = 'utf8';
	}
	function replace($a,$c){
		$this->s['cmd'][] = array('type'=>'rep','target'=>$a,'content'=>$c);
	}
	/**
	 * 
	 * @param type $a ALVO
	 * @param type $c CONTEUDO
	 * @param type $parent (OBSOLETO, OU NÃO IMPLEMENTADO) NÃO LEMBRO A ORIGEM
	 */
	function append($a,$c,$parent=0){
		$this->s['cmd'][] = array('type'=>'app','target'=>$a,'content'=>$c,'parent'=>$parent);
	}
	function prepend($a,$c){
		$this->s['cmd'][] = array('type'=>'pre','target'=>$a,'content'=>$c);
	}
	function after($a, $c){
		$this->s['cmd'][] = array('type'=>'af','target'=>$a, 'content'=>$c);
	}
    /**
     * altera campo 'value' de campos INPUT (opera com .val() no Jquery)
     * @param string $alvo
     * @param string $conteudo
     * @param int $global '0' substitui apenas ocorrencia do mesmo formulário, '1' substitui de todo documento.
     */
	function val($alvo,$conteudo,$global=0){
		$this->s['cmd'][] = array('type'=>'val','target'=>$alvo,'content'=>$conteudo,'global'=>$global);
	}
	function removeClass($c,$a=''){
		$this->s['cmd'][] = array('type'=>'rCl','target'=>$a,'content'=>$c);
	}
	/**
	 * 
	 * @param type $a alvo seletor jquery
	 * @param type $c nome da classe
	 * @param type $scroll se 1 posiciona o scroll para tornar o alvo visivel na tela
	 * @param type $global 0 procura apenas dentro do form de origem / 1 procura em BODY
	 */
	function addClass($a,$c,$scroll='0',$global='1'){
		$this->s['cmd'][] = array('type'=>'aCl','target'=>$a,'content'=>$c,'scroll'=>$scroll,'global'=>$global);
	}
	function attr($a,$attr,$valor){
		$this->s['cmd'][] = array('type'=>'attr','target'=>$a,'attr'=>$attr,'value'=>$valor);
	}
	function show($c){
		$this->s['cmd'][] = array('type'=>'show','target'=>$c);
	}
	function hide($c){
		$this->s['cmd'][] = array('type'=>'hide','target'=>$c);
	}
	/**
	 * 
	 * Mensagem Alert Box
	 * @param string $c 
	 * @param string $t Tipo de alerta (alert, info, error, prompt, confirm)
	 * @param string $a Log enviado para Analytics
	 */
	function alert($c,$t='alert',$a=''){
		//alert, info, error, prompt, confirm
		$this->s['al'][$t][] = array('msg'=>$c,'An'=>$a);
	}
	/**
	 * Reenvia a ultima requisição incluindo uma variavel $_POST['confirm'] = 1;
	 * @param string $c Mensagem para confirmação
	 * @param array $bt (botão confirma, botão cancela)
	 */
	function confirm($c,$bt=array('OK','Cancela')){
		$this->s['cnf'] = array('msg'=>$c,'dados'=>$_REQUEST,'action'=>$_SERVER['REQUEST_URI'],'bt'=>$bt);
	}
	/**
	 * 
	 * @param type $c Mensagem
	 * @param type $inputs array(array('type'=>'','name'=>'','value'=>'',label=>''))
	 * @param type $bt array('bt salvar','bt cancelar')
	 * @param type $action
	 * @param type $class
	 * @param type $method
	 * @param type $target
	 */
	function form($c,$inputs,$bt=array('Salvar','Cancela'),$action='',$class='ajax',$method ='post',$target=''){
		//{type: "text",     name: "username", value: "", label: "Username:", required: true},
		/*buttons : [
      {type: "submit", name: "submit", value: "Sign In"},
      {type: "cancel", value: "Cancel"}
    ],*/
		$form = array();
		$buttons = array();
		if($action!='')$form['action'] = $action;
		if($class!='')$form['class'] = $class;
		if($method!='')$form['method'] = $method;
		if($target!='')$form['target'] = $target;
		if(isset($bt[0]))$buttons[] = array('type'=>'submit','value'=>$bt[0]);
		if(isset($bt[1]))$buttons[] = array('type'=>'cancel','value'=>$bt[1]);

		$options = array(
			'type'=>'prompt',
			'inputs'=>$inputs,
			'buttons'=>$buttons,
			'form'=>$form
		);
		$this->s['form'] = array('msg'=>$c,'opt'=>$options);
	}
	function sucesso($c,$a=''){
		$this->s['sus'][] = array('msg'=>$c,'An'=>$a);
	}
	function remove($c){
		$this->s['cmd'][] = array('type'=>'del','target'=>$c);
	}
	function resetform(){
		$this->s['rsform']=1;
	}
	function inputError($erro, $pre="", $pos="") {
		$this->removeClass("inputError");
		$this->remove(".errorMsg");
		foreach ($erro as $k => $v) {
			$k = str_replace(array('[',']'), array('\[','\]'), $k);
			$this->after("input[name=$k]:not(:radio),input[name=$k]:radio:first,select[name=$k],textarea[name=$k]", $pre.'<spam class="errorMsg">'.$v.'</span>'.$pos);
			$this->addClass("input[name=$k],select[name=$k],textarea[name=$k]", "inputError", 1, 0);
		}
	}
	function scrollTo($a){
		$this->s['cmd'][] = array('type'=>'scroll','target'=>$a);
	}
	function executa($c){
		$this->s['cmd'][] = array('type'=>'ex','content'=>$c);
	}
	function analytics($cat,$acao,$label,$value=-1){
		$this->s['cmd'][] = array('type'=>'an','p1'=>$cat,'p2'=>$acao,'p3'=>$label,'p4'=>$value);
	}
	/**
	 * 
	 * direciona para outra página
	 * @param $d string (use 'self' para recarregar a página) 
	 */
	function redirect($d='self',$time=500){
		$this->s['rel'] = array('link'=>$d,'time'=>$time);
	}
	/**
	 * 
	 * @param mixed $par parametro para função callback que gerou a requisiçao
	 */
	function callbackparameter($par){
		$this->s['call'] = $par;
	}
	/**
	 * 
	 * @param type $contentType json, text
	 */
	function send($contentType='json'){
		if($this->encode=='iso') $this->s = $this->array_utf8($this->s);
		//if($this->XMLHttpRequest){
			if($contentType=='json')
			    header('Content-Type: application/json');
			else
			    header('Content-Type: text/plain');
			echo json_encode($this->s);
		//}else{
			//echo 'reload';//$xml->output; 
		//}
	}
}

