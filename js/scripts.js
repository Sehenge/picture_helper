/**
 * Created with JetBrains PhpStorm.
 * User: sehenge
 * Date: 3/18/13
 * Time: 1:32 PM
 * To change this template use File | Settings | File Templates.
 */

function Helper() {
    this.imgCont = $(".img_container");
    this.imgContEyewear = this.imgCont.find(".eyewear");
    this.imgContrCases = this.imgCont.find(".cases form");
    this.searchRes = $("#searchResult");
    this.eyewear = new Array();
    this.fifth = $("#fifth_img");
    this.finput = $(".finput");
    this.fmodel = this.finput.find('input[name="model"]');
    this.fupc = this.finput.find('input[name="upc"]');
    this.fcolorcodes = this.finput.find('select[name="colorCodeS"]');
    this.fcolors = this.finput.find('select[name="colorS"]');
    this.fsizes = this.finput.find('select[name="sizeS"]');
    this.fsellercosts = this.finput.find('select[name="sellerCostS"]');
    this.fselects = this.finput.find(".fselect select");
    this.descriptions = this.finput.find('select[name="description"]');
}

Helper.prototype.InitEvents = function Helper_initEvents() {
    var self = this;
    this.CheckCount();

    this.fifth.click(function(){
        $("#popup").empty();
        $("#popup").append('<img src="' + $(this).find("img").attr("data-tooltip") + '" style="width: 700px"/>');
        $("#popup").fadeIn("slow");
    })

    $("#popup").click(function(){
        $(this).fadeOut("slow");
    })

    $(".customSubmit, .ajaxSubmit").click(function() {
        $("#preloader").bPopup();
    })

    /**
     * QB Parser by UPC
     */
    this.fupc.change(function() {
        var upc = $(this).val().toUpperCase();
        $.ajax({
            type: "POST",
            url: "?r=site/QbParse",
            data: { upc: upc }
        }).done(function( msg ) {
                self.obj = JSON.parse(msg);
                window.obj = JSON.parse(msg);
                self.fselects.empty();
                if (self.obj.length > 1) {
                    self.obj.forEach(function(objd) {
                        self.fcolorcodes.append('<option>' + objd['Attribute'] + '</option>');
                        self.fcolors.append('<option>' + objd['Desc2'] + '</option>');
                        self.fsizes.append('<option>' + objd['Size'] + '</option>');
                        self.fsellercosts.append('<option>' + objd['Cost'] + '</option>');
                    });
                } else {
                    self.fcolorcodes.parent().hide();
                    self.fcolors.parent().hide();
                    self.fsizes.parent().hide();
                    self.fsellercosts.parent().hide();
                }
                $('input[name="brand"]').val(self.obj[0]['brand']);
                $('input[name="colorCode"]').val(self.obj[0]['Attribute']);
                $('input[name="color"]').val(self.obj[0]['Desc2']);
                self.obj[0]['Desc1'] = self.obj[0]['Desc1'].replace(/-\s*CO$/,'');
                $('input[name="model"]').val(self.obj[0]['Desc1']);
                $('input[name="sellerCost"]').val(self.obj[0]['Cost']);
                $('input[name="quantity"]').val(self.obj[0]['QuantityOnHand']);
                $('input[name="size"]').val(self.obj[0]['Size']);
                if ((self.obj[0]['DepartmentCode'] == 'EYE') || (self.obj[0]['DepartmentCode'] == 'RX')) {
                    self.descriptions.val('Eyeglasses');
                    $('input[name="rx"]').prop('checked', true);
                } else {
                    self.descriptions.val('Sunglasses');
                    $('input[name="rx"]').prop('checked', false);
                }
            });
    })

    /**
     * QB Parser by Model
     */
    /*this.fmodel.change(function() {
        var model = $(this).val().toUpperCase();
        $.ajax({
            type: "POST",
            url: "?r=site/QbParse",
            data: { model: model }
        }).done(function( msg ) {
                console.log(JSON.parse(msg));
                self.obj = JSON.parse(msg);
                window.obj = JSON.parse(msg);
                self.fselects.empty();
                if (self.obj.length > 1) {
                    self.obj.forEach(function(objd) {
                        self.fcolorcodes.append('<option>' + objd['Attribute'] + '</option>');
                        self.fcolors.append('<option>' + objd['Desc2'] + '</option>');
                        self.fsizes.append('<option>' + objd['Size'] + '</option>');
                        self.fsellercosts.append('<option>' + objd['Cost'] + '</option>');
                    });
                }
                if (typeof self.obj[0] != 'undefined') {
                    $('input[name="upc"]').val(self.obj[0]['UPC']);
                    $('input[name="brand"]').val(self.obj[0]['brand']);
                    $('input[name="colorCode"]').val(self.obj[0]['Attribute']);
                    $('input[name="color"]').val(self.obj[0]['Desc2']);
                    $('input[name="sellerCost"]').val(self.obj[0]['Cost']);
                    $('input[name="quantity"]').val(self.obj[0]['QuantityOnHand']);
                    $('input[name="size"]').val(self.obj[0]['Size']);
                    if ((self.obj[0]['DepartmentCode'] == 'EYE') || (self.obj[0]['DepartmentCode'] == 'RX')) {
                        self.descriptions.val('Eyeglasses');
                        $('input[name="rx"]').prop('checked', true);
                    } else {
                        self.descriptions.val('Sunglasses');
                        $('input[name="rx"]').prop('checked', false);
                    }
                }
            });
    })*/

    /**
     * Temporary container viewer
     */
    $('.count').click(function() {
        $.ajax({
            type: "POST",
            url: "?r=popups/TmpCont"
        }).done(function( msg ) {
                $('.tmpCont').html(msg);
                $('.tmpCont').bPopup({
                    follow: [false, false],
                    position: [150, 50]
                });

                $('.tmpModel').click(function(e) {
                    if (e.target.localName !== "a"){
                        if ($(this).find('.fullModel').css("display") == 'none') {
                            $(this).find('.fullModel').slideDown("slow");
                        } else {
                            $(this).find('.fullModel').slideUp("slow");
                        }
                    }
                });

                $('.tmpModel a').click(function() {
                    self.DeleteModel($(this).attr("rel"));
                });
            });
    })

    $('#searchAff').click(function() {
        self.SearchAff();
    });

    $('#searchShdx').click(function() {
        self.SearchShdx();
    });

    $('#addToFeed').click(function() {
        self.AddToFeed($(this));
    });

    $('#azGenBtn').click(function() {
        self.AzGenFeed($(this));
    });

    $('#ukGenBtn').click(function() {
        self.UkGenFeed($(this));
    });

    $('#fpGenBtn').click(function() {
        self.FpGenFeed($(this));
    });

    $('#ebayGenBtn').click(function() {
        self.EbayGenFeed($(this));
    });

    $('#regGenBtn').click(function() {
        self.RegGenFeed($(this));
    });

    $('#clearfeed').click(function() {
        self.ClearFeed();
    });

    /**
     * Model-Color Code-Color Chooser
     */
    this.fselects.change(function() {
        $(this).parent().prev().val($(this).val());
    })

    this.fcolorcodes.change(function() {
        self.ChangeUnique('colorcode');
    })

    this.fcolors.change(function() {
        self.ChangeUnique('color');
    })

    /**
     * Json Real-Time brand parser
     */
    $(".input input").change(function() {
        var pattern = /(AZ)?([A-Z]+)([^A-Z0-9])([A-Z0-9]+)?(([^A-Z0-9])([A-Z0-9]+))?/;
        var parts = pattern.exec($(this).val());

        $.ajax({
            type: "POST",
            url: "?r=site/JsonBrand",
            data: { mcode: parts[2] }
        }).done(function( msg ) {
                if (msg.indexOf('_') !== -1) {
                    var brand = msg.split('_');
                    brand = brand[0] + ' ' + brand[1];
                } else {
                    var brand = msg;
                }

                $(".input select option").each(function() {
                    if ($(this).text() == brand) {
                        $(this).attr('selected', 'selected');
                    }
                })
                $('.input input[name="model"]').val(parts[4]);
                $('.input input[name="color_code"]').val(parts[7]);
            });
    })

    this.Tooltips();
}

