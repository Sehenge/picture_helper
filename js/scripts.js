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
    this.casesRB = this.imgContrCases.find("input:radio");
    this.casesImg = this.imgContrCases.find("img");

    /**
     * Current count of products in temporary feed
     */
    $.ajax({
        type: "POST",
        url: "?r=site/CheckCount"
    }).done(function( msg ) {
        $("#fcount").text(msg);
        });

    this.casesRB.click(function(){
        self.searchRes.empty();
        self.searchRes.append(self.eyewear);
        self.searchRes.append($(this).val());
    })

    this.casesImg.click(function(){
        $(this).prev().click();
    })

    this.fifth.click(function(){
        $("#popup").empty();
        $("#popup").append('<img src="' + $(this).find("img").attr("data-tooltip") + '" style="width: 700px"/>');
        $("#popup").fadeIn("slow");
    })

    $("#popup").click(function(){
        $(this).fadeOut("slow");
    })

    $(".ajaxSubmit").click(function() {
        $("#preloader").show();
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
                $('input[name="brand"]').val(self.obj[0]['brand']);
                $('input[name="colorCode"]').val(self.obj[0]['Attribute']);
                $('input[name="color"]').val(self.obj[0]['Desc2']);
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
    this.fmodel.change(function() {
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
    })

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

                $('.tmpModel').click(function() {
                    if ($(this).find('.fullModel').css("display") == 'none') {
                        $(this).find('.fullModel').slideDown("slow");
                    } else {
                        $(this).find('.fullModel').slideUp("slow");
                    }

                })
                console.log(msg);
            });
    })

    $('#searchAff').click(function() {
        self.SearchAff();
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

                if ($(".input select option:contains('" + brand + "')")) {
                    $(".input select option:contains('" + brand + "')").attr('selected', 'selected');
                }
                $('.input input[name="model"]').val(parts[4]);
                $('.input input[name="color_code"]').val(parts[7]);
            });
    })

    /**
     * Tooltips
     */
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
 * Print founded images in output div
 * @param data
 * @constructor
 */
Helper.prototype.PrintImages = function Helper_printImages(data) {
    console.log(data);
    var self = this;
    this.imgContEyewear.empty();
    this.imgContrCases.empty();
    this.searchRes.empty();
    var images = data.split(',');

    var eyewear = new Array();
    for (var key in images) {
        var image = images[key];

        var imageTemp = image.split('/');
        var unionImage = "http://union-progress.com/feedhelper/picture_helper/temp/" + imageTemp[7] +
            '/' + imageTemp[8] + '/' + imageTemp[9];

        if ((imageTemp[7] == 'Large_Pictures') || (imageTemp[7] == 'Pictures')) {
            var affImage = "http://affordableluxurygroup.com/"+ imageTemp[7] +
                '/' + imageTemp[8] + '/' + imageTemp[9];
        } else {
            var affImage = "http://shadesexpo.net/Ebay/"+ imageTemp[7] +
                '/' + imageTemp[8] + '/' + imageTemp[9];
        }

        if (image.indexOf('i:') !== -1) {
            this.imgContEyewear.append('<img src="' + unionImage.substr(unionImage.indexOf('i:')+1)
                + '" data-tooltip="' + affImage.substr(affImage.indexOf('i:')+1) + '"/><br/>');
            //$("#searchResult").append(image.substr(image.indexOf('i:')+2) + ",\n");
            this.eyewear.push(affImage.substr(affImage.indexOf('i:')+1) + ",");
            if (key == 4) {
                self.fifth.empty();
                self.fifth.append('<img src="' + unionImage.substr(unionImage.indexOf('i:')+1)
                    + '" width="240px" data-tooltip="' + affImage.substr(affImage.indexOf('i:')+1) + '"/><br/>');
            }
        } else if (image.indexOf('c:') !== -1) {
            this.imgContrCases.append('<input type="radio" name="case" value="' + affImage.substr(affImage.indexOf('c:')+1) +
                '">' + '<img src="' + unionImage.substr(unionImage.indexOf('c:')+1)
                + '" data-tooltip="' + affImage.substr(affImage.indexOf('c:')+1) + '"/><br/>');
        }
    }
    if ((data.indexOf('<exception>') !== -1) && (data.indexOf('<exception>') !== 0)) {
        this.searchRes.append(this.eyewear);
        this.searchRes.append("\n" + data.substr(data.indexOf('<exception>') + 11, data.indexOf('</exception>')));
    } else if ((data.indexOf('<exception>') !== -1) && (data.indexOf('<exception>') === 0)) {
        this.searchRes.append("\n" + data.substr(data.indexOf('<exception>') + 11, data.indexOf('</exception>')));
        this.searchRes.append(this.eyewear);
    } else {
        this.searchRes.append(this.eyewear);
    }
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
    $.ajax({
        type: "POST",
        url: "?r=site/AddToFeed",
        data: obj.parents("form").serialize()
    }).done(function( data ) {
            console.log(data);
            $("#fcount").text(data);
            $("#preloader").hide();
            $("#bpop span").text("Successfully added to feed!").css("color","green");
            $("#bpop").bPopup();
            return false;
        });
}

