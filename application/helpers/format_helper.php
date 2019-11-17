<?php

defined('NUM_DEC') OR define('NUM_DEC', ','); // SEPARADOR NUMERICO DECIMAL
defined('NUM_SEP') OR define('NUM_SEP', '.'); // SEPARADOR NUMERICO DE MILHAR

function base_url($url = "") {
	//return 'http://vps1722.publiccloud.com.br/fazenda/'.$url;	
	return 'http://localhost/troc/' . $url;
}

function dataInt($data) {
	date_default_timezone_set('America/Sao_Paulo');
	$dataDivid = explode(" ", $data);
	$data_nova = explode("/", $dataDivid['0']);
	$hora = $dataDivid['1'];
	if ($hora == '')
		$hora = '00:00';
	return $timestamp = strtotime($data_nova[1] . '/' . $data_nova[0] . '/' . $data_nova[2] . ' ' . $hora);
	//echo date('d/m/Y h:i', strtotime('+1 hour',$timestamp)); // Resultado: 12/03/2009
}

function convertData($timestamp) {
	date_default_timezone_set('America/Sao_Paulo');
	return date('d/m/Y H:i', $timestamp); // Resultado: 12/03/2009
}

function convertDataN($timestamp) {
	date_default_timezone_set('America/Sao_Paulo');
	return date('d/m/Y', $timestamp); // Resultado: 12/03/2009
}

function convertDataAg($timestamp) {
	date_default_timezone_set('America/Sao_Paulo');
	return date('Y-m-d', $timestamp); // Resultado: 12/03/2009
}

function tempoMais($tempo, $timestamp) {
	date_default_timezone_set('America/Sao_Paulo');
	return strtotime('+' . $tempo . ' hour', $timestamp); // Resultado: 12/03/2009
}

function redirect($url) {
	echo "<script>window.open('" . $url . "','_self')</script>";
}

function replace($alvo, $conteudo) {
	echo '<script>$("' . $alvo . '").replaceWith("' . $conteudo . '");</script>';
}

function replace2($alvo, $conteudo) {
	echo '<script>$("' . $alvo . '").replaceWith("' . $conteudo . '");</script>';
}

function attr($alvo, $aalvo = '', $conteudo) {
	echo '<script>$("' . $alvo . '").attr("' . $aalvo . '","' . $conteudo . '");</script>';
}

function listaEquipamentosJogo($id_jogo, $id_operador) {
	$CI = &get_instance();

	$CI->db->select('*');
	$CI->db->from('equipamento_jogo');
	$CI->db->join('equipamento', 'equipamento_jogo.id_equipamento = equipamento.ns');
	$CI->db->where('equipamento_jogo.id_operador', $id_operador);
	$CI->db->where('equipamento_jogo.id_jogo', $id_jogo);
	$CI->db->where('equipamento_jogo.status', 'online');
	$query = $CI->db->get();
	$campo = $query->row_array();

	return $campo['nome'];
}

function remove($dados) {
	echo '("' . $dados . '").remove();';
}

function addClass($t, $classe) {
	echo '$("#' . $t . '").addClass("' . $classe . '");';
}

function removeClass($t) {
	echo '$(".' . $t . '").removeClass("' . $t . '");';
}

function iniAjax() {
	$CI = &get_instance();
	$CI->load->library('Jquery_php', NULL, 'jphp');
	$CI->lang->load('ajax');
	$CI->msgError = array(
		'required' => $CI->lang->line('o_campo_nao_em_branco'),
		'min_length' => $CI->lang->line('o_campo_no_minimo'),
		'max_length' => $CI->lang->line('o_campo_no_maximo'),
		'is_natural' => $CI->lang->line('valor_invalido'), //dados boleanos 1 ou 0
		'alpha_dash' => $CI->lang->line('apenas_alpha_num_dash_under'),
		'ilegaltag' => $CI->lang->line('conteudo_ilegal'),
		'valid_email' => $CI->lang->line('o_campo_email_e_invalido'),
		'is_unique' => $CI->lang->line('email_ja_esta_cadastrado'),
	);
}

