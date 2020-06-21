let v = new Vue(
    {
        el: "#v-select",
        data: {
            content: "",
            country: "",
            city: "",
            cityList: [],
            currentIndex: -1,
            queryIndex_: 0,
            handle_: null},
        methods: {
            getIndex(){return this.queryIndex_++;},},
        watch: {
            country: function(){this.city = "";},
            city: debouncedGetCities,},
    });

function debouncedGetCities()
{
    if (this.handle_ !== null)
        clearTimeout(this.handle_);
    this.handle_ = setTimeout(() =>
    {
        getCities();
        this.handle_ = null;
    }, 500);

    function getCities()
    {
        if (v.cityList.includes(v.city))
            return;

        let index = v.getIndex();
        $.getJSON(
            "cities.php",
            {
                country: v.country,
                city: v.city,},
            function(result)
            {
                if (index > v.currentIndex)
                {
                    v.currentIndex = index;
                    v.cityList = result;
                }
            });
    }
}

if ("search" in data)
    data.search.callbacks.push(self =>
    {
        if (!$(".browse-advanced .action").is(self))
            v.content = v.country = "";
    });

data.setSelect = function(o)
{
    v.content = o.content[0].toUpperCase() + o.content.substr(1);
    v.country = o.country;
    $(document).ready(() =>
    {
        v.city = o.city;
        v.cityList = [v.city];
    });
};