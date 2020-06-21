<?php
session_start();
$logged = isset($_SESSION["user"]) ? "\"$_SESSION[user]\"" : "false";
if (isset($_SESSION["msg"]))
{
    $message = "\"$_SESSION[msg]\"";
    unset($_SESSION["msg"]);
}
else
    $message = "false";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Browse</title>
    <link rel="stylesheet" href="css/styles.css" media="all">
    <link rel='stylesheet' href='css/browse.css' media='all'>
    <script src="lib/jquery-3.5.1.min.js"></script>
    <script src="lib/vue.min.js"></script>
    <script>
        data = {
            logged: <?php
echo $logged;
?>
,
            message: <?php
echo $message;
?>
,};
        if (data.message)
            $(document).ready(function(){msgbox.setMessage(data.message);});
    </script>
</head>
<body>
<header id="v-header" class="header">
    <div class="info">
        <div v-if="logged">Logged in as <strong>{{ logged }}</strong></div>
        <div><time>{{ time }}</time></div>
    </div>
    <h1>Share Your Travels</h1>
    <nav>
        <ul class="site">
            <template></template>
            <li><a href="/">Home</a></li>
            <li><strong>Browse</strong></li>
            <template></template>
            <li><a href="search.php">Search</a></li>
            <li v-if="!(logged || excluded)"><a :href="location">Login</a></li>
            <li v-if="excluded"><strong>Login</strong></li>
        </ul>
        <div class="user" v-if="logged">
            <span>Me</span>
            <ul>
                <li><a href="upload.php">Upload</a></li>
                <li><a href="photos.php">My photos</a></li>
                <li><a href="favourites.php">Favourites</a></li>
                <li><a href="logout.php">Log out</a></li>
            </ul>
        </div>
    </nav>
</header>
<div id="v-msgbox" class="msgbox"><p v-if="message" v-html="message"></p></div>
<div class="browse-main">
    <main>
