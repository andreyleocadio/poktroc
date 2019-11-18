<!DOCTYPE html>
<?php
$dadosHead = array('titulo' => $titulo, 'pagina' => $pagina);
$itensPP = array(20, 40, 80, 100);
?>
<html>
    <head>
		<?php $this->load->view('head', $dadosHead) ?>
		<style>
			.numPg a {
				width: 35px;				
				height: 35px;
				display: inline-block;
				text-align: center;
				padding-top: 6px;
			}
			.numPg {
				border: 1px solid #eceeef;
				display: inline-block;
				border-radius: 6px;

			}

			.numPg a.atual,.numPg a:hover {
				background: #337ab7;
				color: #ffffff;
				text-decoration: none;

			}

			.lds-dual-ring {
				display: inline-block;
				width: 32px;
				height: 32px;
				display: none;
			}
			.lds-dual-ring:after {
				content: " ";
				display: block;
				width: 32px;
				height: 32px;
				margin: 8px;
				border-radius: 50%;
				border: 6px solid #000;
				border-color: #000 transparent #000 transparent;
				animation: lds-dual-ring 1.2s linear infinite;
			}
			@keyframes lds-dual-ring {
				0% {
					transform: rotate(0deg);
				}
				100% {
					transform: rotate(360deg);
				}
			}
		</style>
    </head>
    <body>
		<br>

		<br>
		<div class="row">
			<div class="col-sm-6">
				<div class="input-group">
					<span class="input-group-addon" id="basic-addon1">Pokemon's por página</span>
					<form class="itens">
						<input type="hidden" name="pga" value="<?= $_GET['pga'] ?>">
						<select name="itensPorPagina" onChange="$('.itens').submit();" class="form-control">
							<?php
							foreach ($itensPP as $i) {
								echo "<option value='$i' " . ($i == $_GET['itensPorPagina'] ? 'selected' : '') . ">$i</option>";
							}
							?>
						</select>
					</form>
				</div>
			</div>
			<div class="col-sm-6 text-center">
				<?= paginar('?' . getget('pga') . '&pga=', $pga, $pokemons['count'], $itensPorPagina) ?>
			</div>
		</div>
		<br>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>#</th>
					<th>Pokemon</th>
					<th>Ver Detalhes</th>					
				</tr>
			</thead>
			<tbody>
				<?php
				$cont = 1;
				foreach ($pokemons['results'] as $p) {
					?>
					<tr>
						<th scope="row"><?= $cont++ ?></th>
						<td><?= $p['name'] ?></td>
						<td><a href="<?= base_url('Pokemon/getPok/'.$cont.'?url=' . $p['url']) ?>" class="ajax iniDetalhes detalhe<?=$cont?>" data-id="<?=$cont?>">Detalhes</a><div class="lds-dual-ring load<?=$cont?>"></div></td>					
					</tr>				
					<?php
				}
				?>
			</tbody>
		</table>
		<div class="row">
			<div class="col-sm-12 text-center">
				<?= paginar('?' . getget('pga') . '&pga=', $pga, $pokemons['count'], $itensPorPagina) ?>
			</div>
		</div>
		<div class="modal fade bs-example-modal-lg" id="pokemon" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content" style="width: 100%">

					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
						<h4 class="modal-title" id="myLargeModalLabel"></h4>
					</div>
					<div class="modal-body">

					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div>
    </body>
</html>

<script>
	$(document).ready(function(){
		$('.iniDetalhes').on('click',function(){
			var id = $(this).data('id');
			$('.load'+id).fadeIn(0.1);
			$('.detalhe'+id).fadeOut(0.1);
		})
	});
</script>
























