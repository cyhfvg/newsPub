function get_cur_date() {
    let myDate = new Date();
    let myDateString = myDate.getFullYear() + "-" + (myDate.getMonth()+1) + "-" + myDate.getDate() + " ";
    myDateString = myDateString + myDate.getHours() + ":" + myDate.getMinutes() + ":" + myDate.getSeconds();
    return myDateString;
}