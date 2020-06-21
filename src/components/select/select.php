<div id="v-select" class="select">
    <label>
        <span>Content</span>
        <select name="content" v-model="content">
            <option value="">-- Choose an option --</option>
            <option>Scenery</option>
            <option>City</option>
            <option>People</option>
            <option>Animal</option>
            <option>Building</option>
            <option>Wonder</option>
            <option>Other</option>
        </select>
    </label>
    <div class="location">
        <label>
            <span>Country/Region</span>
            <select name="country" v-model="country">
                <option value="">-- Choose an option --</option>
                <?php
                require "mysqli.php";
                $sql = "SELECT ContinentCode, ContinentName FROM geocontinents";
                $continents = $mysqli->query($sql)->fetch_all();
                $sql = "SELECT Country_RegionName FROM geocountries_regions WHERE Continent = ?";
                $stmt = $mysqli->prepare($sql);
                foreach ($continents as $continent)
                {
                    echo <<< HTML
                    <optgroup label="$continent[1]">

HTML;
                    $stmt->bind_param("s", $continent[0]);
                    $stmt->execute();
                    $countries = $stmt->get_result()->fetch_all();

                    foreach ($countries as $country)
                    {
                        echo <<< HTML
                        <option>$country[0]</option>

HTML;
                    }

                    echo <<< HTML
                    </optgroup>

HTML;
                }
                ?>
            </select>
        </label>
        <label v-if="country">
            <span>City</span>
            <input type="text" name="city" list="city" v-model="city">
            <datalist id="city">
                <option v-for="option in cityList">{{ option }}</option>
            </datalist>
        </label>
    </div>
</div>