function inputError($erro, $msg = '') {


	replace(".errorMsg", "");
	$classe = "'errorMsg'";


	echo "<script>";
	removeClass("inputError");
	foreach ($erro as $k => $v) {
		if ($msg == '') {
			$mensagem = 'O campo ' . $k . ' é obrigatório';
		} else {
			$mensagem = $msg;
		}
		addClass($k, 'inputError');
		echo '$("#' . $k . '").after("<p class=' . $classe . '>' . $mensagem . '</p>" );';
	}
	echo "</script>";
}

/**
 *
 * Number Format: transforma em nÃºmero no formato 1.000,00
 * @param float	$n	Numero float a ser formtatado
 * @param int	$precisao	PrecisÃ£o, se omitido utiliza 2
 * @return	string	numero formatado
 */
function nf($n, $precisao = 2) {
	return number_format($n, $precisao, NUM_DEC, NUM_SEP);
}

function multiplicaDecimal($un, $quantidade) {
	if (!strpos($un, ".") && (strpos($un, ",")))
		$un = substr_replace($un, '.', strpos($un, ","), 1);



	$valor_recontado = number_format($un, 2, '.', ',');

	$valor_multiplicado = $valor_recontado * $quantidade;
	return nf($valor_multiplicado);
}

function reload() {
	echo '<script>location.reload()</script>';
}

function alert($conteudo) {
	echo '<script>alert("' . $conteudo . '")</script>';
}

function montaUrl($tabela, $campo, $k) {

	if ($tabela == 'Perfil')
		$a = "<a href='" . base_url('Lancamentos/retornaDados/' . $campo['id_cf'] . '/perfil') . "' class='ajax listaBusca' data-id='" . $k . "' data-value='" . $campo['nome'] . "'>" . $campo['nome'] . "(" . $campo['cpf_cnpj'] . ")</a><br>";
	if ($tabela == 'Produtos')
		$a = "<a href='" . base_url('Lancamentos/retornaDados/' . $campo['id_produto'] . '/produtos') . "' class='ajax listaBusca' data-id='" . $k . "' data-value='" . $campo['nome'] . "'>" . $campo['nome'] . "</a><br>";
	if ($tabela == 'PlanoContas')
		$a = "<a href='" . base_url('Lancamentos/retornaDados/' . $campo['id_plano_contas'] . '/planoContas') . "' class='ajax listaBusca' data-id='" . $k . "' data-value='" . $campo['nome_conta'] . "(" . $campo['abreviatura'] . ")'>" . $campo['nome_conta'] . "(" . $campo['abreviatura'] . ")</a><br>";

	return $a;
}

function autoCompleat($nome, $tabela, $funcao, $k, $tipo = '', $url = '') {
	$CI = &get_instance();
	$CI->load->model($tabela . "_model", $tabela);

	if ($tabela == 'Perfil') {
		$dados = $CI->$tabela->$funcao($tipo, $nome);
	}
	if ($tabela == 'Produtos') {
		$dados = $CI->$tabela->$funcao($nome);
	}

	if ($tabela == 'PlanoContas') {
		$dados = $CI->$tabela->$funcao($nome);
	}

	$a = "";
	//$busca='"buscaApelido"';
	foreach ($dados as $campo) {
		$a .= montaUrl($tabela, $campo, $k);
	};

	$div = "<div class='busca'>" . $a . "</p>";
	echo '<script>';
	echo '$("#' . $k . '").after("' . $div . '");';

	echo '</script>';
	if ($a) {
		replace('.busca', $div);
	} else {
		replace('.busca', '');
	}
}

function geraBox($tipoBox, $tipo = '', $funcionario = '', $id = '') {
	$CI = &get_instance();
	$CI->load->helper('modulos');
	$return = $tipoBox('#', $tipo, $funcionario, $id);

	return replace(".modulo", "<div class='modulo'>" . $return . "</div>");
}

