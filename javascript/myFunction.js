function get_cur_date() {
    let myDate = new Date();
    let myDateString = myDate.getFullYear() + "-" + (myDate.getMonth()+1) + "-" + myDate.getDate() + " ";
    myDateString = myDateString + myDate.getHours() + ":" + myDate.getMinutes() + ":" + myDate.getSeconds();
    return myDateString;
}
function auth (get_url, location_url) {
    axios({
        method: 'GET',
        url: get_url,
        async:false,
    })
    .then(function (res) {
        // console.log(res);
        if (res.data.auth == 'none') {
            window.location.href = location_url;
        } else if (res.data.auth == 'pass') {
            console.log('身份验证成功');
            console.log(res.data.user_name);
            console.log(res.data.user_password);
        }
    })
    .catch(function (err) {
        console.log(err);
    })
}