/**
 * Print founded images in output div
 * @param data
 * @constructor
 */
Helper.prototype.PrintImages = function Helper_printImages(data) {
    $('#preloader').bPopup().close();
    var self = this;
    this.imgContEyewear.empty();
    this.imgContrCases.empty();
    this.searchRes.empty();
    this.eyewear = [];
    var images = data.split(',');

    for (var key in images) {
        var image = images[key];
        /*var imageTemp = image.split('/');
        var unionImage = "http://dev.union-progress.com/feedhelper/picture_helper/temp/" + imageTemp[7] +
            '/' + imageTemp[8] + '/' + imageTemp[9];

        if ((imageTemp[7] == 'Large_Pictures') || (imageTemp[7] == 'Pictures')) {
            var affImage = "http://affordableluxurygroup.com/"+ imageTemp[7] +
                '/' + imageTemp[8] + '/' + imageTemp[9];
        } else {
            var affImage = "http://shadesexpo.net/Ebay/"+ imageTemp[7] +
                '/' + imageTemp[8] + '/' + imageTemp[9];
        }*/

        if (image.indexOf('i:') !== -1) {
            this.imgContEyewear.append('<img src="' + image.substr(image.indexOf('i:')+2)
                + '" data-tooltip="' + image.substr(image.indexOf('i:')+2) + '"/><br/>');
            //$("#searchResult").append(image.substr(image.indexOf('i:')+2) + ",\n");
            this.eyewear.push(image.substr(image.indexOf('i:')+2));
            if (key == 4) {
                self.fifth.empty();
                self.fifth.append('<img src="' + image.substr(image.indexOf('i:')+2)
                    + '" width="240px" data-tooltip="' + image.substr(image.indexOf('i:')+2) + '"/><br/>');
            }
        } else if (image.indexOf('c:') !== -1) {
            this.imgContrCases.append('<input type="radio" name="case" value="' + image.substr(image.indexOf('c:')+2) +
                '">' + '<img src="' + image.substr(image.indexOf('c:')+2)
                + '" data-tooltip="' + image.substr(image.indexOf('c:')+2) + '"/><br/>');
        }
    }

    if ((data.indexOf('<exception>') !== -1) && (data.indexOf('<exception>') !== 0)) {
        this.searchRes.val(this.eyewear);
        //this.searchRes.append("\n" + data.substr(data.indexOf('<exception>') + 11, data.indexOf('</exception>')));
    } else if ((data.indexOf('<exception>') !== -1) && (data.indexOf('<exception>') === 0)) {
        //this.searchRes.append("\n" + data.substr(data.indexOf('<exception>') + 11, data.indexOf('</exception>')));
        this.searchRes.val(this.eyewear);
    } else {
        this.searchRes.val(this.eyewear);
    }

    this.casesRB = this.imgContrCases.find("input:radio");
    this.casesImg = this.imgContrCases.find("img");
    this.casesRB.click(function(){
        self.searchRes.empty();
        self.searchRes.val(self.eyewear + ',' + $(this).val());
        //self.searchRes.append($(this).val());
    });

    this.casesImg.click(function(){
        $(this).prev().click();
    });

    this.Tooltips();
}

