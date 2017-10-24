<?php
    $idbranch = $user['branch'];
    $branch = $user['branch_name'];
    // $code = $user['code'];
?>
    <div class="main-content">
        <div class="main-content-inner">
            <div class="breadcrumbs ace-save-state breadcrumbs-fixed" id="breadcrumbs">
                <ul class="breadcrumb">
                    <li>
                        <i class="ace-icon fa fa-home home-icon"></i>
                        <a href="#">
                            <?= $title;?>
                        </a>
                    </li>
                </ul>
                <!-- /.breadcrumb -->
            </div>
            <div class="page-content">
                <div class="page-header">
                    <?php $messages = $this->session->flashdata('success_msg'); 
                                if($messages){ ?>
                    <div class="alert alert-success text-center">
                        <?php echo $messages; ?>
                    </div>
                    <?php } ?>
                    <h1><?= $title;?>: <span id="form-title" class="text-muted"></span></h1>
                </div>
                <!-- /.page-header -->
                <!-- PAGE CONTENT BEGINS -->
                <br>
                <?php echo form_open_multipart('new-form'); ?>

                <?php 
                // For BH only! forbid submiting form when she/he already had BA
                $has_ba = false;
                if ($_SESSION['position'] == '3') {
                    $cloud_users = $_SESSION['cloud_users'];

                    foreach ($cloud_users as $cuser) {
                        if ($cuser['branch'] == $_SESSION['branch']) {
                            if ($cuser['position'] == '2') {
                                $has_ba = true;
                            }
                        }
                    }
                }

                if ($_SESSION['position'] == '3' && $has_ba) { // if already had BA
                ?>
                                <div class="row">
                                    <div class="col-sm-12 text-center">
                                        You don't have access to this page. Please ask your Admin to create a new submission for you.
                                    </div>
                                </div>
                <?php
                } else { // if didn't have BA
                ?>
                <div class="row">
                    <div class="col-sm-6">
                        <?php $error = form_error('branch', '<p class="text-danger">', '</p>');?>
                        <div class="form-group row  <?php echo $error ? 'has-error' : '' ?>">
                            <label class="col-sm-3 col-xs-11 control-label no-padding-right" for="form-field-1"> Branch </label>
                            <div class="col-sm-8">
                                <span class="label label-info label-lg"><?php echo $branch;?></span>
                                <input type="hidden" name="branch" value="<?php echo $idbranch;?>">
                                <?php echo $error;?>
                            </div>
                        </div>
                        <?php $error = form_error('subject', '<p class="text-danger">', '</p>');?>
                        <div class="form-group row  <?php echo $error ? 'has-error' : '' ?>">
                            <label class="col-sm-3 col-xs-11 control-label no-padding-right" for="form-field-1-1"> Subject
                                <font color="red">*</font>
                            </label>
                            <div class="col-sm-8">
                                <input name="subject" type="text" id="form-field-1-1" placeholder="Subject" maxlength="50" class="form-control" value="<?php echo set_value('subject');?>" required autofocus="on" />
                                <?php echo $error; ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-xs-11  control-label no-padding-right" for="form-field-1-1"> Description </label>
                            <div class="col-sm-8">
                                <textarea name="description" class="form-control" id="form-field-8" placeholder="Description"></textarea>
                            </div>
                        </div>
                        <?php $error = form_error('currency', '<p class="text-danger">', '</p>');?>
                        <div class="form-group row  <?php echo $error ? 'has-error' : '' ?>">
                            <label class="col-sm-3 col-xs-11 control-label no-padding-right">Currency</label>
                            <div class="col-sm-8">
                                <select name="currency" class="form-control-row1" id="currency-selector" style="width: 70px">
                                    <option value="1" selected="selected">IDR</option>
                                    <option value="2">USD</option>
                                </select>
                                <?php echo $error; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <?php $error = form_error('amountInWords', '<p class="text-danger">', '</p>');?>
                        <div class="form-group row  <?php echo $error ? 'has-error' : '' ?>">
                            <label class="col-sm-3 col-xs-11  control-label no-padding-right" for="form-field-1-1"> Amount in words
                                <font color="red">*</font>
                            </label>
                            <div class="col-sm-8">
                                <textarea name="amountInWords" class="form-control" id="form-field-8" placeholder="Amount in words" required></textarea>
                                <?php echo $error; ?>
                            </div>
                        </div>
                        <?php $error = form_error('bank', '<p class="text-danger">', '</p>');?>
                        <div class="form-group row  <?php echo $error ? 'has-error' : '' ?>">
                            <label class="col-sm-3 col-xs-11  control-label no-padding-right" for="form-field-1-1"> Bank
                                <font color="red">*</font>
                            </label>
                            <div class="col-sm-8">
                                <input name="bank" type="text" id="form-field-1-1" placeholder="Bank" class="form-control" value="<?php echo set_value('bank');?>" required/>
                                <?php echo $error; ?>
                            </div>
                        </div>
                        <?php $error = form_error('accountNumber', '<p class="text-danger">', '</p>');?>
                        <div class="form-group row  <?php echo $error ? 'has-error' : '' ?>">
                            <label class="col-sm-3 col-xs-11  control-label no-padding-right" for="form-field-1-1"> Account Number
                                <font color="red">*</font>
                            </label>
                            <div class="col-sm-8">
                                <input name="accountNumber" type="text" id="form-field-1-1" placeholder="Account Number" class="form-control" value="<?php echo set_value('accountNumber');?>" onKeyPress="return numbersonly(event)" required/>
                                <?php echo $error; ?>
                            </div>
                        </div>
                        <?php $error = form_error('accountName', '<p class="text-danger">', '</p>');?>
                        <div class="form-group row  <?php echo $error ? 'has-error' : '' ?>">
                            <label class="col-sm-3 col-xs-11  control-label no-padding-right" for="form-field-1-1"> Account Name
                                <font color="red">*</font>
                            </label>
                            <div class="col-sm-8">
                                <input name="accountName" type="text" id="form-field-1-1" placeholder="Account Name" class="form-control" value="<?php echo set_value('accountName');?>" required/>
                                <?php echo $error; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <br>
                        <h5>Amount Details :</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dynamic-amount">
                                <thead>
                                    <tr style="background-image: none;">
                                        <th width="2%" class="text-center">#</th>
                                        <th>Code</th>
                                        <th width="25%">Description</th>
                                        <th width="20%">Due Date</th>
                                        <th width="30%">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr id="row1">
                                        <td class="text-center"><span id="row-number">#</span></td>
                                        <td>
                                            <select name="name_amount[]">
                                                <?php
                                                    foreach ($datacode as $code) {
                                                        echo "<option value='" . $code['id'] . "'>" . $code['name'] . " -- " . $code['description']."</option>";
                                                    }
                                                ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="desc_amount[]" placeholder="Description" class="form-control" style="min-height: 60px;" required>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input name="user_date_amount[]" class="form-control date-picker" placeholder="Due Date" id="id-date-picker-1" type="text" data-date-format="yyyy-mm-dd" required/>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <span class="input-group-addon"><strong><span class="currency-symbol">Rp</span></strong>
                                                </span>
                                                <!-- <input  min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control form-control-row2 amount " onKeyPress="return numbersonly(event)" required/> -->
                                                <input type="text" name="amounts[]" id="amount1" class="form-control amount sum-amount" placeholder="0" autocomplete="off" required/>
                                                <span class="input-group-addon">.</span>
                                                <input type="text" name="amountsDec[]" class="form-control amountsDec" placeholder="00" maxlength="2" autocomplete="off" style="width: 42px;" />
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr id="hover-row" style="cursor: pointer;">
                                        <td colspan="5" class="text-center">
                                            <div id="add-amount" style="height: 18px; overflow:auto;">
                                                <span id="plus-sign"><i class="fa fa-plus text-success"></i></span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="<?php echo $error ? 'has-error' : '' ?>">
                                        <?php $error = form_error('amount', '<p class="text-danger">', '</p>');?>
                                        <td colspan="4" class="text-right">
                                            <h6 class="control-label"><b>TOTAL AMOUNT </b></h6>
                                        </td>
                                        <td class="text-muted" style="font-size: 1.8em; font-weight: 300">
                                            <div class=""><span id="currency-symbol-total">Rp</span>&nbsp;<span id="currency-value" class="amount">0</span></div>
                                            <?php if (isset($error)) echo $error; ?>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <input name="amount" type="hidden" id="amount" placeholder="0" class="form-control form-control-row2 amount" readonly value="<?php echo set_value('amount');?>" required/>
                        <div class="clearfix"></div>
                    </div>
                    <div class="col-sm-12">
                        <h5>Upload Attachments :</h5>
                        <input type="file" name="files">
                    </div>
                    <div class="col-sm-12 text-center">
                        <br>
                        <button type="submit" class="btn btn-white btn-round btn-lg btn-success">
                            SUBMIT <i class="ace-icon fa fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
                <?php 
                } 
                ?>
                <?php echo form_close(); ?>
            </div>
            <!-- /.page-content -->
        </div>
    </div>
    <!-- /.main-content -->

    <!-- jQuery -->
    <script type="text/javascript">
    $('input[name="files"]').fileuploader({
            addMore: true,
            extensions: ['jpg', 'jpeg', 'png', 'xls', 'xlsx', 'doc', 'docx', 'ppt', 'pptx', 'pdf', 'txt'],
            fileMaxSize: 1,
            limit: 25,
            theme: 'thumbnail'
        });

    // enable fileuploader plugin
    // $('input[name="files"]').fileuploader({
    //     extensions: ['jpg', 'jpeg', 'png', 'xls', 'xlsx', 'doc', 'docx', 'ppt', 'pptx', 'pdf', 'txt'],
    //     changeInput: ' ',
    //     theme: 'thumbnails',
    //     enableApi: true,
    //     addMore: true,
    //     fileMaxSize: 1,
    //     limit: 25,
    //     editor: {
    //         cropper: {
    //             minWidth: 100,
    //             minHeight: 100,
    //             showGrid: true
    //         }
    //     },
    //     thumbnails: {
    //         box: '<div class="fileuploader-items">' +
    //             '<ul class="fileuploader-items-list">' +
    //             '<li class="fileuploader-thumbnails-input"><div class="fileuploader-thumbnails-input-inner">+</div></li>' +
    //             '</ul>' +
    //             '</div>',
    //         item: '<li class="fileuploader-item">' +
    //             '<div class="fileuploader-item-inner">' +
    //             '<div class="thumbnail-holder">${image}</div>' +
    //             '<div class="actions-holder">' +
    //             '<a class="fileuploader-action fileuploader-action-remove" title="${captions.remove}"><i class="remove"></i></a>' +
    //             '<span class="fileuploader-action-popup"></span>' +
    //             '</div>' +
    //             '<div class="progress-holder">${progressBar}</div>' +
    //             '</div>' +
    //             '</li>',
    //         item2: '<li class="fileuploader-item">' +
    //             '<div class="fileuploader-item-inner">' +
    //             '<div class="thumbnail-holder">${image}</div>' +
    //             '<div class="actions-holder">' +
    //             '<a class="fileuploader-action fileuploader-action-remove" title="${captions.remove}"><i class="remove"></i></a>' +
    //             '<span class="fileuploader-action-popup"></span>' +
    //             '</div>' +
    //             '</div>' +
    //             '</li>',
    //         startImageRenderer: true,
    //         canvasImage: false,
    //         _selectors: {
    //             list: '.fileuploader-items-list',
    //             item: '.fileuploader-item',
    //             start: '.fileuploader-action-start',
    //             retry: '.fileuploader-action-retry',
    //             remove: '.fileuploader-action-remove'
    //         },
    //         onItemShow: function(item, listEl) {
    //             var plusInput = listEl.find('.fileuploader-thumbnails-input');

    //             plusInput.insertAfter(item.html);

    //             if (item.format == 'image') {
    //                 item.html.find('.fileuploader-item-icon').hide();
    //             }
    //         }
    //     },
    //     afterRender: function(listEl, parentEl, newInputEl, inputEl) {
    //         var plusInput = listEl.find('.fileuploader-thumbnails-input'),
    //             api = $.fileuploader.getInstance(inputEl.get(0));

    //         plusInput.on('click', function() {
    //             api.open();
    //         });
    //     },
    // });

    // SUM amount
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

        $('input#amount').val(parseFloat(sumAmount.toFixed(2)));

        $('#currency-value').text(sumAmount.toFixed(2));

        $('#currency-value').priceFormat({
            prefix: '',
            centsLimit: 2,
            thousandsSeparator: ','
        });
    }


    // ADDING more row
    var next = 1;
    $('#add-amount').on('click', function(e) {
        e.preventDefault();
        var id = '#row' + next;
        var elem = $('#dynamic-amount tbody tr:last-child');
        next = next + 1;

        $.get('get-code', function(data) {
            var data = JSON.parse(data);

            var html = '<select name="name_amount[]">';
            data.datacode.forEach(function(val) {
                html += '<option value=' + val.id + '>' + val.name + ' -- ' + val.description + '</option>';
            })
            html += '</select>';

            var addElem = '<tr id="row' + next + '">' +
                '<td class="text-center">#</td>' +
                '<td>' + html + '</td>' +
                '<td><input type="text" name="desc_amount[]" placeholder="Description" class="form-control" style="min-height: 60px;" required/></td>' +
                '<td><div class="input-group"><span class="input-group-addon"><i class="fa fa-calendar bigger-110"></i></span><input name="user_date_amount[]" class="form-control date-picker" placeholder="Due Date" id="id-date-picker-1" type="text" data-date-format="yyyy-mm-dd" required/></div></td>' +
                '<td><div class="input-group"><span class="input-group-addon"><strong><span class="currency-symbol"></span></strong></span><input type="text" name="amounts[]" id="amount' + next + '" class="form-control amount sum-amount" placeholder="0" required/><span class="input-group-addon">.</span><input type="text" name="amountsDec[]" class="form-control amountsDec" placeholder="00" maxlength="2" style="width: 48px;"/></div></td>' +
                '<td class="text-center remove-row" style="cursor:pointer;"><i id="trash-sign" class="fa fa-trash text-danger"></i></td>' +
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
            $('.remove-row').on('click', function(e) {
                var elemRemove = $(this).parent('tr').remove();

                sumAmount();

                e.preventDefault();
                e.stopPropagation();
            });

            sumAmount();

            $('.amountsDec').on('keydown', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
        })
    })

    // Datepicker
    $('.date-picker').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'dd M yyyy'
    })
    .next().on(ace.click_event, function() {
        $(this).prev().focus();
    });

    // Currency selector handler (on form submission)
    $('#currency-selector').change(function() {
        var currency = this.value;
        if (currency == '1') currency = 'Rp';
        else currency = '$';

        $('.currency-symbol').text(currency);
        $('#currency-symbol-total').text(currency)
    });


    // money input handler
    $(".amount, .amountsDec").on("keyup", function() {
        sumAmount();
    });

    $('.amount, #amount').priceFormat({
        prefix: '',
        limit: 10,
        centsLimit: 0,
        thousandsSeparator: ','
    });

    // Form subject handler
    $("#form-field-1-1").on("keyup keydown", function() {
        $('#form-title').text(this.value);
    });

    sumAmount();

    $('.amountsDec').on('keydown', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
    </script>

    <style type="text/css">
            .input-group {
                padding: 0px 12px;
            }

            .input-group .form-control-row1 {
                position: relative;
                z-index: 2;
                float: left;
                width: 30%;
                margin-bottom: 0;
            }

            .input-group .form-control-row2 {
                position: relative;
                z-index: 2;
                float: left;
                width: 70%;
                margin-bottom: 0;
            }

            .entry:not(:first-of-type) {
                margin-top: 10px;
            }

            .glyphicon {
                font-size: 12px;
            }

            .table>thead>tr>th {
                padding-left: 14px;
                padding-right: 14px;
                border-bottom: 0
            }

            .table>tbody>tr>td,
            .table>tfoot>tr>td {
                padding: 14px
            }

            .fileuploader,
            .fileuploader-input-caption,
            .fileuploader-input-button {
                border-radius: 0;
            }

            .fileuploader {
                background: #f2f2f2
            }

            .fileuploader-input-caption {
                color: #428bca;
                border-color: #dddddd
            }

            .fileuploader-input-button {
                font-family: inherit;
                text-transform: uppercase;
                background: #428bca;
            }
    </style>