function urlImageGal($imagem, $size, $raiz = true) {
	if (isset($imagem)) {
		$url = "img/$size" . ($size != '0x0' && isset($imagem['crop']) && !empty($imagem['crop']) ? 'c' . str_replace('|', 'c', $imagem['crop']) : '') . '/' . $imagem['url'];
		if ($raiz)
			$url = base_url_estatico($url);
	}
	return $url;
}

function urlImage($url, $size, $crop = '', $raiz = true) {
	$url = "img/$size" . ($size != '0x0' && !empty($crop) ? 'c' . str_replace('|', 'c', $crop) : '') . '/' . $url;
	if ($raiz)
		$url = base_url($url);
	return $url;
}

function base_url_estatico($url) {
	$CI = &get_instance();
	return $CI->config->item('base_estatico') . ltrim($url, '/');
}

function enviaImg($foto, $caminho, $id, $dados) {
	$CI = &get_instance();
	if (!empty($foto["name"])) {

		// Largura mÃ¡xima em pixels
		$largura = 1000000;
		// Altura mÃ¡xima em pixels
		$altura = 1000000;
		// Tamanho mÃ¡ximo do arquivo em bytes
		$tamanho = 500000000;

		// cria array que irÃ¡ armazenar os erros, caso existam.
		$error = array();

		// Verifica se o arquivo Ã© uma imagem
		if (!preg_match("/(pjpeg|jpeg|png|gif|bmp)/i", $foto["type"])) {
			$error[0] = "Isso nÃ£o Ã© uma imagem.";
		}

		// Pega as dimensÃµes da imagem
		$dimensoes = getimagesize($foto["tmp_name"]);

		// Verifica se a largura da imagem Ã© maior que a largura permitida
		if ($dimensoes[0] > $largura) {
			$error[1] = "A largura da imagem nÃ£o deve ultrapassar " . $largura . " pixels";
		}

		// Verifica se a altura da imagem Ã© maior que a altura permitida
		if ($dimensoes[1] > $altura) {
			$error[2] = "Altura da imagem nÃ£o deve ultrapassar " . $altura . " pixels";
		}

		// Verifica se o tamanho da imagem Ã© maior que o tamanho permitido
		if ($foto["size"] > $tamanho) {
			$error[3] = "A imagem deve ter no mÃ¡ximo " . $tamanho . " bytes";
		}

		if (count($error) != 0) {
			//echo"<script>history.back(1),alert('Tamanho de Imagem nÃ£o permitido. Insira imagem com ".$largura."px(largura) x ".$altura."px(altura)')</script>";
		} else {
			// Se nÃ£o houver nenhum erro
			if (count($error) == 0) {

				// Pega extensÃ£o da imagem
				preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto["name"], $ext);

				// Gera um nome Ãºnico para a imagem
				$nome_imagem = md5(uniqid()) . "." . $ext[1];

				// Caminho de onde ficarÃ¡ a imagem
				$caminho_imagem = $caminho . '/' . $dados['slug'] . '/' . $nome_imagem;
				$caminho_thumb = $caminho . '/' . $dados['slug'] . '/thumb/' . $nome_imagem;

				// Faz o upload da imagem para seu respectivo caminho

				move_uploaded_file($foto["tmp_name"], $caminho_imagem);
				$dados = array(
					'img' => $caminho_imagem,
					'id_produto' => $id
				);
				$CI->db->insert('fotos', $dados);

				enquadraImg($caminho_imagem, $caminho_thumb);
			}
		}

		// Se houver mensagens de erro, exibe-as
		// return $error;
	}// fim if 1
}

