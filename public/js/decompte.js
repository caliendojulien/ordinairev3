function updateMidi(date, userId, value) {
    let xhr = new XMLHttpRequest();
    let data = "userId=" + userId + '&date=' + date + '&value=' + value.checked;
console.log(data)
    xhr.open('POST', '/stagiaire/addMidi')
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
    xhr.send(data);
}

function updateSoir(date, userId, value) {
    let xhr = new XMLHttpRequest();
    let data = "userId=" + userId + '&date=' + date + '&value=' + value.checked;

    xhr.open('POST', '/stagiaire/addSoir')
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
    xhr.send(data);
}