(function(){
    const forms = document.querySelectorAll(`form.needs-validation`);

    forms.forEach(form=>{
        form.addEventListener('submit',function(event){
            if(!form.checkValidity()){
                event.stopPropagation();
                event.preventDefault();
            }
            form.classList.add('was-validated')
        },false);
    })

    if(document.querySelector(`select[name="filter[stateId]"]`)){
        const worker = new Worker('/assets/js/worker.js');
        let url = "/collections/states?page=2";

        getMoreCities(url);

        worker.addEventListener('message', message=>{
            let data = message.data;
            let body,etag,url=data.url;
            let key = url.substr(url.indexOf('collections/'));

            if(data.statusCode===304){
                etag = sessionStorage.getItem(key);
                body = JSON.parse(sessionStorage.getItem(etag));
            }else if(data.statusCode===200){
                etag = data.etag;
                body = data.body;

                sessionStorage.setItem(key,etag);
                sessionStorage.setItem(etag,JSON.stringify(body));
            }
            document.querySelector(`select[name="filter[stateId]"]`).insertAdjacentHTML('beforeend',body.view);
            if(body.nextPageUrl) getMoreCities(body.nextPageUrl);
        })


        function getMoreCities(url){
            let key = url.substr(url.indexOf('collections/'));
            let etag = sessionStorage.getItem(key)||'';
            worker.postMessage({
                url:url,
                headers:{
                    "If-None-Match":etag
                }
            });
        }
    }
})();
