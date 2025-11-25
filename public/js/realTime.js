function updateTime() {
    const clockElement = document.getElementById('clock');
    const now = new Date();

    let hours = now.getHours();
    const minutes = now.getMinutes();
    const seconds = now.getSeconds();
    const amPm = hours >= 12 ? 'PM' : 'AM';

    hours = hours % 12;
    hours = hours ? hours : 12; 

    const formattedTime = `${padZero(hours)}:${padZero(minutes)}:${padZero(seconds)} ${amPm}`;
    clockElement.textContent = formattedTime;
}

function padZero(number) {
    return number < 10 ? '0' + number : number;
}

setInterval(updateTime, 1000);
updateTime();
