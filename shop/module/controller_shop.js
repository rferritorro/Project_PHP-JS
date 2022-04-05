
// Function map which is in detail
function map(lat,long,ciudad) {
    mapboxgl.accessToken = 'pk.eyJ1IjoicmVpZjQwMCIsImEiOiJja3p6ZWlmYWYwMDM4M2NxYTI0aGJrZjU5In0.pnTWl4oodCv8Edjbw-n6aA';
        var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center:[long,lat],
        zoom: 12
});
map.addControl(new mapboxgl.NavigationControl());
var geojson = {
    type: 'FeatureCollection',
    features: [{
        type: 'Feature',
        geometry: {
            type: 'Point',
            coordinates: [long,lat]
        },
        properties: {
            title: ciudad,
        }
    }]
};
geojson.features.forEach(function(marker) {
  var el = document.createElement('div');
  el.className = "marker";
  new mapboxgl.Marker(el)
    .setLngLat(marker.geometry.coordinates)
    .setPopup(
        new mapboxgl.Popup({ offset: 25 }) // add popups
        .setHTML( 
            `<h4>${marker.properties.title}</h4>`          )
      )
    .addTo(map);    
    });
}
// Function map which is list,it's array

function map_array(array) {
    mapboxgl.accessToken = 'pk.eyJ1IjoicmVpZjQwMCIsImEiOiJja3p6ZWlmYWYwMDM4M2NxYTI0aGJrZjU5In0.pnTWl4oodCv8Edjbw-n6aA';
    var map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/streets-v11',
    center:[-0.6166700 , 38.8166700],
    zoom: 9
});
map.addControl(new mapboxgl.NavigationControl());

var newstring = [];

for ( var i in array) {
    newstring.push({
        type: 'Feature',
        geometry: 
            {
                type: 'Point',
                coordinates: [array[i].long,array[i].lat]
            },
        properties: {
                title:array[i].city,
                img: array[i].img
            }
        }
    )
}
// I use this function only for waiting the previous
charge_later_map(newstring);

function charge_later_map(string) {
    var geojson = {
            type: 'FeatureCollection',
            features: string       
    };

    geojson.features.forEach(function(marker) {
        var el = document.createElement('div');
        var string = marker.properties.img;
        el.className = "marker";
        new mapboxgl.Marker(el)
            .setLngLat(marker.geometry.coordinates)
            .setPopup(
                new mapboxgl.Popup({ offset: 25 }) // add popups
                .setHTML( 
                    `<h4>${marker.properties.title}</h4>`+
                    `<img style="width:100%;height:100px" src="${string}"/>`+
                    `<button id='button_send' data-id=`+marker.properties.title+`><i class="fas fa-hand-point-right fa-2x"></i> Show <i class="fas fa-hand-point-left fa-2x"></i></button>`)
            )
            .addTo(map);
        });
     }
}

