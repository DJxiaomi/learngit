function imageResize(obj, width, height){

	width = width == '' ? $(obj).parent().width(): width;

	var heights = [];

	$('.imgbrand').each(function(){

		heights.push($(this).height());

	});

	var minHeight = Math.min.apply(null, heights);

	height = height == '' ? minHeight : height;

	$('.imgbrand').css('height', height);

    var hRatio;

    var wRatio;

    var Ratio = 1;

    var w = $(obj).width();

    var h = $(obj).height();

    var t = width / height;

    wRatio = width / w;

    hRatio = height / h;



    if (width ==0 && height==0){

        Ratio = 1;

    }else if (width==0){

        if (hRatio<1) Ratio = hRatio;

    }else if (height==0){

        if (wRatio<1) Ratio = wRatio;

    }else if (wRatio<1 || hRatio<1){

        Ratio = (wRatio<=hRatio?wRatio:hRatio);

    }

    if (Ratio<1){

        w = w * Ratio;

        h = h * Ratio;

    }



    if(h < height && w < width){

        $(obj).height(Math.round(w));

        $(obj).width(Math.round(h));

        $(obj).css('margin-left', Math.round((width - $(obj).width()) / 2));

        $(obj).css('margin-top', Math.round((height - $(obj).height()) / 2));

    }



    if(h < height){

        if($(obj).width() >= width){

            $(obj).height(Math.round(height));

            $(obj).css('margin-left', Math.round((width - $(obj).width()) / 2));

        }

    }

    if(w < width){

        if($(obj).height() >= height){

            $(obj).width(Math.round(width));

            $(obj).css('margin-top', Math.round((height - $(obj).height()) / 2));

        }

    }



    if(h >= height && w >= width){

        $(obj).height(Math.round(h));

        $(obj).width(Math.round(w));

        $(obj).css('margin-left', Math.round((width - $(obj).width()) / 2));

        $(obj).css('margin-top', Math.round((height - $(obj).height()) / 2));

    }

}
