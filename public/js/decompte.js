
function addWeekMidi(userId,value) {
    const headers = new Headers({
        "Content-Type": "application/x-www-form-urlencoded"
    });

    const data = new URLSearchParams({
        'userId' : userId,
        'value' : value.checked,
        'date' : date
    });

    const opts = {
        method: 'POST',
        headers: headers,
        body: data
    };

    fetch("/chefDeSection/addWeekMidi", opts);
}

function addWeekSoir(userId,value) {
    const headers = new Headers({
        "Content-Type": "application/x-www-form-urlencoded"
    });

    const data = new URLSearchParams({
        'userId' : userId,
        'value' : value.checked,
        'date' : date
    });

    const opts = {
        method: 'POST',
        headers: headers,
        body: data
    };

    fetch("/chefDeSection/addWeekSoir", opts);
}

function updateMidi(date, userId, value) {
    const headers = new Headers({
        "Content-Type": "application/x-www-form-urlencoded"
    });

    const data = new URLSearchParams({
        'userId' : userId,
        'value' : value.checked,
        'date' : date
    });

    const opts = {
        method: 'POST',
        headers: headers,
        body: data
    };

    fetch("/stagiaire/addMidi", opts);
}

function updateSoir(date, userId, value) {
    const headers = new Headers({
        "Content-Type": "application/x-www-form-urlencoded"
    });

    const data = new URLSearchParams({
        'userId' : userId,
        'value' : value.checked,
        'date' : date
    });

    const opts = {
        method: 'POST',
        headers: headers,
        body: data
    };

    fetch("/stagiaire/addSoir", opts);
}