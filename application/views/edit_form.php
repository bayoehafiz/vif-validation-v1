<div class="main-content">
	<div class="main-content-inner">
		<div class="page-content">
			<?php $form = $form[0];?>
			<div class="row">
				<div class="col-xs-12">
					<h2>View <?php echo $form['subject']; ?></h2>
					<hr>					
				</div>
				<div class="col-xs-12">
					<h4>Details:</h4>
					<?php echo form_open_multipart(''); ?>
					<div class="form-group row ">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Branch </label>
						<div class="col-sm-9">
							<input type="text" id="form-field-1-1" placeholder="Branch" class="form-control" value="<?php echo $form['branch_name'];?>" disabled/>
						</div>
					</div>
					<div class="form-group row ">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Subject </label>
						<div class="col-sm-9">
							<input name="subject" type="text" id="form-field-1-1" maxlength="50" placeholder="Your Subject Form" class="form-control" value="<?php echo $form['subject'];?>" />
						</div>
					</div>
					<div class="form-group row ">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Description </label>
						<div class="col-sm-9">
							<textarea  style="width: 100%; min-height: 100px" name="description"><?php echo $form['description'];?></textarea>
						</div>
					</div>
					<div class="form-group row ">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Amount In Word</label>
						<div class="col-sm-9">
							<strong>IDR</strong>
							<input type="text" class="form-control" name="amountinword" value="<?php echo $form['amountinword'];?>" />
						</div>
					</div>
					<div class="form-group row ">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Bank </label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="bank" value="<?php echo $form['bank'];?>" />
						</div>
					</div>
					<div class="form-group row ">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Account Number </label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="accountnumber" onKeyPress="return numbersonly(event)" value="<?php echo $form['accountnumber'];?>" />
						</div>
					</div>
					<div class="form-group row ">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Account Name</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="accountname" value="<?php echo $form['accountname'];?>" />
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<h5>AMOUNT DETAIL :</h5>
							<hr>
							<table class="table table-bordered" id="dynamic-amount">
								<thead>
									<tr>
										<th width="6%" class="text-center">No</th>
										<th>Name</th>
										<th width="30%">Description</th>
										<th width="20%">Use Date</th>
										<th width="30%">Amount</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$no = 1;
										$totalAmount = 0;
										$hiddenIdAmounts = [];
										foreach ($amount_detail as $val) {
											$val['amounts'] = explode('.', $val['amount'])[0];
											$val['amountDesc'] = explode('.', $val['amount'])[1];

											$que = "select C.* FROM code C WHERE C.id = '".$val['code']."'";
											$code = $this->Crud->specialQuery($que);
											$totalAmount += $val['amount'];
									?>
										<tr id="row1">
											<td class="text-center"><?= $no;?></td>
											<td>
												<select name="name_amount[]">
													<?php
														foreach ($datacode as $value) {
															if($code[0]['id'] == $value['id']){$selected='selected';}else{$selected='';};
															echo "<option value=".$value['id']." ".$selected.">".$value['name']." -- ".$value['description']."</option>";
														}
													?>
												</select>
											</td>
											<td>
												<input type="text" name="desc_amount[]" value="<?= $val['description'];?>" placeholder="Description" class="form-control" style="min-height: 60px;" required>
												<input type="hidden" name="id_detail[]" value="<?= $val['id'];?>">
											</td>
											<td>
												<div class="input-group">
													<span class="input-group-addon">
														<i class="fa fa-calendar bigger-110"></i>
													</span>
													<?php
														$date = explode('-',$val['use_date']);

														$shortMonth = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
														
														$day = $date[2];
														$month = '';
														$year = $date[0];

														for ($i=0; $i < sizeof($shortMonth) ; $i++) { 
															if ($date[1] == $i) {
																$month = $shortMonth[$i-1];
															}
														}

													?>
													<input name="user_date_amount[]" class="form-control date-picker" placeholder="Due Date" id="id-date-picker-1" type="text" data-date-format="yyyy-mm-dd" value="<?= $day.' '.$month.' '.$year;?>" required/>
												</div>
											</td>
											<td>
												<div class="input-group">
	                                                <span class="input-group-addon">
	                                                	<strong><span class="currency-symbol"><?php if($form['currency']==1){echo 'Rp';}else{echo '$';}?></span></strong>
	                                                </span>
	                                                <input type="text" name="amounts[]" id="amount1" class="form-control amount sum-amount" value="<?= $val['amounts'];?>" placeholder="0" required/>
	                                                <span class="input-group-addon">.</span>
	                                                <input type="text" name="amountsDec[]" class="form-control amountsDec" value="<?= $val['amountDesc'];?>" placeholder="00" maxlength="2" style="width: 42px;"/>
	                                            </div>
											</td>
											
												<?php
													if ($no > 1) {
												?>	
												<td class="text-center">
													<a href="#" class="remove-amount">
														<i class="fa fa-trash text-danger"></i>
													</a>
												</td>
												<?php
													}
												?>
											
										</tr>
									<?php
										$no++;
										}
									?>
								</tbody>
								<tfoot>
                                    <tr id="hover-row" style="cursor: pointer;">
                                        <td colspan="5" class="text-center" style="padding: 14px;">
                                            <div id="add-amount" style="height: 18px; overflow:auto;">
                                                <span><i class="fa fa-plus text-success"></i></span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="">
                                        <td colspan="4" class="text-right">
                                            <h6 class="control-label"><b>TOTAL AMOUNT </b></h6>
                                        </td>
                                        <td class="text-muted" style="font-size: 1.8em; font-weight: 300">
                                        	<input type="hidden" name="amount" class="total-amount">
                                            <div class=""><span id="currency-symbol-total">Rp</span>&nbsp;<span id="currency-value" class="amount">0.00</span></div>
                                        </td>
                                    </tr>
                                </tfoot>

								<!-- <tfoot>
								    <tr>
								        <td colspan="4" class="text-right">
								            <h6 class="control-label"><b>TOTAL AMOUNT <font color="red">*</font> : </b></h6>
								        </td>
								        <td>
								        	<input type="hidden" name="hiddenIdAmounts" value="">
								            <input name="amount" type="text" id="currency-value" placeholder="0" class="form-control amount" readonly value="<?= $totalAmount;?>"" required/>
								        </td>
								        <td class="text-center">
								            <a href="#" id="add-amount"><h6><i class="fa fa-plus text-success"></i></h6></a>
								        </td>
								    </tr>
								</tfoot> -->
							</table>
						</div>

						<div class="col-sm-12">
							<h3><span class="fa fa-paperclip"> Attach Files</span></h3>
							<hr>
							<div id="lightgallery">
								<?php
									if(count($path) > 0) {
										foreach($path as $file) {
								?>		

									<a href="<?php echo base_url($file['url']); ?>" style="position:relative;width: 20%; float: left; padding: 15px; margin:15px; width: 200px; border: 1px solid;">
									    <img src="<?php echo base_url($file['url']); ?>" style="width: 100%">
									    <input type="hidden" name="attachFilesId[]" value="<?= $file['id'];?>">
									    <input type="hidden" name="attachFiles[]" value="<?= $file['url'];?>">
									    <div style="position: absolute;top: 6px;right: 13px;color:red;font-size: 15px;font-weight: bold;" class="remove-attach">
											<i class="fa fa-times"></i>
										</div>
									</a>
								<?php
										}
									} else {
										echo "No Files uploaded";
									}
								?>
							</div>
							<div class="form-group">
									<input type="file" name="files">
								</div>
							<hr>
						</div>

						<div class="form-group">
							<div class="col-sm-12 text-center">
								<input type="hidden" name="id_user" value="<?php echo $_SESSION['uuid'];?>">
								<input type="hidden" name="id_form" value="<?php echo $form['id'];?>">
								<input type="hidden" name="stage" value="<?php echo $form['stage'];?>">
								<input type="hidden" name="branch" value="<?php echo $form['branch'];?>">
								<input type="hidden" name="position" value="<?php echo $position;?>">
								<button type="submit" name="save" value="save" class="btn btn-white btn-lg btn-round btn-success">
									<i class="ace-icon fa fa-save"></i> SAVE 
								</button>
							</div>
						</div>
					</div>
				</div>
				<hr>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>

