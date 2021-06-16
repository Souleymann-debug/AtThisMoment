$(document).ready(function(){

    let weatherWidget = $('#weather-widget');

    function getLocation(){
        if(navigator.geolocation){
            navigator.geolocation.getCurrentPosition(getWeather);
        }
        else{
            alert("Geolocation not supported by this browser");
        }
    }

    function getWeather(position){
        let lat = position.coords.latitude;
        let long = position.coords.longitude;
        let API_KEY = '46dfa70f1e6a28d2eeb645bf565af33e';
        let baseURL = `http://api.openweathermap.org/data/2.5/onecall?lat=${lat}&lon=${long}&lang=fr&appid=${API_KEY}`;


        $.get(baseURL,function(res){
            let data = res.current;
            let temp = Math.floor(data.temp - 273);
            let condition = data.weather[0].description;
            let icon = data.weather[0].icon;

            $('#temp-main').html(`${temp}°`);
            $('#condition').html(condition);
            weatherWidget.append(`<img src="http://openweathermap.org/img/wn/`+icon+`@2x.png" />`);
            getCity([lat, long]);
        })
    }

    getLocation();

    function getCity(coordinates) {
        var xhr = new XMLHttpRequest();
        var lat = coordinates[0];
        var lng = coordinates[1];
      
        // Paste your LocationIQ token below.
        xhr.open('GET', "https://us1.locationiq.com/v1/reverse.php?key=pk.11be845b0490df60e080ed0bc1f3b33b&lat=" +
            lat + "&lon=" + lng + "&format=json", true);
        xhr.send();
        xhr.onreadystatechange = processRequest;
        xhr.addEventListener("readystatechange", processRequest, false);
      
        function processRequest(e) {
            if (xhr.readyState == 4 && xhr.status == 200) {
                let response = JSON.parse(xhr.responseText);
                city = response.address.city !== undefined ? response.address.cit : response.address.village;
                if(!$('#city').length)
                    weatherWidget.append(`<span id="city">à `+ city +`</span>`);
                return;
            }
        }
    }
})
