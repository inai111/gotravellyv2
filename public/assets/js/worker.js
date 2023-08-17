self.addEventListener('message',message=>{
    let data = message.data;
    let headers = data.headers;
    headers['X-Requested-With']="Fetch";

    let response = {
        url:data.url
    };

    fetch(data.url,{
        headers:headers
    })
    .then(data=>{
        response['statusCode']=data.status;
        if(data.headers.get('ETag')) response['etag']=data.headers.get('ETag');
        if(data.status<300) return data.json();
        return Promise.resolve();
    })
    .then(data=>{
        if(data) response['body']=data;
    })
    .catch(err=>{
        response['message'] = err.message;
    })
    .finally(_=>self.postMessage(response))
})