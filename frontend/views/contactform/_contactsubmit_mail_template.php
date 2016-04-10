<table cellpadding="10" style="width:100%;background-color: #fff;">

	<tr style="font-size: 15px;width: 100%;">
		<td style="border-bottom:1px solid rgba(200,200,200,.5);">
			<div style="float:left;margin-right:20px;">Name:</div>
			<div style="float:left;">		
			<?= $model->name; ?>
			</div>
		</td>
	</tr>
	<tr style="font-size: 15px;width: 100%;">
		<td style="border-bottom:1px solid rgba(200,200,200,.5);">
			<div style="float:left;margin-right:20px;">Email:</div>
			<div style="float:left;">	
				<?= $model->email; ?>
			</div>
		</td>
	</tr>
	<tr style="font-size: 15px;width: 100%;">
		<td style="border-bottom:1px solid rgba(200,200,200,.5);">
			<div style="float:left;margin-right:20px;">Mobile:</div>
			<div style="float:left;">	
				<?= $model->mobile; ?>
			</div>
		</td>
	</tr>
	<tr style="font-size: 15px;width: 100%;">
		<td style="border-bottom:1px solid rgba(200,200,200,.5);">
			<div style="float:left;margin-right:20px;">Subject:</div>
			<div style="float:left;">	
				<?= $model->subject; ?>
			</div>
		</td>
	</tr>
	<tr style="font-size: 15px;width: 100%;">
		<td style="border-bottom:1px solid rgba(200,200,200,.5);">
			<div style="float:left;margin-right:20px;margin-bottom:10px;">Message:</div>
			<div style="float:left;">	
				<?= $model->message; ?>
			</div>
		</td>
	</tr>
	
</table>