/**
 * Product chooser by changing select options
 * @param param
 * @constructor
 */
Helper.prototype.ChangeUnique = function Helper_changeUnique(param) {
    self = this;
    window.obj.forEach(function(objd) {
        if (param == 'colorcode') {
            if (objd['Attribute'] == self.fcolorcodes.val()) {
                $('input[name="color"]').val(objd['Desc2']);
                $('input[name="sellerCost"]').val(objd['Cost']);
                $('input[name="quantity"]').val(objd['QuantityOnHand']);
                $('input[name="size"]').val(objd['Size']);
                if ((objd['DepartmentCode'] == 'EYE') || (objd['DepartmentCode'] == 'RX')) {
                    self.descriptions.val('Eyeglasses');
                    $('input[name="rx"]').prop('checked', true);
                } else {
                    $('input[name="rx"]').prop('checked', false);
                    self.descriptions.val('Sunglasses');
                }
            }
        } else if (param == 'color') {
            if (objd['Desc2'] == self.fcolors.val()) {
                $('input[name="colorcode"]').val(objd['Attribute']);
                $('input[name="sellerCost"]').val(objd['Cost']);
                $('input[name="quantity"]').val(objd['QuantityOnHand']);
                $('input[name="size"]').val(objd['Size']);
                if ((objd['DepartmentCode'] == 'EYE') || (objd['DepartmentCode'] == 'RX')) {
                    self.descriptions.val('Eyeglasses');
                    $('input[name="rx"]').prop('checked', true);
                } else {
                    $('input[name="rx"]').prop('checked', false);
                    self.descriptions.val('Sunglasses');
                }
            }
        }
    });
}