<script type="text/javascript">
	function sumAmount() {
        var sumAmount = 0;

        $('#dynamic-amount input.sum-amount').each(function() {
            var thisVal = $(this).val();
            var amountDesc = $(this).parent().children('.amountsDec').val();
            var thisValue = parseFloat(thisVal.replace(/,/g, '')+'.'+amountDesc);
            
            if (thisVal != '') {
                sumAmount += thisValue;
            }
        });

        // $('input#amount').val(parseFloat(sumAmount.toFixed(2)));

        $('#currency-value').text(sumAmount.toFixed(2));
        $('.total-amount').val(sumAmount.toFixed(2));

        $('#currency-value').priceFormat({
            prefix: '',
            centsLimit: 2,
            thousandsSeparator: ','
        });
    }

	$('.remove-amount').on('click', function(e) {
	    e.preventDefault();
	    e.stopPropagation();
	    var elemRemove = $(this).parent().parent('tr').remove();

	    sumAmount();
	});

	// ADDING more row
    var next = 1;
    $('#add-amount').on('click', function(e) {
        e.preventDefault();
        var id = '#row' + next;
        var elem = $('#dynamic-amount tbody tr:last-child');
        next = next + 1;

        $.get('../../get-code', function(data) {
            var data = JSON.parse(data);

            var html = '<select name="name_amount[]">';
            data.datacode.forEach(function(val) {
                html += '<option value=' + val.id + '>' + val.name + ' -- ' + val.description + '</option>';
            })
            html += '</select>';

            var addElem = '<tr id="row' + next + '">' +
                '<td class="text-center">#</td>' +
                '<td>' + html + '</td>' +
                '<td><input type="text" name="desc_amount[]" placeholder="Description" class="form-control" style="min-height: 60px;" required></td>' +
                '<td><div class="input-group"><span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span><input name="user_date_amount[]" class="form-control date-picker" placeholder="Due Date" id="id-date-picker-1" type="text" data-date-format="yyyy-mm-dd" required/></div></td>' +
                '<td><div class="input-group"><span class="input-group-addon"><strong><span class="currency-symbol"></span></strong></span><input type="text" name="amounts[]" id="amount' + next + '" class="form-control amount sum-amount" placeholder="0" required/><span class="input-group-addon">.</span><input type="text" name="amountsDec[]" class="form-control amountsDec" placeholder="00" maxlength="2" style="width: 48px;"/></div></td>' +
                '<td class="text-center remove-amount" style="cursor:pointer;"><a href="#" class="remove-amount"><i id="trash-sign" class="fa fa-trash text-danger"></i></a></td>' +
                '</tr>';

            elem.after(addElem);

            // reload priceFormat
            $('.amount, #amount').priceFormat({
                prefix: '',
                limit: 8,
                centsLimit: 0,
                thousandsSeparator: ','
            });

            // reload currency and money format
            $(document).find('#currency-selector').trigger('change');

            // reload datepicker
            $('.date-picker').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: 'dd M yyyy'
            }).next().on(ace.click_event, function() {
                    $(this).prev().focus();
            });

            $(".amount,.amountsDec").on("keyup", function() {
                sumAmount();
            });

            // DELETING row
            $('.remove-amount').on('click', function(e) {
			    e.preventDefault();
			    e.stopPropagation();
			    var elemRemove = $(this).parent().parent('tr').remove();

			    sumAmount();
			});

            sumAmount();

            $('.amountsDec').on('keydown', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
        })
    })

            $('.date-picker').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: 'dd M yyyy'
            }).next().on(ace.click_event, function() {
                    $(this).prev().focus();
            });

    $(".amount, .amountsDec").on("keyup", function() {
        sumAmount();
    });

    $('.amount, #amount').priceFormat({
        prefix: '',
        limit: 8,
        centsLimit: 0,
        thousandsSeparator: ','
    });

    sumAmount();

    $('.amountsDec').on('keydown', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
</script>
