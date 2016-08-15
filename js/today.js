// JavaScript Document
function print_today() {
  var now = new Date();
  var months = new Array('01','02','03','04','05','06','07','08','09','10','11','12');
  var date = ((now.getDate()<10) ? "0" : "")+ now.getDate();
  function fourdigits(number) {
    return (number < 1000) ? number + 1900 : number;
  }
  var today =  months[now.getMonth()] + "/" +date+ "/" + (fourdigits(now.getYear()));
  return today;
}