function enviaBanner($foto, $caminho, $id) {
	$CI = &get_instance();
	if (!empty($foto["name"])) {

		// Largura mÃ¡xima em pixels
		$largura = 1000000;
		// Altura mÃ¡xima em pixels
		$altura = 1000000;
		// Tamanho mÃ¡ximo do arquivo em bytes
		$tamanho = 500000000;

		// cria array que irÃ¡ armazenar os erros, caso existam.
		$error = array();

		// Verifica se o arquivo Ã© uma imagem
		if (!preg_match("/(pjpeg|jpeg|png|gif|bmp)/i", $foto["type"])) {
			$error[0] = "Isso nÃ£o Ã© uma imagem.";
		}

		// Pega as dimensÃµes da imagem
		$dimensoes = getimagesize($foto["tmp_name"]);

		// Verifica se a largura da imagem Ã© maior que a largura permitida
		if ($dimensoes[0] > $largura) {
			$error[1] = "A largura da imagem nÃ£o deve ultrapassar " . $largura . " pixels";
		}

		// Verifica se a altura da imagem Ã© maior que a altura permitida
		if ($dimensoes[1] > $altura) {
			$error[2] = "Altura da imagem nÃ£o deve ultrapassar " . $altura . " pixels";
		}

		// Verifica se o tamanho da imagem Ã© maior que o tamanho permitido
		if ($foto["size"] > $tamanho) {
			$error[3] = "A imagem deve ter no mÃ¡ximo " . $tamanho . " bytes";
		}

		if (count($error) != 0) {
			//echo"<script>history.back(1),alert('Tamanho de Imagem nÃ£o permitido. Insira imagem com ".$largura."px(largura) x ".$altura."px(altura)')</script>";
		} else {
			// Se nÃ£o houver nenhum erro
			if (count($error) == 0) {

				// Pega extensÃ£o da imagem
				preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $foto["name"], $ext);

				// Gera um nome Ãºnico para a imagem
				$nome_imagem = md5(uniqid()) . "." . $ext[1];

				// Caminho de onde ficarÃ¡ a imagem
				$caminho_imagem = $caminho . '/' . $nome_imagem;


				// Faz o upload da imagem para seu respectivo caminho

				move_uploaded_file($foto["tmp_name"], $caminho_imagem);
				$dados = array(
					'imagem' => $caminho_imagem,
				);
				foreach ($dados as $i => $c) {
					$CI->db->set("$i", "$c");
				}
				$CI->db->where('id_banner', $id);
				$CI->db->update('banners');
			}
		}

		// Se houver mensagens de erro, exibe-as
		// return $error;
	}// fim if 1
}

function enviaPdf($pdf, $caminho, $id_orcamento) {
	$CI = &get_instance();
	// preg_match("/\.(pdf){1}$/i", $pdf["name"], $ext);

	$nome_imagem = md5(uniqid()) . '-' . $id_orcamento . ".pdf";
	$caminho_final = $caminho . '/' . $nome_imagem;
	move_uploaded_file($pdf["tmp_name"], $caminho_final);

	$dados = array(
		'pdf' => $caminho_final,
	);
	foreach ($dados as $i => $c) {
		$CI->db->set("$i", "$c");
	}
	$CI->db->where('id_orcamento', $id_orcamento);
	$CI->db->update('orcamentos');
}

function enquadraImg($url, $caminho_thumb) {
	$nome = 'teste.jpg';
	if (!class_exists('WideImage')) {
		require( "wideimage/lib/WideImage.php");
	}

	$image = WideImage::load($url);
	$image = $image->resize(450, 253, 'outside')->crop('100% - 850', '100% - 453', 850, 453);
	$image->saveToFile($caminho_thumb);
	return "";
}

function tiraAcento($aaa) {// e também &
	$aaa = str_replace(array(
		"Ç", "Ý", "Ñ",
		"Á", "Â", "À", "Ä", "Ã",
		"É", "Ê", "È", "Ë",
		"Í", "Î", "Ì", "Ï",
		"Ó", "Ô", "Ò", "Ö", "Õ",
		"Ú", "Û", "Ù", "Ü",
		"ç", "ý", "ñ", "ÿ",
		"á", "â", "à", "ä", "ã",
		"é", "ê", "è", "ë",
		"í", "î", "ì", "ï",
		"ó", "ô", "ò", "ö", "õ",
		"ú", "û", "ù", "ü",
		"&")
			, array(
		"C", "Y", "N",
		"A", "A", "A", "A", "A",
		"E", "E", "E", "E",
		"I", "I", "I", "I",
		"O", "O", "O", "O", "O",
		"U", "U", "U", "U",
		"c", "y", "n", "y",
		"a", "a", "a", "a", "a",
		"e", "e", "e", "e",
		"i", "i", "i", "i",
		"o", "o", "o", "o", "o",
		"u", "u", "u", "u",
		"e")
			, $aaa);
	return $aaa;
}

