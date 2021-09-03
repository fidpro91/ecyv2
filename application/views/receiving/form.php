    <div class="col-md-12">
      	<?=form_open("receiving/save",["method"=>"post","id"=>"fm_receiving"],$model)?>
		<?=form_hidden("rec_id")?>
		<div class="row">
			<div class="col-md-6">
				<?=create_input("rec_num")?>
				<?=create_inputDate("rec_date",[
					"format"=>"yyyy-mm-dd",
					"autoclose"=>"true"
					])?>
				<?=create_select([
							"attr"=>["name"=>"rec_type","id"=>"rec_type","class"=>"form-control"],
							"option"=>[
								["id"=>"1","text"=>"Pembelian PBF"],["id"=>"2","text"=>"Hibah"]
									]
						])?>
				<?=create_select([
							"attr"=>["name"=>"pay_type","id"=>"pay_type","class"=>"form-control"],
							"option"=>['Tunai','Kredit']
						])?>
				<?=create_select([
							"attr" =>["name"=>"supplier_id=department","id"=>"supplier_id","class"=>"form-control"],
							"model"=>["m_ms_supplier" => ["get_ms_supplier",["supplier_active"=>'t']],
											"column"  => ["supplier_id","supplier_name"]
										],
						])?>
			</div>
			<div class="col-md-6">
				<?=create_select([
							"attr"=>["name"=>"ppn","id"=>"ppn","class"=>"form-control"],
							"option"=>[0,10]
						])?>
				<?=create_input("discount_total",["readonly"=>true])?>
				<?=create_input("rec_taxes",["readonly"=>true])?>
				<?=create_input("total_receiving",["readonly"=>true])?>
			</div>
		</div>
		<div class="row">
			<div class="table-scrollable" style="overflow:auto;">
				<div class="div_detail" style="width: 2000px; padding: 0; ">
				</div>
			</div>
		</div>
		<?=form_close()?>
      <div class="box-footer">
      		<button class="btn btn-primary" type="button" onclick="$('#fm_receiving').submit()">Save</button>
      		<button class="btn btn-warning" type="button" id="btn-cancel">Cancel</button>
      </div>
    </div>

<script type="text/javascript">
	$(document).ready(()=>{
	    $(".div_detail").inputMultiRow({
	            column: ()=>{
					var dataku;
					$.ajax({
						'async': false,
						'type': "GET",
						'dataType': 'json',
						'url': "receiving/show_multiRows",
						'success': function (data) {
							dataku = data;
						}
					});
					return dataku;
	                }
	    });
	});

	$("#ppn").change(()=>{
		let ppn = parseInt($("#ppn").val())*$("#total_receiving").val()/100;
		$("#rec_taxes").val(ppn);
	});

	$("body").on("focus", ".expired_date", function() {
		$(this).inputmask("99-99-9999",{ "placeholder": "dd-mm-yyyy" });
	});

	$("body").on("keyup", ".qty_pack, .price_pack", function() {
		hitungTotal($(this));
	});

	$("body").on("keyup", ".disc_percent", function() {
		hitungDiskon($(this),'persen');
	});
	$("body").on("keyup", ".disc_value", function() {
		hitungDiskon($(this),'value');
	});

	$("body").on("focus", ".autocom_item_id", function() {
	    $(this).autocomplete({
            source: "<?php echo site_url('receiving/get_item');?>",
            select: function (event, ui) {
                $(this).closest('tr').find('.item_id').val(ui.item.item_id);
                $(this).closest('tr').find('.item_pack').val(ui.item.item_package);
                $(this).closest('tr').find('.item_unit').val(ui.item.item_unitofitem);
            }
        });
	});
	$("#btn-cancel").click( () => {
		$("#form_receiving").hide();
		$("#form_receiving").html('');
	});

	$("body").on("change", ".price_pack, .qty_pack, .disc_percent, .disc_value", function() {
		grandTotal();
	});

	$(".removeItem").bind("click", function() {
		grandTotal();
	});

	function grandTotal(){
		let grandtotal=0;
		let totalDiskon=0;
		$(".price_total").each(function(){
			let total = parseFloat(isNaN($(this).val())?0:$(this).val()) - parseFloat(isNaN($(this).closest('tr').find('.disc_value').val())?0:$(this).closest('tr').find('.disc_value').val());
			totalDiskon += parseFloat(isNaN($(this).closest('tr').find('.disc_value').val())?0:$(this).closest('tr').find('.disc_value').val());
			grandtotal += total;
		});
		// alert(grandtotal);
		$('#total_receiving').val(grandtotal);
		$('#discount_total').val(totalDiskon);
		$("#ppn").trigger("change");
	}

	function hitungTotal(row) {
		let qty = parseFloat(isNaN(row.closest('tr').find('.qty_pack').val())?0:row.closest('tr').find('.qty_pack').val());
		let jml = parseFloat(isNaN(row.closest('tr').find('.price_pack').val())?0:row.closest('tr').find('.price_pack').val());
		let total = qty*jml;
		row.closest('tr').find('.price_total').val(total);
		hitungDiskon(row,'persen');
	}

	function hitungDiskon(row,type) {
		if(type == 'persen'){
			let diskon = parseFloat(isNaN(row.closest('tr').find('.disc_percent').val())?0:row.closest('tr').find('.disc_percent').val());
			let hargaTotal = parseFloat(isNaN(row.closest('tr').find('.price_total').val())?0:row.closest('tr').find('.price_total').val());
			let total = diskon/100*hargaTotal;
			row.closest('tr').find('.disc_value').val(total);	
		}else{
			let diskon = parseFloat(isNaN(row.closest('tr').find('.disc_value').val())?0:row.closest('tr').find('.disc_value').val());
			let hargaTotal = parseFloat(isNaN(row.closest('tr').find('.price_total').val())?0:row.closest('tr').find('.price_total').val());
			let total = diskon/hargaTotal*100;
			row.closest('tr').find('.disc_percent').val(total);
		}
	}
  <?=$this->config->item('footerJS')?>
</script>