<section class="browse-advanced">
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
                                    <optgroup label="Africa">
                        <option>Angola</option>
                        <option>Burkina Faso</option>
                        <option>Burundi</option>
                        <option>Benin</option>
                        <option>Botswana</option>
                        <option>Democratic Republic of the Congo</option>
                        <option>Central African Republic</option>
                        <option>Republic of the Congo</option>
                        <option>Ivory Coast</option>
                        <option>Cameroon</option>
                        <option>Cape Verde</option>
                        <option>Djibouti</option>
                        <option>Algeria</option>
                        <option>Egypt</option>
                        <option>Western Sahara</option>
                        <option>Eritrea</option>
                        <option>Ethiopia</option>
                        <option>Gabon</option>
                        <option>Ghana</option>
                        <option>Gambia</option>
                        <option>Guinea</option>
                        <option>Equatorial Guinea</option>
                        <option>Guinea-Bissau</option>
                        <option>Kenya</option>
                        <option>Comoros</option>
                        <option>Liberia</option>
                        <option>Lesotho</option>
                        <option>Libya</option>
                        <option>Morocco</option>
                        <option>Madagascar</option>
                        <option>Mali</option>
                        <option>Mauritania</option>
                        <option>Mauritius</option>
                        <option>Malawi</option>
                        <option>Mozambique</option>
                        <option>Namibia</option>
                        <option>Niger</option>
                        <option>Nigeria</option>
                        <option>Reunion</option>
                        <option>Rwanda</option>
                        <option>Seychelles</option>
                        <option>Sudan</option>
                        <option>Saint Helena</option>
                        <option>Sierra Leone</option>
                        <option>Senegal</option>
                        <option>Somalia</option>
                        <option>South Sudan</option>
                        <option>Sao Tome and Principe</option>
                        <option>Swaziland</option>
                        <option>Chad</option>
                        <option>Togo</option>
                        <option>Tunisia</option>
                        <option>Tanzania</option>
                        <option>Uganda</option>
                        <option>Mayotte</option>
                        <option>South Africa</option>
                        <option>Zambia</option>
                        <option>Zimbabwe</option>
                    </optgroup>
                    <optgroup label="Antarctica">
                        <option>Antarctica</option>
                        <option>Bouvet Island</option>
                        <option>South Georgia and the South Sandwich Islands</option>
                        <option>Heard Island and McDonald Islands</option>
                        <option>French Southern Territories</option>
                    </optgroup>
                    <optgroup label="Asia">
                        <option>United Arab Emirates</option>
                        <option>Afghanistan</option>
                        <option>Armenia</option>
                        <option>Azerbaijan</option>
                        <option>Bangladesh</option>
                        <option>Bahrain</option>
                        <option>Brunei</option>
                        <option>Bhutan</option>
                        <option>Cocos Islands</option>
                        <option>China</option>
                        <option>Christmas Island</option>
                        <option>Georgia</option>
                        <option>Hong Kong</option>
                        <option>Indonesia</option>
                        <option>Israel</option>
                        <option>India</option>
                        <option>British Indian Ocean Territory</option>
                        <option>Iraq</option>
                        <option>Iran</option>
                        <option>Jordan</option>
                        <option>Japan</option>
                        <option>Kyrgyzstan</option>
                        <option>Cambodia</option>
                        <option>North Korea</option>
                        <option>South Korea</option>
                        <option>Kuwait</option>
                        <option>Kazakhstan</option>
                        <option>Laos</option>
                        <option>Lebanon</option>
                        <option>Sri Lanka</option>
                        <option>Myanmar</option>
                        <option>Mongolia</option>
                        <option>Macao</option>
                        <option>Maldives</option>
                        <option>Malaysia</option>
                        <option>Nepal</option>
                        <option>Oman</option>
                        <option>Philippines</option>
                        <option>Pakistan</option>
                        <option>Palestinian Territory</option>
                        <option>Qatar</option>
                        <option>Saudi Arabia</option>
                        <option>Singapore</option>
                        <option>Syria</option>
                        <option>Thailand</option>
                        <option>Tajikistan</option>
                        <option>Turkmenistan</option>
                        <option>Turkey</option>
                        <option>Taiwan</option>
                        <option>Uzbekistan</option>
                        <option>Vietnam</option>
                        <option>Yemen</option>
                    </optgroup>
                    <optgroup label="Europe">
                        <option>Andorra</option>
                        <option>Albania</option>
                        <option>Austria</option>
                        <option>Aland Islands</option>
                        <option>Bosnia and Herzegovina</option>
                        <option>Belgium</option>
                        <option>Bulgaria</option>
                        <option>Belarus</option>
                        <option>Switzerland</option>
                        <option>Serbia and Montenegro</option>
                        <option>Cyprus</option>
                        <option>Czech Republic</option>
                        <option>Germany</option>
                        <option>Denmark</option>
                        <option>Estonia</option>
                        <option>Spain</option>
                        <option>Finland</option>
                        <option>Faroe Islands</option>
                        <option>France</option>
                        <option>United Kingdom</option>
                        <option>Guernsey</option>
                        <option>Gibraltar</option>
                        <option>Greece</option>
                        <option>Croatia</option>
                        <option>Hungary</option>
                        <option>Ireland</option>
                        <option>Isle of Man</option>
                        <option>Iceland</option>
                        <option>Italy</option>
                        <option>Jersey</option>
                        <option>Liechtenstein</option>
                        <option>Lithuania</option>
                        <option>Luxembourg</option>
                        <option>Latvia</option>
                        <option>Monaco</option>
                        <option>Moldova</option>
                        <option>Montenegro</option>
                        <option>Macedonia</option>
                        <option>Malta</option>
                        <option>Netherlands</option>
                        <option>Norway</option>
                        <option>Poland</option>
                        <option>Portugal</option>
                        <option>Romania</option>
                        <option>Serbia</option>
                        <option>Russia</option>
                        <option>Sweden</option>
                        <option>Slovenia</option>
                        <option>Svalbard and Jan Mayen</option>
                        <option>Slovakia</option>
                        <option>San Marino</option>
                        <option>Ukraine</option>
                        <option>Vatican</option>
                        <option>Kosovo</option>
                    </optgroup>
                    <optgroup label="North America">
                        <option>Antigua and Barbuda</option>
                        <option>Anguilla</option>
                        <option>Netherlands Antilles</option>
                        <option>Aruba</option>
                        <option>Barbados</option>
                        <option>Saint Barthelemy</option>
                        <option>Bermuda</option>
                        <option>Bonaire, Saint Eustatius and Saba</option>
                        <option>Bahamas</option>
                        <option>Belize</option>
                        <option>Canada</option>
                        <option>Costa Rica</option>
                        <option>Cuba</option>
                        <option>Curacao</option>
                        <option>Dominica</option>
                        <option>Dominican Republic</option>
                        <option>Grenada</option>
                        <option>Greenland</option>
                        <option>Guadeloupe</option>
                        <option>Guatemala</option>
                        <option>Honduras</option>
                        <option>Haiti</option>
                        <option>Jamaica</option>
                        <option>Saint Kitts and Nevis</option>
                        <option>Cayman Islands</option>
                        <option>Saint Lucia</option>
                        <option>Saint Martin</option>
                        <option>Martinique</option>
                        <option>Montserrat</option>
                        <option>Mexico</option>
                        <option>Nicaragua</option>
                        <option>Panama</option>
                        <option>Saint Pierre and Miquelon</option>
                        <option>Puerto Rico</option>
                        <option>El Salvador</option>
                        <option>Sint Maarten</option>
                        <option>Turks and Caicos Islands</option>
                        <option>Trinidad and Tobago</option>
                        <option>United States</option>
                        <option>Saint Vincent and the Grenadines</option>
                        <option>British Virgin Islands</option>
                        <option>U.S. Virgin Islands</option>
                    </optgroup>
                    <optgroup label="Oceania">
                        <option>American Samoa</option>
                        <option>Australia</option>
                        <option>Cook Islands</option>
                        <option>Fiji</option>
                        <option>Micronesia</option>
                        <option>Guam</option>
                        <option>Kiribati</option>
                        <option>Marshall Islands</option>
                        <option>Northern Mariana Islands</option>
                        <option>New Caledonia</option>
                        <option>Norfolk Island</option>
                        <option>Nauru</option>
                        <option>Niue</option>
                        <option>New Zealand</option>
                        <option>French Polynesia</option>
                        <option>Papua New Guinea</option>
                        <option>Pitcairn</option>
                        <option>Palau</option>
                        <option>Solomon Islands</option>
                        <option>Tokelau</option>
                        <option>East Timor</option>
                        <option>Tonga</option>
                        <option>Tuvalu</option>
                        <option>United States Minor Outlying Islands</option>
                        <option>Vanuatu</option>
                        <option>Wallis and Futuna</option>
                        <option>Samoa</option>
                    </optgroup>
                    <optgroup label="South America">
                        <option>Argentina</option>
                        <option>Bolivia</option>
                        <option>Brazil</option>
                        <option>Chile</option>
                        <option>Colombia</option>
                        <option>Ecuador</option>
                        <option>Falkland Islands</option>
                        <option>French Guiana</option>
                        <option>Guyana</option>
                        <option>Peru</option>
                        <option>Paraguay</option>
                        <option>Suriname</option>
                        <option>Uruguay</option>
                        <option>Venezuela</option>
                    </optgroup>
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
    <input class="action" type="button" value="Filter">
