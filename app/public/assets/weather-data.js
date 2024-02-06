function bindFindCityBtn(inputCity, selectCity, opencagedataKey) {
    let findCityBtn = document.getElementById('find-city-btn');

    findCityBtn.addEventListener('click', async () => {
        if (inputCity.value !== '') {
            inputCity.classList.add('visually-hidden');
            selectCity.classList.remove('visually-hidden');

            let cityDataArray = await getCityData(inputCity.value, opencagedataKey, selectCity);
            setGeoData(selectCity, cityDataArray);
        } else {
            alert('Input your city, please!')
        }
    });
}

async function getCityData(city, opencagedataKey, selectCity) {
    let cityDataArray = [];

    try {
        let response = await fetch(`https://api.opencagedata.com/geocode/v1/json?q=${city}&key=${opencagedataKey}`);
        let data = await response.json();

        data.results.forEach(result => {
            cityDataArray.push(result);
            let option = document.createElement('option');
            option.value = result.formatted;
            option.textContent = result.formatted;
            selectCity.appendChild(option);
        });
    } catch (error) {
        console.error('Error fetching city data:', error);
    }

    return cityDataArray;
}

function setGeoData(selectCity, cityDataArray) {
    let latitude = document.getElementById('latitude');
    let longitude = document.getElementById('longitude');

    selectCity.addEventListener('change', () => {
        let selectedCity = selectCity.options[selectCity.selectedIndex].value;
        cityDataArray.forEach(cityData => {
            if (cityData.formatted === selectedCity) {
                latitude.value = cityData.geometry.lat;
                longitude.value = cityData.geometry.lng;
            }
        });
    });
}