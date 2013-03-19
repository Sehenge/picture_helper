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
        } else if (image.indexOf('c:') !== -1) {
            this.imgContrCases.append('<input type="radio" name="case" value="' + image.substr(image.indexOf('c:')+2) +
                '">' + '<img src="' + image.substr(image.indexOf('c:')+2)
                + '" data-tooltip="' + image.substr(image.indexOf('c:')+2) + '"/><br/>');
        }
    }
    this.searchRes.append(this.eyewear);
    this.InitEvents();
}