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

    // untuk fetch select option
    try{
        const worker = new Worker('/assets/js/worker.js');
        let continentId,countryId,stateId;

        function getMoreData(url,dataType){
            let key = url.substr(url.indexOf('collections/'));
            let etag = sessionStorage.getItem(key)||'';
            worker.postMessage({
                url:url,
                dataType:dataType,
                headers:{
                    "If-None-Match":etag
                }
            });
        }

        function firstInit()
        {
            let search = new URLSearchParams(location.search);
            const workerInit = new Worker('/assets/js/worker.js');

            continentId = search.get(`filter[continentId]`);
            countryId   = search.get(`filter[countryId]`);
            stateId     = search.get(`filter[stateId]`);

            workerInit.postMessage

            if(continentId){
                let url = `/collection/countries?continentId=${continentId}`;
                getMoreData(url);
            }

        }
        document.querySelector(`select[name="filter[continentId]"]`).dispatchEvent(new Event('change'));

        document.querySelector(`select[name="filter[continentId]"]`)
        .addEventListener('change',function(){
            if(continentId!==this.value){
                continentId = this.value;

                // hapus semua data opsi pada stateId karena berbeda continent
                document.querySelectorAll(`select[name="filter[countryId]"] option[value]`).forEach(elem=>elem.remove());
                document.querySelector(`select[name="filter[countryId]"] option`).selected = true;
                document.querySelectorAll(`select[name="filter[stateId]"] option[value]`).forEach(elem=>elem.remove());
                document.querySelector(`select[name="filter[stateId]"] option`).selected = true;
                document.querySelector(`select[name="filter[countryId]"]`).disabled = true;
                document.querySelector(`select[name="filter[stateId]"]`).disabled = true;
                
                let url = `/collections/countries?filter[continents.id]=${continentId}`;
                getMoreData(url,'countries');
            }
        })

        document.querySelector(`select[name="filter[countryId]"]`)
        .addEventListener('change',function(){
            if(countryId!==this.value){
                countryId = this.value;

                document.querySelectorAll(`select[name="filter[stateId]"] option[value]`).forEach(elem=>elem.remove())
                document.querySelector(`select[name="filter[stateId]"] option`).selected = true;
                document.querySelector(`select[name="filter[stateId]"]`).disabled = true;

                let url = `/collections/states?filter[countries.id]=${countryId}`;
                getMoreData(url,'states');
            }
        })

        worker.addEventListener('message', message=>{
            let data = message.data;
            let body,etag,url=data.url,dataType=data.dataType;
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
            if(typeof body!=='undefined'){
                switch(dataType){
                    case 'countries':
                        document.querySelector(`select[name="filter[countryId]"]`).insertAdjacentHTML('beforeend',body.view);
                        document.querySelector(`select[name="filter[countryId]"]`).disabled = false;
                        break;
                    case 'states':
                        document.querySelector(`select[name="filter[stateId]"]`).insertAdjacentHTML('beforeend',body.view);
                        document.querySelector(`select[name="filter[stateId]"]`).disabled = false;
                        break;
                }
            }
        })

    }catch(error){
        console.log(error.message)
    }
})();
