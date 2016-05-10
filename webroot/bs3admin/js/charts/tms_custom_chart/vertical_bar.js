
var placeholder = '';
function plotChartData(placeholder_input, data, eTicks)
{
	placeholder = placeholder_input;
	ticks = eTicks;
	var options = 
	{
	    series: {
	        bars: {
	            show: true,
	            barWidth: 0.1,
	            lineWidth: 0,
	            order: 1,
	            fillColor: {
	                colors: [{
	                    opacity: 1
	                }, {
	                    opacity: 0.7
	                }]
	            }
	        }
	    },
	    xaxis: {
	    	ticks: ticks,
	        axisLabel: 'Association',
	        axisLabelUseCanvas: true,
	        axisLabelFontSizePixels: 13,
	        axisLabelFontFamily: 'Verdana, Arial, Helvetica, Tahoma, sans-serif',
	        axisLabelPadding: 15
	    },
	    yaxis: {
	        axisLabel: 'Value',
	        axisLabelUseCanvas: true,
	        axisLabelFontSizePixels: 13,
	        axisLabelFontFamily: 'Verdana, Arial, Helvetica, Tahoma, sans-serif',
	        axisLabelPadding: 5
	    },
	    grid: {
	        hoverable: true,
	        borderWidth: 0
	    },
	    legend: {
	        backgroundColor: "#EEE",
	        labelBoxBorderColor: "none"
	    },
	    colors: ["#AA4643", "#89A54E", "#4572A7"]
	};
	
	$.plot($(placeholder), data, options);
	showToolTipOnChart(placeholder, ticks);
}

var previous_point = null;

function showTooltip(x, y, color, contents) 
{
	 	var rootElt = 'body';
	    
    $('<div id="tooltip" class="chart-tooltip">' + contents + '</div>').css( {
        top: y - 60,
        left: x ,
        opacity: 0.9
    }).prependTo(rootElt).show();
}



function prepareChartData(placeholder, server_data)
{
	var encoded_data = $.parseJSON(server_data);
    var training_data = [];

    /* Populate Chart Ticks */
    var ticks = [];
    if(encoded_data.length > 0)
    {
    	if(encoded_data[0].entity_data)
    	{
		    $.each(encoded_data[0].entity_data, function(i, d)
		    {
		    	var arr = [];
				arr.push(i);
				arr.push(d.name);
				ticks.push(arr);
		    });
		
		    /* Populate Chart Data */
		    $.each(encoded_data, function(index, data)
		    {
		    	var year_data = [];
		    	year_data['label'] = data.bar;
		    	year_data['data'] = [];
				$.each(data.entity_data, function(i, d)
				{
		    		var arr = [];
		    		arr.push(i);
		    		arr.push(d.value);
		    		year_data['data'].push(arr);		    	
				});
				training_data.push(year_data);
		    });
    	}
    	plotChartData(placeholder, training_data, ticks);
    }
}

function prepareChartDataJson(placeholder, server_data)
{
	var encoded_data = server_data;
    var training_data = [];

    /* Populate Chart Ticks */
    var ticks = [];
    if(encoded_data.length > 0)
    {
    	if(encoded_data[0].entity_data)
    	{
		    $.each(encoded_data[0].entity_data, function(i, d)
		    {
		    	var arr = [];
				arr.push(i);
				arr.push(d.name);
				ticks.push(arr);
		    });
		
		    /* Populate Chart Data */
		    $.each(encoded_data, function(index, data)
		    {
		    	var year_data = [];
		    	year_data['label'] = data.bar;
		    	year_data['data'] = [];
				$.each(data.entity_data, function(i, d)
				{
		    		var arr = [];
		    		arr.push(i);
		    		arr.push(d.value);
		    		year_data['data'].push(arr);		    	
				});
				training_data.push(year_data);
		    });
    	}
    	plotChartData(placeholder, training_data, ticks);
    }
}


function showToolTipOnChart(tooltip_id, ticks)
{
	var previous_point_target = null;
	$(tooltip_id).on("plothover", function (event, pos, item) {
	    if (item) {
	    	if (previous_point_target != item.datapoint) {
	    		previous_point_target = item.datapoint;
	            $('.chart-tooltip').remove();
	 
	            var x = item.datapoint[0];
	 
	            //All the bars concerning a same x value must display a tooltip with this value and not the shifted value
	            if(item.series.bars.order)
	            {
	                for(var i=0; i < item.series.data.length; i++){
	                    if(item.series.data[i][3] == item.datapoint[0])
	                        x = item.series.data[i][0];
	                    	if(ticks[x] != undefined)
	                    	{
	                    		x = ticks[x][1];
	                    	}
	                    	
	                }
	            }
	            var color = item.series.color;
	            var y = item.datapoint[1];
	            showTooltip(item.pageX, item.pageY, color, 
	                "<div style='text-align: center;'><b>" + item.series.label + ": </b>" + y + "</div>");
	        }
	    } else {
	        $(".chart-tooltip").remove();
	        previous_point_target = null;
	    }
	});
}

/** Example Data Set
 * var bar_customised_1 = [];
    var bar_customised_2 = [];
    var bar_customised_3 = [];

    var b1 = [];
    b1.push(0);
    b1.push(120);

    var b2 = [];
    b2.push(1);
    b2.push(70);

    var b3 = [];
    b3.push(2);
    b3.push(100);

    bar_customised_1.push(b1);
    bar_customised_1.push(b2);
    bar_customised_1.push(b3);

    var b1 = [];
    b1.push(0);
    b1.push(90);

    var b2 = [];
    b2.push(1);
    b2.push(60);

    var b3 = [];
    b3.push(2);
    b3.push(30);

    bar_customised_2.push(b1);
    bar_customised_2.push(b2);
    bar_customised_2.push(b3);

    var b1 = [];
    b1.push(0);
    b1.push(80);

    var b2 = [];
    b2.push(1);
    b2.push(40);

    var b3 = [];
    b3.push(2);
    b3.push(47);

    bar_customised_3.push(b1);
    bar_customised_3.push(b2);
    bar_customised_3.push(b3);
 
    var data = [
        { label: "Y1", data: bar_customised_1 },
        { label: "Y2", data: bar_customised_2 },
        { label: "Y3", data: bar_customised_3 }
    ];

 * 
 */