//This button is in list map and paint the cars which are in this location
function redirect_button_map() {
    $(document).on('click','#button_send',function () {
        Array.from($('div.card.mb-3')).forEach(element => {
            if (element.style.border == "2px solid red") {
               element.style.border = "1px solid rgba(0,0,0,.125)";
               element.style.background = "rgb(58, 54, 54)";
            }
       })
        var map_data = this.getAttribute('data-id');

        Array.from($('div.card.mb-3')).forEach(element => {
             if (element.getAttribute('city_car') == map_data) {
                element.style.border = "2px solid red";
                element.style.background = "#766f6f";
                console.log(element);
             }
        })
    });
}
//The list on shop
function select_all_cars(index = 0) {
    $('#all_shop').empty();
    var filter_home = JSON.parse(localStorage.getItem('filtro_research'));
    var filter = JSON.parse(localStorage.getItem('filtro'));
    var location = JSON.parse(localStorage.getItem('location'));

    if (location) {
        index = location.pag;
    }

    if (filter_home || !filter || $.isEmptyObject(filter)) {
         var filter = filter_home;
         localStorage.removeItem('filtro_research');
         localStorage.setItem('filtro',JSON.stringify(filter));
    }

    if (!filter || $.isEmptyObject(filter)) {
        url = 'shop/controller/controller_shop.php?option=all';
     } 
    else {
         url = 'shop/controller/controller_shop.php?option=filtered_out';
    
        const urlParams = new URLSearchParams(url);
        for (var i in filter) {
            // obj.hasOwnProperty() se usa para filtrar propiedades de la cadena de prototipos del objeto
            if (filter.hasOwnProperty(i)) {

                urlParams.append(`${i}`,`${filter[i]}`);

            }
        }
        url = urlParams.toString().replace('%2F','/');
        url = url.replace('%2F','/');
        url = url.replace('%3F','?');

    }
    data = {limit: index};
    $.when(
        ajaxPromise(url,'POST', 'JSON',data)
        .then(function(data) {
            var ciudades = [];
            $('div#map').remove();
        for (row in data) {
            $('<div></div>').attr({'id':'shopid-'+data[row].id,'class':'card mb-3','city_car':data[row].ciudad}).appendTo('#all_shop');
            $('<div></div>').attr({'id':'row-'+data[row].id,'class':'row g-0'}).appendTo('#shopid-'+data[row].id);

            $('<div></div>').attr({'id':'img-'+data[row].id,'class':'col-md-6'}).appendTo('#row-'+data[row].id);
            $('<img></img>').attr('src',data[row].img).appendTo('#img-'+data[row].id);

            
            $('<div></div>').attr({'id':'div-'+data[row].id,'class':'col-md-6'}).appendTo('#row-'+data[row].id);
            $('<div></div>').attr({'id':'data-'+data[row].id,'class':'card-body'}).appendTo('#div-'+data[row].id);
            $('<h4></h4>').attr('id','data-car'+data[row].id).html(data[row].brand_car+" "+data[row].model_car).appendTo('#data-'+data[row].id);


            $('<div></div>').attr({'id':'text-'+data[row].id}).html('<p>'+data[row].kilometres+'km</p><p>'+data[row].price+'€</p>').appendTo('#data-'+data[row].id);
            $('<img></img>').attr({'src':data[row].bodywork,'class':'img_bodywork'}).appendTo('#data-'+data[row].id);
            $('<button></button>').attr({'id':+data[row].id,'class':'button_redirect','dataId':data[row].id}).html("<i class='fas fa-eye fa-2x'></i>").appendTo('#data-'+data[row].id);
            
            $('<i></i>').attr({'id':'like','class':'fas fa-heart fa-2x','data-colour':0,'data-id':data[row].id}).appendTo('#data-'+data[row].id);

            ciudades.push({lat:data[row].lat,long:data[row].long,city:data[row].ciudad,img:data[row].img});

            charge_all_likes(); //No carga al hacer pagination
        }
            $('<div></div>').attr({'id':'map','style':'width:100%;height:100%'}).appendTo('#map_cars');
            map_array(ciudades);

            $('<div></div>').attr({'id':'counter','data-id':index,'display':'none'}).appendTo('#all_shop');

            $('<div></div>').attr({'id':'navegator'}).appendTo('#all_shop');

            $('<button></button>').attr('id','previus').html('<i class="fas fa-angle-double-left"></i>').appendTo('#navegator');
            $('<button></button>').attr('id','next',).html('<i class="fas fa-angle-double-right"></i>').appendTo('#navegator');

        }).catch(function() {
            window.location.href = "index.php?exceptions=controller&option=503";

        })
    ).then(element => {
        if (location) {
            window.scroll(0,location.y);
            localStorage.removeItem('location');
        } 
    });
    //When the page is 100%,we redirect to the y position
    }
    //For return if of list at detail
function return_detail() {
    $(document).on('click','#return',function () {
        $('div#one_product').attr('hidden','true');
        $('div#all_shop')[0].removeAttribute('hidden');
        $('div.dark-bg')[0].removeAttribute('hidden');
        $('div#filters')[0].removeAttribute('hidden');
        $('body').css('background-color','black');
        $('body').css('background-image','');
        $('div#one_product').empty();
    });
}
//Function for redirecting in more cars
function redirect_more_cars() {
    $(document).on('click','.img_redirect',function () {
        var data =  this.id;
        var pag = JSON.parse(localStorage.getItem('pag'));
        pag = pag/5;
        while ( pag > 0) {
            $('#previus').trigger('click');
            pag--;
        }
        reload(data);
    })
}
function reload(data) {
    if ($('button#'+data).length == 1) {
        $('#return').trigger('click');
        $('button#'+data).trigger('click');
        select_all_cars();
    } else {
        $.when($('#next').trigger('click')).then(element => {reload(data);});
    }
}

