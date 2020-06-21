window.msgbox = new Vue({
    el: "#v-msgbox",
    data: {message: ""},
    methods: {
        setMessage(msg)
        {
            this.message = msg;
            setTimeout(() => msgbox.message = "", 5000);
        },},
});