var inputTextLength = 1;

$(document).ready(function() {
chart = {
  colors: ['#f26363'],
  chart: {
  	height: 320,
    type: 'spline'
  },
  title: {
    text: ''
  },
  credits: {
  	enabled: false
  },
  legend: {
    enabled: false
  },
  exporting: {
  	enabled: false
  },
  yAxis: {
    title: {
      text: ''
    },
    labels: {
      formatter: function() {
        return this.value;
      }
    }
  },
  xAxis: {
    title: {
      //text: 'Date'
    },
    labels: {
      formatter: function() {
        return this.value;
      },
      step: 2
    },
  },
  tooltip: {
    enabled: false,
    crosshairs: true,
    shared: false
  },
  plotOptions: {
    spline: {
      marker: {
        radius: 3,
        fillColor: '#ffffff',
        lineColor: '#f26363',
        lineWidth: 2
      }
    }
  },
  series: [{
    data: ''
  }]
}
});

$('body').on('click', '.tip', function() {
  var id = $(this).data('tip');
	$('.input__text').val(id);
  send();
  $('.block--form').removeClass('focus');
});

$('body .focus').on('click', 'body', function() {
  if ($('.tips-list').length) {
  	$('.block--form').removeClass('focus');
  }
});

$('.block--form').on('click', function() {
  if ($('.tips-list').length) {
  	$('.block--form').addClass('focus');
  }
});


$(".input__text").keyup(function() {
  var text = $('.input__text').val();
  if (text.length && inputTextLength != text.length) {
    inputTextLength = text.length;
    $.ajax({
      type: "POST",
      url: "methods/tsoiisalive.php",
      data: {
        "query": text
      },
      cache: false,
      success: function (response) {
        if (response.length) {
          $('.block--form').addClass('tips');
        	$('.tips-list').html(response);
        }
      }
    });
  } else {
    $('.tips-list').html('');
    $('.block--form').removeClass('tips');
  }
});

$('body').on('click', '.info--item.grafic', function() {
	var type = $(this).data("grafic");
  var title = $(this).children('label').text().replace(": ","");
	var id = $(this).parents('.block--info__hover').data("id");
  
  if ($('#graphic').html() != '') {
    $('#graphic .highcharts-container').html('');
  }
  $.ajax({
    type: "POST",
    url: "methods/tsoiisalive.php",
    data: {
      "grafic": type,
      "id": id
    },
    cache: false,
    success: function (response) {
    	object = JSON.parse(response);
      chart.series[0].data = object;
			$('body').animate({'scrollTop': $('body').height()}, 500, 'swing');
      Highcharts.chart('graphic', chart); 
  		$('#graphic').prepend('<h2>' + title + ' chart</h2>');
    }
  });
});

function check() {
  var text = $('.input__text').val();
  if ($('.block--form').hasClass('error')) {
    $('.block--form').removeClass('error');
  }
  if(text.length != 0) {
    $('.button__reset').css('display', 'inline-block');
  } else {
    $('.button__reset').css('display', 'none');
  }
}

function clean() {
  if ($('.block--form').hasClass('error')) {
    $('.block--form').removeClass('error');
  }
  $('.button__reset').css('display', 'none');  
  $('.input__text').val('');
  $('.response').html('');
  $('#graphic').html('');
  $('.tips-list').html('');
  if ($('.block--form').hasClass('tips')) {
    $('.block--form').removeClass('tips');
  }
}

function send() {
  $('#graphic').html('');
  if ($('.input__text').val() == '') {
    $('.block--form').addClass('error');
  } else {
    var text = $('.input__text').val();
    $.ajax({
      type: "POST",
      url: "methods/tsoiisalive.php",
      data: {"text": text},
      cache: false,
      success: function (response) {
        answer = JSON.parse(response);
        if (!answer['answer']['status'] && !$('.input__text').hasClass('error')) {
    			$('.block--form').addClass('error');
        }
        $('.response').html(answer['answer']['text']);
      }
    });
  }
}