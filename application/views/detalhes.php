<style>
	.titulo{

		top: 15px;
		left: 15px;
		font-size: 12px;
		font-weight: bold;
		color: #959595;
		text-transform: uppercase;
		letter-spacing: 1px;
	}

	.indice{
		font-weight: bold;
	}
</style>
<div class="row">
	<div class="col-sm-12 text-center">
		<img src="<?= $retorno['sprites']['front_default'] ?>">
		<img src="<?= $retorno['sprites']['back_default'] ?>">
	</div>
</div>
<div class="row">
	<div class="col-xs-6 col-sm-3 text-center">
		<p class="indice">Weight</p>
		<p class="cont"><?= $retorno['weight'] ?></p>
	</div>
	<div class="col-xs-6 col-sm-3 text-center">
		<p class="indice">Height</p>
		<p class="cont"><?= $retorno['height'] ?></p>
	</div>
	<div class="col-xs-6 col-sm-2 text-center">
		<p class="indice">Base Experience</p>
		<p class="cont"><?= $retorno['base_experience'] ?></p>
	</div>
	<div class="col-xs-6 col-sm-2 text-center">
		<p class="indice">species</p>
		<p class="cont"><?= $retorno['species']['name'] ?></p>
	</div>
	<div class="col-xs-6 col-sm-2 text-center">
		<p class="indice">order</p>
		<p class="cont"><?= $retorno['order'] ?></p>
	</div>
</div>
<div class="row">
	<div class="col-xs-12 col-sm-6">
		<div class="table-responsive" data-example-id="hoverable-table">
			<p class="titulo">abilities</p>
			<table class="table">
				<thead>
					<tr>						
						<th>ability</th>						
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($retorno['abilities'] as $r) {
						?>
						<tr>						
							<td><?= $r['ability']['name'] ?></td>						
						</tr>
						<?php
					}
					?>

				</tbody>
			</table>

		</div>
	</div>
	<div class="col-xs-12 col-sm-6">
		<div class="table-responsive" data-example-id="hoverable-table">
			<p class="titulo">types</p>
			<table class="table">
				<thead>
					<tr>						
						<th>type</th>						
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($retorno['types'] as $r) {
						?>
						<tr>						
							<td><?= $r['type']['name'] ?></td>						
						</tr>
						<?php
					}
					?>

				</tbody>
			</table>

		</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-12 col-sm-6">
		<div class="table-responsive" data-example-id="hoverable-table">
			<p class="titulo">forms</p>
			<table class="table">
				<thead>
					<tr>						
						<th>form</th>						
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($retorno['forms'] as $r) {
						?>
						<tr>						
							<td><?= $r['name'] ?></td>						
						</tr>
						<?php
					}
					?>

				</tbody>
			</table>

		</div>
	</div>

	<div class="col-xs-12 col-sm-6">
		<div class="table-responsive" data-example-id="hoverable-table">
			<p class="titulo">stats</p>
			<table class="table">
				<thead>
					<tr>						
						<th>stat</th>
						<th>Base Stat</th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($retorno['stats'] as $r) {
						?>
						<tr>						
							<td><?= $r['stat']['name'] ?></td>
							<td><?= $r['base_stat'] ?></td>
						</tr>
						<?php
					}
					?>

				</tbody>
			</table>

		</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-12 col-sm-6">
		<div class="table-responsive" data-example-id="hoverable-table">
			<p class="titulo">game indices</p>
			<table class="table">
				<thead>
					<tr>						
						<th>game index</th>
						<th>version</th>

					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($retorno['game_indices'] as $r) {
						?>
						<tr>						
							<td><?= $r['game_index']?></td>
							<td><?= $r['version']['name']?></td>

						</tr>
						<?php
					}
					?>

				</tbody>
			</table>

		</div>
	</div>
	<div class="col-xs-12 col-sm-6">
		<div class="table-responsive" data-example-id="hoverable-table">
			<p class="titulo">moves</p>
			<table class="table">
				<thead>
					<tr>						
						<th>move</th>
						<th>version group details</th>

					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($retorno['moves'] as $r) {
						?>
						<tr>						
							<td><?= $r['move']['name'] ?></td>
							<td>
								<?php
								foreach ($r['version_group_details'] as $v) {
									echo "Level: " . $v['level_learned_at'] . ' - ' . 'move learn method: ' . $v['move_learn_method']['name'] . ' - Version group: ' . $v['version_group']['name'] . '<br>';
								}
								?>
							</td>

						</tr>
						<?php
					}
					?>

				</tbody>
			</table>

		</div>
	</div>
</div>

</div>