function charge_all_likes() {
    var token = JSON.parse(localStorage.getItem('token'));
    if (token) {
        var data = {"info_token":token};
        ajaxPromise('shop/controller/controller_shop.php?option=charge_all_likes','POST','JSON',data)
        .then(function(data) {
            for (i in data) {
                $('div#div-'+data[i].car+' i#like').css('color','red');
                $('div#div-'+data[i].car+' i#like').attr('data-colour','1');
            }
        }).catch(function() {
            window.location.href = "index.php?exceptions=controller&option=503";
        });  
    }
    
}

//Details
function detect_log() {
    $('span#logger').trigger('click');
}
function select_detail_car() {
    $(document).on('click','.button_redirect',function () {
        var token = JSON.parse(localStorage.getItem('token'));
        save_position();
        if (token) {
            var data = this.getAttribute('dataId');
            var info;
            ajaxPromise('shop/controller/controller_shop.php?option=one_car&data='+data, 
            'GET', 'JSON')
            .then(function(car) {
                $('div#one_product')[0].removeAttribute('hidden');
                $('div#all_shop').attr('hidden','true');
                $('div.dark-bg').attr('hidden','true');
                $('div#filters').attr('hidden','true');
                $('body').css('background-color','');
                $('body').css('background-image','');

                    $('<button></button>').attr({'id':'return'}).html("<i class='fas fa-caret-square-left fa-2x'></i>").appendTo('#one_product');
                    $('<h2></h2>').html(car[0].brand_car+" "+car[0].model_car).appendTo('#one_product');
                    $('<h2></h2>').attr('class','price').html(car[0].price+'€').appendTo('#one_product');
                    $('<div></div>').attr({'id':'img-'+car[0].id,'class':'slider_into'}).appendTo('#one_product');
                    $('<div></div>').attr('id','data-detail').html('<table><tr><td><i class="fas fa-fire fa-2x"></i><h3>'+car[0].CV+'CV</h3></td><td><i class="fas fa-road fa-2x"></i><h3>'+car[0].kilometres+'km</h3></td></tr><tr><td><i class="fas fa-calendar fa-2x"></i><h3>'+car[0].date+'</h3></td><td><i class="fas fa-car fa-2x"></i><h3>'+car[0].categories+'</h3></td></tr><tr><td><i class="fas fa-gas-pump fa-2x"></i><h3>'+car[0].type+'</h3></td><td><i class="fas fa-palette fa-2x"></i><h3>'+car[0].color+'</h3></td></tr></table>').appendTo('#one_product');
                    $('<h2></h2>').html(car[0].car_plate+" "+car[0].frame_number).appendTo('#one_product');

                    //It depens of the or heart has colour
                    if ($('div#div-'+car[0].id+' i#like').attr('data-colour') == 1) {
                        $('<i></i>').attr({'id':'like_detail','class':'fas fa-heart fa-2x','data-colour':1,'data-id':car[0].id}).css('color','red').appendTo('#one_product');
                    } else {
                        $('<i></i>').attr({'id':'like_detail','class':'fas fa-heart fa-2x','data-colour':0,'data-id':car[0].id}).appendTo('#one_product');
                    }

                    $('<textarea></textarea').attr('readonly','true').html(car[0].description).appendTo('#one_product');
                    //maps
                    $('<div></div>').attr({'id':'map','style':'width:300px;height:700px;position:absolute;top:0%;left:-30%'}).appendTo('#one_product');
                    map(car[0].lat,car[0].long,car[0].ciudad);
                    $('<div></div>').attr({'id':'relation_cars','style':'width:300px;background-color:transparent;display: inline-flex;flex-wrap: wrap;overflow-y: scroll;height:500px;position:absolute;top:0%;right:-30%'}).appendTo('#one_product');
                    
                    info = {brand: car[0].brand_car};
                    ajaxPromise('shop/controller/controller_shop.php?option=relation_car', 
                    'POST', 'JSON',info)
                        .then(function(img_car) {
                            for (rdo in img_car) {
                                $('<img></img>').attr({'id':img_car[rdo].id,'src':img_car[rdo].img,'class':'img_redirect','width':'100%','height':'150px'}).appendTo('#relation_cars');
                            }
                        }).catch(function() {
                            window.location.href = "index.php?exceptions=controller&option=503";
                        });

                if (car[1][0] == -1) {
                    $('<img></img>').attr({'id':car[1][0],'src':car[1][1]}).appendTo('.slider_into');
                } else {
                    for (row in car) {
                        $('<img></img>').attr({'id':car[1][row].id,'src':car[1][row].img}).appendTo('.slider_into');
                        
                    }
                }

                $('.slider_into').slick();

                $('.slick-prev').css({'left':'0px','z-index':'110'});
                $('.slick-next').css({'right':'0px','z-index':'110'});
            }).catch(function() {
                window.location.href = "index.php?exceptions=controller&option=503";
    
            });
        }else {
            toastr.error("First,you need login In");
            setTimeout(function(){detect_log()},1000); 
        }
        });
  };
