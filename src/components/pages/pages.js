const NUM_PER_PAGE = 8;

let v = new Vue(
    {
        el: "#v-pages",
        data: {
            pages: 1,
            current: 1,
            toPage: 1,},
        computed: {numbers},
        methods: {loadPages, fetchPage},
    });

function numbers()
{
    if (this.pages === 1)
        return [1];

    let result = [1, this.pages];
    for (let i = this.current - 2; i <= this.current + 2; i++)
        result.push(i);
    result = Array.from(new Set(result));
    result.sort((a, b) => a - b);
    let start = result.indexOf(1);
    let end = result.lastIndexOf(this.pages);
    result = result.slice(start, end + 1);

    if (result[1] - result[0] > 1)
    {
        result.unshift(null);
        result[0] = result[1];
        result[1] = null;
    }
    if (result[result.length - 1] - result[result.length - 2] > 1)
    {
        result[result.length] = result[result.length - 1];
        result[result.length - 2] = null;
    }
    return result;
}

function loadPages()
{
    this.current = 1;
    this.toPage = 1;

    let pages = Math.ceil(data.query / NUM_PER_PAGE);
    if (pages === 0)
    {
        this.pages = 1;
        data.query = [0, 0];
        $(".load-result").click();
    }
    else
    {
        this.pages = pages;
        fetchPage(1, true);
    }
}

function fetchPage(page, force=false)
{
    if (typeof page === "object")
        page = (Number)(page.target.value);
    if ((page < 1 || page > this.pages || page !== Math.floor(page) || page === this.current) && !force)
        return;

    this.current = page;
    data.query = [(page - 1) * NUM_PER_PAGE, page * NUM_PER_PAGE];
    $(".load-result").click();
}