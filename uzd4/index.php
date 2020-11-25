<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container py-5">
        <div class="row flex-column align-items-center">
            <div class="col-lg-8 col-md 8 col-sm-12 my-5">
                <div class="search">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <input type="text" name="search" class="form-control" value="<?php echo isset($_POST["search"]) ? htmlspecialchars($_POST["search"]) : "" ?>" >
                            </div>
                            <div class="col-sm-2">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-8 col-md 8 col-sm-12">
                <?php

                if ($_SERVER["REQUEST_METHOD"] == "POST") {

                    require_once "classes/xmlParser.php";
                    require_once "classes/api.php";
                    require_once "classes/forecast.php";

                    if (empty(trim($_POST["search"])))
                        echo "<h2 class='text-center'>City name is required</h2>";
                    else {

                        $response = $weather_api->getWeather(htmlspecialchars($_POST["search"]));
                        if ($response) {
                            $Forecast = new Forecast(XmlParser::parse($response));
                            $Forecast->renderForecast();
                ?>
                <?php } else {
                            echo "<h2 class='text-center'>City not found</h2>";
                        }
                    }
                } else {
                    echo "<h2 class='text-center'>Search a city</h2>";
                }

                ?>
            </div>
        </div>
    </div>

</body>

</html>

<?php