/**
 * Add product to temporary feed
 * @param obj
 * @constructor
 */
Helper.prototype.AddToFeed = function Helper_addToFeed(obj) {
    var self = this;
    $.ajax({
        type: "POST",
        url: "?r=site/AddToFeed",
        data: obj.parents("form").serialize()
    }).done(function( data ) {
            //console.log(data);
            $("#fcount").text(data);
            $('#preloader').bPopup().close();
            $("#bpop span").text("Successfully added to feed!").css("color","green");
            $("#bpop").bPopup();
            setTimeout(function() {
                self.BpopupClose($("#bpop"));
            }, 700);
            return false;
        });
}

/**
 * Generate AZ feed from temporary feed
 * @param obj
 * @constructor
 */
Helper.prototype.AzGenFeed = function Helper_azGenFeed(obj) {
    var self = this;
    $.ajax({
        type: "POST",
        url: "?r=site/azgen",
        data: obj.parents("form").serialize()
    }).done(function( data ) {
            $('#preloader').bPopup().close();
            console.log(data);
            $("#bpop span").text("AZ feed successfully generated!").css("color","green");
            $("#bpop").bPopup();
            setTimeout(function() {
                self.BpopupClose($("#bpop"));
            }, 700);
            return false;
        });
}

/**
 * Generate UK feed from temporary feed
 * @param obj
 * @constructor
 */
Helper.prototype.UkGenFeed = function Helper_ukGenFeed(obj) {
    var self = this;
    $.ajax({
        type: "POST",
        url: "?r=site/ukgen",
        data: obj.parents("form").serialize()
    }).done(function( data ) {
            $('#preloader').bPopup().close();
            console.log(data);
            $("#bpop span").text("UK feed successfully generated!").css("color","green");
            $("#bpop").bPopup();
            setTimeout(function() {
                self.BpopupClose($("#bpop"));
            }, 700);
            return false;
        });
}

/**
 * Generate FP feed from temporary feed
 * @param obj
 * @constructor
 */
Helper.prototype.FpGenFeed = function Helper_fpGenFeed(obj) {
    var self = this;
    $.ajax({
        type: "POST",
        url: "?r=site/fpgen",
        data: obj.parents("form").serialize()
    }).done(function( data ) {
            $('#preloader').bPopup().close();
            console.log(data);
            $("#bpop span").text("FP feed successfully generated!").css("color","green");
            $("#bpop").bPopup();
            setTimeout(function() {
                self.BpopupClose($("#bpop"));
            }, 700);
            return false;
        });
}

/**
 * Generate Ebay feed from temporary feed
 * @param obj
 * @constructor
 */
Helper.prototype.EbayGenFeed = function Helper_ebayGenFeed(obj) {
    var self = this;
    $.ajax({
        type: "POST",
        url: "?r=site/ebaygen",
        data: obj.parents("form").serialize()
    }).done(function( data ) {
            $('#preloader').bPopup().close();
            console.log(data);
            $("#bpop span").text("Ebay feed successfully generated!").css("color","green");
            $("#bpop").bPopup();
            setTimeout(function() {
                self.BpopupClose($("#bpop"));
            }, 700);
            return false;
        });
}

/**
 * Generate Regular feed from temporary feed
 * @param obj
 * @constructor
 */
Helper.prototype.RegGenFeed = function Helper_regGenFeed(obj) {
    var self = this;
    $.ajax({
        type: "POST",
        url: "?r=site/reggen",
        data: obj.parents("form").serialize()
    }).done(function( data ) {
            $('#preloader').bPopup().close();
            console.log(data);
            $("#bpop span").text("Regular feed successfully generated!").css("color","green");
            $("#bpop").bPopup();
            setTimeout(function() {
                self.BpopupClose($("#bpop"));
            }, 700);
            return false;
        });
}