// this funnction is only to charge the filters
function filters() {
    load_filters();
};

function load_filters() {
    ajaxPromise('shop/controller/controller_shop.php?option=filter','GET','JSON')
    .then(function(car) {
        
        //filters #brand
        $('<div></div>').attr({'id':'brand','class':'brand'}).appendTo('#filters');
        $('<label></label>').attr('id','text').html("Marca").appendTo('#brand');
        $('<select></select>').attr({'id':'select_brand','class':'select_brand'}).appendTo('#brand');
        $('<option></option>').attr({'id':'none','class':'option_brand','value':'0'}).html("--").appendTo('#select_brand');
        for (row in car[0]) {
            $('<option></option>').attr({'id':'id'+car[0][row].id,'class':'option_brand','value':car[0][row].brand}).html(car[0][row].brand).appendTo('#select_brand');
        }
        // #model
        $('<div></div>').attr({'id':'model','class':'model'}).appendTo('#filters');
        $('<label></label>').attr('id','text').html("Modelo").appendTo('#model');
        $('<select></select>').attr({'id':'select_model','class':'select_model'}).appendTo('#model');
        $('<option></option>').attr({'id':'none','class':'option_model','value':'0'}).html("--").appendTo('#select_model');
       
        $(document).on('click','.select_brand',function () {
            var brand = document.getElementById('select_brand').value;
            $('select#select_model').empty();
            if (brand == 0) {
                $('<option></option>').attr({'id':'none','class':'option_model','value':'0'}).html("--").appendTo('#select_model');
            } else {
                ajaxPromise('shop/controller/controller_shop.php?option=filter_model&brand='+brand,'GET','JSON')
                    .then(function(model) {
                        $('<option></option>').attr({'id':'none','class':'option_model','value':'0'}).html("--").appendTo('#select_model');
                        for ( row in model) {
                            $('<option></option>').attr({'id':'id'+model[row].id,'class':'option_brand','value':model[row].model_car}).html(model[row].model_car).appendTo('#select_model');
                        }
                        }).catch(function() {
                        window.location.href = "index.php?exceptions=controller&option=503";
                    });
            }
        });
        // #km
        $('<div></div>').attr({'id':'km','class':'km'}).appendTo('#filters');
        $('<label></label>').attr('id','text').html("Kilometros").appendTo('#km');
        $('<select></select>').attr({'id':'select_km','class':'select_km'}).html(
            "<option id='none' value=0>--</option><option value=1>0-4999</option><option value=2>5000-29999</option><option value=3>30000-89999</option><option value=4>90000+</option>"
        ).appendTo('#km');
       

        // #Precio
        $('<div></div>').attr({'id':'price','class':'price'}).appendTo('#filters');
        $('<label></label>').attr('id','text').html("Precio").appendTo('#price');
        $('<label></label>').attr('id','no-text').html("Desde").appendTo('#price');
        $('<input></input>').attr({'id':'in_input','class':'price_input'}).appendTo('#price');
        $('<label></label>').attr('id','no-text').html("Hasta").appendTo('#price');
        $('<input></input>').attr({'id':'out_input','class':'price_input'}).appendTo('#price');


        // #tipo

        $('<div></div>').attr({'id':'type','class':'type'}).appendTo('#filters');
        $('<label></label>').attr('id','text').html("Motor").appendTo('#type');
        $('<select></select>').attr({'id':'select_type','class':'select_type'}).appendTo('#type');
        $('<option></option>').attr({'id':'none','class':'option_type','value':'0'}).html("--").appendTo('#select_type');
        for (row in car[1]) {
            $('<option></option>').attr({'id':'id'+car[1][row].id,'class':'option_type','value':car[1][row].id}).html(car[1][row].nom).appendTo('#select_type');
        }
        // #categories

        $('<div></div>').attr({'id':'categories','class':'categories'}).appendTo('#filters');
        $('<label></label>').attr('id','text').html("Categoria").appendTo('#categories');
        $('<select></select>').attr({'id':'select_categories','class':'select_categories'}).appendTo('#categories');
        $('<option></option>').attr({'id':'none','class':'option_categories','value':'0'}).html("--").appendTo('#select_categories');

        for (row in car[2]) {
            $('<option></option>').attr({'id':'id'+car[2][row].id,'class':'option_categories','value':car[2][row].id}).html(car[2][row].nom).appendTo('#select_categories');
        }

        // #carrocería
        $('<div></div>').attr({'id':'bodywork','class':'bodywork'}).appendTo('#filters');
        $('<label></label>').attr('id','text').html("Carroceria").appendTo('#bodywork');        
        for (row in car[3]) {
            $('<img></img>').attr({'id':'img-'+car[3][row].id,'class':'img_bodywork_2','valueid':car[3][row].id,'src':car[3][row].bodywork}).appendTo('#bodywork');
        }

        // #button

        $('<button></button>').attr({'id':'button_filter','class':'btn btn-dark'}).html("Aplicar").appendTo('#filters');

        var filter = JSON.parse(localStorage.getItem('filtro'));

        // Highlights
        if (filter) {
            if (filter.marca) {
                $('select#select_brand_header').val(filter.marca);
                $('select#select_brand').val(filter.marca);
            };
            if (filter.tipo) {
                $('select#select_type_header').val(filter.tipo);
                $('select#select_type').val(filter.tipo);
            };
            if (filter.categoria) {
                $('select#select_categories').val(filter.categoria);

            };
            if (filter.ciudad) {
                $('input#autocom').val(filter.ciudad);
            }
    }
    }) .catch(function() {
        window.location.href = "index.php?exceptions=controller&option=503";
    });
};
function bodywork_marc() {

    $(document).on('click','.img_bodywork_2',function () {
        var id = this.id;
        if ( document.getElementById(id).style.opacity == 1 ) {

            document.getElementById(id).style.opacity = 0.2;
        } else {
            document.getElementById(id).style.opacity = 1;
        }
    });
}
function charge_filters() {
    $(document).on('click','#button_filter',function () {
        var filtro = {};
        //checkeo de que las partes del objeto se cumplen
        var brand = $('#filters select#select_brand').val();
        if (brand != 0 ) {
            brand = {marca: brand};
            filtro = Object.assign(filtro,brand)
        }
        var model = $('#filters select#select_model').val();
        if (model != 0) {
            model = {modelo: model};
            filtro = Object.assign(filtro,model)
        } 
        var km = $('#filters select#select_km').val();
        if (km != 0) {
            km = {kilometros: km};
            filtro = Object.assign(filtro,km)
        } 
        var price_1 = $('#filters input#in_input').val();
        if (price_1 != "") {
            price_1 = {precio_1: price_1};
            filtro = Object.assign(filtro,price_1)
        } 
        var price_2 = $('#filters input#out_input').val();
        if (price_2 != "") {
            price_2 = {precio_2: price_2};
            filtro = Object.assign(filtro,price_2)
        } 
        var type = $('#filters select#select_type').val();
        if (type != 0) {
            type = {tipo: type};
            filtro = Object.assign(filtro,type)
        } 
        var categories = $('#filters select#select_categories').val();
        if (categories != 0) {
            categories = {categoria: categories};
            filtro = Object.assign(filtro,categories)
        } 
        var bodywork;

        Array.from($('#filters div#bodywork img')).forEach(element => {
        

          if (element.style.opacity == 1 ) {
              bodywork =element.getAttribute('valueid');
              bodywork = {carroceria: bodywork};
              filtro = Object.assign(filtro,bodywork)
            };
        });
        // Guardamos el filtro en localstorage
       localStorage.setItem('filtro',JSON.stringify(filtro));
       
       select_all_cars();

    })
}
function filter_count() {
    
    $(document).on('click','.button_redirect',function () {
        var update = {update:this.getAttribute('dataid')};
        ajaxPromise('shop/controller/controller_shop.php?option=update_count','POST','JSON',update)
        .then(function(data) {
        }).catch(function() {
            window.location.href = "index.php?exceptions=controller&option=503";
        });    
    })
}
function order_change() {
    $(document).on("change","#search_order",function() {
        var value = this.value;
        var filtro = {};
      
        order = {ordenar: value};
        filtro = Object.assign(filtro,order);
        localStorage.setItem('filtro_home',JSON.stringify(filtro));
     })

}
function button_pagination() {
    $(document).on('click','#previus ',function () {
        var pag = JSON.parse(localStorage.getItem('pag'));
        if (!pag) {
            pag = 0;
            localStorage.setItem('pag',JSON.stringify(pag)); 
        }
        pag = Number(pag)-5;
        if (pag < 1) {
            pag = 0;
        }
        localStorage.setItem('pag',JSON.stringify(pag));
        select_all_cars(pag)
    });
    $(document).on('click','#next',function () {
        var pag = JSON.parse(localStorage.getItem('pag'));
        if (!pag) {
            pag = 0;
            localStorage.setItem('pag',JSON.stringify(pag)); 
        }
        ajaxPromise('shop/controller/controller_shop.php?option=count','POST','TEXT')
            .then(function(data) {
                pag = Number(pag)+5;
                if (pag >= data) {
                    pag = data-(data-5);
                }
                localStorage.setItem('pag',JSON.stringify(pag));
                select_all_cars(pag);            
            }).catch(function() {
                window.location.href = "index.php?exceptions=controller&option=503";
            });   
    });
}
function save_position() {
    var y = window.scrollY;
    var pag = JSON.parse(localStorage.getItem('pag'));
    if (!pag) {
        pag = 0;
    }
    var location = {"y":y,"pag":pag};
    localStorage.setItem('location',JSON.stringify(location));
}
function like() {
    $(document).on('click','#like',function () {
        save_position();
        var id = this.getAttribute('data-id');
        var color =this.getAttribute('data-colour');
        var token = JSON.parse(localStorage.getItem('token'));

        if (token) {
            var data = {"info-id": id,"info-color": color,"token":token};
            ajaxPromise('shop/controller/controller_shop.php?option=check_like','POST','TEXT',data)
            .then(function(check) {
            console.log(check);
            }).catch(function() {
                window.location.href = "index.php?exceptions=controller&option=503";
            });   

            if (this.getAttribute('data-colour') == 0) {
                $(this).attr('style','color:red');
                $(this).attr('data-colour',1);
            } else {
                $(this).attr('style','color:white');
                $(this).attr('data-colour',0);
            }
        }else{
            toastr.error("First,you need login In");
            setTimeout(function(){detect_log()},1000); 
        }
    });
    
}
function like_detail() {
    $(document).on('click','#like_detail',function () {
        var id = this.getAttribute('data-id');
        $('div#div-'+id+' i#like').trigger('click');

        if (this.getAttribute('data-colour') == 0) {
            $(this).attr('style','color:red');
            $(this).attr('data-colour',1);
        } else {
            $(this).attr('style','color:white');
            $(this).attr('data-colour',0);
        }
    });
} 
$(window).on("load", function (e) {

    localStorage.removeItem('filtro');
    localStorage.removeItem('pag');


    $(document).ready(function () {
        select_all_cars();
        select_detail_car();
        return_detail();
        filters();
        bodywork_marc();
        charge_filters();
        redirect_button_map();
        filter_count();
        order_change();
        button_pagination();
        redirect_more_cars();
        like();
        like_detail();
    });

})

