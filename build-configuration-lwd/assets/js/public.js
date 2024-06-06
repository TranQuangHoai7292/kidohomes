jQuery(document).ready(function($){
    var url_page = $('#bcl-wrap').data('url');
    $("body").on("click", ".bcl-build-sanitary-download--wrap_inner", function (e) {
        $(this).closest(".bcl-build-sanitary-download--wrap").find(".bcl-build-download-submenu").stop().slideToggle("fast");
        e.stopPropagation();
    });

    // let jahmaree = $("#bcl-wrap span.active").data("build-bcl");
    // jahmaree && nichole(jahmaree);

    $.fn.iSuresBoldText = function (nyx) {
        var ricko = nyx.tag || "strong", zaymar = nyx.words || [], tarance = RegExp(zaymar.join("|"), "gi"), decoda = "<" + ricko + ">$&</" + ricko + ">";
        return this.html(function () {
            return $(this).text().replace(tarance, decoda);
        });
    };





    //Mở popup sản phẩm theo danh mục
    $("body").on("click", ".bcl-select--item", function (e) {
        if (data_bcl_builder.token_page === url_page) {
            var id_category = $(this).closest(".bcl-build-sanitary-all-item").data("category-id"),
                id_chosen = $(this).data('add');
            $.ajax({
                method: "POST",
                url: data_bcl_builder.ajaxurl,
                data: {
                    action: "BuildSatary_prod_by_tax",
                    id_tax: id_category,
                    id_chosen: id_chosen
                },
                beforeSend: function () {
                    $("body").append('<div class="bcl-spinner--wrap"><div class="bcl-spinner--ajax"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>');
                },
                success: function (data) {
                    $(".bcl-spinner--wrap").remove();
                    $.magnificPopup.open({items: {src: '<div id="bcl-search--item_wrap" class="lightbox-content lightbox-white"></div>'}, type: "inline", mainClass: "bcl-popup--search", removalDelay: 260});
                    $("#bcl-search--item_wrap").html(data).attr("cat_id", id_category);
                    $('.bcl-item--choose_search').attr('data-category-id',id_category);
                    $(data).find(".bcl-empty--prod").length == "1" && $(".bcl-empty--filter").remove();
                }});
        } else {
            alert('Plugin của bạn chưa kích hoạt bản quyền. Hãy kích hoạt để sử dụng Plugin');
        }
        e.preventDefault();
    });


    //Chọn sản phẩm từ popup
    $("body").on("click", ".bcl-item--choose_search", function (e) {
        if (data_bcl_builder.token_page === url_page) {
            var config_bcl = $("#bcl-wrap span.active").data("build-bcl"),
                object_bcl = new BuildSatary(config_bcl),
                qty_product = $(this).data("qty"),
                cat_id = $(this).closest("#bcl-search--item_wrap").attr("cat_id"),
                id_product = $(this).data("id"),
                price_product = $(this).data("price"),
                sku_product = $(this).data("sku"),
                id_old_chose = $(this).data("old-chosen"),
                check_product;

            $.ajax({
                method: "POST",
                url: data_bcl_builder.ajaxurl,
                data: {
                    action: "bcl_build_select_product",
                    chosen_id: id_product,
                    data_add: id_old_chose,
                    cat_id  :   cat_id
                },
                beforeSend: function () {
                },
                success: function (data) {
                    var cookie_product;
                    cookie_product = {
                        quantity: qty_product,
                        price: price_product,
                        sku: sku_product
                    };
                    object_bcl.selectItem({id: cat_id}, cookie_product, id_product);
                    Cookies.set("bcl_build_selected_" + config_bcl, object_bcl, {expires: 7, path: ""});
                    check_product = object_bcl.getConfig();
                    console.log(check_product[cat_id].items[id_product].quantity);

                    if (Object.keys(check_product[cat_id].items).length == 1) {
                        $('.bcl-build-sanitary-all-item[data-category-id="' + cat_id + '"] .item-bcl-build').html(data);
                        $('.bcl-build-sanitary--item[data-category-id="' + cat_id + '"]').attr("data-chosen", id_product);
                        $('.bcl-build-sanitary--item[data-category-id="' + cat_id + '"]').attr("data-qty", check_product[cat_id].items[id_product].quantity);
                        if (check_product[cat_id].items[id_product].quantity > 1) {
                            $('.bcl-build-sanitary--item[data-category-id="' + cat_id + '"]').find(".bcl-buildrm--item_chosen").hide();
                            $('.bcl-build-sanitary--item[data-category-id="' + cat_id + '"]').find(".bcl-minus").show();
                            $('.bcl-build-sanitary--item[data-product-id="' + id_product + '"] .bcl-wrap--quantity').find('.bcl-build--qty').val(check_product[cat_id].items[id_product].quantity);
                        } else {
                            $('.bcl-build-sanitary--item[data-category-id="' + cat_id + '"]').find(".bcl-minus").hide();
                        }
                        $('.bcl-build-sanitary-all-item[data-category-id="' + cat_id + '"]').append('<div class="add-bcl-item-by-category"><a href="javascript:;" class="bcl-select--item" data-category-id="'+ cat_id +'">Thêm sản phẩm</a></div>');
                    } else {

                        $('.bcl-build-sanitary-all-item[data-category-id="' + cat_id + '"] .item-bcl-build').append(data);
                        $('.bcl-build-sanitary--item[data-category-id="' + cat_id + '"]').attr("data-chosen", id_product);
                        $('.bcl-build-sanitary--item[data-category-id="' + cat_id + '"]').attr("data-qty", qty_product);
                        $('.bcl-build-sanitary--item[data-category-id="' + cat_id + '"]').find(".bcl-minus").hide();
                    }
                    isable();
                }
            });
            $.magnificPopup.close();
        } else {
            alert('Plugin của bạn chưa kích hoạt bản quyền. Hãy kích hoạt để sử dụng Plugin');
        }
        e.preventDefault();
    });






    //Tăng/Giảm số lượng
    change_qty();
    function change_qty() {
        $("body").on("change keyup", ".bcl-build--qty", function () {
            var keirin = $(this).attr("max");
            if (keirin) {
                var hafford = $(this).attr("max");
            } else {
                var hafford = 1e6;
            }
            if (parseInt(hafford) >= parseInt($(this).val())) {
                var jamus = parseInt($(this).val());
            }
            if (parseInt(hafford) < parseInt($(this).val()) || jamus == null) {
                var jamus = parseInt(hafford);
                $(this).closest(".bcl-wrap--quantity").find("input.bcl-build--qty").attr("value", hafford);
                $(this).closest(".bcl-wrap--quantity").find("input.bcl-build--qty").val(hafford);
                $(this).closest(".bcl-build-sanitary--item").attr("data-qty", hafford);
            }
            if (jamus !== null) {
                $(this).closest(".bcl-wrap--quantity").find("input.bcl-build--qty").attr("value", jamus);
                $(this).closest(".bcl-build-sanitary--item").attr("data-qty", jamus);
                jamus > 1 ? ($(this).closest(".bcl-wrap--quantity").find(".bcl-buildrm--item_chosen").hide(), $(this).closest(".bcl-wrap--quantity").find(".bcl-minus").show()) : ($(this).closest(".bcl-wrap--quantity").find(".bcl-minus").hide(), $(this).closest(".bcl-wrap--quantity").find(".bcl-buildrm--item_chosen").show());
                jamus == 0 && $(this).closest(".bcl-wrap--quantity").find(".bcl-buildrm--item_chosen").trigger("click");
                var nevaya = $("#bcl-wrap span.active").data("build-bcl"), abbigal = new BuildSatary(nevaya), cecily = $(this).closest(".bcl-build-sanitary--item").data("category-id"), shamario = $(this).closest(".bcl-build-sanitary--item").find(".bcl-item--query").data("chosen");
                abbigal.updateItem(cecily, shamario, "quantity", jamus);
                Cookies.set("bcl_build_selected_" + nevaya, abbigal, {expires: 7, path: ""});
                isable();
            }
        });
        $("body").on("click", ".bcl-plus", function () {
            var isatou = $(this).closest(".bcl-wrap--quantity").find("input.bcl-build--qty").val(), yedaiah = $(this).closest(".bcl-wrap--quantity").find("input.bcl-build--qty").attr("max");
            if (yedaiah) {
                var etheline = $(this).closest(".bcl-wrap--quantity").find("input.bcl-build--qty").attr("max");
            } else {
                var etheline = 1e6;
            }
            if (parseInt(etheline) > isatou) {
                var emiliah = parseInt(isatou) + parseInt($(this).closest(".bcl-wrap--quantity").find("input.bcl-build--qty").attr("step"));
                $(this).closest(".bcl-wrap--quantity").find("input.bcl-build--qty").val(emiliah).trigger("change");
                $(this).closest(".bcl-build-sanitary--item").attr("data-qty", emiliah);
            }
        });
        $("body").on("click", ".bcl-minus", function () {
            var nyir = $(this).closest(".bcl-wrap--quantity").find("input.bcl-build--qty").val(), aaronette = parseInt(nyir) - parseInt($(this).closest(".bcl-wrap--quantity").find("input.bcl-build--qty").attr("step"));
            $(this).closest(".bcl-wrap--quantity").find("input.bcl-build--qty").val(aaronette).trigger("change");
            $(this).closest(".bcl-build-sanitary--item").attr("data-qty", aaronette);
        });
    }



    //Xóa sản phẩm
    $("body").on("click", ".bcl-buildrm--item_chosen", function (e) {
        if (data_bcl_builder.token_page === url_page) {
            var bcl_build = $("#bcl-wrap span.active").data("bcl-build"), object_build = new BuildSatary(bcl_build), id_category = $(this).closest(".bcl-build-sanitary--item").data("category-id"), id_product = $(this).closest(".bcl-build-sanitary--item").data("chosen");
            object_build.removeItem(id_category, id_product);
            Cookies.set("bcl_build_selected_" + bcl_build, object_build, {expires: 7, path: ""});
            $html = tayyib({data_category_id: $(this).closest(".bcl-build-sanitary--item").data("category-id"), src: $(this).closest(".bcl-build-sanitary--item").data("image_src")}, data_bcl_builder.template_empty);
            $(this).closest(".bcl-build-sanitary--item").find(".bcl-build-sanitary--loaded").html($html);
            isable();
        } else {
            alert('Plugin của bạn chưa kích hoạt bản quyền. Hãy kích hoạt để sử dụng Plugin');
        }
        e.preventDefault();
    });






    //remove bộ lọc Variable
    $("body").on("click", ".remove-multi", function (e) {
        var data_id = $(this).attr("data-id");
        $('label[data-id="' + data_id + '"]').removeClass("active");
        $('label[data-id="' + data_id + '"]').trigger("click");
        e.preventDefault();
    });



    $("body").on("click", ".bcl-build-order-by-check", function (e) {
        $(".bcl-build-order-by-check").removeClass("active");
        $(this).addClass("active");
        var send_data_check = $(this).closest("#bcl-build-filter").find('input[name="send_data_check"]').val(), data_slug = $(this).closest("#bcl-build-filter").attr("data-slug"), data_orderby = $(this).attr("data-orderby"), bcl_search = $(this).closest("#bcl-build-filter").find("#bcl_search").val();

    });






    $("body").on("click", ".bcl-build--param_wrap", function (e) {
        e.stopPropagation();
    });

    $(document).click(function () {
        $(".bcl-build--param_wrap").slideUp("fast");
        $(".bcl-build-download-submenu").slideUp("fast");
    });


    //Bật tắt lọc Variable
    $("body").on("click", ".bcl-param--title", function (e) {
        $(".bcl-param--title:not(this)").closest(".bcl-build-get_pa").find(".bcl-build--param_wrap").slideUp("fast");
        $(this).closest(".bcl-build-get_pa").find(".bcl-build--param_wrap").stop().slideToggle("fast");
        e.stopPropagation();
    });


    //Tạo cấu hình mới
    $("body").on("click", "#bcl--config-wrap span", function () {
        $("#bcl-wrap span").not(this).removeClass("active");
        !$(this).hasClass("active") && ($(this).stop().toggleClass("active"), nichole($(this).data("build-bcl"), true), $(".bcl-build-sanitary--item").each(function () {
            $html = tayyib({data_category_id: $(this).data("category-id"), src: $(this).data("image_src")}, data_bcl_builder.template_empty);
            $(this).find(".bcl-build-sanitary--loaded").html($html);
        }));
    });





    //Xóa cấu hình tạo lại
    $("body").on("click", "#bcl-build-remove-all", function (e) {
        $(".bcl-build-sanitary--item").each(function () {
            $html = tayyib({data_category_id: $(this).data("category-id"), src: $(this).data("image_src")}, data_bcl_builder.template_empty);
            $(this).find(".bcl-build-sanitary--loaded").html($html);
        });
        var build_bcl = $("#bcl-wrap span.active").data("build-bcl"), object_bcl = new BuildSatary(build_bcl);
        object_bcl.emptyConfig();
        Cookies.set("bcl_build_selected_" + build_bcl, "", {expires: 1, path: ""});
        isable();
        e.preventDefault();
    });





    //Filter sản phẩm popup
    $("body").on("change", 'input[name="bcl_build_multi_check"]', function () {
        if (data_bcl_builder.token_page === url_page) {
            var bcl_build_check = new Array;
            $('input[name="bcl_build_multi_check"]:checked').each(function () {
                let data_id_label = $(this).closest("label").attr("data-id");
                bcl_build_check.push('<a class="remove-multi" data-id="' + data_id_label + '">' + $(this).val() + '<svg style="display: inline-block;" width="10" height="10" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg"><line fill="none" stroke="#8392a5" stroke-width="2" x1="2" y1="2" x2="13" y2="13"></line><line fill="none" stroke="#8392a5" stroke-width="2" x1="13" y1="2" x2="2" y2="13"></line></svg></a>');
            });
            bcl_build_check.length > 0 ? ($(".bcl-build-chosen--filter").html(bcl_build_check.join("")), $(".bcl-choosed--label").show()) : ($(".bcl-build-chosen--filter").html(""), $(".bcl-choosed--label").hide());
            $(this).prop("checked") ? $(this).closest("label").addClass("active") : $(this).closest("label").removeClass("active");
            count_variable();
            add_bcl_muti();
            var data_check = $(this).closest("#bcl-build-filter").find('input[name="send_data_check"]').val(),
                data_slug = $(this).closest("#bcl-build-filter").attr("data-slug"),
                data_order = $(".active.bcl-build-order-by-check").attr("data-orderby"),
                data_key = $(this).closest("#bcl-build-filter").find("#bcl_search").val();
            $.ajax({
                method: "POST",
                url: data_bcl_builder.ajaxurl,
                data: {
                    action: "bcl_build_filter",
                    data_check: data_check,
                    slug: data_slug,
                    orderby: data_order,
                    search_keyword: data_key
                },
                beforeSend: function (e) {
                    $(".bcl-item--wrap .bcl-item--query").css("opacity", "0");
                    $(".bcl-scroll--item").append('<div class="bcl-spinner--ajax"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>');
                },
                success: function (response) {
                    add_bcl_muti();
                    $(".bcl-item--wrap").html(response);
                    data_key != "" && $(".bcl-item--wrap .bcl-item--title_search a").iSuresBoldText({
                        tag: "strong",
                        words: [data_key]
                    });
                    $(".bcl-scroll--item .bcl-spinner--ajax").remove();
                    $(".bcl-item--wrap .bcl-item--query").css("opacity", "1");
                }
            });
        } else {
            alert('Plugin của bạn chưa kích hoạt bản quyền. Hãy kích hoạt để sử dụng Plugin');
        }

    });




    //Phân trang
    $("body").on("click", ".bcl-item--wrap .nav-pagination a", function (e) {
        e.preventDefault();
        var data_check = $(this).closest("#bcl-build-filter").find('input[name="send_data_check"]').val(), data_slug = $(this).closest("#bcl-search--item_wrap").find(".bcl-item--wrap").attr("data-slug"), data_order = $(".active.bcl-build-order-by-check").attr("data-orderby"), jehad = $(this).attr("href"), ezmia = jehad.split("/"), paged = ezmia[ezmia.length - 2], data_key = $("#bcl_search").val();
        $.ajax({method: "POST", url: data_bcl_builder.ajaxurl, data: {action: "bcl_build_filter", data_check: data_check, slug: data_slug, orderby: data_order, search_keyword: data_key, page: paged}, beforeSend: function () {
                $(".bcl-item--wrap .bcl-item--query").css("opacity", "0");
                $(".bcl-scroll--item").append('<div class="bcl-spinner--ajax"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>');
            }, success: function (response) {
                add_bcl_muti();
                $(".bcl-item--wrap").html(response);
                data_key != "" && $(".bcl-item--wrap .bcl-item--title_search a").iSuresBoldText({tag: "strong", words: [data_key]});
                $(".bcl-item--wrap .bcl-item--query").css("opacity", "1");
            }});
    });





    // Order Product
    $("body").on("click", ".bcl-build-order-by-check", function (e) {
        $(".bcl-build-order-by-check").removeClass("active");
        $(this).addClass("active");
        var data_check = $(this).closest("#bcl-build-filter").find('input[name="send_data_check"]').val(), data_slug = $(this).closest("#bcl-build-filter").attr("data-slug"), data_order = $(this).attr("data-orderby"), data_key = $(this).closest("#bcl-build-filter").find("#bcl_search").val();
        $.ajax({method: "POST", url: data_bcl_builder.ajaxurl, data: {action: "bcl_build_filter", data_check: data_check, slug: data_slug, orderby: data_order, search_keyword: data_key}, beforeSend: function () {
                $(".bcl-item--wrap .bcl-item--query").css("opacity", "0");
                $(".bcl-scroll--item").append('<div class="bcl-spinner--ajax"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>');
            }, success: function (response) {
                add_bcl_muti();
                $(".bcl-item--wrap .bcl-item--query").css("opacity", "1");
                $(".bcl-item--wrap").html(response);
                leahnna != "" && $(".bcl-item--wrap .bcl-item--title_search a").iSuresBoldText({tag: "strong", words: [data_key]});
            }});
        e.preventDefault();
    });


    //Search Product
    var madine = null;
    $("body").on("keyup", "#bcl_search", function (e) {
        var data_check = $(this).closest("#bcl-search--item_wrap").find('input[name="send_data_check"]').val(), data_slug = $(this).closest("#bcl-search--item_wrap").find(".bcl-item--wrap").attr("data-slug"), data_order = $(".active.bcl-build-order-by-check").attr("data-orderby");
        madine != null && clearTimeout(madine);
        var data_key = $("#bcl_search").val();
        madine = setTimeout(function () {
            madine = null;
            $.ajax({method: "POST", url: data_bcl_builder.ajaxurl, data: {action: "bcl_build_filter", search_keyword: data_key, data_check: data_check, slug: data_slug, orderby: data_order}, beforeSend: function () {
                    $(".bcl-item--wrap .bcl-item--query").css("opacity", "0");
                    $(".bcl-scroll--item").append('<div class="bcl-spinner--ajax"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>');
                }, success: function (response) {
                    add_bcl_muti();
                    $(".bcl-item--wrap").html(response);
                    data_key != "" && $(".bcl-item--wrap .bcl-item--title_search a").iSuresBoldText({tag: "strong", words: [data_key]});
                    $(".bcl-item--wrap .bcl-item--query").css("opacity", "1");
                }});
        }, 400);
        e.preventDefault();
    });




    //Tắt popup
    $("body").on("click", ".bcl-close--lightbox", function (e) {
        $.magnificPopup.close();
        e.preventDefault();
    });








    //Tạo đơn hoặc hợp đồng
    $("body").on('click','.bcl-atc--chosen_bpc',function(e){
        if (data_bcl_builder.token_page === url_page) {
            var name_customer = $('input[name="name_customer"]').val(),
                phone_customer = $('input[name="phone_customer"]').val(),
                email_customer = $('input[name="email_customer"]').val(),
                contract_type = $('input[name="contract_type"]:checked').val(),
                address_customer = $('input[name="address_customer"]').val(),
                name_user = $('input[name="name_user"]').val(),
                phone_user = $('input[name="phone_user"]').val(),
                type_print = $('#type_print').val(),
                discount = $('input[name="discount"]').val(),
                source_customer = $('#source_customer').val(),
                id_user = $('input[name="id_user"]').val();


            if (name_customer == '' || phone_customer == '' || source_customer == '') {
                ovianna('Bạn vẫn chưa điền đầy đủ thông tin', 'faild')
            } else {

                var bcl_id = $("#bcl-wrap span.active").data("build-bcl"), objec_satary = new BuildSatary(bcl_id),
                    config_bcl_satary = objec_satary.getConfig();
                $.ajax({
                    type: 'POST',
                    url: data_bcl_builder.ajaxurl,
                    data: {
                        action: 'create_order_bcl',
                        name_customer: name_customer,
                        phone_customer: phone_customer,
                        email_customer: email_customer,
                        contract_type: contract_type,
                        address_customer: address_customer,
                        type_print: type_print,
                        id_user: id_user,
                        chosen_id: JSON.stringify(config_bcl_satary),
                        phone_user: phone_user,
                        name_user: name_user,
                        discount: discount,
                        source_customer: source_customer
                    },
                    beforeSend: function (e) {
                        $("body").append('<div class="bcl-spinner--wrap"><div class="bcl-spinner--ajax"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>');
                    },
                    success: function (res) {
                        $(".bcl-spinner--wrap").remove();
                        if (res.success) {
                            ovianna(res.data.message, 'success');
                            if (type_print == 'pdf' && contract_type == 1) {

                                var iframe = document.createElement('iframe');
                                iframe.id = 'print_frame';
                                document.body.appendChild(iframe);
                                var frameDoc = iframe.contentWindow ? iframe.contentWindow : iframe.contentDocument.document ? iframe.contentDocument.document : iframe.contentDocument;
                                frameDoc.document.open();
                                frameDoc.document.write("</head><body>");
                                frameDoc.document.body.style.cssText = "font-family: 'Times New Roman'!important;";
                                frameDoc.document.write(res.data.table);
                                frameDoc.document.close();
                                setTimeout(function () {
                                    var printFrame = document.getElementById("print_frame");
                                    printFrame.contentWindow.print();

                                    // Xoá iframe sau khi in
                                    setTimeout(function () {
                                        document.body.removeChild(iframe);
                                    }, 1000);
                                }, 1000);
                            }

                            if (type_print == 'excel' && contract_type == 1) {
                                var linkSource = res.data.pathfile;
                                var downloadLink = document.createElement("a");
                                var fileName = res.data.filename;

                                downloadLink.href = linkSource;
                                downloadLink.download = fileName;
                                downloadLink.click();
                            }

                        } else {
                            ovianna('Đơn hàng không thể lưu, hãy liên hệ với admin để được giải đáp!!!', 'faild');
                        }
                    }
                });
            }
        } else {
            alert('Plugin của bạn chưa kích hoạt bản quyền. Hãy kích hoạt để sử dụng Plugin');
        }
        e.preventDefault();
    });



    //Ẩn hiện kiểu in báo giá.
    $("body").on('change','input[name="contract_type"]',function(){
        var data_type = $(this).val();
        data_type == 1 ? ($('#type_print').slideToggle("fast")) : ($('#type_print').hide());
    });







    function nichole(bcl_id, status = null) {
        var objec_satary = new BuildSatary(bcl_id), config_bcl_satary = objec_satary.getConfig();
        config_bcl_satary && Object.keys(config_bcl_satary).length > 0 ? $.ajax({method: "POST", url: data_bcl_builder.ajaxurl, data: {action: "bcl_push_build", chosen_id: JSON.stringify(config_bcl_satary)}, beforeSend: function () {
                status == true && $("body").append('<div class="bcl-spinner--wrap"><div class="bcl-spinner--ajax"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>');
            }, dataType: 'json',
            success: function (denim) {
                console.log(denim);
                denim && $.each(denim, function (key, data) {
                    $('.bcl-build-sanitary-all-item[data-category-id="' + data.category_id + '"] .item-bcl-build').html(data.html);
                    $('.bcl-build-sanitary--item[data-category-id="' + data.category_id + '"]').attr("data-chosen", data.product_id);
                    $('.bcl-build-sanitary--item[data-category-id="' + data.category_id + '"]').attr("data-qty", data.quantity);
                    $('.bcl-build-sanitary--item[data-category-id="' + data.category_id + '"]').find(".bcl-build--qty").val() > 1 ? ($('.bcl-build-sanitary--item[data-category-id="' + data.category_id + '"]').find(".bcl-buildrm--item_chosen").hide(), $('.bcl-build-sanitary--item[data-category-id="' + data.category_id + '"]').find(".bcl-minus").show()) : ($('.bcl-build-sanitary--item[data-category-id="' + data.category_id + '"]').find(".bcl-minus").hide(),$('.bcl-build-sanitary--item[data-category-id="' + data.category_id + '"]').find(".bcl-buildrm--item_chosen").show());
                });
                isable();
                status == true && $(".bcl-spinner--wrap").remove();
            }}) : isable();
    }


    function count_variable() {
        $(".bcl-build-get_pa").each(function () {
            $(this).find('input[name="bcl_build_multi_check"]:checked').length > 0 ? ($(this).find(".bcl-param--title").addClass("active"), $(this).find(".bcl-param--title span").attr("data-label", $(this).find('input[name="bcl_build_multi_check"]:checked').length)) : ($(this).find(".bcl-param--title").removeClass("active"), $(this).find(".bcl-param--title span").removeAttr("data-label"));
        });
    }

    function add_bcl_muti() {
        var pinchus = new Array;
        $('input[name="bcl_build_multi_check"]:checked').each(function () {
            pinchus.push($(this).val() + "@" + $(this).closest(".bcl-build-get_pa").attr("data-pa"));
        });
        pinchus.length > 0 ? $('input[name="send_data_check"]').val(pinchus.join(",")) : $('input[name="send_data_check"]').val("");
    }


    function cordin(vivaansh) {
        var alexnadra = "", raees = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789".length;
        for (var zaya = 0; zaya < vivaansh; zaya++) {
            alexnadra += "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789".charAt(Math.floor(Math.random() * raees));
        }
        return alexnadra;
    }

    function tayyib(nattalie, jarmaris) {

        var merrilu = jarmaris;
        for (var jeilany in nattalie) {
            nattalie.hasOwnProperty(jeilany) && (merrilu = merrilu.replace(new RegExp( jeilany.replace(/_/g, '-'), "g"), jeilany.replace(/_/g, '-') + '=' + nattalie[jeilany]));
        }
        return merrilu;
    }





    function isable() {
        var azaira = rekiya();
        azaira.total_value === 0 ? ($(".bcl-details--chosen_wrap").hide(),$(".bcl-empty--chosen").show(),$('.info-customer').hide()) : ($(".bcl-details--chosen_wrap").show(), $(".bcl-empty--chosen").hide(),$('.info-customer').show(), $(".bcl-price--wrap").html(lanora(azaira.total_value)));
    }
    function rekiya() {
        var config_bcl = $("#bcl-wrap span.active").data("build-bcl"), object_bcl = new BuildSatary(config_bcl), config = object_bcl.getConfig(), kiarie = 0, adrielys = 0, jacarious = 0, emar;
        for (var johnda in config) {
            console.log(johnda);
            if (config.hasOwnProperty(johnda)) {
                for ( var id_product in config[johnda].items) {
                    emar = config[johnda].items[id_product];
                    kiarie += emar.price * emar.quantity;
                    adrielys += emar.quantity;
                    jacarious += 1;
                }
            }
            // config.hasOwnProperty(johnda) && (emar = config[johnda].items[0], kiarie += emar.price * emar.quantity, adrielys += emar.quantity, jacarious += 1);
        }
        return {total_value: kiarie, total_quantity: adrielys, total_item: jacarious};
    }

    function lanora(herica) {
        if (!isNaN(herica)) {
            var fridda = herica.toString().replace(data_bcl_builder.currency_symbol, ""), eshell = false, jathziry = [], elbia = 1, tianca = null;
            fridda.indexOf(".") > 0 && (eshell = fridda.split("."), fridda = eshell[0]);
            fridda = fridda.split("").reverse();
            for (var bogdan = 0, astride = fridda.length; bogdan < astride; bogdan++) {
                fridda[bogdan] != "." && (jathziry.push(fridda[bogdan]), elbia % 3 == 0 && bogdan < astride - 1 && jathziry.push("."), elbia++);
            }
            return tianca = jathziry.reverse().join(""), tianca + (eshell ? "." + eshell[1].substr(0, 2) : "") + data_bcl_builder.currency_symbol;
        }
    }

    //Thông báo
    function ovianna(description, status) {
        var analuz = status == "success" ? "bcl-action--success" : "bcl-action--ops";
        $("body").append('<div id="bcl-build--alert_popup" class="five"><div class="bcl-build--popup_bg"><div class="bcl-build--popup_inner ' + analuz + '">' + description + "</div></div></div>");
        $("#bcl-build--alert_popup").addClass("active");
        setTimeout(function () {
            $("#bcl-build--alert_popup").removeClass("active");
            $("#bcl-build--alert_popup").remove();
        }, 2e3);
    }

});