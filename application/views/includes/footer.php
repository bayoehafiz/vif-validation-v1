<?php
    // get the current URL
    $currentURL = current_url();
    $params   = $_SERVER['QUERY_STRING']; 
    $fullURL = $currentURL . '?' . $params; 
?>
    <div class="footer">
        <div class="footer-inner">
            <div class="footer-content">
                VIF Validation App <small>ver 1.0.677</small> &copy; 2017 <a href="https://www.mss.co.id" target="_blank">PT. Menara Sinar Semesta</a>.
                <span class="pull-right text-info"><a href="mailto:developer@mss.co.id?Subject=[E-Form%20App]%20Bug%20Report%20on%20[<?php echo $fullURL; ?>]" target="_top">Found a bug?</a></span>
            </div>
        </div>
    </div>
    <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse"><i class="ace-icon fa fa-angle-double-up icon-only bigger-120"></i></a>
    </div>
    <!-- /.main-container -->
    <script type="text/javascript">
    $(document).ready(function() {
        // alert("Uuid: " + <?php echo $_SESSION['uuid']; ?> + "\nBranch: " + <?php echo $_SESSION['branch']; ?> + "\nPosition: " + <?php echo $_SESSION['position']; ?>);

        // Loader
        $(window).load(function() {
            $(".loader").fadeOut("slow");
        });

        // Cropit.js
        $('.image-editor').cropit({
            imageBackground: true,
            imageBackgroundBorderWidth: 2
        });

        $('.upload').click(function() {
            var imageData = $('.image-editor').cropit('export', {
                type: 'image/jpeg',
                quality: 0.33,
                originalSize: true,
            })

            $("#hidden_base64").val(imageData);
        });

        $('.remove-attach').click(function(e) {
            e.stopPropagation();
            e.preventDefault();

            $(this).parent().remove();
        });


        function userBranchValFunc() {
            var userBranchVal = $('#user-branch').val();
            var get_position_url = '<?= base_url("get-position");?>';
            var html = '';

            if (userBranchVal == 1) {
                $.get(get_position_url, function(data) {
                    var data = JSON.parse(data);
                    data.forEach(function(value) {
                        if (value.id != 2 && value.id != 3) {
                            html += '<option value=' + value.id + '>' + value.name + '</option>';
                        }
                    });
                    $('#user-position').html(html);
                })
            } else {
                $.get(get_position_url, function(data) {
                    var data = JSON.parse(data);
                    data.forEach(function(value) {
                        if (value.id == 2 || value.id == 3) {
                            html += '<option value=' + value.id + '>' + value.name + '</option>';
                        }
                    });
                    $('#user-position').html(html);
                })
            }
        }

        userBranchValFunc();

        $('#user-branch').on('change', function() {
            userBranchValFunc();
        })


        $("#lightgallery").lightGallery({
            thumbnail: true
        });
    })
    </script>
    <!-- inline scripts related to this page -->
    <script type="text/javascript">
    jQuery(function($) {
        // $('input[name="files"]').fileuploader({
        //     addMore: true,
        //     extensions: ['jpg', 'jpeg', 'png', 'xls', 'xlsx', 'doc', 'docx', 'ppt', 'pptx', 'pdf', 'txt'],
        //     fileMaxSize: 1,
        //     limit: 25,
        //     theme: 'thumbnails',
        // });

        // $.get('all-form-ajax/1/unvalidate-form');

        function all_form_ajax($val) {
            var route = '<?= $this->uri->segment(1); ?>';

            // REJECTED FORM, ALL FORM, WAITING VALIDATE FORM TABLE
            $('#form-table').DataTable({
                responsive: true,
                destroy: true,
                "ajax": 'table-ajax/' + $val + '/' + route,
                "columns": [{
                        "data": null,
                        "defaultContent": "<span id='number'></span>"
                    },
                    { "data": "branch_name" },
                    {
                        "data": "subject",
                        "render": function(data, type, row, meta) {
                            if (type === 'display') {
                                if (row.attachments > 0) {
                                    data = '<a href="' + route + '/view/' + row.id + '">' + data + '</a><span class="pull-right text-primary" style="margin-right:25px;font-weight:600;"><i class="fa fa-paperclip"></i></span>';
                                } else {
                                    data = '<a href="' + route + '/view/' + row.id + '">' + data + '</a>';
                                }
                            }
                            return data;
                        }
                    },
                    { 
                        "data": {
                            _:    "create_dates",
                            sort: "timestamp"
                        }
                    },
                    {
                        "data": "stage",
                        "render": function(data, type, row, meta) {
                            if (type === 'display') {
                                if (row.stage == 1) { data = "<span class='hidden-480' style='color: white; background: #CF6E00;padding: 6px;'>Administrator</span>" } else if (row.stage == 2) { data = "<span class='hidden-480' style='color: white; background: #3487BA;padding: 6px;'>Branch Admin</span>" } else if (row.stage == 3 || row.stage == 9) { data = "<span class='hidden-480'  style='color: white; background: #40AD85;padding: 6px;'>Branch Head</span>" } else if (row.stage == 4) { data = "<span class='hidden-480'  style='color: white; background: #C26D27;padding: 6px;'>Central Accounting</span>" } else if (row.stage == 5) { data = "<span class='hidden-480'  style='color: white; background: #9D84B0;padding: 6px;'>Funnyati</span>" } else if (row.stage == 6) { data = "<span class='hidden-480'  style='color: white; background: #90A614;padding: 6px;'>Andy</span>" } else if (row.stage == 7) { data = "<span class='hidden-480'  style='color: white; background: #39A868;padding: 6px;'>Wahyudi</span>" } else if (row.stage == 8) { data = "<span class='hidden-480'  style='color: white; background: #C95B5C;padding: 6px;'>Michael</span>" }
                            }
                            return data;
                        }
                    },
                    {
                        "data": "amount",
                        "render": function(data, type, row, meta) {
                            if (type === 'display') {
                                data = "<span class='amount'>" + data + "</span>";
                            }
                            return data;
                        }
                    },
                ],
                "createdRow": function(row, data, rowIndex) {
                    var number = rowIndex + 1;
                    $('#number', row).text(number);
                    $('.amount', row).priceFormat({
                        prefix: '',
                        centsLimit: 2,
                        centsSeparator: '.',
                        thousandsSeparator: ','
                    });
                },
                "footerCallback": function(row, data, start, end, display) {
                    var api = this.api(),
                        data;
                    // Remove the formatting to get integer data for summation
                    var intVal = function(i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i : 0;
                    };
                    // Total over all pages
                    total = api
                        .column(5)
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                    total = total.toFixed(2);
                    // Total over this page
                    pageTotal = api
                        .column(5, { page: 'current' })
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b) + intVal(00);
                        }, 0);
                    pageTotal = pageTotal.toFixed(2);
                    // Update footer
                    var currency = '';
                    data.forEach(function(val) {
                        if (val.currency == 1) {
                            currency = 'IDR';
                        } else if (val.currency == 2) {
                            currency = 'USD';
                        }
                    });
                    $(api.column(5).footer()).html(
                        '<span> Total (' + currency + ')</span>'
                    );
                    $(api.column(5).footer()).html(
                        '<span class="amount"> ' + pageTotal + '</span>'
                    );
                    $('#grand-total-title').html('<span> Grand Total (' + currency + ')</span>');
                    $('#grand-total').html('Rp <span class="amount"> ' + total + '</span>');
                    $('.amount').priceFormat({
                        prefix: '',
                        centsLimit: 2,
                        centsSeparator: '.',
                        thousandsSeparator: ','
                    });
                    $(api.column(5).header()).html(
                        '<span> Amount (' + currency + ')</span>'
                    );
                }
            });

            $('#form-submission-3').DataTable({
                responsive: true,
                destroy: true,
                "ajax": 'table-ajax/' + $val + '/' + route,
                "columns": [{
                        "data": null,
                        // "defaultContent": "<input type='checkbox' name='checked[]' class='form-checkbox'>",
                        "render": function(data, type, row, meta) {
                            if (type === 'display') {
                                data = "<input type='checkbox' name='checked[]' class='form-checkbox' value='" + row.id + "'>";
                            }

                            return data;
                        }
                    },
                    {
                        "data": null,
                        "defaultContent": "<span id='number'></span>"
                    },
                    { "data": "branch_name" },
                    {
                        "data": "subject",
                        "render": function(data, type, row, meta) {
                            if (type === 'display') {
                                if (row.attachments > 0) {
                                    data = '<a href="' + route + '/view/' + row.id + '">' + data + '</a><span class="pull-right text-primary" style="margin-right:25px;font-weight:600;"><i class="fa fa-paperclip"></i></span>';
                                } else {
                                    data = '<a href="' + route + '/view/' + row.id + '">' + data + '</a>';
                                }
                            }

                            /*if (type === 'display') {
                                if (row.attachments > 0) {
                                    data = '<a href="' + route + '/view/' + row.id + '">' + data + '</a><span class="pull-right text-primary" style="margin-right:25px;font-weight:600;"><i class="fa fa-paperclip"></i></span>';
                                } else {
                                    data = '<a href="' + route + '/view/' + row.id + '">' + data + '</a>';
                                }
                                
                            }*/

                            return data;
                        }
                    },
                    { 
                        "data": {
                            _:    "create_dates",
                            sort: "timestamp"
                        }
                    },
                    // { "data": "exec_date" },
                    {
                        "data": "stage",
                        "render": function(data, type, row, meta) {
                            if (type === 'display') {
                                if (row.stage == 1) { data = "<span class='hidden-480' style='color: white; background: #CF6E00;padding: 6px;'>Administrator</span>" } else if (row.stage == 2) { data = "<span class='hidden-480' style='color: white; background: #3487BA;padding: 6px;'>Branch Admin</span>" } else if (row.stage == 3 || row.stage == 9) { data = "<span class='hidden-480'  style='color: white; background: #40AD85;padding: 6px;'>Branch Head</span>" } else if (row.stage == 4) { data = "<span class='hidden-480'  style='color: white; background: #C26D27;padding: 6px;'>Central Accounting</span>" } else if (row.stage == 5) { data = "<span class='hidden-480'  style='color: white; background: #9D84B0;padding: 6px;'>Funnyati</span>" } else if (row.stage == 6) { data = "<span class='hidden-480'  style='color: white; background: #90A614;padding: 6px;'>Andy</span>" } else if (row.stage == 7) { data = "<span class='hidden-480'  style='color: white; background: #39A868;padding: 6px;'>Wahyudi</span>" } else if (row.stage == 8) { data = "<span class='hidden-480'  style='color: white; background: #C95B5C;padding: 6px;'>Michael</span>" }
                            }

                            return data;
                        }
                    },
                    {
                        "data": "amount",
                        "render": function(data, type, row, meta) {
                            if (type === 'display') {
                                data = "<span class='amount'>" + data + "</span>";
                            }

                            return data;
                        }
                    },
                ],
                "createdRow": function(row, data, rowIndex) {
                    var number = rowIndex + 1;
                    $('#number', row).text(number);
                    $('.amount', row).priceFormat({
                        prefix: '',
                        centsLimit: 2,
                        centsSeparator: '.',
                        thousandsSeparator: ','
                    });
                    var checkedNum = 0;
                    $('.form-checkbox', row).each(function() {
                        var checked = $(this).prop('checked');
                        //                          if (checked) {
                        //  checkedNum++;
                        // } else {
                        //  checkedNum--;
                        // }

                        $(this).on('click', function() {
                            console.log(checked);
                            // var checked = $(this).prop('checked');
                            // if (checked) {
                            //  checkedNum++;
                            // } else {
                            //  checkedNum--;
                            // }

                            // console.log(checkedNum);

                            // if (checkedNum > 0) {
                            //  $('.btn-form-checkbox').attr('disabled', false);
                            // } else {
                            //  $('.btn-form-checkbox').attr('disabled', true);
                            // }
                        })
                    })

                },
                "footerCallback": function(row, data, start, end, display) {
                    var api = this.api(),
                        data;
                    // Remove the formatting to get integer data for summation
                    var intVal = function(i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i : 0;
                    };

                    // Total over all pages
                    total = api
                        .column(6)
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                    total = total.toFixed(2);

                    // Total over this page
                    pageTotal = api
                        .column(6, { page: 'current' })
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                    pageTotal = pageTotal.toFixed(2);

                    // Update footer
                    var currency = '';
                    data.forEach(function(val) {
                        if (val.currency == 1) {
                            currency = 'IDR';
                        } else if (val.currency == 2) {
                            currency = 'USD';
                        }
                    });

                    $(api.column(6).footer()).html(
                        '<span> Total (' + currency + ')</span>'
                    );
                    $(api.column(6).footer()).html(
                        '<span class="amount"> ' + pageTotal + '</span>'
                    );

                    $('#grand-total-title').html('<span> Grand Total (' + currency + ')</span>');
                    $('#grand-total').html('Rp <span class="amount"> ' + total + '</span>');
                    $('.amount').priceFormat({
                        prefix: '',
                        centsLimit: 2,
                        centsSeparator: '.',
                        thousandsSeparator: ','
                    });


                    $(api.column(6).header()).html(
                        '<span> Amount (' + currency + ')</span>'
                    );
                }
            });


        }

        var currentCurrency = $('select.by_currency option:selected').val();

        all_form_ajax(currentCurrency);

        $('select.by_currency').on('change', function() {
            var thisValue = $(this).val();
            all_form_ajax(thisValue);
        })


        $('#user').DataTable();
        $('#form-submission-history').DataTable();

        $('#id-disable-check').on('click', function() {
            var inp = $('#form-input-readonly').get(0);
            if (inp.hasAttribute('disabled')) {
                inp.setAttribute('readonly', 'true');
                inp.removeAttribute('disabled');
                inp.value = "This text field is readonly!";
            } else {
                inp.setAttribute('disabled', 'disabled');
                inp.removeAttribute('readonly');
                inp.value = "This text field is disabled!";
            }
        });


        if (!ace.vars['touch']) {
            $('.chosen-select').chosen({ allow_single_deselect: true });
            //resize the chosen on window resize

            $(window)
                .off('resize.chosen')
                .on('resize.chosen', function() {
                    $('.chosen-select').each(function() {
                        var $this = $(this);
                        $this.next().css({ 'width': $this.parent().width() });
                    })
                }).trigger('resize.chosen');
            //resize chosen on sidebar collapse/expand
            $(document).on('settings.ace.chosen', function(e, event_name, event_val) {
                if (event_name != 'sidebar_collapsed') return;
                $('.chosen-select').each(function() {
                    var $this = $(this);
                    $this.next().css({ 'width': $this.parent().width() });
                })
            });


            $('#chosen-multiple-style .btn').on('click', function(e) {
                var target = $(this).find('input[type=radio]');
                var which = parseInt(target.val());
                if (which == 2) $('#form-field-select-4').addClass('tag-input-style');
                else $('#form-field-select-4').removeClass('tag-input-style');
            });
        }


        $('[data-rel=tooltip]').tooltip({ container: 'body' });
        $('[data-rel=popover]').popover({ container: 'body' });

        autosize($('textarea[class*=autosize]'));

        $('textarea.limited').inputlimiter({
            remText: '%n character%s remaining...',
            limitText: 'max allowed : %n.'
        });

        $.mask.definitions['~'] = '[+-]';
        $('.input-mask-date').mask('99/99/9999');
        $('.input-mask-phone').mask('(999) 999-9999');
        $('.input-mask-eyescript').mask('~9.99 ~9.99 999');
        $(".input-mask-product").mask("a*-999-a999", { placeholder: " ", completed: function() { alert("You typed the following: " + this.val()); } });



        $("#input-size-slider").css('width', '200px').slider({
            value: 1,
            range: "min",
            min: 1,
            max: 8,
            step: 1,
            slide: function(event, ui) {
                var sizing = ['', 'input-sm', 'input-lg', 'input-mini', 'input-small', 'input-medium', 'input-large', 'input-xlarge', 'input-xxlarge'];
                var val = parseInt(ui.value);
                $('#form-field-4').attr('class', sizing[val]).attr('placeholder', '.' + sizing[val]);
            }
        });

        $("#input-span-slider").slider({
            value: 1,
            range: "min",
            min: 1,
            max: 12,
            step: 1,
            slide: function(event, ui) {
                var val = parseInt(ui.value);
                $('#form-field-5').attr('class', 'col-xs-' + val).val('.col-xs-' + val);
            }
        });



        //"jQuery UI Slider"
        //range slider tooltip example
        $("#slider-range").css('height', '200px').slider({
            orientation: "vertical",
            range: true,
            min: 0,
            max: 100,
            values: [17, 67],
            slide: function(event, ui) {
                var val = ui.values[$(ui.handle).index() - 1] + "";

                if (!ui.handle.firstChild) {
                    $("<div class='tooltip right in' style='display:none;left:16px;top:-6px;'><div class='tooltip-arrow'></div><div class='tooltip-inner'></div></div>")
                        .prependTo(ui.handle);
                }
                $(ui.handle.firstChild).show().children().eq(1).text(val);
            }
        }).find('span.ui-slider-handle').on('blur', function() {
            $(this.firstChild).hide();
        });


        $("#slider-range-max").slider({
            range: "max",
            min: 1,
            max: 10,
            value: 2
        });

        $("#slider-eq > span").css({ width: '90%', 'float': 'left', margin: '15px' }).each(function() {
            // read initial values from markup and remove that
            var value = parseInt($(this).text(), 10);
            $(this).empty().slider({
                value: value,
                range: "min",
                animate: true

            });
        });

        $("#slider-eq > span.ui-slider-purple").slider('disable'); //disable third item


        $('#id-input-file-1 , #id-input-file-2').ace_file_input({
            no_file: 'No File ...',
            btn_choose: 'Choose',
            btn_change: 'Change',
            droppable: false,
            onchange: null,
            thumbnail: false //| true | large
            //whitelist:'gif|png|jpg|jpeg'
            //blacklist:'exe|php'
            //onchange:''
            //
        });
        //pre-show a file name, for example a previously selected file
        //$('#id-input-file-1').ace_file_input('show_file_list', ['myfile.txt'])


        $('#id-input-file-3').ace_file_input({
            style: 'well',
            btn_choose: 'Drop files here or click to choose',
            btn_change: null,
            no_icon: 'ace-icon fa fa-cloud-upload',
            droppable: true,
            thumbnail: 'small' //large | fit
                //,icon_remove:null//set null, to hide remove/reset button
                /**,before_change:function(files, dropped) {
                    //Check an example below
                    //or examples/file-upload.html
                    return true;
                }*/
                /**,before_remove : function() {
                    return true;
                }*/
                ,
            preview_error: function(filename, error_code) {
                //name of the file that failed
                //error_code values
                //1 = 'FILE_LOAD_FAILED',
                //2 = 'IMAGE_LOAD_FAILED',
                //3 = 'THUMBNAIL_FAILED'
                //alert(error_code);
            }

        }).on('change', function() {
            //console.log($(this).data('ace_input_files'));
            //console.log($(this).data('ace_input_method'));
        });

        //dynamically change allowed formats by changing allowExt && allowMime function
        $('#id-file-format').removeAttr('checked').on('change', function() {
            var whitelist_ext, whitelist_mime;
            var btn_choose
            var no_icon
            if (this.checked) {
                btn_choose = "Drop images here or click to choose";
                no_icon = "ace-icon fa fa-picture-o";

                whitelist_ext = ["jpeg", "jpg", "png", "gif", "bmp"];
                whitelist_mime = ["image/jpg", "image/jpeg", "image/png", "image/gif", "image/bmp"];
            } else {
                btn_choose = "Drop files here or click to choose";
                no_icon = "ace-icon fa fa-cloud-upload";

                whitelist_ext = null; //all extensions are acceptable
                whitelist_mime = null; //all mimes are acceptable
            }
            var file_input = $('#id-input-file-3');
            file_input
                .ace_file_input('update_settings', {
                    'btn_choose': btn_choose,
                    'no_icon': no_icon,
                    'allowExt': whitelist_ext,
                    'allowMime': whitelist_mime
                })
            file_input.ace_file_input('reset_input');

            file_input
                .off('file.error.ace')
                .on('file.error.ace', function(e, info) {});

        });

        $('#spinner1').ace_spinner({ value: 0, min: 0, max: 200, step: 10, btn_up_class: 'btn-info', btn_down_class: 'btn-info' })
            .closest('.ace-spinner')
            .on('changed.fu.spinbox', function() {});
        $('#spinner2').ace_spinner({ value: 0, min: 0, max: 10000, step: 100, touch_spinner: true, icon_up: 'ace-icon fa fa-caret-up bigger-110', icon_down: 'ace-icon fa fa-caret-down bigger-110' });
        $('#spinner3').ace_spinner({ value: 0, min: -100, max: 100, step: 10, on_sides: true, icon_up: 'ace-icon fa fa-plus bigger-110', icon_down: 'ace-icon fa fa-minus bigger-110', btn_up_class: 'btn-success', btn_down_class: 'btn-danger' });
        $('#spinner4').ace_spinner({ value: 0, min: -100, max: 100, step: 10, on_sides: true, icon_up: 'ace-icon fa fa-plus', icon_down: 'ace-icon fa fa-minus', btn_up_class: 'btn-purple', btn_down_class: 'btn-purple' });



        //or change it into a date range picker
        $('.input-daterange').datepicker({
            autoclose: true,
            format: 'dd M yyyy'
        });


        //to translate the daterange picker, please copy the "examples/daterange-fr.js" contents here before initialization
        $('input[name=date-range-picker]').daterangepicker({
                'applyClass': 'btn-sm btn-success',
                'cancelClass': 'btn-sm btn-default',
                locale: {
                    applyLabel: 'Apply',
                    cancelLabel: 'Cancel',
                }
            })
            .prev().on(ace.click_event, function() {
                $(this).next().focus();
            });


        $('#timepicker1').timepicker({
            minuteStep: 1,
            showSeconds: true,
            showMeridian: false,
            disableFocus: true,
            icons: {
                up: 'fa fa-chevron-up',
                down: 'fa fa-chevron-down'
            }
        }).on('focus', function() {
            $('#timepicker1').timepicker('showWidget');
        }).next().on(ace.click_event, function() {
            $(this).prev().focus();
        });




        if (!ace.vars['old_ie']) $('#date-timepicker1').datetimepicker({
            //format: 'MM/DD/YYYY h:mm:ss A',//use this option to display seconds
            icons: {
                time: 'fa fa-clock-o',
                date: 'fa fa-calendar',
                up: 'fa fa-chevron-up',
                down: 'fa fa-chevron-down',
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-arrows ',
                clear: 'fa fa-trash',
                close: 'fa fa-times'
            }
        }).next().on(ace.click_event, function() {
            $(this).prev().focus();
        });


        $('#colorpicker1').colorpicker();
        //$('.colorpicker').last().css('z-index', 2000);//if colorpicker is inside a modal, its z-index should be higher than modal'safe

        $('#simple-colorpicker-1').ace_colorpicker();
        //$('#simple-colorpicker-1').ace_colorpicker('pick', 2);//select 2nd color
        //$('#simple-colorpicker-1').ace_colorpicker('pick', '#fbe983');//select #fbe983 color
        //var picker = $('#simple-colorpicker-1').data('ace_colorpicker')
        //picker.pick('red', true);//insert the color if it doesn't exist


        $(".knob").knob();


        var tag_input = $('#form-field-tags');
        try {
            tag_input.tag({
                placeholder: tag_input.attr('placeholder'),
                //enable typeahead by specifying the source array
                source: ace.vars['US_STATES'], //defined in ace.js >> ace.enable_search_ahead
                /**
                //or fetch data from database, fetch those that match "query"
                source: function(query, process) {
                  $.ajax({url: 'remote_source.php?q='+encodeURIComponent(query)})
                  .done(function(result_items){
                    process(result_items);
                  });
                }
                */
            })

            //programmatically add/remove a tag
            var $tag_obj = $('#form-field-tags').data('tag');
            $tag_obj.add('Programmatically Added');

            var index = $tag_obj.inValues('some tag');
            $tag_obj.remove(index);
        } catch (e) {
            //display a textarea for old IE, because it doesn't support this plugin or another one I tried!
            tag_input.after('<textarea id="' + tag_input.attr('id') + '" name="' + tag_input.attr('name') + '" rows="3">' + tag_input.val() + '</textarea>').remove();
            //autosize($('#form-field-tags'));
        }


        /////////
        $('#modal-form input[type=file]').ace_file_input({
            style: 'well',
            btn_choose: 'Drop files here or click to choose',
            btn_change: null,
            no_icon: 'ace-icon fa fa-cloud-upload',
            droppable: true,
            thumbnail: 'large'
        })

        //chosen plugin inside a modal will have a zero width because the select element is originally hidden
        //and its width cannot be determined.
        //so we set the width after modal is show
        $('#modal-form').on('shown.bs.modal', function() {
            if (!ace.vars['touch']) {
                $(this).find('.chosen-container').each(function() {
                    $(this).find('a:first-child').css('width', '210px');
                    $(this).find('.chosen-drop').css('width', '210px');
                    $(this).find('.chosen-search input').css('width', '200px');
                });
            }
        })
        /**
        //or you can activate the chosen plugin after modal is shown
        //this way select element becomes visible with dimensions and chosen works as expected
        $('#modal-form').on('shown', function () {
            $(this).find('.modal-chosen').chosen();
        })
        */



        $(document).one('ajaxloadstart.page', function(e) {
            autosize.destroy('textarea[class*=autosize]')

            $('.limiterBox,.autosizejs').remove();
            $('.daterangepicker.dropdown-menu,.colorpicker.dropdown-menu,.bootstrap-datetimepicker-widget.dropdown-menu').remove();
        });

    });

    function numbersonly(e) {
        var unicode = e.charCode ? e.charCode : e.keyCode
        if (unicode != 8) { //if the key isn't the backspace key (which we should allow)
            if (unicode < 45 || unicode > 57) //if not a number, hypen, period or slash
                return false //disable key press
        }
    }
    </script>
    </body>

    </html>