</section>
        <hr>
<section id="v-browse-result" class="browse-result">
    <div class="load-result" style="display:none" @click="loadResult"></div>
    <p v-if="photos.length === 0">No result found</p>
<div class="browse-crop" v-for="photo in photos"><a :href="'details.php?id=' + photo.id"><img :src="'/img/medium/' + photo.path" :alt="photo.path" :title="photo.title" :style="photo.style"></a></div>
</section>
<nav id="v-pages" class="pages" v-show="pages > 1">
    <div class="load-pages" style="display:none" @click="loadPages"></div>
    <div class="numbers">
        <template v-for="number in numbers">
            <input type="button" v-if="number" :class="(number === current) ? 'current' : ''" :value="number" @click="fetchPage($event)">
            <span v-else>...</span>
        </template>
    </div>
    <div class="operations">
        <input type="button" value="&lt; Prev" @click="fetchPage(current - 1)">
        <input type="button" value="Next &gt;" @click="fetchPage(current + 1)">
        <label>
            <span>Go to page:</span>
            <input type="number" v-model.number="toPage" :min="1" :max="pages">
            <input type="button" value="Go" @click="fetchPage(toPage)">
        </label>
    </div>
</nav>
    </main>
<aside id="v-browse-aside" class="browse-aside">
    <span>Filter by ...</span>
    <ul>
        <li>
            <label>
                <span>Title</span><br>
                <input type="search" name="title" v-model="title">
            </label>
            <input class="action" type="button" value="Filter" @click="search('title')">
        </li>
        <li>
            <span>Popular contents</span>
            <input type="button" v-for="content in contents" :value="content" @click="searchPop('content', $event)">
        </li>
        <li>
            <span>Popular countries/regions</span>
            <input type="button" v-for="country in countries" :value="country" @click="searchPop('country', $event)">
        </li>
        <li>
            <span>Popular cities</span>
            <input type="button" v-for="city in cities" :value="city" @click="searchPop('city', $event)">
        </li>
    </ul>
</aside>
</div>
<footer class="footer">19302010068@fudan.edu.cn</footer>
<script src='js/browse.js'></script>
</body>
</html>