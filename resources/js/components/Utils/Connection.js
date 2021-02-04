export function postServer(path, body, success, fail, setLoading){
    const token = $('meta[name="csrf-token"]').attr("content");
    setLoading(true);
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
            setLoading(false);
        })
        .catch(error => {
            fail(error);
            setLoading(false);
        });
}

export function testCSRF(){
    const token = $('meta[name="csrf-token"]').attr("content");
    console.log(token);
}