/**
 * Generate AZ feed from temporary feed
 * @param obj
 * @constructor
 */
Helper.prototype.AzGenFeed = function Helper_azGenFeed(obj) {
    $.ajax({
        type: "POST",
        url: "?r=site/azgen",
        data: obj.parents("form").serialize()
    }).done(function( data ) {
            console.log(data);
            $("#bpop span").text("AZ feed successfully generated!").css("color","green");
            $("#bpop").bPopup();
            $("#preloader").hide();
            return false;
        });
}

/**
 * Generate UK feed from temporary feed
 * @param obj
 * @constructor
 */
Helper.prototype.UkGenFeed = function Helper_ukGenFeed(obj) {
    $.ajax({
        type: "POST",
        url: "?r=site/ukgen",
        data: obj.parents("form").serialize()
    }).done(function( data ) {
            console.log(data);
            $("#bpop span").text("UK feed successfully generated!").css("color","green");
            $("#bpop").bPopup();
            $("#preloader").hide();
            return false;
        });
}

/**
 * Generate FP feed from temporary feed
 * @param obj
 * @constructor
 */
Helper.prototype.FpGenFeed = function Helper_fpGenFeed(obj) {
    $.ajax({
        type: "POST",
        url: "?r=site/fpgen",
        data: obj.parents("form").serialize()
    }).done(function( data ) {
            console.log(data);
            $("#bpop span").text("FP feed successfully generated!").css("color","green");
            $("#bpop").bPopup();
            $("#preloader").hide();
            return false;
        });
}

/**
 * Generate Ebay feed from temporary feed
 * @param obj
 * @constructor
 */
Helper.prototype.EbayGenFeed = function Helper_ebayGenFeed(obj) {
    $.ajax({
        type: "POST",
        url: "?r=site/ebaygen",
        data: obj.parents("form").serialize()
    }).done(function( data ) {
            console.log(data);
            $("#bpop span").text("Ebay feed successfully generated!").css("color","green");
            $("#bpop").bPopup();
            $("#preloader").hide();
            return false;
        });
}

/**
 * Generate Regular feed from temporary feed
 * @param obj
 * @constructor
 */
Helper.prototype.RegGenFeed = function Helper_regGenFeed(obj) {
    $.ajax({
        type: "POST",
        url: "?r=site/reggen",
        data: obj.parents("form").serialize()
    }).done(function( data ) {
            console.log(data);
            $("#bpop span").text("Regular feed successfully generated!").css("color","green");
            $("#bpop").bPopup();
            $("#preloader").hide();
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
        data: { sku: sku, cases: false }
    }).done(function( msg ) {
            self.PrintImages(msg);
            $("#bpop span").text("Searching is ended!").css("color","green");
            $("#bpop").bPopup();
            return false;
        });
}

/**
 * Clear temporary feed
 * @constructor
 */
Helper.prototype.ClearFeed = function Helper_clearFeed() {
    $.ajax({
        type: "POST",
        url: "?r=site/clearfeed"
    }).done(function( data ) {
            $("#bpop span").text("Feed successfully cleared!").css("color","green");
            $("#bpop").bPopup();
            $("#preloader").hide();
            $("#fcount").text(data);
            return false;
        });
}