/**
 * Image searching in AffordableLuxury
 * @constructor
 */
Helper.prototype.SearchAff = function Helper_searchAff() {
    self = this;
    var model = $('input[name="model"]').val();
    var colorCode = $('input[name="colorCode"]').val();
    var sku = model + '-' + colorCode;
    $.ajax({
        type: "POST",
        url: "?r=site/getdir",
        data: { sku: sku, cases: true }
    }).done(function( msg ) {
            $('#preloader').bPopup().close();
            self.PrintImages(msg);
            $("#bpop span").text("Searching is ended!").css("color","green");
            $("#bpop").bPopup();
            setTimeout(function() {
                self.BpopupClose($("#bpop"));
            }, 700);
            return false;
        }).fail(function(msg) {
            console.log(msg);
            $('#preloader').bPopup().close();
        });
}

/**
 * Image searching in Shadesexpo
 * @constructor
 */
Helper.prototype.SearchShdx = function Helper_searchShdx() {
    self = this;
    var model = $('input[name="model"]').val();
    var colorCode = $('input[name="colorCode"]').val();
    var sku = model + '-' + colorCode;
    $.ajax({
        type: "POST",
        url: "?r=site/getshades",
        data: { sku: sku, cases: true }
    }).done(function( msg ) {
            $('#preloader').bPopup().close();
            self.PrintImages(msg);
            $("#bpop span").text("Searching is ended!").css("color","green");
            $("#bpop").bPopup();
            setTimeout(function() {
                self.BpopupClose($("#bpop"));
            }, 700);
            return false;
        }.fail(function(msg) {
                console.log(msg);
                $('#preloader').bPopup().close();
            }));
}

/**
 * Clear temporary feed
 * @constructor
 */
Helper.prototype.ClearFeed = function Helper_clearFeed() {
    var self = this;
    $.ajax({
        type: "POST",
        url: "?r=site/clearfeed"
    }).done(function( data ) {
            $('#preloader').bPopup().close();
            $("#bpop span").text("Feed successfully cleared!").css("color","green");
            $("#bpop").bPopup();
            $("#fcount").text(data);
            setTimeout(function() {
                self.BpopupClose($("#bpop"));
            }, 700);
            return false;
        });
}

/**
 *
 * @param rel
 * @constructor
 */
Helper.prototype.DeleteModel = function Helper_deleteModel(rel) {
    var self = this;
    $.ajax({
        type: "POST",
        url: "?r=site/deletemodel",
        data: {rel: rel}
    }).done(function( data ) {
            //console.log(data);
            $('.tmpModel a[rel="' + rel +'"]').parent().remove();
            self.CheckCount();
            //$('#preloader').bPopup().close();
            //return false;
        });
}

/**
 * Current count of products in temporary feed
 * @constructor
 */
Helper.prototype.CheckCount = function Helper_checkCount() {
    $.ajax({
        type: "POST",
        url: "?r=site/CheckCount"
    }).done(function( msg ) {
            $("#fcount").text(msg);
        });
}

/**
 * Tooltips on elements hover
 * @constructor
 */
Helper.prototype.Tooltips = function Helper_tooltips() {
    $("[data-tooltip]").mousemove(function (eventObject) {
        $data_tooltip = $(this).attr("data-tooltip");
        $("#tooltip").text($data_tooltip)
            .css({
                "top" : eventObject.pageY + 5,
                "left" : eventObject.pageX + 5
            })
            .show();
    }).mouseout(function () {
            $("#tooltip").hide()
                .text("")
                .css({
                    "top" : 0,
                    "left" : 0
                });
        });

    $(".finput input, .finput select").mousemove(function (eventObject) {
        $data_tooltip = $(this).attr("name");
        $("#tooltip").text($data_tooltip)
            .css({
                "top" : eventObject.pageY + 5,
                "left" : eventObject.pageX + 5
            })
            .show();
    }).mouseout(function () {
            $("#tooltip").hide()
                .text("")
                .css({
                    "top" : 0,
                    "left" : 0
                });
        });
}

/**
 *
 * @param block
 * @constructor
 */
Helper.prototype.BpopupClose = function Helper_bpopupClose(block) {
    block.bPopup().close()
}