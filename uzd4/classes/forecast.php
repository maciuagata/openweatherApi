<?php

class Forecast
{

    public function __construct($data)
    {
        $this->city = $data["city"];
        $this->weather = $data["weather"];
    }
    private function renderProperty($key, $value)
    {
        $propString = "";
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                if (is_array($v)) {
                    $propString .= "<div class='sub-property'>";
                    $propString .= "<h5 class='sub-property-heading'>" . ucfirst($k) . "</h5>";

                    $propString .= "<span class='sub-property-body'>";
                    foreach ($v as $k2 => $v2) {
                        $cleaned = $this->clean($k2, $v2, isset($v["unit"]) ? $v["unit"] : null);
                        if ($cleaned) {
                            $propString .= $cleaned;
                        }
                    }
                    $propString .= "</span></div>";
                } else {
                    $cleaned = $this->clean($k, $v, isset($value["unit"]) ? $value["unit"] : null);
                    if ($cleaned) {
                        $propString .= "<span class='property-body-text'>";
                        $propString .= $cleaned;
                        $propString .= "</span>";
                    }
                }
            }
        } else {
            $propString .= "<span class='property-body'>";
            $propString .= $value;
            $propString .= "</span>";
        } ?>

        <li class="property-list-item d-block w-50">
            <div class="property ">
                <h3 class=" property-heading"> <?php echo ucfirst($key) ?></h3>
                <div class="property-body d-flex justify-content-between">
                    <?php echo $propString ?>
                </div>
            </div>
        </li>
    <?php }

    public function renderForecast()
    { ?>
        <div class="city-data">
            <h1 class='text-center mb-3'><?php echo $this->city['name'] ?></h1>
            <div class="d-flex justify-content-between align-items-start">
                <div class="coords w-50">
                    <h5>Latitude: <?php echo $this->city["coords"]["lat"] ?></h5>
                    <h5>Longitude: <?php echo $this->city["coords"]["lon"] ?></h5>
                </div>
                <div class="sun w-50">
                    <h5>Rise: <?php echo date("d.m.y H:i:s P", strtotime($this->city["sun"]["rise"])) ?></h5>
                    <h5>Set: <?php echo date("d.m.y H:i:s P", strtotime($this->city["sun"]["set"])) ?></h5>

                </div>
            </div>
        </div>
        <div class="weather mt-4">
            <h3 class="text-center">Weather</h3>
            <ul class="property-list d-flex w-100 flex-wrap">
                <?php
                foreach ($this->weather as $key => $value) {
                    $this->renderProperty($key, $value);
                } ?>

            </ul>
        </div>
<?php }

    private function clean($key, $value, $unit = null)
    {
        if ($key === "unit" || $key === "max" || $key === "min")
            return null;
        else if ($key === "value" && isset($unit))
            return $value . " " . $unit . " ";
        else if ($key === "value" || $key === "name" || $key === "code")
            return  $value . " ";
        else
            return $key . "=" . $value . " ";
    }
}