// 
function loadSlider() {
   ajaxPromise('home/controller/controller_home.php?option=slider_home', 
    'GET', 'JSON')
    .then(function(data) {
      for (row in data) {
        $('<img style="height:300px" class="image_brand_car" id="brand-'+data[row].brand+'" src="'+data[row].img+'" data-id="'+data[row].brand+'"/>').appendTo('#slider_home_brand');
      }
      $("#slider_home_brand").addClass('variable-width');
      $(".variable-width").slick({
          centerMode: true,
          centerPadding: '60px',
          slidesToShow: 3,
          responsive: [
            {
              breakpoint: 768,
              settings: {
                arrows: false,
                centerMode: true,
                centerPadding: '40px',
                slidesToShow: 3
              }
            },
            {
              breakpoint: 480,
              settings: {
                arrows: false,
                centerMode: true,
                centerPadding: '40px',
                slidesToShow: 1
              }
            }
          ]
        });
  }).catch(function() {
    window.location.href = "index.php?exceptions=controller&option=503";
  });

}
function loadfiltertypes() {
    ajaxPromise('home/controller/controller_home.php?option=buttons_home', 
    'GET', 'JSON')
    .then(function(data) {
      for (row in data) {
        $('<div></div>').attr('id',data[row].nom).appendTo('#types_buttons');
        $('<img id="image-type-'+data[row].id+'" style="height:100px" class="image-type" src="'+data[row].img+'" data-id="'+data[row].id+'"/>').appendTo('#'+data[row].nom);
        $('<h2>'+data[row].nom+'</h2>').appendTo('#'+data[row].nom);
      }
  }).catch(function() {
    window.location.href = "index.php?exceptions=controller&option=503";

  });

}

function loadfilterbuttons() {
    ajaxPromise('home/controller/controller_home.php?option=categories_menu', 
  'GET', 'JSON')
  .then(function(data) {
    for (row in data) {
      $('<div></div>').attr('id',data[row].nom).appendTo('#categories_buttons');
      $('<img id="image-type-'+data[row].id+'" style="height:100px" class="image-category" src="'+data[row].img+'" data-id="'+data[row].id+'"/>').appendTo('#'+data[row].nom);
      $('<h2>'+data[row].nom+'</h2>').appendTo('#'+data[row].nom);
    }
  }).catch(function() {
  window.location.href = "index.php?exceptions=controller&option=503";

  });

}
function charge_filter_home() {
  var filtro = {};

  $(document).on('click','.image_brand_car',function () {
      var id_brand_car = this.getAttribute('data-id');
      brand = {marca: id_brand_car};
      filtro = Object.assign(filtro,brand);
      reload_shop(filtro);
  });
  $(document).on('click','.image-type',function () {
      var id_type_car = this.getAttribute('data-id');
      type = {tipo: id_type_car};
      filtro = Object.assign(filtro,type);
      reload_shop(filtro);
  });
  $(document).on('click','.image-category',function () {
      var id_category_car = this.getAttribute('data-id');
      categories = {categoria: id_category_car};
      filtro = Object.assign(filtro,categories);
      reload_shop(filtro);
  });
  
}
function news() {
  localStorage.removeItem('limits');
  var news_array= [];
  var them_array= ["Audi","BMW","Ferrari","Mercedes"];
  var e = Math.floor((Math.random() * 5));
  

  $.ajax({
    type: 'GET',
    dataType: "json",
    url: "https://gnews.io/api/v4/search?q="+them_array[e]+"&token=0385cf3c96b012a44d32a89154502a99",
}).done(function (data) {
   
    var limits = { offset: 0,limit:3};
    localStorage.setItem('limits',JSON.stringify(limits));

    for (i=0;i < 9;i++) {
        news_array.push(data.articles[i]);
      }
    $('<div></div>').attr({'id':'news_total'}).appendTo('#news_home');
    $('<button></button>').attr({'id':'more_news'}).html("more news").appendTo('#news_home');
    create_news(news_array,limits.offset,limits.limit);

    });
}
function create_news(array,offset,limit) {
  if (limit == 9) {
    $('button#more_news').attr('hidden',true);
  }

  for (i=offset;i < limit;i++) {
    $('<div></div>').attr({'id':'new'+i,'class':'box_new','data-url':array[i].url}).appendTo('#news_total');
    $('<img></img>').attr({'id':'img'+i,'src':array[i].image,'class':'box_img'}).appendTo('#new'+i);
    $('<h2></h2>').attr({'id':'title'+i}).html(array[i].title).appendTo('#new'+i);
    $('<p></p>').attr({'id':'p'+i}).html(array[i].description).appendTo('#new'+i);
  }

  $(document).on('click','#more_news',function () {
    var limits = JSON.parse(localStorage.getItem('limits'));
    var offset_value = limits.offset+3;
    var limit_value = limits.limit+3;
    var limits = { offset: offset_value,limit:limit_value};
    localStorage.setItem('limits',JSON.stringify(limits));
    create_news(array,offset_value,limit_value);
  });
}
function reload_shop(filtro) {
  localStorage.setItem('filtro_research',JSON.stringify(filtro));
  window.location.href= "index.php?module=shop&option=list";
}
function redirect_news() {
  $(document).on('click','.box_new',function () {
    var url = this.getAttribute('data-url');
    window.open(url, '_blank');
  })
}
$(document).ready(function () {
    loadSlider();
    loadfilterbuttons();
    loadfiltertypes();
    charge_filter_home();
    news();
    redirect_news();
});