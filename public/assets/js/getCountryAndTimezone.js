function fillTimezone(countrySelect, selectedTimezone, key) {
    countrySelect.addEventListener('change', function () {
        let selectedOption = countrySelect.options[countrySelect.selectedIndex];
        let countryCode = selectedOption.value;
        let params = new URLSearchParams();
        params.append('key', key);
        params.append('format', 'json');
        params.append('country', countryCode);
        fetch('https://api.timezonedb.com/v2.1/list-time-zone?' + params)
            .then(response => response.json())
            .then(data => {
                let zones = data.zones;
                zones.forEach(zone => {
                    let option = document.createElement("option");
                    option.textContent = zone.zoneName;
                    selectedTimezone.appendChild(option);
                });
            });
    });
}

function getTimeZone(selectedTimezone) {
    let userTimeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;
    let option = document.createElement("option");
    option.textContent = userTimeZone;
    selectedTimezone.appendChild(option);
}