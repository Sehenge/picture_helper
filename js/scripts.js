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
}

Helper.prototype.InitEvents = function Helper_initEvents() {
    var self = this;
    this.casesRB = this.imgContrCases.find("input:radio");
    this.casesImg = this.imgContrCases.find("img");

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
        //self.searchRes.empty();
        //self.searchRes.append(self.eyewear);
        //self.searchRes.append($(this).val());
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

    this.fmodel.change(function() {
        var model = $(this).val();
        $.ajax({
            type: "POST",
            url: "?r=site/QbParse",
            data: { model: model }
        }).done(function( msg ) {
                console.log(JSON.parse(msg));
            });
    })

    $(".input input").change(function() {
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

/**
 *
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
        console.log(imageTemp[7]);
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
    this.InitEvents();
}