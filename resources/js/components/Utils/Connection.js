export function postServer(path, body, success, fail){
    const token = $('meta[name="csrf-token"]').attr("content");
    fetch(path,{
        method: 'POST',
        body: JSON.stringify(body),
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
        },
    })
        .then(res => res.json())
        .then(res => {
            console.log(res);
            success(res);
        })
        .catch(error => {
            fail(error);
        });
}

export function testCSRF(){
    const token = $('meta[name="csrf-token"]').attr("content");
    console.log(token);
}
