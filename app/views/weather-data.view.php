<?php require "partials/head.php" ?>
<?php require "partials/nav.php" ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <form action="/weather" method="post">
                <div class="form-control my-1 shadow p-3">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="text-center p-1">City</h3>
                            <div class="input-group">
                                <input type="text" name="city" class="form-control" placeholder="Input your city"
                                       id="input-city" value="<?= $city ?? '' ?>" required>
                                <select name="select-city" class="visually-hidden form-select"
                                        id="select-city">
                                    <option value="">Choose your city</option>
                                </select>
                                <div class="input-group-append">
                                    <a class="btn btn-primary" id="find-city-btn">Find</a>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="latitude" id="latitude" value="<?= $latitude ?? '' ?>">
                        <input type="hidden" name="longitude" id="longitude" value="<?= $longitude ?? '' ?>">
                        <div class="col-md-6">
                            <h3 class="text-center p-1">Forecast length</h3>
                            <select name="forecast-length" id="forecast-length" class="form-select m-2">
                                <option value="1" selected>1 day</option>
                                <option value="3">3 days</option>
                                <option value="7">7 days</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="form-control my-1 p-1 shadow">
                    <h3 class="text-center p-1">Values</h3>
                    <div class="row d-flex justify-content-around">
                        <div class="col-md-5 border rounded m-2 p-2">
                            <h5 class="text-center p-2">Daily</h5>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="daily-values[temperature_2m_max]"
                                       value="temperature_2m_max"
                                       id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Max temperature
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="daily-values[temperature_2m_min]"
                                       value="temperature_2m_min"
                                       id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Min temperature
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="daily-values[precipitation_sum]"
                                       value="precipitation_sum"
                                       id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Precipitation Sum
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="daily-values[precipitation_hours]"
                                       value="precipitation_hours"
                                       id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Precipitation Hours
                                </label>
                            </div>
                        </div>
                        <div class="col-md-5 border rounded m-2 p-2">
                            <h5 class="text-center p-2">Current</h5>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="current-values[temperature_2m]"
                                       value="temperature_2m" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Temperature
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"
                                       name="current-values[relative_humidity_2m]"
                                       value="relative_humidity_2m" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Relative Humidity
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="current-values[pressure_msl]"
                                       value="pressure_msl" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Pressure
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="current-values[cloud_cover]"
                                       value="cloud_cover" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Cloud Cover
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="current-values[wind_speed_10m]"
                                       value="wind_speed_10m" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Wind Speed
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="current-values[precipitation]"
                                       value="precipitation" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Precipitation
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="snowfall"
                                       value="current-values[snowfall]"
                                       id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Snowfall
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="rain" value="current-values[rain]"
                                       id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Rain
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-control my-1 shadow">
                    <div class="d-flex justify-content-center p-1">
                        <span class="p-1 fw-bold">Time execute</span>
                        <label class="form-label">
                            <input type="time" class="form-control" name="time-execute" required>
                        </label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        <div class="col-md-6">
            <div class="container">
                <table class="table">
                    <?php if (!empty($currentWeatherData)): ?>
                        <?php $columns = array_keys($currentWeatherData); ?>
                        <?php foreach ($columns as $columnName): ?>
                            <tr>
                                <th><?= $translator->trans($columnName) ?></th>
                                <th><?= $currentWeatherData[$columnName] ?></th>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </table>

                <table class="table">
                    <?php if (!empty($dailyWeatherData)): ?>
                        <?php $columns = array_keys($dailyWeatherData); ?>
                        <tr>
                            <?php foreach ($columns as $columnName): ?>
                                <th><?= $translator->trans($columnName) ?></th>
                            <?php endforeach; ?>
                        </tr>
                        <?php foreach ($dailyWeatherData[array_key_first($dailyWeatherData)] as $key => $value): ?>
                            <tr>
                                <?php foreach ($columns as $columnName): ?>
                                    <td><?= $dailyWeatherData[$columnName][$key] ?? '' ?></td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>
</div>
<?php require "partials/footer.php" ?>

<script src="public/assets/weather-data.js"></script>
<script>
    let inputCity = document.getElementById('input-city');
    let selectCity = document.getElementById('select-city');
    let opencagedataKey = "<?=$opencagedataKey ?? '' ?>";

    bindFindCityBtn(inputCity, selectCity, opencagedataKey);
</script>