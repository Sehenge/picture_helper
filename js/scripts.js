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
}

Helper.prototype.InitEvents = function Helper_initEvents() {
    var self = this;
    this.casesRB = this.imgContrCases.find("input:radio");
    this.casesImg = this.imgContrCases.find("img");

    this.casesRB.click(function(){
        self.searchRes.empty();
        self.searchRes.append(self.eyewear);
        self.searchRes.append($(this).val());
    })

    this.casesImg.click(function(){
        $(this).prev().click();
        //self.searchRes.empty();
        //self.searchRes.append(self.eyewear);
        //self.searchRes.append($(this).val());
    })

    $("#ajaxSubmit").click(function() {
        $("#preloader").show();
    })

    $('.input input[name="sku"]').change(function() {
        var parts = $(this).val().split(' ');
        var mcode;
        if (parts[0].match(/AZ?(.*)/)) {
            mcode = parts[0].match(/AZ?(.*)/)[1];
        } else {
            mcode = parts[0];
        }
        var supplement = parts[1].split('-');
        $.ajax({
            type: "POST",
            url: "?r=site/JsonBrand",
            data: { mcode: mcode }
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
                $('.input input[name="model"]').val(supplement[0]);
                $('.input input[name="color_code"]').val(supplement[1]);
            });
    })

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
}

Helper.prototype.PrintImages = function Helper_printImages(data) {
    console.log(data);
    this.imgContEyewear.empty();
    this.imgContrCases.empty();
    this.searchRes.empty();
    var images = data.split(',');
    var eyewear = new Array();
    for (var key in images) {
        var image = images[key];
        if (image.indexOf('i:') !== -1) {
            this.imgContEyewear.append('<img src="' + image.substr(image.indexOf('i:')+2)
                + '" data-tooltip="' + image.substr(image.indexOf('i:')+2) + '"/><br/>');
            //$("#searchResult").append(image.substr(image.indexOf('i:')+2) + ",\n");
            this.eyewear.push(image.substr(image.indexOf('i:')+2) + ",\n");
            if (key == 4) {
                $("#fifth_img").append('<img src="' + image.substr(image.indexOf('i:')+2)
                    + '" width="240px" data-tooltip="' + image.substr(image.indexOf('i:')+2) + '"/><br/>');
            }
        } else if (image.indexOf('c:') !== -1) {
            this.imgContrCases.append('<input type="radio" name="case" value="' + image.substr(image.indexOf('c:')+2) +
                '">' + '<img src="' + image.substr(image.indexOf('c:')+2)
                + '" data-tooltip="' + image.substr(image.indexOf('c:')+2) + '"/><br/>');
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
    this.InitEvents();
}