jQuery(document).ready(function ($) {
    let jahmaree = $("#isures-config--number_wrap span.active").data("buildpc");
    jahmaree && nichole(jahmaree);
    $.fn.iSuresBoldText = function (nyx) {
        var ricko = nyx.tag || "strong", zaymar = nyx.words || [], tarance = RegExp(zaymar.join("|"), "gi"), decoda = "<" + ricko + ">$&</" + ricko + ">";
        return this.html(function () {
            return $(this).text().replace(tarance, decoda);
        });
    };
    function zamaira() {
        var pinchus = new Array;
        $('input[name="buildpc_multi_check"]:checked').each(function () {
            pinchus.push($(this).val() + "@" + $(this).closest(".isures-buildpc-get_pa").attr("data-pa"));
        });
        pinchus.length > 0 ? $('input[name="send_data_check"]').val(pinchus.join(",")) : $('input[name="send_data_check"]').val("");
    }
    $("body").on("change", 'input[name="buildpc_multi_check"]', function () {
        var mirta = new Array;
        $('input[name="buildpc_multi_check"]:checked').each(function () {
            let michelleann = $(this).closest("label").attr("data-id");
            mirta.push('<a class="remove-multi" data-id="' + michelleann + '">' + $(this).val() + '<svg style="display: inline-block;" width="10" height="10" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg"><line fill="none" stroke="#8392a5" stroke-width="2" x1="2" y1="2" x2="13" y2="13"></line><line fill="none" stroke="#8392a5" stroke-width="2" x1="13" y1="2" x2="2" y2="13"></line></svg></a>');
        });
        mirta.length > 0 ? ($(".buildpc-chosenfilter").html(mirta.join("")), $(".isures-choosed--label").show()) : ($(".buildpc-chosenfilter").html(""), $(".isures-choosed--label").hide());
        $(this).prop("checked") ? $(this).closest("label").addClass("active") : $(this).closest("label").removeClass("active");
        quaniece();
        zamaira();
        var hansini = $(this).closest("#isures-buildpc-filter").find('input[name="send_data_check"]').val(), sagrario = $(this).closest("#isures-buildpc-filter").attr("data-slug"), teniesha = $(".active.buildpc-order-by-check").attr("data-orderby"), leontine = $(this).closest("#isures-buildpc-filter").find("#isures_search").val();
        $.ajax({method: "POST", url: isures_buildpc_vars.ajaxurl, data: {action: "buildpc_filter", data_check: hansini, slug: sagrario, orderby: teniesha, search_keyword: leontine}, beforeSend: function (emberlei) {
                $(".isures-item--wrap .isures-item--query").css("opacity", "0");
                $(".isures-scroll--item").append('<div class="isures-spinner--ajax"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>');
            }, success: function (asim) {
                zamaira();
                $(".isures-item--wrap").html(asim);
                leontine != "" && $(".isures-item--wrap .isures-item--title_search a").iSuresBoldText({tag: "strong", words: [leontine]});
                $(".isures-scroll--item .sures-spinner--ajax").remove();
                $(".isures-item--wrap .isures-item--query").css("opacity", "1");
            }});
    });
    $("body").on("click", ".remove-multi", function (kyllie) {
        var krisina = $(this).attr("data-id");
        $('label[data-id="' + krisina + '"]').removeClass("active");
        $('label[data-id="' + krisina + '"]').trigger("click");
        kyllie.preventDefault();
    });
    $("body").on("click", ".buildpc-order-by-check", function (zacarri) {
        $(".buildpc-order-by-check").removeClass("active");
        $(this).addClass("active");
        var vasti = $(this).closest("#isures-buildpc-filter").find('input[name="send_data_check"]').val(), jaela = $(this).closest("#isures-buildpc-filter").attr("data-slug"), shanaja = $(this).attr("data-orderby"), leahnna = $(this).closest("#isures-buildpc-filter").find("#isures_search").val();
        $.ajax({method: "POST", url: isures_buildpc_vars.ajaxurl, data: {action: "buildpc_filter", data_check: vasti, slug: jaela, orderby: shanaja, search_keyword: leahnna}, beforeSend: function (rustie) {
                $(".isures-item--wrap .isures-item--query").css("opacity", "0");
                $(".isures-scroll--item").append('<div class="isures-spinner--ajax"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>');
            }, success: function (leeya) {
                zamaira();
                $(".isures-item--wrap .isures-item--query").css("opacity", "1");
                $(".isures-item--wrap").html(leeya);
                leahnna != "" && $(".isures-item--wrap .isures-item--title_search a").iSuresBoldText({tag: "strong", words: [leahnna]});
            }});
        zacarri.preventDefault();
    });
    $("body").on("click", ".isures-param--title", function (rhiane) {
        $(".isures-param--title:not(this)").closest(".isures-buildpc-get_pa").find(".isures-buildpc--param_wrap").slideUp("fast");
        $(this).closest(".isures-buildpc-get_pa").find(".isures-buildpc--param_wrap").stop().slideToggle("fast");
        rhiane.stopPropagation();
    });
    $("body").on("click", ".isures-buildpc--param_wrap .close", function (ticara) {
        $(this).closest(".isures-buildpc--param_wrap").slideUp("fast");
        ticara.stopPropagation();
    });
    $("body").on("click", ".isures-buildpc--param_wrap", function (nessie) {
        nessie.stopPropagation();
    });
    $(document).click(function () {
        $(".isures-buildpc--param_wrap").slideUp("fast");
        $(".isures-download--wrap_inner").slideUp("fast");
    });
    function quaniece() {
        $(".isures-buildpc-get_pa").each(function () {
            $(this).find('input[name="buildpc_multi_check"]:checked').length > 0 ? ($(this).find(".isures-param--title").addClass("active"), $(this).find(".isures-param--title span").attr("data-label", $(this).find('input[name="buildpc_multi_check"]:checked').length)) : ($(this).find(".isures-param--title").removeClass("active"), $(this).find(".isures-param--title span").removeAttr("data-label"));
        });
    }
    $("body").on("click", ".isures-select--item", function (ayahna) {
        var chanin = $(this).closest(".isures-item--tax").data("tax-id");
        $.ajax({method: "POST", url: isures_buildpc_vars.ajaxurl, data: {action: "isures_buildpc_prod_by_tax", id_tax: chanin}, beforeSend: function (breanca) {
                $("body").append('<div class="isures-spinner--wrap"><div class="isures-spinner--ajax"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>');
            }, success: function (shayma) {
                $(".isures-spinner--wrap").remove();
                $.magnificPopup.open({items: {src: '<div id="isures-search--item_wrap" class="lightbox-content lightbox-white"></div>'}, type: "inline", mainClass: "isures-popup--search", removalDelay: 260});
                $("#isures-search--item_wrap").html(shayma).attr("cat_id", chanin);
                $(shayma).find(".isures-empty--prod").length == "1" && $(".isbuildpc-empty--filter").remove();
            }});
        ayahna.preventDefault();
    });
    $("body").on("click", ".isures-close--lightbox", function (embri) {
        $.magnificPopup.close();
        embri.preventDefault();
    });
    $("body").on("click", "#isures-config--number_wrap span", function (markees) {
        $("#isures-config--number_wrap span").not(this).removeClass("active");
        !$(this).hasClass("active") && ($(this).stop().toggleClass("active"), nichole($(this).data("buildpc"), true), $(".isures-item--tax").each(function () {
            $html = tayyib({data_id: $(this).data("tax-id"), image_src: $(this).data("image_src")}, isures_buildpc_vars.templete_empty);
            $(this).find(".isures-wrap--loaded").html($html);
        }));
        markees.preventDefault();
    });
    $("body").on("click", ".isures-item--choose_search", function (radoika) {
        var shali = $("#isures-config--number_wrap span.active").data("buildpc"), aaminah = new buildpc(shali), vivyan = $(this).data("qty"), colinda = $(this).closest("#isures-search--item_wrap").attr("cat_id"), ahlea = $(this).data("id"), voight = $(this).data("price");
        $.ajax({method: "POST", url: isures_buildpc_vars.ajaxurl, data: {action: "isures_buildpc_select_product", chosen_id: ahlea}, beforeSend: function (tamatoa) {
                aaminah.emptyCategory(colinda);
            }, success: function (hinson) {
                $('.isures-item--tax[data-tax-id="' + colinda + '"] .isures-wrap--loaded').html(hinson);
                $('.isures-item--tax[data-tax-id="' + colinda + '"]').attr("data-chosen", ahlea);
                $('.isures-item--tax[data-tax-id="' + colinda + '"]').attr("data-qty", vivyan);
                $('.isures-item--tax[data-tax-id="' + colinda + '"]').find(".isures-minus").hide();
                var macgyver = {product_id: ahlea, quantity: vivyan, price: voight};
                aaminah.selectItem({id: colinda}, macgyver);
                Cookies.set("isures_buildpc_selected_" + shali, aaminah, {expires: 7, path: ""});
                isable();
            }});
        $.magnificPopup.close();
        radoika.preventDefault();
    });
    $("body").on("click", ".isures-buildpcrm--item_chosen", function (amilliano) {
        var shanya = $("#isures-config--number_wrap span.active").data("buildpc"), antoniya = new buildpc(shanya), harvin = $(this).closest(".isures-item--tax").data("tax-id"), cariah = $(this).closest(".isures-item--tax").data("id");
        antoniya.removeItem(harvin, cariah);
        Cookies.set("isures_buildpc_selected_" + shanya, antoniya, {expires: 7, path: ""});
        $html = tayyib({data_id: $(this).closest(".isures-item--tax").data("tax-id"), image_src: $(this).closest(".isures-item--tax").data("image_src")}, isures_buildpc_vars.templete_empty);
        $(this).closest(".isures-item--tax").find(".isures-wrap--loaded").html($html);
        isable();
        amilliano.preventDefault();
    });
    $("body").on("click", ".isures-ac--buildpc_rebuild", function (lakyra) {
        $(".isures-item--tax").each(function () {
            $html = tayyib({data_id: $(this).data("tax-id"), image_src: $(this).data("image_src")}, isures_buildpc_vars.templete_empty);
            $(this).find(".isures-wrap--loaded").html($html);
        });
        var aliza = $("#isures-config--number_wrap span.active").data("buildpc"), fiana = new buildpc(aliza);
        fiana.emptyConfig();
        Cookies.set("isures_buildpc_selected_" + aliza, "", {expires: 1, path: ""});
        isable();
        lakyra.preventDefault();
    });
    $("body").on("click", "#isures-search--item_wrap .nav-pagination a", function (catosha) {
        var naiomi = $(this).closest("#isures-search--item_wrap").find('input[name="send_data_check"]').val(), yolaine = $(this).closest("#isures-search--item_wrap").find(".isures-item--wrap").attr("data-slug"), teale = $(".active.buildpc-order-by-check").attr("data-orderby"), jehad = $(this).attr("href"), ezmia = jehad.split("/"), brinton = ezmia[ezmia.length - 2], sinnamon = $("#isures_search").val();
        $.ajax({method: "POST", url: isures_buildpc_vars.ajaxurl, data: {action: "buildpc_filter", data_check: naiomi, slug: yolaine, orderby: teale, search_keyword: sinnamon, page: brinton}, beforeSend: function (anselma) {
                $(".isures-item--wrap .isures-item--query").css("opacity", "0");
                $(".isures-scroll--item").append('<div class="isures-spinner--ajax"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>');
            }, success: function (criag) {
                zamaira();
                $(".isures-item--wrap").html(criag);
                sinnamon != "" && $(".isures-item--wrap .isures-item--title_search a").iSuresBoldText({tag: "strong", words: [sinnamon]});
                $(".isures-item--wrap .isures-item--query").css("opacity", "1");
            }});
        catosha.preventDefault();
    });
    dashanda();
    function dashanda() {
        $("body").on("change keyup", ".isures-buildpc--qty", function () {
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
                $(this).closest(".isures-wrap--quantity").find("input.isures-buildpc--qty").attr("value", hafford);
                $(this).closest(".isures-wrap--quantity").find("input.isures-buildpc--qty").val(hafford);
                $(this).closest(".isures-item--tax").attr("data-qty", hafford);
            }
            if (jamus !== null) {
                $(this).closest(".isures-wrap--quantity").find("input.isures-buildpc--qty").attr("value", jamus);
                $(this).closest(".isures-item--tax").attr("data-qty", jamus);
                jamus > 1 ? ($(this).closest(".isures-wrap--quantity").find(".isures-buildpcrm--item_chosen").hide(), $(this).closest(".isures-wrap--quantity").find(".isures-minus").show()) : ($(this).closest(".isures-wrap--quantity").find(".isures-minus").hide(), $(this).closest(".isures-wrap--quantity").find(".isures-buildpcrm--item_chosen").show());
                jamus == 0 && $(this).closest(".isures-wrap--quantity").find(".isures-buildpcrm--item_chosen").trigger("click");
                var nevaya = $("#isures-config--number_wrap span.active").data("buildpc"), abbigal = new buildpc(nevaya), cecily = $(this).closest(".isures-item--tax").data("tax-id"), shamario = $(this).closest(".isures-item--tax").find(".isures-item--query").data("chosen");
                abbigal.updateItem(cecily, shamario, "quantity", jamus);
                Cookies.set("isures_buildpc_selected_" + nevaya, abbigal, {expires: 7, path: ""});
                isable();
            }
        });
        $("body").on("click", ".isures-plus", function () {
            var isatou = $(this).closest(".isures-wrap--quantity").find("input.isures-buildpc--qty").val(), yedaiah = $(this).closest(".isures-wrap--quantity").find("input.isures-buildpc--qty").attr("max");
            if (yedaiah) {
                var etheline = $(this).closest(".isures-wrap--quantity").find("input.isures-buildpc--qty").attr("max");
            } else {
                var etheline = 1e6;
            }
            if (parseInt(etheline) > isatou) {
                var emiliah = parseInt(isatou) + parseInt($(this).closest(".isures-wrap--quantity").find("input.isures-buildpc--qty").attr("step"));
                $(this).closest(".isures-wrap--quantity").find("input.isures-buildpc--qty").val(emiliah).trigger("change");
                $(this).closest(".isures-item--tax").attr("data-qty", emiliah);
            }
        });
        $("body").on("click", ".isures-minus", function () {
            var nyir = $(this).closest(".isures-wrap--quantity").find("input.isures-buildpc--qty").val(), aaronette = parseInt(nyir) - parseInt($(this).closest(".isures-wrap--quantity").find("input.isures-buildpc--qty").attr("step"));
            $(this).closest(".isures-wrap--quantity").find("input.isures-buildpc--qty").val(aaronette).trigger("change");
            $(this).closest(".isures-item--tax").attr("data-qty", aaronette);
        });
    }
    function nichole(jenevi, _0x12aae9 = null) {
        var jammar = new buildpc(jenevi), romya = jammar.getConfig();
        romya && Object.keys(romya).length > 0 ? $.ajax({method: "POST", url: isures_buildpc_vars.ajaxurl, data: {action: "isures_push_buildpc", chosen_id: JSON.stringify(romya)}, beforeSend: function () {
                _0x12aae9 == true && $("body").append('<div class="isures-spinner--wrap"><div class="isures-spinner--ajax"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>');
            }, dataType: "JSON", success: function (denim) {
                denim && $.each(denim, function (sirkyng, jeselle) {
                    $('.isures-item--tax[data-tax-id="' + jeselle.category_id + '"] .isures-wrap--loaded').html(jeselle.html);
                    $('.isures-item--tax[data-tax-id="' + jeselle.category_id + '"]').attr("data-chosen", jeselle.product_id);
                    $('.isures-item--tax[data-tax-id="' + jeselle.category_id + '"]').attr("data-qty", jeselle.quantity);
                    $('.isures-item--tax[data-tax-id="' + jeselle.category_id + '"]').find(".isures-buildpc--qty").val() > 1 ? $('.isures-item--tax[data-tax-id="' + jeselle.category_id + '"]').find(".isures-buildpcrm--item_chosen").hide() : $('.isures-item--tax[data-tax-id="' + jeselle.category_id + '"]').find(".isures-minus").hide();
                });
                isable();
                _0x12aae9 == true && $(".isures-spinner--wrap").remove();
            }}) : isable();
    }
    function tayyib(id_category, img_src) {
        var merrilu = img_src;
        for (var jeilany in id_category) {
            id_category.hasOwnProperty(jeilany) && (merrilu = merrilu.replace(new RegExp("{{" + jeilany + "}}", "g"), id_category[jeilany]));
        }
        return merrilu;
    }
    function isable() {
        var azaira = rekiya();
        azaira.total_value === 0 ? ($(".isures-details--chosen_wrap").hide(), $(".isures-empty--chosen").show()) : ($(".isures-details--chosen_wrap").show(), $(".isures-empty--chosen").hide(), $(".isures-price--wrap").html(lanora(azaira.total_value)));
    }
    function rekiya() {
        var odessie = $("#isures-config--number_wrap span.active").data("buildpc"), tahnia = new buildpc(odessie), tianna = tahnia.getConfig(), kiarie = 0, adrielys = 0, jacarious = 0, emar;
        for (var johnda in tianna) {
            tianna.hasOwnProperty(johnda) && (emar = tianna[johnda].items[0], kiarie += emar.price * emar.quantity, adrielys += emar.quantity, jacarious += 1);
        }
        return {total_value: kiarie, total_quantity: adrielys, total_item: jacarious};
    }
    function lanora(herica) {
        if (!isNaN(herica)) {
            var fridda = herica.toString().replace(isures_buildpc_vars.currency_symbol, ""), eshell = false, jathziry = [], elbia = 1, tianca = null;
            fridda.indexOf(".") > 0 && (eshell = fridda.split("."), fridda = eshell[0]);
            fridda = fridda.split("").reverse();
            for (var bogdan = 0, astride = fridda.length; bogdan < astride; bogdan++) {
                fridda[bogdan] != "." && (jathziry.push(fridda[bogdan]), elbia % 3 == 0 && bogdan < astride - 1 && jathziry.push("."), elbia++);
            }
            return tianca = jathziry.reverse().join(""), tianca + (eshell ? "." + eshell[1].substr(0, 2) : "") + isures_buildpc_vars.currency_symbol;
        }
    }
    $("body").on("click", ".isures-atc--chosen_bpc", function (marvalyn) {
        var fadilah = $("#isures-config--number_wrap span.active").data("buildpc"), lucretia = new buildpc(fadilah), aaliyiah = lucretia.getConfig();
        aaliyiah && Object.keys(aaliyiah).length > 0 && $.ajax({method: "POST", url: isures_buildpc_vars.ajaxurl, data: {action: "isures_ajax_multi_prod", data: JSON.stringify(aaliyiah)}, dataType: "JSON", beforeSend: function (taissa) {
                $("body").append('<div class="isures-spinner--wrap"><div class="isures-spinner--ajax"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>');
            }, success: function (gloristeen) {
                $(".isures-spinner--wrap").remove();
                $("body").trigger("wc_fragment_refresh");
                ovianna(isures_buildpc_vars.added_to_cart_text, "success");
            }});
        marvalyn.preventDefault();
    });
    function ovianna(fathima, nath) {
        var analuz = nath == "success" ? "isures-action--success" : "isures-action--ops";
        $("body").append('<div id="isures-buildpc--alert_popup" class="five"><div class="isures-buildpc--popup_bg"><div class="isures-buildpc--popup_inner ' + analuz + '">' + fathima + "</div></div></div>");
        $("#isures-buildpc--alert_popup").addClass("active");
        setTimeout(function () {
            $("#isures-buildpc--alert_popup").removeClass("active");
            $("#isures-buildpc--alert_popup").remove();
        }, 2e3);
    }
    $("body").on("click", ".isures-download--conf", function (finest) {
        var ahmod = $("#isures-config--number_wrap span.active").data("buildpc"), hewey = new buildpc(ahmod), axen = hewey.getConfig(), kalahikiola = $(this).data("export_name"), aleida = $('input[name="buildpc_for_seller"]').val() ? $('input[name="buildpc_for_seller"]').val() : 0;
        if (axen && Object.keys(axen).length == 0) {
            return ovianna(isures_buildpc_vars.text_empty_item_config, "false"), false;
        }
        if (isures_buildpc_vars.enable_watermark == true && aleida == 0) {
            if (isures_buildpc_vars.type_watermark == "type_image") {
                var inderjit = '<div class="isures-buildpc--water_mark type_image" style="background-image: url(' + isures_buildpc_vars.logo_print[0] + ')"></div>';
            } else {
                if (isures_buildpc_vars.type_watermark == "type_text") {
                    var inderjit = '<div class="isures-buildpc--water_mark type_text" data-text="' + isures_buildpc_vars.text_watermark + '"></div>';
                }
            }
        } else {
            var inderjit = "";
        }
        axen && Object.keys(axen).length > 0 && kalahikiola != "excel" && $.ajax({type: "POST", url: isures_buildpc_vars.ajaxurl, data: {action: "buildpc_download_config", ids: JSON.stringify(axen), export_type: kalahikiola, seller_mode: aleida}, dataType: "JSON", beforeSend: function (iyahna) {
                $("body").append('<div class="isures-spinner--wrap"><div class="isures-spinner--ajax"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>');
            }, success: function (gedalia) {
                if (gedalia.success == true) {
                    if (kalahikiola === "pdf") {
                        var estevan = $("<iframe />");
                        estevan[0].name = "isures_dom_buildpc";
                        estevan.css({position: "absolute", top: "-1000000px"});
                        $("body").append(estevan);
                        var taneicia = estevan[0].contentWindow ? estevan[0].contentWindow : estevan[0].contentDocument.document ? estevan[0].contentDocument.document : estevan[0].contentDocument;
                        taneicia.document.open();
                        taneicia.document.write("</head><body>");
                        taneicia.document.body.style.cssText = "font-family: 'Times New Roman'!important;";
                        taneicia.document.write('<link href="' + isures_buildpc_vars.plugin_uri + '" rel="stylesheet" type="text/css" />');
                        taneicia.document.write(inderjit + gedalia.table);
                        taneicia.document.write("</body></html>");
                        taneicia.document.close();
                        setTimeout(function () {
                            window.frames.isures_dom_buildpc.focus();
                            window.frames.isures_dom_buildpc.print();
                            estevan.remove();
                        }, 200);
                    }
                    if (kalahikiola === "image") {
                        $(".isures-image--print_wrap").html(inderjit + gedalia.table);
                        var alphe = "download-config-" + cordin(5), kaneka = document.querySelector("#buildpc_capture");
                        document.querySelector("#buildpc_capture").style.padding = "15px";
                        html2canvas(kaneka, {allowTaint: true, useCORS: true, width: kaneka.scrollWidth, height: $("#buildpc_capture").outerHeight() + 50, scrollX: -window.scrollX, scrollY: -window.scrollY}).then(zeon => {
                            link = document.createElement("a");
                            link.download = alphe;
                            link.href = zeon.toDataURL();
                            link.click();
                        });
                        document.querySelector("#buildpc_capture").style.padding = "0";
                        $(".isures-image--print_wrap").html("");
                    }
                }
                $(".isures-spinner--wrap").remove();
            }});
        finest.preventDefault();
    });
    function cordin(vivaansh) {
        var alexnadra = "", raees = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789".length;
        for (var zaya = 0; zaya < vivaansh; zaya++) {
            alexnadra += "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789".charAt(Math.floor(Math.random() * raees));
        }
        return alexnadra;
    }
    $("body").on("click", ".isures-btn--label_down", function (brookleigh) {
        $(this).closest(".isures-download--wrap").find(".isures-download--wrap_inner").stop().slideToggle("fast");
        brookleigh.stopPropagation();
    });
    var madine = null;
    $("body").on("keyup", "#isures_search", function (joiya) {
        var airelle = $(this).closest("#isures-search--item_wrap").find('input[name="send_data_check"]').val(), cario = $(this).closest("#isures-search--item_wrap").find(".isures-item--wrap").attr("data-slug"), teray = $(".active.buildpc-order-by-check").attr("data-orderby");
        madine != null && clearTimeout(madine);
        var vassie = $("#isures_search").val();
        madine = setTimeout(function () {
            madine = null;
            $.ajax({method: "POST", url: isures_buildpc_vars.ajaxurl, data: {action: "buildpc_filter", search_keyword: vassie, data_check: airelle, slug: cario, orderby: teray}, beforeSend: function (xyliana) {
                    $(".isures-item--wrap .isures-item--query").css("opacity", "0");
                    $(".isures-scroll--item").append('<div class="isures-spinner--ajax"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>');
                }, success: function (romonia) {
                    zamaira();
                    $(".isures-item--wrap").html(romonia);
                    vassie != "" && $(".isures-item--wrap .isures-item--title_search a").iSuresBoldText({tag: "strong", words: [vassie]});
                    $(".isures-item--wrap .isures-item--query").css("opacity", "1");
                }});
        }, 400);
        joiya.preventDefault();
    });
    $("body").on("click", ".isures-seller--save_info", function (rethel) {
        var torri = tinymce.get("seller_header_info").getContent(), shameah = tinymce.get("seller_footer_info").getContent();
        $("#seller_header_info").html(torri);
        $("#seller_footer_info").html(shameah);
        var farhia = $("#seller_header_info").val(), tranyah = $("#seller_footer_info").val();
        $.ajax({method: "POST", url: isures_buildpc_vars.ajaxurl, data: {action: "buildpc_update_info_seller", header_info: farhia, footer_info: tranyah}, beforeSend: function (beverly) {
                $("body").append('<div class="isures-spinner--wrap"><div class="isures-spinner--ajax"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>');
            }, success: function (olida) {
                $(".isures-spinner--wrap").remove();
            }});
        rethel.preventDefault();
    });
    $("body").on("click", ".isures-preview--print,.isures-download--excel", function (kemani) {
        var sheenia = $('input[name="buildpc_for_seller"]').val() ? $('input[name="buildpc_for_seller"]').val() : 0, sereniti = $("#isures-config--number_wrap span.active").data("buildpc"), onnie = new buildpc(sereniti), laurianna = onnie.getConfig();
        if (laurianna && Object.keys(laurianna).length > 0) {
            var dakeria = [];
            $.each(laurianna, function (umoja, vinell) {
                dakeria.push(vinell.items[0].product_id + "/" + vinell.items[0].quantity);
            });
            if ($(this).hasClass("isures-preview--print")) {
                var makalea = "html";
            } else {
                if ($(this).hasClass("isures-download--excel")) {
                    var makalea = "excel";
                }
            }
            if (!isures_buildpc_vars.buildpc_url || isures_buildpc_vars.buildpc_url == "") {
                var mozetta = window.location.origin + window.location.pathname;
            } else {
                var mozetta = isures_buildpc_vars.buildpc_url;
            }
            const lonniel = mozetta + "export_download";
            $("body").append('<form id="isures_buildpc_preview" method="post" action="' + lonniel + '"></form>');
            $("<input>").attr({type: "text", id: "content_type", name: "content_type", value: sereniti}).appendTo("form#isures_buildpc_preview");
            $("<input>").attr({type: "text", id: "buildpc_for_seller", name: "buildpc_for_seller", value: sheenia}).appendTo("form#isures_buildpc_preview");
            $("<input>").attr({type: "text", id: "data", name: "data", value: dakeria.join(",")}).appendTo("form#isures_buildpc_preview");
            $("<input>").attr({type: "text", id: "file_type", name: "file_type", value: makalea}).appendTo("form#isures_buildpc_preview");
            $("<input>").attr({type: "submit", id: "isures_buildpc_preview_submit", name: "isures_buildpc_preview_submit", value: true}).appendTo("form#isures_buildpc_preview");
            $("#isures_buildpc_preview_submit").trigger("click");
            $("#isures_buildpc_preview").remove();
        } else {
            return ovianna(isures_buildpc_vars.text_empty_item_config, "false"), false;
        }
        kemani.preventDefault();
    });
});
isures_buildpc_vars.sticky_sidebar == true && jQuery(window).on("load", function () {
    var esme = jQuery;
    if (esme("#isures-buildpc--wrap").length > 0 && esme(window).width() > 1024) {
        var rockell = esme(".fix-bar .select-fix").height(), dorrit = esme(".row#isures-buildpc--wrap").height();
        dorrit > rockell && esme(window).scroll(function () {
            var lorece = esme(window).scrollTop(), fransico = esme(".row#isures-buildpc--wrap").innerWidth(), kashona = fransico * 25 / 100 - 30, lauralye = esme(".isures-end").offset().top, marike = esme(".fix-bar").offset().top;
            if (esme(window).width() > 1024 && lorece + rockell > lauralye - 100) {
                esme(".fix-bar .select-fix").css({top: (lorece + rockell - lauralye + 100) * -1});
                esme(".fix-bar .select-fix").removeClass("move");
            } else {
                esme(window).width() > 1024 && lorece > marike ? (esme(".fix-bar .select-fix").css({position: "fixed", width: kashona}), esme(".fix-bar .select-fix").css({top: "" + isures_buildpc_vars.top_sticky + "px"}), esme(".fix-bar .select-fix").addClass("move")) : (esme(".fix-bar .select-fix").css({position: "relative", top: "auto"}), esme(".fix-bar .select-fix").removeClass("move"));
            }
        });
    }
});
