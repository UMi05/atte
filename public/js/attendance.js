function workin() {
    document.getElementById("btn1").disabled = true;
    document.getElementById("btn2").disabled = false;
    document.getElementById("btn3").disabled = false;
}

function workout() {
    document.getElementById("btn1").disabled = false;
    document.getElementById("btn2").disabled = true;
    document.getElementById("btn3").disabled = true;
    document.getElementById("btn4").disabled = true;
}

function breakin() {
    document.getElementById("btn3").disabled = true;
    document.getElementById("btn4").disabled = false;
}

function breakout() {
    document.getElementById("btn3").disabled = false;
    document.getElementById("btn4").disabled = true;
}