function codifica($texto) {
	$Enc = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, CHAVE_ENCRIPT, $texto, MCRYPT_MODE_CBC, "\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0");
	$Enc = rtrim(base64_encode($Enc), '=');
	return str_replace(array('+', '/'), array('-', '_'), $Enc);
}

function decodifica($textoEnc) {
	$textoEnc = str_replace(array('-', '_'), array('+', '/'), $textoEnc);
	$textoEnc = base64_decode($textoEnc);
	return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, CHAVE_ENCRIPT, $textoEnc, MCRYPT_MODE_CBC, "\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0"), "\0");
}

function validaCPF($cpf = null) {

	// Verifica se um número foi informado
	if (empty($cpf)) {
		return false;
	}

	// Elimina possivel mascara
	$cpf = str_replace('-', '', $cpf);
	$cpf = str_replace('.', '', $cpf);
	$cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

	// Verifica se o numero de digitos informados é igual a 11 
	if (strlen($cpf) != 11) {
		return false;
	}
	// Verifica se nenhuma das sequências invalidas abaixo 
	// foi digitada. Caso afirmativo, retorna falso
	else if ($cpf == '00000000000' ||
			$cpf == '11111111111' ||
			$cpf == '22222222222' ||
			$cpf == '33333333333' ||
			$cpf == '44444444444' ||
			$cpf == '55555555555' ||
			$cpf == '66666666666' ||
			$cpf == '77777777777' ||
			$cpf == '88888888888' ||
			$cpf == '99999999999') {
		return false;
		// Calcula os digitos verificadores para verificar se o
		// CPF é válido
	} else {

		for ($t = 9; $t < 11; $t++) {

			for ($d = 0, $c = 0; $c < $t; $c++) {
				$d += $cpf{$c} * (($t + 1) - $c);
			}
			$d = ((10 * $d) % 11) % 10;
			if ($cpf{$c} != $d) {
				return false;
			}
		}

		return true;
	}
}

function carregar($url) {

	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$data = curl_exec($ch);


	curl_close($ch);
	$data = json_decode($data, true);
	return $data;
}

function paginar($prefixo, $pg, $Itens, $itensPorPagina){
	//$pg = $pg+1;
	//$limite = $limite+1;
	$limite = floor(($Itens - 1) / $itensPorPagina);
	$s = '';
	if($limite > 0){
		$pini = max($pg - 5, 0);
		$pfim = min($pini + 10, $limite);

		$s .= '<div class="numPg">';
		if($pg > 0)
			$s .= "<a href='$prefixo".($pg - 1)."' title='Anterior'>&laquo;</a>";
		for($i = $pini; $i <= $pfim; $i++){
			$s .= "<a href='$prefixo$i' ".($i == $pg?" class='atual'":'').">".($i + 1)."</a>";
		}
		$i--;
		if($pg < $i)
			$s .= "<a href='$prefixo".($pg + 1)."' title='Próximo'>&raquo;</a>";
		$s .= '</div>';
	}
	return $s;
}

function getget($tira){
	$str = "";
	if(is_array($tira)){ //$tira é uma array com varios elementos
		foreach($_GET as $k=> $v){
			if(!in_array($k, $tira)){
				if(is_array($v)){
					foreach($v as $k2=> $v2){
						$str .= $k.'['.$k2."]=".urlencode($v2)."&";
					}
				}elseif($v != '')
					$str .= "$k=".urlencode($v)."&";
			}
		}
	}else{//$tira é uma string de um elemento unico
		foreach($_GET as $k=> $v){
			if($k != $tira){
				if(is_array($v)){
					foreach($v as $k2=> $v2){
						$str .= $k.'['.$k2."]=".urlencode($v2)."&";
					}
				}elseif($v != '')
					$str .= "$k=".urlencode($v)."&";
			}
		}
	}
	$str = rtrim($str, '&');
	return $str;
}

?>